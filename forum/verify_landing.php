<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the user's details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// If the user is already verified, redirect them to their profile
if ($user['is_verified']) {
    header('Location: profile.php');
    exit();
}

// Resend verification email
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verification_code = $user['verification_code'];
    $email = $user['email'];

    // Send verification email
    $subject = "Verify your email";
    $message = "Click here to verify your email: http://yourdomain.com/verify.php?code=$verification_code";
    mail($email, $subject, $message);

    echo "Verification email sent!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
</head>
<body>
    <h2>Email Verification Required</h2>
    <p>Hi <?php echo $user['username']; ?>, you need to verify your email address before you can access your profile and the forum.</p>
    <p>An email was sent to <?php echo $user['email']; ?>. Please check your inbox and click the verification link.</p>

    <form method="POST" action="verify_landing.php">
        <button type="submit">Resend Verification Email</button>
    </form>
</body>
</html>

