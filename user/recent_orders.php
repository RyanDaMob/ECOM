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


// Fetch recent orders for the logged-in user
$recentOrdersQuery = "
    SELECT o.order_id, o.order_date, p.product_name
    FROM orders o
    JOIN products p ON o.product_id = p.product_id
    WHERE o.username = ?
    ORDER BY o.order_date DESC
    LIMIT 10";

$stmt = $conn->prepare($recentOrdersQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Orders</title>
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
<section class="boody">
    <h2>Recent Orders for <?= htmlspecialchars($username); ?></h2>
    <ul>
        <?php while($row = $result->fetch_assoc()): ?>
        <li>Order #<?= $row['order_id']; ?> - <?= $row['product_name']; ?> (<?= $row['order_date']; ?>)</li>
        <?php endwhile; ?>
    </ul>
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
