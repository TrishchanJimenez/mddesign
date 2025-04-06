<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Metro District Designs - User Profile</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #e6e3dd;
    }
    .header {
      background-color: #222;
      color: white;
      padding: 10px 20px;
      display: flex;
      align-items: center;
    }
    .sidebar {
      background-color: #222;
      color: white;
      height: 100vh;
      padding: 0;
    }
    .sidebar .nav-link {
      color: white;
      padding: 10px 15px;
      border-radius: 0;
      display: flex;
      align-items: center;
    }
    .sidebar .nav-link i {
      margin-right: 10px;
      width: 20px;
      text-align: center;
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
      margin-top: 15px;
    }
    .breadcrumb {
      margin-bottom: 20px;
    }
    .breadcrumb-item a {
      text-decoration: none;
      color: #007bff;
    }
    .breadcrumb-item a.home {
      color: #007bff;
    }
    .footer {
      background-color: #222;
      color: white;
      padding: 8px 15px;
      position: fixed;
      bottom: 0;
      width: 250px;
    }
    .profile-label {
      font-weight: 500;
      margin-bottom: 5px;
      color: #333;
    }
    .profile-value {
      padding-bottom: 10px;
      margin-bottom: 15px;
      font-weight: normal;
      border-bottom: 1px solid #eee;
    }
    .profile-picture {
      width: 100px;
      height: 100px;
      background-color: #f0f0f0;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 15px;
      border-radius: 4px;
    }
    .profile-icon {
      font-size: 60px;
      color: #aaa;
    }
    .btn-primary {
      background-color: #0d6efd;
      border-color: #0d6efd;
    }
    .btn-primary:hover {
      background-color: #0b5ed7;
      border-color: #0a58ca;
    }
    .user-info {
      margin-left: 20px;
    }
    .user-info-item {
      margin-bottom: 20px;
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
    <div class="ms-auto">
      <span class="me-3">Dashboard</span>
      <span>Accounts</span>
    </div>
  </header>

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-3 col-lg-2 sidebar">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-th-large"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-box"></i> Product Stock
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-chart-line"></i> Sales Record
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-users-cog"></i> Account Manager
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="fas fa-user"></i> Profile
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-home"></i> Home
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </li>
        </ul>
        <div class="footer">
          Apr 06, 2025, 08:42 PM
        </div>
      </div>
      
      <!-- Main Content -->
      <div class="col-md-9 col-lg-10 p-4">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="home">Home</a></li>
            <li class="breadcrumb-item active">Profile</li>
          </ol>
        </nav>
        
        <div class="content-area">
          <!-- User Profile Content -->
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>User Profile</h3>
            <button class="btn btn-primary">
              <i class="fas fa-camera me-1"></i> Change Profile Picture
            </button>
          </div>
          
          <div class="row">
            <div class="col-md-3">
              <div class="profile-picture">
                <i class="fas fa-user profile-icon"></i>
              </div>
            </div>
            <div class="col-md-9">
              <div class="user-info">
                <div class="user-info-item">
                  <div class="profile-label">Name</div>
                  <div class="profile-value">John Rey</div>
                </div>
                
                <div class="user-info-item">
                  <div class="profile-label">Username</div>
                  <div class="profile-value">admin</div>
                </div>
                
                <div class="user-info-item">
                  <div class="profile-label">Email</div>
                  <div class="profile-value">jr@gmail.com</div>
                </div>
                
                <div class="user-info-item">
                  <div class="profile-label">Phone Number</div>
                  <div class="profile-value">092312534</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>