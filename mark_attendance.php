<?php
include "db_connect.php";

$username = $_POST['username'];
$password = $_POST['password'];
$qr_id = $_POST['qr_id'];
$module_id = $_POST['module_id'];

// Validate QR Code
$qr_check = mysqli_query($conn, "SELECT * FROM qr_codes WHERE qr_id = '$qr_id' AND module_id = '$module_id'");
if (mysqli_num_rows($qr_check) == 0) {
    echo "Invalid or Expired QR Code";
    exit();
}

// Verify Student Credentials
$result = mysqli_query($conn, "SELECT * FROM students WHERE username = '$username'");
$row = mysqli_fetch_assoc($result);

if (!$row || !password_verify($password, $row['password'])) {
    echo "Invalid Credentials";
    exit();
}

$student_id = $row['student_id'];

// Prevent Duplicate Attendance
$check_attendance = mysqli_query($conn, "SELECT * FROM attendance WHERE student_id = '$student_id' AND module_id = '$module_id'");
if (mysqli_num_rows($check_attendance) > 0) {
    echo "Attendance Already Marked!";
    exit();
}

// Mark Attendance
mysqli_query($conn, "INSERT INTO attendance (student_id, module_id) VALUES ('$student_id', '$module_id')");
echo "Attendance Marked Successfully!";
?>
