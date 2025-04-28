<?php include_once "role-validation.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Metro District Designs - Account Manager</title>
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

    /* Sidebar styles */
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
      border-radius: 4px;
      margin: 0;
      border: none;
      cursor: pointer;
      transition: all 0.2s;
      background-color: #dc3545;
      color: white;
    }
    
    .action-btn:hover {
      background-color: #bb2d3b;
    }
    
    .add-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 8px 16px;
      font-weight: 500;
      background-color: #0d6efd;
      border: none;
      color: white;
      transition: all 0.3s;
      border-radius: 4px;
    }
    
    .add-btn:hover {
      background-color: #0b5ed7;
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
      color: #0d6efd;
    }
    
    /* Search container */
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
    
    /* Empty state */
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
      color: #0d6efd;
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
        width: 100%;
        position: static;
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
      <!-- Sidebar -->
      <div class="col-auto">
        <div class="sidebar">
          <div class="logo-container">
            <img src="/api/placeholder/40/40" class="logo" alt="Logo">
            <h5 class="brand-name">Metro District Designs</h5>
          </div>
          <a href="dashboard.php" class="sidebar-link">
            <i class="fas fa-tachometer-alt"></i> Dashboard
          </a>
          <a href="product-stock.php" class="sidebar-link">
            <i class="fas fa-box"></i> Product Stock
          </a>
          <a href="admininquiries.php" class="sidebar-link">
            <i class="fas fa-envelope"></i> Inquiries
          </a>
          <a href="user-admin.php" class="sidebar-link active">
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
                <li class="breadcrumb-item active" aria-current="page">Account Manager</li>
              </ol>
            </nav>
          </div>
          
          <!-- Page Title -->
          <div class="page-title">
            <span>User Accounts</span>
            <button class="btn add-btn" id="addNewUserBtn">
              <i class="fas fa-plus-circle"></i> Add User
            </button>
          </div>
          
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control search-input" id="searchUsers" placeholder="Search users...">
              </div>
            </div>
          </div>
          
          <div class="content-area">
            <div class="card">
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-bordered mb-0" id="usersTable">
                    <thead>
                      <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Edit</th>
                      </tr>
                    </thead>
                    <tbody id="userTableBody">
                      <!-- User data will be populated by JavaScript -->
                    </tbody>
                  </table>
                </div>
                
                <!-- Empty state message - only shows when no users -->
                <div class="empty-state" id="emptyState" style="display: none;">
                  <i class="fas fa-users"></i>
                  <h4>No Users Found</h4>
                  <p>Click "Add User" to add users to the system.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add/Edit User Modal -->
  <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="userModalLabel">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="userForm">
            <input type="hidden" id="editUserId">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="userFirstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="userFirstName" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="userLastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="userLastName" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="userEmail" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="userEmail" required>
            </div>
            <div class="mb-3">
              <label for="userPhone" class="form-label">Phone Number</label>
              <input type="text" class="form-control" id="userPhone">
            </div>
            <div class="mb-3">
              <label for="userUsername" class="form-label">Username</label>
              <input type="text" class="form-control" id="userUsername" required>
            </div>
            <div class="mb-3" id="passwordFieldContainer">
              <label for="userPassword" class="form-label">Password</label>
              <input type="password" class="form-control" id="userPassword" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="saveUserBtn">Save User</button>
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
          <p>Are you sure you want to delete this user? This action cannot be undone.</p>
          <p><strong>User: </strong><span id="deleteUserName"></span></p>
          <input type="hidden" id="deleteUserId">
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
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize users array with sample data from the screenshot
      let users = [];

      // DOM References
      const userTableBody = document.getElementById('userTableBody');
      const emptyState = document.getElementById('emptyState');
      const usersTable = document.getElementById('usersTable');
      const searchInput = document.getElementById('searchUsers');
      
      // Modal references
      const userModal = new bootstrap.Modal(document.getElementById('userModal'));
      const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
      const toastNotification = new bootstrap.Toast(document.getElementById('toastNotification'));
      
      // Form elements
      const editUserId = document.getElementById('editUserId');
      const userFirstName = document.getElementById('userFirstName');
      const userLastName = document.getElementById('userLastName');
      const userEmail = document.getElementById('userEmail');
      const userPhone = document.getElementById('userPhone');
      const userUsername = document.getElementById('userUsername');
      const userPassword = document.getElementById('userPassword');
      const passwordFieldContainer = document.getElementById('passwordFieldContainer');
      const userModalLabel = document.getElementById('userModalLabel');
      
      // Delete confirmation elements
      const deleteUserId = document.getElementById('deleteUserId');
      const deleteUserName = document.getElementById('deleteUserName');
      
      // Button references
      const addNewUserBtn = document.getElementById('addNewUserBtn');
      const saveUserBtn = document.getElementById('saveUserBtn');
      const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
      
      // Toast message
      const toastMessage = document.getElementById('toastMessage');

      // Function to show toast notification
      function showToast(message) {
        toastMessage.textContent = message;
        toastNotification.show();
      }

      // Function to fetch users from the backend
      async function fetchUsers() {
        try {
          const response = await fetch('api/get_users.php');
          const result = await response.json();

          if (result.status === 'success' && Array.isArray(result.data)) {
            users = result.data; // Assign the array of users to the `users` variable
            renderUsers(users);  // Pass the array to the `renderUsers` function
          } else {
            console.error('Unexpected response format:', result);
            users = []; // Fallback to an empty array
            renderUsers(users);
          }
        } catch (error) {
          console.error('Error fetching users:', error);
          users = []; // Fallback to an empty array
          renderUsers(users);
        }
      }

      // Function to render users table
      function renderUsers(usersList = users) {
        userTableBody.innerHTML = '';
        
        if (usersList.length === 0) {
          emptyState.style.display = 'flex';
          usersTable.style.display = 'none';
        } else {
          emptyState.style.display = 'none';
          usersTable.style.display = 'table';
          
          usersList.forEach(user => {
            const row = document.createElement('tr');
            row.setAttribute('data-id', user.id);
            
            row.innerHTML = `
              <td>${user.id}</td>
              <td>${user.first_name} ${user.last_name}</td>
              <td>${user.email}</td>
              <td>+63${user.contact_number}</td>
              <td>${user.username}</td>
              <td>${user.role}</td>
              <td>
                <button class="action-btn delete-btn" data-id="${user.id}">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            `;
            
            // Add click event to the entire row for editing
            row.addEventListener('click', function(e) {
              // Don't trigger edit if click was on delete button
              if (!e.target.closest('.delete-btn')) {
                editUser(user.id);
              }
            });
            
            userTableBody.appendChild(row);
          });
        }
      }

      // Function to edit user
      function editUser(userId) {
        const user = users.find(u => u.id === userId);
        
        if (user) {
          editUserId.value = user.id;
          userFirstName.value = user.first_name;
          userLastName.value = user.last_name;
          userEmail.value = user.email;
          userPhone.value = "63" + user.contact_number;
          userUsername.value = user.username;

          userPassword.removeAttribute('required');
          passwordFieldContainer.querySelector('label').textContent = 'Password (leave blank to keep current)';
          userPassword.value = '';

          userModalLabel.textContent = 'Edit User';
          userModal.show();
        }
      }

      // Search functionality
      searchInput.addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase().trim();

        if (searchTerm === '') {
          renderUsers();
        } else {
          const filteredUsers = users.filter(user => {
            return (
              `${user.first_name} ${user.last_name}`.toLowerCase().includes(searchTerm) || // Combine first and last name
              user.email.toLowerCase().includes(searchTerm) ||
              user.username.toLowerCase().includes(searchTerm) ||
              (user.contact_number && user.contact_number.includes(searchTerm))
            );
          });

          renderUsers(filteredUsers);
        }
      });

      // Open add user modal
      addNewUserBtn.addEventListener('click', function() {
        // Reset form
        document.getElementById('userForm').reset();
        editUserId.value = '';
        
        // Password is required when adding new user
        userPassword.setAttribute('required', 'required');
        passwordFieldContainer.querySelector('label').textContent = 'Password';
        
        userModalLabel.textContent = 'Add New User';
        userModal.show();
      });

      // Save user (add or edit)
      saveUserBtn.addEventListener('click', async function() {
        // Validate form
        const form = document.getElementById('userForm');
        if (!form.checkValidity()) {
          form.reportValidity();
          return;
        }
        
        const id = editUserId.value ? parseInt(editUserId.value) : null;
        const fname = userFirstName.value.trim();
        const lname = userLastName.value.trim();
        const email = userEmail.value.trim();
        const phone = userPhone.value.trim();
        const username = userUsername.value.trim();
        const password = userPassword.value;
        
        const payload = {
          id,
          fname,
          lname,
          email,
          phone,
          username,
          password
        };

        try {
          const response = await fetch(id ? 'api/update_admin_user.php' : 'api/add_admin_user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
          });

          const result = await response.json();
          if (result.status === 'success') {
            showToast(result.message);
            userModal.hide();
            fetchUsers();
          } else {
            showToast(result.message);
          }
        } catch (error) {
          console.error('Error saving user:', error);
        }
      });

      // Handle delete button clicks
      document.addEventListener('click', function (event) {
        if (event.target.closest('.delete-btn')) {
          const btn = event.target.closest('.delete-btn');
          const userId = parseInt(btn.getAttribute('data-id'));
          const user = users.find(u => u.id === userId);

          if (user) {
            deleteUserId.value = user.id;
            deleteUserName.textContent = `${user.first_name} ${user.last_name}`;
            deleteModal.show();
          }

          event.stopPropagation();
        }
      });

      // Confirm delete
      confirmDeleteBtn.addEventListener('click', async function () {
        const userId = parseInt(deleteUserId.value);

        try {
          const response = await fetch('api/delete_user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_id: userId })
          });

          const result = await response.json();
          if (result.status === 'success') {
            showToast(result.message);
            deleteModal.hide();
            fetchUsers();
          } else {
            showToast(result.message);
          }
        } catch (error) {
          console.error('Error deleting user:', error);
        }
      });

      // Initial fetch of users
      fetchUsers();
    });
  </script>
</body>
</html>