<?php
require_once "../db_connection.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$response = ['stock' => 0];

// Fetch stock data
$query = " 
    SELECT 
        p.stock AS quantity,
        p.color,
        p.size,
        p.id AS product_id
    FROM 
        display_product dp
    INNER JOIN 
        products p ON dp.product_name = p.name
    WHERE 
        dp.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$stockData = [];
while ($row = $result->fetch_assoc()) {
    $stockData[$row['size']][$row['color']] = [
        'quantity' => $row['quantity'],
        'id' => $row['product_id']
    ];
}

$response['stock'] = $stockData;
$stmt->close();

header('Content-Type: application/json');
echo json_encode($response);
?>