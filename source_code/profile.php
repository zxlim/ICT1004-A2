<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/components/user/profile.php");
define("WEBPAGE_TITLE", "Profile");
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
					<h1>Profile</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="">Seller Profile</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section -->

	<section class="features-area">
		<div class="container">
			<div class="row s_product_inner">
				<?php if ($profile === NULL) { ?>
				<h2>Profile not found.</h2>
				<br /><br /><br />
				<?php } else { ?>
				<input type="hidden" id="profile_id" name="profile_id" value="<?php safe_echo($profile["id"]); ?>" required readonly>
				<div class="col-lg-4">
					<div class="s_product_text">
						<h2><?php safe_echo($profile["name"]); ?></h2>
						<hr />
						<figure>
							<img class="rounded-circle" src="<?php safe_echo($profile["profile_pic"]); ?>" alt="User Profile Image" height="200" width="200">
						</figure>
					</div>
				</div>
				<div class="col-lg-7 offset-lg-1">
					<div class="s_product_text">
						<div class="row">
							<div class="col-8">
								<h4>Email</h4>
								<p class="word_break">
									<?php if ($session_is_authenticated === FALSE) { ?>
										Login to see seller's email.
									<?php
									} else {
										safe_echo($profile["email"]);
									}
									?>
								</p>
							</div>
							<div class="col-4">
								<h4>Gender</h4>
								<p class="word_break">
									<?php safe_echo($profile["gender"]); ?>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-4">
								<h4>Join Date</h4>
								<p class="word_break">
									<?php safe_echo($profile["join_date"]); ?>
								</p>
							</div>
							<div class="col-8">
								<h4>Bio</h4>
								<p class="word_break">
									<?php safe_echo($profile["bio"]); ?>
								</p>
							</div>
						</div>
						<?php if ($session_user_id === $profile_id) { ?>
						<div class="row pt-3">
							<div class="col-12 form-group card_area align-items-center text-center">
								<a class="info-btn" href="edit_profile.php">
									Edit Profile
								</a>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</section>

	<!-- Misc Section -->
	<?php if ($profile !== NULL) { ?>
	<section class="product_description_area section_gap">
		<div class="container">
			<ul class="nav nav-tabs" id="item-tabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="listing-tab" data-toggle="tab" href="#listing" role="tab" aria-controls="listing" aria-selected="true">
						All Listings
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">
						Reviews
					</a>
				</li>
			</ul>
			<div class="tab-content" id="item-tabs-content">
				<div class="tab-pane fade show active" id="listing" role="tabpanel" aria-labelledby="listing-tab">
					<h3 class="text-center">All Listings</h3>
					<br/>
					<div class="progress-table-wrap">
						<div class="progress-table user bg-white">
							<div class="table-row"></div>
							<div class="table-head">
								<div class="col-md-3 name text-center">
									Image
								</div>
								<div class="col-md-3 name text-center">
									Product Name
								</div>
								<div class="col-md-2 name text-center">
									Price
								</div>
								<div class="col-md-2 actions text-center">
									Status
								</div>
								<div class="col-md-2 actions text-center">
									<!-- Actions -->
								</div>
							</div>
							<?php
							foreach ($user_listings as $row) {
								if ($row["sold"] === TRUE || $row["expiry"] < $current_dt) {
									if ($session_user_id === $profile_id) {
							?>
							<div class="table-row bg-light">
								<div class="col-md-3">
									<figure class="img-equalise">
										<img src="<?php safe_echo($row["url"]) ?>" class="img-thumbnail user-listing">
									</figure>
								</div>
								<div class="col-md-3 name text-center word_break">
									<?php safe_echo($row["title"]); ?>
								</div>
								<div class="col-md-2 name text-center word_break">
									$<?php safe_echo($row["price"]); ?>
								</div>
								<div class="col-md-2 name text-center">
									<?php if ($row["sold"] === TRUE) { ?>
									Sold
									<?php } else { ?>
									Expired
									<?php } ?>
								</div>
								<div class="col-md-2 name text-center">
									<form class="delete" action="profile.php" method="post">
										<input type="hidden" name="action" value="delete_listing" required readonly>
										<input type="hidden" name="id" value="<?php safe_echo($row["id"]); ?>" required readonly>
										<button type="submit" class="genric-btn danger small">
											Delete
										</button>
									</form>
								</div>
							</div>
							<?php
									} // if.
								} else {
							?>
							<div class="table-row">
								<div class="col-md-3">
									<figure class="img-equalise">
										<img src="<?php safe_echo($row["url"]) ?>" class="img-thumbnail user-listing">
									</figure>
								</div>
								<div class="col-md-3 name text-center">
									<?php safe_echo($row["title"]); ?>
								</div>
								<div class="col-md-2 name text-center">
									$<?php safe_echo($row["price"]); ?>
								</div>
								<div class="col-md-2 name text-center">
									Available
								</div>
								<div class="col-md-2 name text-center">
									<a class="genric-btn small info" href="item.php?id=<?php safe_echo($row["id"]); ?>">View</a>
								</div>
							</div>
							<?php
								} // if-else.
							} // foreach.
							?>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
					<h3 class="text-center">Seller Reviews</h3>
					<br/>
					<div class="row">
						<div class="col-lg-6">
							<div class="row total_rate">
								<div class="col-6">
									<div class="box_total">
										<h5>Overall</h5>
										<h4><?php safe_echo($review_overall); ?></h4>
									</div>
								</div>
								<div class="col-6">
									<div class="rating_list">
										<h3>Based on <?php safe_echo(count($user_reviews_ratings)); ?> Review(s).</h3>
										<ul class="list">
											<li>
												5 Star
												<label class="fa fa-star fa-star-f"></label>
												<label class="fa fa-star fa-star-f"></label>
												<label class="fa fa-star fa-star-f"></label>
												<label class="fa fa-star fa-star-f"></label>
												<label class="fa fa-star fa-star-f"></label>
												<?php safe_echo(isset($review_counts["5"]) ? $review_counts["5"] : "0"); ?>
											</li>

											<li>
												4 Star
												<label class="fa fa-star fa-star-f"></label>
												<label class="fa fa-star fa-star-f"></label>
												<label class="fa fa-star fa-star-f"></label>
												<label class="fa fa-star fa-star-f"></label>
												<label class="fa fa-star fa-star-b"></label>
												<?php safe_echo(isset($review_counts["4"]) ? $review_counts["4"] : "0"); ?>
											</li>

											<li>
												3 Star
												<label class="fa fa-star fa-star-f"></label>
												<label class="fa fa-star fa-star-f"></label>
												<label class="fa fa-star fa-star-f"></label>
												<label class="fa fa-star fa-star-b"></label>
												<label class="fa fa-star fa-star-b"></label>
												<?php safe_echo(isset($review_counts["3"]) ? $review_counts["3"] : "0"); ?>
											</li>

											<li>
												2 Star
												<label class="fa fa-star fa-star-f"></label>
												<label class="fa fa-star fa-star-f"></label>
												<label class="fa fa-star fa-star-b"></label>
												<label class="fa fa-star fa-star-b"></label>
												<label class="fa fa-star fa-star-b"></label>
												<?php safe_echo(isset($review_counts["2"]) ? $review_counts["2"] : "0"); ?>
											</li>

											<li>
												1 Star
												<label class="fa fa-star fa-star-f"></label>
												<label class="fa fa-star fa-star-b"></label>
												<label class="fa fa-star fa-star-b"></label>
												<label class="fa fa-star fa-star-b"></label>
												<label class="fa fa-star fa-star-b"></label>
												<?php safe_echo(isset($review_counts["1"]) ? $review_counts["1"] : "0"); ?>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="review_list">
								<?php foreach ($user_reviews as $row) { ?>
								<div class="review_item">
									<div class="media">
										<div class="d-flex">
											<a href="profile.php?id=<?php safe_echo($row["buyer_id"]); ?>">
												<img class="rounded-circle review-profile-pic" src="<?php safe_echo($row["buyer_profile_pic"]); ?>" alt="User Profile Image">
											</a>
										</div>
										<div class="media-body">
											<h4><?php safe_echo($row["buyer_name"]); ?></h4>
											<?php
											for ($i = 0; $i < $row["rating"]; $i++) {
												echo("<label class='fa fa-star fa-star-f'>");
											}
											for ($i = 0; $i < (5 - $row["rating"]); $i++) {
												echo("<label class='fa fa-star fa-star-b'>");
											}
											?>
										</div>
									</div>
									<p>
										<?php safe_echo($row["description"]); ?>
									</p>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="review_box">
								<h4>Add a Review</h4>
								<hr />
								<?php if ($session_is_authenticated === FALSE) { ?>
								<br />
								<div class="row">
									<div class="col-12 text-center">
										Log in to submit a review for this seller.
									</div>
								</div>
								<div class="row mt-3">
									<div class="col-12 text-center">
										<a class="primary-btn" href="login.php">Login</a>
									</div>
								</div>
								<?php } else if ($session_user_id === $profile_id) { ?>
								<br />
								<div class="row">
									<div class="col-12 text-center">
										Sorry, you cannot review yourself!
									</div>
								</div>
								<?php } else { ?>
								<form class="contact_form" id="form-review">
									<input type="hidden" name="action" value="add_reviews" required readonly>

									<div class="row">
										<div class="col-12">
											<h6>Your Rating:</h6>
											<fieldset class="rating">
												<input type="radio" id="star5" name="rating" value="5" checked>
												<label class="full" for="star5" title="Outstanding - 5 stars"></label>

												<input type="radio" id="star4half" name="rating" value="4.5">
												<label class="half" for="star4half" title="Outstanding - 4.5 stars"></label>

												<input type="radio" id="star4" name="rating" value="4">
												<label class="full" for="star4" title="Good - 4 stars"></label>

												<input type="radio" id="star3half" name="rating" value="3.5">
												<label class="half" for="star3half" title="Good - 3.5 stars"></label>

												<input type="radio" id="star3" name="rating" value="3">
												<label class="full" for="star3" title="Decent - 3 stars"></label>

												<input type="radio" id="star2half" name="rating" value="2.5">
												<label class="half" for="star2half" title="Decent - 2.5 stars"></label>

												<input type="radio" id="star2" name="rating" value="2">
												<label class="full" for="star2" title="Fair - 2 stars"></label>

												<input type="radio" id="star1half" name="rating" value="1.5">
												<label class="half" for="star1half" title="Fair - 1.5 stars"></label>

												<input type="radio" id="star1" name="rating" value="1">
												<label class="full" for="star1" title="Poor - 1 star"></label>

												<input type="radio" id="starhalf" name="rating" value="0.5">
												<label class="half" for="starhalf" title="Poor - 0.5 stars"></label>
											</fieldset>
										</div>
									</div>

									<div class="row pt-3">
										<div class="col-12 form-group">
											<h6>Review:</h6>
											<textarea class="form-control" name="description" id="description" rows="2" placeholder="Review description"></textarea>
										</div>
									</div>
									<div class="row pt-3">
										<div class="col-12 text-center">
											<button type="submit" value="submit" class="primary-btn">Submit Review</button>
										</div>
									</div>
								</form>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php } ?>
	<!-- End Misc Section-->

	<!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>

	<script>
		$(document).ready(function () {
			$(".delete").on("submit", function(e) {
				const result = confirm("Are you sure you want to delete this listing?");
				if (result === true) {
					return true;
				} else {
					e.preventDefault();
					return false;
				}
			});

			<?php if (isset($response_msg) === TRUE) { ?>
			const resp = "<?php safe_echo($response_msg); ?>";
			<?php if ($valid_response === TRUE) { ?>
			notify(resp, "info");
			<?php } else { ?>
			notify(resp, "danger");
			<?php }} ?>

			$("#form-review").on("submit", function(e) {
				e.preventDefault();
				const profile_id = $("#profile_id").val();
				const form_data = $("#form-review").serialize();

				if (validate_form_notempty(form_data) === false) {
					notify("Please fill in all required fields.", "warning");
					e.preventDefault();
					return false;
				} else {
					$.ajax({
						type: "post",
						url: "profile.php?id=" + profile_id,
						data: form_data,
						dataType: "json",
						success: function (response) {
							notify(response.msg, "success");

							setTimeout(function() {
								// Refresh the page after a delay.
								window.location.reload(true);
							}, 1500);
						},
						error: function (response) {
							notify(response.responseJSON.msg, "error");
						}
					});
				}
			});
		});
	</script>
</body>
</html>
