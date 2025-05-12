<?php
session_start();
require_once 'db_connection.php';
require_once "phpmailer/src/PHPMailer.php";
require_once "phpmailer/src/SMTP.php";
require_once "phpmailer/src/Exception.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $first_name = $conn->real_escape_string(trim($_POST['first_name']));
    $last_name = $conn->real_escape_string(trim($_POST['last_name']));
    $username = $conn->real_escape_string(trim($_POST['username']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $contact_number = $conn->real_escape_string(trim($_POST['contact_number']));
    $regCode = $conn->real_escape_string(trim($_POST['region']));
    $provCode = $conn->real_escape_string(trim($_POST['province']));
    $citymunCode = $conn->real_escape_string(trim($_POST['city']));
    $brgyCode = $conn->real_escape_string(trim($_POST['barangay']));
    $street_address = $conn->real_escape_string(trim($_POST['street_address']));
    $postal_code = $conn->real_escape_string(trim($_POST['postal_code']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Format phone number - remove leading 0 if present
    if (strpos($contact_number, '0') === 0) {
        $contact_number = substr($contact_number, 1);
    }
    
    // Basic validation
    $errors = [];
    if (empty($username)) $errors[] = "Username is required.";
    if (empty($email)) $errors[] = "Email is required.";
    if (empty($password)) $errors[] = "Password is required.";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match.";
    if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters long.";

    // Check if username or email already exists
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Username or email already exists.";
        }
        $stmt->close();
    }

    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $token = bin2hex(random_bytes(16));

        // Insert new user with default role as 'user'
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, contact_number, password, verification_token, role) VALUES (?, ?, ?, ?, ?, ?, ?, 'user')");
        $stmt->bind_param("sssssss", $first_name, $last_name, $username, $email, $contact_number, $hashed_password, $token);

        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;
            $stmt->close();

            // Insert address with all location codes into addresses table
            $stmt_addr = $conn->prepare("INSERT INTO addresses (user_id, brgyCode, citymunCode, provCode, regCode, street_address, postal_code) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt_addr->bind_param("issssss", $user_id, $brgyCode, $citymunCode, $provCode, $regCode, $street_address, $postal_code);
            $stmt_addr->execute();
            $stmt_addr->close();

            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'aiko.careerai@gmail.com'; 
                $mail->Password = 'vtdi memf nqdo yxbx';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('email@gmail.com', 'Metro District Designs');
                $mail->addAddress($email, $first_name . ' ' . $last_name);

                $mail->isHTML(true);
                $mail->Subject = "Verify your email - Metro District Designs";
                $verify_link = "http://localhost/mddesign/login.php?token=$token";
                $mail->Body = "<p>Dear $first_name,</p>
                    <p>Thank you for registering! Please verify your email by clicking the link below:</p>
                    <p><a href='$verify_link'>$verify_link</a></p>
                    <p>Best regards,<br>Metro District Designs</p>";

                $mail->send();
                $_SESSION['success_message'] = ["Registration successful! Please check your email to verify your account."];
                header("Location: Signup.php");
                exit();
            } catch (Exception $e) {
                error_log("Mailer Error: " . $mail->ErrorInfo);
                $errors[] = "Registration successful, but failed to send verification email.";
                $_SESSION['registration_errors'] = $errors;
                header("Location: Signup.php");
                exit();
            }
        } else {
            $errors[] = "Registration failed: " . $stmt->error;
        }
    }

    $_SESSION['registration_errors'] = $errors;
    header("Location: Signup.php");
    exit();
}
?>