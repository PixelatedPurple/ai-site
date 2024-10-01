<?php
session_start();
include 'includes/db.php'; // Include your database connection

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify token and update user status
    $stmt = $pdo->prepare("SELECT id FROM users WHERE verification_token = :token");
    $stmt->execute(['token' => $token]);
    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Update user to set verified and clear token
        $stmt = $pdo->prepare("UPDATE users SET email_verified = 1, verification_token = NULL WHERE id = :id");
        $stmt->execute(['id' => $user['id']]);

        // Log the user in
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username']; // Assuming you have a username column
        header("Location: index.php"); // Redirect to homepage
        exit;
    } else {
        echo "Invalid or expired token!";
    }
} else {
    echo "No token provided!";
}
?>
