<?php
// Database credentials
$host = 'localhost'; // Host name
$dbname = 'projectKing'; // Database name
$username = 'Joe'; // Database username
$password = 'password'; // Database password


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}
?>
