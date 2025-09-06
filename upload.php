<?php

require_once "config.php";

$name=mysqli_real_escape_string($conn, $_POST['name']);
$description=mysqli_real_escape_string($conn, $_POST['description']);
$price=mysqli_real_escape_string($conn, $_POST['price']);
$category=mysqli_real_escape_string($conn, $_POST['category']);
$temperature = !empty($_POST['temperature']) ? mysqli_real_escape_string($conn, $_POST['temperature']) : NULL;

// Prepare the SQL statement with category and temperature
if ($temperature === NULL) {
    $sql = "INSERT INTO menu (name, description, price, category, temperature, no_order) VALUES ('$name', '$description', '$price', '$category', NULL, '0')";
} else {
    $sql = "INSERT INTO menu (name, description, price, category, temperature, no_order) VALUES ('$name', '$description', '$price', '$category', '$temperature', '0')";
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