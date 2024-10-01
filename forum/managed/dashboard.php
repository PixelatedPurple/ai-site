<?php
session_start();
require 'config.php';

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_owner'] != 1) {
    header('Location: login.php');
    exit();
}

// Fetch all users from the database
$stmt = $pdo->prepare("SELECT id, username, email, is_admin FROM users");
$stmt->execute();
$users = $stmt->fetchAll();

// Fetch all chat messages
$stmt = $pdo->prepare("SELECT chat_messages.id, chat_messages.message, chat_messages.created_at, users.username 
                        FROM chat_messages 
                        JOIN users ON chat_messages.user_id = users.id 
                        ORDER BY chat_messages.created_at DESC");
$stmt->execute();
$messages = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        button { padding: 5px 10px; }
    </style>
</head>
<body>
    <h2>Owner Dashboard</h2>

    <!-- Section for managing users -->
    <h3>Manage Users</h3>
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo $user['is_admin'] ? 'Admin' : 'User'; ?></td>
                <td>
                    <?php if (!$user['is_admin']): ?>
                        <form method="POST" action="/api/promote_user.php" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <button type="submit">Promote to Admin</button>
                        </form>
                    <?php else: ?>
                        <form method="POST" action="/api/demote_user.php" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <button type="submit">Demote to User</button>
                        </form>
                    <?php endif; ?>
                    <form method="POST" action="/api/delete_user.php" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <button type="submit">Delete User</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Section for managing chat messages -->
    <h3>Manage Chat Messages</h3>
    <table>
        <tr>
            <th>Username</th>
            <th>Message</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($messages as $message): ?>
            <tr>
                <td><?php echo htmlspecialchars($message['username']); ?></td>
                <td><?php echo htmlspecialchars($message['message']); ?></td>
                <td><?php echo htmlspecialchars($message['created_at']); ?></td>
                <td>
                    <form method="POST" action="/api/delete_message.php" style="display:inline;">
                        <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                        <button type="submit">Delete Message</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
