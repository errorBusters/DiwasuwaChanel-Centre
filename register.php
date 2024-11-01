<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="Assets/css/loginstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'header.html'; ?>
    <div class="formContent">
        <div class="loginForm">
            <form action="register.php" method="POST" enctype="multipart/form-data">
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
                <button type="submit">Register <span class="fa fa-sign-in" aria-hidden="true"></span></button>
            </form>
            <a href="login.php">Already have an account? Login Here</a>
        </div>
    </div>
</body>
</html>

<?php
include 'dbConnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $nic = $_POST['nic'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['addr'];
    $password = $_POST['psswd'];
    $confirmPassword = $_POST['confirmPsswd'];

    // Validate password match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match. Try again.');</script>";
        exit();
    }

    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Handle file upload
    $profilePhoto = null;
    if (isset($_FILES['profileImg']) && $_FILES['profileImg']['error'] == 0) {
        $target_dir = "Assets/images/profiles/";
        $target_file = $target_dir . basename($_FILES["profileImg"]["name"]);
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["profileImg"]["tmp_name"], $target_file)) {
            $profilePhoto = basename($_FILES["profileImg"]["name"]);
        } else {
            echo "<script>alert('Error uploading file.');</script>";
            exit();
        }
    }

    // Insert into login table
    $loginQuery = "INSERT INTO login (passwordHash) VALUES (?)";
    $stmt = $conn->prepare($loginQuery);
    if (!$stmt) {
        echo "<script>alert('Error preparing login statement: " . addslashes($conn->error) . "');</script>";
        exit();
    }
    $stmt->bind_param("s", $passwordHash);

    if ($stmt->execute()) {
        $loginID = $stmt->insert_id; // Get the inserted loginID

        // Insert into patient table
        $patientQuery = "INSERT INTO patient (nic, firstName, lastName, email, phone, address, profilePhoto, loginID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($patientQuery);
        if (!$stmt) {
            echo "<script>alert('Error preparing patient statement: " . addslashes($conn->error) . "');</script>";
            exit();
        }
        $stmt->bind_param("sssssssi", $nic, $firstName, $lastName, $email, $phone, $address, $profilePhoto, $loginID);

        if ($stmt->execute()) {
            header("Location: login.php");
            echo "<script>alert('Registration successful!');</script>";
        } else {
            echo "<script>alert('Error: " . addslashes($stmt->error) . "');</script>";
        }
    } else {
        echo "<script>alert('Error: " . addslashes($stmt->error) . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
