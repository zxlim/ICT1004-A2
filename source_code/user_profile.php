<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/constants.php");
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
    if (isset($results_updateuserdetails)) {
      if ($successupdate) {
        ?>
        <h3 style="text-align:center">User Details has been successfully updated.</h3>
 <?php
      }
      else {
        ?>
        <h3 style="text-align:center">Sorry, an error has occured. Please try again.</h3>
<?php
      }
    }
    //echo "success ";




  //echo $_POST['name'];
     ?>
<button class="primary-btn" onclick="location.href='index.php'">Back to Main Page</button>
<br  />
<br  />
<?php
}
else {
  ?>
<!-- Admin Dashboard Page -->
<br  />
<div id="page-wrapper">

			<div class="container-fluid">

        <form class="row login_form" name="form-login" id="form-login" action="user_profile.php" method="post" enctype="multipart/form-data">
          <?php
          foreach ($results_selectuser as $row) { ?>

            <input type="hidden" id="id" name="id" value="<?php safe_echo($row['id']);?>">

            <div class="col-md-12 form-group">
              <?php if (isset($row['test_pic'])) { ?>
                <img id="photos" class="rounded-circle" src="<?php echo $row['test_pic']?>">
              <?php } ?>
                <div class="avatar" /><input type="file" name="avatar" accept="image/*" />

            </div>

            <div class="col-md-12 form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $row['name']; ?>" required>
                <span class="errorcolor"><?php echo $nameErr;?></span>
            </div>

            <div class="col-md-12 form-group">
                <input type="text" class="form-control" id="loginid" name="loginid" placeholder="Login ID" value="<?php echo $row['loginid'];?>" required>
                <span class="errorcolor"><?php echo $loginidErr;?></span>
            </div>

            <div class="col-md-12 form-group">
                <input type="password" class="form-control" id="password1" name="password1" placeholder="Password" required>
                <span class="errorcolor"><?php echo $pwdErr;?></span>
            </div>

            <div class="col-md-12 form-group">
                <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm Password" required>
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
                <textarea class="form-control" id="bio" name="bio" placeholder="Bio"><?php echo $row['bio']; ?></textarea>
                <span class="errorcolor"><?php echo $bioErr;?></span>
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

            <br  />
            <br  />
            <div class="col-md-12 form-group">
                <button type="submit" value="submit" class="primary-btn" name="updateuser">Update</button>
            </div>
        </form>

      <?php  } ?>
      <?php require_once("serverside/components/user/profile.php");
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
