<?php
session_start();
require_once '../backend/dbh.inc.php';

$whereClauses = ["status = 'completed'"];
$params = [];

if (!empty($_GET['min'])) {
    $whereClauses[] = "total_price >= ?";
    $params[] = $_GET['min'];
}

if (!empty($_GET['max'])) {
    $whereClauses[] = "total_price <= ?";
    $params[] = $_GET['max'];
}

$whereSQL = implode(" AND ", $whereClauses);
$sql = "SELECT order_date, total_price, user_id, articles FROM orders WHERE $whereSQL ORDER BY order_date ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$doneSells = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Summary data
$totalOrders = count($doneSells);
$totalSales = array_sum(array_column($doneSells, 'total_price'));
$averageSales = $totalOrders ? $totalSales / $totalOrders : 0;
$earliestDate = $totalOrders ? min(array_column($doneSells, 'order_date')) : null;
$latestDate = $totalOrders ? max(array_column($doneSells, 'order_date')) : null;

// Prepare data for chart
$salesPerDay = [];
foreach ($doneSells as $sale) {
    $date = substr($sale['order_date'], 0, 10); // get only Y-m-d
    $salesPerDay[$date] = ($salesPerDay[$date] ?? 0) + $sale['total_price'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Done Sells</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-900 text-white">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 p-6 hidden md:block fixed left-0 top-0 bottom-0">
            <h2 class="text-2xl font-bold mb-8">Admin Panel</h2>
            <nav class="space-y-4">
                <a href="./admin.php" class="block text-gray-300 hover:text-white">Add Product</a>
                <a href="./orders.php" class="block text-gray-300 hover:text-white">Orders</a>
                <a href="./acceptedorders.php" class="block text-gray-300 hover:text-white">Accepted Orders</a>
                <a href="#productList" class="block text-gray-300 hover:text-white font-bold">Done Sells</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 ml-64">
            <h2 class="text-2xl font-bold mb-6">🧾 Done Sells</h2>

            <!-- Filter Form -->
            <form method="GET" class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="number" name="min" value="<?= htmlspecialchars($_GET['min'] ?? '') ?>" placeholder="Min Price" class="p-2 rounded bg-gray-700 text-white placeholder-gray-400">
                <input type="number" name="max" value="<?= htmlspecialchars($_GET['max'] ?? '') ?>" placeholder="Max Price" class="p-2 rounded bg-gray-700 text-white placeholder-gray-400">
                <input type="text" name="category" class="hidden">
                <input type="number" name="userid" class="hidden">
                <div class="col-span-1 md:col-span-2 flex gap-4">
                    <button type="submit" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-500 transition">Filter</button>
                    <a href="donesells.php" class="bg-gray-600 px-4 py-2 rounded hover:bg-gray-500 transition">Clear Filter</a>
                </div>
            </form>

            <!-- Sales Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gray-800 p-4 rounded-lg shadow">
                    <h4 class="text-sm text-gray-400">Total Orders</h4>
                    <p class="text-xl font-bold"><?= $totalOrders ?></p>
                </div>
                <div class="bg-gray-800 p-4 rounded-lg shadow">
                    <h4 class="text-sm text-gray-400">Total Sales</h4>
                    <p class="text-xl font-bold text-green-400">$<?= number_format($totalSales, 2) ?></p>
                </div>
                <div class="bg-gray-800 p-4 rounded-lg shadow">
                    <h4 class="text-sm text-gray-400">Average Order</h4>
                    <p class="text-xl font-bold text-blue-400">$<?= number_format($averageSales, 2) ?></p>
                </div>
                <div class="bg-gray-800 p-4 rounded-lg shadow">
                    <h4 class="text-sm text-gray-400">Date Range</h4>
                    <p class="text-sm"><?= $earliestDate ?> ➝ <?= $latestDate ?></p>
                </div>
            </div>
            <!-- Chart -->
            <div class="bg-gray-800 p-6 rounded-lg shadow  mb-8">
                <h3 class="text-lg font-semibold mb-4 text-center">📈 Daily Sales Overview</h3>
                <canvas id="salesChart" height="100"></canvas>
            </div>
            <!-- Done Sales List -->
            <div class="space-y-4 mb-12">
                <?php if ($doneSells): ?>
                    <?php foreach ($doneSells as $sell): ?>
                        <div class="bg-gray-800 p-4 rounded-lg shadow flex justify-between items-center">
                            <div>
                                <span class="text-sm text-gray-400 block">User ID: <?= $sell['user_id'] ?></span>
                                <span class="text-sm text-gray-400 block">Articles: <?= htmlspecialchars($sell['articles']) ?></span>
                            </div>
                            <span class="text-sm text-gray-400"><?= htmlspecialchars($sell['order_date']) ?></span>
                            <span class="text-lg font-semibold text-green-300">$<?= number_format($sell['total_price'], 2) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-gray-400">No sales found with the selected filters.</p>
                <?php endif; ?>
            </div>

            
        </main>
    </div>

    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_keys($salesPerDay)) ?>,
                datasets: [{
                    label: 'Total Sales ($)',
                    data: <?= json_encode(array_values($salesPerDay)) ?>,
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#d1d5db'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#d1d5db'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffffff'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
