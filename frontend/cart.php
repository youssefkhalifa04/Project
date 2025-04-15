<?php
session_start();
require_once '../backend/dbh.inc.php';

$userId = $_SESSION['user_id'] ?? null;



try {
    // First, get the user's cart ID
    $sql = "SELECT user_id FROM cart WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    $cartRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cartRow) {
        $cartItems = []; // No cart yet
    } else {
        $cartId = $cartRow['user_id'];

        // Get items in the cart with product details
        $sql = "SELECT ci.id, p.name, p.price, p.image, ci.quantity
                FROM cart_items ci
                JOIN products p ON ci.product_id = p.id
                WHERE ci.cart_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cartId]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Shopping Cart</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">🛒 Your Cart</h1>

    <?php if (empty($cartItems)): ?>
      <p class="text-center text-gray-400">Your cart is empty.</p>
    <?php else: ?>
      <div class="space-y-6">
        <?php foreach ($cartItems as $item): 
          $itemTotal = $item['price'] * $item['quantity'];
          $total += $itemTotal;
        ?>
        <div class="flex items-center justify-between bg-gray-800 p-4 rounded-lg shadow-md">
          <div class="flex items-center gap-4">
            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-20 h-20 rounded object-cover">
            <div>
              <h3 class="text-lg font-semibold"><?= htmlspecialchars($item['name']) ?></h3>
              <p class="text-sm text-gray-400">Price: $<?= number_format($item['price'], 2) ?></p>
              <p class="text-sm text-gray-400">Quantity: <?= $item['quantity'] ?></p>
            </div>
          </div>
          <div class="text-right">
            <p class="font-bold text-xl">$<?= number_format($itemTotal, 2) ?></p>
            <form action="removefromcart.php" method="POST" class="mt-2">
              <input type="hidden" name="id" value="<?= $item['id'] ?>">
              <button class="text-red-400 hover:text-red-200 text-sm">Remove</button>
            </form>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="mt-8 bg-gray-800 p-6 rounded-lg shadow-md text-right">
        <p class="text-xl font-semibold">Total: $<?= number_format($total, 2) ?></p>
        <a href="checkout.php" class="mt-4 inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-500 transition">Proceed to Checkout</a>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
