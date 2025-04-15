<?php
session_start();
require_once 'dbh.inc.php'; // Adjust path if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $orderId = $_POST['order_id'] ?? null;

    if (!$action || !$orderId) {
        die("Invalid request.");
    }

    try {
        switch ($action) {
            case 'accept':
                // Mark the order as accepted
                $update = $pdo->prepare("UPDATE orders SET status = 'accepted' WHERE id = ?");
                $update->execute([$orderId]);
                header("Location: ../frontend/orders.php?status=accepted");
                exit;

            case 'reject':
                // Delete the order
                $delete = $pdo->prepare("DELETE FROM orders WHERE id = ?");
                $delete->execute([$orderId]);
                header("Location: ../frontend/orders.php?status=rejected");
                exit;

            case 'complete':
                

                $update = $pdo->prepare("UPDATE orders SET status = 'completed' WHERE id = ?");
                $update->execute([$orderId]);

                header("Location: ../frontend/acceptedorders.php?status=completed");
                exit;

            default:
                die("Unknown action.");
        }

    } catch (PDOException $e) {
        die("Error handling order: " . $e->getMessage());
    }
} else {
    die("Invalid request method.");
}
