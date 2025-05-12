<?php
session_start();
require_once "../db_connection.php";

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "User not logged in."]);
    exit;
}

$userId = $_SESSION['user_id'];

// Get the data from the request
$data = json_decode(file_get_contents("php://input"), true);

// Validate the data
if (
    empty($data['username']) || empty($data['first_name']) || empty($data['last_name']) || empty($data['email']) || empty($data['phone'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "All fields are required."]);
    exit;
}

$username = $data['username'];
$firstName = $data['first_name'];
$lastName = $data['last_name'];
$email = $data['email'];
$phone = $data['phone'];

if (str_starts_with($phone, '63')) {
    $phone = substr($phone, 2); // Remove '63'
} elseif (str_starts_with($phone, '0')) {
    $phone = substr($phone, 1); // Remove '0'
}

// Update the user's information in the database
$stmt = $conn->prepare("
    UPDATE users 
    SET username = ?, first_name = ?, last_name = ?, email = ?, contact_number = ?
    WHERE id = ?
");
$stmt->bind_param("sssssi", $username, $firstName, $lastName, $email, $phone, $userId);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Profile updated successfully."]);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Failed to update profile. Please try again."]);
}

$stmt->close();
?>