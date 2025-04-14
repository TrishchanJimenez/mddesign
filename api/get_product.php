<?php
require_once "../db_connection.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid product ID.']);
        exit();
    }

    $productId = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'product' => $product]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>