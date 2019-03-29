<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/constants.php");
require_once("serverside/components/admin/admin.php");

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
					<h1>Add Category</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="admin_page.php">Admin Dashboard Page<span class="lnr lnr-arrow-right"></span></a>
            <a href="add_cat.php">Add Category</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section -->

<?php $catlist = end($results_catdetails);?>
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
                    if(isset($results_addnewcat)) {
                      if ($success) {
                ?>
                <h3 style="text-align:center">Category has been successfully updated.</h3>

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
}else {
                ?>
							</h3>
						</div>
            <form class="row contact_form" name="form-contact" id="form-contact" method="POST" >
  						<div class="col-md-6">
  							<div class="form-group">

  								<input type="text" class="form-control" id="id" name="id" value="<?php safe_echo($catlist['id']+1); ?>" placeholder="Category ID">
  							</div>
                <div class="form-group">
  								<input type="text" class="form-control" id="name" name="name" placeholder="Category Name">
  							</div>
  						<div class="col-md-12 text-right">
  							<button type="submit" name="newcat" class="primary-btn">Add New Category</button>
  						</div>
  					</form>
<p></p>

			</div>
    </div>
    <?php
}
    ?>
<!--End Admin Dashboard Page -->

  <!-- Footer -->
	<?php require_once("serverside/templates/footer.php"); ?>
	<!-- End Footer -->

	<?php require_once("serverside/templates/html.js.php"); ?>
</body>

</html>
