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
                <form enctype="multipart/form-data" action="serverside/components/selling.php">
                    <div class="row s_product_inner">
                        <div class="col-lg-6">
                            <h4>Multiple Files Image</h4>
                            <div id="myDrop" class="kt-dropzone dropzone m-dropzone--primary"
                                 action="serverside/components/selling.php">
                                <div class="kt-dropzone__msg dz-message needsclick">
                                    <h3 class="kt-dropzone__msg-title">Drop files here or click to upload.</h3>
                                    <p><span class="kt-dropzone__msg-desc">Only allows .png .jpg .jpeg to be uploaded</span></p>
                                    <p><span class="kt-dropzone__msg-desc">Upload up to 5 files</span></p>
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
                                        <input type="number" class="form-control" placeholder="1" min="1" max="10">
                                    </div>

                                    <div class="col-lg-4 form-group">
                                        <h4>Product Age</h4>
                                        <input type="number" class="form-control" placeholder="1" min="1">
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
                                        <button type="submit" class="btn primary-btn">Add item to listing</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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

<script type="text/javascript">
    Dropzone.autoDiscover = false;
    $("div#myDrop").dropzone({
        addRemoveLinks: true,
        acceptedFiles: '.png,.jpg,.jpeg',
        dictRemoveFile : "x",
        maxFiles: 5,

        init: function () {
            this.on("complete", function (file) {
                if (file.type !== "image/jpeg" && file.type !== "image/png" && file.type !== "image/jpg") {
                    alert("The file uploaded is not in the correct format");
                    this.removeFile(file);
                }
            });
            this.on("maxfilesexceeded", function (file) {
                alert("You can only upload 5 files!");
                this.removeFile(file);
            });
        }
    });
</script>

</body>
</html>