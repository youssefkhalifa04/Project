<?php 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("./dbh.inc.php");

    $userId = $_SESSION['user_id'] ?? null;
    $username = $_SESSION['username'] ?? 'guest';  // Retrieve from session
    $email = $_SESSION['email'] ?? 'unknown@example.com';  // Retrieve from session
    $total = $_POST['total'] ?? 0;
    $articles = $_POST['articles'] ?? '';
    $orderDate = date("Y-m-d H:i:s");

    if (!$userId) {
        die("User not logged in.");
    }

    try {
        // Insert into orders table
        $sql = "INSERT INTO orders (user_id, username, email, articles, total_price, order_date) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId, $username, $email, $articles, $total, $orderDate]);

        // Optionally clear the user's cart after placing the order
        $clearCartSQL = "DELETE FROM cart_items WHERE cart_id = ?";  // Delete based on user_id
        $clearStmt = $pdo->prepare($clearCartSQL);
        $clearStmt->execute([$userId]);

        $_SESSION['order_success'] = "Order placed successfully!";
        header("Location: ../index.php");
        exit();
    } catch (PDOException $e) {
        die("Order failed: " . $e->getMessage());
    }
}
