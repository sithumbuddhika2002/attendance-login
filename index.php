<?php
session_start();
$servername = "localhost";
$username = "root"; // Change this if you have a different MySQL user
$password = "Sithum@0213"; // Change this if your MySQL has a password
$dbname = "attendance";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $pass = $_POST["password"];
    $course = $_POST["course"];

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

                echo "<script>alert('Attendance Marked Successfully!');</script>";
            } else {
                echo "<script>alert('Attendance Already Marked!');</script>";
            }
        } else {
            echo "<script>alert('Invalid Password!');</script>";
        }
    } else {
        echo "<script>alert('User Not Found!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Student Login</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="course" class="form-label">Course</label>
                                <input type="text" name="course" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login & Mark Attendance</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
