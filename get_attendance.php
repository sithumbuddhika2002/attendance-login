<?php
include 'db.php';

$student_id = $_GET['student_id'];

$sql = "SELECT * FROM attendance WHERE student_id='$student_id' ORDER BY timestamp DESC";
$result = $conn->query($sql);

$attendance = [];
while ($row = $result->fetch_assoc()) {
    $attendance[] = $row;
}

echo json_encode($attendance);
?>
