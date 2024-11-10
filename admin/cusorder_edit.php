<?php
include('connect.php');

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Fetch the existing order details
    $order_query = $conn->prepare("SELECT * FROM custom_orders WHERE order_id = :id");
    $order_query->bindParam(':id', $order_id);
    $order_query->execute();
    $order = $order_query->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo "Order not found.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $username = $_POST['username'];
    $flower_type = $_POST['flower_type'];
    $color = $_POST['color'];
    $quantity = $_POST['quantity'];
    $wrapping_type = $_POST['wrapping_type'];
    $message = $_POST['message'];
    $customer_name = $_POST['customer_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $total_price = $_POST['total_price'];

    // Update order data in the database
    $sql = "UPDATE custom_orders SET username = :username, flower_type = :flower_type, color = :color, quantity = :quantity, wrapping_type = :wrapping_type, 
            message = :message, customer_name = :customer_name, address = :address, phone = :phone, total_price = :total_price WHERE order_id = :id";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':flower_type', $flower_type);
    $stmt->bindParam(':color', $color);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':wrapping_type', $wrapping_type);
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':customer_name', $customer_name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':total_price', $total_price);
    $stmt->bindParam(':id', $order_id);
    $stmt->execute();

    // Redirect to order list page after successful update
    header('Location: cusorder_list.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Edit Order</h1>
    <form action="cusorder_edit.php" method="POST">
        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">

        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($order['username']); ?>" required>

        <label for="flower_type">Flower Type</label>
        <input type="text" name="flower_type" value="<?php echo htmlspecialchars($order['flower_type']); ?>" required>

        <label for="color">Color</label>
        <input type="text" name="color" value="<?php echo htmlspecialchars($order['color']); ?>" required>

        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" value="<?php echo htmlspecialchars($order['quantity']); ?>" required>

        <label for="wrapping_type">Wrapping Type</label>
        <input type="text" name="wrapping_type" value="<?php echo htmlspecialchars($order['wrapping_type']); ?>" required>

        <label for="message">Message</label>
        <textarea name="message" required><?php echo htmlspecialchars($order['message']); ?></textarea>

        <label for="customer_name">Customer Name</label>
        <input type="text" name="customer_name" value="<?php echo htmlspecialchars($order['customer_name']); ?>" required>

        <label for="address">Address</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($order['address']); ?>" required>

        <label for="phone">Phone</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($order['phone']); ?>" required>

        <label for="total_price">Total Price</label>
        <input type="number" name="total_price" value="<?php echo htmlspecialchars($order['total_price']); ?>" required>

        <button type="submit">Update Order</button>
    </form>
</body>
</html>
