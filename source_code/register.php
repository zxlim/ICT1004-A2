<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/components/user/register.php");
define("WEBPAGE_TITLE", "Register");

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

    <!-- Login Section -->
    <section class="login_box_area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <img class="img-fluid" src="static/img/vendor/login.jpg" alt="">
                        <div class="hover">
                            <h4>New to our website?</h4>
                            <p>Join the <?php safe_echo(APP_TITLE); ?> community now!</p>
                            <a class="primary-btn" href="register.html">Create an Account</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Register An Account With Us!</h3>
                        <form class="row login_form" name="form-login" id="form-login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $name;?>">
                                <span class="errorcolor"><?php echo $nameErr;?></span>
                            </div>

                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="loginid" name="loginid" placeholder="Login ID" value="<?php echo $loginid;?>">
                                <span class="errorcolor"><?php echo $loginidErr;?></span>
                            </div>

                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
                                <span class="errorcolor"><?php echo $pwdErr;?></span>
                            </div>

                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" id="pwdcfm" name="pwdcfm" placeholder="Confirm Password">
                                <span class="errorcolor"><?php echo $pwdcfmErr;?></span>

                            </div>

                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email;?>">
                                <span class="errorcolor"><?php echo $emailErr;?></span>
                            </div>

                            <div class="col-md-12 form-group">
                                <!--<input type="text" class="form-control" id="gender" name="gender" placeholder="Gender">-->
                                <select name="gender" id="gender" required>
                                    <option disabled selected>Gender</option>
                                    <option value="Male" <?php if($gender == "Male"){?> selected="selected" <?php }?>>Male</option>
                                    <option value="Female" <?php if($gender == "Female"){?> selected="selected" <?php }?>>Female</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group" align="left">
                                <span class="errorcolor"><?php echo $genderError;?></span>
                            </div>

                            <div class="col-md-12 form-group">
                                <button type="submit" value="submit" class="primary-btn">Proceed</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Login Section -->

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