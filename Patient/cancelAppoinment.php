<?php
session_start(); // Start the session
include '../dbConnection.php'; 

// Check if appointmentID is set in the query string
if (isset($_GET['appointmentID'])) {
    $appointmentID = $_GET['appointmentID'];

    // Prepare SQL statement to delete the appointment
    $query = "DELETE FROM appointment WHERE appointmentID = ?";

    // Prepare and execute the statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "<script>alert('Error preparing statement: " . addslashes($conn->error) . "');</script>";
        exit();
    }

    $stmt->bind_param("i", $appointmentID); 
    if ($stmt->execute()) {
        echo "<script>
        alert('Appointment cancelled successfully.');
        window.location.href = 'your-appointments-page.php'; // Redirect to the appointments page or desired location
        </script>";
    } else {
        echo "<script>alert('Error cancelling appointment: " . addslashes($stmt->error) . "');</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('No appointment ID specified.');</script>";
}
?>
