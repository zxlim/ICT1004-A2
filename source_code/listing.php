<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/components/listing/listing.php");
define("WEBPAGE_TITLE", "Listings");
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
					<?php if (isset($selected_cat_name) === TRUE) { ?>
					<h1><?php safe_echo($selected_cat_name); ?></h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="">Listings<span class="lnr lnr-arrow-right"></span></a>
						<a href=""><?php safe_echo($selected_cat_name); ?></a>
					</nav>
					<?php } else { ?>
					<h1>Category Not Found</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="listing.php?id=1">Listings</a>
					</nav>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section -->

	<!-- Listing Section -->
	<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
					<div class="head bg-dark">
						Browse Categories
					</div>
					<ul class="main-categories">
						<?php foreach ($results_categories as $row) { ?>
						<li class="main-nav-list">
							<a href="listing.php?id=<?php safe_echo($row["id"]); ?>">
								<?php safe_echo($row["name"]); ?>
							</a>
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<div class="col-xl-9 col-lg-8 col-md-7">
				<!-- Start Filter Bar -->
				<div class="filter-bar d-flex flex-wrap align-items-center bg-dark">
					<div class="listing-result-count">
						Showing <?php safe_echo(sizeof($results_listings)); ?> result(s)
					</div>
				</div>
				<!-- End Filter Bar -->
				<!-- Start Item Listings -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
						<?php if (sizeof($results_listings) === 0) { ?>
							<div class="col-12">
								<?php if (isset($selected_cat_name) === TRUE) { ?>
								<h3 class="p-4">Sorry, there are no items in this category.</h3>
								<?php } else { ?>
								<h3 class="p-4">We cannot find the category requested.</h3>
								<?php } ?>
							</div>
						<?php
						} else {
							foreach ($results_listings as $row) {
						?>
						<div class="col-lg-4 col-md-6">
							<div class="single-product">
								<figure class="img-equalise">
									<img src="<?php safe_echo($row["picture"]); ?>">
								</figure>
								<div class="product-details">
									<h6>
										<?php safe_echo($row["title"]); ?>
									</h6>
									<div class="price">
										<h6>S$<?php safe_echo($row["price"]); ?></h6>
									</div>
									<div class="prd-bottom">
										<a href="item.php?id=<?php safe_echo($row["id"]); ?>" class="social-info">
											<span class="lnr lnr-move"></span>
											<p class="hover-text">view</p>
										</a>
										<a href="#" class="social-info">
											<span class="ti-bag"></span>
											<p class="hover-text">make offer</p>
										</a>
									</div>
								</div>
							</div>
						</div>
						<?php }} ?>
					</div>
				</section>
				<!-- End Item Listings -->
			</div>
		</div>
	</div>
	<!-- End Listing Section -->

	<!-- Artificial Spacing -->
	<br /><br /><br />

	<!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>
</body>
</html>