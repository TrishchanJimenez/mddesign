<?php
session_start();
header('Content-Type: application/json');
require_once "../db_connection.php";

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "User not logged in."]);
    exit;
}

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Invalid JSON input."]);
    exit;
}

// Validate required fields
if (empty($data['description']) || empty($data['timeline']) || empty($data['color']) || empty($data['size']) || empty($data['quantity'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Description, timeline, color, size, and quantity are required."]);
    exit;
}

$userId = $_SESSION['user_id'];
$description = $data['description'];
$timeline = $data['timeline'];
$color = ltrim($data['color'], '#');
$size = $data['size'];
$quantity = (int)$data['quantity'];
$additionalInfo = $data['additional_info'] ?? null;
$imageData = $data['referenceImage'] ?? null;
$imagePath = null;

// Handle image upload
if ($imageData) {
    $uploadDir = "../images/inquiry_images";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = uniqid() . ".png";
    $filePath = $uploadDir . "/" . $fileName;

    // Decode base64 image and save it
    $imageData = explode(',', $imageData)[1]; // Remove the "data:image/png;base64," part
    $decodedImage = base64_decode($imageData);

    if (file_put_contents($filePath, $decodedImage)) {
        $imagePath = "images/inquiry_images/" . $fileName;
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "Failed to save the image."]);
        exit;
    }
}

// Insert inquiry into the database
$query = "
    INSERT INTO inquiries (user_id, description, timeline, additional_info, image_path, color, size, quantity)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
";
$stmt = $conn->prepare($query);
$stmt->bind_param("issssssi", $userId, $description, $timeline, $additionalInfo, $imagePath, $color, $size, $quantity);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Inquiry submitted successfully."]);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Failed to submit inquiry. Please try again."]);
}

$stmt->close();
?>