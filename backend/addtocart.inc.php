<?php
session_start();
require_once 'dbh.inc.php'; // Include the database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/login.php?error=not_logged_in");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id']; // Get the user ID from the session
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    try {
        // Check if the item already exists in the cart for the logged-in user
        $checkSql = "SELECT * FROM cart_items WHERE user_id = ? AND product_id = ?";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([$userId, $productId]);
        $existingItem = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingItem) {
            // If the item already exists, update the quantity
            $updateSql = "UPDATE cart_items SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([$quantity, $userId, $productId]);
        } else {
            // If the item does not exist, insert it into the cart
            $insertSql = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $insertStmt = $pdo->prepare($insertSql);
            $insertStmt->execute([$userId, $productId, $quantity]);
        }

        // Redirect to the cart page with a success message
        header("Location: ../frontend/cart.php?added=success");
        exit();
    } catch (PDOException $e) {
        // Handle any errors that occur
        die("Error adding to cart: " . $e->getMessage());
    }
} else {
    // Redirect if the request is not a POST
    header("Location: ../frontend/vape.php");
    exit();
}
?>
