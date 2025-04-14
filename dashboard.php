<?php
include_once "role-validation.php";
require_once "db_connection.php";

$response = [];

// Get top 5 selling products
$topSellingQuery = "
    SELECT p.name AS product_name, SUM(ti.quantity) AS total_quantity
    FROM transaction_items ti
    JOIN products p ON ti.product_id = p.id
    GROUP BY p.name
    ORDER BY total_quantity DESC
    LIMIT 5
";
$topSellingResult = $conn->query($topSellingQuery);
$topSellingProducts = $topSellingResult->fetch_all(MYSQLI_ASSOC);

// Get daily revenue
$dailyRevenueQuery = "
    SELECT SUM(t.total_amount) AS daily_revenue
    FROM transactions t
    WHERE DATE(t.transaction_date) = CURDATE()
";
$dailyRevenueResult = $conn->query($dailyRevenueQuery);
$dailyRevenue = $dailyRevenueResult->fetch_assoc()['daily_revenue'] ?? 0;

// Get total items sold today
$totalItemsSoldQuery = "
    SELECT SUM(ti.quantity) AS total_items_sold
    FROM transaction_items ti
    JOIN transactions t ON ti.transaction_id = t.id
    WHERE DATE(t.transaction_date) = CURDATE()
";
$totalItemsSoldResult = $conn->query($totalItemsSoldQuery);
$totalItemsSold = $totalItemsSoldResult->fetch_assoc()['total_items_sold'] ?? 0;

// Get low stock products (stock < 10, ascending order)
$lowStockQuery = "
    SELECT 
        name AS product_name,
        stock,
        size,
        color
    FROM products
    WHERE stock < 10
    ORDER BY stock ASC
    LIMIT 5
";
$lowStockResult = $conn->query($lowStockQuery);
$lowStockProducts = $lowStockResult->fetch_all(MYSQLI_ASSOC);

// Get 5 recently sold products
$recentlySoldQuery = "
    SELECT t.transaction_date, CONCAT(u.first_name, ' ', u.last_name) AS customer, p.name AS product_name, p.size, p.color, ti.quantity, ti.item_total_price
    FROM transaction_items ti
    JOIN transactions t ON ti.transaction_id = t.id
    JOIN users u ON t.user_id = u.id
    JOIN products p ON ti.product_id = p.id
    ORDER BY t.transaction_date DESC
    LIMIT 5
";
$recentlySoldResult = $conn->query($recentlySoldQuery);
$recentlySoldProducts = $recentlySoldResult->fetch_all(MYSQLI_ASSOC);

$weeklyRevenueQuery = "
    SELECT 
        YEARWEEK(transaction_date, 1) AS year_week,
        DATE_FORMAT(MIN(transaction_date), '%Y-%m-%d') AS week_start,
        DATE_FORMAT(MAX(transaction_date), '%Y-%m-%d') AS week_end,
        SUM(total_amount) AS weekly_revenue
    FROM transactions
    WHERE transaction_date >= DATE_SUB(CURDATE(), INTERVAL 2 MONTH)
    GROUP BY year_week
    ORDER BY year_week ASC
";
$weeklyRevenueResult = $conn->query($weeklyRevenueQuery);
$weeklyRevenueData = $weeklyRevenueResult->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metro District Designs - Sales Record</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            background-color: #1E1E1E;
            color: white;
            min-height: 100vh;
            padding-top: 20px;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
        }
        
        .sidebar-link {
            color: #f8f9fa;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-link:hover, .sidebar-link.active {
            background-color: #333333;
            border-left: 4px solid #0d6efd;
        }
        
        .sidebar-link i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .breadcrumb-container {
            padding: 10px 0;
            margin-bottom: 20px;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .card {
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .card-header {
            background-color: #212529;
            color: white;
            border-radius: 0 !important;
            font-weight: bold;
        }
        
        .card-header h5 {
            margin-bottom: 0;
        }
        
        .table-dark {
            background-color: #212529;
        }
        
        .chart-container {
            height: 150px;
        }
        
        /* Logo in sidebar */
        .logo-container {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #333;
        }
        
        .logo {
            width: 40px;
            height: 40px;
            margin-right: 10px;
            border-radius: 50%;
        }
        
        .brand-name {
            color: white;
            font-weight: bold;
            font-size: 18px;
            margin: 0;
        }
        
        .action-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            margin: 0 2px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .delete-btn {
            background-color: #dc3545;
            color: white;
        }
        
        .delete-btn:hover {
            background-color: #bb2d3b;
        }
        
        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                position: static;
                width: 100%;
                min-height: auto;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
<!-- Main Container with Sidebar -->
<div class="container-fluid p-0">
    <div class="row g-0">
        <!-- Sidebar -->
        <div class="col-auto">
            <div class="sidebar">
                <div class="logo-container">
                    <img src="/api/placeholder/40/40" class="logo" alt="Logo">
                    <h5 class="brand-name">Metro District Designs</h5>
                </div>
                <a href="dashboard.php" class="sidebar-link active">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="product-stock.php" class="sidebar-link">
                    <i class="fas fa-box"></i> Product Stock
                </a>
                <!-- Changed "Sales Record" to "Homepage Editor" and icon to edit icon -->
                <a href="admin-homepage-editor.php" class="sidebar-link">
                    <svg width="20" height="20" viewBox="0 0 1024 1024" fill="currentColor" style="margin-right: 15px;">
                        <<path d="M880 836H144c-17.7 0-32 14.3-32 32v36c0 4.4 3.6 8 8 8h784c4.4 0 8-3.6 8-8v-36c0-17.7-14.3-32-32-32zm-622.3-84c2 0 4-.2 6-.5L431.9 722c2-.4 3.9-1.3 5.3-2.8l423.9-423.9c3.9-3.9 3.9-10.2 0-14.1L694.9 114.9c-1.9-1.9-4.4-2.9-7.1-2.9s-5.2 1-7.1 2.9L256.8 538.8c-1.5 1.5-2.4 3.3-2.8 5.3l-29.5 168.2a33.5 33.5 0 0 0 33.2 39.7z"/>
                    </svg> Homepage Editor
                </a>
                <a href="user-admin.php" class="sidebar-link">
                    <i class="fas fa-users"></i> Account Manager
                </a>
                <a href="profile.php" class="sidebar-link">
                    <i class="fas fa-user-cog"></i> Profile
                </a>
                <a href="index.php" class="sidebar-link">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="logout.php" class="sidebar-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="col">
            <div class="main-content">
                <!-- Breadcrumb -->
                <div class="breadcrumb-container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Title -->
                <div class="page-title">
                    <span>Dashboard</span>
                </div>
                
                <div class="row">
                    <!-- Top Selling Product -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Top Selling Product</h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Rank#</th>
                                            <th>Product Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $index = 1 ?>
                                        <?php foreach($topSellingProducts as $topSeller): ?>
                                            <tr>
                                                <td><?php echo $index; $index++; ?></td>
                                                <td><?php echo $topSeller['product_name'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Most Sold Products -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Most Sold Products</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="mostSoldProductsChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Weekly Revenue -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Weekly Revenue</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="weeklyRevenueChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <!-- Daily Revenue -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Daily Revenue</h5>
                            </div>
                            <div class="card-body">
                                <h3>₱<?php echo $dailyRevenue; ?></h3>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Items Sold -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Items Sold</h5>
                            </div>
                            <div class="card-body">
                                <h3><?php echo $totalItemsSold ?> Items</h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Low Stock Products -->
                <div class="card">
                    <div class="card-header">
                        <h5>Low Stock Products</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($lowStockProducts as $lowStockProduct): ?>
                                    <tr>
                                        <td><?php echo $lowStockProduct['product_name']; ?></td>
                                        <td><?php echo $lowStockProduct['size']; ?></td>
                                        <td><?php echo $lowStockProduct['color']; ?></td>
                                        <td><?php echo $lowStockProduct['stock']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Recently Sold Products -->
                <div class="card">
                    <div class="card-header">
                        <h5>Recently Sold Products</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($recentlySoldProducts as $recentlySoldProduct): ?>
                                    <tr>
                                        <td><?php echo date("M j, Y", strtotime($recentlySoldProduct['transaction_date'])) ?></td>
                                        <td><?php echo $recentlySoldProduct['customer'] ?></td>
                                        <td><?php echo $recentlySoldProduct['product_name'] ?></td>
                                        <td><?php echo $recentlySoldProduct['size'] ?></td>
                                        <td><?php echo $recentlySoldProduct['color'] ?></td>
                                        <td><?php echo $recentlySoldProduct['quantity'] ?></td>
                                        <td>₱<?php echo $recentlySoldProduct['item_total_price'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Functionality -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- Update current date and time script -->
<script>
    function updateDateTime() {
        const now = new Date();
        const options = { 
            year: 'numeric', 
            month: 'short', 
            day: '2-digit',
            hour: '2-digit', 
            minute: '2-digit',
            hour12: true
        };
        
        if (document.getElementById('current-datetime')) {
            document.getElementById('current-datetime').textContent = now.toLocaleDateString('en-US', options);
        }
    }
    
    // Update initially and then every minute
    updateDateTime();
    setInterval(updateDateTime, 60000);
</script>
<script>
    // Data from PHP
    const topSellingProducts = <?php echo json_encode($topSellingProducts); ?>;
    const weeklyRevenueData = <?php echo json_encode($weeklyRevenueData); ?>;

    // Prepare data for Most Sold Products (Bar Chart)
    const mostSoldLabels = topSellingProducts.map(product => product.product_name);
    const mostSoldQuantities = topSellingProducts.map(product => product.total_quantity);

    // Render Most Sold Products Chart
    const mostSoldCtx = document.getElementById('mostSoldProductsChart').getContext('2d');
    new Chart(mostSoldCtx, {
        type: 'bar',
        data: {
            labels: mostSoldLabels,
            datasets: [{
                label: 'Most Sold Products',
                data: mostSoldQuantities,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Prepare data for Weekly Revenue (Line Chart)
    const weeklyLabels = weeklyRevenueData.map(week => `${week.week_start} - ${week.week_end}`);
    const weeklyRevenues = weeklyRevenueData.map(week => week.weekly_revenue);

    // Render Weekly Revenue Chart
    const weeklyRevenueCtx = document.getElementById('weeklyRevenueChart').getContext('2d');
    new Chart(weeklyRevenueCtx, {
        type: 'line',
        data: {
            labels: weeklyLabels,
            datasets: [{
                label: 'Weekly Revenue (₱)',
                data: weeklyRevenues,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>
</html>