<?php
require_once "../db_connection.php";

$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

$query = "
    SELECT 
        inquiries.id,
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
";
if ($userId) {
    $query .= " WHERE inquiries.user_id = $userId ORDER BY inquiries.created_at DESC LIMIT 1";
} else {
    $query .= " ORDER BY inquiries.created_at DESC";
}

$result = $conn->query($query);

if ($result) {
    $inquiries = [];
    while ($row = $result->fetch_assoc()) {
        $inquiries[] = $row;
    }
    echo json_encode(["success" => true, "data" => $inquiries]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Failed to fetch inquiries."]);
}
?>