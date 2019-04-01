<?php
##############################
# selling.php
# Logic for processing listing creation.
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

$error_image = $error_name = $error_desc = $error_date = $error_tags = "";
$error_price = $error_condition = $error_age = $error_cat = $error_loc = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	// POST request method.
	$error_create = FALSE;

	if (validate_notempty($_POST["images"], "array") === FALSE) {
		$error_create = TRUE;
		$error_image = "No image uploaded. Please upload at least one image.";
	} else {
		foreach ($_POST["images"] as $key => $url) {
			if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
				// Expected to receive URL but didn't.
				$error_create = TRUE;
				$error_image = "Invalid image data received. Please try again.";
			}
		}
	}

	if (validate_notempty($_POST["product_name"]) === FALSE) {
		$error_create = TRUE;
		$error_name = "Listing Name is required.";
	}

	if (validate_notempty($_POST["product_desc"]) === FALSE) {
		$error_create = TRUE;
		$error_desc = "Listing Description is required.";
	}

	if (validate_notempty($_POST["listing_expiry"]) === FALSE) {
		$error_create = TRUE;
		$error_date = "Listing Expiry is required.";
	} else if (date("Y/m/d", strtotime($_POST["listing_expiry"])) !== $_POST["listing_expiry"]) {
		$error_create = TRUE;
		$error_date = "Listing Expiry is not in the correct format.";
	}

	if (validate_notempty($_POST["tags"]) === FALSE) {
		$error_create = TRUE;
		$error_tags = "Tag is required.";
	}

	if (validate_notempty($_POST["price"], "int") === FALSE) {
		$error_create = TRUE;
		$error_price = "Price is required.";
	} else if (validate_numeric($_POST["price"]) === FALSE) {
		$error_create = TRUE;
		$error_price = "Price is not in the correct format.";
	} else if (validate_float((float)($_POST["price"])) === FALSE) {
		$error_create = TRUE;
		$error_price = "Price is not in the correct format.";
	}

	if (validate_notempty($_POST["condition"], "int") === FALSE) {
		$error_create = TRUE;
		$error_condition = "Product Condition is required.";
	} else if (validate_numeric($_POST["condition"]) === FALSE || validate_int($_POST["condition"]) === FALSE) {
		$error_create = TRUE;
		$error_price = "Product Condition is not in the correct format.";
	}

	if (validate_notempty($_POST["age"], "int") === FALSE) {
		$error_create = TRUE;
		$error_age = "Product Age is required.";
	} else if (validate_numeric($_POST["age"]) === FALSE || validate_int($_POST["age"]) === FALSE) {
		$error_create = TRUE;
		$error_price = "Product Age is not in the correct format.";
	}

	if (validate_notempty($_POST["category"], "int") === FALSE) {
		$error_create = TRUE;
		$error_cat = "Please choose a category.";
	} else if (validate_numeric($_POST["category"]) === FALSE || validate_int($_POST["category"]) === FALSE) {
		$error_create = TRUE;
		$error_price = "Category is not in the correct format.";
	}

	if (validate_notempty($_POST["location"], "int") === FALSE) {
		$error_create = TRUE;
		$error_loc = "Please choose a location.";
	} else if (validate_numeric($_POST["location"]) === FALSE || validate_int($_POST["location"]) === FALSE) {
		$error_create = TRUE;
		$error_price = "Location is not in the correct format.";
	}

	if ($error_create === FALSE) {
		// All fields successfully validated.
		$listing_id = NULL;
		$image_urls = array();
		$current_user_id = (int)($_SESSION["user_id"]);

		foreach ($_POST["images"] as $key => $url) {
			array_push($image_urls, $url);
		}

		$sql = "INSERT INTO listing
				(title, description, tags, price, item_condition, item_age, meetup_location, show_until, category_id, seller_id)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$sql_imgur = "INSERT INTO picture (listing_id, url) VALUES(?, ?)";

		$conn = get_conn();

		// Create the listing.
		if ($query = $conn->prepare($sql)) {
			$query->bind_param("sssdiissii",
				$_POST["product_name"], $_POST["product_desc"], $_POST["tags"], $_POST["price"], $_POST["condition"],
				$_POST["age"], $_POST["location"], $_POST["listing_expiry"], $_POST["category"], $current_user_id
			);

			$query->execute();
			$listing_id = $query->insert_id;
			$query->close();
		}

		if ($listing_id !== NULL) {
			// Insert the listing images into the database.
			if ($query = $conn->prepare($sql_imgur)) {
				foreach ($image_urls as $url) {
					$query->bind_param("is", $listing_id, $url);
					$query->execute();
				}

				$query->close();
			}
		}

		$conn->close();

		if ($listing_id !== NULL) {
			// Successfully created listing. Redirect to item page.
			header(sprintf("Location: item.php?id=%d", $listing_id));
			// Prevent further execution of PHP code in case redirect fails.
			die();
		}
	}
}

$categories = $locations = array();

$sql_category = "SELECT id, name FROM category ORDER BY id";
$sql_location = "SELECT * FROM locations";

$conn = get_conn();

if ($query = $conn->prepare($sql_category)) {
	$query->execute();
	$query->bind_result($id, $name);

	while ($query->fetch()) {
		$row = array(
			"id" => $id,
			"name" => $name,
		);

		array_push($categories, $row);
	}
	
	$query->close();
}

if ($query = $conn->prepare($sql_location)) {
	$query->execute();
	$query->bind_result($id, $code, $name, $line);

	while ($query->fetch()) {
		if ($code === NULL) {
			$location = $name;
		} else {
			$location = sprintf("%s, %s (%s)", $line, $name, $code);
		}

		$row = array(
			"id" => $id,
			"location" => $location,
		);

		array_push($locations, $row);
	}

	$query->close();
}

$conn->close();
