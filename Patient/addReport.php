<?php
include '../dbConnection.php'; 

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Retrieve email from session
$email = $_SESSION['email'];

// Check if the connection is open
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="../Assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'patientmenu.php'; ?>
    <div class="makeAppoinment">
        <h2>Upload Report Here</h2>
        <form action="addReport.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="fName" placeholder="Report Title" required>
            <label for="profileImg">Upload Report</label>
            <input type="file" id="profileImg" name="profileImg" required>
            <button type="submit">Add Report <span class="fa fa-plus" aria-hidden="true"></span></button>
        </form>
    </div>
</body>
</html>
<?php
include '../dbConnection.php'; 

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Retrieve email from session
$email = $_SESSION['email'];

// Check if the connection is open
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form inputs
    $title = $_POST['fName'];
    $profileImg = $_FILES['profileImg'];

    // Handle profile image upload
    $profilePhotoPath = null;
    if ($profileImg['size'] > 0) {
        $targetDir = "../Assets/docs/";
        $fileType = strtolower(pathinfo($profileImg['name'], PATHINFO_EXTENSION));
        $allowedTypes = ['pdf', 'doc', 'docx'];

        // Check if the file is an acceptable type
        if (!in_array($fileType, $allowedTypes)) {
            echo "Invalid file type.";
            exit;
        }

        // Create a new filename in the format: $email_$title.extension
        $newFileName = $email . '_' . $title . '.' . $fileType;
        $profilePhotoPath = $targetDir . $newFileName;

        // Move the file to the target directory
        if (!move_uploaded_file($profileImg['tmp_name'], $profilePhotoPath)) {
            echo "Error uploading report.";
            exit;
        }
    }


    // Retrieve NIC
    $sql = "SELECT nic FROM patient WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . htmlspecialchars($conn->error));
    }
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($nic);
    if ($stmt->fetch()) {
        $patientNIC = $nic;
    } else {
        echo "<p>No NIC found for this email.</p>";
        $patientNIC = null; // or handle accordingly
    }
    $stmt->close();
    
    // Insert report details into the database
    $sql = "INSERT INTO patientReports (reportTitle, reportFileDestination, nic) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("sss", $title, $profilePhotoPath, $patientNIC);
    if (!$stmt->execute()) {
        echo "Error inserting report details: " . htmlspecialchars($stmt->error);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
