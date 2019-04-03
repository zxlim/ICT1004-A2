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
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="login_form_inner pb-5">
						<h3>Register An Account With Us!</h3>
						<form class="row login_form" name="form-register" id="form-register" action="register.php" method="post">

							<div class="col-12 form-group">
								<input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php if (isset($_POST["name"])) { safe_echo($_POST["name"]); } ?>">
								<?php if (isset($error_name)) { ?>
									<span class="text-danger"><?php safe_echo($error_name); ?></span>
								<?php } ?>
							</div>

							<div class="col-12 form-group">
								<input type="text" class="form-control" id="loginid" name="loginid" placeholder="Login ID" value="<?php if (isset($_POST["loginid"])) { safe_echo($_POST["loginid"]); } ?>">
								<?php if (isset($error_loginid)) { ?>
									<span class="text-danger"><?php safe_echo($error_loginid); ?></span>
								<?php } ?>
							</div>

							<div class="col-12 form-group">
								<input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php if (isset($_POST["email"])) { safe_echo($_POST["email"]); } ?>">
								<?php if (isset($error_email)) { ?>
									<span class="text-danger"><?php safe_echo($error_email); ?></span>
								<?php } ?>
							</div>

							<div class="col-12 form-group">
								<input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
								<?php if (isset($error_password1)) { ?>
									<span class="text-danger"><?php safe_echo($error_password1); ?></span>
								<?php } ?>
							</div>

							<div class="col-12 form-group">
								<input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm Password">
								<span class="text-danger" id="error-password2">
									<?php if (isset($error_password2)) { safe_echo($error_password2); } ?>
								</span>
							</div>

							<div class="col-12 form-group auto-margin">
								<label>Gender</label>
								<select class="default-select wide" id="gender" name="gender" required>
									<option disabled>Gender</option>
									<option value="N"<?php if ($gender === "N") { ?> selected="selected"<?php }?>>
										Prefer not to say
									</option>
									<option value="M"<?php if ($gender === "M") { ?> selected="selected"<?php }?>>
										Male
									</option>
									<option value="F"<?php if ($gender === "F") { ?> selected="selected"<?php }?>>
										Female
									</option>
									<option value="O"<?php if ($gender === "O") { ?> selected="selected"<?php }?>>
										Others
									</option>
								</select>
							</div>
							<div class="col-12 form-group">
								<?php if (isset($error_gender)) { ?>
									<span class="text-danger"><?php safe_echo($error_gender); ?></span>
								<?php } ?>
							</div>

							<div class="col-12 form-group">
								<button type="submit" value="submit" class="primary-btn">Register</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Registration Section -->

	<!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>

	<?php if (validate_notempty($error_message) === TRUE) { ?>
	<script>
		$(document).ready(function() {
			notify("<?php safe_echo($error_message); ?>", "danger");
		});
	</script>
	<?php } ?>
</body>
</html>