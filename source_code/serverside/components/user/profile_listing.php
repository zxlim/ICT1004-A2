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

if (!$session_is_authenticated === True) {
    header("Location: login.php");
    exit;
}

if ($session_is_authenticated === TRUE) {
    $current_user_id = (int)($_SESSION["user_id"]);
}


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $error_review = FALSE;
    
    if (validate_notempty($_POST["rating"]) == FALSE){
        $error_review = TRUE;
    } else {
        
        $conn = get_conn();
        $sql_addreview = "INSERT INTO review (buyer_id, seller_id, datetime, rating, description)
        VALUES (?, ?, ?, ?, ?)";
        $date = date('Y-m-d H:i:s');
        
        if ($query = $conn->prepare($sql_addreview)) {
//            if ($query->execute()){
//                $review_status = true;
//            } else {
//                $review_status = false;
//            }
            $query->bind_param("iisis", $current_user_id, $_POST["sellerId"], $date, $_POST["rating"], $_POST["description"]);
            $review_status = $query->execute();
            
            $query->close();
        }
// STOPPED HERE, NEED TO REDIRECT BACK SOMEHOW with GET PARAMETERS
//        header('Location: '.$_SERVER['REQUEST_URI']);
//        die();
    }
    
}

    if (isset($_GET['id']) === TRUE) {
        $user_id = $_GET['id'];
    } else if (session_isauth() === TRUE) {
        $user_id = $_SESSION["user_id"];
    } else {
        $user_id = 1;
    }

//    if (!$session_is_authenticated === True) {
//        header("Location: login.php");
//        exit;
//    }
//
//    if ($session_is_authenticated === TRUE) {
//        $current_user_id = (int)($_SESSION["user_id"]);
//    }

    

    // DB Conn Part
    $conn = get_conn();

    // User's reviews
    $reviews = array();
    $review_scores = array();
    $sql_reviews = "SELECT r.id, r.buyer_id, r.seller_id, r.datetime, r.rating, r.description, u.name, u.profile_pic 
    FROM review AS r 
    INNER JOIN user AS u 
    ON r.buyer_id = u.id 
    WHERE r.seller_id = ?";

    // This part is when the user click his own profile
    $own_profile_results = array();
    $own_profiles_sql = "SELECT user.id, user.name, user.email, user.join_date, user.gender, user.bio, user.profile_pic FROM user WHERE id = ?";
    #$sql = "SELECT admin from user WHERE loginid = '".$loginid."'";
    if ($query = $conn->prepare($own_profiles_sql)) {
        $query->bind_param("i", $user_id);
        $query->execute();
        $query->bind_result($id, $name, $email, $join_date, $gender, $bio, $profile_pic);

        while ($query->fetch()) {
            $data = array(
                "id" => (int)$id,
                "name" => $name,
                "email" => $email,
                "join_date" => $join_date,
                "gender" => $gender,
                "bio" => $bio,
                "profile_pic" => $profile_pic
            );
            array_push($own_profile_results, $data);
        }
        $query->close();
    }

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
?>