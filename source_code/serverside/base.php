<?php
##############################
# base.php
##############################
/**
* @copyright	Copyright (c) 2019. For the
*				partial fulfillment of the module
*				ICT1004 Web Systems and Technologies.
*
* @author		CHAN HON SIANG	(1802950)
* @author		KISH CHOY		(1802966)
* @author		LIM ZHAO XIANG	(1802976)
* @author		STANLEY CHEONG	(1802986)
* @author		TAN ZHAO YEA	(1802992)
*/

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
