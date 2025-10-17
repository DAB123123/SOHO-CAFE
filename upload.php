<?php

require_once "config.php";

// Clear file stat cache to ensure fresh file modification times
clearstatcache();

$name=mysqli_real_escape_string($conn, $_POST['name']);
$description=mysqli_real_escape_string($conn, $_POST['description']);
$price=mysqli_real_escape_string($conn, $_POST['price']);
$category=mysqli_real_escape_string($conn, $_POST['category']);
$temperature = !empty($_POST['temperature']) ? mysqli_real_escape_string($conn, $_POST['temperature']) : NULL;

// Prepare the SQL statement with category and temperature (no size field)
if ($temperature === NULL) {
    $sql = "INSERT INTO menu (name, description, price, category, temperature, no_order) VALUES ('$name', '$description', '$price', '$category', NULL, '0')";
} else {
    $sql = "INSERT INTO menu (name, description, price, category, temperature, no_order) VALUES ('$name', '$description', '$price', '$category', '$temperature', '0')";
}

// Check if file size exceeds limit
if ($_FILES['userfile']['error'] == 1) {
    echo 'size';
    exit;
}

// Insert menu item into database
if ($conn->query($sql) === TRUE) {
    $menu_id = $conn->insert_id;
    
    // Check if no file was uploaded
    if($_FILES['userfile']['error'] == 4) {
        // No file uploaded, use default sample image
        $file = __DIR__ . '/assets/img/menu/sample.png';
        $newfile = __DIR__ . '/assets/img/menu/' . $menu_id . '.png';
        
        if (!copy($file, $newfile)) {
            echo "copy";
        } else {
            // Touch the file to update modification time
            @touch($newfile);
            clearstatcache(true, $newfile);
            echo 'true';
        }
    } else {
        // File was uploaded, process it
        $uploaddir = __DIR__ . '/assets/img/menu/';
        $imageFileType = strtolower(pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION));
        $uploadfile = $uploaddir . $menu_id . '.png';
        
        // Check if upload directory exists
        if (!is_dir($uploaddir)) {
            mkdir($uploaddir, 0755, true);
        }
        
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            // Touch the file to update modification time
            @touch($uploadfile);
            clearstatcache(true, $uploadfile);
            echo "true";
        } else {
            echo "false_image";
        }
    }
} else {
    echo "false";
}
?> 