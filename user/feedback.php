<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "floral_haven");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$isLoggedIn = isset($_SESSION['username']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form submission
    $rating = intval($_POST['rating']);
    $comment = $conn->real_escape_string($_POST['comment']);

    $stmt = $conn->prepare("INSERT INTO feedback (username, rating, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $username, $rating, $comment);

    if ($stmt->execute()) {
        $successMessage = "Thank you for your feedback!";
    } else {
        $errorMessage = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch recent feedback to display
$feedbackQuery = "SELECT username, rating, comment, created_at FROM feedback ORDER BY created_at DESC LIMIT 5";
$feedbackResult = $conn->query($feedbackQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Floral Haven - User Feedback</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="cart.css"> <!-- Link your CSS file -->
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
    <section id="submit-feedback" class="saction">
        <h2>Submit Your Feedback</h2>
        <?php if (isset($successMessage)): ?>
            <p class="success-message"><?= $successMessage; ?></p>
        <?php elseif (isset($errorMessage)): ?>
            <p class="error-message"><?= $errorMessage; ?></p>
        <?php endif; ?>
        <form action="feedback.php" method="POST">
            <label for="rating">Rating:</label>
            <select id="rating" name="rating" required>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Good</option>
                <option value="3">3 - Average</option>
                <option value="2">2 - Poor</option>
                <option value="1">1 - Terrible</option>
            </select>

            <label for="comment">Comment:</label>
            <textarea id="comment" name="comment" rows="4" required></textarea>

            <button type="submit">Submit Feedback</button>
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

<?php $conn->close(); ?>
