<?php
##############################
# base.php
##############################

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

require_once("serverside/constants.php");
require_once("serverside/functions/utils.php");
require_once("serverside/components/session.php");
require_once("serverside/functions/database.php");

if ($session_is_authenticated === TRUE) {
    $loginid = "";
    $admin = false;
    $loginid = $_SESSION["user_loginid"];

    $conn = get_conn();
    $sql = "SELECT admin from user WHERE loginid = '".$loginid."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row["admin"] == 1){
            // header("Location: index.php");
            $admin = true;
        }
    }
    $conn->close();

    //header("Location: admin_page.php");
}
