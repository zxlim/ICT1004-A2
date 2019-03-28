<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/components/listing/message.php");
define("WEBPAGE_TITLE", "Chat with Seller");
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
					<h1>Chat with Seller (TODO)</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">
							Home<span class="lnr lnr-arrow-right"></span>
						</a>
						<a href="listing.php?id=<?php safe_echo($item["cat_id"]); ?>">
							<?php safe_echo($item["cat_name"]); ?><span class="lnr lnr-arrow-right"></span>
						</a>
						<a href="item.php?id=<?php safe_echo($item["id"]); ?>">
							<?php safe_echo($item["title"]); ?>
						</a>
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

	<section class="section_gap">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="message-box bg-white shadow">
						<div class="message-content-box">
							<div class="message-content"></div>
						</div>
						<div class="message-input">
							<form>
								<input type="hidden" id="item_id" name="item_id" value="<?php safe_echo($item["id"]); ?>" required readonly>
								<div class="row">
									<div class="col-10">
										<input type="text" class="single-input" id="msg_data" name="msg_data" placeholder="Type your message here.">
									</div>
									<div class="col-2">
										<button type="submit" class="genric-btn success circle">Send</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>
	<script src="static/js/message.js"></script>
</body>
</html>