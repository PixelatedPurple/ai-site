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

// Redirect unverified users to the verification landing page
if (!$user['is_verified']) {
    header('Location: verify_landing.php');
    exit();
}

echo "Welcome to your profile, " . $user['username'];


$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = $_POST['bio'];

    // Handle file upload for profile picture
    if (isset($_FILES['profile_pic'])) {
        $file_name = $_FILES['profile_pic']['name'];
        $file_tmp = $_FILES['profile_pic']['tmp_name'];
        move_uploaded_file($file_tmp, "uploads/$file_name");
        $profile_pic = "uploads/$file_name";
    } else {
        $profile_pic = NULL;
    }

    $stmt = $pdo->prepare("UPDATE users SET bio = ?, profile_pic = ? WHERE id = ?");
    $stmt->execute([$bio, $profile_pic, $user_id]);

    echo "Profile updated!";
}

// Fetch user info
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

    <form method="POST" enctype="multipart/form-data">
        <textarea name="bio" placeholder="Write your bio"><?php echo $user['bio']; ?></textarea><br>
        <input type="file" name="profile_pic"><br>
        <button type="submit">Update Profile</button>
    </form>

    <img src="<?php echo $user['profile_pic']; ?>" alt="Profile Picture">
</body>
</html>
