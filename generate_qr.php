<?php
include("db.php");

$qr_code = uniqid();  // Generate unique QR code

// Insert QR code into attendance table with pending status
$query = "INSERT INTO attendance (qr_code, status) VALUES ('$qr_code', 'Pending')";
mysqli_query($conn, $query);

echo json_encode(["qr_code" => $qr_code]);
?>
