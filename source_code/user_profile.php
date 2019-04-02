<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/constants.php");
require_once("serverside/components/user/edit_profile.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once("serverside/templates/html.head.php"); ?>

  <script type="text/javascript">
  function validation()
  {
    var a = document.form.pass.value;
    if(a=="")
    {
      alert("Please Enter Your Password");
      document.form.pass.focus();
      return false;
    }
    if ((a.length < 4) || (a.length > 8))
    {
      alert("Your Password must be 4 to 8 Character");
      document.form.pass.select();
      return false;
    }
  }
</script>

</head>

<body>
  <?php require_once("serverside/templates/header.php"); ?>
  <!-- Banner Section -->
  <section class="banner-area organic-breadcrumb">
    <div class="container">
      <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
        <div class="col-first">
          <h1>Edit Profile</h1>
          <nav class="d-flex align-items-center">
            <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
            <a href="login.php"></a>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <!-- End Banner Section -->
  <?php

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($results_updateuserdetails)) {
      if ($successupdate) {
        ?>
        <h3 style="text-align:center">User Details has been successfully updated.</h3>
        <?php
      }
      else {
        ?>
        <h3 style="text-align:center">Sorry, an error has occured. Please try again.</h3>
        <?php
      }
    }
    //echo "success ";




    //echo $_POST['name'];
    ?>
    <button class="primary-btn" onclick="location.href='index.php'">Back to Main Page</button>
    <br  />
    <br  />
    <?php
  }
  else {
    ?>
    <!-- Admin Dashboard Page -->
    <br  />
    <div id="page-wrapper">

      <div class="container">
        <div class="row s_product_inner">
        <div class="col-lg-6">
          <h5>Upload Profile Picture</h5>
          <div id="profile_picdrop" class="kt-dropzone dropzone m-dropzone--primary">
            <div class="kt-dropzone__msg dz-message needsclick">
              <h3 class="kt-dropzone__msg-title">Drop files here or click to upload.</h3>
              <p>
                <span class="kt-dropzone__msg-desc">Only allows .png .jpg .jpeg to be uploaded</span>
              </p>
              <p><span class="kt-dropzone__msg-desc">Upload only 1 file</span></p>
            </div>
          </div>
          <br>
          <div align="center">
            <button type="submit" class="btn info-btn" id="uploadprofilepic">Upload</button>
          </div>

          <br>
          <div id="previewprofilepic" class="dotted_border"></div>
        </div>

        <div class="col-lg-5 offset-lg-1">
        <form name="form-login" id="form-login" action="user_profile.php" method="post" enctype="multipart/form-data">
<div class="s_product_text">
          <?php
          foreach ($results_selectuser as $row) { ?>

            <input type="hidden" id="id" name="id" value="<?php safe_echo($row['id']);?>">



              <div class="form-group" id="hidden_fieldsprofile"></div>
              <div class="form-group">
                <h5>Name</h5>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $row['name']; ?>" required>
                <span class="errorcolor"><?php echo $nameErr;?></span>
              </div>
              <div class="form-group">
                <h5>LoginID</h5>
                <input type="text" class="form-control" id="loginid" name="loginid" placeholder="Login ID" value="<?php echo $row['loginid'];?>" required>
                <span class="errorcolor"><?php echo $loginidErr;?></span>
              </div>

              <div class="form-group">
                <h5>Password</h5>
                <input type="password" class="form-control" id="password1" name="password1" placeholder="Password" required>
                <span class="errorcolor"><?php echo $pwdErr;?></span>
              </div>

              <div class="form-group">
                <h5>Confirm your Password</h5>
                <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm Password" required>
                <span class="errorcolor"><?php echo $pwdcfmErr;?></span>
              </div>


              <div class="form-group">
                <h5>Email</h5>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $row['email'];?>" >
                <span class="errorcolor"><?php echo $emailErr;?></span>
              </div>

              <div class="form-group">
                <h5>Mobile</h5>
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" value="<?php echo $row['mobile'];?>" >
                <span class="errorcolor"><?php echo $mobileErr;?></span>
              </div>

              <div class="form-group">
                <h5>Bio</h5>
                <textarea class="form-control" id="bio" name="bio" placeholder="Bio"><?php echo $row['bio']; ?></textarea>
                <span class="errorcolor"><?php echo $bioErr;?></span>
              </div>

              <div class="form-group auto-margin">
                <h5>Gender</h5>
                <select class="default-select wide" id="gender" name="gender" required>
                  <option disabled>Gender</option>
                  <option value="N"<?php if ($gender === "N") { ?> selected="selected"<?php }?>>
                    Prefer not to say
                  </option>
                  <option value="M"<?php if ($gender === "M") { ?> selected="selected"<?php }?>>
                    Male
                  </option>
                  <option value="F"<?php if ($gender === "F") { ?> selected="selected"<?php }?>>
                    Female
                  </option>
                  <option value="O"<?php if ($gender === "O") { ?> selected="selected"<?php }?>>
                    Others
                  </option>
                </select>
              </div>

              <br  />
              <br  />
              <div class="col-md-12 form-group">
                <button type="submit" value="submit" class="genric-btn primary circle" name="updateuser">Update</button>
              </div>
            </div>
            </form>

          <?php  } ?>
          <?php require_once("serverside/components/user/edit_profile.php");
          ?>
        </div>
      </div>
      </div>
      <!--End Admin Dashboard Page -->
    <?php } ?>

    <!-- Footer -->
    <?php require_once("serverside/templates/footer.php"); ?>
    <!-- End Footer -->

    <?php require_once("serverside/templates/html.js.php"); ?>

    <script type="text/javascript">
    var fileCount = 0;
    Dropzone.autoDiscover = false;
    $(document).ready(function () {
      $("div#profile_picdrop").dropzone({
        url: "https://api.imgur.com/3/image", //imgur endpoint for image upload
        paramName: "image", //important for imgur request name
        method: "post",
        addRemoveLinks: true,
        autoProcessQueue: false,
        acceptedFiles: '.png,.jpg,.jpeg',
        maxFiles: 1,
        parallelUploads: 1,
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
          var submitButton = document.querySelector('#uploadprofilepic');
          myDropzone = this;
          submitButton.addEventListener("click", function () {
            myDropzone.processQueue();
          });
          this.on("addedfile", function (file) {
            if (file.type !== "image/jpeg" && file.type !== "image/png" && file.type !== "image/jpg") {
              alert("The file uploaded is not in the correct format");
              this.removeFile(file);
            }

            else if (fileCount > 1) {
              alert("1 file have already been uploaded");
              this.removeFile(file);
            }
            else {
            fileCount += 1;
            }
          });
          this.on("complete", function (file) {
            if (fileCount <= 1) {
              upload2imgur(file);
            } else {
              alert("1 file have already been uploaded");
            }
            if (this.getQueuedFiles().length === 0 && this.getUploadingFiles().length === 0) {
              var _this = this;
              _this.removeAllFiles();
            }
          });
          this.on("maxfilesexceeded", function (file) {
            alert("You can only upload 1 file!");
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

        $("#previewprofilepic").append("<img src='" + link + "' class='img-thumbnail' width='175' height='175'>");
        $("#hidden_fieldsprofile").append("<input type='hidden' name='profileimgur_link[]' value='" + link + "'>");
      });
    }
    </script>
  </body>

  </html>
