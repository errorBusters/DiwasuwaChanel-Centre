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
    <?php
// Include the database connection file
include '../dbConnection.php'; 

// Prepare the SQL query to retrieve patient reports
$sql = "
    SELECT profilePhoto, firstName, lastName, nic, email, phone, address
        FROM patient
        WHERE email = '$email'
";

// Execute the query
$result = $conn->query($sql);

// Check if there are results
if ($result && $result->num_rows > 0) {
    // Display reports in a table
    $row = $result->fetch_assoc();
    $profileLocation = "../Assets/images/profiles/" . htmlspecialchars($profilePhoto);
        echo '<img src="' . htmlspecialchars($profileLocation) . '" alt="Profile Photo" style="width:100px;height:100px;">';
        echo '<p>First Name: ' . htmlspecialchars($row['firstName']) . '</p>';
        echo '<p>Last Name: ' . htmlspecialchars($row['lastName']) . '</p>';
        echo '<p>NIC: ' . htmlspecialchars($row['nic']) . '</p>';
        echo '<p>Email: ' . htmlspecialchars($row['email']) . '</p>';
        echo '<p>Phone: ' . htmlspecialchars($row['phone']) . '</p>';
        echo '<p>Address: ' . htmlspecialchars($row['address']) . '</p>';
} else {
    echo 'No Details found.';
}

// Close the database connection
$conn->close();
?>

    </div>
</body>
</html>
