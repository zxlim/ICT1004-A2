<?php

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

require_once("serverside/functions/validation.php");
require_once("serverside/functions/database.php");

$selected_id = 1;
$selected_name = NULL;
$selected_cat_id = 1;
$selected_cat_name = NULL;

$results_userdetails = array();
$results_catdetails = array();


if (isset($_GET["id"]) && validate_int($_GET["id"])) {
	$selected_id = (int)($_GET["id"]);
}

$sql_userdetails = "SELECT id, name, email, gender FROM user ORDER BY id";
$sql_catdetails = "SELECT * from category ORDER BY id";

$conn = get_conn();

if ($query = $conn->prepare($sql_userdetails)) {
	$query->execute();
	$query->bind_result($id, $name, $email, $gender);

	while ($query->fetch()) {
		$data = array(
			"id" => (int)($id),
			"name" => $name,
      "email" => $email,
      "gender" => $gender,
		);

		if ($selected_id === (int)($id)) {
			$selected_name = $name;
		}

		array_push($results_userdetails, $data);
	}
	$query->close();
}
$arrayName = array('' => , );
if ($query = $conn->prepare($sql_catdetails)) {
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

		array_push($results_catdetails, $data);
	}
	$query->close();
}



if (isset($_GET['del'])) {
	$id = $_GET['del'];

	$sql_delete = "DELETE FROM user WHERE id=$id";
	if ($query = $conn->prepare($sql_delete)) {
		$query->execute();
	$_SESSION['message'] = "User deleted!";
  	$query->close();
	//header('location: admin_page.php');
}

}

$conn->close();

 ?>
