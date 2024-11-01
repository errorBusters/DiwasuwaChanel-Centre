<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="../Assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'doctormenu.php'?>
    <div class="makeAppoinment">
    <?php
// Include the database connection file
include '../dbConnection.php'; 

// SQL query to select appointment details along with patient and payment information
$sql = "SELECT appointment.appointmentID, appointment.date, appointment.time, 
               patient.firstName, patient.lastName, payment.payID, payment.amount
        FROM appointment
        JOIN patient ON appointment.nic = patient.nic
        JOIN payment ON payment.appointmentID = appointment.appointmentID";

$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    echo '<table border="1" cellpadding="10" cellspacing="0">';
    echo '<tr>';
    echo '<th>Appointment ID</th>';
    echo '<th>Date</th>';
    echo '<th>Time</th>';
    echo '<th>Patient First Name</th>';
    echo '<th>Patient Last Name</th>';
    echo '<th>Payment ID</th>';
    echo '<th>Amount</th>';
    echo '</tr>';

    // Loop through the results and add them to the table
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['appointmentID']) . '</td>';
        echo '<td>' . htmlspecialchars($row['date']) . '</td>';
        echo '<td>' . htmlspecialchars($row['time']) . '</td>';
        echo '<td>' . htmlspecialchars($row['firstName']) . '</td>';
        echo '<td>' . htmlspecialchars($row['lastName']) . '</td>';
        echo '<td>' . htmlspecialchars($row['payID']) . '</td>';
        echo '<td>' . htmlspecialchars($row['amount']) . '</td>';
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