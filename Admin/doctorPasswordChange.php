
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
        <form action="doctorPasswordChange.php" method="POST" enctype="multipart/form-data">
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

    // Start transaction to ensure atomic operations
    $conn->begin_transaction();

    try {
        // Insert new login record
        $insertLoginQuery = "
            INSERT INTO login (passwordHash) 
            VALUES (?)
        ";
        $stmt = $conn->prepare($insertLoginQuery);
        if (!$stmt) {
            throw new Exception('Error preparing insert statement: ' . $conn->error);
        }
        $stmt->bind_param("s", $passwordHash);
        $stmt->execute();
        $newLoginID = $stmt->insert_id; 
        $stmt->close();

        // Update doctor table with new loginID
        $updateDoctorQuery = "
            UPDATE doctor 
            SET loginID = ? 
            WHERE docID = ?  -- Adjust this as needed to specify which doctor
        ";
        $stmt = $conn->prepare($updateDoctorQuery);
        if (!$stmt) {
            throw new Exception('Error preparing update statement: ' . $conn->error);
        }
        $stmt->bind_param("ii", $newLoginID, $docID);
        $stmt->execute();
        $stmt->close();

        // Commit the transaction
        $conn->commit();

        echo "<script>
        alert('Password changed successfully.');
        </script>";
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();
        echo "<script>alert('Error changing password: " . addslashes($e->getMessage()) . "');</script>";
    }

    // Close the connection
    $conn->close();
}
?>
