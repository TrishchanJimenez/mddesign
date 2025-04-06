<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $username = $conn->real_escape_string(trim($_POST['username']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $_POST['password'];

    // Basic validation
    $errors = [];
    if (empty($username)) $errors[] = "Username is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($password)) $errors[] = "Password is required";
    if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters long";

    // Check if username or email already exists
    if (empty($errors)) {
        // Prepare statement to check existing username or email
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $errors[] = "Username or email already exists";
        }
        $stmt->close();
    }

    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        try {
            // Prepare statement to insert new user
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            
            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to login page or dashboard
                $_SESSION['success_message'] = "Registration successful! Please log in.";
                header("Location: Login.php");
                exit();
            } else {
                $errors[] = "Registration failed: " . $stmt->error;
            }
            $stmt->close();
        } catch(Exception $e) {
            $errors[] = "Registration failed: " . $e->getMessage();
        }
    }

    // If there are errors, store them in session to display on the registration page
    $_SESSION['registration_errors'] = $errors;
    header("Location: Signup.php");
    exit();
}
?>