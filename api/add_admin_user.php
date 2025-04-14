<?php
require_once "../db_connection.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $first_name = $conn->real_escape_string(trim($data['fname']));
    $last_name = $conn->real_escape_string(trim($data['lname']));
    $email = $conn->real_escape_string(trim($data['email']));
    $contact_number = $conn->real_escape_string(trim($data['phone']));
    $username = $conn->real_escape_string(trim($data['username']));
    $password = $data['password'];

    if (strpos($contact_number, '63') !== 0) {
        $contact_number = ltrim($contact_number, '0');
    }

    $errors = [];
    if (empty($first_name) || empty($last_name) || empty($email) || empty($contact_number) || empty($username) || empty($password)) {
        $errors[] = "All fields are required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'message' => implode(", ", $errors)]);
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, contact_number, username, password, role) VALUES (?, ?, ?, ?, ?, ?, 'admin')");
    $stmt->bind_param("ssssss", $first_name, $last_name, $email, $contact_number, $username, $hashed_password);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Admin added successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error adding admin: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>