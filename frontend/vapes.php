<?php
  session_start();
  if (isset($_GET["added"]) && $_GET["added"] === "success") {
    echo "
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

        // Correct the parameter name here
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>
<body class="bg-gray-50 text-gray-200">

  <!-- Navbar -->
  <nav class="bg-gray-800 shadow-md p-4 sticky top-0 z-10">
    <div class="container mx-auto px-10 flex justify-between items-center">
      <a href="./index.php" class="text-2xl font-bold text-indigo-400">Vape Bliss</a>
      <div class="space-x-6">
      <?php 
          
          if (isset($_SESSION["username"]) && $_SESSION["username"] === "admin") {
            echo '<a
            href="./admin.php"
            class="text-lg hover:text-indigo-200 transition-colors"
            >Admin</a
          >';
        }
        ?>
        <a href="./index.php" class="text-lg hover:text-indigo-300">Home</a>
        <a href="./vapes.php" class="text-lg hover:text-indigo-300 font-semibold">Vapes</a>
        <?php 
          
          if (isset($_SESSION["username"])) {
            echo '<a href="./cart.php" class="text-lg hover:text-indigo-300">Cart</a>';
          }
        ?>
        <?php
        
          if (isset($_SESSION["username"])) {
            echo '<a href="../backend/logout.inc.php" class="text-lg hover:text-red-400">Logout</a>';
          } else {
            echo '<a href="./login.php" class="text-lg hover:text-indigo-300">Login</a>';
          }

         
         
          require_once '../backend/dbh.inc.php'; // This gives you $pdo

          try {
              $sql = "SELECT * FROM products";
              $stmt = $pdo->prepare($sql); // use $pdo here
              $stmt->execute();
              $products = $stmt->fetchAll(PDO::FETCH_ASSOC); // PDO fetch
          } catch (PDOException $e) {
              die("Query failed: " . $e->getMessage());
          }

        ?>
      </div>
    </div>
  </nav>

  <!-- Page Header -->
  <header class="bg-gradient-to-r from-gray-800 to-gray-700 py-16 text-center">
    <h1 class="text-4xl font-bold text-white mb-2">Our Full Collection</h1>
    <p class="text-gray-300 text-lg">Explore all our premium one-use vapes</p>
  </header>

  <!-- Products Grid -->
  <main class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
      
      <!-- Sample Product Card -->
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
    Buy Now
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

</body>
</html>
