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
          class="bg-transparent text-white p-6 shadow-lg h-16 flex items-center px-8 sticky top-0 left-0 right-0 px-8"
        >
          <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-3xl font-extrabold">Vape Bliss</a>
            <div class="space-x-8">
            <?php 
          
          if (isset($_SESSION["username"])) {
            echo '<a
            href="./admin.php"
            class="text-lg hover:text-indigo-200 transition-colors"
            >Admin</a
          >';
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
      <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-12"
      >
        <!-- Vape 1 -->
        <div
          class="bg-white rounded-xl shadow-lg overflow-hidden hover:scale-105 cursor-pointer transition-transform"
        >
          <img
            src="./assets/vape1.jpg"
            alt="Vape 1"
            class="w-full h-64 object-cover"
          />
          <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-800">VaporWave</h3>
            <p class="text-gray-500 mt-2">
              A smooth, refreshing flavor that takes you to a new level of
              relaxation.
            </p>
            <p class="mt-4 text-xl font-semibold text-gray-800">$14.99</p>
            <a
              href="#"
              class="mt-4 inline-block bg-indigo-600 text-white py-2 px-6 rounded-full text-sm font-semibold hover:bg-indigo-500 transition-colors"
              >Buy Now</a
            >
          </div>
        </div>

        <!-- Vape 2 -->
        <div
          class="bg-white rounded-xl shadow-lg overflow-hidden hover:scale-105 cursor-pointer transition-transform"
        >
          <img
            src="./assets/vape2.jpg"
            alt="Vape 2"
            class="w-full h-64 object-cover"
          />
          <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-800">CloudNine</h3>
            <p class="text-gray-500 mt-2">
              A vibrant mix of tropical fruit flavors, perfect for a refreshing
              escape.
            </p>
            <p class="mt-4 text-xl font-semibold text-gray-800">$15.49</p>
            <a
              href="#"
              class="mt-4 inline-block bg-indigo-600 text-white py-2 px-6 rounded-full text-sm font-semibold hover:bg-indigo-500 transition-colors"
              >Buy Now</a
            >
          </div>
        </div>

        <!-- Vape 3 -->
        <div
          class="bg-white rounded-xl shadow-lg overflow-hidden hover:scale-105 cursor-pointer transition-transform"
        >
          <img
            src="./assets/vape3.jpg"
            alt="Vape 3"
            class="w-full h-64 object-cover"
          />
          <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-800">ZenPuff</h3>
            <p class="text-gray-500 mt-2">
              A relaxing, smooth experience with a hint of mint and green tea.
            </p>
            <p class="mt-4 text-xl font-semibold text-gray-800">$13.99</p>
            <a
              href="#"
              class="mt-4 inline-block bg-indigo-600 text-white py-2 px-6 rounded-full text-sm font-semibold hover:bg-indigo-500 transition-colors"
              >Buy Now</a
            >
          </div>
        </div>

        <!-- Vape 4 -->
        <div
          class="bg-white rounded-xl shadow-lg overflow-hidden hover:scale-105 cursor-pointer transition-transform"
        >
          <img
            src="./assets/vape4.jpg"
            alt="Vape 4"
            class="w-full h-64 object-cover"
          />
          <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-800">MysticMist</h3>
            <p class="text-gray-500 mt-2">
              A mysterious and smooth vape with hints of berry and eucalyptus.
            </p>
            <p class="mt-4 text-xl font-semibold text-gray-800">$16.99</p>
            <a
              href="#"
              class="mt-4 inline-block bg-indigo-600 text-white py-2 px-6 rounded-full text-sm font-semibold hover:bg-indigo-500 transition-colors"
              >Buy Now</a
            >
          </div>
        </div>
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
