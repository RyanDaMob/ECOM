<?php
include('connect.php');

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $product_query = $conn->prepare("SELECT * FROM products WHERE product_id = :id");
    $product_query->bindParam(':id', $product_id);
    $product_query->execute();
    $product = $product_query->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $sql = "UPDATE products SET product_name = :product_name, product_category = :category, product_price = :price, product_stock = :stock WHERE product_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':id', $product_id);
    $stmt->execute();

    header('Location: product_list.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="css/pestyle.css">
</head>
<body>

    <div class="dashboard-container">
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="product_list.php">Products</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <h1>Edit Product</h1>
            <form action="product_edit.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

                <label for="product_name">Product Name</label>
                <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required>

                <label for="category">Category</label>
                <input type="text" name="category" value="<?php echo $product['product_category']; ?>" required>

                <label for="price">Price</label>
                <input type="number" name="price" value="<?php echo $product['product_price']; ?>" required>

                <label for="stock">Stock</label>
                <input type="number" name="stock" value="<?php echo $product['product_stock']; ?>" required>

                <button type="submit">Update Product</button>
            </form>
        </main>
    </div>

</body>
</html>
