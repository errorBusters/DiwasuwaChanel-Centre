
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
        <form action="payment.php" method="POST" enctype="multipart/form-data">
        <input type="text" id="appoinmetID" name="appoinmetID" required placeholder="Appoinmet ID">
        <input type="text" id="amount" name="amount" required placeholder="Amount">
        <button type="submit">Pay</button>
        </form>
    </div>
</body>
</html>


<?php
session_start(); 
include '../dbConnection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $appointmentID = $_POST['appoinmetID'];
    $amount = $_POST['amount'];
    $username = 'admin1'; 

    // Validate input
    if (empty($appointmentID) || empty($amount)) {
        echo "<script>alert('All fields are required.');</script>";
        exit();
    }

    if (!is_numeric($amount) || $amount <= 0) {
        echo "<script>alert('Invalid amount.');</script>";
        exit();
    }

    // Get current date and time
    $dateTime = date('Y-m-d H:i:s');

    // Prepare SQL query to insert payment record
    $query = "
        INSERT INTO payment (dateTime, amount, appointmentID, username) 
        VALUES (?, ?, ?, ?)
    ";

    // Prepare the statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "<script>alert('Error preparing statement: " . addslashes($conn->error) . "');</script>";
        exit();
    }

    // Bind the parameters
    $stmt->bind_param("sdis", $dateTime, $amount, $appointmentID, $username);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
        alert('Payment recorded successfully.');
        </script>";
    } else {
        echo "<script>alert('Error recording payment: " . addslashes($stmt->error) . "');</script>";
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>

