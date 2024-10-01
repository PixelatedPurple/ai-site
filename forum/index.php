<?php
session_start();
include 'includes/db.php';

// Fetch posts from the database
$stmt = $pdo->query("SELECT posts.id, posts.content, posts.created_at, users.username 
                      FROM posts JOIN users ON posts.user_id = users.id 
                      ORDER BY posts.created_at DESC LIMIT 10");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Forum</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Welcome to the User Forum</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <section id="posts">
            <h2>Recent Posts</h2>
            <?php if ($posts): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <h3><?php echo htmlspecialchars($post['username']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                        <small>Posted on: <?php echo htmlspecialchars($post['created_at']); ?></small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No posts available.</p>
            <?php endif; ?>
        </section>

        <section id="login-register">
            <h2><?php echo isset($_SESSION['user_id']) ? 'Welcome back!' : 'Login / Register'; ?></h2>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <form action="login.php" method="POST">
                    <input type="text" name="username" required placeholder="Username">
                    <input type="password" name="password" required placeholder="Password">
                    <button type="submit">Login</button>
                </form>
                <form action="register.php" method="POST">
                    <input type="text" name="username" required placeholder="Username">
                    <input type="email" name="email" required placeholder="Email">
                    <input type="password" name="password" required placeholder="Password">
                    <button type="submit">Register</button>
                </form>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> User Forum. All rights reserved.</p>
    </footer>
</body>
</html>
