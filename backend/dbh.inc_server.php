<?php
$host = "sql200.infinityfree.com";
$dbname = "if0_38758925_ecommerce"; // This must match the DB name you created in InfinityFree
$usernamee = "if0_38758925";
$passwordd = "pepsicolaKH2004"; // Replace with the password you set when creating the DB

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $usernamee, $passwordd); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
