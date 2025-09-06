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
	
	<style>

    </style>


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
						echo '<div class="col-md-6 section_menu__grid__item">';
						echo '<div class="section_menu__item"><div class="row"><div class="col-3 align-self-center"><div class="section_menu__item__img">';
						echo '<img src="assets/img/menu/' . $row["menu_id"] . '.png" alt="not found">';
						echo '</div></div><div class="col-6"><h4 class="1">' . $row["name"];
						
						// Add temperature badge for drinks
						if ($show_temperature && !empty($row["temperature"])) {
							$badge_class = $row["temperature"] == 'hot' ? 'hot-badge' : 'cold-badge';
							echo '<span class="temperature-badge ' . $badge_class . '">' . strtoupper($row["temperature"]) . '</span>';
						}
						
						echo '</h4><p>' . $row["description"] . '</p></div>';
						echo '<div class="col-3"><div class="section_menu__item__price text-center"><p class="1">₱' . $row["price"] .'</p><br></div>';
						echo '<div class="cd-single-item" style="position:absolute;bottom:0"><a href="#0"><ul class="cd-slider-wrapper" style="margin-bottom:0"><li class="selected"><button style="padding:7px 9px; font-size:small" class="add-to-cart btn btn-outline-primary button">ADD TO CART</button></li></ul></a><div class="cd-customization" style="padding:0px;">';	
                        echo '<button class="add-to-cart" style="width:100%;font-size:small;margin-bottom:0" onclick="addtolocal('. $row["menu_id"] . ')">';
                        echo '<em>Add to Cart</em><svg x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"/></svg></button></div><button class="cd-customization-trigger">Customize</button></div>';
                        echo '</div></div></div></div><br>';
                    }
                }
            }
            ?>

            <!-- Hot Drinks Section -->
            <div class="menu-section" id="hot-drinks-section">
                <h3 class="section-title">Hot Drinks</h3>
                <div class="row section_menu__grid">
                    <?php displayMenuItems($hot_drinks, true); ?>
                </div>
            </div>

            <!-- Cold Drinks Section -->
            <div class="menu-section" id="cold-drinks-section">
                <h3 class="section-title">Cold Drinks</h3>
                <div class="row section_menu__grid">
                    <?php displayMenuItems($cold_drinks, true); ?>
                </div>
            </div>

            <!-- Pastries Section -->
            <div class="menu-section" id="pastries-section">
                <h3 class="section-title">Pastries</h3>
                <div class="row section_menu__grid">
                    <?php displayMenuItems($pastries); ?>
                </div>
            </div>

            <!-- Food Section -->
            <div class="menu-section" id="food-section">
                <h3 class="section-title">Food</h3>
                <div class="row section_menu__grid">
                    <?php displayMenuItems($food); ?>
                </div>
            </div>

            <?php $conn->close(); ?>
        </div>
    </section>

	<!-- DISHES
	================================================== -->
	<section class="section section_dishes">

		<!-- Header -->
		<div class="container">
			<div class="row">
				<div class="col">

					<!-- Heading -->
					<h2 class="section__heading text-center">
						Featured dishes
					</h2>

					<!-- Subheading -->
					<p class="section__subheading text-center">
						Quibusdam in labore tempore quidem voluptatum ullam soluta! Maiores!
					</p>

				</div>
			</div>
		</div>

		<!-- Carouse -->
		<div class="section_dishes__carousel">
			<div class="section_dishes__carousel__item>

				<!-- Image -->
				<img src="assets/img/26.jpg" alt="..." class="section_dishes__carousel__item__img">

				<!-- Body -->
				<div class="section_dishes__carousel__item__body">
					<h5 class="section_dishes__carousel__item__body__heading mb-0">
						Lorem ipsum dolor sit amet <span>₱25</span>
					</h5>
					
				</div>

			</div>
			<div class="section_dishes__carousel__item">

				<!-- Image -->
				<img src="assets/img/27.jpg" alt="..." class="section_dishes__carousel__item__img">

				<!-- Body -->
				<div class="section_dishes__carousel__item__body">
					<h5 class="section_dishes__carousel__item__body__heading mb-0">
						Lorem ipsum dolor sit amet <span>₱35</span>
					</h5>
				</div>

			</div>
			<div class="section_dishes__carousel__item">

				<!-- Image -->
				<img src="assets/img/28.jpg" alt="..." class="section_dishes__carousel__item__img">

				<!-- Body -->
				<div class="section_dishes__carousel__item__body">
					<h5 class="section_dishes__carousel__item__body__heading mb-0">
						Lorem ipsum dolor sit amet <span>₱18</span>
					</h5>
				</div>

			</div>
			<div class="section_dishes__carousel__item">

				<!-- Image -->
				<img src="assets/img/29.jpg" alt="..." class="section_dishes__carousel__item__img">

				<!-- Body -->
				<div class="section_dishes__carousel__item__body">
					<h5 class="section_dishes__carousel__item__body__heading mb-0">
						Lorem ipsum dolor sit amet <span>₱32</span>
					</h5>
				</div>

			</div>
			<div class="section_dishes__carousel__item">

				<!-- Image -->
				<img src="assets/img/30.jpg" alt="..." class="section_dishes__carousel__item__img">

				<!-- Body -->
				<div class="section_dishes__carousel__item__body">
					<h5 class="section_dishes__carousel__item__body__heading mb-0">
						Lorem ipsum dolor sit amet <span>₱40</span>
					</h5>
				</div>

			</div>
			<div class="section_dishes__carousel__item">

				<!-- Image -->
				<img src="assets/img/31.jpg" alt="..." class="section_dishes__carousel__item__img">

				<!-- Body -->
				<div class="section_dishes__carousel__item__body">
					<h5 class="section_dishes__carousel__item__body__heading mb-0">
						Lorem ipsum dolor sit amet <span>₱27</span>
					</h5>
				</div>

			</div>
		</div> <!-- / .section_dishes__carousel -->

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
            } else if (category === 'drinks') {
                document.getElementById('hot-drinks-section').style.display = 'block';
                document.getElementById('cold-drinks-section').style.display = 'block';
            } else if (category === 'hot') {
                document.getElementById('hot-drinks-section').style.display = 'block';
            } else if (category === 'cold') {
                document.getElementById('cold-drinks-section').style.display = 'block';
            } else if (category === 'pastries') {
                document.getElementById('pastries-section').style.display = 'block';
            } else if (category === 'food') {
                document.getElementById('food-section').style.display = 'block';
            }
        }
    </script>

  </body>
</html>
