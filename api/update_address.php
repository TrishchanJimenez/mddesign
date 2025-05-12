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

if (!isset($data['id']) || !isset($data['brgyCode']) || !isset($data['citymunCode']) || 
    !isset($data['provCode']) || !isset($data['regCode']) || !isset($data['street_address'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

$addressId = intval($data['id']);
$brgyCode = $data['brgyCode'];
$citymunCode = $data['citymunCode'];
$provCode = $data['provCode'];
$regCode = $data['regCode'];
$street_address = $data['street_address'];
$postal_code = isset($data['postal_code']) ? $data['postal_code'] : '';

// Verify the address belongs to this user
$stmt = $conn->prepare("SELECT id FROM addresses WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $addressId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(403);
    echo json_encode(['error' => 'Address not found or not authorized']);
    exit;
}

// Update the address with all location codes
$stmt = $conn->prepare("UPDATE addresses SET brgyCode = ?, citymunCode = ?, provCode = ?, regCode = ?, street_address = ?, postal_code = ? WHERE id = ?");
$stmt->bind_param("ssssssi", $brgyCode, $citymunCode, $provCode, $regCode, $street_address, $postal_code, $addressId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update address: ' . $stmt->error]);
}
?>