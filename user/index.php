<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "floral_haven";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$isLoggedIn = isset($_SESSION['username']);

$mostOrderedQuery = "
    SELECT p.product_id, p.product_name, p.image_path, COUNT(o.product_id) AS order_count
    FROM orders o
    JOIN products p ON o.product_id = p.product_id
    GROUP BY o.product_id
    ORDER BY order_count DESC
    LIMIT 5";
$mostOrderedResult = $conn->query(query: $mostOrderedQuery);

$feedbackQuery = "SELECT username, rating, comment, created_at FROM feedback ORDER BY created_at DESC LIMIT 5";
$feedbackResult = $conn->query($feedbackQuery);
if (!$feedbackResult) {
    die("Query failed: " . $conn->error);
} elseif ($feedbackResult->num_rows == 0) {
    echo "No feedback available yet.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Floral Haven</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
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
                <a class="ddc" href="recent_orders.php">View Recent Orders</a>
                <a class="ddc" href="logout.php">Log Out</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</header>

<section class="hero" style="position: relative;">
    <div class="content">
        <h3>Bloom with Elegance at Floral Haven</h3>
        <p>Your trusted florist for crafting beautiful and memorable moments.</p>
    </div>
</section>

<section id="products" class="product-types">
    <h2>Our Floral Products</h2><br><br><br>
    <div class="product-type-box">
        <div class="product-card">
            <div class="product-label">Roses</div>
            <img src="images\product\anni\ani (6).jpg" alt="Roses">
            <p>Beautiful red roses to express love and passion.</p>
            <a href="product.php" class="btn">View More</a>
        </div>
        
        <div class="product-card">
            <div class="product-label">Lilies</div>
            <img src="images\product\anni\ani (1).jpg" alt="Lilies">
            <p>Elegant lilies for a touch of grace and beauty.</p>
            <a href="product.php" class="btn">View More</a>
        </div>
        
        <div class="product-card">
            <div class="product-label">Sunflower</div>
            <img src="images\product\anni\ani (3).jpg" alt="sunflower">
            <p>Radiant sunflowers to uplift any space.</p>
            <a href="product.php" class="btn">View More</a>
        </div>
    </div>
</section>
<section class="product-types">
<h1>Our Specialties</h1>
</section>

        <section class="features">
            <div class="feature-box">
                <i class="fa fa-truck"></i>
                <h4>Fast Delivery</h4>
                <p>Get your flowers delivered quickly.</p>
            </div>
            <div class="feature-box">
                <i class="fa fa-gift"></i>
                <h4>Gift Options</h4>
                <p>Beautiful arrangements for every occasion.</p>
            </div>
            <div class="feature-box">
                <i class="fa fa-heart"></i>
                <h4>Customer Care</h4>
                <p>We care about our customers.</p>
            </div>
        </section>

        </section>

        <section class="product-types">
    <h1>Our Products Types</h1><br><br><br>
    <div class="product-type-box">
        <a href="product.php?type=anniversary">
            <div class="product-label">Anniversary</div>
            <div class="product-card">
                <img src="images/product/anni/ani (10).jpg" alt="Anniversary Bouquets">
            </div>
        </a>
        <a href="product.php?type=wedding">
            <div class="product-label">Wedding</div>
            <div class="product-card">
                <img src="images/product/wedding/wed (4).jpg" alt="Wedding Bouquets">
            </div>
        </a>
        <a href="product.php?type=custom">
            <div class="product-label">Custom</div>
            <div class="product-card">
                <img src="images/product/custom/cus8.jpg" alt="Custom Bouquets">
            </div>
        </a>
    </div>
</section>


<section id="most-ordered" class="bouquet-slider">
    <h2><i class="fas fa-star"></i> Most Ordered Bouquets</h2>
    <div class="slider">
        <div class="slide-track">
            <?php while($row = $mostOrderedResult->fetch_assoc()): ?>
                <div class="slide">
                    <img src="image.php?id=<?= $row['product_id']; ?>" alt="<?= $row['product_name']; ?>">
                    <p><?= $row['product_name']; ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<section id="user-feedback" class="section">
    <h2>User Feedback</h2><br><br><br>
    <div class="slideshow-container">
        <?php if ($feedbackResult && $feedbackResult->num_rows > 0): ?>
            <?php $slideIndex = 1; ?>
            <?php while ($row = $feedbackResult->fetch_assoc()): ?>
                <div class="feedback-slide fade">
                    <div class="feedback-header">
                        <span class="username"><?= htmlspecialchars($row['username']); ?></span>
                        <span class="rating">
                            <?php for ($i = 0; $i < $row['rating']; $i++): ?>
                                ★
                            <?php endfor; ?>
                        </span>
                    </div>
                    <p class="comment"><?= htmlspecialchars($row['comment']); ?></p>
                    <span class="feedback-date"><?= date("F j, Y", strtotime($row['created_at'])); ?></span>
                </div>
                <?php $slideIndex++; ?>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No feedback available yet.</p>
        <?php endif; ?>

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
</section>
<br><br>

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

<style>
</style>


</body>
</html>
<script>
    function logout() {
        window.location.href = 'logout.php';
    }
</script>

<script>
    const blossomImages = ['images/cb1.jpg', 'images/cb2.jpg', 'images/cb3.jpg', 'images/cb4.jpg'];
    const blossomCount = 50; 

    for (let i = 0; i < blossomCount; i++) {
        const blossom = document.createElement('div');
        blossom.className = 'blossom';
        blossom.style.left = Math.random() * 100 + 'vw';
        blossom.style.animationDuration = Math.random() * 3 + 2 + 's';
        blossom.style.animationDelay = Math.random() * 5 + 's';
        const randomImage = blossomImages[Math.floor(Math.random() * blossomImages.length)];
        blossom.style.backgroundImage = `url(${randomImage})`;
        document.body.appendChild(blossom);
    }
</script>
<script>
    function previewBouquet() {
        const flowerType = document.getElementById('flower-type').value;
        const color = document.getElementById('color').value;
        const arrangement = document.getElementById('arrangement').value;

        document.getElementById('bouquet-preview').innerHTML = `
            <div class="preview-box" style="background-color: ${color};">
                <p>${flowerType} Bouquet</p>
                <p>Arrangement: ${arrangement}</p>
            </div>
        `;
    }
</script>
<script>
let slideIndex = 0;
showSlides();

function showSlides() {
    let slides = document.getElementsByClassName("feedback-slide");
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1 }    
    slides[slideIndex - 1].style.display = "block";  
    setTimeout(showSlides, 50000); // Change slide every 5 seconds
}

function plusSlides(n) {
    slideIndex += n - 1;
    showSlides();
}

</script>
