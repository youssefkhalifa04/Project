<?php
// manageproduct.php
session_start();

// Placeholder: simulate fetching products
$products = [
  [
    "id" => 1,
    "name" => "Dark Hoodie",
    "price" => 39.99,
    "description" => "A stylish dark hoodie.",
    "image" => "https://via.placeholder.com/150"
  ],
  [
    "id" => 2,
    "name" => "Sneakers",
    "price" => 59.99,
    "description" => "Comfortable running shoes.",
    "image" => "https://via.placeholder.com/150"
  ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manage Products</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
  <div class="min-h-screen flex">
    <aside class="w-64 bg-gray-800 p-6">
      <h2 class="text-2xl font-bold mb-8">Admin Panel</h2>
      <nav class="space-y-4">
        <a href="#addProduct" class="block text-gray-300 hover:text-white">Add Product</a>
        <a href="#productList" class="block text-gray-300 hover:text-white">Manage Products</a>
      </nav>
    </aside>

    <main class="flex-1 p-10">
      <!-- Add Product Form -->
      <section id="addProduct" class="mb-12">
        <h3 class="text-xl font-semibold mb-4">Add New Product</h3>
        <form action="addproduct.inc.php" method="POST" class="bg-gray-800 p-6 rounded-lg shadow-md space-y-4">
          <input type="text" name="name" placeholder="Product Name" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded" />
          <input type="number" name="price" placeholder="Price" step="0.01" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded" />
          <textarea name="description" placeholder="Description" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded"></textarea>
          <input type="text" name="image" placeholder="Image URL" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded" />
          <button type="submit" class="bg-indigo-600 px-4 py-2 rounded hover:bg-indigo-500">Add Product</button>
        </form>
      </section>

      <!-- Product List -->
      <section id="productList">
        <h3 class="text-xl font-semibold mb-4">Product List</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($products as $product): ?>
            <div class="bg-gray-800 p-4 rounded-lg shadow-md">
              <img src="<?= htmlspecialchars($product['image']) ?>" class="rounded mb-3" alt="Product Image" />
              <h4 class="text-lg font-bold"><?= htmlspecialchars($product['name']) ?></h4>
              <p class="text-sm text-gray-400">$<?= number_format($product['price'], 2) ?></p>
              <p class="mt-2 text-gray-300"><?= htmlspecialchars($product['description']) ?></p>
              <div class="mt-4 flex gap-2">
                <form action="editproduct.php" method="GET">
                  <input type="hidden" name="id" value="<?= $product['id'] ?>">
                  <button class="bg-yellow-500 px-3 py-1 rounded hover:bg-yellow-400 text-black">Edit</button>
                </form>
                <form action="deleteproduct.inc.php" method="POST" onsubmit="return confirm('Are you sure?');">
                  <input type="hidden" name="id" value="<?= $product['id'] ?>">
                  <button class="bg-red-600 px-3 py-1 rounded hover:bg-red-500">Delete</button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
