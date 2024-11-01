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
    
</body>
</html>