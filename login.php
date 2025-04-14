<?php
session_start();
require_once "db_connection.php";

// Handle login submission
$login_error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Prepare SQL to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            // Invalid password
            $login_error = "Invalid email or password";
        }
    } else {
        // User not found
        $login_error = "Invalid email or password";
    }

    $stmt->close();
}
?>
<?php
    $page_title = "Metro District Designs - Login";
    require_once "header.php";
?>
<style>
    body {
        background-color: #E5E4E2;
        font-family: Arial, sans-serif;
    }   

    .login-container {
        background-color: #9b9b9b;
        width: 800px;
        padding: 80px;
        text-align: center;
        margin: 80px auto;
    }
    .login-container h2 {
        color: black;
        margin-bottom: 20px;
    }
    .login-form input {
        width: 100%;
        margin-bottom: 25px;
        padding: 8px;
        border: none;
        box-sizing: border-box;
    }
    .login-form button {
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
<body>
    <!-- Navbar -->
    <!-- <nav class="navbar navbar-expand-lg navbar-dark">
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
                    <li class="nav-item"><a class="nav-link" href="Signup.php">SIGNUP</a></li>
                </ul>
            </div>
        </nav>
        </div> -->
    <?php require_once "navbar.php"; ?>

    <div class="login-container">
        <h2>LOGIN</h2>
        
        <?php
        // Display login errors
        if (!empty($login_error)) {
            echo '<div class="error-message">' . htmlspecialchars($login_error) . '</div>';
        }

        // Display any registration success message
        if (isset($_SESSION['registration_success'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['registration_success']) . '</div>';
            unset($_SESSION['registration_success']);
        }
        ?>

        <form class="login-form" action="login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <div class="login-link">
                Don't have an account? <a href="Signup.php">Sign Up</a>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>