<?php
require_once "../db_connection.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $id = intval($data['id']);
    $first_name = $conn->real_escape_string(trim($data['fname']));
    $last_name = $conn->real_escape_string(trim($data['lname']));
    $email = $conn->real_escape_string(trim($data['email']));
    $phone = $conn->real_escape_string(trim($data['phone']));
    $username = $conn->real_escape_string(trim($data['username']));
    $address = isset($data['address']) ? $conn->real_escape_string(trim($data['address'])) : null;
    $postal_code = isset($data['postalCode']) ? $conn->real_escape_string(trim($data['postalCode'])) : null;
    $password = isset($data['password']) && !empty($data['password']) ? $data['password'] : null;

    if (str_starts_with($phone, '63')) {
        $phone = substr($phone, 2); // Remove '63'
    } elseif (str_starts_with($phone, '0')) {
        $phone = substr($phone, 1); // Remove '0'
    }

    $errors = [];
    if (empty($first_name) || empty($last_name) || empty($email) || empty($username)) {
        $errors[] = "All required fields must be filled.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'message' => implode(", ", $errors)]);
        exit();
    }

    if ($password) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, contact_number = ?, username = ?, password = ?, address = ?, postal_code = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssssi", $first_name, $last_name, $email, $phone, $username, $hashed_password, $address, $postal_code, $id);
    } else {
        $query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, contact_number = ?, username = ?, address = ?, postal_code = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssi", $first_name, $last_name, $email, $phone, $username, $address, $postal_code, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update user: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>