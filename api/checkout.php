<?php
session_start();
require "../db_connection.php";

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "User not logged in."]);
    exit;
}

$userId = $_SESSION['user_id'];

// Get the cart data from the frontend
$cart = json_decode(file_get_contents("php://input"), true);

// Validate the cart data
if (empty($cart['items']) || !isset($cart['shipping_method']) || !isset($cart['payment_method']) || !isset($cart['shipping_fee'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Invalid cart data."]);
    exit;
}

$items = $cart['items'];
$shippingMethod = $cart['shipping_method'];
$paymentMethod = $cart['payment_method'];
$shippingFee = floatval($cart['shipping_fee']);
$addressId = intval($cart['address']);

// Initialize totals
$subtotal = 0;
$total = 0;

// Start a transaction
$conn->begin_transaction();

try {
    // Validate each item
    foreach ($items as $item) {
        $productId = intval($item['productId']);
        $quantity = intval($item['quantity']);

        // Fetch product details from the database
        $stmt = $conn->prepare("SELECT stock, price FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();

        if (!$product) {
            throw new Exception("Product with ID $productId not found.");
        }

        // Validate stock
        if ($product['stock'] < $quantity) {
            throw new Exception("Insufficient stock for product ID $productId.");
        }

        // Validate price
        if (floatval($item['price']) !== floatval($product['price'])) {
            throw new Exception("Price mismatch for product ID $productId.");
        }

        // Calculate item total
        $itemTotal = $quantity * $product['price'];
        $subtotal += $itemTotal;

        // Subtract the stock
        $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $stmt->bind_param("ii", $quantity, $productId);
        $stmt->execute();
        $stmt->close();
    }

    // Calculate total
    $total = $subtotal + $shippingFee;

    // Insert transaction into the `orders` table
    $stmt = $conn->prepare("
        INSERT INTO orders (user_id, total_amount, shipping_method, payment_method, shipping_fee, address_id)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("idssdi", $userId, $total, $shippingMethod, $paymentMethod, $shippingFee, $addressId);
    $stmt->execute();
    $order_id = $stmt->insert_id; // Get the inserted transaction ID
    $stmt->close();

    // Insert transaction items into the `order_items` table
    foreach ($items as $item) {
        $productId = intval($item['productId']);
        $quantity = intval($item['quantity']);
        $itemTotal = $quantity * $item['price'];

        $stmt = $conn->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, item_total_price)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("iiid", $order_id, $productId, $quantity, $itemTotal);
        $stmt->execute();
        $stmt->close();
    }

    // Commit the transaction
    $conn->commit();

    // Return success response
    echo json_encode(["success" => true, "order_id" => $order_id]);
} catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();

    // Return error response
    http_response_code(400); // Bad Request
    echo json_encode(["error" => $e->getMessage()]);
}
?>