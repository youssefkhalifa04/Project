<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    require_once("./dbh.inc.php");
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    header("Location: ../frontend/admin.php?deleteproduct=success");
    exit();
}