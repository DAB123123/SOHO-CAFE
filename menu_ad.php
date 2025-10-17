<?php clearstatcache(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
      crossorigin="anonymous"
    />
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/styles.css?v=2" />
    <title>Admin Dashboard</title>
    <style >
      
      .row{
display: flex;
  width: 100%;
}
.coly{
 flex: 1;
}
.box
{
height:80%;
padding:20px;
}
.d-flex
{
 justify-content: center;
}
.menu-details
{
height:30%;
}

/* Badge Styles */
.item-badges {
  display: flex;
  justify-content: center;
  gap: 8px;
  flex-wrap: wrap;
  margin-bottom: 10px;
}

.badge {
  display: inline-block;
  padding: 4px 8px;
  font-size: 11px;
  font-weight: 600;
  line-height: 1;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  border-radius: 12px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.badge-temp.badge-hot {
  background-color: #ff6b6b;
  color: white;
  border: 1px solid #ff5252;
}

.badge-temp.badge-cold {
  background-color: #4ecdc4;
  color: white;
  border: 1px solid #26a69a;
}

.badge-size {
  background-color: #9c27b0;
  color: white;
  border: 1px solid #7b1fa2;
}

.badge-category {
  background-color: #2196f3;
  color: white;
  border: 1px solid #1976d2;
}

/* Responsive badge styling */
@media (max-width: 768px) {
  .item-badges {
    gap: 4px;
  }
  
  .badge {
    font-size: 10px;
    padding: 3px 6px;
  }
}
    </style>
  </head>
  <body id="body">
    <div class="container-fluid">
  <?php require_once 'nav_admin.php' ?>

      <main>
        <div class="main__container">
          <!-- MAIN TITLE STARTS HERE -->

          <div class="main__title">
            <img src="assets/hello.svg" alt="" />
            <div class="main__greeting">
              <h1>Hello Caffeteria</h1>
              <p>Welcome to your admin dashboard</p>
            </div>
        </div>

<?php

if(isset($_GET["mssg"]))
{

if($_GET["mssg"]=='true')

echo '<br><br><div class="alert alert-success"><strong>Success!</strong> Item is removed from menu sucessfully</div>';

else

echo '<br><br><div class="alert alert-danger"><strong>Error!</strong> Not able to process please try later!</div>';

}

?>

<?php
require_once "config.php";

$sql = "SELECT * from menu";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
$i=0;
    while($row = $result->fetch_assoc()) {

	if($i==0)
	echo '<div class="row">';
	
	// Cache busting for image
	$img_path = 'assets/img/menu/' . $row["menu_id"] . '.png';
	$img_url = $img_path . (file_exists($img_path) ? '?v=' . filemtime($img_path) : '?v=' . time());
	
	echo '<div class="col-xxxl-3 col-xl-4 col-lg-6 col-12">';
	echo '<div class="box food-box"> <div class="box-body text-center"> <div class="menu-item"> <img src="' . $img_url . '" class="img-fluid w-p75 img_size" ></div>';
	echo '<div class="menu-details text-center"> <h4 class="mt-40 mb-10">' . $row["name"] . '</h4> <p>' . $row["description"] . '</p>';
	
	// Display temperature and category badges (no size badge since sizes are now dynamic)
	echo '<div class="item-badges mb-15">';
	if (!empty($row["temperature"])) {
		$tempClass = ($row["temperature"] == 'hot') ? 'badge-hot' : 'badge-cold';
		echo '<span class="badge badge-temp ' . $tempClass . '">' . ucfirst($row["temperature"]) . '</span>';
	}
	if (!empty($row["category"])) {
		echo '<span class="badge badge-category">' . ucfirst($row["category"]) . '</span>';
	}
	// Add size info for drinks
	if ($row["category"] == 'drinks') {
		echo '<span class="badge badge-info">Dynamic Sizes</span>';
	}
	echo '</div>';
	
	echo '</div>';
	echo '<div class="act-btn  justify-content-between"> <div class="text-center mx-5">';
	echo '<a href="edit_menu.php?id='. $row["menu_id"]. '" class="waves-effect waves-circle btn btn-circle btn-danger-light btn-xs mb-5"><i class="fa fa-edit"></i></a>';
	echo '&nbsp;<small class="d-block">Edit</small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<a href="delete_ad.php?id='. $row["menu_id"]. '" class="waves-effect waves-circle btn btn-circle btn-primary-light btn-xs mb-5"><i class="fa fa-trash"></i></a>';
	echo '&nbsp;<small class="d-block">Delete</small> </div> </div> </div> </div> </div>';
	if($i==2)
	{ $i=-1;echo '</div>';}
	$i=$i+1;
    }
} else {
    echo "0 results";
}

$conn->close();
?>


          </div>




            </div>
        
        </main>
   



    </div>
<script src="assets/js/script.js"></script>
</body>
</html>