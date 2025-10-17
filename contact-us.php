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

	<title>Contact Us</title>
	<!-- JS Global -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- JS Plugins -->
	<script src="assets/plugins/parallax/parallax.min.js"></script>
	<script src="assets/plugins/isotope/lib/imagesloaded.pkgd.min.js"></script>
	<script src="assets/plugins/isotope/isotope.pkgd.min.js"></script>
	<script src="assets/plugins/flickity/flickity.pkgd.min.js"></script>
	<script src="assets/plugins/lightbox/js/lightbox.min.js"></script>

	<!-- CSS Plugins -->
	<link rel="stylesheet" href="assets/plugins/font-awesome/css/all.min.css">
	<link rel="stylesheet" href="assets/plugins/lightbox/css/lightbox.min.css">
	<link rel="stylesheet" href="assets/plugins/flickity/flickity.min.css">

	<!-- CSS Global -->
	<link rel="stylesheet" href="assets/css/theme.min.css">

	<style>
		.section__subheading {
			font-size: 1.05rem;
			color: #555;
			margin-top: 15px;
			text-align: center;
		}
		.contact-map {
			border-radius: 12px;
			overflow: hidden;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
			width: 100%;
			height: 500px;
		}
		@media (max-width: 768px) {
			.contact-map {
				height: 350px;
			}
		}
	</style>
  </head>

  <body>
  <?php require_once 'nav.php' ?> 

	<!-- HEADER -->
	<section class="section section_header" data-parallax="scroll" data-image-src="assets/img/37.jpg">
		<div class="container">
			<div class="row">
				<div class="col">
					<h1 class="section__heading section_header__heading text-center">
						Contact Us
					</h1>
				</div>
			</div> 
		</div> 
	</section>

	<!-- CONTACT -->
	<section class="section section_contact">
		<div class="container">


			<div class="row">
				<div class="col-md-3 order-md-2">
					<!-- Contact info -->
					<div class="section_contact__info">
						<div class="section_contact__info__item">
							<h4 class="section_contact__info__item__heading">Write us</h4>
							<p class="section_contact__info__item__content">
								<a href="mailto:sohocafe@gmail.com">sohocafe@gmail.com</a>
							</p>
						</div>
						<div class="section_contact__info__item">
							<h4 class="section_contact__info__item__heading">Call us</h4>
							<p class="section_contact__info__item__content"><a href="#">09910229687</a></p>
						</div>
						<div class="section_contact__info__item">
							<h4 class="section_contact__info__item__heading">Visit us</h4>
							<p class="section_contact__info__item__content">
								Sōho Cafe + Kitchen Biñan Branch Petron Timbao
							</p>
						</div>
						<div class="section_contact__info__item">
							<h4 class="section_contact__info__item__heading">Social links</h4>
							<ul class="section_contact__info__item__content">
								<li><a href="#"><i class="fab fa-twitter"></i></a></li>
								<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
								<li><a href="#"><i class="fab fa-instagram"></i></a></li>
							</ul>
						</div>
					</div>
				</div>

				<div class="col-md-9 order-md-1">
					<!-- Google Map Embed -->
					<div class="contact-map">
						<iframe
							src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3871.006066081345!2d121.0526821!3d14.2856633!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d7006fb4f881%3A0x263352f212136bdc!2sSOHO%20Caf%C3%A9%20%2B%20Kitchen!5e0!3m2!1sen!2sph!4v1729075200000!5m2!1sen!2sph"
							width="100%"
							height="100%"
							style="border:0;"
							allowfullscreen=""
							loading="lazy"
							referrerpolicy="no-referrer-when-downgrade">
						</iframe>
					</div>
				</div>
			</div> <!-- / .row -->
		</div>
	</section>

	<!-- FOOTER -->
	<footer class="section section_footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-4">
					<h5 class="section_footer__heading">About Us</h5>
					<p>We have been brewing our own coffee and serving for 3 years now, and popular for our great coffee and lively atmosphere.</p>
				</div>
				<div class="col-sm-4">
					<h5 class="section_footer__heading">Contact info</h5>
					<ul class="section_footer__info">
						<li><i class="fas fa-map-marker-alt"></i> Sōho Cafe + Kitchen Biñan Branch Petron Timbao</li>
						<li><i class="fas fa-phone"></i> 09100229687</li>
						<li><i class="far fa-envelope"></i> <a href="mailto:sohocafe&kitchen@gmail.com">sohocafe&kitchen@gmail.com</a></li>
					</ul>
				</div>
				<div class="col-sm-4">
					<h5 class="section_footer__heading">Opening hours</h5>
					<div class="section_footer__open">
						<div class="section_footer__open__days">Monday - Thursday</div>
						<div class="section_footer__open__time">3:00 PM - 11:00 PM</div>
					</div>
					<div class="section_footer__open">
						<div class="section_footer__open__days">Friday - Sunday</div>
						<div class="section_footer__open__time">3:00 PM - 12:00 AM</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="section_footer__copyright">
						&copy; <span id="js-current-year"></span> SOHO Cafe & Kitchen. All rights reserved.
					</div>
				</div>
			</div>
		</div>
	</footer>
  </body>
</html>
