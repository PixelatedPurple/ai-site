<?php
$host = 'sql.freedb.tech'; // or your database host
$db = 'freedb_forumdata'; // your database name
$user = 'freedb_Database_Worker'; // your database username
$pass = 'c!PB@5QJvhtu%E5'; // your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $db :" . $e->getMessage());
}
?>
