<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "floral_haven");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$isLoggedIn = isset($_SESSION['username']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Floral Haven - About Us, Contact, Careers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="cart.css">
</head>
<body>
<header>
    <input type="checkbox" id="toggler">
    <label for="toggler" class="fas fa-bars"></label>
    <a href="#" class="logo1">Floral Haven<span>.</span></a>
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="signup.php">Signup</a>
        <a href="product.php">Products</a>
        <a href="customization.php">Customization</a>
    </nav>
    <div class="icons">
    <a href="heart.php" class="fas fa-heart"></a>
    <a href="cart.php" class="fas fa-shopping-cart" title="Cart"></a>
        <?php if ($isLoggedIn): ?>
            <div class="user-menu">
                <span class="user-icon">
                    <i class="fas fa-user-circle"></i> <?= $_SESSION['username']; ?>
                </span>
                <div class="dropdown-content">
                    <a href="recent_orders.php">View Recent Orders</a>
                    <a href="logout.php">Log Out</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</header>
<br><br><br><br>
<section id="about" class="section">
        <h2>About Us</h2>
        <div class="content-wrapper">
            <div class="image-placeholder"><img src="images\qwe1.jpg" alt="Lilies"></div>
            <p>
                Floral Haven is dedicated to providing beautiful floral arrangements crafted with the freshest flowers. 
                Our passion for flowers drives us to deliver the best to our customers. We value sustainability and work with 
                local growers to bring you unique arrangements for any occasion.
            </p>
        </div>
    </section>

    <section id="contact" class="section">
        <h2>Contact Us</h2>
        <div class="content-wrapper reverse">
            <p>
                Reach out to us for any inquiries, custom arrangements, or assistance with your orders. 
                Our team is here to help you with any questions and provide you with the best customer service possible.
            </p>
            <div class="image-placeholder"><img src="images\qwe2.jpg" alt="Lilies"></div>
        </div>
    </section>

    <section id="careers" class="section">
        <h2>Careers</h2>
        <div class="content-wrapper">
        <div class="image-placeholder"><img src="images\qwe3.jpg" alt="Lilies"></div>
        <p>
                Join our team! At Floral Haven, we are always looking for talented individuals who share our love for flowers 
                and commitment to excellence. Explore opportunities to work with a passionate team and grow your career with us.
            </p>
        </div>
    </section>

    <section class="footer">
    <div class="footer-container">
        <div class="footer-column">
            <h4>Company</h4>
            <ul>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="aboutus.php">Contact</a></li>
                <li><a href="aboutus.php">Careers</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Services</h4>
            <ul>
                <li><a href="service.php">Flower Delivery</a></li>
                <li><a href="service.php">Custom Bouquets</a></li>
                <li><a href="service.php">Gift Wrapping</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Follow Us</h4>
            <ul>
                <li><a href="www.facebook.com"><i class="fas fa-comment"></i> Facebook</a></li>
                <li><a href="www.instagram.com"><i class="fas fa-camera"></i> Instagram</a></li>
                <li><a href="feedback.php"><i class="fas fa-bird"></i> Feedback</a></li>
            </ul>
        </div>
    </div>
</section>
    
</body>
</html>
