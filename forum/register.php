<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $verification_code = md5(rand());

    // Insert user into database
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, verification_code) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $email, $password, $verification_code]);

    // Send verification email
    $subject = "Verify your email";
    $message = "Click here to verify your email: http://yourdomain.com/verify.php?code=$verification_code";
    mail($email, $subject, $message);

    echo "Registration successful! Please check your email for verification.";
}
?>

<!DOCTYPE html>
<html>
<body>
    <form method="POST" action="register.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
