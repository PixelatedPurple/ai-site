<?php
session_start();
include 'includes/db.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if username already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    
    if ($stmt->rowCount() > 0) {
        echo "Username already taken!";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Create a verification token
        $token = bin2hex(random_bytes(16));

        // Insert user into the database
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, verification_token) VALUES (:username, :email, :password, :token)");
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashedPassword, 'token' => $token]);

        // Send verification email
        $subject = "Email Verification";
        $message = "Please verify your email by clicking the link: 
                    http://yourdomain.com/verify.php?token=$token";
        mail($email, $subject, $message); // Use a proper mail setup in production
        
        echo "Registration successful! Please check your email to verify your account.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Register</h2>
    <form action="register.php" method="POST">
        <input type="text" name="username" required placeholder="Username">
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Password">
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Log in here</a>.</p>
</body>
</html>
