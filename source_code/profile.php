<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/components/user/profile_listing.php");
define("WEBPAGE_TITLE", "Profile");
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <?php require_once("serverside/templates/html.head.php"); ?>
</head>
<body>
<!-- Header -->
<?php require_once("serverside/templates/header.php"); ?>
<!-- End Header -->

<!-- Banner Section -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Profile (TO-DO)</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="">Profile</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Section -->

<section class="features-area">
    <div class="container">
        <div class="product_image_area">
            <div class="container">
                <div class="row s_product_inner">
                    <div class="col-lg-6">
                        <h2>Profiles</h2>
                        <hr>
                        <figure>
                            <img class="rounded-circle" src="static/img/default/user.jpg" alt="User Profile Image"
                                 height="200"
                                 width="200">
                        </figure>
                    </div>

                    <div class="col-lg-5 offset-lg-1">
                        <div class="s_product_text">
                            <div class="dotted_border">
                                <h4>Name</h4>
                                <p></p>
                            </div>

                            <div class="form-group">
                                <h4>Email</h4>
                            </div>

                            <div class="form-group">
                                <h4>Join Date</h4>
                            </div>

                            <div class="form-group">
                                <h4>Gender</h4>
                            </div>

                            <div class="form-group">
                                <h4>Bio</h4>
                            </div>

                            <div class="row">
                                <br/>
                                <div class="col-12 form-group card_area align-items-center text-center">
                                    <button type="submit" name="selling_submit" class="btn primary-btn">
                                        Edit Profile
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>


<section class="features-area">
    <div class="container">
    </div>
</section>
<!-- Footer -->
<?php require_once("serverside/templates/footer.php"); ?>
<!-- End Footer -->

<?php require_once("serverside/templates/html.js.php"); ?>
</body>
</html>