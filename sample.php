<?php
$servername = "localhost";
$username = "root";
$password = "Sithum@0213";
$dbname = "attendance";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

$user = "student123";
$pass = password_hash("password123", PASSWORD_BCRYPT);
$full_name = "John Doe";

// Check if username exists
$check_sql = "SELECT id FROM students WHERE username = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $user);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    echo "Username already exists!";
} else {
    // Insert new user if not exists
    $sql = "INSERT INTO students (username, password, full_name) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user, $pass, $full_name);
    $stmt->execute();
    echo "Student added successfully!";
}

$conn->close();
?>
