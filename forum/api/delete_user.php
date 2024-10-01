<?php
session_start();
require 'config.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if (!isset($_SESSION['is_owner']) || $_SESSION['is_owner'] != 1) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];

    // Delete the user from the database
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);

    header('Location: /managed/dashboard.php');
}
