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
define("APP_TITLE", "FastTrade 08");
define("APP_ROOT", trim(dirname($_SERVER["REQUEST_URI"])));
define("APP_DOMAIN", trim($_SERVER["SERVER_NAME"]));
define("APP_TZ", "Asia/Singapore");

# Sensitive parameters.
require_once("serverside/private/dbpasswd.php");
require_once("serverside/private/smtp.php");