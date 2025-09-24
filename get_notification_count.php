<?php
header('Content-Type: application/json');
require_once "config.php";

$query = "SELECT COUNT(*) as count FROM notifications WHERE is_read = 0";
$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    echo json_encode(['count' => (int)$row['count']]);
} else {
    echo json_encode(['count' => 0]);
}

$conn->close();
?>