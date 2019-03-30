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
$selected_update_user_id = 99999;
$selected_update_user_name = NULL;
$selected_update_loginid = NULL;
$selected_update_email = NULL;
$selected_new_user_id = 99999;
$selected_new_user_name = NULL;
$suspended_state = 255;
$delete_user = 99999;

$results_userdetails = array();
$results_updateuser = array();
$results_selectedupdateuserdetails = array();
$results_updateuserdetails = array();
$results_addnewuser = array();

if (isset($_GET["id"]) && validate_int($_GET["id"])) {
	$selected_id = (int)($_GET["id"]);
}

if (isset($_GET["edituser"]) && validate_int($_GET["edituser"])) {
	$selected_update_user_id = (int)($_GET["edituser"]);
}

if (isset($_GET["deluser"]) && validate_int($_GET["deluser"])) {
	$delete_user = (int)($_GET["deluser"]);
}

$sql_userdetails = "SELECT id, name, email, gender, suspended FROM user ORDER BY id";
$sql_selectedupdateuserdetails = "SELECT id, name, loginid, email, suspended from user where id='$selected_update_user_id'";
$sql_deleteuser = "DELETE FROM user WHERE id='$delete_user'";

$conn = get_conn();

/* Storing id, name, email, gender of all users into an array for listing on admin_page.php */
if ($query = $conn->prepare($sql_userdetails)) {
	$query->execute();
	$query->bind_result($id, $name, $email, $gender, $suspended);

	while ($query->fetch()) {
		$data = array(
			"id" => (int)($id),
			"name" => $name,
      "email" => $email,
      "gender" => $gender,
      "suspended" => $suspended,
		);

		if ($selected_id === (int)($id)) {
			$selected_name = $name;
		}

		array_push($results_userdetails, $data);
	}
	$query->close();
}

if ($query = $conn->prepare($sql_selectedupdateuserdetails)) {
	$query->execute();
	$query->bind_result($id, $name, $loginid, $email, $suspended);

	while ($query->fetch()) {
		$data = array(
			"id" => (int)($id),
			"name" => $name,
      "loginid" => $loginid,
      "email" => $email,
      "suspended" => $suspended,
		);

		if ($selected_update_user_id === (int)($id)) {
			$selected_update_user_name = $name;
      $selected_update_loginid = $loginid;
      $selected_update_email = $email;
      $suspended_state = $suspended;
		}
		array_push($results_selectedupdateuserdetails, $data);
	}
	$query->close();
}

if (isset($_POST["updateuser"])) {
	$selected_update_user_id = $_POST['id'];
	$selected_update_user_name = $_POST['name'];
  $suspended_state = (1-((int)($_POST['suspended'])));
}


$sql_updateuserdetails = "UPDATE user SET suspended='$suspended_state' WHERE id='$selected_update_user_id'";

if ($query = $conn->prepare($sql_updateuserdetails)) {
// echo $_POST["id"];
	$query->execute();

	if ($query->execute()) {
		$success = 1;
	}
	else {
		$success = 0;
	}
		array_push($results_updateuserdetails, $data);
	$query->close();
}


if (isset($_POST["newuser"])) {
	$selected_new_user_id = $_POST['id'];
	$selected_new_user_name = $_POST['name'];

}

$sql_add_new_user = "INSERT INTO user(id, name) VALUES($selected_new_user_id, '$selected_new_user_name')";

if ($query = $conn->prepare($sql_add_new_user)) {
// echo $_POST["id"];
	$query->execute();

	if ($query->execute()) {
		$success = 1;
	}
	else {
		$success = 0;
	}
		array_push($results_addnewuser, $data);
	$query->close();
}

/* deleting user from db */
	if ($query = $conn->prepare($sql_deleteuser)) {
		$query->execute();
	$_SESSION['message'] = "User deleted!";
  	$query->close();
	//header('location: admin_page.php');
}


$conn->close();

 ?>