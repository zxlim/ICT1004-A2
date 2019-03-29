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
$selected_update_cat_id = 99999;
$selected_update_cat_name = NULL;
$delete_user = 99999;
$delete_cat = 99999;

$results_userdetails = array();
$results_catdetails = array();
$results_updatecatdetails = array();

/* Getting current id's for category and user */
if (isset($_GET["id"]) && validate_int($_GET["id"])) {
	$selected_id = (int)($_GET["id"]);
	$selected_cat_id = (int)($_GET["id"]);
}

/* Getting current id for updating category */
if (isset($_GET["updatecat"]) && validate_int($_GET["updatecat"])) {
	$selected_update_cat_id = (int)($_GET["updatecat"]);
}

if (isset($_GET["deluser"]) && validate_int($_GET["deluser"])) {
	$delete_user = (int)($_GET["deluser"]);
}

if (isset($_GET['delcat']) && validate_int($_GET["delcat"])) {
	$delete_cat = $_GET['delcat'];
}


$sql_userdetails = "SELECT id, name, email, gender FROM user ORDER BY id";
$sql_catdetails = "SELECT * from category ORDER BY id";
$sql_updatecatdetails = "SELECT * from category where id='$selected_update_cat_id'";
$sql_deleteuser = "DELETE FROM user WHERE id='$delete_user'";
$sql_deletecat = "DELETE FROM category WHERE id='$delete_cat'";

$conn = get_conn();

/* Storing id, name, email, gender of all users into an array for listing on admin_page.php */
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

/* Storing all category details into an array for listing on admin_page.php */
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

/* Storing selected results from what admin selected in admin_page.php and listing out on update_cat.php */
if ($query = $conn->prepare($sql_updatecatdetails)) {
	$query->execute();
	$query->bind_result($id, $name);

	while ($query->fetch()) {
		$data = array(
			"id" => (int)($id),
			"name" => $name,
		);

		if ($selected_update_cat_id === (int)($id)) {
			$selected_update_cat_name = $name;
		}

		array_push($results_updatecatdetails, $data);
	}
	$query->close();
}

/* deleting user from db */
	if ($query = $conn->prepare($sql_deleteuser)) {
		$query->execute();
	$_SESSION['message'] = "User deleted!";
  	$query->close();
	//header('location: admin_page.php');
}


/*deleting cat from db */
	if ($query = $conn->prepare($sql_deletecat)) {
		$query->execute();
	$_SESSION['message'] = "Category deleted!";
  	$query->close();
	//header('location: admin_page.php');
}



$conn->close();

 ?>
