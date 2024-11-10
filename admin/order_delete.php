<?php
include('connect.php');

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    $delete_query = $conn->prepare("DELETE FROM orders WHERE order_id = :id");
    $delete_query->bindParam(':id', $order_id);
    $delete_query->execute();

    // Redirect to the order list page after deletion
    header('Location: order_list.php');
}
?>
