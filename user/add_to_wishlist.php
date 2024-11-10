<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];  // Assume you store user_id in session upon login
$product_id = $_GET['product_id'];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "floral_haven");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the product is already in the wishlist
$checkQuery = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Add product to wishlist if not already there
    $insertQuery = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
}

$stmt->close();
$conn->close();

header("Location: product.php");
exit();
?>
