<?php
session_start();
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    
    if (empty($username) || empty($password)) {
        echo "All fields are required.";
    } else {
        
        $query = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $query->bindParam(':username', $username);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
        
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
           
            if ($user['role'] === 'admin') {
                header("Location: admin/index.php"); 
            } else {
                header("Location: index.php"); 
            }
        } else {
            echo "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Floral Haven</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="slstyle.css">
</head>

<body>

    <!-- Header Start -->
    <header>

    <input type="checkbox" name="" id="toggler">
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
       
    </div>
    </header>
    <!-- Header End -->
    <br><br><br><br><br>
    <!-- Signup Form Start -->
    <section class="signup">
    <form action="login.php" method="POST">
    <br><br>
        <h1>Login</h1>
        <br>
        <label for="username">Username</label>
        <input type="text" name="username" required><br>
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" required><br>
        <br><br>
        <button type="submit">Login</button>
        <br><br>
        <a class="goli" href='signup.php'> Doesn't have an account? Sign Up</a>
    </form>
    </section>
    <!-- Signup Form End -->
<br><br><br>
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

    
    

