<?php
require_once "../db_connection.php";

// Get latest chat message for each user, and their name, but exclude admin users
$sql = "
    SELECT t1.user_id, t1.message AS text, t1.sent_at AS time, t1.sender, CONCAT(u.first_name, ' ', u.last_name) AS customer_name
    FROM chat_messages t1
    INNER JOIN (
        SELECT user_id, MAX(sent_at) as max_time
        FROM chat_messages
        GROUP BY user_id
    ) t2 ON t1.user_id = t2.user_id AND t1.sent_at = t2.max_time
    LEFT JOIN users u ON t1.user_id = u.id
    WHERE u.role IS NULL OR u.role != 'admin'
";
$result = $conn->query($sql);

$latestChats = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $latestChats[$row['user_id']] = [
            'text' => $row['text'],
            'time' => $row['time'],
            'sender' => $row['sender'],
            'customer_name' => $row['customer_name']
        ];
    }
}
echo json_encode($latestChats);
?>