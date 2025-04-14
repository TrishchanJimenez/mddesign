<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $first_name = $conn->real_escape_string(trim($_POST['first_name']));
    $last_name = $conn->real_escape_string(trim($_POST['last_name']));
    $username = $conn->real_escape_string(trim($_POST['username']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $contact_number = $conn->real_escape_string(trim($_POST['contact_number']));
    $address = $conn->real_escape_string(trim($_POST['address']));
    $postal_code = $conn->real_escape_string(trim($_POST['postal_code']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

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

        // Insert new user with default role as 'user'
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, contact_number, address, postal_code, password, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'user')");
        $stmt->bind_param("ssssssss", $first_name, $last_name, $username, $email, $contact_number, $address, $postal_code, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Registration successful! Please log in.";
            header("Location: Login.php");
            exit();
        } else {
            $errors[] = "Registration failed: " . $stmt->error;
        }
        $stmt->close();
    }

    $_SESSION['registration_errors'] = $errors;
    header("Location: Signup.php");
    exit();
}
?>