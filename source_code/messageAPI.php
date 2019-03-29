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

$response = array("status" => 200, "data" => array(), "message" => "OK");
$accept_request = FALSE;

// Check for valid request.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	// Only POST method allowed on this endpoint.
	$response["status"] = 405;
	$response["message"] = "Method Not Allowed";
	header("Content-Type: application/json; charset=UTF-8", TRUE, (int)($response["status"]));
	die(json_encode($response));
} else if (isset($_POST["id"]) && isset($_POST["action"])) {
	if (validate_int($_POST["id"]) && validate_notempty($_POST["action"])) {
		// Check action.
		if ($_POST["action"] === "get") {
			// `get` action.
			$accept_request = TRUE;
			$action = "get";
		} else if ($_POST["action"] === "send") {
			// `send` action.
			if (isset($_POST["msg_data"]) && validate_notempty($_POST["msg_data"])) {
				// Ensure there is message data.
				$accept_request = TRUE;
				$action = "send";
				$msg_data = $_POST["msg_data"];
			}
		}
	}
}

if ($accept_request === FALSE) {
	$response["status"] = 400;
	$response["message"] = "Bad Request";
	header("Content-Type: application/json; charset=UTF-8", TRUE, (int)($response["status"]));
	die(json_encode($response));
}

$user_id = 1; // Temporary hardcode. //(int)($_SESSION["user_id"]);
$convo_id = (int)($_POST["id"]);

$conn = get_conn();

if ($action === "get") {
	$sql = "SELECT message.sender_id, message.data, message.datetime FROM message
			INNER JOIN conversation ON message.conversation = conversation.id
			WHERE conversation.id = ?
			AND (conversation.user1 = ? OR conversation.user2 = ?)
			ORDER BY message.datetime";

	$sql_read = "UPDATE message
			INNER JOIN conversation ON conversation.id = message.conversation
			SET receiver_read = 1
			WHERE conversation.id = ?
			AND message.sender_id != ?";

	if ($query = $conn->prepare($sql)) {
		$query->bind_param("iii", $convo_id, $user_id, $user_id);
		$query->execute();
		$query->bind_result($msg_sid, $msg_data, $msg_dt);

		while ($query->fetch()) {
			$row = array(
				"sender_id" => (int)($msg_sid),
				"data" => html_safe($msg_data),
				"datetime" => $msg_dt,
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
	$rollback = FALSE;
	$message_id = NULL;
	$current_dt = get_datetime();

	$sql = "INSERT INTO message (conversation, sender_id, data, datetime) VALUES (?, ?, ?, ?)";

	if ($query = $conn->prepare($sql)) {
		$query->bind_param("iiss", $convo_id, $user_id, $msg_data, $current_dt);

		if (!$query->execute()) {
			// Something went wrong.
			$response["status"] = 500;
			$response["message"] = "Failed to send message. " . $query->error;
		}

		$query->close();
	}
}

$conn->close();

header("Content-Type: application/json", TRUE, (int)($response["status"]));
echo(json_encode($response));
