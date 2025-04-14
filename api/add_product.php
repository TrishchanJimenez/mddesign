<?php
require_once "../db_connection.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $name = $conn->real_escape_string(trim($data['name']));
    $category = $conn->real_escape_string(trim($data['category']));
    $color = $conn->real_escape_string(trim($data['color']));
    $color_code = $conn->real_escape_string(trim($data['colorCode']));
    $size = $conn->real_escape_string(trim($data['size']));
    $stock = intval($data['stock']);
    $price = floatval($data['price']);

    if (empty($name) || empty($category) || empty($color) || empty($size) || $stock < 0 || $price <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input. Please fill all fields correctly.']);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO products (name, category, color, color_code, size, stock, price) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssid", $name, $category, $color, $color_code, $size, $stock, $price);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Product added successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add product: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>