<?php define("CLIENT", TRUE);
define("REQUIRE_AUTH", TRUE);
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
        <div class="product_image_area">
            <div class="container">

                <div class="row s_product_inner">
                    <div class="col-lg-6">
                        <h4>Listing Image Upload</h4>
                        <div id="myDrop" class="kt-dropzone dropzone m-dropzone--primary">
                            <div class="kt-dropzone__msg dz-message needsclick">
                                <h3 class="kt-dropzone__msg-title">Drop files here or click to upload.</h3>
                                <p>
                                    <span class="kt-dropzone__msg-desc">Only .png, .jpg and .jpeg images are allowed.</span>
                                </p>
                                <p>
                                    <span class="kt-dropzone__msg-desc">You may upload up to 5 images</span>
                                </p>
                            </div>
                        </div>
                        <br/>
                        <div align="center">
                            <button type="submit" class="btn info-btn" id="upload-all">Upload</button>
                        </div>
                        <br/>
                        <span class="text-danger"><?php safe_echo($error_image); ?></span>
                        <br/>
                        <h4>Image Preview</h4>
                        <div id="preview" class="dotted_border"></div>
                    </div>

                    <div class="col-lg-5 offset-lg-1">
                        <form id="form_selling" name="form_selling" action="selling.php" method="post">
                            <div class="s_product_text">
                                <div class="form-group" id="hidden_fields"></div>

                                <div class="form-group">
                                    <h4>Listing Name</h4>
                                    <input type="text" id="product_name" name="product_name" class="form-control"
                                           placeholder="E.g. iPhone">
                                    <span class="text-danger"><?php safe_echo($error_name); ?></span>
                                </div>

                                <div class="form-group">
                                    <h4>Listing Description</h4>
                                    <textarea class="form-control" id="product_desc" name="product_desc"
                                              rows="5"></textarea>
                                    <span class="text-danger"><?php safe_echo($error_desc); ?></span>
                                </div>

                                <div class="form-group">
                                    <h4>Show Listing Till</h4>
                                    <input type="text" id="listing_expiry" name="listing_expiry" class="form-control"
                                           placeholder="yyyy/mm/dd">
                                    <span class="text-danger"><?php safe_echo($error_date); ?></span>
                                </div>

                                <div class="form-group">
                                    <h4>Tags</h4>
                                    <input type="text" class="form-control" id="tags" name="tags"
                                           placeholder="Search tags, separate with comma">
                                    <span class="text-danger"><?php safe_echo($error_tags); ?></span>
                                </div>

                                <div class="form-group">
                                    <h4>Price</h4>
                                    <input type="text" class="form-control" id="price" name="price">
                                    <span class="text-danger"><?php safe_echo($error_price); ?></span>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 form-group">
                                        <h4>Condition</h4>
                                        <input type="number" id="condition" name="condition" class="form-control"
                                               min="1" max="10" placeholder="1 to 10">
                                    </div>

                                    <div class="col-lg-4 form-group">
                                        <h4>Age</h4>
                                        <input type="number" id="age" name="age" class="form-control" min="0"
                                               placeholder="Age in months">
                                    </div>

                                    <div class="col-lg-5 form-group">
                                        <h4>Category</h4>
                                        <select class="default-select wide" id="category" name="category">
                                            <?php foreach ($categories as $row) { ?>
                                                <option value="<?php safe_echo($row['id']) ?>">
                                                    <?php safe_echo($row['name']) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <span class="text-danger"><?php safe_echo($error_condition); ?></span>
                                        <span class="text-danger"><?php safe_echo($error_age); ?></span>
                                        <span class="text-danger"><?php safe_echo($error_cat); ?></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <h4>Meetup Location</h4>
                                        <select class="default-select wide" id="location" name="location">
                                            <?php foreach ($locations as $row) { ?>
                                                <option value="<?php safe_echo($row['id']) ?>">
                                                    <?php safe_echo($row['location']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <span class="text-danger"><?php safe_echo($error_loc); ?></span>
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <div class="col-12 card_area align-items-center text-center">
                                        <button type="submit" name="selling_submit" class="btn primary-btn">
                                            Add item to listing
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- Artificial Spacing -->
<br/><br/><br/>

<!-- Footer -->
<?php require_once("serverside/templates/footer.php"); ?>
<!-- End Footer -->
<?php require_once("serverside/templates/html.js.php"); ?>

<script>
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
                        notify("The file uploaded is not in the correct format!", "danger");
                        this.removeFile(file);
                    } else if (fileCount > 5) {
                        this.removeFile(file);
                    } else {
                        fileCount += 1;
                    }
                });

                this.on("removedfile", function () {
                    fileCount -= 1;
                });

                this.on("complete", function (file) {
                    if (fileCount <= 5) {
                        upload2imgur(file);
                    }
                    if (this.getQueuedFiles().length === 0 && this.getUploadingFiles().length === 0) {
                        var _this = this;
                        _this.removeAllFiles();
                    }
                });
                this.on("maxfilesexceeded", function (file) {
                    notify("5 files have already been uploaded!", "danger");
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
            var deleteHash = obj.data.deletehash; //TODO

            // $("#preview").append("<img src='" + link + "' class='img-thumbnail' width='175' height='175'>");
            $("#previewprofilepic").append("<img src='" + link + "' class='img-thumbnail' width='175' height='175'> <br> <input type='hidden' id='delete_hash' name='delete_hash' value='" + deleteHash + "'> <br> <button id='submit_delete' class='btn btn-link'>Remove</button>");
            $("#hidden_fields").append("<input type='hidden' name='images[]' value='" + link + "'>");
        });
    }

    //TODO
    function deleteImgurImage(deleteHash) {
        var settings = {
            "url": "https://api.imgur.com/3/image/" + deleteHash,
            "method": "DELETE",
            "timeout": 0,
            "headers": {
                "Authorization": "Client-ID b0fe35e83401711"
            },
        };
        $.ajax(settings).done(function (response) {
            console.log(response);
        });
    }
</script>
</body>
</html>