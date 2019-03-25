<?php define("CLIENT", TRUE);
require_once("serverside/base.php");
require_once("serverside/functions/validation.php");
require_once("serverside/functions/database.php");

if (isset($_GET["id"]) && validate_int($_GET["id"])) {
	$image_id = (int)($_GET["id"]);
} else {
	header("Location: index.php");
}

if (isset($_GET["type"]) && $_GET["type"] === "u") {
	// User display picture.
	$sql = "SELECT data, mimetype FROM user_picture WHERE id = ?";
} else {
	// Defaults to listing image.
	$sql = "SELECT data, mimetype FROM picture WHERE id = ?";
}

$conn = get_conn();

if ($query = $conn->prepare($sql)) {
	$query->bind_param("i", $image_id);
	$query->execute();
	$query->bind_result($data, $mimetype);

	if ($query->fetch()) {
		header("Content-Type: " . $mimetype);
		echo($data);
	}

	$query->close();
}

$conn->close();