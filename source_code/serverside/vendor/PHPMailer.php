<?php
##############################
# PHPMailer.php
##############################

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

require_once("serverside/vendor/PHPMailerSrc/Exception.php");
require_once("serverside/vendor/PHPMailerSrc/PHPMailer.php");
require_once("serverside/vendor/PHPMailerSrc/SMTP.php");
