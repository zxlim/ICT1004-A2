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
$chat_with = NULL;
$sender_id = $_SESSION["user_id"];

$sql_item = "SELECT listing.id, listing.title, listing.price,
category.id, category.name, user.id, user.name
FROM listing
INNER JOIN category ON listing.category_id = category.id
INNER JOIN user ON listing.seller_id = user.id
INNER JOIN conversation ON listing.id = conversation.listing_id
WHERE conversation.id = ?
AND (conversation.user1 = ? OR conversation.user2 = ?)
GROUP BY listing.id";

$sql_receiver = "SELECT user.name
FROM user
INNER JOIN message ON user.id = message.sender_id
INNER JOIN conversation ON message.conversation = conversation.id
WHERE conversation.id = ?
AND message.sender_id != ?
GROUP BY conversation.id";

$conn = get_conn();
$current_dt = get_datetime(TRUE);

if ($query = $conn->prepare($sql_item)) {
	$query->bind_param("iii", $convo_id, $sender_id, $sender_id);
	$query->execute();
	$query->bind_result($id, $title, $price, $cat_id, $cat_name, $user_id, $user_name);

	if ($query->fetch()) {
		$item = array(
			"id" => (int)($id),
			"title" => $title,
			"price" => (float)($price),
			"cat_id" => (int)($cat_id),
			"cat_name" => $cat_name,
			"user_id" => (int)($user_id),
			"user_name" => $user_name,
		);
	}

	$query->close();
}

if ($item !== NULL) {
	if ($query = $conn->prepare($sql_receiver)) {
		$query->bind_param("ii", $convo_id, $sender_id);
		$query->execute();
		$query->bind_result($receiver_name);

		if ($query->fetch()) {
			$chat_with = $receiver_name;
		} else {
			$chat_with = $item["user_name"];
		}

		$query->close();
	}
}

$conn->close();
