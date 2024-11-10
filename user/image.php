<?php
// Database configuration
$host = 'localhost';
$dbname = 'floral_haven';
$username = 'root';
$password = '';

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the product ID from the query string
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id > 0) {
    // SQL query to fetch the image BLOB for the specific product
    $sql = "SELECT image_blob FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($image_blob);
    $stmt->fetch();
    
    // Set the content-type header to image/png (or image/jpeg if using JPEG)
    header("Content-Type: image/png");
    echo $image_blob; // Output the image BLOB
} else {
    echo "Product not found.";
}

// Close the connection
$conn->close();
?>
