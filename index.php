<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrimeCare Medical Center</title>
    <link rel="stylesheet" href="Assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'header.html'?>
    <section class="home" id="home">
        <img src="Assets/images/BG.jpeg" alt="bg image">
        <h2>WELCOME <br><br><br><br></h2>
        <h2>DIWASUWA MEDICAL CENTER</h2>
        <h3>Your Health, Our Priority.</h3>
    </section>
    <section class="aboutUs" id="aboutUs">
        <img src="Assets/images/img1.jpg" alt="">
        <div class="aboutText">
            <h4>About Us</h4>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Illum commodi placeat accusamus et aliquam asperiores quasi soluta inventore reprehenderit ut deleniti laboriosam quas nemo, unde perspiciatis quis corporis cum dolor!</p>
        </div>
    </section>
    <section class="aboutDoctor">
        <img src="Assets/images/doctor.jpg" alt="">
        <div class="docText">
        <h4>Dr. Stephen  Strange</h4>
        <p class="mbbs">MBBS University of Colombo</p>
        <p>Speciality : Nerologist</p>
        <p>Phone : 012301204</p>
        <p>Email : strange@diwasuwa.lk</p>
        <div class="doctorLinks">
            <a href="#"><span class="fab fa-facebook" aria-hidden="true"></span></a>
            <a href="#"><span class="fab fa-instagram" aria-hidden="true"></span></a>
            <a href="#"><span class="fab fa-linkedin" aria-hidden="true"></span></a>
        </div>
        </div>
    </section>
    <section class="services" id="services">
        <div>
        <h4>Services</h4>
        </div>
        <div class="serviceCards">
            <div class="Scard">
                <img src="Assets/images/3.png" alt="">
                <h5>Pharmacy</h5>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem quae ullam aliquid eveniet rerum! Rerum iste expedita numquam eum optio vel hic ratione? Nesciunt ipsa perferendis sunt ipsum, consectetur saepe.</p>
            </div>
            <div class="Scard">
                <img src="Assets/images/1.png" alt="">
                <h5>Laborotary</h5>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ut in ab, eveniet deserunt magni maiores excepturi sequi, saepe soluta aspernatur repellendus perferendis dolorum harum eligendi, nesciunt placeat quaerat ipsa. Non.</p>
            </div>
            <div class="Scard">
                <img src="Assets/images/2.png" alt="">
                <h5>Medicine</h5>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque, quasi in doloribus, aspernatur, ea modi culpa voluptas eaque repudiandae labore laboriosam. Vitae totam cum inventore hic pariatur id explicabo impedit!</p>
            </div>
        </div>
    </section>
    <section class="joinUs">
        <h4>Login To Make an Appoinment</h4>
        <p>Be a member and get easy for booking appoinments.</p>
        <a href="login.php">Login</a>
    </section>
    <section class="contactUs" id="contactUs">
        <h4>Contact Us</h4>
        <div class="contact">
            <div class="contactForm">
                <form action="index.php">
                    <input type="text" placeholder="Email Address" name="email">
                    <input type="textarea" placeholder="Message" name="message">
                    <button type="submit">Send <span class="fa fa-paper-plane" aria-hidden="true"></span></button>
                </form>
            </div>
            <div class="contactDetails">
                <p><span class="fa fa-phone" aria-hidden="true"></span>01231021032</p>
                <p><span class="fa fa-envelope" aria-hidden="true"></span>inquire@diwasuwa.lk</p>
                <p><span class="fa fa-map-marker" aria-hidden="true"></span> No:101, Kandy</p>
            </div>
        </div>
    </section>
    <section class="announcement" id="announcement">
        <h4>Announcements</h4>
    <div class="serviceCards">
        <?php
        include 'dbConnection.php';

        // Query to get all announcements from the announcements table
        $query = "SELECT announceID, announcement FROM announcements ORDER BY announceID DESC";
        $result = $conn->query($query);

        // Check if there are results
        if ($result->num_rows > 0) {
            // Loop through the results and create a Scard div for each announcement
            while ($row = $result->fetch_assoc()) {
                $announcementID = htmlspecialchars($row['announceID']);
                $announcement = htmlspecialchars($row['announcement']);
                echo '<div class="Scard">';
                echo '<p>' . $announcement . '</p>';
                echo '</div>';
            }
        } else {
            echo '<div class="Scard">';
            echo '<p>No announcements available.</p>';
            echo '</div>';
        }

        // Close the connection
        $conn->close();
        ?>
    </div>
    </section>
    <?php include 'footer.html'?>
</body>
</html>


<?php
// Include the database connection file
include 'dbConnection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form inputs
    $email = $_POST['email'];
    $message = $_POST['message'];
    $username = 'admin1';

    // Validate input fields
    if (empty($email) || empty($message)) {
        echo "<script>alert('Please fill in all fields.');</script>";
        exit();
    }

    // SQL query to insert data into the message table
    $sql = "INSERT INTO message (email, message, username) VALUES (?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "<script>alert('Error preparing statement: " . addslashes($conn->error) . "');</script>";
        exit();
    }

    // Bind the parameters to the SQL query
    $stmt->bind_param("sss", $email, $message, $username);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
        alert('Message sent successfully!');
        </script>";
    } else {
        echo "<script>alert('Error sending message: " . addslashes($stmt->error) . "');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>