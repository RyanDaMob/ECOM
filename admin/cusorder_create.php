<?php
include('connect.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $customer_name = $_POST['customer_name'];
    $order_date = date('Y-m-d H:i:s'); // Current timestamp for order date

    // Fetch product price from the products table
    $stmt = $conn->prepare("SELECT product_price FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $product_price = $product['product_price'];
        $total_price = $product_price * $quantity;

        // Insert order data into the orders table
        $sql = "INSERT INTO orders (username, product_id, quantity, total_price, order_date, phone, address, customer_name) 
                VALUES (:username, :product_id, :quantity, :total_price, :order_date, :phone, :address, :customer_name)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':total_price', $total_price);
        $stmt->bindParam(':order_date', $order_date);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':customer_name', $customer_name);
        $stmt->execute();

        // Redirect to the order list page after successful submission
        header('Location: order_list.php');
        exit();
    } else {
        echo "Product not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order</title>
    <link rel="stylesheet" href="css/pcstyles.css"> <!-- Link to your CSS -->
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="cusorder_list.php">Orders</a></li>
                    <!-- Add more navigation links if necessary -->
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <h1>Add New Order</h1>
            <form action="order_create.php" method="POST">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>

                <label for="product_id">Product ID</label>
                <input type="number" name="product_id" id="product_id" required>

                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" required>

                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" required>

                <label for="address">Address</label>
                <input type="text" name="address" id="address" required>

                <label for="customer_name">Customer Name</label>
                <input type="text" name="customer_name" id="customer_name" required>

                <button type="submit">Add Order</button>
            </form>
        </main>
    </div>
</body>
</html>
