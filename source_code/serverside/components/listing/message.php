<?php
##############################
# message.php
# Logic for messaging between users
# regarding a particular item listing.
##############################

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

require_once("serverside/functions/validation.php");
require_once("serverside/functions/database.php");

if (isset($_GET["id"]) && validate_int($_GET["id"])) {
	$item_id = (int)($_GET["id"]);
} else {
	header("Location: listing.php");
}

$item = NULL;

$sql_item = "SELECT listing.id, listing.title, listing.description, listing.tags,
listing.price, listing.condition, listing.item_age, listing.meetup_location, picture.id,
category.id, category.name, user.id, user.name, user.join_date, user.bio, user_picture.id
FROM listing
INNER JOIN category ON listing.category_id = category.id
INNER JOIN user ON listing.seller_id = user.id
LEFT JOIN picture ON listing.id = picture.listing_id
LEFT JOIN user_picture ON user.id = user_picture.user_id
WHERE listing.id = ?
GROUP BY listing.id";

$sql_pictures = "SELECT id FROM picture WHERE listing_id = ?";

$conn = get_conn();
$current_dt = get_datetime(TRUE);

if ($query = $conn->prepare($sql_item)) {
	$query->bind_param("i", $item_id);
	$query->execute();
	$query->bind_result(
		$id, $title, $description, $tags, $price, $condition, $item_age, $meetup_location, $picture_id,
		$cat_id, $cat_name, $user_id, $user_name, $user_join_date, $user_bio, $user_pic_id
	);

	if ($query->fetch()) {
		$picture = "static/img/default/listing.jpg";
		$user_picture = "static/img/default/user.jpg";

		if ($user_pic_id !== NULL) {
			$user_picture = sprintf("image.php?id=%d&type=u", $user_pic_id);
		}

		if ($picture_id !== NULL) {
			$picture = sprintf("image.php?id=%d", $picture_id);
		}

		$item = array(
			"id" => (int)($id),
			"title" => $title,
			"description" => $description,
			"tags" => $tags,
			"price" => (float)($price),
			"condition" => (int)($condition),
			"item_age" => (int)($item_age),
			"meetup_location" => $meetup_location,
			"cat_id" => (int)($cat_id),
			"cat_name" => $cat_name,
			"user_id" => (int)($user_id),
			"user_name" => $user_name,
			"user_join_date" => date("M Y", strtotime($user_join_date)),
			"user_bio" => $user_bio,
			"user_pic" => $user_picture,
			"picture" => $picture,
		);
	}

	$query->close();
}

$conn->close();
