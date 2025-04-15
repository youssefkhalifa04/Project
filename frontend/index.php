<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vape Bliss</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="styles.css">
  </head>

  <body class="bg-gray-50">
    
  <?php
    session_start();
    require_once '../backend/dbh.inc.php'; // This gives you $pdo
    
    try {
        $sql = "SELECT * FROM products";
        $stmt = $pdo->prepare($sql); // use $pdo here
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC); // PDO fetch
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
            // Clear the URL parameters after showing alert
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
            // Clear the URL parameters after showing alert
            if (window.history.replaceState) {
                const url = new URL(window.location.href);
                url.searchParams.delete('signup');
                window.history.replaceState({}, document.title, url.toString());
            }
        });
    </script>";
}
?>
    
    <section class="h-screen to-gray-200 text-white">
      <div
        class="container mx-auto text-center h-screen bg-[url(./assets/bg.png)] bg-cover bg-center"
      >
        <nav
          class="bg-transparent text-white p-6 shadow-lg h-16 flex items-center px-10 sticky top-0 left-0 right-0 px-8"
        >
          <div class="container mx-auto px-10 flex justify-between items-center">
            <a href="#" class="text-3xl font-extrabold">Vape Bliss</a>
            <div class="space-x-8">
            <?php 
          
          if (isset($_SESSION["username"]) && $_SESSION["username"] == "admin") {
            echo '<a href="./admin.php" class="text-lg hover:text-indigo-200 transition-colors">Admin</a>';
        }
        
        ?>
              <a
                href="./index.php"
                class="text-lg hover:text-indigo-200 transition-colors"
                >Home</a
              >
              <a
                href="./vapes.php"
                class="text-lg hover:text-indigo-200 transition-colors"
                >Vapes</a
              >
              <?php 
               
                if (isset($_SESSION["username"])) {
                echo '<a href="./cart.php" class="hover:text-indigo-200 text-lg">Cart</a>';
               }
               ?>
              <?php
              if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
                echo '<a href="../backend/logout.inc.php" class="text-lg hover:text-indigo-200 transition-colors">Logout</a>';
              } else {
                echo '<a href="./login.php"  class="text-lg hover:text-indigo-200 transition-colors">Login</a>';
              }
              ?>
            </div>
          </div>
        </nav>
        <div class="mt-28">
          <h1 class="text-5xl font-bold leading-tight">
            Vape Bliss - Your Perfect Puff
          </h1>
          <p class="mt-6 text-xl font-light">
            Explore our premium selection of one-use vapes for a smooth and
            effortless experience.
          </p>
          <a
            href="#products"
            class="mt-8 inline-block bg-indigo-700 text-white py-3 px-8 rounded-full text-lg font-semibold hover:bg-indigo-600 transition-colors"
            >Shop Now</a
          >
        </div>
      </div>
    </section>

    <!-- Featured Vapes Section -->
    <section id="products" class="container mx-auto py-20 px-8">
  <h2 class="text-4xl font-semibold text-center text-gray-800 mb-10">
    Featured Vapes
  </h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-12">
  <?php foreach ($products as $product): ?>
  <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Vape" class="h-64 w-full object-cover">
    <div class="p-5">
      <h3 class="text-xl font-semibold text-white mb-1"><?php echo htmlspecialchars($product['name']); ?></h3>
      <p class="text-gray-400 text-sm mb-3"><?php echo htmlspecialchars($product['description']); ?></p>
      <p class="text-indigo-400 font-bold mb-3">$<?php echo htmlspecialchars($product['price']); ?></p>
      <form action="../backend/addtocart.inc.php" method="POST">
  <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
  <input type="hidden" name="quantity" value="1">
  <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 transition">
    <a href="./vapes.php">Buy Now</a>
  </button>
</form>

    </div>
  </div>
<?php endforeach; ?>
  </div>
</section>


    <!-- Footer -->
    <footer
      class="bg-[url(./assets/bg.png)] to-blue-500 text-white py-6"
    >
      <div class="container mx-auto text-center">
        <p class="text-sm">&copy; 2025 Vape Bliss - All Rights Reserved</p>
      </div>
    </footer>
  </body>
</html>
