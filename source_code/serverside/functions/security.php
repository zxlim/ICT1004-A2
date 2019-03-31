<?php declare(strict_types=1);

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

require_once("serverside/functions/validation.php");


function secure_strcmp(string $str1, string $str2): bool {
	/**
	* A function to securely compare 2 strings.
	* Mitigates timing analysis attempts (Timing attack).
	*
	* @param	string	$str1		The user-controlled input strong.
	* @param	string	$str2		The string to compare with.
	*
	* @return	string	$r			TRUE if both string matches else FALSE.
	*/

	if (validate_notempty($str1) === FALSE || validate_notempty($str2) === FALSE) {
		// A string is empty.
		return FALSE;
	}

	$s1 = str_split($str1);
	$s2 = str_split($str2);
	array_push($s1, "");
	array_push($s2, "");

	$a = 0;
	$b = 0;
	$c = 0;
	$r = 0;

	while (TRUE) {
		$r |= ord($s1[$a]) ^ ord($s2[$b]);

		if (count($s1) === ($a + 1)) {
			break;
		}

		$a += 1;

		if (count($s2) !== ($b + 1)) {
			$b += 1;
		}
		if (count($s2) === ($b + 1)) {
			$c += 1;
		}
	}

	return (bool)($r === 0);
}

function generate_token(int $len = 16): string {
	/**
	* A function to generate a cryptographically secure random token.
	*
	* @param	int		$len		The length of random bytes to generate.
	*
	* @return	string	$token		The random token.
	*/
	return bin2hex(random_bytes($len));
}

function sha256(string $input): string {
	/**
	* A function to generate a SHA256 hash.
	*
	* @param	string	$input		The input to hash.
	*
	* @return	string	$hash		The resultant hash.
	*/
	return hash("sha256", $input, FALSE);
}

function pw_hash(string $password): string {
	/**
	* A function to hash a plaintext password using bcrypt.
	*
	* @param	string	$password	The password string to hash.
	*
	* @return	string	$hash		The resultant hash.
	*/
	$hash = password_hash($password, PASSWORD_BCRYPT, ["cost" => 14]);

	if ($hash === FALSE) {
		// Something went wrong when hashing.
		return "";
	}

	return $hash;
}


function pw_verify(string $password, string $hash): bool {
	/**
	* A function to validate whether a plaintext password
	* matches the hash stored on the server-side.
	*
	* @param	string	$password	The plaintext password.
	* @param	string	$hash		The hashed password.
	*
	* @return	bool	$result		TRUE if password is validated else FALSE.
	*/
	return password_verify($password, $hash);
}