<?php
function calculateTotal($cartItems, $conn) {
    $total = 0;

    if (!empty($cartItems)) {
        // Create a comma-separated string of product IDs
        $cartItemsString = implode(',', $cartItems);

        // Fetch product details for the items in the cart
        $sql = "SELECT product_price FROM products WHERE product_id IN ($cartItemsString)";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Add up the prices of all products in the cart
            while ($row = $result->fetch_assoc()) {
                $total += $row['product_price'];
            }
        }
    }

    return $total;
}
?>