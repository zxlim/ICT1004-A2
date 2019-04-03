<?php declare(strict_types=1);
/**
* @license		MIT License
* @copyright	Copyright (c) 2019 Zhao Xiang.
*
* @author		ZHAO XIANG LIM	(developer@zxlim.xyz)
*/

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

require_once("serverside/vendor/zxcvbn.php");

use ZxcvbnPhp\Zxcvbn;


function validate_notempty($input, string $type = "string"): bool {
	/**
	* A function to check whether a variable is empty or not yet set.
	* Used for input validation.
	*
	* @param 	mixed	$input	The input to check.
	* @param 	string	$type	The input type (String or Array.
	*
	* @return 	bool	$result	TRUE if variable is not empty else FALSE.
	*/
	if (isset($input) === FALSE || $input === NULL) {
		return FALSE;
	} else if ($type === "string" && (strlen(trim($input)) === 0 || empty($input))) {
		return FALSE;
	} else if ($type === "array" && count($input) === 0) {
		return FALSE;
	} else {
		return TRUE;
	}
}

function validate_numeric($input): bool {
	/**
	* A function to check whether a variable is a valid number.
	* Used for input validation.
	*
	* @param 	mixed	$input	The variable to check.
	*
	* @return 	bool	$result	TRUE if variable is a number else FALSE.
	*/
	if (isset($input) === FALSE || $input === NULL) {
		return FALSE;
	} else {
		return is_numeric($input);
	}
}

function validate_int($input): bool {
	/**
	* A function to check whether a variable is a valid integer.
	* Used for input validation.
	*
	* @param 	mixed	$input	The variable to check.
	*
	* @return 	bool	$result	TRUE if variable is an integer else FALSE.
	*/
	if (isset($input) === FALSE || $input === NULL) {
		return FALSE;
	} else if (filter_var($input, FILTER_VALIDATE_INT) !== 0 && filter_var($input, FILTER_VALIDATE_INT) === FALSE) {
		return FALSE;
	} else {
		return TRUE;
	}
}

function validate_float($input): bool {
	/**
	* A function to check whether a variable is a valid float.
	* Used for input validation.
	*
	* @param 	mixed	$input	The variable to check.
	*
	* @return 	bool	$result	TRUE if variable is a float else FALSE.
	*/
	if (isset($input) === FALSE || $input === NULL) {
		return FALSE;
	} else {
		return is_float($input);
	}
}

function validate_email($input): bool {
	/**
	* A function to check whether a variable is a valid email address.
	* Used for input validation.
	*
	* @param 	mixed	$input	The variable to check.
	*
	* @return 	bool	$result	TRUE if variable is an email address else FALSE.
	*/
	if (isset($input) === FALSE || $input === NULL) {
		return FALSE;
	} else if (filter_var($input, FILTER_VALIDATE_EMAIL) === FALSE) {
		return FALSE;
	} else {
		return TRUE;
	}
}

function validate_password(string $input, array $data = array()): bool {
	/**
	* A function to check whether a password is valid (Meets requirements).
	* Makes use of the zxcvbn algorithm by Dropbox. Used for input validation.
	*
	* @param 	string	$input	The password to check.
	* @param	array	$data	Additional user input data to compare with password input.
	*
	* @return 	bool	$result	TRUE if password is valid else FALSE.
	*/
	if (isset($input) === FALSE || $input !== NULL) {
		$zxcvbn = new Zxcvbn();
		$strength = $zxcvbn->passwordStrength($input, $data);

		if (strlen($input) >= 8 && (int)($strength["score"]) >= 2) {
			return TRUE;
		}
	}

	return FALSE;
}