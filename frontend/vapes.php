<?php
session_start();

if (isset($_GET["added"]) && $_GET["added"] === "success") {
  echo "
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      Swal.fire({
        title: 'Product Added!',
        text: 'The product has been successfully added.',
        icon: 'success',
        confirmButtonText: 'Great!',
        customClass: {
          popup: 'rounded-lg shadow-lg'
        }
      });

      if (window.history.replaceState) {
        const url = new URL(window.location.href);
        url.searchParams.delete('added'); 
        window.history.replaceState({}, document.title, url.toString());
      }
    });
  </script>
  ";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>All Products - Vape Bliss</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-200">

  <!-- Navbar -->
  <nav class="bg-gray-900 shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
      <div class="text-2xl font-bold text-white">Vape Store</div>

      <!-- Desktop Menu -->
      <div class="hidden md:flex space-x-6 text-gray-700 font-medium">
        <?php 
          if (isset($_SESSION["username"]) && $_SESSION["username"] == "admin") {
            echo '<a href="./frontend/admin.php" class="text-white hover:text-blue-600 transition">Admin</a>';
          }
        ?>
        <a href="./index.php" class="text-white hover:text-blue-600 transition">Home</a>
        <a href="./frontend/vapes.php" class="text-white hover:text-blue-600 transition">Store</a>
        <?php 
          if (isset($_SESSION["username"]) && $_SESSION["username"] !== "admin") {
            echo '<a href="./frontend/cart.php" class="text-white hover:text-blue-600 transition">Cart</a>';
          }
        ?>
        <?php
          if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
            echo '<a href="../index.php" class="text-white hover:text-blue-600 transition">Logout</a>';
          } else {
            echo '<a href="./frontend/login.php" class="text-white hover:text-blue-600 transition">Login</a>';
          }
        ?>
      </div>

      <!-- Mobile Hamburger -->
      <div class="md:hidden">
        <button id="menu-btn6" class="text-white focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu6" class="md:hidden hidden flex flex-col justify-center px-4 pb-4">
      <center>
        <?php 
        if (isset($_SESSION["username"]) && $_SESSION["username"] == "admin") {
          echo '<a href="./admin.php" class="block py-2 text-white hover:text-blue-600">Admin</a>';
        }
      ?>
      <a href="../index.php" class="block py-2 text-white hover:text-blue-600">Home</a>
      <a href="./vapes.php" class="block py-2 text-white hover:text-blue-600">Store</a>
      <?php 
        if (isset($_SESSION["username"]) && $_SESSION["username"] !== "admin") {
          echo '<a href="./cart.php" class="block py-2 text-white hover:text-blue-600">Cart</a>';
        }
      ?>
      <?php
        if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
          echo '<a href="../index.php" class="block py-2 text-white hover:text-blue-600">Logout</a>';
        } else {
          echo '<a href="./login.php" class="block py-2 text-white hover:text-blue-600">Login</a>';
        }
      ?>
      </center>
    </div>
  </nav>

  <?php
    require_once '../backend/dbh.inc.php';

    try {
      $stmt = $pdo->prepare("SELECT * FROM products");
      $stmt->execute();
      $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      die("Query failed: " . $e->getMessage());
    }
  ?>

  <!-- Page Header -->
  <header class="bg-gradient-to-r from-gray-800 to-gray-700 py-16 text-center">
    <h1 class="text-4xl font-bold text-white mb-2">Our Full Collection</h1>
    <p class="text-gray-300 text-lg">Explore all our premium one-use vapes</p>
  </header>

  <!-- Products Grid -->
  <main class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
      <?php foreach ($products as $product): ?>
        <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
          <img src="<?= htmlspecialchars($product['image']) ?>" alt="Vape" class="h-64 w-full object-cover">
          <div class="p-5">
            <h3 class="text-xl font-semibold text-white mb-1"><?= htmlspecialchars($product['name']) ?></h3>
            <p class="text-gray-400 text-sm mb-3"><?= htmlspecialchars($product['description']) ?></p>
            <p class="text-indigo-400 font-bold mb-3">$<?= htmlspecialchars($product['price']) ?></p>
            <form action="../backend/addtocart.inc.php" method="POST">
              <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
              <input type="hidden" name="quantity" value="1">
              <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 transition">
                Buy Now
              </button>
              
            </form>
            <form action="../backend/details.inc.php" method="POST">
              <button type="submit" name="product_id" value="<?= $product['id'] ?>" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 transition">
                  Details
              </button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-800 py-6 border-t border-gray-700 mt-20">
    <div class="container mx-auto text-center text-gray-400">
      &copy; 2025 Vape Bliss — All rights reserved.
    </div>
  </footer>

  <!-- Toggle Mobile Menu Script -->
  <script>
    document.getElementById('menu-btn6').addEventListener('click', () => {
      const menu = document.getElementById('mobile-menu6');
      menu.classList.toggle('hidden');
    });
  </script>
</body>
</html>
