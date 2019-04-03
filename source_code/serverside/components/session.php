<?php require_once("serverside/functions/session.php");
/**
* If sessions are used in the page, please include this file first at the top.
*/

set_session_defaults();
session_start();

$session_is_authenticated = False;
$session_is_admin = FALSE;
$session_is_regmode = FALSE;

// Check if client session is authenticated (Logged in).
if (session_isauth() === TRUE) {
	// Client is authenticated.
	$session_is_authenticated = TRUE;
	$session_is_admin = $_SESSION["is_admin"];
} else if (session_isregmode() === TRUE && defined("REGISTER_ENDPOINT") === TRUE && REGISTER_ENDPOINT === TRUE) {
	// Registration going on.
	$session_is_regmode = TRUE;
} else {
	// Client is not authenticated.
	if (defined("REQUIRE_SESSION") === FALSE || REQUIRE_SESSION === FALSE) {
		// Page does not require session.
		// Unset and destroy session instance.
		session_end();
	}
	
	if (defined("REQUIRE_AUTH") === TRUE && REQUIRE_AUTH === TRUE) {
		// Page requires authentication.
		header("HTTP/1.1 401 Unauthorised");
		header("Location: login.php");
		die("Please login to access the requested resource.");
	}
}