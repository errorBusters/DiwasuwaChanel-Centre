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
        <!-- Form to publish an announcement -->
        <form action="dashboard.php" method="POST" enctype="multipart/form-data">
            <textarea name="announcement" placeholder="Announcement" required></textarea>
            <button type="submit" name="publish">Publish</button>
        </form>

        <!-- Form to delete an announcement -->
        <form action="dashboard.php" method="POST">
            <?php
            include '../dbConnection.php'; 

            // Query to get announceID and announcement from the announcements table
            $query = "SELECT announceID, announcement FROM announcements";
            $result = $conn->query($query);

            // Check if there are results
            if ($result->num_rows > 0) {
                echo '<select name="announcementID" id="announcementID">';
                echo '<option value="">Select an Announcement</option>'; 

                // Loop through the results and generate option elements
                while ($row = $result->fetch_assoc()) {
                    $announceID = htmlspecialchars($row['announceID']);
                    $announcement = htmlspecialchars($row['announcement']);
                    echo '<option value="' . $announceID . '">' . $announcement . '</option>';
                }

                echo '</select>';
            } else {
                echo '<select name="announcementID" id="announcementID">';
                echo '<option value="">No Announcements Available</option>';
                echo '</select>';
            }

            // Close the connection
            $conn->close();
            ?>
            <button type="submit" name="delete">Delete</button>
        </form>
    </div>
</body>
</html>

<?php
session_start(); 
include '../dbConnection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['publish'])) {
        // Handle announcement publishing
        $announcement = $_POST['announcement'];

        // Validate input
        if (empty($announcement)) {
            echo "<script>alert('Announcement cannot be empty.');</script>";
            exit();
        }

        // Prepare SQL query to insert announcement
        $query = "INSERT INTO announcements (announcement) VALUES (?)";

        // Prepare the statement
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo "<script>alert('Error preparing statement: " . addslashes($conn->error) . "');</script>";
            exit();
        }

        // Bind the parameter
        $stmt->bind_param("s", $announcement);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>
            alert('Announcement published successfully.');
            </script>";
        } else {
            echo "<script>alert('Error publishing announcement: " . addslashes($stmt->error) . "');</script>";
        }

        // Close the statement
        $stmt->close();
    }

    if (isset($_POST['delete'])) {
        // Handle announcement deletion
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
            </script>";
        } else {
            echo "<script>alert('Error deleting announcement: " . addslashes($stmt->error) . "');</script>";
        }

        // Close the statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}
?>
