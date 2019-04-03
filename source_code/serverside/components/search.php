<?php
##############################
# search.php
# Logic for processing search queries.
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

$results_listings = array();
$search_query = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	if (validate_notempty($_POST["search_query"]) === FALSE) {
		header("Location: index.php");
	} else {
		$current_dt = get_datetime(TRUE);
		$search_query = html_safe($_POST["search_query"], TRUE);
		$wild_search = "%" . $search_query . "%";

		$sql = "SELECT l.id, l.title, l.price, l.tags, u.name, p.url
		FROM listing AS l
		INNER JOIN user AS u ON l.seller_id = u.id
		LEFT JOIN picture AS p ON l.id = p.listing_id
		WHERE l.sold = 0
		AND DATE(l.show_until) > ?
		AND (title LIKE ? OR tags LIKE ?)
		GROUP BY l.id
		ORDER BY l.view_counts DESC";

		$conn = get_conn();

		if ($query = $conn->prepare($sql)) {
			$query->bind_param("sss", $current_dt, $wild_search, $wild_search);
			$query->execute();
			$query->bind_result($id, $title, $price, $tags, $user_name, $picture_url);

			while ($query->fetch()) {
				if ($picture_url === NULL) {
					$picture_url = "static/img/default/listing.jpg";
				}

				$row = array(
					"id" => (int)($id),
					"title" => $title,
					"tags" => $tags,
					"price" => (float)($price),
					"user_name" => $user_name,
					"picture" => $picture_url
				);

				array_push($results_listings, $row);
			}

			$query->close();
		}

		$conn->close();
	}
} else {
	header("HTTP/1.1 405 Method Not Allowed");
	header("Location: index.php");
}
