<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Metro District Designs - Account Manager</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f5f5;
    }
    .header {
      background-color: #212529;
      color: white;
      padding: 10px 20px;
      display: flex;
      align-items: center;
    }
    .system-header {
      background-color: #0b5b61;
      color: white;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .sidebar {
      background-color: #0b5b61;
      color: white;
      height: calc(100vh - 134px);
      padding: 0;
    }
    .sidebar .nav-link {
      color: white;
      padding: 10px 20px;
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
      border-radius: 0;
      padding: 20px;
    }
    .breadcrumb {
      margin-bottom: 20px;
    }
    .breadcrumb-item a {
      text-decoration: none;
    }
    .footer {
      background-color: #65cbdb;
      color: #333;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
    }
    .table-dark th {
      background-color: #212529;
    }
    .btn-edit {
      background-color: #dc3545;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 4px;
    }
    .timestamp {
      background-color: #0b5b61;
      color: white;
      padding: 5px 10px;
      font-size: 0.9rem;
    }
    .user-info {
      background-color: white;
      padding: 8px 15px;
      border-radius: 5px;
      color: #333;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="header">
    <div class="d-flex align-items-center">
      <img src="/api/placeholder/40/40" alt="Logo" class="me-2" style="border-radius: 50%;">
      <span class="h5 mb-0">Metro District Designs</span>
    </div>
  </header>

  <!-- System Header -->
  <div class="system-header">
    <div class="d-flex align-items-center">
      <img src="/api/placeholder/30/30" alt="System Icon" class="me-2">
      <span class="h5 mb-0">Retail Stock Management System</span>
    </div>
    <div class="user-info">
      <i class="fas fa-user me-1"></i> Richard
    </div>
  </div>

  <div class="container-fluid p-0">
    <div class="row g-0">
      <!-- Timestamp Bar -->
      <div class="col-12 timestamp">
        May 30, 2024, 3:35 AM
      </div>
      
      <!-- Sidebar -->
      <div class="col-md-2 sidebar">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="#" class="nav-link">Dashboard</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Product Stock</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Sales Record</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">Account Manager</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" style="padding-left: 40px;">Profile</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" style="padding-left: 40px;">Home</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Logout</a>
          </li>
        </ul>
      </div>
      
      <!-- Main Content -->
      <div class="col-md-10">
        <div class="content-area">
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Account Manager</li>
            </ol>
          </nav>
          
          <!-- User Accounts Section -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">User Accounts</h3>
            <button class="btn btn-primary">
              <i class="fas fa-plus-circle me-1"></i> Add User
            </button>
          </div>
          
          <!-- User Table -->
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="table-dark">
                <tr>
                  <th>#ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone Number</th>
                  <th>Username</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>7</td>
                  <td>Anthony Edwards</td>
                  <td>ant_man@gmail.com</td>
                  <td>00</td>
                  <td>ant_man5</td>
                  <td class="text-center">
                    <button class="btn-edit"><i class="fas fa-edit"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>8</td>
                  <td>Nikola Jokić</td>
                  <td>Nikola_joker15@yahoo.com</td>
                  <td>00</td>
                  <td>Joker15</td>
                  <td class="text-center">
                    <button class="btn-edit"><i class="fas fa-edit"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>9</td>
                  <td>jin eck</td>
                  <td>jsvs@gmail.com</td>
                  <td>00</td>
                  <td>Jin</td>
                  <td class="text-center">
                    <button class="btn-edit"><i class="fas fa-edit"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>10</td>
                  <td>Thanasis Antetokounmpo</td>
                  <td>thanasis123@gmail.com</td>
                  <td>09159539824</td>
                  <td>thanasis_goat</td>
                  <td class="text-center">
                    <button class="btn-edit"><i class="fas fa-edit"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>11</td>
                  <td>Lebron James</td>
                  <td>lbj_goat@yahoo.com</td>
                  <td>00279439410</td>
                  <td>lbj_goat</td>
                  <td class="text-center">
                    <button class="btn-edit"><i class="fas fa-edit"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>12</td>
                  <td>Richard Padilla</td>
                  <td>rpadilla@microsoft.com</td>
                  <td>06958271418</td>
                  <td>richards</td>
                  <td class="text-center">
                    <button class="btn-edit"><i class="fas fa-edit"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      <div class="quote">
        "The best preparation for tomorrow is doing your best today." - H. Jackson Brown, Jr.
      </div>
      <div class="contact text-end">
        Email: developer@gmail.com |<br>
        Phone: +12 345 6789 902 |<br>
        Tel: 012-345-6789
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>