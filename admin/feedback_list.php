<?php
include('connect.php');

// Corrected query with the actual column names from your database
$sql = "SELECT id, username, rating, comment, created_at FROM feedback";
$stmt = $conn->query($sql);
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$feedbacks) {
    echo "No feedback available.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback List</title>
    <link rel="stylesheet" href="css/plstyle.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="feedback_list.php">Feedback</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <h1>Feedback</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($feedbacks) : ?>
                        <?php foreach ($feedbacks as $feedback) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($feedback['id']); ?></td>
                                <td><?php echo htmlspecialchars($feedback['username']); ?></td>
                                <td><?php echo htmlspecialchars($feedback['rating']); ?></td>
                                <td><?php echo htmlspecialchars($feedback['comment']); ?></td>
                                <td><?php echo htmlspecialchars($feedback['created_at']); ?></td>
                                <td>
                                    <a href="feedback_edit.php?id=<?php echo $feedback['id']; ?>" class="action-link">Edit</a>
                                    <a href="feedback_delete.php?id=<?php echo $feedback['id']; ?>" class="action-link delete" onclick="return confirm('Are you sure you want to delete this feedback?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6">No feedback available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
