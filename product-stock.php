<?php include_once "role-validation.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Metro District Designs - Product Inventory</title>
  <link rel="icon" type="image/png" href="images/logo/threadcraft-logo.png">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
      margin: 0;
      padding: 0;
    }

    /* Sidebar styles from dashboard.php */
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
    
    /* Main content area */
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
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    /* Button styles */
    .btn-primary {
      background-color: #0d6efd;
      border-color: #0d6efd;
    }
    
    .btn-primary:hover {
      background-color: #0b5ed7;
      border-color: #0a58ca;
    }

    /* Card and table styles */
    .card {
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      margin-bottom: 1.5rem;
      border: 1px solid #dee2e6;
      overflow: hidden;
    }
    
    .table th {
      background-color: #212529;
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
    
    /* Action buttons */
    .action-btn {
      width: 36px;
      height: 36px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 0;
      margin: 0;
      border: none;
      cursor: pointer;
      transition: all 0.2s;
    }
    
    .edit-btn {
      background-color: #0d6efd;
      color: white;
      border-radius: 4px 0 0 4px;
    }
    
    .delete-btn {
      background-color: #dc3545;
      color: white;
      border-radius: 0 4px 4px 0;
    }
    
    .view-btn {
      background-color: #198754;
      color: white;
      border-radius: 4px;
      margin-right: 3px;
    }
    
    .edit-btn:hover {
      background-color: #0b5ed7;
    }
    
    .delete-btn:hover {
      background-color: #bb2d3b;
    }
    
    .view-btn:hover {
      background-color: #157347;
    }
    
    .add-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 8px 16px;
      font-weight: 500;
      background-color: #dc3545;
      border: none;
      color: white;
      transition: all 0.3s;
      border-radius: 4px;
    }
    
    .add-btn:hover {
      background-color: #c82333;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .add-btn i {
      margin-right: 8px;
    }
    
    /* Other styles */
    .content-area {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      padding: 20px;
      margin-bottom: 20px;
    }
    
    .table-responsive {
      overflow-x: auto;
    }
    
    .breadcrumb-item a {
      color: #212529;
      text-decoration: none;
    }
    
    .breadcrumb-item a:hover {
      color: #dc3545;
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
      color: #dc3545;
    }
    
    /* Action buttons group */
    .action-buttons {
      display: flex;
    }
    
    /* Card headers */
    .card .card-header {
      background-color: #212529;
      color: white;
      padding: 10px 15px;
      font-weight: 500;
    }
    
    /* Color display */
    .color-circle {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      display: inline-block;
      margin-right: 5px;
      border: 1px solid #ddd;
    }
    
    /* Modal styles */
    .modal-header {
      background-color: #212529;
      color: white;
    }
    
    .modal-header .btn-close {
      filter: invert(1) grayscale(100%) brightness(200%);
    }
    
    .form-label {
      font-weight: 500;
    }
    
    .color-preview {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      display: inline-block;
      border: 1px solid #ddd;
      vertical-align: middle;
      margin-left: 10px;
    }
    
    /* Toast notification */
    .toast-container {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1060;
    }
    
    .toast {
      background-color: white;
      max-width: 350px;
    }

    /* Image preview */
    .image-preview-container {
      margin-top: 10px;
      border: 1px dashed #ddd;
      padding: 10px;
      text-align: center;
      border-radius: 5px;
      background-color: #f8f9fa;
      position: relative;
    }
    
    .image-preview {
      max-width: 100%;
      max-height: 150px;
      display: none;
    }

    .file-input-label {
      display: inline-block;
      padding: 8px 12px;
      cursor: pointer;
      background-color: #0d6efd;
      color: white;
      border-radius: 4px;
      margin-top: 5px;
    }

    .file-input-label:hover {
      background-color: #0b5ed7;
    }

    .design-thumbnail {
      max-width: 60px;
      max-height: 60px;
      border-radius: 4px;
      cursor: pointer;
    }
    
    /* Product details modal */
    .product-images {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }
    
    .product-image-container {
      flex: 1;
      text-align: center;
      padding: 10px;
      border: 1px solid #ddd;
      margin: 0 5px;
      border-radius: 5px;
    }
    
    .product-image {
      max-width: 100%;
      max-height: 200px;
    }
    
    .design-title {
      margin-top: 10px;
      font-weight: bold;
    }
    
    /* Tab styles */
    .nav-tabs .nav-link {
      color: #495057;
    }
    
    .nav-tabs .nav-link.active {
      font-weight: bold;
      border-bottom: 2px solid #0d6efd;
    }
    
    .tab-content {
      padding: 20px 0;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .sidebar {
        position: static;
        width: 100%;
        min-height: auto;
      }
      
      .main-content {
        margin-left: 0;
        width: 100%;
      }
      
      .product-images {
        flex-direction: column;
      }
      
      .product-image-container {
        margin: 5px 0;
      }
    }
  </style>
</head>
<body>
  <div class="container-fluid p-0">
    <div class="row g-0">
      <!-- Sidebar from dashboard.php -->
      <div class="col-auto">
        <div class="sidebar">
          <div class="logo-container">
            <img src="images/TSHIRTS/LOGO.jpg" class="logo" alt="Logo">
            <h5 class="brand-name">Metro District Designs</h5>
          </div>
          <a href="dashboard.php" class="sidebar-link">
            <i class="fas fa-tachometer-alt"></i> Dashboard
          </a>
          <a href="admin-orders.php" class="sidebar-link">
              <i class="fas fa-shopping-cart"></i> Orders
          </a>
          <a href="product-stock.php" class="sidebar-link active">
            <i class="fas fa-box"></i> Product Stock
          </a>
          <a href="admininquiries.php" class="sidebar-link">
            <i class="fas fa-envelope"></i> Inquiries
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
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Product Stock</li>
              </ol>
            </nav>
          </div>
          
          <!-- Page Title -->
          <div class="page-title">
            <span>Product Stock</span>
            <button class="btn add-btn" id="addNewProductBtn">
              <i class="fas fa-plus-circle"></i> Add New Product
            </button>
          </div>
          
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control search-input" id="searchProducts" placeholder="Search products...">
              </div>
            </div>
          </div>
          
          <div class="content-area">
            <div class="card">
              <div class="card-header">
                Product Inventory
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-bordered mb-0" id="productsTable">
                    <thead>
                      <tr>
                        <th>#ID</th>
                        <th>Product Name</th>
                        <th>Category/Type</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Stock</th>
                        <th>Selling Price</th>
                        <th>Original Price</th>
                        <th>Design</th>
                        <th>Product Added</th>
                        <th>Product Modified</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="productTableBody">
                      <!-- Sample row, will be populated by JavaScript -->
                    </tbody>
                  </table>
                </div>
                
                <!-- Empty state message - only shows when no products -->
                <div class="empty-state" id="emptyState" style="display: none;">
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
  </div>

  <!-- Add/Edit Product Modal -->
  <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="productModalLabel">Add New Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul class="nav nav-tabs" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">Basic Information</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="designs-tab" data-bs-toggle="tab" data-bs-target="#designs" type="button" role="tab" aria-controls="designs" aria-selected="false">T-shirt Designs</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="false">Description</button>
            </li>
          </ul>
          
          <form id="productForm">
            <input type="hidden" id="editProductId">
            
            <div class="tab-content" id="productTabsContent">
              <!-- Basic Information Tab -->
              <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                <div class="row mb-3 mt-3">
                  <div class="col-md-6">
                    <label for="productName" class="form-label">Product Name</label>
                    <div class="input-group mb-3">
                      <select class="form-select" id="productNameSelect" onchange="handleProductNameSelect()">
                        <option value="">Select or Add Product</option>
                        <option value="custom">Add Custom Name</option>
                        <option value="BORN BROKE DIE RICH">BORN BROKE DIE RICH</option>
                        <option value="CHOSEN">CHOSEN</option>
                        <option value="CLASSIC WOLF">CLASSIC WOLF</option>
                        <option value="COOL DADS RAISING COOL KIDS">COOL DADS RAISING COOL KIDS</option>
                        <option value="CS X CMA COLLAB">CS X CMA COLLAB</option>
                        <option value="DOERS ALWAYS DOET">DOERS ALWAYS DOET</option>
                        <option value="DOERS GET TIRED TOO">DOERS GET TIRED TOO</option>
                        <option value="DOLLAR LANE">DOLLAR LANE</option>
                        <option value="FLVMME DREAMER">FLVMME DREAMER</option>
                        <option value="GOALS IN MOTION">GOALS IN MOTION</option>
                        <option value="GROW IN SILENCE">GROW IN SILENCE</option>
                        <option value="HOLO V1">HOLO V1</option>
                        <option value="JDG NUGS BASIC TEE">JDG NUGS BASIC TEE</option>
                        <option value="JDM NUGS COLLECTION">JDM NUGS COLLECTION</option>
                        <option value="NO ORDINARY LOVE">NO ORDINARY LOVE</option>
                        <option value="NUGS JANUARY RLS (GLYPH)">NUGS JANUARY RLS (GLYPH)</option>
                        <option value="NUGS JANUARY RLS (THAI CAMO)">NUGS JANUARY RLS (THAI CAMO)</option>
                        <option value="PANTAS">PANTAS</option>
                        <option value="STONERS SOCIETY">STONERS SOCIETY</option>
                        <option value="THE GOOD GUYS">THE GOOD GUYS</option>
                        <option value="THE GOOD GUYS (BADGES)">THE GOOD GUYS (BADGES)</option>
                        <option value="WARSHIP">WARSHIP</option>
                      </select>
                    </div>
                    <div id="customNameContainer" style="display: none;">
                      <input type="text" class="form-control" id="productName" placeholder="Enter custom product name">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="productCategory" class="form-label">Category/Type</label>
                    <select class="form-select" id="productCategory" required>
                      <option value="">Select category</option>
                      <option value="Pre-Made Design">Pre-Made Design</option>
                      <option value="Commissioned Design">Commissioned Design</option>
                      <option value="Limited Edition">Limited Edition</option>
                      <option value="Seasonal Collection">Seasonal Collection</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="productColor" class="form-label">Color</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="productColor" placeholder="e.g. Black, Red, Blue" required>
                      <input type="color" class="form-control form-control-color" id="productColorCode" title="Choose color">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="productSize" class="form-label">Size</label>
                    <div class="input-group mb-3">
                      <select class="form-select" id="productSizeSelect" onchange="handleSizeSelect()">
                        <option value="">Select or Add Size</option>
                        <option value="custom">Add Custom Size</option>
                        <option value="S">Small</option>
                        <option value="M">Medium</option>
                        <option value="L">Large</option>
                        <option value="XL">X-Large</option>
                        <option value="Standard">Standard</option>
                      </select>
                    </div>
                    <div id="customSizeContainer" style="display: none;">
                      <input type="text" class="form-control" id="productSize" placeholder="Enter custom size">
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="productStock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="productStock" min="0" required>
                  </div>
                  <div class="col-md-6">
                    <label for="productPrice" class="form-label">Selling Price (₱)</label>
                    <input type="number" class="form-control" id="productPrice" min="0" step="0.01" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="originalPrice" class="form-label">Original Price (₱)</label>
                    <input type="number" class="form-control" id="originalPrice" min="0" step="0.01">
                  </div>
                </div>
              </div>
              
              <!-- T-shirt Designs Tab -->
              <div class="tab-pane fade" id="designs" role="tabpanel" aria-labelledby="designs-tab">
                <div class="row mb-3 mt-3">
                  <div class="col-md-4">
                    <label for="frontDesign" class="form-label">Front Design</label>
                    <input type="file" class="form-control" id="frontDesign" accept="image/*" style="display: none;">
                    <div class="image-preview-container">
                      <img id="frontDesignPreview" class="image-preview">
                      <p id="frontDesignText">No image selected</p>
                      <label for="frontDesign" class="file-input-label">Choose Front Design</label>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label for="backDesign" class="form-label">Back Design</label>
                    <input type="file" class="form-control" id="backDesign" accept="image/*" style="display: none;">
                    <div class="image-preview-container">
                      <img id="backDesignPreview" class="image-preview">
                      <p id="backDesignText">No image selected</p>
                      <label for="backDesign" class="file-input-label">Choose Back Design</label>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label for="mainDesign" class="form-label">Main Design (Full T-shirt)</label>
                    <input type="file" class="form-control" id="mainDesign" accept="image/*" style="display: none;">
                    <div class="image-preview-container">
                      <img id="mainDesignPreview" class="image-preview">
                      <p id="mainDesignText">No image selected</p>
                      <label for="mainDesign" class="file-input-label">Choose Main Design</label>
                    </div>
                  </div>
                </div>
                <input type="hidden" id="frontDesignFile">
                <input type="hidden" id="backDesignFile">
                <input type="hidden" id="mainDesignFile">
              </div>
              
              <!-- Description Tab -->
              <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="description-tab">
                <div class="row mb-3 mt-3">
                  <div class="col-12">
                    <label for="productDescription" class="form-label">Product Description</label>
                    <textarea class="form-control" id="productDescription" rows="6" placeholder="Enter product description here..."></textarea>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="saveProductBtn">Save Product</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Product View Modal -->
  <div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewProductModalLabel">Product Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="product-details">
            <h3 id="viewProductName" class="mb-3"></h3>
            
            <div class="product-images mb-4">
              <div class="product-image-container">
                <img id="viewFrontImage" class="product-image" src="" alt="Front Design">
                <div class="design-title">Front Design</div>
              </div>
              <div class="product-image-container">
                <img id="viewBackImage" class="product-image" src="" alt="Back Design">
                <div class="design-title">Back Design</div>
              </div>
              <div class="product-image-container">
                <img id="viewMainImage" class="product-image" src="" alt="Main Design">
                <div class="design-title">Main Design</div>
              </div>
            </div>
            
            <div class="row mb-3">
              <div class="col-md-6">
                <h5>Basic Information</h5>
                <table class="table table-striped">
                  <tr>
                    <th>Category</th>
                    <td id="viewCategory"></td>
                  </tr>
                  <tr>
                    <th>Color</th>
                    <td>
                      <span id="viewColorCircle" class="color-circle"></span>
                      <span id="viewColor"></span>
                    </td>
                  </tr>
                  <tr>
                    <th>Size</th>
                    <td id="viewSize"></td>
                  </tr>
                  <tr>
                    <th>Stock</th>
                    <td id="viewStock"></td>
                  </tr>
                  <tr>
                    <th>Selling Price</th>
                    <td id="viewPrice"></td>
                  </tr>
                  <tr>
                    <th>Original Price</th>
                    <td id="viewOriginalPrice"></td>
                  </tr>
                </table>
              </div>
              <div class="col-md-6">
                <h5>Description</h5>
                <div id="viewDescription" class="p-3 bg-light rounded mb-3"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="editFromViewBtn">Edit Product</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal (continued) -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this product? This action cannot be undone.</p>
        <p><strong>Product: </strong><span id="deleteProductName"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Product</button>
      </div>
    </div>
  </div>
</div>

<!-- Toast Notification -->
<div class="toast-container">
  <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" id="successToast">
    <div class="d-flex">
      <div class="toast-body">
        <i class="fas fa-check-circle me-2"></i>
        <span id="toastMessage">Operation successful!</span>
      </div>
      <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
  // Global variables
  let currentProductId = null;
  const products = []; // Will store the product data fetched from the server
  
  // DOM ready handler
  $(document).ready(function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Load products when page loads
    loadProducts();
    
    // Event listeners
    $("#addNewProductBtn").click(openAddProductModal);
    $("#saveProductBtn").click(saveProduct);
    $("#confirmDeleteBtn").click(deleteProduct);
    $("#editFromViewBtn").click(openEditModalFromView);
    $("#searchProducts").on("keyup", searchProducts);
    
    // File input change handlers for image previews
    $("#frontDesign").change(function() {
      handleImagePreview(this, "#frontDesignPreview", "#frontDesignText");
    });
    
    $("#backDesign").change(function() {
      handleImagePreview(this, "#backDesignPreview", "#backDesignText");
    });
    
    $("#mainDesign").change(function() {
      handleImagePreview(this, "#mainDesignPreview", "#mainDesignText");
    });
  });
  
  // Function to handle product name selection
  function handleProductNameSelect() {
    const selectedValue = $("#productNameSelect").val();
    if (selectedValue === "custom") {
      $("#customNameContainer").show();
    } else {
      $("#customNameContainer").hide();
      $("#productName").val(selectedValue);
    }
  }
  
  // Function to handle size selection
  function handleSizeSelect() {
    const selectedValue = $("#productSizeSelect").val();
    if (selectedValue === "custom") {
      $("#customSizeContainer").show();
    } else {
      $("#customSizeContainer").hide();
      $("#productSize").val(selectedValue);
    }
  }
  
  // Function to handle image preview
  function handleImagePreview(input, previewId, textId) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      
      reader.onload = function(e) {
        $(previewId).attr('src', e.target.result);
        $(previewId).show();
        $(textId).hide();
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }
  
  // Function to open add product modal
  function openAddProductModal() {
    // Reset form
    $("#productForm")[0].reset();
    $("#editProductId").val("");
    $("#productModalLabel").text("Add New Product");
    
    // Reset image previews
    resetImagePreviews();
    
    // Reset custom fields
    $("#customNameContainer").hide();
    $("#customSizeContainer").hide();
    
    // Show the modal
    const productModal = new bootstrap.Modal(document.getElementById('productModal'));
    productModal.show();
    
    // Set focus to the first input field
    setTimeout(() => {
      $("#productNameSelect").focus();
    }, 500);
  }
  
  // Function to reset image previews
  function resetImagePreviews() {
    $("#frontDesignPreview, #backDesignPreview, #mainDesignPreview").hide().attr('src', '');
    $("#frontDesignText, #backDesignText, #mainDesignText").show();
    $("#frontDesignFile, #backDesignFile, #mainDesignFile").val('');
  }
  
  // Function to load products from server
  function loadProducts() {
    // Show loading state
    $("#productTableBody").html('<tr><td colspan="12" class="text-center"><i class="fas fa-spinner fa-spin me-2"></i> Loading products...</td></tr>');
    
    // Fetch products from the server
    $.ajax({
      url: 'api/get_products.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        if (data.success) {
          products.length = 0; // Clear the array
          
          // Store products in the array
          products.push(...data.products);
          
          // Display products
          displayProducts(products);
        } else {
          // Show error message
          $("#productTableBody").html(`<tr><td colspan="12" class="text-center text-danger">${data.message}</td></tr>`);
          $("#emptyState").show();
        }
      },
      error: function(xhr, status, error) {
        console.error('Error fetching products:', error);
        $("#productTableBody").html(`<tr><td colspan="12" class="text-center text-danger">Error loading products. Please try again later.</td></tr>`);
      }
    });
  }
  
  // Function to display products in the table
  function displayProducts(productsToShow) {
    // Clear the table
    $("#productTableBody").empty();
    
    if (productsToShow.length === 0) {
      // Show empty state
      $("#emptyState").show();
      return;
    }
    
    // Hide empty state
    $("#emptyState").hide();
    
    // Populate the table
    productsToShow.forEach(product => {
      let front = '', back = '', main = '';
      if (product.images && product.images.length) {
        product.images.forEach(img => {
          if (img.toUpperCase().includes('FRONT')) front = img;
          else if (img.toUpperCase().includes('BACK')) back = img;
          else if (img.toUpperCase().includes('DESIGN')) main = img;
        });
      }

      const row = `
        <tr>
          <td>${product.id}</td>
          <td>${product.product_name || product.name}</td>
          <td>${product.category}</td>
          <td>
            <span class="color-circle" style="background-color: ${product.color_code || '#000000'}"></span>
            ${product.color}
          </td>
          <td>${product.size}</td>
          <td>${product.stock}</td>
          <td>₱${parseFloat(product.price).toFixed(2)}</td>
          <td>₱${parseFloat(product.original_price || 0).toFixed(2)}</td>
          <td>
            ${main ? `<img src="${main}" alt="Front Design" class="design-thumbnail" onclick="viewProduct(${product.id})">` : 'No image'}
          </td>
          <td>${product.date_added ? new Date(product.date_added).toLocaleDateString() : ''}</td>
          <td>${product.date_modified ? new Date(product.date_modified).toLocaleDateString() : ''}</td>
          <td>
            <div class="action-buttons">
              <button class="action-btn view-btn" onclick="viewProduct(${product.id})" data-bs-toggle="tooltip" title="View">
                <i class="fas fa-eye"></i>
              </button>
              <button class="action-btn edit-btn" onclick="editProduct(${product.id})" data-bs-toggle="tooltip" title="Edit">
                <i class="fas fa-edit"></i>
              </button>
              <button class="action-btn delete-btn" onclick="confirmDelete(${product.id})" data-bs-toggle="tooltip" title="Delete">
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          </td>
        </tr>
      `;
      $("#productTableBody").append(row);
    });
    
    // Reinitialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  }
  
  // Function to save product (add or update)
  function saveProduct() {
    // Get form data
    const productName = $("#productNameSelect").val() === "custom" ? $("#productName").val() : $("#productNameSelect").val();
    const category = $("#productCategory").val();
    const color = $("#productColor").val();
    const colorCode = $("#productColorCode").val();
    const size = $("#productSizeSelect").val() === "custom" ? $("#productSize").val() : $("#productSizeSelect").val();
    const stock = $("#productStock").val();
    const price = $("#productPrice").val();
    const originalPrice = $("#originalPrice").val();
    const description = $("#productDescription").val();
    const productId = $("#editProductId").val();
    
    // Validate form
    if (!productName || !category || !color || !size || !stock || !price) {
      showToast("Please fill in all required fields", "danger");
      return;
    }
    
    // Create form data object for file uploads
    const formData = new FormData();
    formData.append('name', productName);
    formData.append('category', category);
    formData.append('color', color);
    formData.append('color_code', colorCode);
    formData.append('size', size);
    formData.append('stock', stock);
    formData.append('price', price);
    formData.append('original_price', originalPrice);
    formData.append('description', description);
    
    // Add files if they exist
    if ($("#frontDesign")[0].files[0]) {
      formData.append('front_design', $("#frontDesign")[0].files[0]);
    } else if ($("#frontDesignFile").val()) {
      formData.append('front_design_file', $("#frontDesignFile").val());
    }
    
    if ($("#backDesign")[0].files[0]) {
      formData.append('back_design', $("#backDesign")[0].files[0]);
    } else if ($("#backDesignFile").val()) {
      formData.append('back_design_file', $("#backDesignFile").val());
    }
    
    if ($("#mainDesign")[0].files[0]) {
      formData.append('main_design', $("#mainDesign")[0].files[0]);
    } else if ($("#mainDesignFile").val()) {
      formData.append('main_design_file', $("#mainDesignFile").val());
    }
    
    // Set the request URL based on whether we're adding or updating
    let url = 'api/add_product.php';
    if (productId) {
      url = 'api/update_product.php';
      formData.append('id', productId);
    }
    
    // Send the request
    $.ajax({
      url: url,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        try {
          const data = typeof response === 'string' ? JSON.parse(response) : response;
          
          if (data.success) {
            // Hide the modal
            bootstrap.Modal.getInstance(document.getElementById('productModal')).hide();
            
            // Show success message
            showToast(data.message, 'success');
            
            // Reload products
            loadProducts();
          } else {
            // Show error message
            showToast(data.message, 'danger');
          }
        } catch (e) {
          console.error('Error parsing response:', e);
          showToast('An error occurred while processing your request', 'danger');
        }
      },
      error: function(xhr, status, error) {
        console.error('Error saving product:', error);
        showToast('An error occurred while saving the product', 'danger');
      }
    });
  }

  function getImageByType(images, type) {
    if (!images) return '';
    type = type.toUpperCase();
    return images.find(img => img.toUpperCase().includes(type)) || '';
  }
  
  // Function to view product details
  function viewProduct(id) {
    const product = products.find(p => p.id == id);
    if (!product) {
      showToast('Product not found', 'danger');
      return;
    }
    $("#viewProductName").text(product.product_name || product.name);
    $("#viewCategory").text(product.category);
    $("#viewColor").text(product.color);
    $("#viewColorCircle").css('background-color', product.color_code || '#000000');
    $("#viewSize").text(product.size);
    $("#viewStock").text(product.stock);
    $("#viewPrice").text(`₱${parseFloat(product.price).toFixed(2)}`);
    $("#viewOriginalPrice").text(`₱${parseFloat(product.original_price || 0).toFixed(2)}`);
    $("#viewDescription").text(product.description || 'No description available');

    // Set product images
    $("#viewFrontImage").attr('src', getImageByType(product.images, 'FRONT') || 'images/no-image.png');
    $("#viewBackImage").attr('src', getImageByType(product.images, 'BACK') || 'images/no-image.png');
    $("#viewMainImage").attr('src', getImageByType(product.images, 'DESIGN') || 'images/no-image.png');

    currentProductId = product.id;
    const viewModal = new bootstrap.Modal(document.getElementById('viewProductModal'));
    viewModal.show();
  }
  
  // Function to edit product
  function editProduct(id) {
    const product = products.find(p => p.id == id);
    if (!product) {
      showToast('Product not found', 'danger');
      return;
    }
    $("#productForm")[0].reset();
    resetImagePreviews();
    $("#productModalLabel").text("Edit Product");
    $("#editProductId").val(product.id);

    // Product name
    if ($("#productNameSelect option[value='" + product.name + "']").length > 0) {
      $("#productNameSelect").val(product.name);
      $("#customNameContainer").hide();
    } else {
      $("#productNameSelect").val("custom");
      $("#productName").val(product.name);
      $("#customNameContainer").show();
    }
    $("#productCategory").val(product.category);
    $("#productColor").val(product.color);
    $("#productColorCode").val(product.color_code || '#000000');
    if ($("#productSizeSelect option[value='" + product.size + "']").length > 0) {
      $("#productSizeSelect").val(product.size);
      $("#customSizeContainer").hide();
    } else {
      $("#productSizeSelect").val("custom");
      $("#productSize").val(product.size);
      $("#customSizeContainer").show();
    }
    $("#productStock").val(product.stock);
    $("#productPrice").val(product.price);
    $("#originalPrice").val(product.original_price || '');
    $("#productDescription").val(product.description || '');

    // Set hidden image file values and previews
    const frontImg = getImageByType(product.images, 'FRONT');
    const backImg = getImageByType(product.images, 'BACK');
    const mainImg = getImageByType(product.images, 'DESIGN');
    $("#frontDesignFile").val(frontImg);
    $("#backDesignFile").val(backImg);
    $("#mainDesignFile").val(mainImg);

    if (frontImg) {
      $("#frontDesignPreview").attr('src', frontImg).show();
      $("#frontDesignText").hide();
    }
    if (backImg) {
      $("#backDesignPreview").attr('src', backImg).show();
      $("#backDesignText").hide();
    }
    if (mainImg) {
      $("#mainDesignPreview").attr('src', mainImg).show();
      $("#mainDesignText").hide();
    }

    const productModal = new bootstrap.Modal(document.getElementById('productModal'));
    productModal.show();
  }
  
  // Function to confirm delete
  function confirmDelete(id) {
    // Find the product
    const product = products.find(p => p.id == id);
    
    if (!product) {
      showToast('Product not found', 'danger');
      return;
    }
    
    // Set product name in confirmation modal
    $("#deleteProductName").text(product.name);
    
    // Store the product ID to be deleted
    currentProductId = product.id;
    
    // Show the delete confirmation modal
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
  }
  
  // Function to delete product
  function deleteProduct() {
    if (!currentProductId) {
      showToast('No product selected for deletion', 'danger');
      return;
    }
    
    // Send delete request
    $.ajax({
      url: 'api/delete_product.php',
      type: 'POST',
      data: JSON.stringify({ id: currentProductId }),
      dataType: 'json',
      success: function(data) {
        // Accept both {status: "..."} and {success: ...}
        const isSuccess = data.success === true || data.status === 'success';
        const message = data.message || (isSuccess ? 'Product deleted successfully.' : 'Failed to delete product.');

        if (isSuccess) {
          // Hide the delete modal
          bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();

          // Show success message
          showToast(message, 'success');

          // Reload products
          loadProducts();
        } else {
          // Show error message
          showToast(message, 'danger');
        }
      },
      error: function(xhr, status, error) {
        console.error('Error deleting product:', error);
        showToast('An error occurred while deleting the product', 'danger');
      }
    });
  }
  
  // Function to open edit modal from view modal
  function openEditModalFromView() {
    // Hide the view modal
    bootstrap.Modal.getInstance(document.getElementById('viewProductModal')).hide();
    
    // Open edit modal with the current product ID
    editProduct(currentProductId);
  }
  
  // Function to search products
  function searchProducts() {
    const searchText = $("#searchProducts").val().toLowerCase();
    
    if (!searchText) {
      // If search box is empty, show all products
      displayProducts(products);
      return;
    }
    
    // Filter products
    const filteredProducts = products.filter(product => {
      return (
        product.name.toLowerCase().includes(searchText) ||
        product.category.toLowerCase().includes(searchText) ||
        product.color.toLowerCase().includes(searchText) ||
        product.size.toLowerCase().includes(searchText) ||
        product.id.toString().includes(searchText)
      );
    });
    
    // Display filtered products
    displayProducts(filteredProducts);
  }
  
  // Function to show toast notification
  function showToast(message, type) {
    // Set toast message
    $("#toastMessage").text(message);
    
    // Set toast background color based on type
    const toast = $("#successToast");
    toast.removeClass('bg-success bg-danger bg-warning');
    
    switch(type) {
      case 'success':
        toast.addClass('bg-success');
        break;
      case 'danger':
        toast.addClass('bg-danger');
        break;
      case 'warning':
        toast.addClass('bg-warning');
        break;
      default:
        toast.addClass('bg-success');
    }
    
    // Show the toast
    const toastInstance = new bootstrap.Toast(document.getElementById('successToast'), {
      delay: 3000
    });
    toastInstance.show();
  }
</script>
</body>
</html>