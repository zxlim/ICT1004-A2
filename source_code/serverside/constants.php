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

# Database connection parameters.
require_once("serverside/private/dbpasswd.php");