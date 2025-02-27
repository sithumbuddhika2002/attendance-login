<?php
include("db.php");

$student_id = $_POST['student_id'];
$qr_code = $_POST['qr_code'];

// Check if QR code exists and is not used
$query = "SELECT * FROM attendance WHERE qr_code = '$qr_code' AND status = 'Pending'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Get student details
    $student_query = "SELECT * FROM students WHERE student_id = '$student_id'";
    $student_result = mysqli_query($conn, $student_query);
    $student = mysqli_fetch_assoc($student_result);

    // Update attendance record
    $update_query = "UPDATE attendance SET student_id = '$student_id', name = '{$student['name']}', status = 'Completed' WHERE qr_code = '$qr_code'";
    mysqli_query($conn, $update_query);

    echo json_encode(["status" => "success", "student_id" => $student_id, "name" => $student['name']]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid or already used QR code"]);
}
?>
