<?php
session_start();
require_once "../db_connection.php";

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$userId = $_SESSION['user_id'];

if (!isset($data['brgyCode']) || !isset($data['citymunCode']) || 
    !isset($data['provCode']) || !isset($data['regCode']) || !isset($data['street_address'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

$brgyCode = $data['brgyCode'];
$citymunCode = $data['citymunCode'];
$provCode = $data['provCode'];
$regCode = $data['regCode'];
$street_address = $data['street_address'];
$postal_code = isset($data['postal_code']) ? $data['postal_code'] : '';

// Add the new address with all location codes
$stmt = $conn->prepare("INSERT INTO addresses (user_id, brgyCode, citymunCode, provCode, regCode, street_address, postal_code) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssss", $userId, $brgyCode, $citymunCode, $provCode, $regCode, $street_address, $postal_code);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to add address: ' . $stmt->error]);
}
?>