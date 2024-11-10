<?php
include('connect.php');

// Fetch total products
$total_products_query = $conn->query("SELECT COUNT(*) as total_products FROM products");
$total_products = $total_products_query->fetch(PDO::FETCH_ASSOC)['total_products'];

// Fetch recent orders (assuming orders table exists)
$recent_orders_query = $conn->query("SELECT * FROM orders ORDER BY order_date DESC LIMIT 5");
$recent_orders = $recent_orders_query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <h2>Floral Haven</h2>

            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="product_list.php">Products</a></li>
                    <li><a href="order_list.php">Orders</a></li>
                    <li><a href="user_list.php">Users</a></li>
                    <li><a href="cusorder_list.php">Custom Order</a></li>
                    <li><a href="feedback_list.php">Feedback</a></li>
                    <li><a href="logout.php">Logout</a></li>                                
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header>
            
                <h1> Admin Dashboard</h1><br><br><br><br><br>
                
            </header>

            <section class="stats">
                <div class="stat-box">
                    <h3>Total Products</h3>
                    <p><?php echo $total_products; ?></p>
                </div>
            </section>

            <section class="recent-activity">
                <h2>Recent Orders</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Order date</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_orders as $order) : ?>
                        <tr>
                            <td><?php echo $order['order_id']; ?></td>
                            <td><?php echo $order['customer_name']; ?></td>
                            <td><?php echo $order['order_date']; ?></td>
                            <td><?php echo $order['total_price']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebar-toggle');
            sidebar.classList.toggle('active');
            toggleBtn.classList.toggle('sidebar-open');
        }
    </script>

</body>
</html>


