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