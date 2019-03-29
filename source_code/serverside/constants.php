<?php
##############################
# constants.php
##############################

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

# Web application parameters.
define("APP_TITLE", "FastTrade");
define("APP_ROOT", dirname($_SERVER["REQUEST_URI"]));

# Database connection parameters.
require_once("serverside/private/dbpasswd.php");