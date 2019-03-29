<?php session_start();
/**
* If sessions are used in the page, please include this file first at the top.
* `session_start` function should be the first function call in a page that uses session.
*/

// Include custom session functions.
require_once("serverside/functions/session.php");

// Check if client session is authenticated (Logged in).
if (session_isauth() === TRUE) {
	// Client is authenticated.
	$session_is_authenticated = TRUE;
} else {
	// Client is not authenticated.
	$session_is_authenticated = False;

	if (defined("REQUIRE_SESSION") === FALSE || REQUIRE_SESSION === FALSE) {
		// Page does not require session.
		// Unset and destroy session instance.
		session_end();
	}
}