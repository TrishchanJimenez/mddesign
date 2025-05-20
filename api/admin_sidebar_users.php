<?php
require_once "../db_connection.php";

// Get users with inquiries
$inquirySql = "
    SELECT 
        inquiries.user_id,
        CONCAT(users.first_name, ' ', users.last_name) AS customer_name,
        inquiries.id AS inquiry_id,
        inquiries.description,
        inquiries.created_at,
        inquiries.timeline,
        inquiries.color,
        inquiries.size,
        inquiries.quantity,
        inquiries.status,
        inquiries.image_path
    FROM inquiries
    JOIN users ON inquiries.user_id = users.id
    WHERE inquiries.id IN (
        SELECT MAX(id) FROM inquiries GROUP BY user_id
    )
";

// Get users with chat messages
$chatSql = "
    SELECT DISTINCT user_id
    FROM chat_messages
";

// Build user list
$inquiryResult = $conn->query($inquirySql);
$chatResult = $conn->query($chatSql);

$users = [];
$inquiriesMap = [];
if ($inquiryResult) {
    while ($row = $inquiryResult->fetch_assoc()) {
        $users[$row['user_id']] = [
            'user_id' => $row['user_id'],
            'customer_name' => $row['customer_name']
        ];
        $inquiriesMap[$row['user_id']] = $row;
    }
}
if ($chatResult) {
    while ($row = $chatResult->fetch_assoc()) {
        if (!isset($users[$row['user_id']])) {
            // Fetch user name
            $userRes = $conn->query("SELECT CONCAT(first_name, ' ', last_name) AS customer_name FROM users WHERE id = " . intval($row['user_id']));
            $userRow = $userRes ? $userRes->fetch_assoc() : null;
            $users[$row['user_id']] = [
                'user_id' => $row['user_id'],
                'customer_name' => $userRow ? $userRow['customer_name'] : 'User #' . $row['user_id']
            ];
        }
    }
}
echo json_encode([
    'users' => array_values($users),
    'inquiriesMap' => $inquiriesMap
]);
?>