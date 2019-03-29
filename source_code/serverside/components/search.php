<?php
##############################
# search.php
# Logic for processing search queries.
##############################

if (defined("CLIENT") === FALSE) {
    /**
     * Ghetto way to prevent direct access to "include" files.
     */
    http_response_code(404);
    die();
}

require_once("serverside/functions/database.php");

$results_listings = array();

$sql_search_result = "SELECT listing.id, listing.title, listing.price, listing.tags, user.name, picture.id FROM listing INNER JOIN user ON listing.seller_id = user.id LEFT JOIN picture ON listing.id = picture.listing_id WHERE NOT EXISTS (SELECT offer.id FROM offer WHERE offer.listing_id = listing.id AND offer.accepted != 1) AND DATE(listing.show_until) > ? AND title LIKE ? OR tags LIKE ? GROUP BY listing.id ORDER BY listing.id";
$conn = get_conn();

if (isset($_POST['search_query'])) {
    $current_dt = get_datetime(TRUE);
    $search_query = $_POST['search_query'];
    $wild_search = "%" . $search_query . "%";

    if ($query = $conn->prepare($sql_search_result)) {
        $query->bind_param("sss", $current_dt,$wild_search, $wild_search);
        $query->execute();
        $query->bind_result($id, $title, $price, $tags, $user_name, $picture_id);

        while ($query->fetch()) {
            $picture = "static/img/default/listing.jpg";

            if ($picture_id !== NULL) {
                $picture = sprintf("image.php?id=%d", $picture_id);
            }

//            $tags_handler = explode(",", $tags);
//            array_push($tags_data, $tags_handler);

            $data = array(
                "id" => (int)$id,
                "title" => $title,
                "tags" => $tags,
                "price" => (float)($price),
                "user_name" => $user_name,
                "picture" => $picture
            );
            array_push($results_listings, $data);
        }
        $query->close();
    }
}
