<?php
require_once "../db_connection.php";
header("Content-Type: application/json");

$query = "SELECT p.*, dp.id as display_id, dp.product_name, dp.description
          FROM products p
          LEFT JOIN display_product dp ON p.name = dp.product_name
          ORDER BY p.date_added DESC";
$result = $conn->query($query);

$products = [];
while ($row = $result->fetch_assoc()) {
    // Fetch images for this display_product
    $images = [];
    if ($row['display_id']) {
        $imgq = $conn->prepare("SELECT image_path FROM display_images WHERE product_id = ?");
        $imgq->bind_param("i", $row['display_id']);
        $imgq->execute();
        $imgres = $imgq->get_result();
        while ($imgrow = $imgres->fetch_assoc()) {
            $images[] = $imgrow['image_path'];
        }
        $imgq->close();
    }
    $row['images'] = $images;
    $products[] = $row;
}
echo json_encode(['success' => true, 'products' => $products]);
?>