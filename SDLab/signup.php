    <?php
    session_start();
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "metrodistrictdesigns";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="Homepage.php">
                <img src="/api/placeholder/40/40" class="rounded-circle">
                Metro District Designs
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="Homepage.php">HOME</a></li>
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
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <div class="login-link">
                Already have an account? <a href="Login.php">Log In</a>
            </div>
            <button type="submit">Sign Up</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>