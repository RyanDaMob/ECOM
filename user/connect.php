<?php
$host = 'localhost'; // Change if necessary
$db = 'floral_haven'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}
?>
