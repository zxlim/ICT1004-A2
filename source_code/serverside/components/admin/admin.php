<?php

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

if (!$session_is_authenticated === True) {
	header("Location: login.php");
	exit;
}

require_once("serverside/functions/validation.php");
require_once("serverside/functions/database.php");


$selected_cat_id = 1;
$selected_cat_name = NULL;
$selected_update_cat_id = 99999;
$selected_update_cat_name = NULL;
$delete_cat = 99999;
$new_id = NULL;
$new_cat_name = NULL;



$results_catdetails = array();
$results_selectedupdatecatdetails = array();
$results_updatecatdetails = array();
$results_addnewcat = array();
$results_deletecat = array();

/* Getting current id's for category and user */
if (isset($_GET["id"]) && validate_int($_GET["id"])) {
	$selected_id = (int)($_GET["id"]);
	$selected_cat_id = (int)($_GET["id"]);
}

/* Getting current id for updating category */
if (isset($_GET["updatecat"]) && validate_int($_GET["updatecat"])) {
	$selected_update_cat_id = (int)($_GET["updatecat"]);
}



if (isset($_GET['delcat']) && validate_int($_GET["delcat"])) {
	$selected_update_cat_id = $_GET['delcat'];
}

if (isset($_POST["deletecat"])) {
	$delete_cat = (int)($_POST["id"]);

}

if (isset($_POST["newcat"])) {
	$new_id = (int)($_POST["id"]);
	$new_cat_name = $_POST["name"];

}


$sql_catdetails = "SELECT * from category ORDER BY id";
$sql_selectedupdatecatdetails = "SELECT * from category where id='$selected_update_cat_id'";
$sql_deletecat = "DELETE FROM category WHERE id='$delete_cat'";

$conn = get_conn();



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
if ($query = $conn->prepare($sql_selectedupdatecatdetails)) {
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

		array_push($results_selectedupdatecatdetails, $data);
	}
	$query->close();
}


if (isset($_POST["updatecat"])) {
	$selected_update_cat_id = $_POST['id'];
	$selected_update_cat_name = $_POST['name'];
	//print_r(explode(",",$str,2));
}




$sql_updatecatdetails = "UPDATE category SET name='$selected_update_cat_name' WHERE (id='$selected_update_cat_id')";
//echo $sql_updatecatdetails;
/* Storing selected results from what admin selected in admin_page.php and listing out on update_cat.php */
if ($query = $conn->prepare($sql_updatecatdetails)) {
	// echo $_POST["id"];
	$query->execute();
	if ($query->execute()) {
		$successupdate = 1;
	}
	else {
		$successupdate = 0;
	}
	array_push($results_updatecatdetails, $data);
	$query->close();
}



/*deleting cat from db */

if ($query = $conn->prepare($sql_deletecat)) {
	// echo $_POST["id"];
	$query->execute();

	if ($query->execute()) {
		$successdel = 1;
	}
	else {
		$successdel = 0;
	}
	array_push($results_deletecat, $data);
	$query->close();
}

//header('location: admin_page.php');


if (isset($_POST["newcat"])) {
	$new_id = $_POST['id'];
	$new_cat_name = $_POST['name'];
	//print_r(explode(",",$str,2));
}

$sql_add_new_cat = "INSERT INTO category(id, name) VALUES($new_id, '$new_cat_name')";

if ($query = $conn->prepare($sql_add_new_cat)) {

	$query->execute();

	if ($query->execute()) {
		$successaddcat = 1;
	}
	else {
		$successaddcat = 0;
	}
	array_push($results_addnewcat, $data);
	$query->close();
}

$conn->close();

?>
