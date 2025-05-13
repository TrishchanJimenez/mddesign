<?php
session_start();
require "../db_connection.php";

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "User not logged in."]);
    exit;
}

$userId = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['cart']) || !is_array($data['cart'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid cart data."]);
    exit;
}

// Optional: Clear existing cart for this user before saving new one
$stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->close();

$inserted = 0;
foreach ($data['cart'] as $item) {
    $productId = intval($item['productId'] ?? $item['id']);
    $size = $item['size'] ?? null;
    $color = $item['color'] ?? null;
    $quantity = intval($item['quantity']);

    $stmt = $conn->prepare("INSERT INTO cart_items (user_id, product_id, size, color, quantity) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        http_response_code(500);
        echo json_encode(["error" => "Prepare failed: " . $conn->error]);
        exit;
    }
    $stmt->bind_param("iissi", $userId, $productId, $size, $color, $quantity);
    if (!$stmt->execute()) {
        $error = $stmt->error;
        $stmt->close();
        http_response_code(500);
        echo json_encode(["error" => "Insert failed: " . $error]);
        exit;
    } else {
        $inserted++;
    }
    $stmt->close();
}

if ($inserted > 0) {
    echo json_encode(["success" => true, "inserted" => $inserted]);
} else {
    echo json_encode(["success" => false, "message" => "No items inserted"]);
}
?>