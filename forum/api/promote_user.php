<?php
session_start();
require 'config.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];

    // Update the user's is_admin field to promote them to admin
    $stmt = $pdo->prepare("UPDATE users SET is_admin = 1 WHERE id = ?");
    $stmt->execute([$user_id]);

    header('Location: /managed/dashboard.php');
}
