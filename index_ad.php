<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
      crossorigin="anonymous"
    />
  <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- Bootstrap CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <link rel="stylesheet" href="assets/css/styles.css" />
    <link rel="stylesheet" href="assets/css/styles.css?v=2" />
    <title>Admin Dashboard</title>
    <style>

	.drive
	{
		height: 425px;
		overflow: auto;
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
              <h1>Hello Admin!</h1>
              <p>Welcome to your admin dashboard</p>
            </div>
          </div>

          <!-- NOTIFICATION AREA -->
          <div id="notification-area" class="alert alert-info" style="display: none;">
            <i class="fa fa-bell"></i> <span id="notification-message"></span>
            <button type="button" class="btn-close" onclick="dismissNotification()"></button>
          </div>

<br>
          <!-- MAIN TITLE ENDS HERE -->

          <!-- MAIN CARDS STARTS HERE -->
<!--           <div class="main__cards">
            <div class="card">
              <i
                class="fa fa-user-o fa-2x text-lightblue"
                aria-hidden="true"
              ></i>
              <div class="card_inner">
                <p class="text-primary-p">Total Menu</p>
                <span class="font-bold text-title">578</span>
              </div>
            </div>

            <div class="card">
              <i class="fa fa-calendar fa-2x text-red" aria-hidden="true"></i>
              <div class="card_inner">
                <p class="text-primary-p">Total Revenue</p>
                <span class="font-bold text-title">$2467</span>
              </div>
            </div>

            <div class="card">
              <i
                class="fa fa-video-camera fa-2x text-yellow"
                aria-hidden="true"
              ></i>
              <div class="card_inner">
                <p class="text-primary-p">Total Orders</p>
                <span class="font-bold text-title">340</span>
              </div>
            </div>

            <div class="card">
              <i
                class="fa fa-thumbs-up fa-2x text-green"
                aria-hidden="true"
              ></i>
              <div class="card_inner">
                <p class="text-primary-p">Total Customers</p>
                <span class="font-bold text-title">645</span>
              </div>
            </div>
          </div> -->



<?php
require_once "config.php";

$sql = mysqli_query($conn,"SELECT count(*) as total, sum(amount) as total_amount FROM `orders` WHERE status != 'cancel'");
$result = mysqli_fetch_assoc($sql);


$sql = mysqli_query($conn,"SELECT count(*) as deliverd FROM `orders` WHERE status = 'delivered'");
$total_deliverd =  mysqli_fetch_assoc($sql); 

$sql = mysqli_query($conn,"SELECT count(*) as cancel FROM `orders` WHERE status IN ('cancel', 'cancelled', 'canceled')");
$total_cancel =  mysqli_fetch_assoc($sql); 

?>




              
              <div class="row">
        <div class="col-xl-3 col-lg-3 col-12">
          <div class="box">
            <div class="box-body">
              <div class="d-flex align-items-start">
                <div>
                  <img src="assets/img/dash-1.png" class="w-80 me-20" alt="">
                </div>
                <div>
                  <h2 class="my-0 fw-700"><?php echo $result['total'];  ?></h2>
                  <p class="text-fade mb-0">Total Order</p>
                  <p class="fs-12 mb-0 text-success"><span class="badge badge-pill badge-success-light me-5"><i class="fa fa-arrow-up"></i></span>&nbsp;</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-12">
          <div class="box">
            <div class="box-body">
              <div class="d-flex align-items-start">
                <div>
                  <img src="assets/img/dash-2.png" class="w-80 me-20" alt="">
                </div>
                <div>
                  <h2 class="my-0 fw-700"><?php echo $total_deliverd['deliverd'];  ?></h2>
                  <p class="text-fade mb-0">Total Delivered
                    
                  </p>
                  <p class="fs-12 mb-0 text-success"><span class="badge badge-pill badge-success-light me-5"><i class="fa fa-arrow-up"></i></span>&nbsp;</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-12">
          <div class="box">
            <div class="box-body">
              <div class="d-flex align-items-start">
                <div>
                  <img src="assets/img/dash-3.png" class="w-80 me-20" alt="">
                </div>
                <div>
                  <h2 class="my-0 fw-700"><?php echo $total_cancel['cancel'];  ?></h2>
                  <p class="text-fade mb-0">Total Canceled</p>
                  <p class="fs-12 mb-0 text-primary"><span class="badge badge-pill badge-primary-light me-5"><i class="fa fa-arrow-down"></i></span>&nbsp;</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-12">
          <div class="box">
            <div class="box-body">
              <div class="d-flex align-items-start">
                <div>
                  <img src="assets/img/dash-4.png" class="w-80 me-20" alt="">
                </div>
                <div>
                  <h2 class="my-0 fw-700">₱<?php echo $result['total_amount'];  ?></h2>
                  <p class="text-fade mb-0">Total Revenue</p>
                  <p class="fs-12 mb-0 text-primary"><span class="badge badge-pill badge-primary-light me-5"><i class="fa fa-arrow-down"></i></span>&nbsp;</p>
                </div>
              </div>
            </div>
          </div>
        </div>

</div>



          <!-- MAIN CARDS ENDS HERE -->

          <!-- CHARTS STARTS HERE -->


            <!--<div class="charts__right">
              <div class="charts__right__title">
                <div>
                  <h1>To-Do list</h1>

                  </div>
                  
                <i class="fa fa-usd" aria-hidden="true"></i>
              </div>

             
            </div> 
          </div>-->



<div class="charts">
  <!-- LEFT: Trending Items -->
  <div class="charts__left">
    <div class="charts__left__title">
      <div>
        <h1>Trending Items</h1>
        <p>SOHO Cafe & Kitchen</p>
      </div>
      <i class="fa fa-line-chart" aria-hidden="true"></i>
    </div>
    <div class="box-body drive">
      <?php
      $sql = "SELECT * FROM menu ORDER BY no_order DESC";
      $result = $conn->query($sql);
      $i = 1;
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              // Cache busting for image
              $img_path = 'assets/img/menu/' . $row["menu_id"] . '.png';
              $img_url = $img_path . (file_exists($img_path) ? '?v=' . filemtime($img_path) : '?v=' . time());
              
              echo '<div class="d-md-flex justify-content-between align-items-center">';
              echo '<div class="d-flex justify-content-start align-items-center mb-20 mb-md-0">';
              echo '<p class="mb-0 fs-18 text-mute">#' . $i . '</p>';
              echo '<img src="' . $img_url . '" class="rounded10 w-80 mx-15" alt="">';
              echo '<div><h5 class="mb-0 fw-500">' . $row["name"] . '</h5>';
              echo '<p class="mb-0">₱' . $row['price'] . '</p></div></div>';
              echo '<div class="text-center trending-count">';
              echo '<h3 class="box-title fw-700 mb-0">' . $row["no_order"] . '</h3>';
              echo '<p class="text-muted mb-0 small">no of order</p>';
              echo '</div></div><hr>';
              $i++;
          }
      } else {
          echo "0 results";
      }
      ?>
    </div>
  </div>

  <!-- CENTER: Daily Reports -->
  <div class="charts__right wide">
    <div class="charts__right__title">
      <div>
        <h1>Daily Reports</h1>
        <p>SOHO Cafe & Kitchen</p>
      </div>
      <i class="fa fa-bar-chart" aria-hidden="true"></i>
    </div>
    <div id="apex1"></div>
  </div>

  <!-- RIGHT: To-Do List -->
  <div class="charts__todo">
    <div class="charts__right__title">
      <div>
        <h1>To-Do List</h1>
      </div>
      <i class="fa fa-list" aria-hidden="true"></i>
    </div>
    <div class="box-body">
      <?php require_once 'todo.php'; ?>
    </div>
  </div>
</div>


            <!--<div class="chart__rig">
              <div class="chart__rig__title">
                <div>
                  <h1>Customer</h1>
                  <p>SOHO Cafe & Kitchen</p>
                </div>
                <i class="fa fa-usd" aria-hidden="true"></i>
              </div>
              <div id="apex2"></div>
            </div>-->







           

            
          </div>

          <!-- CHARTS ENDS HERE -->

        </div>
      </main>

    <!--   <div id="sidebar">
        <div class="sidebar__title">
          <div class="sidebar__img">
            <img src="assets/logo.png" alt="logo" />
            <h1>Cafeteria</h1>
          </div>
          <i
            onclick="closeSidebar()"
            class="fa fa-times"
            id="sidebarIcon"
            aria-hidden="true"
          ></i>
        </div>

        <div class="sidebar__menu">
          <div class="sidebar__link active_menu_link">
            <i class="fa fa-home"></i>
            <a href="#">Dashboard</a>
          </div>
        </div>
      </div> -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/chart_ad.js"></script>

    <!-- Notification Polling Script -->
    <script>
    let lastNotificationId = 0;

    function checkNotifications() {
        fetch('get_notifications.php')
            .then(response => response.json())
            .then(data => {
                if (data.new && data.id > lastNotificationId) {
                    lastNotificationId = data.id;
                    document.getElementById('notification-message').textContent = data.message;
                    document.getElementById('notification-area').style.display = 'block';
                    
                    // Optional: Play a notification sound
                    // const audio = new Audio('notification-sound.mp3');
                    // audio.play();
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function dismissNotification() {
        document.getElementById('notification-area').style.display = 'none';
    }

    // Check for notifications every 10 seconds
    setInterval(checkNotifications, 10000);
    
    // Check immediately on page load
    checkNotifications();
    </script>
  </body>
</html>
