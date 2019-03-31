<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/constants.php");
require_once("serverside/components/user/register.php");
require_once("serverside/components/user/profile.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php require_once("serverside/templates/html.head.php"); ?>

<script type="text/javascript">
    function validation()
    {
        var a = document.form.pass.value;
        if(a=="")
        {
            alert("Please Enter Your Password");
            document.form.pass.focus();
            return false;
        }
        if ((a.length < 4) || (a.length > 8))
        {
            alert("Your Password must be 4 to 8 Character");
            document.form.pass.select();
            return false;
        }
    }
</script>

</head>

<body>
  <?php require_once("serverside/templates/header.php"); ?>
  <!-- Banner Section -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Admin Dashboard Page</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="login.php"></a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section -->
  <?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //echo $_POST['name'];
    if(isset($results_updateuserdetails)) {
      if ($successupdate) {
  //echo "success ";
?>
<h3 style="text-align:center">User Details has been successfully updated.</h3>


<?php
}
else {
  ?>
  <h3 style="text-align:center">Sorry, an error has occured. Please try again.</h3>
  <?php
}
} ?>
<button class="primary-btn" onclick="location.href='index.php'">Back to Main Page</button>
<?php
}
else {
  ?>
<!-- Admin Dashboard Page -->
<div id="page-wrapper">

			<div class="container-fluid">

        <form class="row login_form" name="form-login" id="form-login" action="user_profile.php" method="post">
          <?php
          foreach ($results_selectuser as $row) { ?>

            <input type="hidden" id="id" name="id" value="<?php safe_echo($row['id']);?>">

            <div class="col-md-12 form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $row['name']; ?>" required>
                <span class="errorcolor"><?php echo $nameErr;?></span>
            </div>

            <div class="col-md-12 form-group">
                <input type="text" class="form-control" id="loginid" name="loginid" placeholder="Login ID" value="<?php echo $row['loginid'];?>" required>
                <span class="errorcolor"><?php echo $loginidErr;?></span>
            </div>

            <div class="col-md-12 form-group">
                <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password" required>
                <span class="errorcolor"><?php echo $pwdErr;?></span>
            </div>

            <div class="col-md-12 form-group">
                <input type="password" class="form-control" id="pwdcfm" name="pwdcfm" placeholder="Confirm Password" required>
                <span class="errorcolor"><?php echo $pwdcfmErr;?></span>

            </div>

            <div class="col-md-12 form-group">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $row['email'];?>" >
                <span class="errorcolor"><?php echo $emailErr;?></span>
            </div>

            <div class="col-md-12 form-group">
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" value="<?php echo $row['mobile'];?>" >
                <span class="errorcolor"><?php echo $mobileErr;?></span>
            </div>

            <div class="col-md-12 form-group">
                <textarea class="form-control" id="bio" name="bio" placeholder="Bio"><?php echo $row['bio']; }?></textarea>
                <span class="errorcolor"><?php echo $bioErr;?></span>
            </div>


            <div class="col-md-12 form-group" align="left">
                <span class="errorcolor"><?php echo $genderError;?></span>
            </div>

            <div class="col-md-12 form-group">
                <button type="submit" value="submit" class="primary-btn" name="updateuser">Update</button>
            </div>
        </form>

        <?php  require_once("serverside/components/user/profile.php");
        ?>
			</div>
    </div>
<!--End Admin Dashboard Page -->
<?php } ?>

  <!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>
</body>

</html>
