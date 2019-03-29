<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/components/user/verification.php");
define("WEBPAGE_TITLE", "Verification");
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<?php require_once("serverside/templates/html.head.php"); ?>

    <style>
        .errorcolor {
            color:red;
        }
    </style>
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
						<a href="register.php">Register<span class="lnr lnr-arrow-right"></span></a>
						<a href="">Email Verification</a>
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
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <img class="img-fluid" src="static/img/vendor/login.jpg" alt="">
                        <div class="hover">
                            <h4>New to our website?</h4>
                            <p>Join the <?php safe_echo(APP_TITLE); ?> community now!</p>
                            <a class="primary-btn" href="register.php">Create an Account</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h4>Enter your verification code here!</h4>
                        <form class="row login_form" name="form-login" id="form-login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="vericode" name="vericode" placeholder="Verification Code">
                                <span class="errorcolor"><?php echo $vericodeErr;?></span>
                            </div>

                            <div class="col-md-12 form-group">
                                <button type="submit" value="submit" class="primary-btn">Create Account</button>
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
</body>
</html>