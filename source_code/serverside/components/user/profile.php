<?php
##############################
# profile.php
# Logic for processing user profile details.
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

$user_id = 99999;
$user_name = NULL;
$mobile = $bio = "";
$mobileErr = $bioErr =  "";

$results_selectuser = array();


if (isset($_GET["id"]) && validate_int($_GET["id"])) {
	$user_id = (int)($_GET["id"]);
}


$sql_selectuser = "SELECT id, name, loginid, email, gender, mobile, bio FROM user where (id=$user_id)";

$conn = get_conn();

if ($query = $conn->prepare($sql_selectuser)) {
	$query->execute();
	$query->bind_result($id, $name, $loginid, $email, $gender, $mobile, $bio);

	while ($query->fetch()) {
		$data = array(
			"id" => (int)($id),
			"name" => $name,
			"loginid" => $loginid,
      "email" => $email,
			"gender" => $gender,
			"mobile" => $mobile,
			"bio" => $bio,
		);

		if ($user_id === (int)($id)) {
			$user_name = $name;
			$login_id = $loginid;
			$Email = $email;
			$Gender = $gender;
			$Mobile = $mobile;
			$Bio = $bio;
		}

		array_push($results_selectuser, $data);
	}
	$query->close();
}

$conn->close();
