<?php
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $guests = $_POST["guests"];
    $message = $_POST["message"];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $error1 = "";
        $error2 = "";
        $error3 = "";
        $error4 = "";
        $error5 = "";
        $error6 = "";

        // Validate name
        if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
            $error1 = "Name must contain only letters and spaces.";
        }

        // Validate email
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error2 = "Valid email address is required.";
        }

        // Validate phone number
        if (!preg_match("/^\d{10}$/", $phone)) {
            $error3 = "Phone number must be 10 digits long.";
        }

        // Validate reservation date
        $today = strtotime(date("Y-m-d"));
        $reservationDate = strtotime($date);
        $twoDaysAhead = strtotime("+2 days");
        if ($reservationDate < $today || $reservationDate < $twoDaysAhead) {
            $error4 = "Reservation date must be at least 2 days ahead.";
        }

        // Validate reservation time
        $reservationTime = strtotime($time);
        $minTime = strtotime("10:00");
        $maxTime = strtotime("22:00");
        if ($reservationTime < $minTime || $reservationTime > $maxTime) {
            $error5 = "Reservation time must be between 10:00 and 22:00.";
        }

        // Validate message length
        if (strlen($message) > 200) {
            $error6 = "Additional message should not exceed 200 characters.";
        }
    
    }

    if(empty($error1) && empty($error2) && empty($error3) && empty($error4) && empty($error5) && empty($error6)){
        $server = "localhost";
        $username = "root";
        $password = "";
        
        $con = mysqli_connect($server, $username, $password);

        if(!$con){
            die("connection to this database failed due to".mysqli_connect_error());
        }
        // echo "Success connecting to the database";

        
        $sql = "INSERT INTO `finalproject`.`reservations` (`name`, `email`, `phone`, `date`, `time`, `guests`, `message`, `dt`) VALUES ('$name', '$email', '$phone', '$date', '$time', '$guests', '$message', current_timestamp());";
        // echo $sql;
        
        if($con->query($sql)){
            $successMessage = "Reservation successfully submitted!";

        }
        else{
            echo "ERROR : $sql <br> $con->error";
        }

        $con->close();
    }
    // include"./reservations.html";
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="reservations.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="iconlogo.png" alt="Burger Hut Logo">
        </div>
        <nav>
            <div class="hamburger" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <ul id="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="menu.html">Menu</a></li>
                <li><a href="reservations.html">Reservations</a></li>
                <li><a href="testimonials.html">Testimonials</a></li>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section class="reservations">
        <div class="reservation-form">
            <h2>Make a Reservation</h2>
            <br>
            <?php if (isset($successMessage)) : ?>
                <div style="color: green; height:0; transform:translateY(-19px);"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <br>
            <form action="reservations.php" method="post" autocomplete="off">
                <input type="text" name="name" id="name" placeholder="Your Name" required>
                <?php if (isset($error1)) : ?>
                    <div style="color: red; height:0; transform:translateY(-19px);"><?php echo $error1; ?></div>
                <?php endif; ?>
                <input type="email" name="email" id="email" placeholder="Your Email" required>
                <?php if (isset($error2)) : ?>
                    <div style="color: red; height:0; transform:translateY(-19px);"><?php echo $error2; ?></div>
                <?php endif; ?>
                <input type="tel" name="phone" id="phone" placeholder="Phone Number" required>
                <?php if (isset($error3)) : ?>
                    <div style="color: red; height:0; transform:translateY(-19px);"><?php echo $error3; ?></div>
                <?php endif; ?>
                <input type="date" name="date" id="date" placeholder="Date of Reservation" required>
                <?php if (isset($error4)) : ?>
                    <div style="color: red; height:0; transform:translateY(-19px);"><?php echo $error4; ?></div>
                <?php endif; ?>
                <input type="time" name="time" id="time" placeholder="Time for Reservation" required>
                <?php if (isset($error5)) : ?>
                    <div style="color: red; height:0; transform:translateY(-19px);"><?php echo $error5; ?></div>
                <?php endif; ?>
                <input type="number" name="guests" id="guests" min="1" placeholder="Number of Guests" required>
                <textarea name="message" id="message" placeholder="Additional Message" rows="4"></textarea>
                <?php if (isset($error6)) : ?>
                    <div style="color: red; height:0; transform:translateY(-19px);"><?php echo $error6; ?></div>
                <?php endif; ?>
                <button type="submit">Submit</button>
            </form>
        </div>
    </section>

    <footer class="footer">
        <p class="footer-text">&copy;Arman 2024 Burger Hut. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>

