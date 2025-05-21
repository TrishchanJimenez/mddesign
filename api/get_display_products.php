<?php
// filepath: c:\xampp\htdocs\mddesign\api\get_display_products.php
require_once "../db_connection.php";
$result = $conn->query("SELECT product_name FROM display_product ORDER BY product_name ASC");
$names = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $names[] = ['product_name' => $row['product_name']];
    }
}
header('Content-Type: application/json');
echo json_encode($names);
?>