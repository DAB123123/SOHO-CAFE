<?php

require_once "config.php";

// Clear file stat cache to ensure fresh file modification times
clearstatcache();

$id=mysqli_real_escape_string($conn, $_POST['id']);
$name=mysqli_real_escape_string($conn, $_POST['name']);
$description=mysqli_real_escape_string($conn, $_POST['description']);
$price=mysqli_real_escape_string($conn, $_POST['price']);
$category=mysqli_real_escape_string($conn, $_POST['category']);
$temperature = !empty($_POST['temperature']) ? mysqli_real_escape_string($conn, $_POST['temperature']) : NULL;

// Prepare the SQL statement with category and temperature (no size field)
if ($temperature === NULL) {
    $sql = "UPDATE menu SET name='$name', description='$description', price='$price', category='$category', temperature=NULL WHERE menu_id='$id'";
} else {
    $sql = "UPDATE menu SET name='$name', description='$description', price='$price', category='$category', temperature='$temperature' WHERE menu_id='$id'";
}

// Check if file upload field exists and has a file
$fileUploaded = isset($_FILES['userfile']) && $_FILES['userfile']['error'] != 4;

// Check if file size exceeds limit (only if a file was uploaded)
if ($fileUploaded && $_FILES['userfile']['error'] == 1) {
    echo 'size';
    exit;
}

// Update menu item in database
if ($conn->query($sql) === TRUE) {
    
    // Check if a file was actually uploaded
    if (!$fileUploaded) {
        // No new file uploaded, just updated text fields
        echo 'true';
    } else {
        // File was uploaded, process it
        $uploaddir = __DIR__ . '/assets/img/menu/';
        $oldfile = $uploaddir . $id . '.png';
        
        // Delete old image if it exists
        if (file_exists($oldfile)) {
            @unlink($oldfile); // @ suppresses warnings if file can't be deleted
        }
        
        // Check if upload directory exists
        if (!is_dir($uploaddir)) {
            mkdir($uploaddir, 0755, true);
        }
        
        $imageFileType = strtolower(pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION));
        
        // Check file type
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        
        if (!in_array($imageFileType, $allowed_types)) {
            echo "false_image";
            exit;
        }
        
        $temp_file = $_FILES['userfile']['tmp_name'];
        $uploadfile = $uploaddir . $id . '.png';
        
        // Check if GD library is available
        if (extension_loaded('gd')) {
            // GD is available, use it to convert to PNG
            $image = null;
            switch($imageFileType) {
                case 'jpg':
                case 'jpeg':
                    $image = @imagecreatefromjpeg($temp_file);
                    break;
                case 'png':
                    $image = @imagecreatefrompng($temp_file);
                    break;
                case 'gif':
                    $image = @imagecreatefromgif($temp_file);
                    break;
                case 'webp':
                    $image = @imagecreatefromwebp($temp_file);
                    break;
            }
            
            // If image creation successful, save as PNG
            if ($image !== false && $image !== null) {
                // Preserve transparency for PNG and GIF
                imagealphablending($image, false);
                imagesavealpha($image, true);
                
                if (imagepng($image, $uploadfile)) {
                    imagedestroy($image);
                    // Touch the file to update modification time for cache busting
                    @touch($uploadfile);
                    // Clear stat cache for this specific file
                    clearstatcache(true, $uploadfile);
                    echo "true";
                } else {
                    imagedestroy($image);
                    echo "false_image";
                }
            } else {
                echo "false_image";
            }
        } else {
            // GD not available, just move the file with .png extension
            // Note: The file will keep its original format but have .png extension
            if (move_uploaded_file($temp_file, $uploadfile)) {
                // Touch the file to update modification time for cache busting
                @touch($uploadfile);
                // Clear stat cache for this specific file
                clearstatcache(true, $uploadfile);
                echo "true";
            } else {
                echo "false_image";
            }
        }
    }
} else {
    echo "false";
}
?> 