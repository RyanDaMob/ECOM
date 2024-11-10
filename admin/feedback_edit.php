<?php
include('connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM feedback WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $feedback = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$feedback) {
        echo "Feedback not found!";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $sql = "UPDATE feedback SET username = :username, rating = :rating, comment = :comment WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('Location: feedback_list.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Feedback</title>
    <link rel="stylesheet" href="css/pestyle.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="feedback_list.php">Feedback</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <h1>Edit Feedback</h1>
            <?php if (isset($feedback)) { ?>
                <form action="feedback_edit.php" method="POST">
                    <input type="hidden" name="id" value="<?= $feedback['id'] ?>">

                    <label for="username">Username</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($feedback['username']) ?>" required>

                    <label for="rating">Rating</label>
                    <input type="number" name="rating" min="1" max="5" value="<?= htmlspecialchars($feedback['rating']) ?>" required>

                    <label for="comment">Comment</label>
                    <textarea name="comment" required><?= htmlspecialchars($feedback['comment']) ?></textarea>

                    <button type="submit">Update Feedback</button>
                </form>
            <?php } ?>
        </main>
    </div>
</body>
</html>
