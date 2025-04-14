<?php
session_start();

// Dummy cart items for demonstration
$cart = $_SESSION['cart'] ?? [
    ['id' => 1, 'name' => 'Sample Product', 'price' => 19.99, 'quantity' => 2, 'image' => 'https://via.placeholder.com/150'],
    ['id' => 2, 'name' => 'Another Product', 'price' => 39.99, 'quantity' => 1, 'image' => 'https://via.placeholder.com/150']
];
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

    <?php if (empty($cart)): ?>
      <p class="text-center text-gray-400">Your cart is empty.</p>
    <?php else: ?>
      <div class="space-y-6">
        <?php foreach ($cart as $item): 
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
