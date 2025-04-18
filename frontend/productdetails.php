<?php
session_start();
require_once("../backend/dbh.inc.php");

$productId = $_GET["id"] ;


$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "<h1 class='text-center text-3xl text-red-500 mt-10'>Product not found</h1>";
    exit();
}

$img = substr($product["image"], 12);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product["name"]) ?> | VapeVerse</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-white min-h-screen font-sans">
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
        <button id="menu-btn7" class="text-white focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu7" class="md:hidden hidden flex flex-col justify-center px-4 pb-4">
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
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid md:grid-cols-2 gap-12 bg-gray-900 rounded-3xl shadow-2xl overflow-hidden">

            <!-- Product Image Section -->
            <div class="relative bg-gray-800 flex items-center justify-center p-10">
                <img src="<?= $img ?>" alt="<?= htmlspecialchars($product["name"]) ?>" class="rounded-2xl max-h-[480px] object-contain transition-transform duration-300 hover:scale-105">
                <div class="absolute bottom-4 right-4 bg-purple-600 px-3 py-1 text-sm rounded-full font-medium"><?= htmlspecialchars($product["name"]) ?></div>
            </div>

            <!-- Product Info Section -->
            <div class="p-10 flex flex-col justify-between space-y-8">
                <div>
                    <h1 class="text-4xl font-extrabold text-white leading-snug"><?= htmlspecialchars($product["name"]) ?></h1>
                    <p class="mt-4 text-lg text-gray-300 leading-relaxed"><?= htmlspecialchars($product["description"]) ?></p>
                </div>

                <div class="space-y-4">
                    <div class="text-3xl font-bold text-purple-400">$<?= htmlspecialchars($product["price"]) ?></div>
                    <div class="flex items-center gap-6 text-sm text-gray-400">
                        <span>Stock: <strong class="text-white"><?= htmlspecialchars($product["stock_quantity"]) ?></strong></span>
                    </div>
                    <form action="../backend/addtocart.inc.php" method="POST" class="mt-6">
                        <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-6 rounded-xl font-semibold text-lg shadow-lg transition-all duration-300">
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.getElementById('menu-btn7').addEventListener('click', () => {
      const menu = document.getElementById('mobile-menu7');
      menu.classList.toggle('hidden');
    });
  </script>
</body>
</html>

