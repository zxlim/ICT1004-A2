<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/components/home.php");
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
        <h2>Your search results for <? echo $_POST['search_query']; ?></h2>
        <hr>
        <div class="row features-inner">

        </div>
    </div>

</section>
<!-- End Features Section -->
<!-- Footer -->
<?php require_once("serverside/templates/footer.php"); ?>
<!-- End Footer -->

<?php require_once("serverside/templates/html.js.php"); ?>
</body>
</html>