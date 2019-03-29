<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/constants.php");
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
            <a href="add_user.php">Add New User</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section -->

<!-- Admin Dashboard Page -->
<div id="page-wrapper">

			<div class="container-fluid">

				<!-- /.row -->

				<!-- /.row -->


        <div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								<i class="fa fa-money fa-fw"></i>
							</h3>
						</div>
            <?php

          if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //echo $_POST['name'];
              if(isset($results_addnewuser)) {
                if ($success) {
            //echo "success ";
?>
    <h3 style="text-align:center">New User has been successfully added.</h3>

    <button class="primary-btn" onclick="location.href='admin_page.php'">Back to Dashboard</button>
<?php
          }
          else {
            ?>
            <h3 style="text-align:center">Sorry, an error has occured. Please try again.</h3>
            <button class="primary-btn" onclick="location.href='admin_page.php'">Back to Dashboard</button>
            <?php
          }
        }
    } else {

    ?>
    <h2 style="test-align:center">You found a new page! Heres a cookie!</h2>
    <button class="primary-btn" onclick="location.href='index.php'">Back to Main</button>
    <?php
    }
     ?>

            <p></p>
					</div>
				</div>

			</div>
    </div>
<!--End Admin Dashboard Page -->

  <!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>
</body>

</html>
