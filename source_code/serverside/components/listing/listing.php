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
$selected_cat_name = "Default Category";

$results_categories = array();
$results_listings = array();

if (isset($_GET["cat"]) && validate_int($_GET["cat"])) {
	$selected_cat_id = (int)($_GET["cat"]);
}

$sql_categories = "SELECT id, name FROM category ORDER BY id";
$sql_listings = "SELECT id, title, price FROM listing WHERE NOT EXISTS (SELECT id FROM offer WHERE listing_id = listing.id AND accepted != 1) AND category_id=? ORDER BY id";

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

if ($query = $conn->prepare($sql_listings)) {
	$query->bind_param("i", $selected_cat_id);
	$query->execute();
	$query->bind_result($id, $title, $price);

	while ($query->fetch()) {
		$data = array(
			"id" => (int)($id),
			"title" => $title,
			"price" => (float)($price),
		);
		array_push($results_listings, $data);
	}
	$query->close();
}

$conn->close();
