<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/constants.php");
require_once("serverside/components/admin/admin.php");
require_once("serverside/components/admin/user.php");


?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php require_once("serverside/templates/html.head.php"); ?>
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
						<a href="admin_page.php">Admin Dashboard Page<span class="lnr lnr-arrow-right"></span></a>
            <a href="del_user.php?deluser=">Delete User Account</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section -->

<!-- Admin Dashboard Page -->
<div id="page-wrapper">

			<div class="container-fluid">



        <div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								<i class="fa fa-money fa-fw"></i>
                <?php

              if ($_SERVER["REQUEST_METHOD"] == "POST") {

                //echo $_POST['name'];
                  if(isset($results_deleteuser)) {
                    if ($successuserdel) {
                //echo "success ";
    ?>
        <h3 style="text-align:center">User has been successfully deleted.</h3>

    <?php
              }
              else {
                ?>
                <h3 style="text-align:center">Sorry, an error has occured. Please try again.</h3>

                <?php
              } ?>
              <button class="primary-btn" onclick="location.href='admin_page.php'">Back to Dashboard</button>
              <p></p>
              <?php
            }
          }
          else {
            ?>
							</h3>
						</div>

<?php

  foreach ($results_selectdeleteuser as $row) {

 ?>
             <!-- Delete User Form -->
            <form class="row contact_form" name="form-contact" id="form-contact" action="del_user.php" METHOD="POST">
  						<div class="col-md-6">
  							<div class="form-group">

  							ID:	<input type="text" class="form-control" id="id" name="id" value="<?php safe_echo($row['id']); ?>" readonly>
  							</div>
                <div class="form-group">
  							Name:	<input type="text" class="form-control" id="name" name="name" value="<?php safe_echo($row['name']); ?>" readonly>
  							</div>
                <div class="form-group">
  							LoginID:	<input type="text" class="form-control" id="loginid" name="loginid" value="<?php safe_echo($row['loginid']); ?>" readonly>
  							</div>
                <div class="form-group">
  							Email:	<input type="text" class="form-control" id="email" name="email" value="<?php safe_echo($row['email']); }?>" readonly>
  							</div>

                <h3>Are you sure you want to delete this account?</h3>

  						<div class="col-md-12 text-right">
  							<button type="submit"  name="deleteuser" class="primary-btn">Delete User</button>
  						</div>


  					</form>
             <!-- End Delete Category Form -->
            <p></p>
					</div>
				</div>
<?php } ?>
			</div>
    </div>

<!--End Admin Dashboard Page -->

  <!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>
</body>

</html>
