<?php
header('Content-Type: application/json');
require_once "config.php";

// Fetch active size pricing
$sql = "SELECT size_name, size_description, multiplier FROM size_pricing WHERE is_active = 1 ORDER BY multiplier";
$result = $conn->query($sql);

$sizePricing = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sizePricing[$row['size_name']] = array(
            'description' => $row['size_description'],
            'multiplier' => floatval($row['multiplier'])
        );
    }
} else {
    // Fallback to default values if table doesn't exist or is empty
    $sizePricing = array(
        'short' => array('description' => '8 oz', 'multiplier' => 1.00),
        'tall' => array('description' => '12 oz', 'multiplier' => 1.25),
        'grande' => array('description' => '16 oz', 'multiplier' => 1.50),
        'venti' => array('description' => '20 oz', 'multiplier' => 1.75)
    );
}

echo json_encode($sizePricing);
$conn->close();
?>