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
$related_items = array();
$related_seller_items = array();

$sql_item = "SELECT listing.id, listing.title, listing.description, listing.tags, listing.price, listing.condition, listing.item_age, listing.meetup_location, category.id, category.name, user.id, user.name, user.join_date, user.bio, user_picture.id FROM listing INNER JOIN category ON listing.category_id = category.id INNER JOIN user ON listing.seller_id = user.id LEFT JOIN user_picture ON user.id = user_picture.user_id WHERE listing.id = ?";

$sql_listings = "SELECT listing.id, listing.title, listing.price, picture.id FROM listing LEFT JOIN picture ON listing.id = picture.listing_id WHERE NOT EXISTS (SELECT offer.id FROM offer WHERE offer.listing_id = listing.id AND offer.accepted != 1) AND listing.category_id = ? AND DATE(listing.show_until) > ? AND listing.id != ? GROUP BY listing.id ORDER BY listing.view_counts DESC LIMIT 3";

$sql_seller_listings = "SELECT listing.id, listing.title, listing.price, picture.id FROM listing LEFT JOIN picture ON listing.id = picture.listing_id WHERE NOT EXISTS (SELECT offer.id FROM offer WHERE offer.listing_id = listing.id AND offer.accepted != 1) AND listing.seller_id = ? AND DATE(listing.show_until) > ? AND listing.id != ? GROUP BY listing.id ORDER BY listing.id DESC LIMIT 4";

$sql_pictures = "SELECT id FROM picture WHERE listing_id = ?";

$conn = get_conn();
$current_dt = get_datetime(TRUE);

if ($query = $conn->prepare($sql_item)) {
	$query->bind_param("i", $item_id);
	$query->execute();
	$query->bind_result(
		$id, $title, $description, $tags, $price, $condition, $item_age, $meetup_location,
		$cat_id, $cat_name, $user_id, $user_name, $user_join_date, $user_bio, $user_pic_id
	);

	if ($query->fetch()) {
		$user_picture = "static/img/default/user.jpg";

		if ($user_pic_id !== NULL) {
			$user_picture = sprintf("image.php?id=%d&type=u", $user_pic_id);
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
			"picture" => array(),
		);
	}

	$query->close();
}

if (isset($item) === TRUE) {
	if ($query = $conn->prepare($sql_pictures)) {
		$query->bind_param("i", $item["id"]);
		$query->execute();
		$query->bind_result($picture_id);

		while ($query->fetch()) {
			array_push($item["picture"], sprintf("image.php?id=%d", $picture_id));
		}

		$query->close();
	}

	if (sizeof($item["picture"]) === 0) {
		array_push($item["picture"], "static/img/default/listing.jpg");
	}

	if ($query = $conn->prepare($sql_listings)) {
		$query->bind_param("isi", $item["cat_id"], $current_dt, $item["id"]);
		$query->execute();
		$query->bind_result($id, $title, $price, $picture_id);

		while ($query->fetch()) {
			$picture = "static/img/default/listing.jpg";

			if ($picture_id !== NULL) {
				$picture = sprintf("image.php?id=%d", $picture_id);
			}

			$data = array(
				"id" => (int)($id),
				"title" => $title,
				"price" => (float)($price),
				"picture" => $picture,
			);

			array_push($related_items, $data);
		}

		$query->close();
	}

	if ($query = $conn->prepare($sql_seller_listings)) {
		$query->bind_param("isi", $item["user_id"], $current_dt, $item["id"]);
		$query->execute();
		$query->bind_result($id, $title, $price, $picture_id);

		while ($query->fetch()) {
			$picture = "static/img/default/listing.jpg";

			if ($picture_id !== NULL) {
				$picture = sprintf("image.php?id=%d", $picture_id);
			}

			$data = array(
				"id" => (int)($id),
				"title" => $title,
				"price" => (float)($price),
				"picture" => $picture,
			);

			array_push($related_seller_items, $data);
		}

		$query->close();
	}
}

$conn->close();
