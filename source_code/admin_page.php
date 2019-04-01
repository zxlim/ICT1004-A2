<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/constants.php");
require_once("serverside/components/admin/admin.php");
require_once("serverside/components/admin/user.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once("serverside/templates/html.head.php"); ?>

    <style>
        a {
            color: inherit;
        }
    </style>

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
                    <a href="admin_page.php">Admin Dashboard Page</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Section -->

<!-- Admin Dashboard Page -->
<div id="page-wrapper">
    <div class="container section_gap">
        <!-- Category Report Table -->
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading float-left">
                    <h3 class="panel-title">Category Report</h3>
                </div>

                <button type="button" class="genric-btn info circle float-right" onClick="location.href='add_cat.php'">
                    Add Category
                </button>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Details</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            foreach ($results_catdetails as $row) {
                                echo "<tr>";

                                echo "<td>";
                                safe_echo($row["id"]);
                                echo "</td>";
                                echo "<td>";
                                safe_echo($row["name"]);
                                echo "</td>";
                                echo "<td><button type='button' class=\"genric-btn primary circle\"> <a href='update_cat.php?updatecat=" . $row['id'] . "'>Update Category</a></button><p></p>";
                                #echo "<td><button type='button' class=\"genric-btn warning circle\"><a href='update_cat.php?updatecat=".$row['id']."'>Update Category</a></button>";
                                echo "<button type='button' class=\"genric-btn danger circle arrow\"><a href='del_cat.php?delcat=" . $row['id'] . "'>Delete Category</a></button>";
                                #echo "<button type='button'><a href='del_cat.php?delcat=".$row['id']."'>Delete Category</a></button></td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Category Report Table -->

        <!-- User Report Table -->
        <div class="col-lg-12">
            <div class="panel panel-default section_gap_top_75">
                <div class="panel-heading float-left">
                    <h3 class="panel-title">User Report</h3>
                </div>

                <button type="button" class="genric-btn info circle float-right" onClick="location.href='add_user.php'">
                    Add User
                </button>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th>Details</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            foreach ($results_userdetails as $row) {
                                echo "<tr>";

                                echo "<td>";
                                safe_echo($row["id"]);
                                echo "</td>";
                                echo "<td>";
                                safe_echo($row["name"]);
                                echo "</td>";
                                echo "<td>";
                                safe_echo($row["email"]);
                                echo "</td>";
                                echo "<td>";
                                safe_echo($row["gender"]);
                                echo "</td>";
                                echo "<td>";
                                if (!isset($row["suspended"]) || $row["suspended"] == 0) {
                                    $row["suspended"] = "Not suspended";
                                } else {
                                    $row["suspended"] = "Suspended";
                                }

                                safe_echo($row["suspended"]);
                                echo "</td>";
                                echo "<td><button type='button' class=\"genric-btn primary circle arrow\"><a href='edit_account.php?edituser=" . $row['id'] . "'>Enable/Disable Account</button><p></p>";
                                echo "<button type='button' class=\"genric-btn danger circle arrow\"><a href='del_user.php?deluser=" . $row['id'] . "'>Delete User</a></button></td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End User Report Table -->

    </div>
</div>
<!--End Admin Dashboard Page -->

<!-- Footer -->
<?php require_once("serverside/templates/footer.php"); ?>
<!-- End Footer -->

<?php require_once("serverside/templates/html.js.php"); ?>
</body>

</html>
