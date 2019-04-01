<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/components/home.php");
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<?php require_once("serverside/templates/html.head.php"); ?>
</head>
<body>
	<!-- Header -->
	<?php require_once("serverside/templates/header.php"); ?>
	<!-- End Header -->

	<!-- Homepage Banner -->
	<section class="banner-area">
		<div class="container">
			<div class="row fullscreen align-items-center justify-content-start">
				<div class="col-lg-12">
					<div class="active-banner-slider owl-carousel">
						<!-- Slider -->
						<div class="row single-slide align-items-center d-flex">
							<div class="col-lg-5 col-md-6">
								<div class="banner-content">
                                    <br /><br />
                                    <?php if ($session_is_authenticated === TRUE) { ?>
                                        <h2> Welcome, <?php safe_echo($_SESSION["user_name"]); ?>!<h2>
                                    <?php } ?>
                                    <br />
									<h1>
										Black Friday
										<br />
										Sale!
									</h1>
									<p>
										Lowest prices guaranteed! Find pre-loved items that suit your budget right on FastTrade.
									</p>
									<div class="add-bag d-flex align-items-center">
										<a class="add-btn" href="listing.php?id=1"><span class="lnr lnr-cart"></span></a>
										<span class="add-text text-uppercase">Shop Now</span>
									</div>
								</div>
							</div>
							<div class="col-lg-7">
								<div class="banner-img">
									<img class="img-fluid" src="static/img/black-friday.png" alt="">
								</div>
							</div>
						</div>
						<!-- End Slider -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Homepage Banner -->

	<!-- Features Section -->
	<section class="features-area section_gap">
		<div class="container">
            <h2>Explore <?php safe_echo(APP_TITLE); ?></h2>
            <hr>
			<div class="row features-inner">
				<div class="col-lg-3 col-md-6 col-sm-6">
					<a href="listing.php?cat=1">
						<div class="single-features">
							<div class="f-icon">
	                            <img src="https://img.icons8.com/ios/50/000000/home-automation.png">
							</div>
							<h6>Home Appliances</h6>
						</div>
					</a>
				</div>
				
				<div class="col-lg-3 col-md-6 col-sm-6">
					<a href="listing.php?cat=2">
						<div class="single-features">
							<div class="f-icon">
	                            <img src="https://img.icons8.com/ios/50/000000/sofa.png">
							</div>
							<h6>Furnitures</h6>
						</div>
					</a>
				</div>
				
				<div class="col-lg-3 col-md-6 col-sm-6">
					<a href="listing.php?cat=3">
						<div class="single-features">
							<div class="f-icon">
	                            <img src="https://img.icons8.com/ios/50/000000/processor.png">
							</div>
							<h6>Computers and IT</h6>
						</div>
					</a>
				</div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                	<a href="listing.php?cat=5">
	                    <div class="single-features">
	                        <div class="f-icon">
	                            <img src="https://img.icons8.com/ios/50/000000/nailer.png">
	                        </div>
	                        <h6>Home Repairs and Services</h6>
	                    </div>
	                </a>
                </div>

			</div>
		</div>
	</section>
	<!-- End Features Section -->

	<!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>
</body>
</html>