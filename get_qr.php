<?php
header('Content-Type: application/json'); 
include 'db.php';

$sql = "SELECT qr_code FROM qr_codes ORDER BY id DESC LIMIT 1"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["qr_code" => $row['qr_code']]);
} else {
    echo json_encode(["qr_code" => "No QR Available"]);
}
?>
