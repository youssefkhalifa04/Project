<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-blue-200 min-h-screen flex items-center justify-center">

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

    

    <div class="bg-white p-8 rounded-lg shadow-lg w-96 ">
        <h2 class="text-2xl font-semibold text-center mb-6">Sign Up</h2>
        <form action="../backend/signup.inc.php" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <div class="mb-4">
                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirmPassword" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">Sign Up</button>
            <p class="text-center text-gray-600">Already have an account? <a href="./login.php" class="text-blue-600 hover:underline">Login</a></p>
        </form>
    </div>

</body>


</html>
