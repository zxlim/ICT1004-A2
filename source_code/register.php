<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/components/user/register.php");
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

<?php
$currentPage = 'register';

// define variables and set to empty values
$gender = $loginid = $name = $email = $pwd = $pwdcfm = "";
$genderError = $loginidErr = $nameErr = $emailErr = $pwdErr = $pwdcfmErr = $chbxErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    if (empty($_POST["firstname"])) {
//        $firstnameErr = "Please enter your first name";
//    } else {
//        $firstname = test_input($_POST["firstname"]);
//    }
//    if (empty($_POST["lastname"])) {
//        $lastnameErr = "Please enter your last name";
//    } else {
//        $lastname = test_input($_POST["lastname"]);
//    }
    if (empty($_POST["name"])) {
        $nameErr = "Please enter your name";
    } else {
        $name = test_input($_POST["name"]);
    }
    if (empty($_POST["loginid"])) {
        $loginidErr = "Please enter a Login ID";
    } else {
        $loginid = test_input($_POST["loginid"]);
    }
    if (empty($_POST["email"])) {
        $emailErr = "Please enter a email address";
    } else {
        $email = test_input($_POST["email"]);
    }
    if (empty($_POST["pwd"])) {
        $pwdErr = "Please enter the Password";
    } else {
        $pwd = test_input($_POST["pwd"]);
    }
    if (empty($_POST["pwdcfm"])) {
        $pwdcfmErr = "Please enter the confirmed Password";
    } else {
        $pwdcfm = test_input($_POST["pwdcfm"]);
    }
    if (empty($_POST["gender"])) {
        $genderError = "Please select a gender";
    } else {
        $gender = test_input($_POST["gender"]);
    }


//    if (!isset($_POST['agreecheck1'])) {
//        $chbxErr = "You have to agree to our privacy agreement";
//    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    $firstname = test_input($_POST["firstname"]);
//    $lastname = test_input($_POST["lastname"]);
    $email = test_input($_POST["email"]);
    $pwd = test_input($_POST["pwd"]);
    $pwdcfm = test_input($_POST["pwdcfm"]);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(!empty($_POST["email"])){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Please enter a valid email address";
    }
}
if (!empty($_POST["pwd"])) {
    if(strlen($pwd) < 8 || (!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $pwd))){
        $pwdErr = "Your password should be alphanumeric and contains at least 8 characters";
    }
}
if (!empty($_POST["pwdcfm"])) {
    if($pwdcfm != $pwd){
        $pwdcfmErr = "Your password confirm does not match your password";
    }
}

?>

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
						<a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="register.html">Register</a>
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
                                <input type="text" class="form-control" id="pwd" name="pwd" placeholder="Password">
                            </div>

                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="pwdcfm" name="pwdcfm" placeholder="Confirm Password">
                            </div>

                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email;?>">
                                <span class="errorcolor"><?php echo $emailErr;?></span>
                            </div>

                            <div class="col-md-12 form-group">
                                <!--<input type="text" class="form-control" id="gender" name="gender" placeholder="Gender">-->
                                <select name="gender" id="gender" required>
                                    <option disabled selected>Marital Status</option>
                                    <option value="male" <?php if($gender == "male"){?> selected="selected" <?php }?>>Male</option>
                                    <option value="female" <?php if($gender == "female"){?> selected="selected" <?php }?>>Female</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group" align="left">
                                <span class="errorcolor"><?php echo $genderError;?></span>
                            </div>

                            <div class="col-md-12 form-group">
                                <button type="submit" value="submit" class="primary-btn">Register</button>
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