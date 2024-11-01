<?php
include '../dbConnection.php'; 

// Retrieve reportID from the URL and validate it
$reportID = $_GET['reportID'] ?? null;

// Check if reportID is valid
if (!$reportID || !is_numeric($reportID)) {
    echo "Invalid report ID.";
    exit;
}

// Prepare the SQL statement to prevent SQL injection
$sql = $conn->prepare("SELECT reportFileDestination FROM patientReports WHERE reportID = ?");
if (!$sql) {
    // Check if the statement preparation failed
    die("Preparation failed: " . $conn->error);
}

// Bind the reportID parameter as an integer
if (!$sql->bind_param("i", $reportID)) {
    // Check if parameter binding failed
    die("Binding parameters failed: " . $sql->error);
}

// Execute the prepared statement
if (!$sql->execute()) {
    // Check if execution failed
    die("Execution failed: " . $sql->error);
}

// Get the result set from the executed statement
$result = $sql->get_result();

// Initialize the variable to store reportFileDestination
$reportFileDestination = '';

// Check if the query returned a result
if ($result && $result->num_rows > 0) {
    // Fetch the row
    $row = $result->fetch_assoc();
    $filePath =$row['reportFileDestination'];
    
    // Check if the file exists
    if (file_exists($filePath)) {
        // Set headers to prompt download
        // Set headers to display the file in the browser
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf'); // Change this to the appropriate MIME type for your file (e.g., application/pdf for PDFs, image/jpeg for JPEG images)
        header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        // Clear output buffer before reading the file
        ob_clean();
        flush();

        // Read the file and send it to the output buffer
        readfile($filePath);
        // Exit to stop any further script execution
        header('Location: myReports.php');
        exit;
    } else {
        echo "The file does not exist.";
    }
} else {
    echo "No report found for the given report ID.";
}

// Close the statement and connection
$sql->close();
$conn->close();
?>
