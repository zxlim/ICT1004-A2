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
                <h1>Add Category</h1>
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

<?php $userlist = end($results_userdetails); ?>

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
                            if (isset($results_addnewuser)) {
                                if ($success) {
                                    //echo "success ";
                                    ?>
                                    <h3 style="text-align:center">New User has been successfully added.</h3>
                                    <?php
                                } else {
                                    ?>
                                    <h3 style="text-align:center">Sorry, an error has occured. Please try again.</h3>
                                    <?php
                                } ?>
                                <button class="primary-btn" onclick="location.href='admin_page.php'">Back to Dashboard
                                </button>
                                <?php
                            }
                        }
                        else { ?>
                    </h3>
                </div>
                <form class="row contact_form" name="form-contact" id="form-contact" method="POST"
                      action="add_user.php">
                    <div class="col-md-2">
                        <div class="form-group">
                            <h4>User ID</h4>
                            <input type="text" class="form-control" id="id" name="id"
                                   value="<?php safe_echo($userlist['id'] + 1); ?>" placeholder="User ID">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <h4>Gender</h4>
                            <select id="Gender" name="Gender">
                                TODO
                                <option value="M" selected>Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <h4>User Name</h4>
                            <input type="text" class="form-control" id="name" name="name" placeholder="User Name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-md-12 text-right">
                            <button type="submit" name="newuser" class="genric-btn primary">Add New User</button>
                        </div>
                    </div>
                </form>
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