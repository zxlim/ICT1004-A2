<?php
if (defined("CLIENT") === FALSE) {
    /**
     * Ghetto way to prevent direct access to "include" files.
     */
    http_response_code(404);
    die();
}

require_once("serverside/functions/validation.php");
require_once("serverside/functions/database.php");

if ($session_is_admin === TRUE) {
    // No admins allowed here.
    header("Location: index.php");
    die(); // Prevent further execution of PHP code.
}

if (isset($_GET['id']) === TRUE && validate_int($_GET['id']) === TRUE) {
    $user_id = (int)($_GET['id']);
} else if (session_isauth() === TRUE) {
    $user_id = $_SESSION["user_id"];
} else {
    // Default profile.
    $user_id = 1;
}

// DB Conn Part
$conn = get_conn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error_review = FALSE;

    if (validate_notempty($_POST["rating"]) == FALSE) {
        $error_review = TRUE;
    } else {
        $sql_addreview = "INSERT INTO review (buyer_id, seller_id, datetime, rating, description)
        VALUES (?, ?, ?, ?, ?)";
        $date = date('Y-m-d H:i:s');

        if ($query = $conn->prepare($sql_addreview)) {
            $query->bind_param("iisis", $user_id, $_POST["sellerId"], $date, $_POST["rating"], $_POST["description"]);
            $review_status = $query->execute();

            $query->close();
        }
    }
}

// Profile Page
$profile = NULL;
$sql_profiles = "SELECT id, name, email, join_date, gender, bio, profile_pic, admin FROM user WHERE id = ?";

// Profile Page
if ($query = $conn->prepare($sql_profiles)) {
    $query->bind_param("i", $user_id);
    $query->execute();
    $query->bind_result($id, $name, $email, $join_date, $gender, $bio, $profile_pic, $admin);

    if ($query->fetch()) {
        if ((bool)($admin) === FALSE) {
            $profile = array(
                "id" => (int)$id,
                "name" => $name,
                "email" => $email,
                "join_date" => $join_date,
                "gender" => $gender,
                "bio" => $bio,
                "profile_pic" => $profile_pic
            );
        }
    }

    $query->close();
}


// Profiles Listing
$profiles_listings = array();
$sql_listings = "SELECT picture.url, listing.title, listing.price, listing.sold FROM listing 
INNER JOIN picture on picture.listing_id = listing.id
WHERE listing.seller_id = ?
GROUP BY listing.id";

if ($query = $conn->prepare($sql_listings)) {
    $query->bind_param("i", $user_id);
    $query->execute();
    $query->bind_result($url, $title, $price, $status);

    while ($query->fetch()) {
        if ((bool)($admin) === FALSE) {
            $data = array(
                "url" => $url,
                "title" => $title,
                "price" => $price,
                "status" => $status
            );
            array_push($profiles_listings, $data);
        }
    }
    $query->close();
}

// User's reviews
$reviews = array();
$review_scores = array();

$sql_reviews = "SELECT r.id, r.buyer_id, r.seller_id, r.datetime, r.rating, r.description, u.name, u.profile_pic 
    FROM review AS r 
    INNER JOIN user AS u 
    ON r.buyer_id = u.id 
    WHERE r.seller_id = ?";

if ($query = $conn->prepare($sql_reviews)) {
    $query->bind_param("i", $user_id);
    $query->execute();
    $query->bind_result($id, $buyer_id, $seller_id, $datetime, $rating, $description, $seller_name, $seller_profile_pic);

    while ($query->fetch()) {
        $data = array(
            "id" => (int)($id),
            "buyer_id" => (int)($buyer_id),
            "seller_id" => (int)($seller_id),
            "datetime" => $datetime,
            "rating" => $rating,
            "description" => $description,
            "seller_name" => $seller_name,
            "seller_profile_pic" => $seller_profile_pic
        );

        array_push($reviews, $data);
        array_push($review_scores, $rating);
    }

    $query->close();
}


$conn->close();