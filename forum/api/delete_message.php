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
    $message_id = $_POST['message_id'];

    // Delete the message from the chat_messages table
    $stmt = $pdo->prepare("DELETE FROM chat_messages WHERE id = ?");
    $stmt->execute([$message_id]);

    header('Location: /managed/dashboard.php');
}
