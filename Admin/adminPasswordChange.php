
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
        <form action="adminPasswordChange.php" method="POST" enctype="multipart/form-data">
        <input type="password" id="psswd" name="psswd" required placeholder="New Password">
        <input type="password" id="confirmpsswd" name="confirmpsswd" required placeholder="Confirm Password">
        <button type="submit">Change Password</button>
        </form>
    </div>
</body>
</html>

<?php
session_start(); 
include '../dbConnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $password = $_POST['psswd'];
    $confirmPassword = $_POST['confirmpsswd'];

    // Validate input
    if (empty($password) || empty($confirmPassword)) {
        echo "<script>alert('Both password fields are required.');</script>";
        exit();
    }

    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.');</script>";
        exit();
    }

    // Hash the new password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query to update passwordHash in the login table
    $query = "
        UPDATE admin 
        SET passwordHash = ? 
        WHERE username = 'admin1'
    ";

    // Prepare the statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "<script>alert('Error preparing statement: " . addslashes($conn->error) . "');</script>";
        exit();
    }

    // Bind the new password hash parameter
    $stmt->bind_param("s", $passwordHash);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
        alert('Password changed successfully.');
        </script>";
    } else {
        echo "<script>alert('Error changing password: " . addslashes($stmt->error) . "');</script>";
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>
