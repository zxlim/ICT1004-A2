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
	header("Location: listing.php");
}

if ($session_is_authenticated === TRUE) {
	$current_user_id = (int)($_SESSION["user_id"]);
}

$item = NULL;
$related_items = array();
$related_seller_items = array();

$sql_item = "SELECT l.id, l.title, l.description, l.tags,
l.price, l.item_condition, l.item_age, l.show_until, l.sold,
loc.stn_code, loc.stn_name, loc.stn_line,
c.id, c.name, u.id, u.name, u.join_date, u.bio, u.profile_pic
FROM listing AS l
INNER JOIN locations AS loc ON l.meetup_location = loc.id
INNER JOIN category AS c ON l.category_id = c.id
INNER JOIN user AS u ON l.seller_id = u.id
WHERE l.id = ?";

$sql_viewcount = "UPDATE listing
SET view_counts = (view_counts + 1)
WHERE id = ?";

$sql_related_listings = "SELECT l.id, l.title, l.price, p.url
FROM listing AS l
LEFT JOIN picture AS p ON l.id = p.listing_id
WHERE l.sold = 0
AND l.id != ?
AND DATE(l.show_until) > ?
AND l.category_id = ?
GROUP BY l.id
ORDER BY l.view_counts DESC LIMIT 9";

$sql_seller_listings = "SELECT l.id, l.title, l.price, p.url
FROM listing AS l
LEFT JOIN picture AS p ON l.id = p.listing_id
WHERE l.sold = 0
AND l.seller_id = ?
AND l.id != ?
AND DATE(l.show_until) > ?
GROUP BY l.id
ORDER BY l.id DESC LIMIT 4";

$sql_pictures = "SELECT url FROM picture WHERE listing_id = ?";

$conn = get_conn();
$current_dt = get_datetime(TRUE);

if ($query = $conn->prepare($sql_item)) {
	$query->bind_param("i", $item_id);
	$query->execute();
	$query->bind_result(
		$id, $title, $description, $tags, $price, $condition, $item_age, $show_until, $sold,
		$meetup_code, $meetup_name, $meetup_line,
		$cat_id, $cat_name, $user_id, $user_name, $user_join_date, $user_bio, $user_picture
	);

	if ($query->fetch()) {
		if (strtotime($show_until) > strtotime($current_dt) || (bool)($sold) === FALSE || ($current_user_id === (int)($user_id))) {
			if ($user_picture === NULL) {
				$user_picture = "static/img/default/user.jpg";
			}

			if ($meetup_code === NULL) {
				$meetup_location = $meetup_name;
			} else {
				$meetup_location = sprintf("%s, %s (%s)", $meetup_line, $meetup_name, $meetup_code);
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
	}

	$query->close();
}

if (isset($item) === TRUE) {
	if ($query = $conn->prepare($sql_viewcount)) {
		// Increment view count.
		$query->bind_param("i", $item["id"]);
		$query->execute();
		$query->close();
	}

	if ($query = $conn->prepare($sql_pictures)) {
		$query->bind_param("i", $item["id"]);
		$query->execute();
		$query->bind_result($picture_url);

		while ($query->fetch()) {
			array_push($item["picture"], $picture_url);
		}

		$query->close();
	}

	if (sizeof($item["picture"]) === 0) {
		array_push($item["picture"], "static/img/default/listing.jpg");
	}

	if ($query = $conn->prepare($sql_related_listings)) {
		$query->bind_param("isi", $item["id"], $current_dt, $item["cat_id"]);
		$query->execute();
		$query->bind_result($id, $title, $price, $picture_url);

		while ($query->fetch()) {
			if ($picture_url === NULL) {
				$picture_url = "static/img/default/listing.jpg";
			}

			$data = array(
				"id" => (int)($id),
				"title" => $title,
				"price" => (float)($price),
				"picture" => $picture_url,
			);

			array_push($related_items, $data);
		}

		$query->close();
	}

	if ($query = $conn->prepare($sql_seller_listings)) {
		/* Get the other listings by the seller. */
		$query->bind_param("isi", $item["user_id"], $item["id"], $current_dt);
		$query->execute();
		$query->bind_result($id, $title, $price, $picture_url);

		while ($query->fetch()) {
			if ($picture_url === NULL) {
				$picture_url = "static/img/default/listing.jpg";
			}

			$data = array(
				"id" => (int)($id),
				"title" => $title,
				"price" => (float)($price),
				"picture" => $picture_url,
			);

			array_push($related_seller_items, $data);
		}

		$query->close();
	}

	if ($session_is_authenticated === TRUE) {
		if ($current_user_id === (int)($item["user_id"])) {
			$convo_link = "message_list.php";
		} else {
			$convo_id = NULL;
			$sql_convo = "SELECT id FROM conversation WHERE listing_id = ? AND (user1 = ? OR user2 = ?)";
			$sql_convo_create = "INSERT INTO conversation (listing_id, user1, user2) VALUES (?, ?, ?)";
			
			if ($query = $conn->prepare($sql_convo)) {
				$query->bind_param("iii", $item["id"], $current_user_id, $current_user_id);
				$query->execute();
				$query->bind_result($id);

				if ($query->fetch()) {
					$convo_id = $id;
				}

				$query->close();
			}

			if ($convo_id === NULL) {
				if ($query = $conn->prepare($sql_convo_create)) {
					$query->bind_param("iii", $item["id"], $item["user_id"], $current_user_id);
					$query->execute();
					$convo_id = $query->insert_id;
					$query->close();
				}
			}

			$convo_link = sprintf("message.php?id=%d", $convo_id);
		}
	} else {
		$current_user_id = NULL;
		$convo_link = "login.php";
	}
}

$conn->close();
