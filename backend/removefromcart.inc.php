<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        require_once("./dbh.inc.php");
        $sql = "DELETE FROM cart_items WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        header("Location: ../frontend/cart.php");
        exit();
    }