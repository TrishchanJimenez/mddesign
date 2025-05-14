<?php
session_start();
require_once "db_connection.php";

// Handle email verification via token
if (isset($_GET['token'])) {
    $token = $conn->real_escape_string($_GET['token']);
    $stmt = $conn->prepare("SELECT id FROM users WHERE verification_token = ? AND is_verified = 0");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        // Mark as verified
        $user = $result->fetch_assoc();
        $update = $conn->prepare("UPDATE users SET is_verified = 1, verification_token = NULL WHERE id = ?");
        $update->bind_param("i", $user['id']);
        $update->execute();
        $update->close();
        $_SESSION['registration_success'] = "Email verified! You can now log in.";
    } else {
        $_SESSION['registration_success'] = "Invalid or expired verification link.";
    }
    header("Location: Login.php");
    exit();
}

// Handle login submission
$login_error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Prepare SQL to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, username, password, role, is_verified FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Check if email is verified first
        if ($user['is_verified'] != 1) {
            $login_error = "Please verify your email before logging in. Check your inbox for the verification link.";
        }
        // Verify password only if email is verified
        else if (password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            $cart = [];
            $stmt_cart = $conn->prepare("
                SELECT 
                    p.id AS productId,
                    dp.id AS displayProductId,
                    dp.product_name,
                    p.size,
                    p.color,
                    ci.quantity,
                    p.price,
                    dp.description,
                    (
                        SELECT image_path 
                        FROM display_images di 
                        WHERE di.product_id = dp.id 
                        LIMIT 1
                    ) AS image
                FROM cart_items ci
                INNER JOIN products p ON ci.product_id = p.id
                INNER JOIN display_product dp ON p.name = dp.product_name
                WHERE ci.user_id = ?
            ");
            $stmt_cart->bind_param("i", $user['id']);
            $stmt_cart->execute();
            $result_cart = $stmt_cart->get_result();
            while ($row = $result_cart->fetch_assoc()) {
                $cart[] = [
                    "productId" => $row['productId'],
                    "id" => $row['displayProductId'],
                    "name" => $row['product_name'],
                    "size" => $row['size'],
                    "color" => $row['color'],
                    "quantity" => $row['quantity'],
                    "price" => floatval($row['price']),
                    "description" => $row['description'],
                    "image" => $row['image']
                ];
            }
            $stmt_cart->close();

            // Calculate cartTotal
            $cartTotal = 0;
            foreach ($cart as $item) {
                $cartTotal += $item['price'] * $item['quantity'];
            }

            // Echo JS to set cart and cartTotal in localStorage, then redirect
            echo "<script>
                localStorage.setItem('cart', " . json_encode(json_encode($cart)) . ");
                localStorage.setItem('cartTotal', '" . number_format($cartTotal, 2, '.', '') . "');
                window.location.href = '" . ($user['role'] === 'admin' ? "dashboard.php" : "index.php") . "';
            </script>";
            exit();

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
    .login-links {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 14px;
    }
    .login-links a {
        color: #0056b3;
        text-decoration: none;
    }
    .login-links a:hover {
        text-decoration: underline;
    }
</style>
<body>
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
            <div class="login-links">
                <div>Don't have an account? <a href="Signup.php">Sign Up</a></div>
                <div><a href="forgot_password.php">Forgot Password?</a></div>
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