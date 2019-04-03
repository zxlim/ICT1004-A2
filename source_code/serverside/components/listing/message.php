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

if (isset($_GET["id"]) && validate_int($_GET["id"]) && $session_is_admin === FALSE) {
	$convo_id = (int)($_GET["id"]);
} else {
	header("Location: listing.php");
}

$item = NULL;
$chat_with = NULL;
$sender_id = (int)($_SESSION["user_id"]);

$sql_item = "SELECT l.id, l.title, l.price, c.id, c.name, u.id, u.name
FROM listing AS l
INNER JOIN category AS c ON l.category_id = c.id
INNER JOIN user AS u ON l.seller_id = u.id
INNER JOIN conversation AS cv ON l.id = cv.listing_id
WHERE cv.id = ?
AND (cv.user1 = ? OR cv.user2 = ?)
GROUP BY l.id";

$sql_receiver = "SELECT u.name
FROM user AS u
INNER JOIN message AS m ON u.id = m.sender_id
INNER JOIN conversation AS cv ON m.conversation = cv.id
WHERE cv.id = ?
AND m.sender_id != ?
GROUP BY cv.id";

$conn = get_conn();

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
