<?php
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
    $role = $_POST['role'];

    // Insert user data into the database
    $sql = "INSERT INTO users (username, email, password, role) 
            VALUES (:username, :email, :password, :role)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);
    $stmt->execute();

    // Redirect to user list page after successful submission
    header('Location: user_list.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="css/pcstyles.css">
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
            <h1>Add New User</h1>
            <form action="user_create.php" method="POST" enctype="multipart/form-data">
                <label for="username">Username</label>
                <input type="text" name="username" required>

                <label for="email">Email</label>
                <input type="email" name="email" required>

                <label for="password">Password</label>
                <input type="password" name="password" required>

                <label for="role">Role</label>
                <select name="role" required>
                    <option value="customer">Customer</option>
                    <option value="admin">Admin</option>
                </select>

                <button type="submit">Add User</button>
            </form>
        </main>
    </div>

</body>
</html>
