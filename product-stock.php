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
    
    .edit-btn:hover {
      background-color: #0b5ed7;
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
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="productModalLabel">Add New Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="productForm">
            <input type="hidden" id="editProductId">
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="productName" class="form-label">Product Name</label>
                <!-- <input type="text" class="form-control" id="productName" required> -->
                <select class="form-select" id="productName" required>
                  <option value="">Select Product</option>
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
                <select class="form-select" id="productSize" required>
                  <option value="">Select size</option>
                  <option value="S">Small</option>
                  <option value="M">Medium</option>
                  <option value="L">Large</option>
                  <option value="XL">X-Large</option>
                  <option value="Standard">Standard</option>
                </select>
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
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="saveProductBtn">Save Product</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
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
          <input type="hidden" id="deleteProductId">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Notification -->
  <div class="toast-container">
    <div class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" id="toastNotification">
      <div class="d-flex">
        <div class="toast-body" id="toastMessage">
          Operation successful!
        </div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // DOM References
    const productTableBody = document.getElementById('productTableBody');
    const searchInput = document.getElementById('searchProducts');
    const emptyState = document.getElementById('emptyState');
    const productsTable = document.getElementById('productsTable');
    const addNewProductBtn = document.getElementById('addNewProductBtn');
    const saveProductBtn = document.getElementById('saveProductBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const productModal = new bootstrap.Modal(document.getElementById('productModal'));
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

    const editProductId = document.getElementById('editProductId');
    const productName = document.getElementById('productName');
    const productCategory = document.getElementById('productCategory');
    const productColor = document.getElementById('productColor');
    const productColorCode = document.getElementById('productColorCode');
    const productSize = document.getElementById('productSize');
    const productStock = document.getElementById('productStock');
    const productPrice = document.getElementById('productPrice');
    const originalPrice = document.getElementById('originalPrice');
    const deleteProductId = document.getElementById('deleteProductId');
    const deleteProductName = document.getElementById('deleteProductName');

    // Toast Notification
    const toastNotification = new bootstrap.Toast(document.getElementById('toastNotification'));
    const toastMessage = document.getElementById('toastMessage');

    // Function to show toast notification
    function showToast(message) {
      toastMessage.textContent = message;
      toastNotification.show();
    }

    // Fetch products from the backend
    function fetchProducts() {
      fetch('api/get_products.php')
        .then((response) => response.json())
        .then((data) => {
          if (data.status === 'success') {
            renderProducts(data.products);
          } else {
            emptyState.style.display = 'flex';
            productsTable.style.display = 'none';
          }
        })
        .catch((error) => {
          console.error('Error fetching products:', error);
        });
    }

    // Function to filter products based on the search query
    function filterProducts(query) {
      const rows = productTableBody.querySelectorAll('tr');
      rows.forEach((row) => {
        const productName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        const productCategory = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        const productColor = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

        // Check if the query matches any of the product details
        if (
          productName.includes(query) ||
          productCategory.includes(query) ||
          productColor.includes(query)
        ) {
          row.style.display = ''; // Show the row
        } else {
          row.style.display = 'none'; // Hide the row
        }
      });
    }
    
    // Event listener for the search input
    searchInput.addEventListener('input', function () {
      const query = searchInput.value.toLowerCase().trim();
      filterProducts(query);
    });

    // Render products in the table
    function renderProducts(products) {
      productTableBody.innerHTML = '';
      if (products.length === 0) {
        emptyState.style.display = 'flex';
        productsTable.style.display = 'none';
      } else {
        emptyState.style.display = 'none';
        productsTable.style.display = 'table';
        products.forEach((product) => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${product.id}</td>
            <td>${product.name}</td>
            <td>${product.category}</td>
            <td>
              <span class="color-circle" style="background-color: ${product.color_code};"></span>
              ${product.color}
            </td>
            <td>${product.size}</td>
            <td>${product.stock}</td>
            <td>₱${parseFloat(product.price).toFixed(2)}</td>
            <td>
              ${product.original_price == null
                ? ''
                : `₱${parseFloat(product.original_price).toFixed(2)}`}
            </td>
            <td>${formatDate(product.date_added)}</td>
            <td>${formatDate(product.date_modified)}</td>
            <td>
              <button class="btn btn-sm btn-primary edit-btn" data-id="${product.id}">Edit</button>
              <button class="btn btn-sm btn-danger delete-btn" data-id="${product.id}">Delete</button>
            </td>
          `;
          productTableBody.appendChild(row);
        });
      }
    }

    function formatDate(dateString) {
      const options = { year: 'numeric', month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit', hour12: true };
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', options).replace(',', '').replace('AM', 'AM').replace('PM', 'PM');
    }

    // Open Add Product Modal
    addNewProductBtn.addEventListener('click', function () {
      // Reset form
      document.getElementById('productForm').reset();
      editProductId.value = '';
      productColorCode.value = '#000000';
      productModalLabel.textContent = 'Add New Product';
      productModal.show();
    });

    // Save Product (Add or Edit)
    saveProductBtn.addEventListener('click', function () {
      // Validate form
      const form = document.getElementById('productForm');
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }

      const id = editProductId.value;
      const productData = {
        id: id ? parseInt(id) : null,
        name: productName.value,
        category: productCategory.value,
        color: productColor.value,
        colorCode: productColorCode.value,
        size: productSize.value,
        stock: parseInt(productStock.value),
        price: parseFloat(productPrice.value),
        original_price: originalPrice.value == null || originalPrice.value === '' ? null : parseFloat(originalPrice.value),
      };

      const url = id ? 'api/update_product.php' : 'api/add_product.php';
      fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(productData),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === 'success') {
            productModal.hide();
            fetchProducts();
            showToast(data.message);
          } else {
            alert(data.message);
          }
        })
        .catch((error) => {
          console.error('Error saving product:', error);
        });
    });

    // Handle Edit Button Clicks
    document.addEventListener('click', function (event) {
      if (event.target.closest('.edit-btn')) {
        const btn = event.target.closest('.edit-btn');
        const productId = parseInt(btn.getAttribute('data-id'));

        fetch(`api/get_product.php?id=${productId}`)
          .then((response) => response.json())
          .then((data) => {
            if (data.status === 'success') {
              const product = data.product;

              // Populate fields with product data
              editProductId.value = product.id;
              productName.value = product.name;
              productCategory.value = product.category;
              productColor.value = product.color;
              productColorCode.value = product.color_code;
              productSize.value = product.size;
              productStock.value = product.stock;
              productPrice.value = product.price;
              originalPrice.value = product.original_price;

              // Update modal title
              productModalLabel.textContent = 'Edit Product';
              productModal.show();
            } else {
              alert(data.message);
            }
          })
          .catch((error) => {
            console.error('Error fetching product details:', error);
          });
      }
    });

    // Handle Delete Button Clicks
    document.addEventListener('click', function (event) {
      if (event.target.closest('.delete-btn')) {
        const btn = event.target.closest('.delete-btn');
        const productId = parseInt(btn.getAttribute('data-id'));

        deleteProductId.value = productId;
        deleteProductName.textContent = btn.closest('tr').querySelector('td:nth-child(2)').textContent;
        deleteModal.show();
      }
    });

    // Confirm Delete
    confirmDeleteBtn.addEventListener('click', function () {
      const id = parseInt(deleteProductId.value);

      fetch('api/delete_product.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === 'success') {
            deleteModal.hide();
            fetchProducts();
            showToast(data.message);
          } else {
            alert(data.message);
          }
        })
        .catch((error) => {
          console.error('Error deleting product:', error);
        });
    });

    // Initial Fetch
    fetchProducts();

    productColor.addEventListener('input', function () {
      // If user enters a valid hex code, update color picker
      let val = productColor.value.trim();
      // Accepts #RRGGBB or #RGB or color names
      let temp = document.createElement('div');
      temp.style.color = val;
      if (temp.style.color !== '') {
        // If it's a valid color name, convert to hex using a trick
        document.body.appendChild(temp);
        let cs = getComputedStyle(temp).color;
        document.body.removeChild(temp);
        // Convert rgb to hex if needed
        let rgb = cs.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        if (rgb) {
          let hex = "#" + ((1 << 24) + (parseInt(rgb[1]) << 16) + (parseInt(rgb[2]) << 8) + parseInt(rgb[3])).toString(16).slice(1).toUpperCase();
          productColorCode.value = hex;
        }
      } else if (/^#([0-9A-Fa-f]{3}){1,2}$/.test(val)) {
        productColorCode.value = val;
      }
    });
  });
</script>
</body>
</html>