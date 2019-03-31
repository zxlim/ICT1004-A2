<?php declare(strict_types=1);

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

function html_safe(string $string_raw): string {
	/**
	* A function to encode some predefined characters into HTML entities.
	*
	* @param	string	$string_raw	The string to encode and echo.
	*
	* @return	string	$str		The encoded string.
	*/
	// Encode string to UTF-8, then encode HTML entities.
	if (strlen(trim($string_raw)) !== 0) {
		$string = utf8_encode($string_raw);
		return htmlspecialchars($string);
	}
	return "";
}

function safe_echo($string): void {
	/**
	* A function to safely echo a string into an HTML template.
	* Makes use of `html_safe` function.
	*
	* @param	mixed	$string		The string to echo.
	*/
	if ($string !== NULL) {
		$str = (string)($string);
		echo(html_safe($str));
	}
}

function truncate(string $string_raw, int $limit): string {
	/**
	* A function to truncate a string to a predefined limit.
	*
	* @param	string	$string_raw	The string to truncate.
	* @param	int		$limit		The point to truncate at.
	*
	* @return	string	$str		The truncated string.
	*/
	return mb_strimwidth($string_raw, 0, $limit, "...");
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

function get_datetime(bool $date_only = FALSE, int $offset = 0, string $tz = APP_TZ): string {
	/**
	* Returns the date and time, accounting for any offset provided in seconds.
	*
	* @param	bool	$date_only	Only return the date without time.
	* @param	int		$offset		The offset in seconds to add/subtract from
	*								the date and time.
	* @param	string	$tz			The timezone to use when getting the date.
	*
	* @return	string	$date		The date and time.
	*/
	if (in_array($tz, timezone_identifiers_list(), TRUE) === TRUE) {
		// Valid timezone passed, use it.
		date_default_timezone_set($tz);
	} else {
		// Default timezone.
		date_default_timezone_set(APP_TZ);
	}

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
