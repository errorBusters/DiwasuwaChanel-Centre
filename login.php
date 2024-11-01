<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="Assets/css/loginstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'header.html'; ?>
    <div class="formContent">
        <div class="loginForm">
            <form action="login.php" method="POST" enctype="multipart/form-data">
                <input type="email" name="email" placeholder="Email ID" required>
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
include 'dbConnection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['psswd'];

    // Query to get loginID and passwordHash based on email
    $query = "
        SELECT login.passwordHash
        FROM patient
        INNER JOIN login ON patient.loginID = login.loginID
        WHERE patient.email = ?
    ";
    
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "<script>alert('Error preparing statement: " . addslashes($conn->error) . "');</script>";
        exit();
    }
    
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($passwordHash);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $passwordHash)) {
            // Password is correct
            $_SESSION['email'] = $email;
            echo "<script></script>";
            echo "<script>
            alert('Login Successfull');
            window.location.href = 'Patient/dashboard.php';
            </script>";
            exit();
        } else {
            // Password is incorrect
            echo "<script>alert('Invalid credentials.');</script>";
        }
    } else {
        // No user found with the given email
        echo "<script>alert('No user found with that email.');</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>
