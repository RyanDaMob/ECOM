<?php
include('connect.php');

// Fetch products
$sql = "SELECT product_id, product_name, product_category, product_price, product_stock, image_blob FROM products";
$stmt = $conn->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($products) > 0) {
    foreach ($products as $row) {
        $image_data = base64_encode($row['image_blob']); // Encode the binary data for HTML
       
    }
} else {
    echo "No products available.";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="css/plstyle.css">
</head>
<body>

    <div class="dashboard-container">
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="product_list.php">Products</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <h1>Products</h1>
            <a href="product_create.php" class="add-product-btn">Add New Product</a>
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?php echo $product['product_id']; ?></td>
                        <td><?php echo $product['product_name']; ?></td>
                        <td><?php echo $product['product_category']; ?></td>
                        <td><?php echo $product['product_price']; ?></td>
                        <td><?php echo $product['product_stock']; ?></td>
                        <td>
                            <a href="product_edit.php?id=<?php echo $product['product_id']; ?>" class="action-link">Edit</a>
                            <a href="product_delete.php?id=<?php echo $product['product_id']; ?>" class="action-link delete" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>

</body>
</html>

