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
  $stmt = $conn->prepare("SELECT username, first_name, last_name, email, contact_number FROM users WHERE id = ?");
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $user = $stmt->get_result()->fetch_assoc();
  $stmt->close();

  $regions = [
    "13" => "National Capital Region (NCR)",
    "14" => "Cordillera Administrative Region (CAR)",
    "01" => "Region I (Ilocos Region)",
    "02" => "Region II (Cagayan Valley)",
    "03" => "Region III (Central Luzon)",
    "04" => "Region IV-A (CALABARZON)",
    "17" => "Region IV-B (MIMAROPA)",
    "05" => "Region V (Bicol Region)",
    "06" => "Region VI (Western Visayas)",
    "07" => "Region VII (Central Visayas)",
    "08" => "Region VIII (Eastern Visayas)",
    "09" => "Region IX (Zamboanga Peninsula)",
    "10" => "Region X (Northern Mindanao)",
    "11" => "Region XI (Davao Region)",
    "12" => "Region XII (SOCCSKSARGEN)",
    "16" => "Region XIII (Caraga)",
    "15" => "Bangsamoro Autonomous Region in Muslim Mindanao (BARMM)"
  ];
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
          <label>Addresses</label>
        </div>
        <div class="form-group">
        <?php
            // Direct query to get all user addresses with joined data in a single query
            $stmt = $conn->prepare("
                SELECT 
                    a.id, a.street_address, a.postal_code, 
                    a.brgyCode, a.citymunCode, a.provCode, a.regCode,
                    b.brgyDesc AS barangay,
                    c.citymunDesc AS city,
                    p.provDesc AS province,
                    r.regDesc AS region
                FROM 
                    addresses a
                LEFT JOIN 
                    refbrgy b ON a.brgyCode = b.brgyCode
                LEFT JOIN 
                    refcitymun c ON a.citymunCode = c.citymunCode
                LEFT JOIN 
                    refprovince p ON a.provCode = p.provCode
                LEFT JOIN 
                    refregion r ON a.regCode = r.regCode
                WHERE 
                    a.user_id = ?
                ORDER BY
                    a.id DESC
            ");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $addresses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
          
            if (!empty($addresses)): 
              foreach ($addresses as $address): 
          ?>
              <textarea
                  class="form-control mb-2"
                  rows="2"
                  data-id="<?php echo htmlspecialchars($address['id']); ?>"
                  data-brgycode="<?php echo htmlspecialchars($address['brgyCode']); ?>"
                  data-citymuncode="<?php echo htmlspecialchars($address['citymunCode']); ?>"
                  data-provcode="<?php echo htmlspecialchars($address['provCode']); ?>"
                  data-regcode="<?php echo htmlspecialchars($address['regCode']); ?>"
                  readonly
                  style="resize: none; cursor: edit;"
                  
              ><?php echo htmlspecialchars(
                  $address['street_address'] . ', ' .
                  $address['barangay'] . ', ' .
                  $address['city'] . ', ' .
                  $address['province'] . ', ' .
                  $address['region'] . ' ' .
                  $address['postal_code']
              ); ?></textarea>
          <?php 
              endforeach; 
            else: 
          ?>
              <div class="text-muted">No address on file.</div>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#addAddressModal">
            Add New Address
          </button>
        </div>
        <button type="submit" class="btn btn-primary">Save Profile</button>
    </form> 
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="add-address-form">
            <div class="modal-header">
              <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="region" class="form-label">Region</label>
                <select class="form-select" id="region" name="region" required>
                  <option value="">Select Region</option>
                  <?php foreach ($regions as $code => $name): ?>
                      <option value="<?php echo htmlspecialchars($code); ?>"><?php echo htmlspecialchars($name); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="province" class="form-label">Province</label>
                <select class="form-select" id="province" name="province" required>

                </select>
              </div>
              <div class="mb-3">
                <label for="city" class="form-label">City/Municipality</label>
                <select class="form-select" id="city" name="city" required>

                </select>
              </div>
              <div class="mb-3">
                <label for="barangay" class="form-label">Barangay</label>
                <select class="form-select" id="barangay" name="barangay" required>

                </select>
              </div>
              <div class="mb-3">
                <label for="street_address" class="form-label">Street Address</label>
                <input type="text" class="form-control" id="street_address" name="street_address" required>
              </div>
              <div class="mb-3">
                <label for="address_postal_code" class="form-label">Postal Code</label>
                <input type="text" class="form-control" id="address_postal_code" name="postal_code" required pattern="[0-9]*" maxlength="4">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Save Address</button>
            </div>
          </form>
        </div>
      </div>
    </div>
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
    // const postalCodeInput = document.getElementById('postal-code');
    
    // postalCodeInput.addEventListener('input', function(e) {
    //   // Only allow numbers for postal code
    //   const value = e.target.value;
    //   // Remove any characters that aren't numbers
    //   const filteredValue = value.replace(/[^\d]/g, '');
      
    //   if (value !== filteredValue) {
    //     e.target.value = filteredValue;
    //   }
    // });

    document.getElementById('region').addEventListener('change', function() {
        const regionCode = this.value;
        const provinceDropdown = document.getElementById('province');
        const cityDropdown = document.getElementById('city');
        const barangayDropdown = document.getElementById('barangay');

        if (regionCode) {
            fetch(`api/fetch_locations.php?type=province&regionCode=${regionCode}`)
                .then(response => response.json())
                .then(data => {
                    provinceDropdown.innerHTML = '<option value="">Select Province</option>';
                    data.forEach(province => {
                        const option = document.createElement('option');
                        option.value = province.provCode;
                        option.textContent = province.provDesc;
                        provinceDropdown.appendChild(option);
                    });
                    provinceDropdown.disabled = false;
                });
        } else {
            provinceDropdown.disabled = true;
            cityDropdown.disabled = true;
            barangayDropdown.disabled = true;
        }
    });
    
    document.getElementById('province').addEventListener('change', function() {
        const provinceCode = this.value;
        const cityDropdown = document.getElementById('city');
        const barangayDropdown = document.getElementById('barangay');

        if (provinceCode) {
            fetch(`api/fetch_locations.php?type=city&provinceCode=${provinceCode}`)
                .then(response => response.json())
                .then(data => {
                    cityDropdown.innerHTML = '<option value="">Select City/Municipality</option>';
                    data.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.citymunCode;
                        option.textContent = city.citymunDesc;
                        cityDropdown.appendChild(option);
                    });
                    cityDropdown.disabled = false;
                });
        } else {
            cityDropdown.disabled = true;
            barangayDropdown.disabled = true;
        }
    });
    
    document.getElementById('city').addEventListener('change', function() {
        const cityCode = this.value;
        const barangayDropdown = document.getElementById('barangay');

        if (cityCode) {
            fetch(`api/fetch_locations.php?type=barangay&cityCode=${cityCode}`)
                .then(response => response.json())
                .then(data => {
                    barangayDropdown.innerHTML = '<option value="">Select Barangay</option>';
                    data.forEach(barangay => {
                        const option = document.createElement('option');
                        option.value = barangay.brgyCode;
                        option.textContent = barangay.brgyDesc;
                        barangayDropdown.appendChild(option);
                    });
                    barangayDropdown.disabled = false;
                });
        } else {
            barangayDropdown.disabled = true;
        }
    });

    document.getElementById('add-address-form').addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const addressId = this.querySelector('input[name="address_id"]')?.value;
      const isUpdate = !!addressId;
      
      const data = {
        brgyCode: document.getElementById('barangay').value,
        citymunCode: document.getElementById('city').value,
        provCode: document.getElementById('province').value,
        regCode: document.getElementById('region').value,
        street_address: document.getElementById('street_address').value,
        postal_code: document.getElementById('address_postal_code').value
      };
      
      if (isUpdate) {
        data.id = addressId;
      }
    
      try {
        const endpoint = isUpdate ? 'api/update_address.php' : 'api/add_address.php';
        const response = await fetch(endpoint, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
          alert(isUpdate ? 'Address updated!' : 'Address added!');
          location.reload();
        } else {
          alert(result.error || `Failed to ${isUpdate ? 'update' : 'add'} address.`);
        }
      } catch (err) {
        alert(`Error ${isUpdate ? 'updating' : 'adding'} address.`);
      }
    });

    document.querySelectorAll('textarea[data-id]').forEach(textarea => {
      // When clicking an address, populate and show the edit modal
      textarea.addEventListener('click', async function() {
        const addressId = this.getAttribute('data-id');
        const addressModal = new bootstrap.Modal(document.getElementById('addAddressModal'));
        
        // Change modal title to indicate we're editing
        document.getElementById('addAddressModalLabel').textContent = 'Edit Address';
        
        try {
          const response = await fetch(`api/get_address.php?id=${addressId}`);
          const address = await response.json();
          
          if (address) {
            // Store all retrieved address data
            const addressData = {
              id: addressId,
              street_address: address.street_address,
              postal_code: address.postal_code,
              regCode: address.regCode,
              provCode: address.provCode,
              citymunCode: address.citymunCode,
              brgyCode: address.brgyCode
            };
            
            // Populate the street address and postal code
            document.getElementById('street_address').value = addressData.street_address;
            document.getElementById('address_postal_code').value = addressData.postal_code;
            
            // Set region and trigger the chain of dropdown population
            const regionSelect = document.getElementById('region');
            regionSelect.value = addressData.regCode;
            
            // Instead of using custom events, call the fetch functions directly
            // Fetch provinces for the region
            fetch(`api/fetch_locations.php?type=province&regionCode=${addressData.regCode}`)
              .then(response => response.json())
              .then(data => {
                const provinceDropdown = document.getElementById('province');
                provinceDropdown.innerHTML = '<option value="">Select Province</option>';
                data.forEach(province => {
                  const option = document.createElement('option');
                  option.value = province.provCode;
                  option.textContent = province.provDesc;
                  provinceDropdown.appendChild(option);
                });
                provinceDropdown.disabled = false;
                
                // Set the province value
                provinceDropdown.value = addressData.provCode;
                
                // Fetch cities for the province
                return fetch(`api/fetch_locations.php?type=city&provinceCode=${addressData.provCode}`);
              })
              .then(response => response.json())
              .then(data => {
                const cityDropdown = document.getElementById('city');
                cityDropdown.innerHTML = '<option value="">Select City/Municipality</option>';
                data.forEach(city => {
                  const option = document.createElement('option');
                  option.value = city.citymunCode;
                  option.textContent = city.citymunDesc;
                  cityDropdown.appendChild(option);
                });
                cityDropdown.disabled = false;
                
                // Set the city value
                cityDropdown.value = addressData.citymunCode;
                
                // Fetch barangays for the city
                return fetch(`api/fetch_locations.php?type=barangay&cityCode=${addressData.citymunCode}`);
              })
              .then(response => response.json())
              .then(data => {
                const barangayDropdown = document.getElementById('barangay');
                barangayDropdown.innerHTML = '<option value="">Select Barangay</option>';
                data.forEach(barangay => {
                  const option = document.createElement('option');
                  option.value = barangay.brgyCode;
                  option.textContent = barangay.brgyDesc;
                  barangayDropdown.appendChild(option);
                });
                barangayDropdown.disabled = false;
                
                // Set the barangay value
                barangayDropdown.value = addressData.brgyCode;
                
                // Add the address ID to the form for updating
                const addressForm = document.getElementById('add-address-form');
                
                // If we already have a hidden input for address ID, update it, otherwise create one
                let addressIdInput = addressForm.querySelector('input[name="address_id"]');
                if (!addressIdInput) {
                  addressIdInput = document.createElement('input');
                  addressIdInput.type = 'hidden';
                  addressIdInput.name = 'address_id';
                  addressForm.appendChild(addressIdInput);
                }
                addressIdInput.value = addressId;
                
                // Show the modal after everything is loaded
                addressModal.show();
              });
          }
        } catch (err) {
          console.error(err);
          alert('Error loading address details.');
        }
      });
    });

    // Add reset functionality when the modal is closed
    document.getElementById('addAddressModal').addEventListener('hidden.bs.modal', function() {
      // Reset form and title
      document.getElementById('add-address-form').reset();
      document.getElementById('addAddressModalLabel').textContent = 'Add New Address';
      
      // Remove any address ID
      const addressIdInput = document.querySelector('input[name="address_id"]');
      if (addressIdInput) {
        addressIdInput.remove();
      }
    });
    // Form validation and submission for the profile form only
    const profileForm = document.getElementById('profile-form');

    profileForm.addEventListener('submit', async function(e) {
      e.preventDefault();
      
      // Simple validation - only check inputs within the profile form
      let isValid = true;
      const inputs = profileForm.querySelectorAll('input[required]');
      
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
      
      if (isValid) {
        // Form is valid, submit the data to the backend
        const formData = {
          username: document.getElementById('username').value.trim(),
          first_name: document.getElementById('first-name').value.trim(),
          last_name: document.getElementById('last-name').value.trim(),
          email: document.getElementById('email').value.trim(),
          phone: document.getElementById('phone').value.trim(),
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