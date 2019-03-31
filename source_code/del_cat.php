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
            <a href="del_cat.php?delcat=">Delete Category</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section -->


<div id="page-wrapper">

			<div class="container-fluid">



        <div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								<i class="fa fa-money fa-fw"></i>
              <?php  if ($_SERVER["REQUEST_METHOD"] == "POST") {

                  //echo $_POST['name'];
                    if(isset($results_deletecat)) {
                      if ($successdel) {
                  //echo "success ";
      ?>
          <h3 style="text-align:center">Category has been successfully deleted.</h3>


      <?php
                }
                else {
                  ?>
                  <h3 style="text-align:center">Sorry, an error has occured. Please try again.</h3>

                  <?php
                }
              } ?>
              <button class="primary-btn" onclick="location.href='admin_page.php'">Back to Dashboard</button>
              <p></p>
              <?php
          }
          else {
          ?>
							</h3>
						</div>

<?php

  foreach ($results_selectedupdatecatdetails as $row) {

 ?>
 <!-- Delete Category Form -->
            <form class="row contact_form" name="form-contact" id="form-contact" action="del_cat.php" METHOD="POST">
  						<div class="col-md-6">
  							<div class="form-group">

  							ID:	<input type="text" class="form-control" id="id" name="id" value="<?php safe_echo($row['id']); ?>" readonly>
  							</div>
                <div class="form-group">
  							Name:	<input type="text" class="form-control" id="name" name="name" value="<?php safe_echo($row['name']); }?>" readonly>
  							</div>


                <h3>Are you sure you want to delete this category?</h3>

  						<div class="col-md-12 text-right">
  							<button type="submit"  name="deletecat" class="primary-btn">Delete Category</button>
  						</div>


  					</form>
             <!-- End Delete Category Form -->
            <p></p>
					</div>
				</div>
<?php } ?>
			</div>
    </div>


  <!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>
</body>

</html>
