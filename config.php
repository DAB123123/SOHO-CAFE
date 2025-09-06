<?php
// No whitespace or output before this line
$conn = new mysqli("localhost", "root", "", "sohocafe");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>