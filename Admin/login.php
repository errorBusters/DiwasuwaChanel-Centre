<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../Assets/css/loginstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'header.html'; ?>
    <div class="formContent">
        <div class="loginForm">
            <form action="login.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="userName" placeholder="User Name" required>
                <input type="password" name="psswd" placeholder="Password" required>
                <button type="submit">Login<span class="fa fa-sign-in" aria-hidden="true"></span></button>
            </form>
            <a href="register.php">Do not have an account? Sign Up Here</a>
        </div>
    </div>
</body>
</html>


<?php
session_start(); // Start the session
include '../dbConnection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['userName'];
    $password = $_POST['psswd'];

    // Query to get the passwordHash based on the username from the admin table
    $query = "
        SELECT passwordHash 
        FROM admin 
        WHERE username = ?
    ";

    // Prepare the statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "<script>alert('Error preparing statement: " . addslashes($conn->error) . "');</script>";
        exit();
    }

    // Bind the username parameter to the query
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($passwordHash);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $passwordHash)) {
            // Password is correct, set session and redirect
            $_SESSION['username'] = $username;
            echo "<script>
            alert('Login Successful');
            window.location.href = 'dashboard.php';
            </script>";
            exit();
        } else {
            // Password is incorrect
            echo "<script>alert('Invalid credentials.');</script>";
        }
    } else {
        // No user found with the given username
        echo "<script>alert('No user found with that username.');</script>";
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>
