<?php declare(strict_types=1);

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

function pw_hash(string $password): string {
	/**
	* A function to hash a plaintext password using bcrypt.
	*
	* @param	string	$password	The password string to hash.
	*
	* @return	string	$hash		The resultant hash.
	*/
	$hash = password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);

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