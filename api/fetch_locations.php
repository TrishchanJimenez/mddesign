<?php
require_once '../db_connection.php';

$type = $_GET['type'] ?? '';
$response = [];

if ($type === 'province' && isset($_GET['regionCode'])) {
    $regionCode = $conn->real_escape_string($_GET['regionCode']);
    $query = "SELECT provCode, provDesc FROM refprovince WHERE regCode = '$regionCode'";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
} elseif ($type === 'city' && isset($_GET['provinceCode'])) {
    $provinceCode = $conn->real_escape_string($_GET['provinceCode']);
    $query = "SELECT citymunCode, citymunDesc FROM refcitymun WHERE provCode = '$provinceCode'";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
} elseif ($type === 'barangay' && isset($_GET['cityCode'])) {
    $cityCode = $conn->real_escape_string($_GET['cityCode']);
    $query = "SELECT brgyCode, brgyDesc FROM refbrgy WHERE citymunCode = '$cityCode'";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>