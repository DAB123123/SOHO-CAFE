<?php
header('Content-Type: application/json');
require_once "config.php";

$query = "SELECT o.order_id, o.name, o.status, o.amount, o.date, n.notification_id
          FROM orders o
          INNER JOIN notifications n ON o.order_id = n.order_id
          WHERE n.is_read = 0
          ORDER BY o.date DESC
          LIMIT 5";
$result = $conn->query($query);

$orders = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

echo json_encode([
    'success' => true,
    'orders' => $orders
]);

$conn->close();
?>