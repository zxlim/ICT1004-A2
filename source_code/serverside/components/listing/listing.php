<?php
##############################
# listing.php
# Logic for processing listings.
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

// Set default category to id:1.
$selected_cat_id = 1;
$selected_cat_name = NULL;

$results_categories = array();
$results_listings = array();

if (isset($_GET["id"]) && validate_int($_GET["id"])) {
	$selected_cat_id = (int)($_GET["id"]);
}

$sql_categories = "SELECT id, name FROM category ORDER BY id";
$sql_listings = "SELECT listing.id, listing.title, listing.price, picture.id FROM listing LEFT JOIN picture ON listing.id = picture.listing_id WHERE NOT EXISTS (SELECT offer.id FROM offer WHERE offer.listing_id = listing.id AND offer.accepted != 1) AND listing.category_id = ? AND DATE(listing.show_until) > ? GROUP BY listing.id ORDER BY listing.id";

$conn = get_conn();

if ($query = $conn->prepare($sql_categories)) {
	$query->execute();
	$query->bind_result($id, $name);

	while ($query->fetch()) {
		$data = array(
			"id" => (int)($id),
			"name" => $name,
		);

		if ($selected_cat_id === (int)($id)) {
			$selected_cat_name = $name;
		}

		array_push($results_categories, $data);
	}
	$query->close();
}

if (isset($selected_cat_name)) {
	$current_dt = get_datetime(TRUE);
	
	if ($query = $conn->prepare($sql_listings)) {
		$query->bind_param("is", $selected_cat_id, $current_dt);
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
			array_push($results_listings, $data);
		}
		$query->close();
	}
}

$conn->close();
