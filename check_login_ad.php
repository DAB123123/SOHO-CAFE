<?php
session_start();
require_once "config.php";

// Check if POST data exists
if (!isset($_POST['inemail']) || !isset($_POST['inpassword'])) {
    echo 'false';
    exit;
}

$inemail = trim($_POST['inemail']);
$inpassword = $_POST['inpassword'];

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
$stmt->bind_param("s", $inemail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    if (password_verify($inpassword, $row['password'])) {
        $_SESSION['login_ad'] = $row['id'];
        echo 'true';
    } else {
        echo 'false';
    }
} else {
    echo 'false';
}

$stmt->close();
?>