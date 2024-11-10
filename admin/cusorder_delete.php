<?php
include('connect.php');

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Delete order data from the database
    $sql = "DELETE FROM custom_orders WHERE order_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $order_id);
    $stmt->execute();

    // Redirect to order list page after successful deletion
    header('Location: cusorder_list.php');
    exit();
}
?>
