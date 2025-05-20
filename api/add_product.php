<?php
require_once "../db_connection.php";
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = $_POST;

    // 1. Handle product name/description
    $name = trim($data['name']);
    $description = trim($data['description']);

    // Find or insert into display_product
    $stmt = $conn->prepare("SELECT id FROM display_product WHERE product_name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($display_product_id);
    if ($stmt->fetch()) {
        // Found
        $stmt->close();
    } else {
        $stmt->close();
        $stmt_insert = $conn->prepare("INSERT INTO display_product (product_name, description) VALUES (?, ?)");
        $stmt_insert->bind_param("ss", $name, $description);
        $stmt_insert->execute();
        $display_product_id = $stmt_insert->insert_id;
        $stmt_insert->close();
    }

    // 2. Handle image uploads (save to display_images)
    $upload_dir = "../images/display_products/" . $name . "/";
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    foreach (['front_design', 'back_design', 'main_design'] as $img_field) {
        if (isset($_FILES[$img_field]) && $_FILES[$img_field]['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES[$img_field]['name'], PATHINFO_EXTENSION);
            $filename = strtoupper($img_field === 'main_design' ? 'DESIGN' : strtoupper(str_replace('_design', '', $img_field))) . "." . $ext;
            $filepath = $upload_dir . $filename;
            move_uploaded_file($_FILES[$img_field]['tmp_name'], $filepath);

            // Save image path to display_images
            $rel_path = "images/display_products/" . $name . "/" . $filename;
            $stmt_img = $conn->prepare("INSERT INTO display_images (product_id, image_path) VALUES (?, ?)");
            $stmt_img->bind_param("is", $display_product_id, $rel_path);
            $stmt_img->execute();
            $stmt_img->close();
        }
    }

    // 3. Insert into products table (reference display_product)
    $category = trim($data['category']);
    $color = trim($data['color']);
    $color_code = trim($data['color_code']);
    $size = trim($data['size']);
    $stock = intval($data['stock']);
    $price = floatval($data['price']);
    $original_price = isset($data['original_price']) ? floatval($data['original_price']) : null;

    $stmt = $conn->prepare("INSERT INTO products (name, category, color, color_code, size, stock, price, original_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssidd", $name, $category, $color, $color_code, $size, $stock, $price, $original_price);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Product added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add product: ' . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>