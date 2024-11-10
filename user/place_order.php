<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['full_name'];
    $phoneNumber = $_POST['phone_number'];
    $address = $_POST['address'];
    $totalPrice = $_POST['total_price'];

    // Assuming $conn is your database connection
    // Insert order into database
    $sql = "INSERT INTO orders (customer_name, product_id, quantity, total_price, order_date, ph_num, address)
            VALUES (?, ?, ?, ?, NOW(), ?, ?)";

    $stmt = $conn->prepare($sql);

    foreach ($_SESSION['cart'] as $productId) {
        // For now, assuming a quantity of 1 for each product
        $quantity = 1;
        $stmt->bind_param("siiiss", $fullName, $productId, $quantity, $totalPrice, $phoneNumber, $address);
        $stmt->execute();
    }

    // Clear the cart
    $_SESSION['cart'] = [];

    // Redirect to a confirmation page
    header("Location: order_confirmation.php");
}
