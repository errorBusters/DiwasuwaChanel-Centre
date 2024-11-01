
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
        <form action="timeSlot.php" method="POST" enctype="multipart/form-data">
        <label for="time">Time:</label>
        <input type="time" id="time" name="time" required>
        <button type="submit">ADD</button>
        </form>
    </div>
</body>
</html>
<?php
session_start(); // Start the session if needed
include '../dbConnection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $timeSlot = $_POST['time'];

    // Validate input
    if (empty($timeSlot)) {
        echo "<script>alert('Please select a time slot.');</script>";
        exit();
    }

    // Prepare SQL query to insert data into TimeSlots table
    $query = "
        INSERT INTO TimeSlots (timeSlot, availability) 
        VALUES (?, 'available')
    ";

    // Prepare the statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "<script>alert('Error preparing statement: " . addslashes($conn->error) . "');</script>";
        exit();
    }

    // Bind the timeSlot parameter to the query
    $stmt->bind_param("s", $timeSlot);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
        alert('Time slot added successfully.');
        </script>";
    } else {
        echo "<script>alert('Error adding time slot: " . addslashes($stmt->error) . "');</script>";
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>
