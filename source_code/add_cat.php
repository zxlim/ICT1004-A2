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

<?php $catlist = end($results_catdetails); ?>

<section class="features-area section_gap">
    <div class="container">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"></i>

                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                            //echo $_POST['name'];
                            if (isset($results_addnewcat)) {
                                if ($successaddcat) {
                                    ?>
                                    <h3 style="text-align:center">Category has been successfully updated.</h3>

                                    <?php
                                }
                                ?>
                                <h3 style="text-align:center">Sorry, an error has occured. Please try again.</h3>
                            <?php } ?>
                            <button class="primary-btn" onclick="location.href='admin_page.php'">Back to Dashboard
                            </button>
                            <p></p>
                            <?php
                        }
                        else {

                        ?>
                    </h3>
                </div>
                <!-- Add Category Form -->
                <form class="row contact_form" name="form-contact" id="form-contact" method="POST" action="add_cat.php">
                    <div class="col-md-4">
                        <div class="form-group">
                            <h4>Category ID</h4>
                            <input type="text" class="form-control" id="id" name="id"
                                   value="<?php safe_echo($catlist['id'] + 1); ?>" placeholder="Category ID">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <h4>Category Name</h4>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Category Name">
                        </div>
                    </div>
                    <div class="col-md-4 float-right">
                        <button type="submit" name="newcat" class="primary-btn">Add New Category</button>
                    </div>
                </form>
                <!-- End Add Category Form -->

                <?php } ?>
            </div>
        </div>
    </div>
</section>
<!-- Footer -->
<?php require_once("serverside/templates/footer.php"); ?>
<!-- End Footer -->

<?php require_once("serverside/templates/html.js.php"); ?>
</body>

</html>
