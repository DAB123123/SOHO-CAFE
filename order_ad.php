<?php clearstatcache(); ?>
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
        <!-- Bootstrap CSS -->

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/styles.css?v=3" />
  
  <style>
    /* Temperature and size badges */
    .temperature-badge, .size-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: bold;
        margin-left: 6px;
        margin-right: 4px;
        vertical-align: middle;
        line-height: 1;
    }

    .hot-badge {
        background: #ff6b35;
        color: white;
        box-shadow: 0 2px 4px rgba(255, 107, 53, 0.3);
    }

    .cold-badge {
        background: #4a90e2;
        color: white;
        box-shadow: 0 2px 4px rgba(74, 144, 226, 0.3);
    }

    .size-s-badge {
        background: #28a745;
        color: white;
        box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
    }

    .size-m-badge {
        background: #ffc107;
        color: black;
        box-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
    }

    .size-l-badge {
        background: #dc3545;
        color: white;
        box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
    }

    /* Modal enhancements */
    .table th {
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
    }

    .table td {
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(245, 166, 55, 0.05);
    }
  </style>
  
    <title>Admin Dashboard</title>
  </head>
  <body id="body">


        <div class="container-fluid">
  <?php require_once 'nav_admin.php' ?>

      <main class="admin-order-main" style="margin-top: 20px;">
        <div class="container-fluid px-4">
          <div class="main__container">


            <div class="main__title">
              <img src="assets/hello.svg" alt="" />
              <div class="main__greeting">
                <h1>Hello Admin!</h1>
                <p>Manage customer orders and track deliveries</p>
              </div>
          </div>
       </div>

  <!-- Order Statistics Cards -->
  <div class="container-fluid px-4 mb-4">
    <div class="row mb-4">
  <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
    <div class="card bg-warning text-dark shadow-sm h-100">
      <div class="card-body stats-card-body p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div class="flex-grow-1">
            <h6 class="card-title mb-1 text-truncate">In Progress</h6>
            <h3 class="mb-0 fw-bold" id="in-progress-count">0</h3>
          </div>
          <div class="ms-2">
            <i class="fa fa-clock fa-lg"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 mb-3">
    <div class="card bg-info text-white shadow-sm h-100">
      <div class="card-body stats-card-body p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div class="flex-grow-1">
            <h6 class="card-title mb-1 text-truncate">Food OTW</h6>
            <h3 class="mb-0 fw-bold" id="food-otw-count">0</h3>
          </div>
          <div class="ms-2">
            <i class="fa fa-truck fa-lg"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 mb-3">
    <div class="card bg-success text-white shadow-sm h-100">
      <div class="card-body stats-card-body p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div class="flex-grow-1">
            <h6 class="card-title mb-1 text-truncate">Delivered</h6>
            <h3 class="mb-0 fw-bold" id="delivered-count">0</h3>
          </div>
          <div class="ms-2">
            <i class="fa fa-check-circle fa-lg"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 mb-3">
    <div class="card bg-danger text-white shadow-sm h-100">
      <div class="card-body stats-card-body p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div class="flex-grow-1">
            <h6 class="card-title mb-1 text-truncate">Cancelled</h6>
            <h3 class="mb-0 fw-bold" id="cancelled-count">0</h3>
          </div>
          <div class="ms-2">
            <i class="fa fa-times-circle fa-lg"></i>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>

  <!-- Filter and Search Options -->
  <div class="container-fluid px-4 mb-4">
    <div class="row mb-3">
  <div class="col-lg-6 col-md-12 mb-2">
    <form method="GET" class="d-flex flex-column flex-sm-row align-items-sm-center">
      <label for="status_filter" class="form-label me-2 mb-1 mb-sm-0 text-nowrap">Filter:</label>
      <select name="status_filter" id="status_filter" class="form-select" onchange="this.form.submit()">
        <option value="">All Orders</option>
        <option value="in_progress" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] == 'in_progress') ? 'selected' : ''; ?>>In Progress</option>
        <option value="food_otw" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] == 'food_otw') ? 'selected' : ''; ?>>Food OTW</option>
        <option value="delivered" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] == 'delivered') ? 'selected' : ''; ?>>Delivered</option>
        <option value="cancel" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] == 'cancel') ? 'selected' : ''; ?>>Cancelled</option>
      </select>
      <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
        <input type="hidden" name="search" value="<?php echo htmlspecialchars($_GET['search']); ?>">
      <?php endif; ?>
    </form>
  </div>
  <div class="col-lg-6 col-md-12 mb-2">
    <form method="GET" class="d-flex flex-column flex-sm-row">
      <input type="text" name="search" class="form-control me-sm-2 mb-2 mb-sm-0" placeholder="Search customer or order ID" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
      <div class="d-flex">
        <button type="submit" class="btn btn-primary me-2">Search</button>
        <?php if(isset($_GET['search']) || isset($_GET['status_filter'])): ?>
          <a href="order_ad.php" class="btn btn-secondary">Clear</a>
      <?php endif; ?>
      <?php if(isset($_GET['status_filter']) && !empty($_GET['status_filter'])): ?>
        <input type="hidden" name="status_filter" value="<?php echo htmlspecialchars($_GET['status_filter']); ?>">
      <?php endif; ?>
    </form>
    </div>
  </div>

<div class="container-fluid px-4">
<section class="content">
<div class="box-body">
              <div class="table-responsive rounded card-table">
                <div id="example1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer"><div class="row"><div class="col-sm-12 col-md-6"></div><div class="col-sm-12 col-md-6"></div></div>
                <div class="row" style="background-color:white;padding-top:30px">
                  <div class="col-sm-12" style="padding-bottom:30px;"><table class="table border-no dataTable no-footer" id="example1" role="grid" aria-describedby="example1_info">
                  <thead>
                    <tr role="row">
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Order ID: activate to sort column ascending">Order ID</th><th class="sorting_asc mobile-hide" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column descending" aria-sort="ascending">Date</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Customer Name: activate to sort column ascending">Customer</th><th class="sorting mobile-hide" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Location: activate to sort column ascending">Location</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Amount: activate to sort column ascending">Amount</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Status Order: activate to sort column ascending">Status</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="View: activate to sort column ascending">View</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending">Actions</th></tr>
                  </thead>
                  <tbody>
                  

<?php

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 10;
        $offset = ($pageno-1) * $no_of_records_per_page;

        require_once "config.php";
        // Check connection
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }

        // Build WHERE clause for filtering and searching
        $where_conditions = array();
        $search_param = '';
        $status_param = '';
        
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = mysqli_real_escape_string($conn, $_GET['search']);
            $where_conditions[] = "(name LIKE '%$search%' OR order_id LIKE '%$search%')";
            $search_param = "&search=" . urlencode($_GET['search']);
        }
        
        if (isset($_GET['status_filter']) && !empty($_GET['status_filter'])) {
            $status = mysqli_real_escape_string($conn, $_GET['status_filter']);
            if ($status === 'cancel') {
                $where_conditions[] = "status IN ('cancel', 'cancelled', 'canceled')";
            } else {
                $where_conditions[] = "status = '$status'";
            }
            $status_param = "&status_filter=" . urlencode($_GET['status_filter']);
        }
        
        $where_clause = '';
        if (!empty($where_conditions)) {
            $where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
        }

        // Get statistics for all orders
        $stats_sql = "SELECT 
            CASE 
                WHEN status IN ('cancel', 'cancelled', 'canceled') THEN 'cancel'
                ELSE status 
            END as normalized_status, 
            COUNT(*) as count 
            FROM orders 
            GROUP BY normalized_status";
        $stats_result = mysqli_query($conn, $stats_sql);
        $stats = array();
        while($stat_row = mysqli_fetch_array($stats_result)) {
            $stats[$stat_row['normalized_status']] = $stat_row['count'];
        }

        $total_pages_sql = "SELECT COUNT(*) FROM orders $where_clause";
        $result = mysqli_query($conn,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql = "SELECT * FROM orders $where_clause ORDER BY order_id DESC LIMIT $offset, $no_of_records_per_page";
        $res_data = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_array($res_data)){
            //here goes the data
echo '<tr class="hover-primary even" role="row">';
echo '<td data-label="Order ID">#' . $row['order_id'] . '</td>';	
echo '<td data-label="Date" class="mobile-hide">' . $row['date'] . '</td>';                      
echo '<td data-label="Customer">' . $row['name'] . '</td>';                      
echo '<td data-label="Location" class="mobile-hide">' . $row['address'] . '</td>';                      
echo '<td data-label="Amount">₱ ' . number_format($row['amount'], 2) . '</td>';                      
if($row['status']=='in_progress') {

echo '<td data-label="Status" id="'. $row['order_id'] .'span"> <span class="badge bg-warning">In Progress...</span> </td>';                      
echo '<td data-label="View"><button class="btn btn-sm btn-outline-primary" onclick="viewOrderDetails(' . $row['order_id'] . ')"><i class="fa fa-eye"></i> <span class="d-none d-md-inline">View</span></button></td>';
echo '<td data-label="Actions"> <div id="'. $row['order_id'] .'" class="btn-group"> <a class="hover-primary dropdown-toggle no-caret" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a> <div class="dropdown-menu" style="margin: 0px;">';		      
echo '<a class="dropdown-item" onclick="foodOtw(' . $row['order_id'] . ')"><i class="fa fa-truck"></i> Food OTW</a>';                      
echo '<a class="dropdown-item" onclick="deliver(' . $row['order_id'] . ')"><i class="fa fa-check"></i> Delivered</a>';                      
echo '<a class="dropdown-item" onclick="cancel(' . $row['order_id'] . ')"><i class="fa fa-times"></i> Cancel</a>';                      
echo '</div></div></td>';                          
}

else if($row['status']=='food_otw') {

echo '<td data-label="Status" id="'. $row['order_id'] .'span"> <span class="badge bg-info">Food OTW</span> </td>';                      
echo '<td data-label="View"><button class="btn btn-sm btn-outline-primary" onclick="viewOrderDetails(' . $row['order_id'] . ')"><i class="fa fa-eye"></i> <span class="d-none d-md-inline">View</span></button></td>';
echo '<td data-label="Actions"> <div id="'. $row['order_id'] .'" class="btn-group"> <a class="hover-primary dropdown-toggle no-caret" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a> <div class="dropdown-menu" style="margin: 0px;">';		      
echo '<a class="dropdown-item" onclick="deliver(' . $row['order_id'] . ')"><i class="fa fa-check"></i> Delivered</a>';                      
echo '<a class="dropdown-item" onclick="cancel(' . $row['order_id'] . ')"><i class="fa fa-times"></i> Cancel</a>';                      
echo '</div></div></td>';                          
}

else if($row['status']=='delivered') 
echo '<td data-label="Status"> <span class="badge bg-success">Delivered</span> </td> <td data-label="View"><button class="btn btn-sm btn-outline-primary" onclick="viewOrderDetails(' . $row['order_id'] . ')"><i class="fa fa-eye"></i> <span class="d-none d-md-inline">View</span></button></td> <td data-label="Actions">-</td>';

else if(in_array($row['status'], ['cancel', 'cancelled', 'canceled']) || stripos($row['status'], 'cancel') !== false)
echo '<td data-label="Status"> <span class="badge bg-danger">Cancelled</span> </td> <td data-label="View"><button class="btn btn-sm btn-outline-primary" onclick="viewOrderDetails(' . $row['order_id'] . ')"><i class="fa fa-eye"></i> <span class="d-none d-md-inline">View</span></button></td> <td data-label="Actions">-</td>';

else 
echo '<td data-label="Status"> <span class="badge bg-secondary">Unknown: ' . htmlspecialchars($row['status']) . '</span> </td> <td data-label="View"><button class="btn btn-sm btn-outline-primary" onclick="viewOrderDetails(' . $row['order_id'] . ')"><i class="fa fa-eye"></i> <span class="d-none d-md-inline">View</span></button></td> <td data-label="Actions">-</td>';
		      
echo '</tr>';
        }
        mysqli_close($conn);
    ?>
<tr>

<td colspan="8">
    <ul class="pagination justify-content-center">
        <li class="page-item"><a class="page-link" href="?pageno=1<?php echo $search_param . $status_param; ?>">First</a></li>
        <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1) . $search_param . $status_param; } ?>">Prev</a>
        </li>
        <li class="page-item active">
            <span class="page-link">Page <?php echo $pageno; ?> of <?php echo $total_pages; ?></span>
        </li>
        <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1) . $search_param . $status_param; } ?>">Next</a>
        </li>
        <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages . $search_param . $status_param; ?>">Last</a></li>
    </ul>
    <div class="text-center mt-2">
        <small class="text-muted">Showing <?php echo min($offset + 1, $total_rows); ?> to <?php echo min($offset + $no_of_records_per_page, $total_rows); ?> of <?php echo $total_rows; ?> entries</small>
    </div>
</td>
</tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>






</section>
</div>
</main>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="orderDetailsContent">
        <div class="text-center">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Payment Proof Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Payment Proof</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modalImage" src="" alt="Payment Proof" style="max-width: 100%; height: auto;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

  <!-- <div id="sidebar">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="assets/js/script.js"></script>
<style>
.cursor-pointer {
    cursor: pointer;
    transition: transform 0.2s ease-in-out;
}
.cursor-pointer:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.border-start {
    border-left: 3px solid var(--bs-primary) !important;
    padding-left: 1rem;
    background-color: rgba(var(--bs-primary-rgb), 0.05);
}
</style>
<script>
function send_post(value,status)
{

$.ajax({
type:"POST",
url:"update_status.php",
data: "order_id=" + value + "&status=" + status,
success:function(html)
{
if(html=='true') {
    console.log('updated');
    // Refresh the page to update the statistics
    setTimeout(function() {
        location.reload();
    }, 1000);
} else {
    console.log(html);
}
}
                });

}

// Update statistics cards
document.addEventListener('DOMContentLoaded', function() {
    // Set the statistics from PHP
    document.getElementById('in-progress-count').textContent = '<?php echo isset($stats["in_progress"]) ? $stats["in_progress"] : 0; ?>';
    document.getElementById('food-otw-count').textContent = '<?php echo isset($stats["food_otw"]) ? $stats["food_otw"] : 0; ?>';
    document.getElementById('delivered-count').textContent = '<?php echo isset($stats["delivered"]) ? $stats["delivered"] : 0; ?>';
    document.getElementById('cancelled-count').textContent = '<?php echo isset($stats["cancel"]) ? $stats["cancel"] : 0; ?>';
});

function viewOrderDetails(orderId) {
    const modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
    const modalContent = document.getElementById('orderDetailsContent');
    
    // Show loading spinner
    modalContent.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
    
    // Show the modal
    modal.show();
    
    // Mark notification as read
    fetch('mark_notification_read.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'order_id=' + encodeURIComponent(orderId)
    }).catch(error => console.error('Error marking notification as read:', error));
    
    // Fetch order details
    fetch('get_order_details.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'order_id=' + encodeURIComponent(orderId)
    })
    .then(response => response.text())
    .then(data => {
        modalContent.innerHTML = data;
    })
    .catch(error => {
        console.error('Error:', error);
        modalContent.innerHTML = '<div class="alert alert-danger">Error loading order details. Please try again.</div>';
    });
}

function openImageModal(imageSrc) {
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageSrc;
    modal.show();
}

</script>
</body>
</html>
