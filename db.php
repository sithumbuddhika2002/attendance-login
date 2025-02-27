<?php
$host = "localhost";
$user = "root";
$pass = "Sithum@0213";
$db_name = "attendance";

$conn = new mysqli($host, $user, $pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
