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
    SELECT patientReports.reportID, patientReports.reportTitle, patientReports.reportFileDestination
    FROM patientReports
    JOIN patient ON patientReports.nic = patient.nic
    WHERE patient.email = '$email'
";

// Execute the query
$result = $conn->query($sql);

// Check if there are results
if ($result && $result->num_rows > 0) {
    // Display reports in a table
    echo '<table border="1" cellpadding="10" cellspacing="0">';
    echo '<tr>';
    echo '<th>Report ID</th>';
    echo '<th>Report Title</th>';
    echo '<th>Action</th>';
    echo '</tr>';

    // Loop through the results and add them to the table
    while ($row = $result->fetch_assoc()) {
        
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['reportID']) . '</td>';
        echo '<td>' . htmlspecialchars($row['reportTitle']) . '</td>';
        echo '<td><a href="loadfile.php?reportID=' . urlencode($row['reportID']) . '" class="view-btn">View</a></td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo 'No reports found.';
}

// Close the database connection
$conn->close();
?>

    </div>
    <script>
function openFileInNewTab(filePath) {
    // Open the file in a new tab
    window.open(filePath, '_blank');
}
</script>

</body>
</html>
