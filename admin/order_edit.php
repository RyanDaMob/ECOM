<?php
include('connect.php');

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Fetch the order details
    $order_query = $conn->prepare("SELECT * FROM orders WHERE order_id = :id");
    $order_query->bindParam(':id', $order_id);
    $order_query->execute();
    $order = $order_query->fetch(PDO::FETCH_ASSOC);

    // Check if order exists
    if ($order === false) {
        echo "Order not found!";
        exit();  // Stop further execution if the order doesn't exist
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $customer_name = $_POST['customer_name'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $order_date = $_POST['order_date'];

    // Fetch the product price to update the total price
    $product_query = $conn->prepare("SELECT product_price FROM products WHERE product_id = :product_id");
    $product_query->bindParam(':product_id', $product_id);
    $product_query->execute();
    $product = $product_query->fetch(PDO::FETCH_ASSOC);

    // Check if the product exists
    if ($product !== false) {
        $product_price = $product['product_price'];
        $total_price = $product_price * $quantity;

        // Update the order details in the database
        $sql = "UPDATE orders SET customer_name = :customer_name, product_id = :product_id, quantity = :quantity, total_price = :total_price, order_date = :order_date WHERE order_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':customer_name', $customer_name);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':total_price', $total_price);
        $stmt->bindParam(':order_date', $order_date);
        $stmt->bindParam(':id', $order_id);
        $stmt->execute();

        // Redirect to the orders list page after successful update
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
    <title>Edit Order</title>
    <link rel="stylesheet" href="css/pestyle.css">
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
            <h1>Edit Order</h1>

            <!-- Ensure the order exists before rendering the form -->
            <?php if (isset($order)) { ?>
                <form action="order_edit.php" method="POST">
                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">

                    <label for="customer_name">Customer Name</label>
                    <input type="text" name="customer_name" value="<?php echo $order['customer_name']; ?>" required>

                    <label for="product_id">Product ID</label>
                    <input type="number" name="product_id" value="<?php echo $order['product_id']; ?>" required>

                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" value="<?php echo $order['quantity']; ?>" required>

                    <label for="order_date">Order Date</label>
                    <input type="date" name="order_date" value="<?php echo $order['order_date']; ?>" required>

                    <button type="submit">Update Order</button>
                </form>
            <?php } else { ?>
                <p>Order not found!</p>
            <?php } ?>

        </main>
    </div>

</body>
</html>
