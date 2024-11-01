<?php
session_start();
include '../dbConnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $announcementID = $_POST['announcementID'];

    // Validate input
    if (empty($announcementID)) {
        echo "<script>alert('No announcement selected.');</script>";
        exit();
    }

    // Prepare SQL query to delete the selected announcement
    $query = "DELETE FROM announcements WHERE announceID = ?";

    // Prepare the statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "<script>alert('Error preparing statement: " . addslashes($conn->error) . "');</script>";
        exit();
    }

    // Bind the parameter
    $stmt->bind_param("i", $announcementID);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
        alert('Announcement deleted successfully.');
        window.location.href = 'dashboard.php'; // Redirect to a page of your choice
        </script>";
    } else {
        echo "<script>alert('Error deleting announcement: " . addslashes($stmt->error) . "');</script>";
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>
