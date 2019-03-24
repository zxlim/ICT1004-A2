<?php
##############################
# message.php
# Logic for messaging between users
# regarding a particular item listing.
##############################

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}
