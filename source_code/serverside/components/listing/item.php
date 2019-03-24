<?php
##############################
# item.php
# Logic for processing item.
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
	header("Location: listing.php?cat=1");
}

$item = NULL;
$sql_item = "SELECT listing.id, listing.title, listing.description, listing.price, listing.tags, category.id, category.name, user.id, user.name FROM listing INNER JOIN category ON listing.category_id = category.id INNER JOIN user ON listing.seller_id = user.id WHERE listing.id=?";

$conn = get_conn();

if ($query = $conn->prepare($sql_item)) {
	$query->bind_param("i", $item_id);
	$query->execute();
	$query->bind_result($id, $title, $description, $price, $tags, $cat_id, $cat_name, $user_id, $user_name);

	if ($query->fetch()) {
		$item = array(
			"id" => (int)($id),
			"title" => $title,
			"description" => $description,
			"price" => $price,
			"tags" => $tags,
			"cat_id" => $cat_id,
			"cat_name" => $cat_name,
			"user_id" => $user_id,
			"user_name" => $user_name,
		);
	}
	$query->close();
}

$conn->close();
