<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$studentID = $_POST['studentID'];
$qrData = $_POST['qrData'];

$sql = "INSERT INTO attendance (student_id, qr_code) VALUES ('$studentID', '$qrData')";
if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error";
}

$conn->close();
?>
