<?php
include('connect.php'); // Assuming this connects to the database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $order_date = $_POST['order_date'];

    // Fetch the product price from the products table using product_id
    $stmt = $conn->prepare("SELECT product_price FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $product_price = $product['product_price'];
        $total_price = $product_price * $quantity;

        // Insert order data into the database
        $sql = "INSERT INTO orders (customer_name, product_id, quantity, total_price, order_date) 
                VALUES (:customer_name, :product_id, :quantity, :total_price, :order_date)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':customer_name', $customer_name);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':total_price', $total_price);
        $stmt->bindParam(':order_date', $order_date);
        $stmt->execute();

        // Redirect to orders list page after successful submission
        header('Location: order_list.php');
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
    <link rel="stylesheet" href="css/pcstyles.css">
</head>
<body>

    <div class="dashboard-container">
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="order_list.php">Orders</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <h1>Add New Order</h1>
            <form action="order_create.php" method="POST">
                <label for="customer_name">Customer Name</label>
                <input type="text" name="customer_name" required>

                <label for="product_id">Product ID</label>
                <input type="number" name="product_id" required>

                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" required>

                <label for="order_date">Order Date</label>
                <input type="date" name="order_date" required>

                <button type="submit">Add Order</button>
            </form>
        </main>
    </div>

</body>
</html>
