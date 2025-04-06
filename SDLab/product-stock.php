<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Metro District Designs - Product Inventory</title>
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
      font-family: 'Helvetica Neue', Arial, sans-serif;
      color: var(--text-color);
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
    
    .sidebar {
      background-color: var(--primary-color);
      color: white;
      min-height: calc(100vh - 70px);
      padding-top: 20px;
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
    
    .sidebar-footer {
      position: absolute;
      bottom: 20px;
      width: 100%;
      color: rgba(255,255,255,0.6);
      padding: 0 15px;
      font-size: 0.8rem;
    }
    
    .breadcrumb {
      margin-bottom: 0;
      padding: 0.75rem 0;
    }
    
    .page-header {
      margin: 1.5rem 0;
    }
    
    .card {
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      margin-bottom: 1.5rem;
      border: 1px solid var(--light-border);
      overflow: hidden;
    }
    
    .table th {
      background-color: var(--primary-color);
      color: white;
      font-weight: 500;
      vertical-align: middle;
    }
    
    .table td {
      vertical-align: middle;
    }
    
    .table tr:hover {
      background-color: rgba(220, 53, 69, 0.05);
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
    
    .edit-btn {
      background-color: #0d6efd;
      color: white;
    }
    
    .edit-btn:hover {
      background-color: #0b5ed7;
    }
    
    .delete-btn {
      background-color: #dc3545;
      color: white;
    }
    
    .delete-btn:hover {
      background-color: #bb2d3b;
    }
    
    .add-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 8px 16px;
      font-weight: 500;
      background-color: var(--accent-color);
      border: none;
      color: white;
      transition: all 0.3s;
    }
    
    .add-btn:hover {
      background-color: #c82333;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .add-btn i {
      margin-right: 8px;
    }
    
    .table-responsive {
      overflow-x: auto;
    }
    
    .breadcrumb-item a {
      color: var(--primary-color);
      text-decoration: none;
    }
    
    .breadcrumb-item a:hover {
      color: var(--accent-color);
    }
    
    .stock-low {
      color: #dc3545;
      font-weight: 500;
    }
    
    .stock-medium {
      color: #fd7e14;
      font-weight: 500;
    }
    
    .stock-good {
      color: #198754;
      font-weight: 500;
    }
    
    .profit-negative {
      color: #dc3545;
    }
    
    .search-container {
      position: relative;
      margin-bottom: 20px;
    }
    
    .search-container i {
      position: absolute;
      left: 10px;
      top: 10px;
      color: #6c757d;
    }
    
    .search-input {
      padding-left: 35px;
      border-radius: 20px;
    }
    
    .main-content {
      padding: 20px;
    }
    
    .empty-state {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 0;
      color: #6c757d;
    }
    
    .empty-state i {
      font-size: 48px;
      margin-bottom: 20px;
      color: var(--accent-color);
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
          <a href="#" class="sidebar-link active">
            <i class="fas fa-box"></i> Product Stock
          </a>
          <a href="#" class="sidebar-link">
            <i class="fas fa-chart-line"></i> Sales Record
          </a>
          <a href="#" class="sidebar-link">
            <i class="fas fa-truck"></i> Supplier List
          </a>
          <a href="#" class="sidebar-link">
            <i class="fas fa-shipping-fast"></i> Supplier Deliveries
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
                <li class="breadcrumb-item active" aria-current="page">Product Stock</li>
              </ol>
            </nav>
          </div>
        </nav>
        
        <!-- Page content -->
        <div class="container-fluid">
          <div class="d-flex justify-content-between align-items-center page-header">
            <h2 class="fw-bold">Product Stock</h2>
            <button class="btn add-btn">
              <i class="fas fa-plus-circle"></i> Add New Product
            </button>
          </div>
          
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control search-input" placeholder="Search products...">
              </div>
            </div>
          </div>
          
          <div class="card">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-bordered mb-0">
                  <thead>
                    <tr>
                      <th>#ID</th>
                      <th>Product Name</th>
                      <th>Category/Type</th>
                      <th>Stock</th>
                      <th>Supplier Price</th>
                      <th>Selling Price</th>
                      <th>Supplier</th>
                      <th>Product Added</th>
                      <th>Product Modified</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Empty table body with no data -->
                  </tbody>
                </table>
              </div>
              
              <!-- Empty state message -->
              <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h4>No Products Found</h4>
                <p>Click "Add New Product" to add items to your inventory.</p>
              </div>
            </div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>