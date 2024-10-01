<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Homepage</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        h1 {
            margin-bottom: 20px;
        }
        button {
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Welcome to the Forum</h1>

    <!-- Check if user is logged in -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Show the Chat button -->
        <a href="chat.php">
            <button>Go to Chat</button>
        </a>

        <!-- Show the Admin Dashboard button if the user is an admin -->
        <?php if ($_SESSION['is_admin'] == 1): ?>
            <a href="admin.php">
                <button>Admin Dashboard</button>
            </a>
        <?php endif; ?>

<?php if ($_SESSION['is_owner'] == 1): ?>
            <a href="/managed/dashboard.php">
                <button>Admin Dashboard</button>
            </a>
        <?php endif; ?>
  

        <!-- Logout button -->
        <form method="POST" action="logout.php" style="display:inline;">
            <button type="submit">Logout</button>
        </form>
    <?php else: ?>
        <!-- Show the Login and Registration buttons -->
        <a href="login.php">
            <button>Login</button>
        </a>
        <a href="register.php">
            <button>Register</button>
        </a>
    <?php endif; ?>

</body>
</html>
