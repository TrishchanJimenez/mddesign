<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Metro District Designs</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #e6e3dd;
    }
    .logo-text {
      font-weight: bold;
    }
    .sidebar {
      background-color: #0c5a5e;
      color: white;
      height: 100vh;
      padding: 0;
    }
    .sidebar .nav-link {
      color: white;
      padding: 10px 15px;
      border-radius: 0;
    }
    .sidebar .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }
    .sidebar .nav-link.active {
      background-color: rgba(255, 255, 255, 0.2);
    }
    .content-area {
      background-color: white;
      border-radius: 4px;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .breadcrumb {
      margin-bottom: 20px;
    }
    .breadcrumb-item a {
      text-decoration: none;
    }
    .footer {
      background-color: #222;
      color: white;
      padding: 8px 15px;
      position: fixed;
      bottom: 0;
      width: 250px;
      text-align: center;
    }
    .btn-primary {
      background-color: #0d6efd;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-3 col-lg-2 sidebar">
        <div class="d-flex align-items-center p-3">
          <img src="/api/placeholder/40/40" alt="Logo" class="me-2" style="border-radius: 50%;">
          <span class="logo-text">Metro District Designs</span>
        </div>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="#" class="nav-link">Dashboard</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Product Stock</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">Sales Record</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Supplier List</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Supplier Deliveries</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Account Manager</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Profile</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Logout</a>
          </li>
        </ul>
        <div class="footer">
          Apr 02, 2025, 11:39 PM
        </div>
      </div>
      
      <!-- Main Content -->
      <div class="col-md-9 col-lg-10 p-4">
        <div class="content-area">
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sales Record</li>
            </ol>
          </nav>
          
          <!-- Sales Record Content -->
          <div class="mb-4">
            <h3>Sales Record</h3>
          </div>
          
          <!-- Filter Section -->
          <div class="row mb-4 align-items-center">
            <div class="col-md-6">
              <div class="d-flex align-items-center">
                <label for="date-filter" class="me-2">Filter by day:</label>
                <input type="date" id="date-filter" class="form-control me-2" value="2025-04-02" style="width: auto;">
                <button class="btn btn-outline-primary">Filter</button>
              </div>
            </div>
            <div class="col-md-6 text-md-end">
              <button class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Sales
              </button>
            </div>
          </div>
          
          <!-- Results Section -->
          <div>
            <p>0 results</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>