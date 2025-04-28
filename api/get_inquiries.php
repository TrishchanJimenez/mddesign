<?php
require_once "../db_connection.php";

// Fetch all inquiries with their associated data
$query = "
    SELECT 
        inquiries.id,
        LEFT(inquiries.description, 40) AS description_preview, -- Limit description to 40 characters
        inquiries.timeline,
        inquiries.created_at,
        inquiries.description,
        inquiries.image_path,
        inquiries.color,
        inquiries.size,
        inquiries.quantity,
        inquiries.status,
        CONCAT(users.first_name, ' ', users.last_name) AS customer_name,
        users.email AS customer_email,
        users.contact_number AS customer_phone
    FROM inquiries
    JOIN users ON inquiries.user_id = users.id
    ORDER BY inquiries.created_at DESC
";

$result = $conn->query($query);

if ($result) {
    $inquiries = [];
    while ($row = $result->fetch_assoc()) {
        $inquiries[] = $row;
    }
    echo json_encode(["success" => true, "data" => $inquiries]);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(["success" => false, "error" => "Failed to fetch inquiries."]);
}
?>