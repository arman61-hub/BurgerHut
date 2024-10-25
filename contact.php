<?php
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $error1 = "";
        $error2 = "";
        $error3 = "";

        // Validate name
        if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
            $error1 = "Name must contain only letters and spaces.";
        }

        // Validate email
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error2 = "Valid email address is required.";
        }

        // Validate message length
        if (strlen($message) > 200) {
            $error3 = "Additional message should not exceed 200 characters.";
        }
    
    }

    if(empty($error1) && empty($error2) && empty($error3)){
        $server = "localhost";
        $username = "root";
        $password = "";
        
        $con = mysqli_connect($server, $username, $password);

        if(!$con){
            die("connection to this database failed due to".mysqli_connect_error());
        }
        // echo "Success connecting to the database";

        
        $sql = "INSERT INTO `finalproject`.`contacts` (`name`, `email`,`message`, `dt`) VALUES ('$name', '$email', '$message', current_timestamp());";
        // echo $sql;
        
        if($con->query($sql)){
            $successMessage = "Message Sended!";

        }
        else{
            echo "ERROR : $sql <br> $con->error";
        }

        $con->close();
    }
    // include"./contact.html";
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <div class="logo">
            <img src="iconlogo.png" alt="Burger Hut Logo">
        </div>
        <nav>
            <ul>
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

    <section class="contact">
        <div class="contact-container">
            <h2>Contact Us</h2>
            <div class="contact-info">
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>123 Main Street, City, Country</p>
                </div>
                <div class="info-item">
                    <i class="fas fa-phone-alt"></i>
                    <p>+1 234 567 890</p>
                </div>
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <p>info@burgerhut.com</p>
                </div>
            </div>
            <br>
            <?php if (isset($successMessage)) : ?>
                <div style="color: green; height:0; transform:translateY(-19px);"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <br>
            <form action="contact.php" method="post" autocomplete="off" class="contact-form">
                <input type="text" name="name" id="name" placeholder="Your Name" required>
                <?php if (isset($error1)) : ?>
                    <div style="color: red; height:0; transform:translateY(-19px);"><?php echo $error1; ?></div>
                <?php endif; ?>
                <input type="email" name="email" id="email" placeholder="Your Email" required>
                <?php if (isset($error2)) : ?>
                    <div style="color: red; height:0; transform:translateY(-19px);"><?php echo $error2; ?></div>
                <?php endif; ?>
                <textarea name="message" id="message" placeholder="Your Message" rows="5" required></textarea>
                <?php if (isset($error3)) : ?>
                    <div style="color: red; height:0; transform:translateY(-19px);"><?php echo $error3; ?></div>
                <?php endif; ?>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </section>

    <footer class="footer">
        <p class="footer-text">&copy;Arman 2024 Burger Hut. All rights reserved.</p>
    </footer>
    
</body>
</html>

