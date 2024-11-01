<?php
include '../dbConnection.php'; 


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
    <link rel="stylesheet" href="../Assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="sideMenu">
        <div class="profile">
            <img src="<?php echo htmlspecialchars($profileLocation); ?>" alt="Profile Picture">
            <p><?php echo htmlspecialchars($name); ?></p>
            <a href="editProfile.php"><span class="fa fa-pencil" aria-hidden="true"></span></a>
        </div>
        <div class="navigation">
            <ul class="nav-links">
                <li><a href="makeAppoinment.php">Make Appointment</a></li>
                <li><a href="viewAppoinment.php">View Appointment</a></li>
                <li><a href="myReports.php">My Reports</a></li>
                <li><a href="addReport.php">Add Report</a></li>
                <li><a href="myprofile.php">My profile</a></li>
                <li><a href="../login.php"><span class="fa fa-sign-out" aria-hidden="true"></span> Log Out</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
