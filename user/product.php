
<?php
session_start(); // Ensure session is started

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "floral_haven";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cartCount = 0; // Default cart count to 0

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['username']); 

if ($isLoggedIn) {
    $username = $_SESSION['username'];

    // Query to count the number of items in the cart for the logged-in user
    $cartCountSql = "SELECT SUM(quantity) AS total_items FROM cart_items WHERE username = '$username'";
    $cartResult = $conn->query($cartCountSql);

    if ($cartResult && $cartResult->num_rows > 0) {
        $row = $cartResult->fetch_assoc();
        $cartCount = $row['total_items'] ?? 0; // Ensure it's zero if null
    }
}

// Retrieve filter values
$category = $_GET['category'] ?? 'all'; // Default to 'all'
$min_price = $_GET['min_price'] ?? '';  // Default to no minimum price
$max_price = $_GET['max_price'] ?? '';  // Default to no maximum price

// SQL query to fetch products based on filters
$sql = "SELECT product_id, product_name, product_category, product_price, product_stock FROM products WHERE 1=1";

// Filter by category if not 'all'
if ($category !== 'all') {
    $sql .= " AND product_category = '$category'";
}

// Filter by price range if specified
if (!empty($min_price)) {
    $sql .= " AND product_price >= $min_price";
}
if (!empty($max_price)) {
    $sql .= " AND product_price <= $max_price";
}

// Execute the query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="product.css">
    <title>Floral Haven Products</title>
</head>
<body>

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
        <a href="heart.php" class="fas fa-heart"></a>
        <div class="cart-icon">
        <a href="cart.php" class="fas fa-shopping-cart" alt="Cart" width="24">
        <span id="cart-count" class="<?= $cartCount > 0 ? 'badge-show' : 'badge-hide'; ?>">
            <?= $cartCount; ?>
        </span> 
    </a>
            </div>

        <!-- User Menu: Only shows when logged in -->
        <?php if ($isLoggedIn): ?>
        <div class="user-menu">
            <span class="user-icon">
                <i class="fas fa-user-circle"></i> <?= $_SESSION['username']; ?>
            </span>
            <div class="dropdown-content">
                <a class="ddc" href="recent_orders.php">View Recent Orders</a>
                <a class="ddc" href="logout.php">Log Out</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</header>

<h2>Our Products</h2>

<!-- Filter Section on the Left -->
<div class="content">
    <div class="filter-section">
        <h3>Filter Products</h3>
        <form action="product.php" method="GET">
            <label for="category">Category:</label>
            <select name="category" id="category">
                <option value="all" <?= $category == 'all' ? 'selected' : '' ?>>All</option>
                <option value="anniversary" <?= $category == 'anniversary' ? 'selected' : '' ?>>Anniversary</option>
                <option value="birthday" <?= $category == 'birthday' ? 'selected' : '' ?>>Birthday</option>
                <option value="wedding" <?= $category == 'wedding' ? 'selected' : '' ?>>Wedding</option>
            </select>
            
            <label for="price-range">Price Range:</label>
            <input type="number" name="min_price" value="<?= htmlentities($min_price) ?>" placeholder="Min">
            <input type="number" name="max_price" value="<?= htmlentities($max_price) ?>" placeholder="Max">
            
            <button type="submit">Apply Filter</button>
        </form>
    </div>

    <!-- Product Grid Section -->
    <div class="product-grid">
    <?php
// Fetch products from the database (this is inside your product display loop)
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $originalPrice = $row['product_price'];
        $increasedPrice = $originalPrice + ($originalPrice * 0.20); // Calculate the 20% increase

        echo "<div class='product-card'>
                <img src='image.php?id={$row['product_id']}' alt='{$row['product_name']}'>
                <h3>{$row['product_name']}</h3>

                <p>Discounted Price: <s>\${$originalPrice}</s></p>
                <p>Original Price: \${$increasedPrice}</p>

                <p>Stock: {$row['product_stock']}</p>
                

                <form action='heart.php' method='POST' style='display:inline;'>
                <input type='hidden' name='productId' value='{$row['product_id']}'>
              <button type='submit' class='action-button heart-button'>
              <i class='fas fa-heart'></i>
                </button>
                </form>

                
                <form action='cart.php' method='POST' style='display:inline;'>
                    <input type='hidden' name='productId' value='{$row['product_id']}'>
                    <button type='submit' class='action-button cart-button'>
                        <i class='fas fa-shopping-cart'></i>
                    </button>
                </form>
              </div>";
    }
} else {
    echo "<p>No products available in this category or price range.</p>";
}
?>

    </div>
</div>

<script src="cart.js"></script> 
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