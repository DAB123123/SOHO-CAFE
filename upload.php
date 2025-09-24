<?php

require_once "config.php";

$name=mysqli_real_escape_string($conn, $_POST['name']);
$description=mysqli_real_escape_string($conn, $_POST['description']);
$price=mysqli_real_escape_string($conn, $_POST['price']);
$category=mysqli_real_escape_string($conn, $_POST['category']);
$temperature = !empty($_POST['temperature']) ? mysqli_real_escape_string($conn, $_POST['temperature']) : NULL;
$size = !empty($_POST['size']) ? mysqli_real_escape_string($conn, $_POST['size']) : NULL;

// Prepare the SQL statement with category, temperature, and size
if ($temperature === NULL && $size === NULL) {
    $sql = "INSERT INTO menu (name, description, price, category, temperature, size, no_order) VALUES ('$name', '$description', '$price', '$category', NULL, NULL, '0')";
} elseif ($temperature === NULL) {
    $sql = "INSERT INTO menu (name, description, price, category, temperature, size, no_order) VALUES ('$name', '$description', '$price', '$category', NULL, '$size', '0')";
} elseif ($size === NULL) {
    $sql = "INSERT INTO menu (name, description, price, category, temperature, size, no_order) VALUES ('$name', '$description', '$price', '$category', '$temperature', NULL, '0')";
} else {
    $sql = "INSERT INTO menu (name, description, price, category, temperature, size, no_order) VALUES ('$name', '$description', '$price', '$category', '$temperature', '$size', '0')";
}

if ( $_FILES['userfile']['error']==1)
echo 'size';

else if ($conn->query($sql) === TRUE)
{

if($_FILES['userfile']['error']==4)
{
$file = 'assets\img\menu/sample.png';
$newfile = 'assets\img\menu/'.$conn->insert_id.'.png';

if (!copy($file, $newfile)) {
    echo "copy";
}
else
echo 'true';

}
else
{
$uploaddir =  __DIR__ .'\assets\img\menu/';
$imageFileType = strtolower(pathinfo($_FILES['userfile']['name'],PATHINFO_EXTENSION));
$uploadfile = $uploaddir . $conn->insert_id . '.png';

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
  echo "true";
} else {
   echo "false_image";
}

}
}
else
echo "false";
?> 