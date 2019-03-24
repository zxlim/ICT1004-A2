<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/components/user/reset.php");
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
					<h1>Reset Password</h1>
					<nav class="d-flex align-items-center">
						<a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="login.html">Login<span class="lnr lnr-arrow-right"></span></a>
						<a href="reset.html">Reset Password</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section -->

	<!-- Reset Section -->
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="login_box_img">
						<img class="img-fluid" src="static/img/vendor/login.jpg" alt="">
						<div class="hover">
							<h4>Forgotten your password?</h4>
							<p>Please provide the required information in order to initiate a password reset.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>User Information</h3>
						<form class="row login_form" name="form-login" id="form-login">
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="loginid" name="loginid" placeholder="Login ID">
							</div>

							<div class="col-md-12 form-group">
								<input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
							</div>

							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="primary-btn">Reset Password</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Reset Section -->

	<!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>
</body>
</html>