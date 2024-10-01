<?php
require 'config.php';

if (isset($_GET['code'])) {
    $verification_code = $_GET['code'];

    // Verify user
    $stmt = $pdo->prepare("UPDATE users SET is_verified = 1 WHERE verification_code = ?");
    $stmt->execute([$verification_code]);

    if ($stmt->rowCount()) {
        echo "Email verified successfully!";
    } else {
        echo "Invalid verification code!";
    }
}
?>
