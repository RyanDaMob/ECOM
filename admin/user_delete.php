<?php
include('connect.php');

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $delete_query = $conn->prepare("DELETE FROM users WHERE user_id = :id");
    $delete_query->bindParam(':id', $user_id);
    $delete_query->execute();

    header('Location: user_list.php');
}
?>
