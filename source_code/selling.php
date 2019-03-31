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
                        <div id="myDrop" class="kt-dropzone dropzone m-dropzone--primary">
                            <div class="kt-dropzone__msg dz-message needsclick">
                                <h3 class="kt-dropzone__msg-title">Drop files here or click to upload.</h3>
                                <p>
                                    <span class="kt-dropzone__msg-desc">Only allows .png .jpg .jpeg to be uploaded</span>
                                </p>
                                <p><span class="kt-dropzone__msg-desc">Upload up to 5 files</span></p>
                            </div>
                        </div>
                        <br>
                        <div align="center">
                            <button type="submit" class="btn info-btn" id="upload-all" name="upload">Upload</button>
                        </div>


                        <br>
                        <div id="preview" class="dropzone"></div>
                    </div>

                    <div class="col-lg-5 offset-lg-1">
                        <form id="form_selling" name="form_selling" action="selling.php" method="post">
                            <div class="s_product_text">
                                <div class="form-group" id="hidden_fields"></div>

                                <div class="form-group">
                                    <h4>Product Name</h4>
                                    <input type="text" id="product_name" name="product_name" class="form-control"
                                           placeholder="iPhone">

                                </div>

                                <div class="form-group">
                                    <h4>Product Description</h4>
                                    <textarea class="form-control" id="productDesc" name="product_desc"
                                              rows="5"></textarea>

                                </div>

                                <div class="form-group">
                                    <h4>Price</h4>
                                    <input type="text" class="form-control" id="price" name="price" placeholder="100">

                                </div>

                                <div class="row">
                                    <div class="col-lg-3 form-group">
                                        <h4>Condition</h4>
                                        <input type="number" id="condition" name="condition" class="form-control"
                                               placeholder="1"
                                               min="1"
                                               max="10">

                                    </div>

                                    <div class="col-lg-4 form-group">
                                        <h4>Product Age</h4>
                                        <input type="number" id="age" name="age" class="form-control" placeholder="1"
                                               min="1">

                                    </div>

                                    <div class="col-lg-5 form-group">
                                        <h4>Category</h4>
                                        <select class="nice-select" id="categorySelection" name="categorySelection">
                                            <option selected="" value="Default"></option>
                                            <option>Home Appliances</option>
                                            <option>Computers and IT</option>
                                            <option>Furniture</option>
                                            <option>Kids</option>
                                            <option>Home Repairs and Services</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="wrapper col-lg-12 form-group">
                                        <h4>Meetup Location</h4>
                                        <select class="nice-select custom-select selection" size="10"
                                                id="locationSelection" name="locationSelection">
                                            <option selected="" value="Default"></option>
                                            <?php foreach ($mrt_stations as $row) { ?>
                                                <option><?php safe_echo($row['stn_code'] . ' / ' . $row['stn_name'] . ' / ' . $row['stn_line']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="card_area d-flex align-items-center">
                                        <button type="submit" class="btn primary-btn">Add item
                                            to listing
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--================End Single Product Area =================-->
</section>

<!-- Artificial Spacing -->
<br/><br/><br/>

<!-- Footer -->
<?php require_once("serverside/templates/footer.php"); ?>
<!-- End Footer -->
<?php require_once("serverside/templates/html.js.php"); ?>

<script type="text/javascript">
    var fileCount = 0;
    Dropzone.autoDiscover = false;
    $(document).ready(function () {
        $("div#myDrop").dropzone({
            url: "https://api.imgur.com/3/image", //imgur endpoint for image upload
            paramName: "image", //important for imgur request name
            method: "post",
            addRemoveLinks: true,
            autoProcessQueue: false,
            acceptedFiles: '.png,.jpg,.jpeg',
            maxFiles: 5,
            parallelUploads: 5,
            headers: {
                'Cache-Control': null, //required for cors
                'X-Requested-With': null, //required for cors
                'Authorization': "Client-ID b0fe35e83401711"
            },
            // Strings
            dictRemoveFileConfirmation: "Are you Sure?",
            dictRemoveFile: "x",
            dictCancelUpload: "x",
            init: function () {
                var submitButton = document.querySelector('#upload-all');
                myDropzone = this;
                submitButton.addEventListener("click", function () {
                    myDropzone.processQueue();
                });
                this.on("addedfile", function (file) {
                    if (file.type !== "image/jpeg" && file.type !== "image/png" && file.type !== "image/jpg") {
                        alert("The file uploaded is not in the correct format");
                        this.removeFile(file);
                    }
                    fileCount += 1;
                    if (fileCount > 5) {
                        alert("5 files have already been uploaded");
                        this.removeFile(file);
                    }
                });
                this.on("complete", function (file) {
                    if (fileCount <= 5) {
                        upload2imgur(file);
                    } else {
                        alert("5 files have already been uploaded");
                    }
                    if (this.getQueuedFiles().length === 0 && this.getUploadingFiles().length === 0) {
                        var _this = this;
                        _this.removeAllFiles();
                    }
                });
                this.on("maxfilesexceeded", function (file) {
                    alert("You can only upload 5 files!");
                    this.removeFile(file);
                });
            },
        });
    });

    function upload2imgur(file) {
        var form = new FormData();
        form.append("image", file);
        var settings = {
            "url": "https://api.imgur.com/3/image",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Authorization": "Client-ID b0fe35e83401711"
            },
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form
        };
        $.ajax(settings).done(function (response) {
            var obj = JSON.parse(response);
            var link = obj.data.link;
            $("#preview").append("<img src='" + link + "' class='img-thumbnail' width='175' height='175'>");
            $("#hidden_fields").append("<input type='hidden' name='imgur_link[]' value='" + link + "'>");
        });
    }
</script>
</body>
</html>