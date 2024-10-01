<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $user_id = $_SESSION['user_id'];

    // Insert post
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, body) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $title, $body]);

    echo "Post created!";
}
?>

<!DOCTYPE html>
<html>
<body>
    <form method="POST" action="/api/post.php">
        <input type="text" name="title" placeholder="Title" required><br>
        <textarea name="body" placeholder="Body" required></textarea><br>
        <button type="submit">Create Post</button>
    </form>
</body>
</html>
