<?php
session_start();
require_once "db_connection.php";

require "phpmailer/src/PHPMailer.php";
require "phpmailer/src/SMTP.php";
require "phpmailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set("Asia/Manila");
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    
    // Check if email exists
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE email = ? AND is_verified = 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Generate unique reset token
        $reset_token = bin2hex(random_bytes(32));
        $reset_expires = date("Y-m-d H:i:s", strtotime('+1 hour'));
        
        // Save token to database
        $update = $conn->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE id = ?");
        $update->bind_param("ssi", $reset_token, $reset_expires, $user['id']);
        $update->execute();
        
        if ($update->affected_rows === 1) {
            // Email the reset link using PHPMailer
            $reset_link = "http://localhost/mddesign/reset_password.php?token=" . $reset_token;
            $to = $email;
            $subject = "Password Reset Request";
            $message_body = "Hello " . htmlspecialchars($user['username']) . ",<br><br>";
            $message_body .= "You have requested to reset your password. Click the link below to reset your password:<br><br>";
            $message_body .= "<a href='$reset_link'>$reset_link</a><br><br>";
            $message_body .= "This link will expire in 1 hour. If you did not request a password reset, please ignore this email.<br><br>";
            $message_body .= "Regards,<br>Metro District Designs Team";

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'aiko.careerai@gmail.com'; // Your SMTP username
                $mail->Password = 'vtdi memf nqdo yxbx'; // Your SMTP password or app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('MetroDistrict@gmail.com', 'Metro District Designs');
                $mail->addAddress($to, $user['username']);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $message_body;

                $mail->send();
                $message = "Password reset instructions have been sent to your email.";
            } catch (Exception $e) {
                $message = "Failed to send reset email. Please try again later.";
            }

            // For development/testing purposes only - display the reset link
            $_SESSION['dev_reset_link'] = $reset_link;
        } else {
            $message = "An error occurred. Please try again later.";
        }
    } else {
        // Don't reveal if email exists or not for security
        $message = "If your email address exists in our database, you will receive a password recovery link at your email address shortly.";
    }
    
    $stmt->close();
}

$page_title = "Metro District Designs - Forgot Password";
require_once "header.php";
?>

<style>
    body {
        background-color: #E5E4E2;
        font-family: Arial, sans-serif;
    }   

    .password-container {
        background-color: #9b9b9b;
        width: 800px;
        padding: 80px;
        text-align: center;
        margin: 80px auto;
    }
    
    .password-container h2 {
        color: black;
        margin-bottom: 20px;
    }
    
    .password-form input {
        width: 100%;
        margin-bottom: 25px;
        padding: 8px;
        border: none;
        box-sizing: border-box;
    }
    
    .password-form button {
        width: 100%;
        padding: 10px;
        background-color: white;
        border: none;
        cursor: pointer;
        margin-top: 15px;
    }
    
    .message {
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 5px;
    }
    
    .success-message {
        background-color: rgba(40, 167, 69, 0.2);
        border: 1px solid #28a745;
        color: #28a745;
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

    <div class="password-container">
        <h2>FORGOT PASSWORD</h2>
        
        <?php if (!empty($message)): ?>
            <div class="message success-message">
                <?php echo htmlspecialchars($message); ?>
                
                <?php if (isset($_SESSION['dev_reset_link'])): ?>
                    <div style="margin-top: 10px; word-break: break-all; text-align: left; font-size: 12px; background: #f8f9fa; padding: 10px; border-radius: 5px;">
                        <strong>Development Only:</strong> Reset Link:<br>
                        <a href="<?php echo $_SESSION['dev_reset_link']; ?>"><?php echo $_SESSION['dev_reset_link']; ?></a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <form class="password-form" action="forgot_password.php" method="POST">
            <p>Enter your email address and we'll send you instructions to reset your password.</p>
            <input type="email" name="email" placeholder="Email Address" required>
            <button type="submit">Request Password Reset</button>
        </form>
        
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