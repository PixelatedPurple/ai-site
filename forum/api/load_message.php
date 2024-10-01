<?php
require 'config.php';

// Fetch chat messages from the database
$stmt = $pdo->prepare("SELECT chat_messages.message, chat_messages.created_at, users.username 
                        FROM chat_messages 
                        JOIN users ON chat_messages.user_id = users.id 
                        ORDER BY chat_messages.created_at ASC");
$stmt->execute();
$messages = $stmt->fetchAll();

// Output messages as HTML
foreach ($messages as $message) {
    echo "<p><strong>{$message['username']}</strong>: {$message['message']} <small>{$message['created_at']}</small></p>";
}
