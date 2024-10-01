<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo "User not logged in.";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $message = $_POST['message'];

    // Insert the message into the chat_messages table
    $stmt = $pdo->prepare("INSERT INTO chat_messages (user_id, message) VALUES (?, ?)");
    $stmt->execute([$user_id, $message]);

    echo "Message sent.";
}
