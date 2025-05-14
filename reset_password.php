<?php
session_start();
require_once "db_connection.php";

$token_valid = false;
$token = "";
$message = "";

// Check if token is provided
if (isset($_GET['token'])) {
    $token = $conn->real_escape_string($_GET['token']);
    
    // Verify token is valid and not expired
    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expires > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $token_valid = true;
    } else {
        $message = "Invalid or expired reset token. Please request a new password reset.";
    }
    $stmt->close();
}

// Handle password reset submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['token']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $token = $conn->real_escape_string($_POST['token']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate password
    if (strlen($password) < 8) {
        $message = "Password must be at least 8 characters long.";
    } else if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        // Check token again
        $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expires > NOW()");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Hash new password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Update password and clear reset token
            $update = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
            $update->bind_param("si", $hashed_password, $user['id']);
            $update->execute();
            
            if ($update->affected_rows === 1) {
                $_SESSION['registration_success'] = "Password has been reset successfully. You can now log in with your new password.";
                header("Location: login.php");
                exit();
            } else {
                $message = "An error occurred. Please try again later.";
            }
        } else {
            $message = "Invalid or expired reset token. Please request a new password reset.";
        }
        $stmt->close();
    }
}

$page_title = "Metro District Designs - Reset Password";
require_once "header.php";
?>

<style>
    body {
        background-color: #E5E4E2;
        font-family: Arial, sans-serif;
    }   

    .reset-container {
        background-color: #9b9b9b;
        width: 800px;
        padding: 80px;
        text-align: center;
        margin: 80px auto;
    }
    
    .reset-container h2 {
        color: black;
        margin-bottom: 20px;
    }
    
    .reset-form input {
        width: 100%;
        margin-bottom: 25px;
        padding: 8px;
        border: none;
        box-sizing: border-box;
    }
    
    .reset-form button {
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
    
    .back-link {
        margin-top: 15px;
        display: block;
    }
    
    .back-link a {
        color: #0056b3;
        text-decoration: none;
    }
    
    .back-link a:hover {
        text-decoration: underline;
    }
</style>

<body>
    <?php require_once "navbar.php"; ?>

    <div class="reset-container">
        <h2>RESET PASSWORD</h2>
        
        <?php if (!empty($message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if ($token_valid): ?>
            <form class="reset-form" action="reset_password.php" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <input type="password" name="password" placeholder="New Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
                <button type="submit">Reset Password</button>
            </form>
        <?php elseif (empty($token)): ?>
            <div class="error-message">No reset token provided. Please use the link from your email.</div>
        <?php endif; ?>
        
        <div class="back-link">
            <a href="login.php">&laquo; Back to Login</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>