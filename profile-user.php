<?php
  session_start();
  $page_title = "Metro District Designs - User Profile";
  require_once "header.php";

  require_once "db_connection.php";

  // Ensure the user is logged in
  if (!isset($_SESSION['user_id'])) {
      header("Location: Login.php");
      exit;
  }

  $userId = $_SESSION['user_id'];

  // Fetch user information
  $stmt = $conn->prepare("SELECT username, first_name, last_name, email, contact_number, address, postal_code FROM users WHERE id = ?");
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $user = $stmt->get_result()->fetch_assoc();
  $stmt->close();
?>
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
    justify-content: space-between;
  }
  .header-logo {
    display: flex;
    align-items: center;
  }
  .header-nav {
    display: flex;
    align-items: center;
  }
  .header-nav a {
    color: white;
    text-decoration: none;
    margin: 0 15px;
    text-transform: uppercase;
    font-size: 14px;
  }
  .header-nav a:hover {
    color: #e6e3dd;
  }
  .user-actions {
    display: flex;
    align-items: center;
  }
  .user-actions a {
    color: white;
    text-decoration: none;
    margin-left: 20px;
    text-transform: uppercase;
    font-size: 14px;
    display: flex;
    align-items: center;
  }
  .user-actions a i {
    margin-left: 8px; /* Increased spacing between Login text and icon */
  }
  .content-area {
    background-color: white;
    border-radius: 4px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    margin-top: 30px;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
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
  .profile-header {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
  }
  .profile-title {
    margin-left: 20px;
  }
  .profile-title h2 {
    margin: 0 0 10px 0;
    color: #333;
  }
  .profile-title p {
    margin: 0;
    color: #666;
  }
  .form-group {
    margin-bottom: 20px;
  }
  .form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #555;
  }
  .form-row {
    display: flex;
    gap: 20px;
  }
  .form-row .form-group {
    flex: 1;
  }
  .btn-primary {
    background-color: #222;
    border-color: #222;
    padding: 10px 20px;
    font-size: 16px;
  }
  .btn-primary:hover {
    background-color: #444;
    border-color: #444;
  }
  /* Add error state styling */
  .form-control.error {
    border-color: #dc3545;
  }
  .error-message {
    color: #dc3545;
    font-size: 12px;
    margin-top: 5px;
  }
</style>
<body>
  <!-- Header -->
  <?php require_once "navbar.php" ?>

  <div class="container">
    <!-- Profile Form -->
    <div class="content-area">
      <div class="profile-header">
        <div class="profile-picture">
          <i class="fas fa-user profile-icon"></i>
        </div>
        <div class="profile-title">
          <h2>Your Profile</h2>
          <p>Update your personal information</p>
        </div>
      </div>
      
      <form id="profile-form">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="first-name" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="last-name" class="form-control" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <div class="input-group">
                    <span class="input-group-text">+63</span>
                    <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['contact_number']); ?>" placeholder="9XX XXX XXXX" maxlength="10" required>
                </div>
                <small class="text-muted">Philippines mobile number (e.g., 9XX XXX XXXX)</small>
            </div>
        </div>
        
        <div class="form-group">
            <label for="complete-address">Complete Address (House number, building, street name)</label>
            <textarea id="complete-address" name="complete-address" class="form-control" rows="3" required><?php echo htmlspecialchars($user['address']); ?></textarea>
        </div>
    
        <div class="form-group">
            <label for="postal-code">Postal Code</label>
            <input type="text" id="postal-code" name="postal-code" class="form-control" value="<?php echo htmlspecialchars($user['postal_code']); ?>" placeholder="Numbers only" pattern="[0-9]*" inputmode="numeric" maxlength="4" required>
            <small class="text-muted">Enter numeric postal code (e.g., 1234)</small>
        </div>
        
        <button type="submit" class="btn btn-primary">Save Profile</button>
    </form> 
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
   <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Philippines phone number validation
    const phoneInput = document.getElementById('phone');
    
    phoneInput.addEventListener('input', function(e) {
      let value = e.target.value;

      // Remove any characters that aren't numbers
      value = value.replace(/[^\d]/g, '');

      // Ensure it starts with 9 (standard for PH mobile)
      if (value.length > 0 && value.charAt(0) !== '9') {
        value = '9' + value.substring(1, 10);
      }

      // Limit to 10 digits (9XX XXX XXXX)
      e.target.value = value.substring(0, 10);
    });
    
    // Postal code validation - numbers only
    const postalCodeInput = document.getElementById('postal-code');
    
    postalCodeInput.addEventListener('input', function(e) {
      // Only allow numbers for postal code
      const value = e.target.value;
      // Remove any characters that aren't numbers
      const filteredValue = value.replace(/[^\d]/g, '');
      
      if (value !== filteredValue) {
        e.target.value = filteredValue;
      }
    });
    
    // Form validation and submission
    const profileForm = document.getElementById('profile-form');
    
    profileForm.addEventListener('submit', async function(e) {
      e.preventDefault();
      
      // Simple validation
      let isValid = true;
      const inputs = profileForm.querySelectorAll('input[required], textarea[required]');
      
      inputs.forEach(input => {
        if (!input.value.trim()) {
          input.classList.add('error');
          isValid = false;
          
          // Check if error message exists, if not create one
          let errorMsg = input.nextElementSibling;
          if (!errorMsg || !errorMsg.classList.contains('error-message')) {
            errorMsg = document.createElement('div');
            errorMsg.classList.add('error-message');
            errorMsg.textContent = 'This field is required';
            
            // Special handling for phone input which is in an input group
            if (input.id === 'phone') {
              const inputGroup = input.closest('.input-group');
              inputGroup.parentNode.insertBefore(errorMsg, inputGroup.nextSibling);
            } else {
              input.parentNode.insertBefore(errorMsg, input.nextSibling);
            }
          }
        } else {
          input.classList.remove('error');
          
          // Remove error message if it exists
          let errorMsg;
          if (input.id === 'phone') {
            const inputGroup = input.closest('.input-group');
            errorMsg = inputGroup.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains('error-message')) {
              errorMsg.remove();
            }
          } else {
            errorMsg = input.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains('error-message')) {
              errorMsg.remove();
            }
          }
        }
      });
      
      // Phone number validation
      if (phoneInput.value) {
        // Must be 10 digits and start with 9
        if (phoneInput.value.length < 10 || phoneInput.value.charAt(0) !== '9') {
          phoneInput.classList.add('error');
          
          // Check if error message exists, if not create one
          const inputGroup = phoneInput.closest('.input-group');
          let errorMsg = inputGroup.nextElementSibling;
          if (!errorMsg || !errorMsg.classList.contains('error-message')) {
            errorMsg = document.createElement('div');
            errorMsg.classList.add('error-message');
            errorMsg.textContent = 'Please enter a valid Philippine mobile number starting with 9';
            inputGroup.parentNode.insertBefore(errorMsg, inputGroup.nextSibling.nextSibling);
          }
          
          isValid = false;
        }
      }
      
      // Postal code validation
      if (postalCodeInput.value) {
        // Must contain only numbers
        if (!/^\d+$/.test(postalCodeInput.value)) {
          postalCodeInput.classList.add('error');
          
          // Check if error message exists, if not create one
          let errorMsg = postalCodeInput.nextElementSibling;
          if (!errorMsg || !errorMsg.classList.contains('error-message')) {
            errorMsg = document.createElement('div');
            errorMsg.classList.add('error-message');
            errorMsg.textContent = 'Postal code must contain only numbers';
            postalCodeInput.parentNode.insertBefore(errorMsg, postalCodeInput.nextSibling);
          }
          
          isValid = false;
        }
      }
      
      if (isValid) {
        // Form is valid, submit the data to the backend
        const formData = {
          username: document.getElementById('username').value.trim(),
          first_name: document.getElementById('first-name').value.trim(),
          last_name: document.getElementById('last-name').value.trim(),
          email: document.getElementById('email').value.trim(),
          phone: document.getElementById('phone').value.trim(),
          address: document.getElementById('complete-address').value.trim(),
          postal_code: document.getElementById('postal-code').value.trim()
        };
  
        try {
          const response = await fetch('api/update_profile.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
          });
  
          const result = await response.json();
  
          if (response.ok) {
            alert(result.message);
          } else {
            alert(result.error || 'An error occurred while updating your profile.');
          }
        } catch (error) {
          console.error('Error:', error);
          alert('An error occurred. Please try again.');
        }
      }
    });
  });
  </script> 
</body>
</html>