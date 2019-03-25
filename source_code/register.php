<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/components/user/register.php");
define("WEBPAGE_TITLE", "Register");
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
					<h1>Register</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="register.php">Register</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section -->

	<!-- Registration Section -->
	<section class="section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<!-- TODO: Not provided by template. -->
				</div>
			</div>
		</div>
	</section>
	<!-- End Registration Section -->

	<!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>
</body>
</html>