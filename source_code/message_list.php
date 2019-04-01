<?php define("CLIENT", TRUE);
define("REQUIRE_AUTH", TRUE);
require_once("serverside/base.php");
define("WEBPAGE_TITLE", "My Chats");
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
					<h1>My Chats</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="">My Chats</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section -->

	<section class="cart_area">
		<div class="container">
			<div class="cart_inner">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th scope="col" width="20%">Listing</th>
								<th scope="col" width="60%">Chat</th>
								<th scope="col" width="20%">Date</th>
							</tr>
						</thead>
						<tbody id="ftmsg-all-list">
							<tr class="no-pointer-event">
								<td></td>
								<td>
									<h3 class="text-center">No messages yet.</h3>
								</td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>

	<script>
		$(document).ready(function() {
			const FTList = new FastTradeMessengerList();
			FTList.fetch();
		});
	</script>
</body>
</html>