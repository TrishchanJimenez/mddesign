<?php
session_start();
require_once "../db_connection.php";

$addressId = intval($_GET['id']);
$userId = $_SESSION['user_id'];

// Fetch the address with joins to get all location codes
$stmt = $conn->prepare("
    SELECT a.id, a.street_address, a.postal_code, a.brgyCode, 
           a.citymunCode, a.provCode, a.regCode,
           b.brgyDesc,
           c.citymunDesc,
           p.provDesc,
           r.regDesc
    FROM addresses a
    JOIN refbrgy b ON a.brgyCode = b.brgyCode
    JOIN refcitymun c ON a.citymunCode = c.citymunCode
    JOIN refprovince p ON a.provCode = p.provCode
    JOIN refregion r ON a.regCode = r.regCode
    WHERE a.id = ? AND a.user_id = ?
");

$stmt->bind_param("ii", $addressId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Address not found']);
    exit;
}

$address = $result->fetch_assoc();
echo json_encode($address);
?>