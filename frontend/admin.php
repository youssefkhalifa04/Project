<?php
session_start();
require_once '../backend/dbh.inc.php';

try {
    $stmt = $pdo->prepare("SELECT * FROM products");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

if (isset($_GET["addproduct"]) && $_GET["addproduct"] === "success") {
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
            const url = new URL(window.location.href);
            url.searchParams.delete('addproduct');
            window.history.replaceState({}, document.title, url.toString());
        });
    </script>";
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Product</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-900 text-white">
  <div class=" flex ">
    <aside class="w-64 bg-gray-800 p-6 hidden md:block fixed left-0 top-0 bottom-0">
      <h2 class="text-2xl font-bold mb-8 mt-10">Admin Panel</h2>
      <nav class="space-y-4">
        <a href="#addProduct" class="block text-gray-300 hover:text-white  font-bold">Products</a>
        <a href="./orders.php" class="block text-gray-300 hover:text-white ">orders</a>
        <a href="./acceptedorders.php" class="block text-gray-300 hover:text-white ">In Progress..</a>
        <a href="./donesells.php" class="block text-gray-300 hover:text-white ">Done</a>
        
      </nav>
    </aside>
    

<div class="fixed md:hidden left-0 right-0 top-0 h-10 bg-gray-900 py-4">
    <div class="md:hidden fixed right-4 top-2  ">
              <button id="menu-btn1" class="text-white focus:outline-none ">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                  viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
              </button>
            </div>
    </div>
        <a href="../index.php" class=" fixed top-2  left-4 mb-10  hover:text-red-800 ">
      Back
    </a>
</div>

   


   <nav class="bg-gray-900  shadow-md sticky top-10 z-50">
          <!-- Mobile Menu -->
          <div id="mobile-menu1" class="flex itmes-center justify-around md:hidden  px-4 pb-4">     <a href="./admin.php" class="block py-2 text-white hover:text-blue-600">Products</a>
            <a href="./orders.php" class="block py-2 text-white hover:text-blue-600">Orders</a> 
            <a href="./acceptedorders.php" class="block py-2 text-white hover:text-blue-600">In Progress ...</a>
            <a href="./donesells.php" class="block py-2 text-white hover:text-blue-600">Done</a>
                
          </div>
    </nav>






    <main class="flex-1 p-10 md:ml-64">
    
    
      <!-- Add Product -->
      <section id="addProduct" class="mb-12 pt-4">
      <a href="../index.php" class="hidden md-flex inline-block mb-6 bg-blue-600 px-4 py-2 rounded hover:bg-blue-500">
      ← Back
    </a>
  





    









        <h3 class="text-xl font-semibold mb-4 mt-2">Add New Product</h3>
        <form action="../backend/addproduct.inc.php" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-md space-y-4">
          <input type="text" name="name" placeholder="Product Name" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded" />
          <input type="number" name="price" placeholder="Price" step="0.01" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded" />
          <input type="number" name="quantity" placeholder="Stock Quantity" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded" />
          <textarea name="description" placeholder="Description" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded"></textarea>
          <input type="file" name="image" accept="image/*" required onchange="previewImage(event)" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded cursor-pointer" />
          <div id="imagePreview" class="mt-4">
            <img id="preview" src="" class="max-h-48 rounded border border-gray-600 hidden" />
          </div>
          <button type="submit" class="bg-indigo-600 px-4 py-2 rounded hover:bg-indigo-500">Products</button>
        </form>
      </section>

      <!-- Product List -->
      <section id="productList">
        <h3 class="text-xl font-semibold mb-4">Product List</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($products as $product): ?>
            <div class="bg-gray-800 p-4 rounded-lg shadow-md">
              <img src="<?= htmlspecialchars($product['image']) ?>" class="rounded mb-3 h-48 w-full object-cover" alt="Product Image" />
              <h4 class="text-lg font-bold"><?= htmlspecialchars($product['name']) ?></h4>
              <p class="text-sm text-gray-400">$<?= number_format($product['price'], 2) ?></p>
              <p class="mt-2 text-gray-300"><?= htmlspecialchars($product['description']) ?></p>
              <div class="mt-4 flex gap-2">
                <form action="editproduct.php" method="GET">
                  <input type="hidden" name="id" value="<?= $product['id'] ?>">
                  <button class="bg-yellow-500 px-3 py-1 rounded hover:bg-yellow-400 text-black">Edit</button>
                </form>
                <form class="delete-form" action="../backend/deleteproduct.inc.php" method="POST">
                  <input type="hidden" name="id" value="<?= $product['id'] ?>">
                  <button type="submit" class="bg-red-600 px-3 py-1 rounded hover:bg-red-500">Delete</button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    </main>
  </div>

  <script>
    function previewImage(event) {
      const file = event.target.files[0];
      const preview = document.getElementById('preview');
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
          preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
      }
    }

    // SweetAlert2 Delete Confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
          title: 'Are you sure?',
          text: 'This product will be deleted permanently.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#e3342f',
          cancelButtonColor: '#6b7280',
          confirmButtonText: 'Yes, delete it!',
          customClass: {
            popup: 'rounded-lg shadow-lg'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  </script>
  <script>
      document.getElementById('menu-btn1').addEventListener('click', () => {
        const menu = document.getElementById('mobile-menu1');
        if (menu.classList.contains('hidden')) {
          menu.classList.remove('hidden');
        } else {
          menu.classList.add('hidden');
        }
      });
    </script>
</body>
</html>
