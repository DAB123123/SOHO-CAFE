<?php
require_once "config.php";

if (isset($_POST['order_id'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    
    $query = "UPDATE notifications SET is_read = 1 WHERE order_id = '$order_id'";
    $conn->query($query);
    
    echo 'success';
} else {
    echo 'error';
}

$conn->close();
?>