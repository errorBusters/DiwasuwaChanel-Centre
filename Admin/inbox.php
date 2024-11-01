<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../Assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'adminmenu.php'; ?>
    <div class="makeAppoinment">
    <?php
include '../dbConnection.php'; 

// Query to get email and message from the message table
$query = "SELECT email, message FROM message";
$result = $conn->query($query);

// Check if there are results
if ($result->num_rows > 0) {
    echo '<table border="1" cellpadding="10" cellspacing="0">';
    echo '<tr>';
    echo '<th>Email</th>';
    echo '<th>Message</th>';
    echo '</tr>';

    // Loop through the results and add them to the table
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . htmlspecialchars($row['message']) . '</td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo 'No messages found.';
}

// Close the connection
$conn->close();
?>

    </div>
</body>
</html>