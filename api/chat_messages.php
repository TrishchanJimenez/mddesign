<?php
session_start();
$user_id = $_SESSION['user_id'] ?? null;

// Use shared DB connection
require_once "../db_connection.php"; // $conn

// Admin fetch: ?admin=1&user_id=THE_USER_ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['admin']) && $_GET['admin'] == 1 && isset($_GET['user_id'])) {
    // Optionally, check if the session is admin here
    $target_user = $_GET['user_id'];
    $stmt = $conn->prepare("SELECT sender, message, sent_at FROM chat_messages WHERE user_id = ? ORDER BY sent_at ASC");
    $stmt->bind_param('s', $target_user);
    $stmt->execute();
    $result = $stmt->get_result();
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = [
            'sender' => $row['sender'],
            'text' => $row['message'],
            'time' => $row['sent_at']
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($messages);
    exit;
}

// User fetch (default)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!$user_id) {
        http_response_code(401);
        exit('Not logged in');
    }
    $stmt = $conn->prepare("SELECT sender, message, sent_at FROM chat_messages WHERE user_id = ? ORDER BY sent_at ASC");
    $stmt->bind_param('s', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = [
            'sender' => $row['sender'],
            'text' => $row['message'],
            'time' => $row['sent_at']
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($messages);
    exit;
}

// Save message (user or admin)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // If admin, allow specifying user_id
    if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin' && !empty($data['user_id'])) {
        $target_user = $data['user_id'];
    } else {
        if (!$user_id) {
            http_response_code(401);
            exit('Not logged in');
        }
        $target_user = $user_id;
    }
    $stmt = $conn->prepare("INSERT INTO chat_messages (user_id, sender, message) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $target_user, $data['sender'], $data['text']);
    $stmt->execute();
    echo 'OK';
    exit;
}