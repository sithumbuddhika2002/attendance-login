<?php
header("Content-Type: application/json");
session_start();
$servername = "localhost";
$username = "root";
$password = "Sithum@0213";  // Change as needed
$dbname = "attendance";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed."]));
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["username"], $data["password"], $data["course"])) {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit();
}

$user = $data["username"];
$pass = $data["password"];
$course = $data["course"];

// Fetch student details
$sql = "SELECT * FROM students WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    // Verify password
    if (password_verify($pass, $row["password"])) {
        $student_id = $row["id"];
        $date = date("Y-m-d");

        // Check if attendance is already marked
        $check_sql = "SELECT * FROM attendance WHERE student_id=? AND attendance_date=?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("is", $student_id, $date);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows == 0) {
            // Insert attendance
            $insert_sql = "INSERT INTO attendance (student_id, course, attendance_date) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("iss", $student_id, $course, $date);
            $insert_stmt->execute();

            echo json_encode(["success" => true, "message" => "Attendance Marked Successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Attendance Already Marked"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid Password"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "User Not Found"]);
}

$conn->close();
?>
