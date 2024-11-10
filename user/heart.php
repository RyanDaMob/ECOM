<?php 
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "floral_haven";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$isLoggedIn = isset($_SESSION['username']);

// Add item to favorites (heart)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    // Fetch product details from the database
    $sql = "SELECT product_id, product_name, product_price FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        die("Product not found.");
    }

    // Initialize favorites if not set
    if (!isset($_SESSION['favorites'])) {
        $_SESSION['favorites'] = [];
    }

    // Add product to favorites session
    $favoriteItem = [
        'product_id' => $product['product_id'],
        'product_name' => $product['product_name'],
        'product_price' => $product['product_price'],
        'quantity' => 1
    ];
    $_SESSION['favorites'][] = $favoriteItem;
}

// Remove item from favorites
if (isset($_GET['remove'])) {
    $removeIndex = intval($_GET['remove']);
    unset($_SESSION['favorites'][$removeIndex]);
    $_SESSION['favorites'] = array_values($_SESSION['favorites']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="cart.css">
    <script defer src="cart.js"></script>
    <title>Your Favorites</title>
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
        <a href="heart.php" class="fas fa-heart" title="Favorites"></a>
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

<button class="back-button" onclick="window.location.href='product.php';">Back to Products</button>

<section>
    <h2>Your Favorites</h2>
    <?php if (!empty($_SESSION['favorites'])): ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['favorites'] as $index => $item): ?>
                <tr>
                    <td class="product-image">
                        <img src="image.php?id=<?= htmlspecialchars($item['product_id']) ?>" 
                             alt="<?= htmlspecialchars($item['product_name']) ?>" 
                             width="80" height="80">
                    </td>
                    <td class="product-name"><?= htmlspecialchars($item['product_name']) ?></td>
                    <td class="product-price">$<?= number_format($item['product_price'], 2) ?></td>
                    <td class="product-quantity"><?= htmlspecialchars($item['quantity']) ?></td>
                    <td class="product-total">$<?= number_format($item['product_price'] * $item['quantity'], 2) ?></td>
                    <td><a href="heart.php?remove=<?= $index ?>" class="remove-link">Remove</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3 class="total-price">Total: $<?= number_format(array_sum(array_map(fn($item) => $item['product_price'] * $item['quantity'], $_SESSION['favorites'])), 2) ?></h3>
    <?php else: ?>
        <p><br><br><br><br>Your favorites list is empty.</p>
    <?php endif; ?>
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
