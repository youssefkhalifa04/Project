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
  $cartItemsName = array_column($cartItems, 'name');
  $total = 0;
  //var_dump($total);  // Check the total
  //var_dump($cartItemsName);  // Check the array of article names


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Shopping Cart</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<script>
  const form = document.getElementById('checkoutForm');

  form.addEventListener('submit', function(e) {
    e.preventDefault(); // Stop normal submission

    Swal.fire({
      title: 'Are you sure?',
      text: "Do you want to place this order?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#2563eb',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, checkout!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Submit the form after confirmation
        form.submit();
      }
    });
  });
</script>
<body class="bg-gray-900 text-white">
  <div class="container mx-auto px-4 py-8">
  <a href="./index.php" class="fixed left-6 top-8 mb-6 bg-blue-600 px-4 py-2 rounded hover:bg-blue-500 transition">
    ← Back to Home
  </a>
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
            <form action="../backend/removefromcart.inc.php" method="POST" class="mt-2">
              <input type="hidden" name="id" value="<?= $item['id'] ?>">
              <div class="flex gap-2">
              <button type="submit"  class="text-red-500 hover:text-white hover:bg-red-500 text-sm border border-red-400 px-2 py-1 rounded">Remove</button>
              
              </div>
            </form>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <form action="../backend/makeorder.inc.php" method="POST" id="checkoutForm">
  <div class="mt-8 bg-gray-800 p-6 rounded-lg shadow-md text-right">
    <p class="text-sm text-gray-400">Shipping fees : $8</p>
    <p class="text-xl font-semibold">Total: $<?= number_format($total + 8, 2) ?></p>

    <input type="hidden" name="total" value="<?= $total ?>">
    <input type="hidden" name="articles" value="<?= htmlspecialchars(implode(", ", $cartItemsName)) ?>">

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-4 hover:bg-blue-500 transition" onclick="alert('Order Placed')">
      Checkout
    </button>
  </div>
</form>


    <?php endif; ?>
  </div>
</body>
</html>
