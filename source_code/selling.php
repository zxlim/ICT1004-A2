<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/components/selling.php");
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
<!-- Features Section -->
<section class="features-area section_gap">
    <div class="container section_gap">
        <!--================Single Product Area =================-->
        <div class="product_image_area">
            <div class="container">
                <div class="row s_product_inner">
                    <div class="col-lg-6">
                        <h4>Multiple Files Image</h4>
                        <div class="kt-dropzone dropzone m-dropzone--primary"
                             action="serverside/components/selling.php">
                            <div class="kt-dropzone__msg dz-message needsclick">
                                <h3 class="kt-dropzone__msg-title">Drop files here or click to upload.</h3>
                                <span class="kt-dropzone__msg-desc">Upload up to 10 files</span>
                            </div>
                        </div>
                        <hr/>
                        <h4>Single Product Image</h4>
                        <div class="dropzone" action="serverside/components/selling.php">
                            <div class="kt-dropzone__msg dz-message needsclick">
                                <h3 class="kt-dropzone__msg-title">Drop files here or click to upload.</h3>
                                <span class="kt-dropzone__msg-desc">Only image are allowed for upload</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 offset-lg-1">
                        <div class="s_product_text">
                            <div class="form-group">
                                <h4>Product Name</h4>
                                <input type="text" class="form-control" placeholder="iPhone">
                            </div>

                            <div class="form-group">
                                <h4>Product Description</h4>
                                <textarea class="form-control" id="productDesc" rows="5"></textarea>
                            </div>

                            <div class="form-group">
                                <h4>Price</h4>
                                <input type="text" class="form-control" placeholder="100">
                            </div>

                            <div class="row">
                                <div class="col-lg-3 form-group">
                                    <h4>Condition</h4>
                                    <input type="number" class="form-control" placeholder="1">
                                </div>

                                <div class="col-lg-4 form-group">
                                    <h4>Product Age</h4>
                                    <input type="number" class="form-control" placeholder="1">
                                </div>

                                <div class="col-lg-5 form-group">
                                    <h4>Category</h4>
                                    <select class="form-control" id="categorySelection">
                                        <option></option>
                                        <option>Home Appliances</option>
                                        <option>Computers & IT</option>
                                        <option>Furniture</option>
                                        <option>Kids</option>
                                        <option>Home Repairs and Services</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <h4>Meetup Location</h4>
                                    <select class="form-control" id="categorySelection">
                                        <option></option>
                                        <option>Central</option>
                                        <option>North</option>
                                        <option>South</option>
                                        <option>East</option>
                                        <option>West</option>
                                    </select>
                                </div>

                                <div class="card_area d-flex align-items-center">
                                    <a class="primary-btn" href="#">Add item to listing</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--================End Single Product Area =================-->
    </div>
</section>

<!-- Artificial Spacing -->
<br/><br/><br/>

<!-- Footer -->
<?php require_once("serverside/templates/footer.php"); ?>
<!-- End Footer -->

<?php require_once("serverside/templates/html.js.php"); ?>
</body>
</html>