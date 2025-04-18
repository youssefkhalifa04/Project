<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-blue-200 min-h-screen flex items-center justify-center">

  <div class="w-full max-w-sm bg-white rounded-2xl shadow-md p-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Login</h2>
    <form action="../backend/login.inc.php" method="POST" class="space-y-5">
      <div>
        <label class="block mb-1 text-sm font-medium text-gray-600">Username</label>
        <input type="text" name="username" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <div>
        <label class="block mb-1 text-sm font-medium text-gray-600">Password</label>
        <input type="password" name="password"  required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
        Sign In
      </button>
      <p class="text-center text-gray-600">Don't have an account? <a href="./signup.php" class="text-blue-600 hover:underline">Sign Up</a></p>
    </form>
  </div>

</body>
</html>
