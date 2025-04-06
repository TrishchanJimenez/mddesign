<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metro District Designs - Sales Record</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #212529;
            --accent-color: #dc3545;
            --background-color: #ffffff;
            --text-color: #333;
            --light-border: #dee2e6;
        }
        
        body {
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }
        
        .navbar-brand {
            font-weight: bold;
            color: white !important;
        }
        
        .sidebar {
            background-color: var(--primary-color);
            min-height: calc(100vh - 70px);
            padding-top: 20px;
            color: white;
            position: sticky;
            top: 0;
        }
        
        .sidebar-link {
            color: rgba(255,255,255,0.8);
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
            margin: 5px 0;
        }
        
        .sidebar-link:hover, .sidebar-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
            border-left-color: var(--accent-color);
        }
        
        .sidebar-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            background-color: var(--background-color);
            color: var(--text-color);
            min-height: calc(100vh - 56px);
            padding: 20px;
        }
        
        .card {
            margin-bottom: 20px;
            border-radius: 0.5rem;
            border: 1px solid var(--light-border);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 0 !important;
            font-weight: bold;
        }
        
        .card-header h5 {
            margin-bottom: 0;
        }
        
        .table-dark {
            background-color: var(--primary-color);
        }
        
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 20px;
        }
        
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .breadcrumb-item a:hover {
            color: var(--accent-color);
        }
        
        .chart-container {
            height: 150px;
        }
        
        .header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .logo-container {
            display: flex;
            align-items: center;
        }
        
        .logo {
            width: 40px;
            height: 40px;
            margin-right: 15px;
            border-radius: 50%;
            background-color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px solid white;
        }
        
        .brand-text {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
        }
        
        .sidebar-footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            color: rgba(255,255,255,0.6);
            padding: 0 15px;
            font-size: 0.8rem;
        }
        
        .user-button {
            background-color: transparent;
            border: 1px solid white;
            color: white;
        }
        
        .user-button:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
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
            background-color: var(--accent-color);
            color: white;
        }
        
        .delete-btn:hover {
            background-color: #bb2d3b;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                position: static;
            }
            
            .sidebar-footer {
                position: static;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar d-none d-md-block">
                <div class="p-3">
                    <div class="logo-container mb-4">
                        <div class="logo">
                            <img src="/api/placeholder/40/40" alt="Metro District Logo" />
                        </div>
                        <span class="brand-text">Metro District</span>
                    </div>
                </div>
                <nav class="mt-3">
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-box"></i> Product Stock
                    </a>
                    <a href="#" class="sidebar-link active">
                        <i class="fas fa-chart-line"></i> Sales Record
                    </a>
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-user-cog"></i> Account Manager
                    </a>
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-user-circle"></i> Profile
                    </a>
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-home"></i> Home
                    </a>
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
                <div class="sidebar-footer">
                    <p>Apr 06, 2025, 11:56 PM</p>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <!-- Header for mobile only -->
                <header class="header d-md-none">
                    <div class="container">
                        <div class="logo-container">
                            <div class="logo">
                                <img src="/api/placeholder/40/40" alt="Metro District Logo" />
                            </div>
                            <h1 class="brand-text">Metro District Designs</h1>
                        </div>
                    </div>
                </header>
                
                <!-- Navigation breadcrumb -->
                <nav class="bg-light border-bottom">
                    <div class="container-fluid">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Sales Record</li>
                            </ol>
                        </nav>
                    </div>
                </nav>
                
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
                                        <tr>
                                            <td>1</td>
                                            <td>BLACK LITE 8000</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>FLAVA XTRE 10000</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>SHIFT X Chillax Vista 15000</td>
                                        </tr>
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
                                <div class="text-center">
                                    <h6 class="mb-3">Most Sold Product</h6>
                                    <div class="chart-container">
                                        <div class="row justify-content-center h-100">
                                            <div class="col-3">
                                                <div class="bg-primary h-100 w-100" style="height: 80% !important;"></div>
                                            </div>
                                            <div class="col-3">
                                                <div class="bg-success h-100 w-100" style="height: 60% !important;"></div>
                                            </div>
                                            <div class="col-3">
                                                <div class="bg-danger h-100 w-100" style="height: 40% !important;"></div>
                                            </div>
                                            <div class="col-3">
                                                <div class="bg-info h-100 w-100" style="height: 30% !important;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-muted small mt-2">Chart data visualization</div>
                                </div>
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
                                <div class="text-center">
                                    <h6 class="mb-3">Weekly Revenue</h6>
                                    <div class="chart-container" id="weekly-revenue-chart">
                                        <!-- Line chart would be rendered here -->
                                        <svg viewBox="0 0 300 100" class="w-100 h-100">
                                            <polyline
                                                fill="none"
                                                stroke="#0d6efd"
                                                stroke-width="2"
                                                points="0,50 50,20 100,60 150,30 200,20 250,35 300,50"
                                            />
                                            <circle cx="0" cy="50" r="3" fill="#0d6efd" />
                                            <circle cx="50" cy="20" r="3" fill="#0d6efd" />
                                            <circle cx="100" cy="60" r="3" fill="#0d6efd" />
                                            <circle cx="150" cy="30" r="3" fill="#0d6efd" />
                                            <circle cx="200" cy="20" r="3" fill="#0d6efd" />
                                            <circle cx="250" cy="35" r="3" fill="#0d6efd" />
                                            <circle cx="300" cy="50" r="3" fill="#0d6efd" />
                                        </svg>
                                    </div>
                                    <div class="text-muted small mt-2">Chart data visualization</div>
                                </div>
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
                                <h3>₱2450.00</h3>
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
                                <h3>24 Items</h3>
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
                                    <th>Customer Name</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Kai Sotto</td>
                                    <td>BLACK Elite 8000</td>
                                    <td>1</td>
                                    <td>
                                        <button class="action-btn delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
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
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Apr 06, 2025</td>
                                    <td>John Smith</td>
                                    <td>BLACK LITE 8000</td>
                                    <td>2</td>
                                    <td>₱1600.00</td>
                                    <td>
                                        <button class="action-btn delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Apr 05, 2025</td>
                                    <td>Maria Garcia</td>
                                    <td>FLAVA XTRE 10000</td>
                                    <td>1</td>
                                    <td>₱850.00</td>
                                    <td>
                                        <button class="action-btn delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center">
            <small>&copy; 2025 Metro District Designs. All rights reserved.</small>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>