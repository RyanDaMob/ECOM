<?php
include('connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM feedback WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('Location: feedback_list.php');
}
?>
