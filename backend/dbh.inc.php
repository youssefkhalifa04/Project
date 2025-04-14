<?php
$dsn = "mysql:host=localhost;dbname=e-commerce;";

$dbusername = "admin";
$dbpassword = "admin";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'hello' . '<br>';
    die("Connection failed: " . $e->getMessage()); // Use die() to stop execution
}
