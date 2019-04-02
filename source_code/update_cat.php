<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/constants.php");
require_once("serverside/components/admin/category.php");
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
                    <a href="#">Update Category</a>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Section -->


<section class="features-area section_gap">
    <div class="container">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"></i>
                    </h3>
                </div>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($results_updatecatdetails)) {
                        if ($successupdate) { ?>
                            <h3 style="text-align:center">Category has been successfully updated.</h3>
                        <?php } else { ?>
                            <h3 style="text-align:center">Sorry, an error has occured. Please try again.</h3>
                        <?php } ?>
                        <button class="primary-btn" onclick="location.href='admin_page.php'">Back to Dashboard</button>

                    <?php }
                } else { ?>
                <!-- Update Category Form -->
                <form class="row contact_form" name="form-contact" id="form-contact" action="update_cat.php"
                      METHOD="POST">
                    <?php foreach ($results_selectedupdatecatdetails as $row) { ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <h4>Category ID</h4>
                                <input type="text" class="form-control" id="id" name="id"
                                       value="<?php safe_echo($row['id']); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <h4>Category Name</h4>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="<?php safe_echo($row['name']); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" name="updatecat" class="primary-btn">Update</button>
                        </div>
                    <?php } ?>
                </form>
                <!-- End Update Category Form -->
            </div>
        </div>
        <?php } ?>
    </div>
</section>


<!-- Footer -->
<?php require_once("serverside/templates/footer.php"); ?>
<!-- End Footer -->

<?php require_once("serverside/templates/html.js.php"); ?>
</body>

</html>
