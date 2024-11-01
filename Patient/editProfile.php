<?php
include '../dbConnection.php'; 

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Retrieve email from session
$email = $_SESSION['email'];

// Prepare and execute the SQL query
$sql = "SELECT profilePhoto, firstName, lastName FROM patient WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);

try {
    $stmt->execute();
    // Bind result variables
    $stmt->bind_result($profilePhoto, $firstName, $lastName);
    
    if ($stmt->fetch()) {
        $name = $firstName . " " . $lastName;
        $profileLocation = "../Assets/images/profiles/" . $profilePhoto;
    } else {
        echo "<script>alert('You have not uploaded a profile picture');</script>";
        $profileLocation = "../Assets/images/userprofile.png";
        $firstName = "Unknown";
        $lastName = "User";
        $name = $firstName . " " . $lastName;
    }
    
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    echo "<script>alert('Error preparing statement: " . addslashes($e->getMessage()) . "');</script>";
}

$conn->close();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="../Assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'patientmenu.php'?>
    <div class="makeAppoinment">
        <h2>Change details here</h2>
    <form action="editProfile.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="fName" placeholder="First Name" required>
            <input type="text" name="lName" placeholder="Last Name" required>
            <input type="text" name="nic" placeholder="NIC" required>
            <input type="email" name="email" placeholder="Email ID" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <textarea name="addr" placeholder="Address" required></textarea>
            <label for="profileImg">Profile Picture</label>
            <input type="file" id="profileImg" name="profileImg" accept="image/*">                
            <input type="password" name="psswd" placeholder="Create a Password" required>
            <input type="password" name="confirmPsswd" placeholder="Confirm Password" required>
            <button type="submit">Apply Changes <span class="fa fa-wrench" aria-hidden="true"></span></button>
        </form>
    </div>
</body>
</html>

<?php
// Include the database connection file
include '../dbConnection.php'; 



// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form inputs
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $nic = $_POST['nic'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $addr = $_POST['addr'];
    $psswd = $_POST['psswd'];
    $confirmPsswd = $_POST['confirmPsswd'];
    $profileImg = $_FILES['profileImg'];

    // Check if the passwords match
    if ($psswd !== $confirmPsswd) {
        echo "Passwords do not match!";
        exit;
    }

    // Hash the password securely
    $passwordHash = password_hash($psswd, PASSWORD_BCRYPT);

    // Handle profile image upload
    $profilePhotoPath = null;
    if ($profileImg['size'] > 0) {
        $targetDir = "../Assets/images/profiles/"; 
        $profilePhotoPath = $targetDir . basename($profileImg['name']);
        // Check if the file is an image and move it to the target directory
        if (!move_uploaded_file($profileImg['tmp_name'], $profilePhotoPath)) {
            echo "Error uploading profile picture.";
            exit;
        }
    }

    // Update patient details in the database
    $sql = "UPDATE patient 
            SET firstName = ?, lastName = ?, nic = ?, phone = ?, address = ?, 
                profilePhoto = IFNULL(?, profilePhoto) 
            WHERE email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $fName, $lName, $nic, $phone, $addr, $profilePhotoPath, $email);

    // Execute the update statement
    if ($stmt->execute()) {
        // Optional: Update the password in the login table if required
        $loginUpdate = "UPDATE login 
                        SET passwordHash = ? 
                        WHERE loginID = (SELECT loginID FROM patient WHERE email = ?)";
        $stmtLogin = $conn->prepare($loginUpdate);
        $stmtLogin->bind_param("ss", $passwordHash, $email);

        if ($stmtLogin->execute()) {
            echo "<script>alert('Profile updated successfully!')</script>";
        } else {
            echo "Error updating password: " . $stmtLogin->error;
        }

        $stmtLogin->close();
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
