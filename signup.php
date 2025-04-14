<?php
session_start();
require_once "db_connection.php";
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
        .signup-form input {
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="/api/placeholder/40/40" class="rounded-circle">
                Metro District Designs
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="Products.php">PRODUCTS</a></li>
                    <li class="nav-item"><a class="nav-link" href="Inquiry.php">INQUIRY</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="Login.php">LOGIN</a></li>
                </ul>
            </div>
        </div>
    </nav>

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
            <textarea name="address" placeholder="Full Address" required></textarea>
            <input type="number" name="postal_code" id="postal_code" placeholder="Postal Code" pattern="[0-9]*" inputmode="numeric" minlength="4" maxlength="4" required>
            <div class="input-help-text">Enter a 4-digit Philippine postal code</div>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <div class="login-link">
                Already have an account? <a href="Login.php">Log In</a>
            </div>
            <button type="submit">Sign Up</button>
        </form>
    </div>

    <!-- Client-side validation for phone number and postal code -->
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
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>