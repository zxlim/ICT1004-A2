<?php
##############################
# profile.php
# Logic for processing user profile.
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


$current_dt = get_datetime(TRUE);
$review_overall = "-";
$response_msg = $session_user_id = $profile = NULL;
$ajax_call = $response_error = FALSE;
$user_listings = $user_reviews = $user_reviews_ratings = $review_counts = array();


if ($session_is_authenticated === TRUE) {
	// Get client's user ID if authenticated.
	$session_user_id = $_SESSION["user_id"];
}

if (isset($_GET["id"]) === TRUE && validate_int($_GET["id"]) === TRUE) {
	// Profile ID is specified.
	$profile_id = (int)(html_safe($_GET["id"], TRUE));
} else if ($session_is_authenticated === TRUE) {
	// Fallback to user's own profile if client is authenticated.
	$profile_id = $_SESSION["user_id"];
} else {
	header("Location: login.php");
	die(); // Prevent further execution of PHP code.
}


$conn = get_conn();

// Retrieve User Profile.
$sql_profiles = "SELECT id, name, email, join_date, gender, bio, profile_pic, suspended, admin FROM user WHERE id = ?";

if ($query = $conn->prepare($sql_profiles)) {
	$query->bind_param("i", $profile_id);
	$query->execute();
	$query->bind_result($id, $name, $email, $join_date, $gender_char, $bio, $profile_pic, $suspended, $admin);

	if ($query->fetch()) {
		if ((bool)($admin) === FALSE && (bool)($suspended) === FALSE) {
			switch ($gender_char) {
				case "M":
					$gender = "Male";
					break;
				case "F":
					$gender = "Female";
					break;
				case "O":
					$gender = "Others";
					break;
				default:
					$gender = "Not Specified";
					break;
			}

			$user_bio = validate_notempty($bio) ? $bio : "This user prefers to keep their life a mystery...";

			$profile = array(
				"id" => (int)($id),
				"name" => $name,
				"email" => $email,
				"join_date" => date("F Y", strtotime($join_date)),
				"gender" => $gender,
				"bio" => $user_bio,
				"profile_pic" => $profile_pic
			);
		}
	}

	$query->close();
}

if ($profile !== NULL) {
	// Only execute the following code if user profile is successfully retrieved.

	if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) === TRUE) {
		// POST request method.
		if ($_POST["action"] === "add_reviews" && $session_is_admin === FALSE) {
			$ajax_call = TRUE;
			$response_error = TRUE;

			if (
				isset($session_user_id) && $session_user_id !== $profile_id &&
				isset($_POST["rating"]) === TRUE && validate_int($_POST["rating"]) === TRUE &&
				isset($_POST["description"]) === TRUE && validate_notempty($_POST["description"]) === TRUE
			) {
				$r_rating = html_safe($_POST["rating"], TRUE);
				$r_desc = html_safe($_POST["description"], TRUE);

				$sql = "INSERT INTO review (buyer_id, seller_id, datetime, rating, description)
						VALUES (?, ?, ?, ?, ?)";

				if ($query = $conn->prepare($sql)) {
					$query->bind_param("iisis",
						$session_user_id, $profile_id, $current_dt, $r_rating, $r_desc
					);

					if (!$query->execute()) {
						$response_msg = "Failed to add review, please try again.";
					} else {
						$response_error = FALSE;
						$response_msg = "Review added successfully.";
					}

					$query->close();
				}
			}
		} else if (
			$_POST["action"] === "delete_listing" &&
			isset($_POST["id"]) === TRUE && validate_int($_POST["id"]) === TRUE
		) {
			$listing_id = html_safe($_POST["id"], TRUE);

			$sql = "DELETE FROM listing WHERE id = ? AND seller_id = ?";

			if ($query = $conn->prepare($sql)) {
				$query->bind_param("ii", $listing_id, $session_user_id);

				if (!$query->execute()) {
					$response_error = TRUE;
					$response_msg = "Failed to delete listing, please try again.";
				} else {
					$response_msg = "Listing deleted successfully.";
				}

				$query->close();
			}
		} else if (
			$_POST["action"] === "sold_listing" &&
			isset($_POST["id"]) === TRUE && validate_int($_POST["id"]) === TRUE
		) {
			$listing_id = html_safe($_POST["id"], TRUE);

			$sql = "UPDATE listing SET sold = 1 WHERE id = ? AND seller_id = ?";

			if ($query = $conn->prepare($sql)) {
				$query->bind_param("ii", $listing_id, $session_user_id);

				if (!$query->execute()) {
					$response_error = TRUE;
					$response_msg = "Failed to update listing status, please try again.";
				} else {
					$response_msg = "Listing mark as sold.";
				}

				$query->close();
			}
		}
	} // End POST.

	// Retrieve user's listings.
	$sql_listings = "SELECT l.id, l.title, l.price, l.show_until, l.sold, p.url FROM listing AS l
					LEFT JOIN picture AS p ON p.listing_id = l.id
					WHERE l.seller_id = ?
					GROUP BY l.id
					ORDER BY l.id DESC";

	if ($query = $conn->prepare($sql_listings)) {
		$query->bind_param("i", $profile_id);
		$query->execute();
		$query->bind_result($id, $title, $price, $show_until, $sold, $picture_url);

		while ($query->fetch()) {
			if ($picture_url === NULL) {
				$picture_url = "static/img/default/listing.jpg";
			}
			
			$row = array(
				"id" => $id,
				"title" => $title,
				"price" => (float)($price),
				"expiry" => strtotime($show_until),
				"sold" => (bool)($sold),
				"url" => $picture_url,
			);

			array_push($user_listings, $row);
		}

		$query->close();
	}

	// Retrieve user's reviews.
	$sql_reviews = "SELECT r.id, r.buyer_id, r.seller_id, r.datetime, r.rating, r.description, u.name, u.profile_pic 
					FROM review AS r
					INNER JOIN user AS u ON r.buyer_id = u.id 
					WHERE r.seller_id = ?
					ORDER BY r.datetime DESC";

	if ($query = $conn->prepare($sql_reviews)) {
		$query->bind_param("i", $profile_id);
		$query->execute();
		$query->bind_result($id, $buyer_id, $seller_id, $datetime, $rating, $description, $buyer_name, $buyer_profile_pic);

		while ($query->fetch()) {
			$row = array(
				"id" => (int)($id),
				"buyer_id" => (int)($buyer_id),
				"seller_id" => (int)($seller_id),
				"datetime" => date("d M Y", strtotime($datetime)),
				"rating" => (int)($rating),
				"description" => $description,
				"buyer_name" => $buyer_name,
				"buyer_profile_pic" => $buyer_profile_pic
			);

			array_push($user_reviews, $row);
			array_push($user_reviews_ratings, $rating);
		}

		if (validate_notempty($user_reviews_ratings, "array") === TRUE) {
			$review_overall = round(array_sum($user_reviews_ratings) / count($user_reviews_ratings), 2);
			$review_counts = array_count_values($user_reviews_ratings);
		}

		$query->close();
	}
}

$conn->close();

if ($ajax_call === TRUE && $response_error === TRUE) {
	header("HTTP/1.1 500 Internal Server Error");
	header("Content-Type: application/json; charset=UTF-8");
	echo(json_encode(array("msg" => $response_msg)));
	die(); // Prevent further execution of PHP code.
}
