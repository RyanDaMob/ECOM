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

$isLoggedIn = isset($_SESSION['username']); // Initialize $isLoggedIn based on session

// Handle form submission for customizing a bouquet
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs
    $flowerType = $_POST['flower_type'];
    $color = $_POST['color'];
    $quantity = intval($_POST['quantity']);
    $wrappingType = $_POST['wrapping_type'];
    $message = $_POST['message'];
    $customerName = $_POST['customer_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $totalPrice = floatval($_POST['total_price']);

    // Insert the custom order into the database
    $insertQuery = "INSERT INTO custom_orders (username, flower_type, color, quantity, wrapping_type, message, customer_name, address, phone, total_price, order_date)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssisssssd", $username, $flowerType, $color, $quantity, $wrappingType, $message, $customerName, $address, $phone, $totalPrice);

    if ($stmt->execute()) {
        $successMessage = "Your custom bouquet has been created successfully!";
    } else {
        $errorMessage = "There was an error creating your custom bouquet. Please try again.";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customize Your Bouquet</title>
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
<br><br><br><br>
<section>
<h2>Customize Your Bouquet</h2>

<?php if (isset($successMessage)): ?>
    <p class="success"><?= $successMessage ?></p>
<?php elseif (isset($errorMessage)): ?>
    <p class="error"><?= $errorMessage ?></p>
<?php endif; ?>

<!-- Customization Form -->
<form action="customization.php" method="post" class="customization-form">
    <label for="flower_type">Flower Type:</label>
    <input type="text" id="flower_type" name="flower_type" required>

    <label for="color">Color:</label>
    <input type="text" id="color" name="color" required>

    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" min="1" required>

    <label for="wrapping_type">Wrapping Type:</label>
    <input type="text" id="wrapping_type" name="wrapping_type" required>

    <label for="message">Message (optional):</label>
    <textarea id="message" name="message"></textarea>

    <label for="customer_name">Your Name:</label>
    <input type="text" id="customer_name" name="customer_name" required>

    <label for="address">Delivery Address:</lab-el>
    <input type="text" id="address" name="address" required>

    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phone" required>

    <!-- Hidden total price -->
    <input type="hidden" id="total_price" name="total_price" value="250">

    <button type="submit" class="submit-button">Submit Custom Bouquet</button>
</form>
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

<?php
$conn->close();
?>
