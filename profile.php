<?php
//session_start();
include_once "role-validation.php";
require_once "db_connection.php";

// Fetch the user's profile picture from the database
$userId = $_SESSION['user_id']; // Replace with the logged-in user's ID
$stmt = $conn->prepare("SELECT profile_picture FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($profilePicture);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Metro District Designs - ADMIN Profile</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
      margin: 0;
      padding: 0;
    }

    /* Sidebar Styles - Consistent with dashboard.php */
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

    /* Main Content Area Styles - Adjusted for sidebar layout */
    .main-content {
      margin-left: 250px;
      padding: 20px;
    }
    
    .breadcrumb-container {
      padding: 10px 0;
      margin-bottom: 20px;
    }
    
    /* Profile Page Specific Styles */
    .content-area {
      background-color: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      margin-top: 15px;
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
      display: flex;
      justify-content: space-between;
      align-items: center;
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
    
    .edit-icon {
      color: #6c757d;
      cursor: pointer;
    }
    
    .edit-icon:hover {
      color: #0d6efd;
    }
    
    .form-control:disabled {
      background-color: #fff;
      opacity: 1;
      border: none;
      padding: 0;
      height: auto;
      box-shadow: none;
    }
    
    .edit-buttons {
      display: none;
      margin-top: 20px;
    }
    
    .edit-buttons.show {
      display: flex !important;
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
          <img src="images/TSHIRTS/LOGO.jpg" class="logo" alt="Logo">
          <h5 class="brand-name">Metro District Designs</h5>
        </div>
        <a href="dashboard.php" class="sidebar-link">
          <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="admin-orders.php" class="sidebar-link">
            <i class="fas fa-shopping-cart"></i> Orders
        </a>
        <a href="product-stock.php" class="sidebar-link">
          <i class="fas fa-box"></i> Product Stock
        </a>
        <a href="admininquiries.php" class="sidebar-link">
          <i class="fas fa-envelope"></i> Inquiries
        </a>
        <a href="user-admin.php" class="sidebar-link">
          <i class="fas fa-users"></i> Account Manager
        </a>
        <a href="profile.php" class="sidebar-link active">
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
              <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
          </nav>
        </div>
        
        <!-- Profile Content -->
        <div class="content-area">
          <!-- Admin Profile Content -->
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Admin Profile</h3>
            <div>
              <button class="btn btn-primary me-2" id="editProfileBtn">
                <i class="fas fa-edit me-1"></i> Edit Profile
              </button>
              <button class="btn btn-primary" id="profile-change">
                <i class="fas fa-camera me-1"></i> Change Profile Picture
              </button>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-3">
              <div class="profile-picture">
                <?php if(!empty($profilePicture)): ?>
                  <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture" class="img-fluid" style="width: 100px; height: 100px;">
                <?php else: ?>
                  <i class="fas fa-user profile-icon"></i>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-md-9">
              <form id="editProfileForm">
                <div class="user-info">
                  <input type="hidden" name="id" value="<?php echo $_SESSION['user_id'] ?>">
                  <div class="user-info-item">
                    <div class="profile-label">First Name</div>
                    <div class="profile-value">
                      <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" disabled>
                      <i class="fas fa-pen edit-icon field-edit" data-field="fname"></i>
                    </div>
                  </div>
                  <div class="user-info-item">
                    <div class="profile-label">Last Name</div>
                    <div class="profile-value">
                      <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" disabled>
                      <i class="fas fa-pen edit-icon field-edit" data-field="lname"></i>
                    </div>
                  </div>
                  
                  <div class="user-info-item">
                    <div class="profile-label">Username</div>
                    <div class="profile-value">
                      <input type="text" class="form-control" id="username" name="username" placeholder="Username" disabled>
                      <i class="fas fa-pen edit-icon field-edit" data-field="username"></i>
                    </div>
                  </div>
                  
                  <div class="user-info-item">
                    <div class="profile-label">Email</div>
                    <div class="profile-value">
                      <input type="email" class="form-control" id="email" name="email" placeholder="Email" disabled>
                      <i class="fas fa-pen edit-icon field-edit" data-field="email"></i>
                    </div>
                  </div>
                  
                  <div class="user-info-item">
                    <div class="profile-label">Phone Number</div>
                    <div class="profile-value">
                      <input type="text" class="form-control" id="phone" name="phone" placeholder="Contact Number" disabled>
                      <i class="fas fa-pen edit-icon field-edit" data-field="phone"></i>
                    </div>
                  </div>
                  
                  <div class="edit-buttons" id="editButtons">
                    <button type="button" class="btn btn-success me-2" id="saveBtn">Save Changes</button>
                    <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editProfilePictureModal" tabindex="-1" aria-labelledby="editProfilePictureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfilePictureModalLabel">Change Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="profilePictureForm" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
                    <h6>Current Profile Picture:</h6>
                    <div class="text-center mb-3">
                      <?php if(!empty($profilePicture)): ?>
                        <img id="currentProfilePicture" src="<?php echo htmlspecialchars($profilePicture); ?>" alt=" Current Profile Picture" class="img-fluid" style="width: 100px; height: 100px;">
                      <?php else: ?>
                        <i class="fas fa-user profile-icon"></i>
                      <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="profilePictureFile" class="form-label">Upload New Profile Picture</label>
                        <input type="file" class="form-control" id="profilePictureFile" name="profilePictureFile" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const editProfileBtn = document.getElementById("editProfileBtn");
    const fieldEditIcons = document.querySelectorAll(".field-edit");
    const saveBtn = document.getElementById("saveBtn");
    const cancelBtn = document.getElementById("cancelBtn");
    const editButtons = document.getElementById("editButtons");
    const editProfileForm = document.getElementById("editProfileForm");
    const inputs = editProfileForm.querySelectorAll("input, textarea");

    let originalValues = {}; // Store original values for cancel functionality

    // Fetch user details and populate the form
    function fetchUserDetails() {
      fetch("api/get_admin_user_details.php")
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            // Populate form fields with user details
            document.getElementById("fname").value = data.user.first_name;
            document.getElementById("lname").value = data.user.last_name;
            document.getElementById("username").value = data.user.username;
            document.getElementById("email").value = data.user.email;
            document.getElementById("phone").value = "63" + data.user.contact_number;

            // Save original values
            originalValues = { ...data.user };
          } else {
            alert(data.message || "Failed to fetch user details.");
          }
        })
        .catch((error) => {
          console.error("Error fetching user details:", error);
          alert("An error occurred while fetching user details. Please try again.");
        });
    }

    // Enable editing for specific field when pencil icon is clicked
    fieldEditIcons.forEach(icon => {
      icon.addEventListener('click', function() {
        const fieldId = this.getAttribute('data-field');
        const input = document.getElementById(fieldId);
        input.disabled = false;
        input.focus();
        editButtons.classList.add('show');
      });
    });

    // Show pencil icons and enable edit mode when "Edit Profile" button is clicked
    editProfileBtn.addEventListener('click', function() {
      // inputs.forEach(input => {
      //   input.disabled = false;
      // });
      editButtons.classList.add('show');
      fieldEditIcons.forEach((icon) => (icon.style.display = "flex"));
    });

    // Save changes to the backend
    saveBtn.addEventListener("click", function (e) {
        e.preventDefault(); // Prevent default form submission

        // Create a JSON object from the form inputs
        const formData = {};
        inputs.forEach((input) => {
          formData[input.name] = input.value;
        });

        // Send the JSON data to the backend
        fetch("api/update_admin_user.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(formData),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "success") {
                    const alert = document.createElement('div');
                    alert.className = 'alert alert-success mt-3';
                    alert.innerHTML = 'Profile updated successfully!';
                    editProfileForm.appendChild(alert);

                    setTimeout(() => {
                        alert.remove();
                    }, 3000);

                    // Update original values after successful save
                    originalValues = { ...formData };
                    disableFields();
                } else {
                    alert(data.message || "An error occurred while updating the profile.");
                }
            })
            .catch((error) => {
                console.error("Error updating profile:", error);
                alert("An error occurred while updating the profile. Please try again.");
            });
    });

    // Revert changes on cancel
    cancelBtn.addEventListener("click", function () {
      // Revert form fields to original values
      document.getElementById("fname").value = originalValues.first_name;
      document.getElementById("lname").value = originalValues.last_name;
      document.getElementById("username").value = originalValues.username;
      document.getElementById("email").value = originalValues.email;
      document.getElementById("phone").value = originalValues.contact_number;

      disableFields();
    });

    // Disable all form fields and hide pencil icons
    function disableFields() {
      inputs.forEach((input) => (input.disabled = true));
      fieldEditIcons.forEach((icon) => (icon.style.display = "none"));
      editButtons.style.display = "none";
      editButtons.classList.remove("show");
    }

    // Fetch user details on page load
    disableFields();
    fetchUserDetails();
  });   

  // Update current date and time script
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
    document.addEventListener("DOMContentLoaded", function () {
        const profilePictureForm = document.getElementById("profilePictureForm");
        const changeProfilePictureBtn = document.getElementById("profile-change");
        const profilePictureModal = new bootstrap.Modal(document.getElementById("editProfilePictureModal"));

        changeProfilePictureBtn.addEventListener("click", function () {
          profilePictureModal.show();
        });

        profilePictureForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(profilePictureForm);

            fetch("api/upload_profile_picture.php", {
                method: "POST",
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "success") {
                        alert(data.message);
                        window.location.reload();
                        // document.getElementById("currentProfilePicture").src = data.filePath;
                        // const modal = bootstrap.Modal.getInstance(document.getElementById("editProfilePictureModal"));
                        // modal.hide();
                    } else {
                        alert(data.message);
                    }
                })
                .catch((error) => {
                    console.error("Error uploading profile picture:", error);
                    alert("An error occurred while uploading the profile picture. Please try again.");
                });
        });
    });
</script>
</body>
</html>