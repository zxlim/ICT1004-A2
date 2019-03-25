<?php define("CLIENT", TRUE);

require_once("serverside/base.php");
require_once("serverside/components/listing/item.php");

define("WEBPAGE_TITLE", "Item Details");
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

	<!-- Banner Section -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<?php if (isset($item) === FALSE) { ?>
					<h1>Item Not Found</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="listing.php?id=1">Listings</a>
					</nav>
					<?php } else { ?>
					<h1>Item Details</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="listing.php?id=<?php safe_echo($item["cat_id"]); ?>">Listings<span class="lnr lnr-arrow-right"></span></a>
						<a href="listing.php?id=<?php safe_echo($item["cat_id"]); ?>"><?php safe_echo($item["cat_name"]); ?><span class="lnr lnr-arrow-right"></span></a>
						<a href=""><?php safe_echo($item["title"]); ?></a>
					</nav>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section -->

	<!-- Listing Section -->
	<?php if (isset($item) === TRUE) { ?>
	<div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="s_Product_carousel">
						<div class="single-prd-item">
							<img class="img-fluid" src="static/img/vendor/category/s-p1.jpg" alt="">
						</div>
						<div class="single-prd-item">
							<img class="img-fluid" src="static/img/vendor/category/s-p1.jpg" alt="">
						</div>
						<div class="single-prd-item">
							<img class="img-fluid" src="static/img/vendor/category/s-p1.jpg" alt="">
						</div>
					</div>
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3>
							<?php safe_echo($item["title"]); ?>
						</h3>
						<h2>
							$<?php safe_echo($item["price"]); ?>
						</h2>
						<ul class="list">
							<hr class="dotted" />
							<li>
								<a class="active no-click" href="profile.php?id=<?php safe_echo($item["user_id"]); ?>">
									<span><i class="fas fa-user"></i></span>
									<?php safe_echo($item["user_name"]); ?>
								</a>
							</li>
							<hr class="dotted" />
							<li>
								<a class="active no-click">
									<span><span><i class="fas fa-award"></i></span></span>
									<?php safe_echo($item["condition"]); ?>/10&nbsp;
									<?php
									if ($item["condition"] < 5) {
										safe_echo("(Bad)");
									} else if ($item["condition"] >= 5 && $item["condition"] < 8) {
										safe_echo("(Good)");
									} else if ($item["condition"] !== 10) {
										safe_echo("(Very Good)");
									} else {
										safe_echo("(Brand New)");
									}
									?>
								</a>
							</li>
							<li>
								<a class="active no-click">
									<span><span><i class="fas fa-history"></i></span></span>
									<?php safe_echo($item["item_age"]); ?> month(s)
								</a>
							</li>
							<li>
								<a class="active no-click">
									<span><i class="fas fa-map-marked-alt"></i></span>
									<?php safe_echo($item["meetup_location"]); ?>
								</a>
							</li>
							<hr class="dotted" />
							<li>
								<a class="active" href="listing.php?id=<?php safe_echo($item["cat_id"]); ?>">
									<span><i class="fas fa-list"></i></span>
									<?php safe_echo($item["cat_name"]); ?>
								</a>
							</li>
							<li>
								<a class="active no-click">
									<span><span><i class="fas fa-tags"></i></span></span>
									<?php safe_echo($item["tags"]); ?>
								</a>
							</li>
						</ul>
						<p>
							<?php safe_echo($item["description"]); ?>
						</p>
						<div class="card_area d-flex align-items-center">
							<a class="primary-btn" href="#">Make an Offer</a>
							<a class="primary-btn" href="#">Chat with Seller</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<!-- End Listing Section -->

	<!-- Artificial Spacing -->
	<br /><br /><br />

	<!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>
</body>
</html>