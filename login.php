<?php
$servername = "localhost";  // Change if needed
$username = "root";         // Database username
$password = "Sithum@0213";             // Database password
$dbname = "attendance";  // Change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$studentID = $_POST['student_id'];
$password = $_POST['password'];

$sql = "SELECT * FROM students WHERE student_id='$studentID' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "success";
} else {
    echo "error";
}

$conn->close();
?>
