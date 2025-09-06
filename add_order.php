<?php

require_once "config.php";

$name=mysqli_real_escape_string($conn, $_POST['name']);
$description=mysqli_real_escape_string($conn, $_POST['description']);
$status="in_progress";
$addr=mysqli_real_escape_string($conn, $_POST['addr']);
$amount=mysqli_real_escape_string($conn, $_POST['amount']);
$id=mysqli_real_escape_string($conn, $_POST['id']);

// Handle payment proof upload
$payment_proof = null;
if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] == 0) {
    $target_dir = "uploads/payment_proofs/";
    
    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_extension = strtolower(pathinfo($_FILES['payment_proof']['name'], PATHINFO_EXTENSION));
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    
    if (in_array($file_extension, $allowed_extensions)) {
        // Generate unique filename
        $new_filename = "payment_" . time() . "_" . $id . "." . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        if (move_uploaded_file($_FILES['payment_proof']['tmp_name'], $target_file)) {
            $payment_proof = $new_filename;
        }
    }
}

$sql = "INSERT INTO orders (id,name, description, status ,address,amount,payment_proof) VALUES ('$id','$name', '$description', '$status', '$addr', '$amount', '$payment_proof')";

if($conn->query($sql) === TRUE)
echo 'true';
else
echo 'false';
?>