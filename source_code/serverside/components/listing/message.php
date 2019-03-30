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
	$convo_id = (int)($_GET["id"]);
} else {
	header("Location: listing.php");
}

$item = NULL;

$sql_item = "SELECT listing.id, listing.title, listing.description, listing.tags,
listing.price, listing.condition, listing.item_age, listing.meetup_location,
category.id, category.name, user.id, user.name
FROM listing
INNER JOIN category ON listing.category_id = category.id
INNER JOIN user ON listing.seller_id = user.id
INNER JOIN conversation ON listing.id = conversation.listing_id
WHERE conversation.id = ?
GROUP BY listing.id";

$conn = get_conn();
$current_dt = get_datetime(TRUE);

if ($query = $conn->prepare($sql_item)) {
	$query->bind_param("i", $convo_id);
	$query->execute();
	$query->bind_result(
		$id, $title, $description, $tags, $price, $condition, $item_age, $meetup_location,
		$cat_id, $cat_name, $user_id, $user_name
	);

	if ($query->fetch()) {

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
		);
	}

	$query->close();
}

$conn->close();

$sender_id = $_SESSION["user_id"];
