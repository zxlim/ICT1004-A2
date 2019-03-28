<?php declare(strict_types=1);

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

function safe_echo(string $string_raw = ""): void {
	/**
	* A function to safely echo a string into an HTML template.
	* Encodes some predefined characters into HTML entities.
	*
	* @param	string	$string_raw	The string to encode and echo.
	*/
	if (strlen($string_raw) !== 0) {
		// Only proceed if string has characters.
		// Encode string to UTF-8, then encode HTML entities.
		$string = utf8_encode($string_raw);
		echo(htmlspecialchars($string));
	}
}

function active_nav(array $item): string {
	/**
	* A function to mark a navigation item as "active".
	*
	* @param	array	$item	A list of the nav-item's child anchor
	*							links (href).
	*
	* @return	string	$class	The class values for the HTML element.
	*/
	foreach ($item as $i) {
		if (basename($_SERVER["PHP_SELF"]) === $i) {
			return "nav-item active";
		}
	}

	return "nav-item";
}

function get_datetime(bool $date_only = FALSE, int $offset = 0): string {
	/**
	* Returns the date and time, accounting for any offset provided in seconds.
	*
	* @param	bool	$date_only	Only return the date without time.
	* @param	int		$offset		The offset in seconds to add/subtract from
	*								the date and time.
	*
	* @return	string	$date		The date and time.
	*/
	$ts = time();

	if ($offset > 0) {
		// Add the offset to the timestamp.
		$ts += $offset;
	} else if ($offset < 0) {
		// Subtract the offset from the timestamp.
		$ts -= $offset;
	}

	if ($date_only === TRUE) {
		return date("Y-m-d", $ts);
	} else {
		return date("Y-m-d H:i:s", $ts);
	}
}
