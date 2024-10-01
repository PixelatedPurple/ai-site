<?php
session_start();
require 'config.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo "Access denied!";
    exit();
}

// Fetch all posts
$stmt = $pdo->prepare("SELECT posts.id, posts.title, posts.body, users.username FROM posts JOIN users ON posts.user_id = users.id");
$stmt->execute();
$posts = $stmt->fetchAll();

// Handle post deletion
if (isset($_GET['delete'])) {
    $post_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$post_id]);
    header('Location: admin.php');
}
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Admin Panel - Moderating Posts</h2>

    <table>
        <tr>
            <th>Title</th>
            <th>Body</th>
            <th>Posted by</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($posts as $post): ?>
            <tr>
                <td><?php echo $post['title']; ?></td>
                <td><?php echo $post['body']; ?></td>
                <td><?php echo $post['username']; ?></td>
                <td>
                    <a href="admin.php?delete=<?php echo $post['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
