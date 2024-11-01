<?php
include '../dbConnection.php'; 
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Retrieve email from session
$email = $_SESSION['email'];

// Prepare and execute the SQL query
$sql = "SELECT profilePhoto, firstName, lastName FROM patient WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);

try {
    $stmt->execute();
    // Bind result variables
    $stmt->bind_result($profilePhoto, $firstName, $lastName);
    
    if ($stmt->fetch()) {
        $name = $firstName . " " . $lastName;
        $profileLocation = "../Assets/images/profiles/" . $profilePhoto;
    } else {
        echo "<script>alert('You have not uploaded a profile picture');</script>";
        $profileLocation = "../Assets/images/userprofile.png";
        $firstName = "Unknown";
        $lastName = "User";
        $name = $firstName . " " . $lastName;
    }
    
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    echo "<script>alert('Error preparing statement: " . addslashes($e->getMessage()) . "');</script>";
}

$conn->close();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="../Assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'patientmenu.php'?>
    <div class="makeAppoinment">
        <form action="makeAppoinment.php" method="POST" enctype="multipart/form-data">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        <?php
            include '../dbConnection.php';
            $sql = "SELECT slotID, timeSlot, availability FROM TimeSlots";
            $result = $conn->query($sql);
            
            // Check if there are results
            if ($result->num_rows > 0) {
                echo '<form action="/submit" method="post">';
                echo '<p>Select your preferred time slot:</p>';
                
                // Loop through the results and generate radio buttons
                while($row = $result->fetch_assoc()) {
                    $slotID = $row['slotID'];
                    $timeSlot = $row['timeSlot'];
                    $availability = $row['availability'];
                    
                    // Determine if radio button should be disabled
                    $disabled = ($availability === 'unavailable') ? 'disabled' : '';
                    
                    echo '<label>';
                    echo '<input type="radio" name="timeSlot" value="' . htmlspecialchars($slotID) . '" ' . $disabled . '>';
                    echo htmlspecialchars($timeSlot);
                    echo '</label><br>';
                }
            }else{
                echo 'No TimeSlots found';
            }
        ?>
        <button type="submit">Make Appoinment</button>
        </form>
    </div>
</body>
</html>

<?php

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the date and selected time slot from the form
    $date = $_POST['date'];
    $timeSlotID = $_POST['timeSlot'];

    // Define the status, docID, and username manually for this case
    $status = 'booked';
    $docID = 1;
    $username = 'admin1';

    // Assuming email is stored in the session
    $email = $_SESSION['email']; // Set this properly in your login script

    // Fetch the patient's NIC based on the email
    $nicQuery = "SELECT nic FROM patient WHERE email = ?";
    $stmt = $conn->prepare($nicQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $nicResult = $stmt->get_result();

    if ($nicResult->num_rows > 0) {
        $nicRow = $nicResult->fetch_assoc();
        $nic = $nicRow['nic'];

        // Fetch the time slot value based on the selected slotID
        $timeSlotQuery = "SELECT timeSlot FROM TimeSlots WHERE slotID = ?";
        $stmtTimeSlot = $conn->prepare($timeSlotQuery);
        $stmtTimeSlot->bind_param("i", $timeSlotID);
        $stmtTimeSlot->execute();
        $timeSlotResult = $stmtTimeSlot->get_result();

        if ($timeSlotResult->num_rows > 0) {
            $timeSlotRow = $timeSlotResult->fetch_assoc();
            $time = $timeSlotRow['timeSlot'];

            // Insert data into the appointment table
            $insertQuery = "INSERT INTO appointment (date, time, status, username, nic, docID) 
                            VALUES (?, ?, ?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($insertQuery);
            $stmtInsert->bind_param("sssssi", $date, $time, $status, $username, $nic, $docID);

            if ($stmtInsert->execute()) {
                echo "<script>alert('Appointment successfully booked!');</script>";
            } else {
                echo "<script>alert('Error: " . addslashes($stmtInsert->error) . "');</script>";
            }

            // Close the insert statement
            $stmtInsert->close();
        } else {
            echo "<script>alert('Selected time slot not found.');</script>";
        }

        // Close the time slot statement
        $stmtTimeSlot->close();
    } else {
        echo "<script>alert('Patient not found');</script>";
    }

    // Close the NIC statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
