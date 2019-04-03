<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/functions/validation.php");
require_once("serverside/functions/security.php");
require_once("serverside/functions/database.php");

$action = NULL;
$convo_id = NULL;
$msg_data = NULL;
$user_id = NULL;

$valid_request = FALSE;
$response = array(
	"status" => 200,
	"data" => array(),
	"message" => "OK",
);

// Responses are in JSON.
header("Content-Type: application/json; charset=UTF-8");

if ($session_is_authenticated === FALSE) {
	// Client not authenticated.
	$response["status"] = 401;
	$response["message"] = "Authentication is required to access this resource";
} else if ($session_is_admin === TRUE) {
	// Admins not allowed.
	$response["status"] = 403;
	$response["message"] = "You are not allowed to access the requested resource";
} else if ($_SERVER["REQUEST_METHOD"] === "GET") {
	// GET request.
	if (
		isset($_GET["state"]) && isset($_GET["action"]) &&
		($_GET["action"] === "ping" || $_GET["action"] === "list")
	) {
		// Valid request `ping`.
		$action = html_safe($_GET["action"], TRUE);
		$state = html_safe($_GET["state"], TRUE);
		$valid_request = TRUE;
	} else if (
		isset($_GET["ctr"]) === FALSE || validate_int($_GET["ctr"]) === FALSE ||
		isset($_GET["id"]) === FALSE || validate_int($_GET["id"]) === FALSE
	) {
		// Bad request.
		$response["status"] = 400;
		$response["message"] = "Bad Request";
	} else {
		// Valid request.
		$action = "fetch";
		$convo_id = html_safe($_GET["id"], TRUE);
		$offset = html_safe($_GET["ctr"], TRUE);
		$valid_request = TRUE;
	}
} else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"]) && validate_int($_POST["id"])) {
	// POST request.
	if (validate_notempty($_POST["msg_data"]) === FALSE) {
		// Bad request.
		$response["status"] = 428;
		$response["message"] = "Your message cannot be empty.";
	} else {
		// Valid request.
		$action = "send";
		$convo_id = html_safe($_POST["id"], TRUE);
		$msg_data = html_safe($_POST["msg_data"], TRUE);
		$valid_request = TRUE;
	}
} else {
	// Invalid request method.
	$response["status"] = 405;
	$response["message"] = "Method Not Allowed";
}

// Check if request is valid.
if ($valid_request === FALSE) {
	if ($response["status"] === 400) {
		header("HTTP/1.1 400 Bad Request");
	} else if ($response["status"] === 401) {
		header("HTTP/1.1 401 Unauthorised");
	} else if ($response["status"] === 405) {
		header("HTTP/1.1 405 Method Not Allowed");
	} else if ($response["status"] === 428) {
		header("HTTP/1.1 428 Precondition Required");
	}
	die(json_encode($response));
}

$user_id = (int)($_SESSION["user_id"]);

$conn = get_conn();

/**
* Why "18446744073709551615" you ask? See:
* 1. https://stackoverflow.com/a/271650
* 2. https://mariadb.com/kb/en/library/why-is-order-by-in-a-from-subquery-ignored/
*/

if ($action === "ping") {
	$sql = "SELECT c.id, m.datetime, m.receiver_read, l.id, l.title, u.id, u.name
			FROM (SELECT * FROM message ORDER BY datetime DESC LIMIT 18446744073709551615) AS m
			INNER JOIN conversation AS c ON m.conversation = c.id
			INNER JOIN listing AS l ON c.listing_id = l.id
			INNER JOIN user AS u ON m.sender_id = u.id
			WHERE m.sender_id != ?
			AND (c.user1 = ? OR c.user2 = ?)
			GROUP BY c.id
			ORDER BY m.datetime DESC";

	if ($query = $conn->prepare($sql)) {
		$query->bind_param("iii", $user_id, $user_id, $user_id);
		$query->execute();
		$query->bind_result($convo_id, $msg_dt, $msg_rr, $listing_id, $listing_title, $uid, $uname);

		while ($query->fetch()) {
			$row = array(
				"convo_id" => (int)($convo_id),
				"datetime" => date("d M Y, g:i A", strtotime($msg_dt)),
				"datetime_epoch" => (int)(strtotime($msg_dt)),
				"read" => (bool)($msg_rr),
				"listing_id" => (int)($listing_id),
				"listing_title" => html_safe(truncate($listing_title, 64)),
				"user_id" => (int)($uid),
				"user_name" => html_safe($uname),
			);

			array_push($response["data"], $row);
		}

		$query->close();
	}

	$response["message"] = sha256(serialize($response["data"]));
} else if ($action === "list") {
	$sql = "SELECT c.id, m.data, m.datetime, m.receiver_read, l.id, l.title, u.id, u.name
			FROM (SELECT * FROM message ORDER BY datetime DESC LIMIT 18446744073709551615) AS m
			INNER JOIN conversation AS c ON m.conversation = c.id
			INNER JOIN listing AS l ON c.listing_id = l.id
			INNER JOIN user AS u ON m.sender_id = u.id
			WHERE c.user1 = ? OR c.user2 = ?
			GROUP BY c.id
			ORDER BY m.datetime DESC";

	if ($query = $conn->prepare($sql)) {
		$query->bind_param("ii", $user_id, $user_id);
		$query->execute();
		$query->bind_result($convo_id, $msg_data, $msg_dt, $msg_rr, $listing_id, $listing_title, $uid, $uname);

		while ($query->fetch()) {
			if ($user_id === $uid) {
				$read_state = TRUE;
			} else {
				$read_state = (bool)($msg_rr);
			}

			$row = array(
				"convo_id" => (int)($convo_id),
				"datetime" => date("d M Y, g:i A", strtotime($msg_dt)),
				"datetime_epoch" => (int)(strtotime($msg_dt)),
				"data" => truncate($msg_data, 64),
				"read" => $read_state,
				"listing_id" => (int)($listing_id),
				"listing_title" => html_safe($listing_title),
				"user_id" => (int)($uid),
				"user_name" => html_safe($uname),
			);

			array_push($response["data"], $row);
		}

		$query->close();
	}

	$response["message"] = sha256(serialize($response["data"]));
} else if ($action === "fetch") {
	$sql = "SELECT m.sender_id, m.data, m.datetime, m.receiver_read FROM message AS m
			INNER JOIN conversation AS c ON m.conversation = c.id
			WHERE c.id = ?
			AND (c.user1 = ? OR c.user2 = ?)
			ORDER BY m.datetime
			LIMIT ?, 18446744073709551615";

	$sql_read = "UPDATE message AS m
				INNER JOIN conversation AS c ON c.id = m.conversation
				SET m.receiver_read = 1
				WHERE c.id = ?
				AND m.sender_id != ?
				AND m.receiver_read = 0";

	if ($query = $conn->prepare($sql)) {
		$query->bind_param("iiii", $convo_id, $user_id, $user_id, $offset);
		$query->execute();
		$query->bind_result($msg_sid, $msg_data, $msg_dt, $msg_read);

		while ($query->fetch()) {
			$row = array(
				"sender_id" => (int)($msg_sid),
				"data" => html_safe($msg_data),
				"datetime" => date("d M Y, g:i A", strtotime($msg_dt)),
				"read" => (bool)($msg_read),
			);

			array_push($response["data"], $row);
		}

		$query->close();
	}

	if (count($response) !== 0) {
		// Mark messages as read.
		if ($query = $conn->prepare($sql_read)) {
			$query->bind_param("ii", $convo_id, $user_id);
			$query->execute();
			$query->close();
		}
	}
} else if ($action === "send") {
	// New message.
	$message_id = NULL;
	$current_dt = get_datetime();

	$sql = "INSERT INTO message (conversation, sender_id, data, datetime) VALUES (?, ?, ?, ?)";

	if ($query = $conn->prepare($sql)) {
		$query->bind_param("iiss", $convo_id, $user_id, $msg_data, $current_dt);

		if (!$query->execute()) {
			// Something went wrong.
			$response["status"] = 500;
			$response["message"] = "Failed to send message.";
		}

		$query->close();
	}
}

$conn->close();

if ($response["status"] === 200) {
	header("HTTP/1.1 200 OK");
} else if ($response["status"] === 500) {
	header("HTTP/1.1 500 Internal Server Error");
}

echo(json_encode($response));
