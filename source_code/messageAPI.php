<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/functions/database.php");
require_once("serverside/functions/validation.php");

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

if (session_isauth() === FALSE) {
	// Client not authenticated.
	$response["status"] = 401;
	$response["message"] = "Authentication is required to access this resource";
} else if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"]) && validate_int($_GET["id"])) {
	// GET request.
	if (isset($_GET["ctr"]) === FALSE || validate_int($_GET["ctr"]) === FALSE) {
		// Bad request.
		$response["status"] = 400;
		$response["message"] = "Bad Request";
	} else {
		// Valid request.
		$action = "fetch";
		$convo_id = $_GET["id"];
		$offset = $_GET["ctr"];
		$valid_request = TRUE;
	}
} else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"]) && validate_int($_POST["id"])) {
	// POST request.
	if (isset($_POST["msg_data"]) === FALSE || validate_notempty($_POST["msg_data"]) === FALSE) {
		// Bad request.
		$response["status"] = 428;
		$response["message"] = "Your message cannot be empty.";
	} else {
		// Valid request.
		$action = "send";
		$convo_id = $_POST["id"];
		$msg_data = $_POST["msg_data"];
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

if ($action === "fetch") {
	// Why 18446744073709551615 you ask? See: `https://stackoverflow.com/a/271650`.
	$sql = "SELECT message.sender_id, message.data, message.datetime, message.receiver_read FROM message
			INNER JOIN conversation ON message.conversation = conversation.id
			WHERE conversation.id = ?
			AND (conversation.user1 = ? OR conversation.user2 = ?)
			ORDER BY message.datetime LIMIT ?, 18446744073709551615";

	$sql_read = "UPDATE message
			INNER JOIN conversation ON conversation.id = message.conversation
			SET message.receiver_read = 1
			WHERE conversation.id = ?
			AND message.sender_id != ?
			AND message.receiver_read = 0";

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
			// $response["debug"] = $query->error;
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
