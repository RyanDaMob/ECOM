<?php
include('connect.php');

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $user_query = $conn->prepare("SELECT * FROM users WHERE user_id = :id");
    $user_query->bindParam(':id', $user_id);
    $user_query->execute();
    $user = $user_query->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Optional: Update password if provided
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $user['password'];

    $sql = "UPDATE users SET username = :username, email = :email, password = :password, role = :role WHERE user_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();

    // Redirect to user list page after update
    header('Location: user_list.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="css/pestyle.css">
</head>
<body>

    <div class="dashboard-container">
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="user_list.php">Users</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <h1>Edit User</h1>
            <form action="user_edit.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

                <label for="username">Username</label>
                <input type="text" name="username" value="<?php echo $user['username']; ?>" required>

                <label for="email">Email</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

                <label for="password">Password (leave blank to keep current password)</label>
                <input type="password" name="password">

                <label for="role">Role</label>
                <select name="role" required>
                    <option value="customer" <?php echo $user['role'] === 'customer' ? 'selected' : ''; ?>>Customer</option>
                    <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>

                <button type="submit">Update User</button>
            </form>
        </main>
    </div>

</body>
</html>
