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



#use ZxcvbnPhp\Zxcvbn;
?>
