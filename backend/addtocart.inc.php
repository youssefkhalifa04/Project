<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];  // Get the logged-in user's ID
    $productId = $_POST["product_id"];  // Get the product ID
    $quantity = $_POST["quantity"];  // Get the quantity to be added

    try {
        require_once("./dbh.inc.php");

        // Check if the user already has a cart
        $cartQuery = "SELECT * FROM cart WHERE user_id = ?";
        $cartStmt = $pdo->prepare($cartQuery);
        $cartStmt->execute([$userId]);
        $cart = $cartStmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            // Cart found for the user, use the user_id as the cart_id
            $cartId = $userId;  // The user_id acts as the cart_id in this case

            // Check if the product already exists in the cart
            $checkSql = "SELECT * FROM cart_items WHERE cart_id = ? AND product_id = ?";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->execute([$cartId, $productId]);
            $existingItem = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($existingItem) {
                // Update the quantity if the item already exists in the cart
                $updateSql = "UPDATE cart_items SET quantity = quantity + ? WHERE cart_id = ? AND product_id = ?";
                $updateStmt = $pdo->prepare($updateSql);
                $updateStmt->execute([$quantity, $cartId, $productId]);
            } else {
                // Insert the new item into the cart
                $insertSql = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)";
                $insertStmt = $pdo->prepare($insertSql);
                $insertStmt->execute([$cartId, $productId, $quantity]);
            }

            header("Location: ../frontend/vapes.php?added=success");
            exit();
        } else {
            echo "No cart found for the user.";
        }

    } catch (PDOException $e) {
        die("Error adding to cart: " . $e->getMessage());
    }
} else {
    header("Location: ../frontend/vape.php");
    exit();
}
