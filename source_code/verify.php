<?php define("CLIENT", TRUE);
define("REGISTER_ENDPOINT", TRUE);
require_once("serverside/base.php");
require_once("serverside/components/user/verify.php");
define("WEBPAGE_TITLE", "Verify Email");
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
					<h1>Email Verification</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a class="no-click" href="">Register<span class="lnr lnr-arrow-right"></span></a>
						<a class="no-click" href="">Email Verification</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section -->

	<!-- Verification Section -->
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="login_form_inner">
						<h3>Verify your email address</h3>
						<p>
							We have sent a verification code to your email address (<strong><?php safe_echo($email); ?></strong>).
							<br /><br />
							Please check your email and enter the verification code below.
							<br />
							The code will expire after 15 minutes.
						</p>
						<form class="row login_form" name="form-verification" id="form-verification" action="verify.php" method="post">
							<div class="col-12 input-group-icon">
								<div class="icon"><i class="fas fa-terminal" aria-hidden="true"></i></div>
								<input type="text" class="single-input" id="code" name="code" placeholder="Verification Code" autofocus>
							</div>
							<br /><br />
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="primary-btn">Verify &amp; Create Account</button>
							</div>
						</form>
					</div>
					<!-- Artificial Padding -->
					<br /><br /><br />
					<!-- End of Artificial Padding -->
				</div>
			</div>
		</div>
	</section>
	<!-- End Verification Section -->

	<!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>

	<?php if ($error_validate === TRUE) { ?>
	<script>
		$(document).ready(function() {
			notify("<?php safe_echo($error_message); ?>", "danger");
		});
	</script>
	<?php } ?>
</body>
</html>