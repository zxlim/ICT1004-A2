<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/functions/database.php");
require_once("serverside/functions/validation.php");
//require_once("serverside/components/session.php");

// if ($session_is_authenticated === FALSE) {
// 	// Client is not authenticated.
// 	header("HTTP/1.1 401 Unauthorised");
// 	die("Authentication is required to access this resource.");
// }

// Check for valid request.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	header("HTTP/1.1 405 Method Not Allowed");
	die("Bad request.");
} else if (isset($_POST["id"]) === FALSE) {
	header("HTTP/1.1 400 Bad Request");
	die("Bad request.");
} else if (validate_int($_POST["id"]) === FALSE) {
	header("HTTP/1.1 400 Bad Request");
	die("Bad request.");
}

if (isset($_POST["msg_data"])) {
	if (validate_notempty($_POST["msg_data"])) {
		$send = TRUE;
		$msg_data = $_POST["msg_data"];
	} else {
		header("HTTP/1.1 400 Bad Request");
		die("Bad request.");
	}
} else {
	$send = FALSE;
}

// Responses will be in json.
header("Content-Type: application/json; charset=UTF-8");

$messages = array();
// Temporary hardcode.
$sender_id = 1; //(int)($_SESSION["user_id"]);
$listing_id = (int)($_POST["id"]);

$conn = get_conn();

if ($send) {
	// New message.
	$rollback = FALSE;
	$message_id = NONE;
	$current_dt = get_datetime();

	$sql_msg = "INSERT INTO message (data, datetime) VALUES (?, ?)";
	$sql_msg_r = "INSERT INTO message_relation (sender_id, receiver_id, listing_id, message_id) VALUES (?, ?, ?, ?)";

	$sql_msg_rollback = "DELETE FROM message WHERE id = ?";

	if ($query = $conn->prepare($sql_msg)) {
		$query->bind_param("ss", $msg_data, $current_dt);

		if (!$query->execute()) {
			// Something went wrong.
			header("HTTP/1.1 500 Internal Server Error");
			echo(json_encode(array("message" => "Failed to send message.",)));
		} else {
			$message_id = $conn->insert_id();
		}

		$query->close();
	}

	if ($message_id !== NONE) {
		if ($query = $conn->prepare($sql_msg_r)) {
			$query->bind_param("iii", $sender_id, $listing_id, $message_id);

			if (!$query->execute()) {
				// Something went wrong.
				$rollback = TRUE;
				header("HTTP/1.1 500 Internal Server Error");
				echo(json_encode(array("message" => "Failed to send message.",)));
			} else {
				echo(json_encode(array("message" => "OK",)));
			}

			$query->close();
		}
	}

	if ($rollback) {
		// Delete the inserted message record.
		if ($query = $conn->prepare($sql_msg_rollback)) {
			$query->bind_param("i", $message_id);
			$query->execute()
			$query->close();
		}
	}
} else {
	// Retrieve messages.
	$sql = "SELECT message_relation.sender_id, message.data, message.datetime FROM message_relation
			INNER JOIN message ON message.id = message_relation.message_id
			WHERE message_relation.listing_id = ?
			AND (message_relation.sender_id = ? OR message_relation.receiver_id = ?)
			ORDER BY message.datetime";

	if ($query = $conn->prepare($sql)) {
		$query->bind_param("iii", $listing_id, $sender_id, $sender_id);
		$query->execute();
		$query->bind_result($msg_sid, $msg_data, $msg_dt);

		while ($query->fetch()) {
			$row = array(
				"sender_id" => (int)($msg_sid),
				"data" => $msg_data,
				"datetime" => $msg_dt,
			);

			array_push($messages, $row);
		}

		$query->close();
	}

	echo(json_encode($messages));
}

$conn->close();
