<?php
require_once "../db_connection.php";
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Use $_POST for text fields, $_FILES for images
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $category = trim($_POST['category']);
    $color = trim($_POST['color']);
    $color_code = trim($_POST['color_code']);
    $size = trim($_POST['size']);
    $stock = intval($_POST['stock']);
    $price = floatval($_POST['price']);
    $original_price = isset($_POST['original_price']) ? floatval($_POST['original_price']) : null;
    $description = trim($_POST['description']);

    // 1. Update products table
    $stmt = $conn->prepare("UPDATE products SET name=?, category=?, color=?, color_code=?, size=?, stock=?, price=?, original_price=?, date_modified=NOW() WHERE id=?");
    $stmt->bind_param("sssssiddi", $name, $category, $color, $color_code, $size, $stock, $price, $original_price, $id);
    $stmt->execute();
    $stmt->close();

    // 2. Update display_product description
    $stmt = $conn->prepare("SELECT id FROM display_product WHERE product_name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($display_product_id);
    if ($stmt->fetch()) {
        $stmt->close();
        $stmt2 = $conn->prepare("UPDATE display_product SET description=? WHERE id=?");
        $stmt2->bind_param("si", $description, $display_product_id);
        $stmt2->execute();
        $stmt2->close();
    } else {
        $stmt->close();
        // If not found, create new display_product
        $stmt2 = $conn->prepare("INSERT INTO display_product (product_name, description) VALUES (?, ?)");
        $stmt2->bind_param("ss", $name, $description);
        $stmt2->execute();
        $display_product_id = $stmt2->insert_id;
        $stmt2->close();
    }

    // 3. Handle image uploads (replace old images if new ones are uploaded)
    $upload_dir = "../images/display_products/" . $name . "/";
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $image_types = [
        'front_design' => 'FRONT',
        'back_design' => 'BACK',
        'main_design' => 'DESIGN'
    ];

    foreach ($image_types as $field => $type) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
            $filename = $type . "." . $ext;
            $filepath = $upload_dir . $filename;

            // Delete previous image of this type for this product
            $pattern = $upload_dir . $type . ".*";
            foreach (glob($pattern) as $oldfile) {
                if (is_file($oldfile)) unlink($oldfile);
            }

            move_uploaded_file($_FILES[$field]['tmp_name'], $filepath);

            // Save or update image path in display_images
            $rel_path = "images/display_products/" . $name . "/" . $filename;
            // Check if image exists
            $stmt_img = $conn->prepare("SELECT id FROM display_images WHERE product_id = ? AND image_path LIKE ?");
            $like_path = "%/" . $type . ".%";
            $stmt_img->bind_param("is", $display_product_id, $like_path);
            $stmt_img->execute();
            $stmt_img->bind_result($img_id);
            if ($stmt_img->fetch()) {
                $stmt_img->close();
                $stmt_upd = $conn->prepare("UPDATE display_images SET image_path=? WHERE id=?");
                $stmt_upd->bind_param("si", $rel_path, $img_id);
                $stmt_upd->execute();
                $stmt_upd->close();
            } else {
                $stmt_img->close();
                $stmt_ins = $conn->prepare("INSERT INTO display_images (product_id, image_path) VALUES (?, ?)");
                $stmt_ins->bind_param("is", $display_product_id, $rel_path);
                $stmt_ins->execute();
                $stmt_ins->close();
            }
        }
    }

    echo json_encode(['success' => true, 'message' => 'Product updated successfully.']);
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>