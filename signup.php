<?php
session_start();
require_once "db_connection.php";

// These arrays would typically come from your database
// For demonstration, I'm including sample data for Philippines locations
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metro District Designs - Sign Up</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #E5E4E2;
            font-family: Arial, sans-serif;
        }   

        .navbar {
            background-color: #1E1E1E;
            padding: 10px 0;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            color: white !important;
            font-weight: bold;
        }

        .navbar-brand img {
            height: 30px;
            margin-right: 10px;
        }

        .navbar-nav {
            flex-grow: 1;
            justify-content: center;
        }

        .navbar-nav .nav-link {
            color: white !important;
            text-transform: uppercase;
            font-weight: bold;
            margin: 0 10px;
        }

        .signup-container {
            background-color: #9b9b9b;
            width: 800px;
            padding: 80px;
            text-align: center;
            margin: 80px auto;
        }
        .signup-container h2 {
            color: black;
            margin-bottom: 20px;
        }
        .signup-form input, .signup-form select {
            width: 100%;
            margin-bottom: 25px;
            padding: 8px;
            border: none;
            box-sizing: border-box;
        }
        .signup-form .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 0;
        }
        .signup-form .form-row .form-group {
            flex: 1;
        }
        .signup-form textarea {
            width: 100%;
            margin-bottom: 25px;
            padding: 8px;
            border: none;
            box-sizing: border-box;
            resize: vertical;
            min-height: 80px;
        }
        .signup-form button {
            width: 100%;
            padding: 10px;
            background-color: white;
            border: none;
            cursor: pointer;
            margin-top: 15px;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
        }
        .login-link {
            margin-bottom: 15px;
        }
        .input-help-text {
            font-size: 12px;
            color: #333;
            text-align: left;
            margin-top: -20px;
            margin-bottom: 15px;
        }
        .section-header {
            font-weight: bold;
            text-align: left;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include "navbar.php"; ?>

    <div class="signup-container">
        <h2>SIGN UP</h2>
        
        <?php
        // Display any registration errors
        if (isset($_SESSION['registration_errors'])) {
            echo '<div class="error-message">';
            foreach ($_SESSION['registration_errors'] as $error) {
                echo '<p>' . htmlspecialchars($error) . '</p>';
            }
            echo '</div>';
            unset($_SESSION['registration_errors']);
        }
        ?>

        <form class="signup-form" action="register.php" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="first_name" placeholder="First Name" required>
                </div>
                <div class="form-group">
                    <input type="text" name="last_name" placeholder="Last Name" required>
                </div>
            </div>
            <input type="text" name="username" placeholder="Username" required>
            <input type="tel" name="contact_number" id="contact_number" placeholder="Contact Number (e.g., 09123456789)" pattern="^(09|\+639)\d{9}$" maxlength="11" required>
            <div class="input-help-text">Enter a Philippine mobile number (e.g., 09123456789)</div>
            <input type="email" name="email" placeholder="Email" required>
            
            <!-- Address Section with Dropdowns -->
            <div class="section-header">Complete Address</div>
            
            <select name="region" id="region" required>
                <option value="">Select Region</option>
                <?php foreach ($regions as $code => $name): ?>
                    <option value="<?php echo htmlspecialchars($code); ?>"><?php echo htmlspecialchars($name); ?></option>
                <?php endforeach; ?>
            </select>
            
            <select name="province" id="province" required disabled>
                <option value="">Select Province</option>
                <!-- Will be populated via AJAX -->
            </select>
            
            <select name="city" id="city" required disabled>
                <option value="">Select City/Municipality</option>
                <!-- Will be populated via AJAX -->
            </select>
            
            <select name="barangay" id="barangay" required disabled>
                <option value="">Select Barangay</option>
                <!-- Will be populated via AJAX -->
            </select>
            
            <input type="text" name="street_address" id="street_address" placeholder="House/Lot/Unit Number, Building, Street Name" required>
            
            <input type="number" name="postal_code" id="postal_code" placeholder="Postal Code" pattern="[0-9]*" inputmode="numeric" minlength="4" maxlength="4" required>
            <div class="input-help-text">Enter a 4-digit Philippine postal code</div>
            
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            
            <div class="login-link">
                Already have an account? <a href="Login.php">Log In</a>
            </div>
            <button type="submit">Sign Up</button>
            
            <!-- Hidden input to store the complete address -->
            <input type="hidden" name="address" id="address">
        </form>
    </div>

    <!-- Client-side validation and AJAX for address dropdowns -->
    <script>
        // Ensure postal code only accepts numbers and is limited to 4 digits (Philippine standard)
        document.querySelector('#postal_code').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 4) {
                this.value = this.value.slice(0, 4);
            }
        });

        // Ensure phone number follows Philippine format
        document.querySelector('#contact_number').addEventListener('input', function(e) {
            // Remove non-digits
            this.value = this.value.replace(/[^0-9+]/g, '');
            
            // Ensure it follows Philippine format
            if (this.value.startsWith('+63')) {
                if (this.value.length > 12) {
                    this.value = this.value.slice(0, 12);
                }
            } else if (this.value.startsWith('09')) {
                if (this.value.length > 11) {
                    this.value = this.value.slice(0, 11);
                }
            } else if (this.value.startsWith('0')) {
                // Ensure it starts with '09'
                if (this.value.length > 1 && this.value[0] !== '9') {
                    this.value = '9' + this.value.slice(2);
                }
            } else if (this.value.length > 0 && !this.value.startsWith('+')) {
                // If it doesn't start with '+' or '0', prepend '09'
                this.value = '9' + this.value;
            }
        });
        
        // Handle address dropdown dependencies
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
        
        document.getElementById('street_address').addEventListener('input', function() {
            updateCompleteAddress();
        });
        
        // Function to update the hidden complete address field
        function updateCompleteAddress() {
            const streetAddress = document.getElementById('street_address').value;
            const barangay = document.getElementById('barangay').options[document.getElementById('barangay').selectedIndex]?.text || '';
            const city = document.getElementById('city').options[document.getElementById('city').selectedIndex]?.text || '';
            const province = document.getElementById('province').options[document.getElementById('province').selectedIndex]?.text || '';
            const region = document.getElementById('region').options[document.getElementById('region').selectedIndex]?.text || '';
            const postalCode = document.getElementById('postal_code').value;
            
            let addressParts = [streetAddress, barangay, city, province, region];
            // Filter out empty parts
            addressParts = addressParts.filter(part => part.trim() !== '');
            
            const completeAddress = addressParts.join(', ') + (postalCode ? ' ' + postalCode : '');
            document.getElementById('address').value = completeAddress;
        }
        
        // Add form submission handler to ensure complete address is updated before submission
        document.querySelector('.signup-form').addEventListener('submit', function(e) {
            updateCompleteAddress();
        });

        const signupForm = document.querySelector('.signup-form');
        signupForm.addEventListener('submit', function(e) {
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;

            if (password !== confirmPassword) {
                e.preventDefault(); // Prevent form submission
                alert('Passwords do not match. Please try again.');
            } else if(password.length < 8) {

            } else {
                signupForm.removeEventListener('submit', arguments.callee);
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>