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
			<div class="message-box bg-white shadow">
				<div class="row message-details">
					<div class="col-md-1 col-2"></div>
					<div class="col-md-9 col-10">
						<h4 class="vertical-align-middle">
							<?php safe_echo($item["title"]); ?>
						</h4>
					</div>
					<div class="col-2 d-md-none"></div>
					<div class="col-md-2 col-10">
						<h4 class="vertical-align-middle">
							S$<?php safe_echo($item["price"]); ?>
						</h4>
					</div>
				</div>
				<div class="row message-list p-2">
					<div class="col-12">
						<div class="message-content">
							<h3 class="text-center vertical-align-middle">No messages yet, start chatting.</h3>
						</div>
					</div>
				</div>
				<div class="row message-input">
					<div class="col-12">
						<form id="form-message" name="form-message">
							<input type="hidden" id="action" name="action" value="send" required readonly>
							<input type="hidden" id="convo_id" name="id" value="<?php safe_echo($convo_id); ?>" required readonly>
							<input type="hidden" id="sender_id" name="sender_id" value="<?php safe_echo($sender_id); ?>" required readonly>
							<div class="row">
								<!-- Message Input -->
								<div class="col-1"></div>
								<div class="col-md-7 col-10">
									<input type="text" class="single-input" id="msg_data" name="msg_data" placeholder="Type your message here" required>
								</div>
								<div class="col-1"></div>
								<!-- End of Message Input -->
								<!-- Send button -->
								<div class="col-1 top-margin d-md-none"></div>
								<div class="col-md-2 col-10 top-margin text-center">
									<button type="submit" class="genric-btn success circle btn-block">Send</button>
								</div>
								<div class="col-1 top-margin"></div>
								<!-- End of Send button -->
							</div>
						</form>
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