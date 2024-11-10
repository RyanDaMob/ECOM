<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['product_id'];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "floral_haven");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Remove product from wishlist
$deleteQuery = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($deleteQuery);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: heart.php");
exit();
?>
