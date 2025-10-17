<?php session_start(); ?>
<!doctype html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="apple-touch-icon" sizes="180x180" href="assets/ico/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/ico/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/ico/favicon-16x16.png">
	<link rel="manifest" href="assets/ico/site.webmanifest">
	<link rel="mask-icon" href="assets/ico/safari-pinned-tab.svg" color="#5bbad5">
	<link rel="shortcut icon" href="assets/ico/favicon.ico">
	<meta name="msapplication-config" content="assets/ico/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">

	<title>SOHO CAFE</title>

	<!-- CSS Plugins -->
	<link rel="stylesheet" href="assets/plugins/font-awesome/css/all.min.css">
	<link rel="stylesheet" href="assets/plugins/lightbox/css/lightbox.min.css">
	<link rel="stylesheet" href="assets/plugins/flickity/flickity.min.css">

	<!-- CSS Global -->

  <link rel="stylesheet" href="assets/css/theme.min.css">
  <link rel="stylesheet" href="assets/css/history.css">

  </head>
  <body>

	<!-- NAVBAR
	================================================== -->
  <?php require_once 'nav.php' ?> <!-- / .navbar --> <!-- / .navbar -->

	<!-- HEADER
	================================================== -->
  <section class="section section_header" data-parallax="scroll" data-image-src="assets/img/bar-italia-darker.jpg">
		<div class="container">
			<div class="row">
				<div class="col">

					<!-- Heading -->
          <h1 class="section__heading section_welcome__heading text-center" style="font-family: 'Dosis', sans-serif;
font-family: 'Oswald', sans-serif;
font-family: 'Quicksand', sans-serif;">
            Order History
          </h1>

				</div>
			</div> <!-- / .row -->
		</div> <!-- / .container -->
	</section>


  <div class="container order_cards order-history" style="padding-top:50px;margin-bottom:30px">
      

<?php
require_once "config.php";

if(isset($_SESSION['name']))
{
$id=($_SESSION['login']);
$sql = "SELECT * FROM orders where id='$id' order by order_id desc";
// echo $id."<br>";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	$i=0;
	$j=0;

    while($row = $result->fetch_assoc()) {
	
	if($i==0)
	echo '<div class="row">';
	echo '<div class="col-lg-4" style="border:50px; "> <div class="card " id="card-a" >';
	
	// Add order tracker
	echo '<div class="order-tracker">';
	echo '<h5 style="text-align: center; margin-bottom: 15px; color: #495057;">Order Progress</h5>';
	echo '<div class="tracker-container" data-status="' . strtolower(str_replace(['_', ' '], '-', $row["status"])) . '">';
	echo '<div class="tracker-steps">';
	echo '<div class="progress-line" id="progress-' . $row["order_id"] . '"></div>';
	
	// Check if order is cancelled - if so, only show cancelled step
	if (strtolower($row["status"]) === 'cancelled' || strtolower($row["status"]) === 'cancel') {
		echo '<div class="tracker-step" data-step="cancelled">';
		echo '<div class="step-icon"><i class="fas fa-times-circle"></i></div>';
		echo '<div class="step-label">Cancelled</div>';
		echo '</div>';
	} else {
		// Show normal progression steps for non-cancelled orders
		// Step 1: In Progress
		echo '<div class="tracker-step" data-step="in-progress">';
		echo '<div class="step-icon"><i class="fas fa-clock"></i></div>';
		echo '<div class="step-label">In Progress</div>';
		echo '</div>';
		
		// Step 2: Food OTW
		echo '<div class="tracker-step" data-step="food-otw">';
		echo '<div class="step-icon"><i class="fas fa-motorcycle"></i></div>';
		echo '<div class="step-label">Food OTW</div>';
		echo '</div>';
		
		// Step 3: Delivered
		echo '<div class="tracker-step" data-step="delivered">';
		echo '<div class="step-icon"><i class="fas fa-check-circle"></i></div>';
		echo '<div class="step-label">Delivered</div>';
		echo '</div>';
	}
	
	echo '</div>'; // end tracker-steps
	echo '</div>'; // end tracker-container
	echo '</div>'; // end order-tracker
	
	echo '<h4 class="card-title header" id="order_number">Order-Number:</h4>';
	echo '<p id="order-number-'. $row["order_id"] .'" class="content">'. $row["order_id"] .'</p>';
	echo '<br> <h4 class="amount header" >Total-Amount:</h4>';
	echo '<p id="amount-' . $row["order_id"] . '" class="content ">₱ ' . $row["amount"] .  '</p>';
	echo '<br> <h4 class="items header" >Items</h4>';
	echo '<p class="hidden-data" id="hidden-data-' . $row["order_id"] . '">'. $row["description"] .'</p>';	
	echo '<p id="items-' . $row["order_id"] . '" class="no-of-items content">' . $row["description"] . '</p> <br> <h4 class="date header" >Ordered On:</h4>';
	echo '<p id="ordered-' . $row["order_id"] . '" class="content">' . $row["date"] . '</p>';
	echo '<br> <h4 class="status header" >Status</h4>';
	echo '<p id="status-'. $row["order_id"] . '" class="delivered content">' . $row["status"] .'</p>';
	echo '<br> <div class="card-block modal-button">';
	echo '<button href="#" onclick="modalshow(' . $row['order_id'] . ')" class="add-to-cart btn btn-outline-primary button" data-toggle="modal" data-target="#exampleModalCenter">View Order</button> </div> </div> </div>';
	if($i==2)
	{
	echo '</div>';
	$i=-1;}	
	$i+=1;$j+=1;
	
    }
} else {
    echo '<div class="sc-fCPvlr ejewMc"><div height="200px" width="180px" class="s1isp7-1 dzOBvv sc-hAXbOi fLBnSZ"><div src="" class="s1isp7-3 dqsEmh"></div><img alt="No Orders" src="https://b.zmtcdn.com/webFrontend/96a9a259cfa3dd8e260d65d1f135ab941581004545.png" loading="lazy" class="s1isp7-5 cNjMLA"></div><p class="sc-1hez2tp-0 sc-gAmQfK egPsux">Nothing here yet</p></div>';

}

$conn->close();

}
else
{
echo 'login first';
}


?>


  </div>

  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-title">Order Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Order Tracker in Modal -->
          <div class="order-tracker" id="modal-tracker">
            <h5 style="text-align: center; margin-bottom: 15px; color: #495057;">Order Progress</h5>
            <div class="tracker-container" id="modal-tracker-container">
              <div class="tracker-steps">
                <div class="progress-line" id="modal-progress-line"></div>
                
                <!-- Step 1: In Progress -->
                <div class="tracker-step" data-step="in-progress">
                  <div class="step-icon"><i class="fas fa-clock"></i></div>
                  <div class="step-label">In Progress</div>
                </div>
                
                <!-- Step 2: Food OTW -->
                <div class="tracker-step" data-step="food-otw">
                  <div class="step-icon"><i class="fas fa-motorcycle"></i></div>
                  <div class="step-label">Food OTW</div>
                </div>
                
                <!-- Step 3: Delivered -->
                <div class="tracker-step" data-step="delivered">
                  <div class="step-icon"><i class="fas fa-check-circle"></i></div>
                  <div class="step-label">Delivered</div>
                </div>
                
                <!-- Step 4: Cancelled (only show if cancelled) -->
                <div class="tracker-step" data-step="cancelled" style="display: none;">
                  <div class="step-icon"><i class="fas fa-times-circle"></i></div>
                  <div class="step-label">Cancelled</div>
                </div>
              </div>
            </div>
          </div>
          
          <table>
            <tbody >
              <tr>
                <th scope="row">Order Number</th>
                <td id="modal-number"></td>
              </tr>
              <tr>
                <th scope="row">Total Amount</th>
                <td id="modal-amount"></td>
              </tr>
              <tr>
                <th class="align-text-top" scope="row">Items</th>
                <td>
                  <div id="kuch">
                </div>
                </td>
              </tr>
              <tr>
                <th scope="row">Ordered On</th>
                <td id="modal-ordered"></td>
              </tr>
              <tr>
                <th scope="row">Status</th>
                <td id="modal-status"></td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- <div class="modal-footer"> -->

        </div>
      </div>
    </div>
  </div>

  <footer class="section section_footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-4">

					<!-- About Us -->
					<h5 class="section_footer__heading">
						About Us
					</h5>
					<p>
						We have been brewing our own coffee and serving for 3 years now, and popular for our great coffee and lively atmosphere.
					</p>

				</div>
				<div class="col-sm-4">

					<!-- Contact info -->
					<h5 class="section_footer__heading">
						Contact info
					</h5>
					<ul class="section_footer__info">
						<li>
							<i class="fas fa-map-marker-alt"></i> Sōho Cafe + Kitchen Biñan Branch Petron Timbao
						</li>
						<li>
							<i class="fas fa-phone"></i> 09100229687
						</li>
						<li>
							<i class="far fa-envelope"></i> <a href="mailto:johndoedelacruz69@gmail.com">sohocafe&kitchen@gmail.com</a>
						</li>
					</ul>

				</div>
				<div class="col-sm-4">

					<!-- Opening hours -->
					<h5 class="section_footer__heading">
						Opening hours
					</h5>
					<div class="section_footer__open">
						<div class="section_footer__open__days">Monday - Thursday</div>
						<div class="section_footer__open__time">3:00 PM - 11:00 PM</div>
					</div>
					<div class="section_footer__open">
						<div class="section_footer__open__days">Friday - Sunday</div>
						<div class="section_footer__open__time">3:00 PM - 12:00 AM</div>
					</div>

				</div>
			</div> <!-- / .row -->
			<div class="row">
				<div class="col-12">

					<!-- Copyright -->
					<div class="section_footer__copyright">
						&copy; <span id="js-current-year"></span> SOHO Cafe & Kitchen. All rights reserved.
					</div>

				</div>
			</div> <!-- / .row -->
		</div> <!-- / .container -->
	</footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- JS Plugins -->
	<script src="assets/plugins/parallax/parallax.min.js"></script>
	<script src="assets/plugins/isotope/lib/imagesloaded.pkgd.min.js"></script>
	<script src="assets/plugins/isotope/isotope.pkgd.min.js"></script>
	<script src="assets/plugins/flickity/flickity.pkgd.min.js"></script>
	<script src="assets/plugins/lightbox/js/lightbox.min.js"></script>
	<script src="assets/plugins/reservation/reservation.js"></script>
	<script src="assets/plugins/alerts/alerts.js"></script>

	<!-- JS Custom -->
	<script src="assets/js/theme.min.js"></script>
	<script src="assets/js/custom.js"></script>

<script>
// Function to update order tracker based on status
function updateOrderTracker() {
    document.querySelectorAll('.tracker-container').forEach(function(container) {
        const status = container.getAttribute('data-status');
        console.log('Processing order with status:', status); // Debug line
        const steps = container.querySelectorAll('.tracker-step');
        const progressLine = container.querySelector('.progress-line');
        
        // Reset all steps
        steps.forEach(step => {
            step.classList.remove('active', 'completed', 'in-progress', 'otw', 'food-otw', 'cancelled');
        });
        
        let progressWidth = 0;
        
        // For cancelled orders, hide all other steps and show only cancelled
        if (status === 'cancelled' || status === 'cancel' || status === 'canceled') {
            // Hide all normal steps
            steps.forEach((step, index) => {
                if (step.getAttribute('data-step') !== 'cancelled') {
                    step.style.display = 'none';
                } else {
                    step.style.display = 'flex';
                    step.classList.add('cancelled');
                }
            });
            // Hide progress line for cancelled orders
            if (progressLine) {
                progressLine.style.display = 'none';
            }
            return; // Exit early for cancelled orders
        } else {
            // Show all normal steps and hide cancelled step for non-cancelled orders
            steps.forEach((step, index) => {
                if (step.getAttribute('data-step') === 'cancelled') {
                    step.style.display = 'none';
                } else {
                    step.style.display = 'flex';
                }
            });
            // Show progress line for active orders
            if (progressLine) {
                progressLine.style.display = 'block';
            }
        }
        
        switch(status) {
            case 'in-progress':
            case 'in_progress':
                steps[0].classList.add('in-progress');
                progressWidth = 0;
                break;
                
            case 'food-otw':
            case 'food_otw':
            case 'otw':
                steps[0].classList.add('completed');
                steps[1].classList.add('food-otw');
                progressWidth = 33.33;
                break;
                
            case 'delivered':
                steps[0].classList.add('completed');
                steps[1].classList.add('completed');
                steps[2].classList.add('active');
                progressWidth = 100;
                break;
                
            default:
                // Default to in progress
                steps[0].classList.add('in-progress');
                progressWidth = 0;
        }
        
        // Update progress line width
        if (progressLine) {
            progressLine.style.width = progressWidth + '%';
        }
    });
}

// Initialize trackers when page loads
document.addEventListener('DOMContentLoaded', function() {
    updateOrderTracker();
});

// Existing modal function
function modalshow(orderId) {
    // Get order details
    const orderNumber = document.getElementById('order-number-' + orderId).textContent;
    const amount = document.getElementById('amount-' + orderId).textContent;
    const ordered = document.getElementById('ordered-' + orderId).textContent;
    const status = document.getElementById('status-' + orderId).textContent;
    
    // Update modal content
    document.getElementById('modal-number').textContent = orderNumber;
    document.getElementById('modal-amount').textContent = amount;
    document.getElementById('modal-ordered').textContent = ordered;
    document.getElementById('modal-status').textContent = status;
    
    // Show loading message
    document.getElementById('kuch').innerHTML = '<div class="text-center"><small>Loading order details...</small></div>';
    
    // Fetch detailed order information with size data
    fetch('get_order_details.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'order_id=' + encodeURIComponent(orderId) + '&customer_view=1'
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response from server:', data); // Debug line
        
        // Extract just the items table from the response
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = data;
        const itemsTable = tempDiv.querySelector('.table tbody');
        
        if (itemsTable) {
            // Convert the admin table format to a customer-friendly list
            const rows = itemsTable.querySelectorAll('tr');
            let itemsHtml = '<ul class="order-items-list">';
            
            rows.forEach(function(row) {
                const cells = row.querySelectorAll('td');
                if (cells.length >= 4) { // Make sure we have enough cells
                    const itemName = cells[0].textContent.trim();
                    const detailsCell = cells[1]; // This should contain the badges
                    const quantity = cells[2].textContent.trim();
                    const price = cells[3].textContent.trim();
                    
                    if (itemName && itemName !== 'Total Amount:') {
                        itemsHtml += '<li class="order-item">';
                        itemsHtml += '<span class="item-name">' + itemName + '</span>';
                        
                        // Extract badges from the details cell
                        const badges = detailsCell.querySelectorAll('.temperature-badge, .size-badge');
                        if (badges.length > 0) {
                            badges.forEach(function(badge) {
                                // Clone the badge and add it to our content
                                const badgeClone = badge.cloneNode(true);
                                itemsHtml += ' ' + badgeClone.outerHTML;
                            });
                        } else {
                            // Fallback: try to get innerHTML if no specific badges found
                            const badgeHtml = detailsCell.innerHTML.trim();
                            if (badgeHtml) {
                                itemsHtml += ' ' + badgeHtml;
                            }
                        }
                        
                        itemsHtml += '<br><small class="item-details">Qty: ' + quantity + ' | Price: ' + price + '</small>';
                        itemsHtml += '</li>';
                    }
                }
            });
            itemsHtml += '</ul>';
            document.getElementById('kuch').innerHTML = itemsHtml;
        } else {
            console.log('No items table found, using fallback method');
            // Fallback to the old method if the fetch fails
            const items = document.getElementById('hidden-data-' + orderId).textContent;
            const itemsArray = items.split(',');
            let itemsHtml = '<ul>';
            itemsArray.forEach(function(item) {
                if (item.trim()) {
                    itemsHtml += '<li>' + item.trim() + '</li>';
                }
            });
            itemsHtml += '</ul>';
            document.getElementById('kuch').innerHTML = itemsHtml;
        }
    })
    .catch(error => {
        console.error('Error fetching order details:', error);
        // Fallback to the old method with test badges
        const items = document.getElementById('hidden-data-' + orderId).textContent;
        const itemsArray = items.split(',');
        let itemsHtml = '<ul class="order-items-list">';
        itemsArray.forEach(function(item) {
            if (item.trim()) {
                // Parse item format: "1-Café Latte-149"
                const parts = item.trim().split('-');
                if (parts.length >= 3) {
                    const qty = parts[0];
                    const name = parts[1];
                    const price = parts[2];
                    
                    itemsHtml += '<li class="order-item">';
                    itemsHtml += '<span class="item-name">' + name + '</span>';
                    
                    // Add test badges based on item name
                    if (name.toLowerCase().includes('latte') || name.toLowerCase().includes('cappuccino') || name.toLowerCase().includes('americano')) {
                        itemsHtml += ' <span class="temperature-badge hot-badge">HOT</span>';
                        if (name.toLowerCase().includes('latte')) {
                            itemsHtml += ' <span class="size-badge size-venti-badge">VENTI</span>';
                        } else if (name.toLowerCase().includes('cappuccino')) {
                            itemsHtml += ' <span class="size-badge size-grande-badge">GRANDE</span>';
                        } else {
                            itemsHtml += ' <span class="size-badge size-tall-badge">TALL</span>';
                        }
                    }
                    
                    itemsHtml += '<br><small class="item-details">Qty: ' + qty + ' | Price: ₱' + price + '</small>';
                    itemsHtml += '</li>';
                } else {
                    itemsHtml += '<li>' + item.trim() + '</li>';
                }
            }
        });
        itemsHtml += '</ul>';
        document.getElementById('kuch').innerHTML = itemsHtml;
    });
    
    // Update modal tracker
    updateModalTracker(status);
}

// Function to update modal tracker based on status
function updateModalTracker(status) {
    console.log('Updating modal tracker with status:', status); // Debug line
    const container = document.getElementById('modal-tracker-container');
    const steps = container.querySelectorAll('.tracker-step');
    const progressLine = document.getElementById('modal-progress-line');
    const cancelledStep = container.querySelector('[data-step="cancelled"]');
    
    // Set the data-status attribute on the modal container for CSS targeting
    const normalizedStatus = status.toLowerCase().replace(/\s+/g, '-');
    container.setAttribute('data-status', normalizedStatus);
    console.log('Set modal container data-status to:', normalizedStatus); // Debug line
    
    // Reset all steps
    steps.forEach(step => {
        step.classList.remove('active', 'completed', 'in-progress', 'otw', 'food-otw', 'cancelled');
    });
    
    let progressWidth = 0;
    console.log('Normalized status:', normalizedStatus); // Debug line
    
    // For cancelled orders, hide all other steps and show only cancelled
    if (normalizedStatus === 'cancelled' || normalizedStatus === 'cancel' || normalizedStatus === 'canceled') {
        // Hide all normal steps
        steps.forEach((step, index) => {
            if (step.getAttribute('data-step') !== 'cancelled') {
                step.style.display = 'none';
            } else {
                step.style.display = 'flex';
                step.classList.add('cancelled');
            }
        });
        // Hide progress line for cancelled orders
        progressLine.style.display = 'none';
        return; // Exit early for cancelled orders
    } else {
        // Show all normal steps and hide cancelled step for non-cancelled orders
        steps.forEach((step, index) => {
            if (step.getAttribute('data-step') === 'cancelled') {
                step.style.display = 'none';
            } else {
                step.style.display = 'flex';
            }
        });
        // Show progress line for active orders
        progressLine.style.display = 'block';
    }
    
    switch(normalizedStatus) {
        case 'in-progress':
        case 'in_progress':
            steps[0].classList.add('in-progress');
            progressWidth = 0;
            break;
            
        case 'food-otw':
        case 'food_otw':
        case 'otw':
            steps[0].classList.add('completed');
            steps[1].classList.add('food-otw');
            progressWidth = 33.33;
            break;
            
        case 'delivered':
            steps[0].classList.add('completed');
            steps[1].classList.add('completed');
            steps[2].classList.add('active');
            progressWidth = 100;
            break;
            
        default:
            // Default to in progress
            steps[0].classList.add('in-progress');
            progressWidth = 0;
    }
    
    // Update progress line width
    progressLine.style.width = progressWidth + '%';
}
</script>

  </body>
</html>
