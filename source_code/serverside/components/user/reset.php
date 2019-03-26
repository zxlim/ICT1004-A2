<?php
##############################
# login.php
# Logic for processing user password resets.
##############################

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

require_once("serverside/vendor/zxcvbn.php");

#use ZxcvbnPhp\Zxcvbn;
