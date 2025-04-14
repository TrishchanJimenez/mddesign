<?php
require_once "../db_connection.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $query = "SELECT id, first_name, last_name, email, contact_number, username, role, profile_picture, created_at, updated_at FROM users WHERE role='admin'";
    $result = $conn->query($query);

    if ($result) {
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = [
                'id' => $row['id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'contact_number' => $row['contact_number'],
                'username' => $row['username'],
                'role' => $row['role'],
                'profile_picture' => $row['profile_picture'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ];
        }
        echo json_encode(['status' => 'success', 'data' => $users]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to fetch users: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>