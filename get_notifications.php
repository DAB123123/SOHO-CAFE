<?php
header('Content-Type: application/json');
require_once "config.php";

$query = "SELECT notification_id, message FROM notifications WHERE is_read = 0 ORDER BY created_at DESC LIMIT 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['new' => true, 'id' => $row['notification_id'], 'message' => $row['message']]);
} else {
    echo json_encode(['new' => false]);
}

$conn->close();
?>