<?php
// config.php

$servername = "localhost"; // Usually 'localhost'
$db_username = "root"; // Replace with your DB username
$db_password = ""; // Replace with your DB password
$dbname = "floral_haven"; // Database name

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
