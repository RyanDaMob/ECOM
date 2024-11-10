<?php
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $image_blob = null;

    // Handle image upload and convert to binary
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_tmp = $_FILES['image']['tmp_name'];

        // Open the image file as binary
        $image_blob = file_get_contents($image_tmp);
    }

    // Insert product data into the database with image as BLOB
    $sql = "INSERT INTO products (product_name, product_category, product_price, product_stock, image_blob) 
            VALUES (:product_name, :category, :price, :stock, :image_blob)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':image_blob', $image_blob, PDO::PARAM_LOB); // Bind the image binary as a BLOB
    $stmt->execute();

    // Redirect to product list page after successful submission
    header('Location: product_list.php');
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/pcstyles.css">
    <style>
        .drag-area {
            border: 2px dashed #007bff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        }

        .drag-area.highlight {
            background-color: rgba(0, 123, 255, 0.1);
        }

        .drag-area p {
            margin: 0;
            font-size: 16px;
            color: #555;
        }

        .drag-area strong {
            color: #007bff;
            cursor: pointer;
        }

        .drag-area img {
            max-width: 150px;
            margin-top: 10px;
            display: none;
            border-radius: 5px;
        }
    </style>
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
            <h1>Add New Product</h1>
            <form action="product_create.php" method="POST" enctype="multipart/form-data">
                <label for="product_name">Product Name</label>
                <input type="text" name="product_name" required>

                <label for="category">Category</label>
                <input type="text" name="category" required>

                <label for="price">Price</label>
                <input type="number" name="price" required>

                <label for="stock">Stock</label>
                <input type="number" name="stock" required>

                <!-- Image Upload with Drag and Drop -->
                <label for="image">Product Image</label>
                <div class="drag-area" id="drag-area">
                    <p>Drag & Drop to Upload Image or <strong>Browse</strong></p>
                    <input type="file" name="image" id="image" style="display:none;" accept="image/*">
                    <img id="preview" alt="Image preview" />
                </div>

                <button type="submit">Add Product</button>
            </form>
        </main>
    </div>

    <script>
        const dragArea = document.getElementById('drag-area');
        const imageInput = document.getElementById('image');
        const preview = document.getElementById('preview');

        // Handle drag and drop
        dragArea.addEventListener('click', () => imageInput.click());

        dragArea.addEventListener('dragover', (event) => {
            event.preventDefault();
            dragArea.classList.add('highlight');
        });

        dragArea.addEventListener('dragleave', () => dragArea.classList.remove('highlight'));

        dragArea.addEventListener('drop', (event) => {
            event.preventDefault();
            dragArea.classList.remove('highlight');
            const file = event.dataTransfer.files[0];
            imageInput.files = event.dataTransfer.files;
            showPreview(file);
        });

        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            showPreview(file);
        });

        function showPreview(file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    </script>

</body>
</html>
