<?php declare(strict_types=1);

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

require_once("serverside/vendor/zxcvbn.php");


function validate_notempty(string $input): bool {
	/**
	* A function to check whether a string variable is empty.
	* Used for input validation.
	*
	* @param 	string	$input	The string to check.
	*
	* @return 	bool	$result	True if string is not empty else false.
	*/
	if (empty($input) || (strlen(trim($input)) === 0)) {
		return false;
	} else {
		return true;
	}
}

function validate_int($input): bool {
	/**
	* A function to check whether a variable is a valid integer.
	* Used for input validation.
	*
	* @param 	mixed	$input	The variable to check.
	*
	* @return 	bool	$result	True if variable is an integer else false.
	*/
	if (filter_var($input, FILTER_VALIDATE_INT) === false) {
		return false;
	} else {
		return true;
	}
}

function validate_email($input): bool {
	/**
	* A function to check whether a variable is a valid email address.
	* Used for input validation.
	*
	* @param 	mixed	$input	The variable to check.
	*
	* @return 	bool	$result	True if variable is an email address else false.
	*/
	if (filter_var($input, FILTER_VALIDATE_EMAIL) === false) {
		return false;
	} else {
		return true;
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
	* @return 	bool	$result	True if password is valid else false.
	*/
	$zxcvbn = new Zxcvbn();
	$strength = $zxcvbn->passwordStrength($input, $data);
	if (strlen($input) < 8 || (int)($strength["score"]) < 2) {
		return false;
	} else {
		return false;
	}
}