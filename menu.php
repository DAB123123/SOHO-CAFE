<?php
// Start session before any HTML output
session_start();
?>
<!doctype html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="apple-touch-icon" sizes="180x180" href="assets/ico/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/ico/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/ico/favicon-16x16.png">
	<link rel="manifest" href="assets/ico/manifest.json">
	<link rel="mask-icon" href="assets/ico/safari-pinned-tab.svg" color="#5bbad5">
	<link rel="shortcut icon" href="assets/ico/favicon.ico">
	<meta name="msapplication-config" content="assets/ico/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">

	<title>Menu</title>

	<!-- CSS Plugins -->
	<link rel="stylesheet" href="assets/plugins/font-awesome/css/all.min.css">
	<link rel="stylesheet" href="assets/plugins/lightbox/css/lightbox.min.css">
	<link rel="stylesheet" href="assets/plugins/flickity/flickity.min.css">

	<!-- CSS Global -->
	<link rel="stylesheet" href="assets/css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="assets/css/style.css"> <!-- Resource style -->
	<script src="assets/js/modernizr.js"></script>
	<link rel="stylesheet" href="assets/css/theme.min.css">
	<link rel="stylesheet" href="assets/css/menu.css"> <!-- Menu specific styles -->

<script type="text/javascript" src="assets/js/menuitem.php"></script>

  </head>
  <body>

	<!-- NAVBAR
	================================================== -->
  <?php require_once 'nav.php' ?> <!-- / .navbar -->

	<!-- HEADER
	================================================== -->
	<section class="section section_header" data-parallax="scroll" data-image-src="assets/img/25.jpg">
		<div class="container">
			<div class="row">
				<div class="col">

					<!-- Heading -->
					<h1 class="section__heading section_header__heading text-center">
						Menu
					</h1>

				</div>
			</div> <!-- / .row -->
		</div> <!-- / .container -->
	</section>

	<!-- MENU
	================================================== -->
	<section class="section section_menu section_border_bottom">
		<div class="container">
			<div class="row">
				<div class="col">

					<!-- Heading -->
					<h2 class="section__heading text-center">
						Browse by categories
					</h2>
					<p class="section__subheading text-center">
						Choose from our selection of hot & cold drinks, fresh pastries, and delicious food.
					</p>

					<!-- Category Filter Buttons -->
					<div class="category-filter">
						<button class="filter-btn active" onclick="showCategory('all')">All Items</button>
						<button class="filter-btn" onclick="showCategory('drinks')">Drinks</button>
						<button class="filter-btn" onclick="showCategory('hot')">Hot Drinks</button>
						<button class="filter-btn" onclick="showCategory('cold')">Cold Drinks</button>
						<button class="filter-btn" onclick="showCategory('pastries')">Pastries</button>
						<button class="filter-btn" onclick="showCategory('food')">Food</button>
					</div>
				</div>
			</div>

			<?php
			require_once "config.php";

			// Get drinks (hot & cold)
			$hot_drinks = $conn->query("SELECT * FROM menu WHERE category = 'drinks' AND temperature = 'hot' ORDER BY name");
			$cold_drinks = $conn->query("SELECT * FROM menu WHERE category = 'drinks' AND temperature = 'cold' ORDER BY name");
			
			// Get other categories
			$pastries = $conn->query("SELECT * FROM menu WHERE category = 'pastries' ORDER BY name");
			$food = $conn->query("SELECT * FROM menu WHERE category = 'food' ORDER BY name");

			function displayMenuItems($result, $show_temperature = false) {
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						echo '<div class="menu-item">';
						echo '<div class="menu-item-content">';
						echo '<div class="menu-item-row">';
						echo '<div class="menu-item-image">';
						echo '<img src="assets/img/menu/' . $row["menu_id"] . '.png" alt="' . htmlspecialchars($row["name"]) . '">';
						echo '</div>';
						echo '<div class="menu-item-details">';
						echo '<h4>' . htmlspecialchars($row["name"]);
						
						// Add temperature badge for drinks
						if ($show_temperature && !empty($row["temperature"])) {
							$badge_class = $row["temperature"] == 'hot' ? 'hot-badge' : 'cold-badge';
							echo '<span class="temperature-badge ' . $badge_class . '">' . strtoupper($row["temperature"]) . '</span>';
						}
						
						echo '</h4>';
						echo '<p>' . htmlspecialchars($row["description"]) . '</p>';
						echo '</div>';
						echo '</div>';
						echo '<div class="menu-item-price">';
						echo '<p>₱' . number_format($row["price"], 0) .'</p>';
						echo '<div class="menu-item-actions">';
						
						// Check if item is a drink to show size selection
						if ($row["category"] == 'drinks') {
							echo '<button class="add-to-cart btn btn-outline-primary" onclick="showSizeSelection('. $row["menu_id"] . ', \'' . addslashes($row["name"]) . '\', ' . $row["price"] . ', this)">ADD TO CART</button>';
						} else {
							echo '<button class="add-to-cart btn btn-outline-primary" onclick="addToCartWithNotification('. $row["menu_id"] . ', \'' . addslashes($row["name"]) . '\', this)">ADD TO CART</button>';
						}
						
						echo '</div>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
					}
				}
			}
            ?>

            <!-- Hot Drinks Section -->
            <div class="menu-section" id="hot-drinks-section">
                <h3 class="section-title">Hot Drinks</h3>
                <div class="menu-grid-container">
                    <?php displayMenuItems($hot_drinks, true); ?>
                </div>
            </div>

            <!-- Cold Drinks Section -->
            <div class="menu-section" id="cold-drinks-section">
                <h3 class="section-title">Cold Drinks</h3>
                <div class="menu-grid-container">
                    <?php displayMenuItems($cold_drinks, true); ?>
                </div>
            </div>

            <!-- Pastries Section -->
            <div class="menu-section" id="pastries-section">
                <h3 class="section-title">Pastries</h3>
                <div class="menu-grid-container">
                    <?php displayMenuItems($pastries); ?>
                </div>
            </div>

            <!-- Food Section -->
            <div class="menu-section" id="food-section">
                <h3 class="section-title">Food</h3>
                <div class="menu-grid-container">
                    <?php displayMenuItems($food); ?>
                </div>
            </div>

            <?php $conn->close(); ?>
        </div>
    </section>

	



	<!-- FOOTER
	================================================== -->
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

	<!-- Size Selection Modal -->
	<div id="size-selection-modal" class="size-modal">
		<div class="size-modal-content">
			<div class="size-modal-header">
				<h3 id="modal-item-name">Select Size</h3>
				<span class="size-modal-close" onclick="closeSizeModal()">&times;</span>
			</div>
			<div class="size-modal-body">
				<div class="size-options">
					<div class="size-option" data-size="short" data-multiplier="1">
						<div class="size-info">
							<h4>Short</h4>
							<p>8 oz</p>
						</div>
						<div class="size-price" id="short-price">₱0</div>
					</div>
					<div class="size-option" data-size="tall" data-multiplier="1.25">
						<div class="size-info">
							<h4>Tall</h4>
							<p>12 oz</p>
						</div>
						<div class="size-price" id="tall-price">₱0</div>
					</div>
					<div class="size-option" data-size="grande" data-multiplier="1.5">
						<div class="size-info">
							<h4>Grande</h4>
							<p>16 oz</p>
						</div>
						<div class="size-price" id="grande-price">₱0</div>
					</div>
					<div class="size-option" data-size="venti" data-multiplier="1.75">
						<div class="size-info">
							<h4>Venti</h4>
							<p>20 oz</p>
						</div>
						<div class="size-price" id="venti-price">₱0</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- JAVASCRIPT
	================================================== -->

	<!-- JS Global -->
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

	<script src="assets/js/javascript.js"></script>	
	<script src="assets/js/jquery-2.1.4.js"></script>
  <script src="assets/js/main.js"></script>

  <script>
        function showSize(size) {
            // Remove active class from all size buttons
            document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            if (event && event.target) {
                event.target.classList.add('active');
            } else {
                // If no event, find the button by size
                const btn = document.querySelector(`.size-btn[onclick*="${size}"]`);
                if (btn) btn.classList.add('active');
            }
            
            // Filter items based on size
            document.querySelectorAll('.menu-item').forEach(item => {
                const itemSize = item.getAttribute('data-size');
                if (size === 'all' || itemSize === size) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function showCategory(category) {
            // Remove active class from all buttons
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            event.target.classList.add('active');
            
            // Hide all sections
            document.querySelectorAll('.menu-section').forEach(section => {
                section.style.display = 'none';
            });
            
            // Show selected sections
            if (category === 'all') {
                document.querySelectorAll('.menu-section').forEach(section => {
                    section.style.display = 'block';
                });
                // Hide size filter
                document.getElementById('size-filter').style.display = 'none';
                // Show all items
                document.querySelectorAll('.menu-item').forEach(item => {
                    item.style.display = 'block';
                });
            } else if (category === 'drinks') {
                document.getElementById('hot-drinks-section').style.display = 'block';
                document.getElementById('cold-drinks-section').style.display = 'block';
                // Show size filter
                document.getElementById('size-filter').style.display = 'block';
                // Reset size filter to all
                showSize('all');
            } else if (category === 'hot') {
                document.getElementById('hot-drinks-section').style.display = 'block';
                // Show size filter
                document.getElementById('size-filter').style.display = 'block';
                // Reset size filter to all
                showSize('all');
            } else if (category === 'cold') {
                document.getElementById('cold-drinks-section').style.display = 'block';
                // Show size filter
                document.getElementById('size-filter').style.display = 'block';
                // Reset size filter to all
                showSize('all');
            } else if (category === 'pastries') {
                document.getElementById('pastries-section').style.display = 'block';
                // Hide size filter
                document.getElementById('size-filter').style.display = 'none';
            } else if (category === 'food') {
                document.getElementById('food-section').style.display = 'block';
                // Hide size filter
                document.getElementById('size-filter').style.display = 'none';
            }
        }
    </script>

    <script>
        // Cart notification system
        function showCartNotification(type, title, message) {
            // Remove any existing notifications
            const existingNotification = document.querySelector('.cart-notification');
            if (existingNotification) {
                existingNotification.remove();
            }

            // Create notification element
            const notification = document.createElement('div');
            notification.className = `cart-notification ${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <div class="notification-icon">
                        ${type === 'success' ? '✓' : type === 'warning' ? '⚠' : 'ℹ'}
                    </div>
                    <div class="notification-text">
                        <div class="notification-title">${title}</div>
                        <div class="notification-message">${message}</div>
                    </div>
                    <button class="close-btn" onclick="hideCartNotification(this)">&times;</button>
                </div>
            `;

            // Add to page
            document.body.appendChild(notification);

            // Show notification with animation
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);

            // Auto-hide after 4 seconds
            setTimeout(() => {
                hideCartNotification(notification);
            }, 4000);
        }

        function hideCartNotification(element) {
            const notification = element.closest ? element.closest('.cart-notification') : element;
            if (notification) {
                notification.classList.remove('show');
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 400);
            }
        }

        // Enhanced addtolocal function with notifications
        function addToCartWithNotification(menuId, itemName, buttonElement) {
            // Get button element if not passed
            if (!buttonElement) {
                buttonElement = event.target;
            }

            // Add loading state
            buttonElement.classList.add('loading');
            const originalText = buttonElement.textContent;

            // Get the current user cart
            let user = {};
            if (localStorage.getItem("user") != null) {
                user = JSON.parse(localStorage.getItem("user"));
            }

            if (!(user.hasOwnProperty(userid))) {
                if ((user.hasOwnProperty(0))) {
                    user[userid] = user[0];
                    delete user[0];
                    localStorage.setItem("user", JSON.stringify(user));
                } else {
                    user[userid] = [];
                }
            }

            // Simulate a brief delay for better UX
            setTimeout(() => {
                // Check if item already exists
                if (user[userid].indexOf(menuId) !== -1) {
                    showCartNotification('warning', 'Already in Cart', `${itemName} is already in your cart.`);
                    
                    // Remove loading state
                    buttonElement.classList.remove('loading');
                    return false;
                }

                // Add item to cart (same logic as original addtolocal)
                const n = user[userid].length;
                const key = menuId;
                let i;
                for (i = n - 1; (i >= 0 && user[userid][i] > key); i--) {
                    user[userid][i + 1] = user[userid][i];
                }
                user[userid][i + 1] = key;

                // Update localStorage
                localStorage.setItem("user", JSON.stringify(user));

                // Remove loading state
                buttonElement.classList.remove('loading');

                // Brief success animation
                buttonElement.style.background = '#28a745';
                buttonElement.style.color = 'white';
                buttonElement.textContent = 'Added!';

                // Reset button after animation
                setTimeout(() => {
                    buttonElement.style.background = '';
                    buttonElement.style.color = '';
                    buttonElement.textContent = originalText;
                }, 1500);

                // Show success notification
                showCartNotification('success', 'Added to Cart', `${itemName} has been added to your cart!`);

                console.log(user);
                return true;
            }, 300); // Small delay for better perceived performance
        }

        // Global variable to store size pricing
        let sizePricing = {};
        
        // Load size pricing from database
        function loadSizePricing() {
            fetch('get_size_pricing.php')
                .then(response => response.json())
                .then(data => {
                    sizePricing = data;
                    console.log('Size pricing loaded:', sizePricing);
                })
                .catch(error => {
                    console.error('Error loading size pricing:', error);
                    // Fallback to default pricing
                    sizePricing = {
                        'short': { description: '8 oz', multiplier: 1.00 },
                        'tall': { description: '12 oz', multiplier: 1.25 },
                        'grande': { description: '16 oz', multiplier: 1.50 },
                        'venti': { description: '20 oz', multiplier: 1.75 }
                    };
                });
        }

        // Show size selection modal
        function showSizeSelection(menuId, itemName, basePrice, buttonElement) {
            const modal = document.getElementById('size-selection-modal');
            const modalItemName = document.getElementById('modal-item-name');
            
            modalItemName.textContent = itemName;
            
            // Update prices and descriptions for each size
            Object.keys(sizePricing).forEach(size => {
                const priceElement = document.getElementById(size + '-price');
                const sizeOption = document.querySelector(`[data-size="${size}"]`);
                
                if (priceElement && sizeOption) {
                    const finalPrice = Math.round(basePrice * sizePricing[size].multiplier);
                    priceElement.textContent = '₱' + finalPrice;
                    
                    // Update the data-multiplier attribute to match database
                    sizeOption.setAttribute('data-multiplier', sizePricing[size].multiplier);
                    
                    // Update size description
                    const sizeInfo = sizeOption.querySelector('.size-info p');
                    if (sizeInfo) {
                        sizeInfo.textContent = sizePricing[size].description;
                    }
                    
                    // Update size option click handler
                    sizeOption.onclick = function() {
                        // Remove selected class from all options
                        document.querySelectorAll('.size-option').forEach(opt => opt.classList.remove('selected'));
                        // Add selected class to clicked option
                        this.classList.add('selected');
                        
                        // Add to cart with size information
                        setTimeout(() => {
                            addToCartWithSize(menuId, itemName, size, finalPrice, buttonElement);
                            closeSizeModal();
                        }, 200);
                    };
                }
            });
            
            // Clear previous selections
            document.querySelectorAll('.size-option').forEach(option => {
                option.classList.remove('selected');
            });
            
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        // Close size selection modal
        function closeSizeModal() {
            const modal = document.getElementById('size-selection-modal');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        // Load size pricing when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadSizePricing();
            
            // Close modal when clicking outside
            window.onclick = function(event) {
                const modal = document.getElementById('size-selection-modal');
                if (event.target === modal) {
                    closeSizeModal();
                }
            };
        });

        // Enhanced addToCartWithSize function for drinks with sizes
        function addToCartWithSize(menuId, itemName, size, price, buttonElement) {
            // Get the current user cart
            let user = {};
            if (localStorage.getItem("user") != null) {
                user = JSON.parse(localStorage.getItem("user"));
            }

            if (!(user.hasOwnProperty(userid))) {
                if ((user.hasOwnProperty(0))) {
                    user[userid] = user[0];
                    delete user[0];
                    localStorage.setItem("user", JSON.stringify(user));
                } else {
                    user[userid] = [];
                }
            }

            // Create unique item ID with size (e.g., "123_short", "123_tall")
            const sizeItemId = `${menuId}_${size}`;
            const sizeDescription = sizePricing[size] ? sizePricing[size].description : size;
            const displayName = `${itemName} (${size.charAt(0).toUpperCase() + size.slice(1)} ${sizeDescription})`;

            // Check if this exact size combination already exists
            if (user[userid].some(item => {
                if (typeof item === 'object' && item.fullId) {
                    return item.fullId === sizeItemId;
                }
                return item.toString() === sizeItemId;
            })) {
                showCartNotification('warning', 'Already in Cart', `${displayName} is already in your cart.`);
                return false;
            }

            // Add item with size to cart
            user[userid].push({
                id: menuId,
                size: size,
                price: price,
                name: itemName,
                fullId: sizeItemId
            });

            // Update localStorage
            localStorage.setItem("user", JSON.stringify(user));

            // Add loading state
            if (buttonElement) {
                buttonElement.classList.add('loading');
                const originalText = buttonElement.textContent;

                // Brief success animation
                buttonElement.style.background = '#28a745';
                buttonElement.style.color = 'white';
                buttonElement.textContent = 'Added!';

                // Reset button after animation
                setTimeout(() => {
                    buttonElement.classList.remove('loading');
                    buttonElement.style.background = '';
                    buttonElement.style.color = '';
                    buttonElement.textContent = originalText;
                }, 1500);
            }

            // Show success notification
            showCartNotification('success', 'Added to Cart', `${displayName} has been added to your cart! (₱${price})`);

            console.log(user);
            return true;
        }
    </script>

  </body>
</html>
