<?php
session_start();
require_once '../backend/dbh.inc.php';

try {
    $stmt = $pdo->query("SELECT id, order_date, total_price, articles FROM orders where status = 'pending'");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching orders: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Orders</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
  <div class="min-h-screen flex">
    <aside class="w-64 bg-gray-800 p-6 hidden md:block fixed left-0 top-0 bottom-0">
      <h2 class="text-2xl font-bold mb-8">Admin Panel</h2>
      <nav class="space-y-4">
        <a href="./admin.php" class="block text-gray-300 hover:text-white">Add Product</a>
        <a href="./orders.php" class="block text-gray-300 hover:text-white font-bold">Orders</a>
        <a href="./acceptedorders.php" class="block text-gray-300 hover:text-white ">Accepted Orders</a>
        <a href="./donesells.php" class="block text-gray-300 hover:text-white">Done Sells</a>
      </nav>
    </aside>

    <main class="flex-1 p-8 ml-64">
      <h2 class="text-2xl font-bold mb-4">📦 Orders</h2>
      <div class="space-y-4">
        <?php if (empty($orders)): ?>
          <p class="text-gray-400">No orders found.</p>
        <?php else: ?>
          <?php foreach ($orders as $order): ?>
            <div class="bg-gray-800 p-4 rounded-lg shadow space-y-2">
              <div class="flex justify-between items-center">
                <span class="text-sm text-gray-400"><?= htmlspecialchars($order['order_date']) ?></span>
                <span class="text-lg font-semibold">$<?= number_format($order['total_price'], 2) ?></span>
              </div>
              <?php if (!empty($order['articles'])): ?>
                <p class="text-sm text-gray-300">🛒 <?= htmlspecialchars($order['articles']) ?></p>
              <?php endif; ?>

              <!-- Accept / Reject Buttons -->
              <div class="flex gap-4 mt-4">
                <form action="../backend/handelorder.inc.php" method="POST">
                  <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                  <input type="hidden" name="action" value="accept">
                  <input type="hidden" name="total_price" value="<?= $order['total_price'] ?>">
                  <input type="hidden" name="articles" value="<?= htmlspecialchars($order['articles']) ?>">
                  <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-500 rounded text-white text-sm">Accept</button>
                </form>

                <form action="../backend/handelorder.inc.php" method="POST">
                  <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                  <input type="hidden" name="action" value="reject">
                  <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-500 rounded text-white text-sm">Reject</button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </main>
  </div>
</body>
</html>
