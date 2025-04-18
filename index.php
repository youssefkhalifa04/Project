<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vape Bliss</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="./output.css" />
  </head>

  <body class="bg-gray-50">
    <?php
    session_start();
    require_once './backend/dbh.inc.php';

    try {
        $sql = "SELECT * FROM products";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

    if (isset($_GET["login"]) && $_GET["login"] === "success") {
        echo "
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    title: 'Login Successful!',
                    text: 'Welcome, " . $_SESSION["username"] . " 😊',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'rounded-lg shadow-lg'
                    }
                });
                if (window.history.replaceState) {
                    const url = new URL(window.location.href);
                    url.searchParams.delete('login');
                    window.history.replaceState({}, document.title, url.toString());
                }
            });
        </script>";
    }

    if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo "
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    title: 'Signup Successful!',
                    text: 'Welcome, " . $_SESSION["username"] . " 😊',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'rounded-lg shadow-lg'
                    }
                });
                if (window.history.replaceState) {
                    const url = new URL(window.location.href);
                    url.searchParams.delete('signup');
                    window.history.replaceState({}, document.title, url.toString());
                }
            });
        </script>";
    }
    ?>

    <section class="h-screen text-white">
      <div class="container mx-auto text-center h-screen bg-[url(./frontend/assets/bg.png)] bg-cover bg-center">

        <!-- Navbar -->
        <nav class="bg-gray-900 shadow-md sticky top-0 z-50">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <div class="text-2xl font-bold text-white">
              Vape Store
            </div>

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
                  echo '<a href="./backend/logout.inc.php" class="text-white hover:text-blue-600 transition">Logout</a>';
                } else {
                  echo '<a href="./frontend/login.php" class="text-white hover:text-blue-600 transition">Login</a>';
                }
              ?>
            </div>

            <!-- Mobile Hamburger -->
            <div class="md:hidden">
              <button id="menu-btn" class="text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                  viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
              </button>
            </div>
          </div>

          <!-- Mobile Menu -->
          <div id="mobile-menu" class="md:hidden hidden px-4 pb-4">
            <?php 
              if (isset($_SESSION["username"]) && $_SESSION["username"] == "admin") {
                echo '<a href="./frontend/admin.php" class="block py-2 text-white hover:text-blue-600">Admin</a>';
              }
            ?>
            <a href="./index.php" class="block py-2 text-white hover:text-blue-600">Home</a>
            <a href="./frontend/vapes.php" class="block py-2 text-white hover:text-blue-600">Store</a>
            <?php 
              if (isset($_SESSION["username"]) && $_SESSION["username"] !== "admin") {
                echo '<a href="./frontend/cart.php" class="block py-2 text-white hover:text-blue-600">Cart</a>';
              }
            ?>
            <?php
              if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
                echo '<a href="./backend/logout.inc.php" class="block py-2 text-white hover:text-blue-600">Logout</a>';
              } else {
                echo '<a href="./frontend/login.php" class="block py-2 text-white hover:text-blue-600">Login</a>';
              }
            ?>
          </div>
        </nav>

        <!-- Hero Section -->
        <div class="mt-28">
          <h1 class="text-5xl font-bold leading-tight">
            Vape Bliss - Your Perfect Puff
          </h1>
          <p class="mt-6 text-xl font-light">
            Explore our premium selection of one-use vapes for a smooth and effortless experience.
          </p>
          <a href="#products" class="mt-8 inline-block bg-indigo-700 text-white py-3 px-8 rounded-full text-lg font-semibold hover:bg-indigo-600 transition-colors">
            Shop Now
          </a>
        </div>
      </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="container mx-auto py-20 px-8">
      <h2 class="text-4xl font-semibold text-center text-gray-800 mb-10">Featured Vapes</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-12">
        <?php foreach ($products as $product): ?>
        <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
          <img src="<?= substr($product['image'], 1); ?>" alt="Vape" class="h-64 w-full object-cover">
          <div class="p-5">
            <h3 class="text-xl font-semibold text-white mb-1"><?= htmlspecialchars($product['name']); ?></h3>
            <p class="text-gray-400 text-sm mb-3"><?= htmlspecialchars($product['description']); ?></p>
            <p class="text-indigo-400 font-bold mb-3">$<?= htmlspecialchars($product['price']); ?></p>
            <form action="../backend/addtocart.inc.php" method="POST">
              <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
              <input type="hidden" name="quantity" value="1">
              <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 transition">
                Buy Now
              </button>
            </form>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[url(./frontend/assets/bg.png)] to-blue-500 text-white py-6">
      <div class="container mx-auto text-center">
        <p class="text-sm">&copy; 2025 Vape Bliss - All Rights Reserved</p>
      </div>
    </footer>

    <!-- Toggle Menu Script -->
    <script>
      document.getElementById('menu-btn').addEventListener('click', () => {
        const menu = document.getElementById('mobile-menu');
        if (menu.classList.contains('hidden')) {
          menu.classList.remove('hidden');
        } else {
          menu.classList.add('hidden');
        }
      });
    </script>
  </body>
</html>
