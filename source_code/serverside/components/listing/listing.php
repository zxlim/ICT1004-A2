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

// Set default category to id: 1.
$selected_cat_id = 1;
$selected_cat_name = NULL;

$results_categories = array();
$results_listings = array();

if (isset($_GET["id"]) && validate_int($_GET["id"])) {
	$selected_cat_id = (int)($_GET["id"]);
}

$sql_categories = "SELECT id, name FROM category ORDER BY id";

$sql_listings = "SELECT l.id, l.title, l.price, u.name, p.url
FROM listing AS l
INNER JOIN user AS u ON l.seller_id = u.id
LEFT JOIN picture AS p ON l.id = p.listing_id
WHERE l.category_id = ?
AND l.sold = 0
AND DATE(l.show_until) > ?
GROUP BY l.id
ORDER BY l.id";

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
		$query->bind_result($id, $title, $price, $user_name, $picture_url);

		while ($query->fetch()) {
			if ($picture_url === NULL) {
				$picture_url = "static/img/default/listing.jpg";
			}

			$data = array(
				"id" => (int)($id),
				"title" => $title,
				"price" => (float)($price),
				"user_name" => $user_name,
				"picture" => $picture_url,
			);
			array_push($results_listings, $data);
		}
		$query->close();
	}
}

$conn->close();
