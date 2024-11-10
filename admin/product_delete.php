<?php
include('connect.php');

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $delete_query = $conn->prepare("DELETE FROM products WHERE product_id = :id");
    $delete_query->bindParam(':id', $product_id);
    $delete_query->execute();

    header('Location: product_list.php');
}
?>
