<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/components/user/profile_listing.php");
define("WEBPAGE_TITLE", "Profile");
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <?php require_once("serverside/templates/html.head.php"); ?>
    <style>
        a {
            color: inherit;
        }
    </style>

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
                <h1>Profile</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="">Seller Profile</a>
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
                    <?php if ($profile !== NULL) { ?>
                        <div class="col-lg-6">
                            <h2>Profiles</h2>
                            <hr>
                            <figure>
                                <img class="rounded-circle" src="<?php safe_echo($profile['profile_pic']); ?>"
                                     alt="User Profile Image"
                                     height="200"
                                     width="200">
                            </figure>
                        </div>

                        <div class="col-lg-5 offset-lg-1">
                            <div class="s_product_text">
                                <input type="hidden" id="user_id" name="user_id"
                                       value="<?php safe_echo((int)$_SESSION["user_id"]); ?>">

                                <div class="row form-group">
                                    <div class="col-4">
                                        <h4>Name</h4>
                                        <p><?php safe_echo($profile["name"]); ?></p>
                                    </div>
                                    <div class="col-5">
                                        <h4>Email</h4>
                                        <p class="word_break"><?php safe_echo($profile["email"]); ?></p>
                                    </div>
                                    <div class="col-3">
                                        <h4>Gender</h4>
                                        <p><?php safe_echo($profile["gender"]); ?></p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-4">
                                        <h4>Join Date</h4>
                                        <p><?php safe_echo($profile["join_date"]); ?></p>
                                    </div>
                                    <div class="col-8">
                                        <h4>Bio</h4>
                                        <p><?php safe_echo($profile["bio"]); ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <br/>
                                    <?php if ($current_user_id === $user_id) { ?>
                                        <div class="col-12 form-group card_area align-items-center text-center">
                                            <button type="submit" name="selling_submit" class="btn info-btn">
                                                <a href="edit_profile.php">Edit Profile</a>
                                            </button>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <h2>Profile not found.</h2>
                        <br/><br/><br/>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Misc Section -->
<?php if ($profile !== NULL) { ?>
    <section class="product_description_area section_gap">
        <div class="container">
            <ul class="nav nav-tabs" id="item-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="listing-tab" data-toggle="tab" href="#listing" role="tab"
                       aria-controls="listing" aria-selected="true">
                        All Listings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab"
                       aria-controls="review" aria-selected="false">
                        Reviews
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="item-tabs-content">
                <div class="tab-pane fade show active" id="listing" role="tabpanel" aria-labelledby="listing-tab">
                    <h3 class="text-center">All Listings</h3>
                    <br/>
                    <div class="progress-table-wrap">
                        <div class="progress-table user bg-white">
                            <div class="table-row"></div>
                            <div class="table-head">
                                <div class="col-md-3 name text-center">
                                    Image
                                </div>
                                <div class="col-md-3 name text-center">
                                    Product Name
                                </div>
                                <div class="col-md-2 name text-center">
                                    Price
                                </div>
                                <div class="col-md-2 actions text-center">
                                    Status
                                </div>
                                <div class="col-md-2 actions text-center">
                                    Actions
                                </div>
                            </div>
                            <?php
                            foreach ($profiles_listings as $list) {
                                if ($list["status"] === 1) {
                                    if ($current_user_id === $user_id) {
                            ?>
                            <div class="table-row bg-light">
                                <figure class="col-md-3">
                                    <img src="<?php safe_echo($list['url']) ?>" class="img-thumbnail"
                                         width="175"
                                         height="175">
                                </figure>
                                <div class="col-md-3 name text-center">
                                    <?php safe_echo($list["title"]); ?>
                                </div>
                                <div class="col-md-2 name text-center">
                                    $<?php safe_echo($list["price"]); ?>
                                </div>
                                <div class="col-md-2 name text-center">
                                    Sold
                                </div>
                                <div class="col-md-2 name text-center">
                                    <button type="button" class="genric-btn danger mr-1">Delete</button>
                                </div>
                            </div>
                            <?php
                                    } // if.
                                } else {
                            ?>
                            <div class="table-row">
                                <figure class="col-md-3">
                                    <img src="<?php safe_echo($list['url']) ?>" class="img-thumbnail"
                                         width="175"
                                         height="175">
                                </figure>
                                <div class="col-md-3 name text-center">
                                    <?php safe_echo($list["title"]); ?>
                                </div>
                                <div class="col-md-2 name text-center">
                                    $<?php safe_echo($list["price"]); ?>
                                </div>
                                <div class="col-md-2 name text-center">
                                    Available
                                </div>
                                <div class="col-md-2 name text-center">
                                    <a class="genric-btn info mr-1" href="item.php?id=<?php safe_echo($list["id"]); ?>">View</a>
                                </div>
                            </div>
                            <?php
                                } // if-else.
                            } // foreach.
                            ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <h3 class="text-center">Reviews Listings</h3>
                    <br/>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row total_rate">
                                <div class="col-6">
                                    <div class="box_total">
                                        <h5>Overall</h5>
                                        <?php
                                        echo '<h4>' . (!empty($review_scores) ? (round(array_sum($review_scores) / count($review_scores), 2)) : '-') . '</h4>';
                                        echo '<h6>(' . (!empty($review_scores) ? sizeof($review_scores) : '0') . ' Reviews)</h6>'; ?>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="rating_list">
                                        <?php
                                        echo '<h3>Based on ' . sizeof($review_scores) . ' Reviews</h3>';
                                        $review_counts = array_count_values($review_scores); ?>
                                        <ul class="list">
                                            <li>5 Star <label class="fa fa-star fa-star-f"></label><label
                                                        class="fa fa-star fa-star-f"></label><label
                                                        class="fa fa-star fa-star-f"></label><label
                                                        class="fa fa-star fa-star-f"></label><label
                                                        class="fa fa-star fa-star-f"></label> <?php echo isset($review_counts['5']) ? $review_counts['5'] : '0'; ?>
                                            </li>
                                            <li>4 Star <label class="
                                            fa fa-star fa-star-f"></label><label
                                                        class="fa fa-star fa-star-f"></label><label
                                                        class="fa fa-star fa-star-f"></label><label
                                                        class="fa fa-star fa-star-f"></label><label
                                                        class="fa fa-star fa-star-b"></label> <?php echo isset($review_counts['4']) ? $review_counts['4'] : '0'; ?>
                                            </li>
                                            <li>3 Star <label class="fa fa-star fa-star-f"></label><label
                                                        class="fa fa-star fa-star-f"></label><label
                                                        class="fa fa-star fa-star-f"></label><label
                                                        class="fa fa-star fa-star-b"></label><label
                                                        class="fa fa-star fa-star-b"></label> <?php echo isset($review_counts['3']) ? $review_counts['3'] : '0'; ?>
                                            </li>
                                            <li>2 Star <label class="fa fa-star fa-star-f"></label><label
                                                        class="fa fa-star fa-star-f"></label><label
                                                        class="fa fa-star fa-star-b"></label><label
                                                        class="fa fa-star fa-star-b"></label><label
                                                        class="fa fa-star fa-star-b"></label> <?php echo isset($review_counts['2']) ? $review_counts['2'] : '0'; ?>
                                            </li>
                                            <li>1 Star <label class="fa fa-star fa-star-f"></label><label
                                                        class="fa fa-star fa-star-b"></label><label
                                                        class="fa fa-star fa-star-b"></label><label
                                                        class="fa fa-star fa-star-b"></label><label
                                                        class="fa fa-star fa-star-b"></label> <?php echo isset($review_counts['1']) ? $review_counts['1'] : '0'; ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="review_list">
                                <?php
                                if (isset($reviews) === TRUE && empty($reviews) === FALSE) {
                                    foreach ($reviews as $review) { ?>
                                        <div class="review_item">
                                            <div class="media">
                                                <div class="d-flex">
                                                    <?php echo '<img class="rounded-circle review-profile-pic" src="'
                                                        . $review["seller_profile_pic"] .
                                                        '" alt="' . $review["seller_name"] . ' Profile Image">'; ?>
                                                </div>

                                                <div class="media-body">
                                                    <?php
                                                    echo '<h4>' . $review["seller_name"] . '</h4>';
                                                    for ($i = 0; $i < $review["rating"]; $i++) {
                                                        echo '<label class="fa fa-star fa-star-f">';
                                                    }
                                                    for ($i = 0; $i < (5 - $review["rating"]); $i++) {
                                                        echo "<label class=\"fa fa-star fa-star-b\">";
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <?php echo '<p>' . $review["description"] ?>
                                        </div>
                                    <?php }
                                } ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <?php if ($current_user_id !== $user_id) { ?>
                            <div class="review_box">
                                <h4>Add a Review</h4>
                                <form class="row contact_form" action="profile.php" method="post" id="reviewForm"
                                      novalidate="novalidate">
                                    <p>Your Rating:</p>
                                    <fieldset class="rating">
                                        <input type="radio" id="star5" name="rating" value="5" checked/><label
                                                class="full" for="star5" title="Outstanding - 5 stars"></label>
                                        <input type="radio" id="star4half" name="rating" value="4.5"/><label
                                                class="half" for="star4half" title="Outstanding - 4.5 stars"></label>
                                        <input type="radio" id="star4" name="rating" value="4"/><label class="full"
                                                                                                       for="star4"
                                                                                                       title="Good - 4 stars"></label>
                                        <input type="radio" id="star3half" name="rating" value="3.5"/><label
                                                class="half" for="star3half" title="Good - 3.5 stars"></label>
                                        <input type="radio" id="star3" name="rating" value="3"/><label class="full"
                                                                                                       for="star3"
                                                                                                       title="Decent - 3 stars"></label>
                                        <input type="radio" id="star2half" name="rating" value="2.5"/><label
                                                class="half" for="star2half" title="Decent - 2.5 stars"></label>
                                        <input type="radio" id="star2" name="rating" value="2"/><label class="full"
                                                                                                       for="star2"
                                                                                                       title="Fair - 2 stars"></label>
                                        <input type="radio" id="star1half" name="rating" value="1.5"/><label
                                                class="half" for="star1half" title="Fair - 1.5 stars"></label>
                                        <input type="radio" id="star1" name="rating" value="1"/><label class="full"
                                                                                                       for="star1"
                                                                                                       title="Poor - 1 star"></label>
                                        <input type="radio" id="starhalf" name="rating" value="0.5"/><label class="half"
                                                                                                            for="starhalf"
                                                                                                            title="Poor - 0.5 stars"></label>
                                    </fieldset>
                                    <!--
                                                                        <ul class="list">
                                                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                                        </ul>
                                                                        <p>Outstanding</p>
                                    -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea class="form-control" name="description" id="description" rows="1"
                                                      placeholder="Review"
                                                      onfocus="if (!window.__cfRLUnblockHandlers) return false; this.placeholder = ''"
                                                      onblur="if (!window.__cfRLUnblockHandlers) return false; this.placeholder = 'Review'"></textarea>
                                            <!--                                            <input type="text" name="description" placeholder="Review" />-->
                                        </div>
                                    </div>
                                    <input type="text" name="sellerId"
                                           value="<?php echo isset($_GET['id']) ? (int)($_GET['id']) : '' ?>" hidden/>
                                    <div class="col-md-12 text-right">
                                        <button type="submit" value="submit" class="primary-btn">Submit Now</button>
                                    </div>
                                </form>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<?php
if (isset($review_status) && $review_status === TRUE) {
    echo '<script type="text/javascript">
                notify("Review Added.", "success");
            </script>';
} ?>

<!-- End Misc Section-->

<!-- Footer -->
<?php require_once("serverside/templates/footer.php"); ?>
<!-- End Footer -->

<?php require_once("serverside/templates/html.js.php"); ?>
<script>
    $(document).ready(function () {
        console.log("ready!!");
        $("#reviewForm").on('submit', function (e) {
            console.log("in");
            e.preventDefault();
            var rating = $('input[name=rating]').val();
            var description = $('#description').val();
            var sellerId = $('#sellerId').val();

            $.ajax({
                type: 'post',
                url: 'profile.php',
                data: $('#reviewForm').serialize(),
                success: function () {
                    notify('Review Added!!!', 'success');
                }
            });
        });
    });
</script>
</body>
</html>
