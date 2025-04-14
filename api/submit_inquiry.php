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

// Validate required fields
if (empty($_POST['designType']) || empty($_POST['description'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Design type and description are required."]);
    exit;
}

$designType = $_POST['designType'];
$description = $_POST['description'];
$budgetRange = $_POST['budget'] ?? null;
$timeline = $_POST['timeline'] ?? null;

// Insert inquiry into the database
$query = "
    INSERT INTO inquiries (user_id, design_type, description, budget_range, timeline)
    VALUES (?, ?, ?, ?, ?)
";
$stmt = $conn->prepare($query);
$stmt->bind_param("issss", $userId, $designType, $description, $budgetRange, $timeline);

if ($stmt->execute()) {
    $inquiryId = $stmt->insert_id; // Get the ID of the newly created inquiry

    // Handle file uploads (if any)
    if (isset($_FILES['referenceImages']['tmp_name']) && is_array($_FILES['referenceImages']['tmp_name'])) {
        $uploadDir = "../images/inquiry_images";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($_FILES['referenceImages']['tmp_name'] as $key => $tmpName) {
            if (!empty($tmpName)) { // Ensure the file is not empty
                $fileName = uniqid() . "_" . basename($_FILES['referenceImages']['name'][$key]);
                $filePath = $uploadDir . "/" . $fileName;

                if (move_uploaded_file($tmpName, $filePath)) {
                    // Insert image path into inquiry_images table
                    $imageQuery = "
                        INSERT INTO inquiry_images (inquiry_id, image_path)
                        VALUES (?, ?)
                    ";
                    $imagePath = "images/inquiry_images/" . $fileName;

                    $imageStmt = $conn->prepare($imageQuery);
                    $imageStmt->bind_param("is", $inquiryId, $imagePath);
                    $imageStmt->execute();
                    $imageStmt->close();
                }
            }
        }
    }

    echo json_encode(["success" => true, "message" => "Inquiry submitted successfully."]);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Failed to submit inquiry. Please try again."]);
}

$stmt->close();
?>