<?php
include '../dbConnection.php'; 

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve email from session
$email = $_SESSION['username'];
$conn->close();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../Assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'adminmenu.php'?>
    <div class="makeAppoinment">
        <?php
            // Include the database connection file
            include '../dbConnection.php'; 

            $sql = "SELECT appointment.appointmentID, appointment.date, appointment.time, doctor.name 
                FROM appointment 
                JOIN doctor ON appointment.docID = doctor.docID";

            $result = $conn->query($sql);

            // Check if there are results
            if ($result->num_rows > 0) {
                echo '<table border="1" cellpadding="10" cellspacing="0">';
                echo '<tr>';
                echo '<th>Appointment ID</th>';
                echo '<th>Date</th>';
                echo '<th>Time</th>';
                echo '<th>Doctor Name</th>';
                echo '</tr>';

                // Loop through the results and add them to the table
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['appointmentID']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['date']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['time']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td><a href="../Patient/cancelAppointment.php?appointmentID=' . urlencode($row['appointmentID']) . '" class="cancel">Cancel</a></td>';
                echo '</tr>';
                }

                echo '</table>';
            } else {
                echo 'No appointments found.';
            }

            // Close the database connection
            $conn->close();
        ?>
    </div>
</body>
</html>

<?php