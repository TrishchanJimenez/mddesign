<?php
require_once "../db_connection.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["success" => false, "error" => "Invalid request method."]);
    exit;
}

// Validate input
$inquiryId = $_POST['inquiry_id'] ?? null;
$status = $_POST['status'] ?? null;

if (!$inquiryId || !$status) {
    http_response_code(400); // Bad Request
    echo json_encode(["success" => false, "error" => "Inquiry ID and status are required."]);
    exit;
}

// Update the inquiry status
$query = "UPDATE inquiries SET status = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $status, $inquiryId);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Inquiry status updated successfully."]);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(["success" => false, "error" => "Failed to update inquiry status."]);
}

$stmt->close();
?>