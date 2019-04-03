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
                    <a href="edit_account.php?edituser=">Enable/Disable Account</a>
                </nav>
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
                        <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (isset($results_updateuserdetails)) {
                                if ($successupdate) { ?>
                                    <h3 style="text-align:center">Account has
                                        been <?php if ($suspended_state) { ?> Disabled <?php } else { ?> Enabled <?php } ?>
                                        .</h3>

                                <?php } else { ?>
                                    <h3 style="text-align:center">Sorry, an error has occured. Please try again.</h3>
                                <?php }
                            } ?>
                            <button class="primary-btn" onclick="location.href='admin_page.php'">Back to Dashboard
                            </button>
                            <p></p>
                        <?php } else { ?>
                    </h3>
                </div>


                <!-- Edit Account Form -->
                <form class="contact_form" name="form-contact" id="form-contact" action="edit_account.php"
                      METHOD="POST">
                    <?php foreach ($results_selectedupdateuserdetails as $row) { ?>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <h4>User ID</h4>
                                    <input type="text" class="form-control" id="id" name="id"
                                           value="<?php safe_echo($row['id']); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <h4>Name</h4>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="<?php safe_echo($row['name']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h4>Login ID</h4>
                                    <input type="text" class="form-control" id="loginid" name="loginid"
                                           value="<?php safe_echo($row['loginid']); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php if ($row['suspended'] == 1) { ?>
                                    <h3>User is suspended. Enable user account?</h3>
                                    <input type="hidden" id="suspended" name="suspended"
                                           value="<?php safe_echo($row['suspended']); ?>">
                                <?php } else { ?>
                                    <h3>User is not suspended. Disable user account?</h3>
                                    <?php $row['suspended'] = 0; ?>
                                    <input type="hidden" id="suspended" name="suspended"
                                           value="<?php safe_echo($row['suspended']); ?>">
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h4>Email</h4>
                                    <input type="text" class="form-control" id="email" name="email"
                                           value="<?php safe_echo($row['email']); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" name="updateuser"
                                        class="genric-btn danger large"><?php if ($row['suspended'] == 1) { ?> Enable <?php } else { ?> Disable <?php } ?></button>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-md-12 text-right">

                    </div>
                </form>
                <!-- End Edit Account Form -->
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
