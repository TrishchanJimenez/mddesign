<?php
require_once "../db_connection.php";

// Fetch all inquiries with their associated images
$query = "
    SELECT 
        inquiries.id,
        inquiries.design_type,
        LEFT(inquiries.description, 40) AS description_preview, -- Limit description to 40 characters
        inquiries.budget_range,
        inquiries.timeline,
        inquiries.status,
        inquiries.created_at,
        inquiries.description,
        CONCAT(users.first_name, ' ', users.last_name) AS customer_name,
        users.email AS customer_email,
        users.contact_number AS customer_phone,
        GROUP_CONCAT(inquiry_images.image_path) AS images -- Combine all image paths for each inquiry
    FROM inquiries
    JOIN users ON inquiries.user_id = users.id
    LEFT JOIN inquiry_images ON inquiries.id = inquiry_images.inquiry_id
    GROUP BY inquiries.id
    ORDER BY inquiries.created_at DESC
";

$result = $conn->query($query);

if ($result) {
    $inquiries = [];
    while ($row = $result->fetch_assoc()) {
        // Split the concatenated image paths into an array
        $row['images'] = $row['images'] ? explode(',', $row['images']) : [];
        $inquiries[] = $row;
    }
    echo json_encode(["success" => true, "data" => $inquiries]);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(["success" => false, "error" => "Failed to fetch inquiries."]);
}
?>