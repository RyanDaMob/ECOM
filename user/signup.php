<?php
include('connect.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (empty($username) || empty($email) || empty($password)) {
        echo "All fields are required.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $query->bindParam(':username', $username);
        $query->bindParam(':email', $email);
        $query->execute();
        
        if ($query->rowCount() > 0) {
            echo "Username or email already exists.";
        } else {
            $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, 'customer')";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();
            echo "Registration successful!";
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
        <form action="signup.php" method="POST">
        <br>
            <h1>Sign Up</h1>
            <br>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <button type="submit">Sign Up</button>
            <br><br>
            <a class="goli" href="login.php">Already have an account? Log In</a>
            <br><br><br><br><br>
        </form>
    </section>
    <!-- Signup Form End -->
<br><br><br><br><br>
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
