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
					<?php if (isset($item) === TRUE) { ?>
					<h1>Item Details</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="listing.php?id=<?php safe_echo($item["cat_id"]); ?>">Listings<span class="lnr lnr-arrow-right"></span></a>
						<a href="listing.php?id=<?php safe_echo($item["cat_id"]); ?>"><?php safe_echo($item["cat_name"]); ?><span class="lnr lnr-arrow-right"></span></a>
						<a href=""><?php safe_echo($item["title"]); ?></a>
					</nav>
					<?php } else { ?>
					<h1>Item Not Found</h1>
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

	<?php if (isset($item) === TRUE) { ?>
	<!-- Item Section -->
	<div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="s_Product_carousel">
						<?php foreach ($item["picture"] as $pic) { ?>
						<div class="single-prd-item">
							<img src="<?php safe_echo($pic); ?>">
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3>
							<?php safe_echo($item["title"]); ?>
						</h3>
						<h2>
							S$<?php safe_echo($item["price"]); ?>
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
							<a class="success-btn" href="#">Make an Offer</a>
							<a class="info-btn" href="#">Chat with Seller</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Item Section -->

	<!-- Misc Section -->
	<section class="product_description_area">
		<div class="container">
			<ul class="nav nav-tabs" id="item-tabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">
						About Seller
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="related-tab" data-toggle="tab" href="#related" role="tab" aria-controls="related" aria-selected="false">
						Related Listings
					</a>
				</li>
			</ul>
			<div class="tab-content" id="item-tabs-content">
				<div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<div class="row">
						<div class="col-lg-6">
							<div class="comment_list">
								<div class="review_item">
									<h3>About Me</h3>
									<div class="media">
										<div class="d-flex">
											<img class="img-listing-user-dp" src="<?php safe_echo($item["user_pic"]); ?>">
										</div>
										<div class="media-body">
											<h4>
												<?php safe_echo($item["user_name"]); ?>
											</h4>
											<h5>
												Joined <?php safe_echo($item["user_join_date"]); ?>
											</h5>
											<a class="reply_btn" href="profile.php?id=<?php safe_echo($item["user_id"]); ?>">
												See Profile
											</a>
										</div>
									</div>
									<p>
										<?php
										if (isset($item["user_bio"]) === TRUE) {
											safe_echo($item["user_bio"]);
										} else {
											safe_echo("This user prefers to keep their life a mystery...");
										}
										?>
									</p>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="review_box">
								<h3>My Other Listings</h3>
								<?php
								if (isset($related_seller_items) === TRUE && empty($related_seller_items) === FALSE) {
									foreach ($related_items as $row) {
								?>
								<div class="col-lg-4 col-md-6 col-sm-6 mb-20">
									<div class="single-related-product d-flex">
										<a href="item.php?id=<?php safe_echo($row["id"]); ?>">
											<img class="img-related-item" src="<?php safe_echo($row["picture"]); ?>">
										</a>
										<div class="desc">
											<a href="item.php?id=<?php safe_echo($row["id"]); ?>" class="title">
												<?php safe_echo($row["title"]); ?>
											</a>
											<div class="price">
												<h6>S$<?php safe_echo($row["price"]); ?></h6>
											</div>
										</div>
									</div>
								</div>
								<?php
									}
								} else {
								?>
								<h5>
									No Suggestions to Show
								</h5>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="related" role="tabpanel" aria-labelledby="related-tab">
					<h3 class="text-center">Similar Listings</h3>
					<br />
					<div class="row align-items-center">
						<?php if (isset($related_items) === TRUE && empty($related_items) === FALSE) { ?>
						<?php foreach ($related_items as $row) { ?>
						<div class="col-lg-4 col-md-4 col-sm-6 mb-20">
							<div class="single-related-product d-flex">
								<a href="item.php?id=<?php safe_echo($row["id"]); ?>">
									<img class="img-related-item" src="<?php safe_echo($row["picture"]); ?>">
								</a>
								<div class="desc">
									<a href="item.php?id=<?php safe_echo($row["id"]); ?>" class="title">
										<?php safe_echo($row["title"]); ?>
									</a>
									<div class="price">
										<h6>S$<?php safe_echo($row["price"]); ?></h6>
									</div>
								</div>
							</div>
						</div>
						<?php }
						} else {
						?>
						<div class="col-12">
							<h5 class="text-center">
								No Suggestions to Show
							</h5>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Misc Section-->
	<?php } ?>

	<!-- Artificial Spacing -->
	<br /><br /><br />

	<!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>
</body>
</html>