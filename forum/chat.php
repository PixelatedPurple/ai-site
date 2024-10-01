<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Fetch user info
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        /* Simple chat style */
        #chat-box {
            width: 100%;
            height: 400px;
            border: 1px solid #ccc;
            overflow-y: scroll;
            padding: 10px;
            background-color: #f9f9f9;
        }
        #chat-form {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Welcome to the Chat, <?php echo $username; ?></h2>

    <!-- Chat Messages Box -->
    <div id="chat-box"></div>

    <!-- Chat Form -->
    <form id="chat-form" method="POST">
        <input type="text" id="message" placeholder="Type your message" required>
        <button type="submit">Send</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to load chat messages
        function loadChat() {
            $.ajax({
                url: "/api/load_messages.php",
                method: "GET",
                success: function(data) {
                    $('#chat-box').html(data); // Load chat messages into the chat box
                }
            });
        }

        // Load chat every second
        setInterval(loadChat, 1000);

        // Function to send a new message
        $('#chat-form').submit(function(e) {
            e.preventDefault();
            var message = $('#message').val();
            $.ajax({
                url: "/api/post.php",
                method: "POST",
                data: {message: message},
                success: function() {
                    $('#message').val(''); // Clear input field after sending
                    loadChat(); // Load updated chat messages
                }
            });
        });
    </script>
</body>
</html>
