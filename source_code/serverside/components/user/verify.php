<?php
##############################
# verify.php
# Logic for processing email verification.
##############################

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

require_once("serverside/functions/validation.php");
require_once("serverside/functions/security.php");
require_once("serverside/functions/database.php");

if ($session_is_authenticated === TRUE) {
	header("HTTP/1.1 403 Forbidden");
	header("Location: index.php");
	die("You are not allowed to access the requested resource.");
} else if (isset($_SESSION["is_register"]) === FALSE || $_SESSION["is_register"] === FALSE) {
	header("HTTP/1.1 403 Forbidden");
	header("Location: register.php");
	die("You are not allowed to access the requested resource.");
}


$error_validate = FALSE;
$error_message = NULL;

$email = $_SESSION["registration_data"]["email"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// POST request.
	if (validate_notempty($_POST["code"]) === FALSE) {
		$error_validate = TRUE;
		$error_message = "Please enter your verification code.";
	} else {
		$current_dt = get_datetime();
		$data = $_SESSION["registration_data"];

		if ((int)(strtotime($current_dt)) > $data["code_expiry"]) {
			// Verification code has expired. Invalidate the session to force registration restart.
			session_end();
			$error_validate = TRUE;
			$error_message = "Sorry, the verification code has expired. Please restart the registration process.";
		} else if (secure_strcmp($_POST["code"], $data["code"]) === FALSE) {
			$error_validate = TRUE;

			if ($data["code_attempt"] === 2) {
				// Max tries reached. Invalidate the session to force registration restart.
				session_end();
				$error_message = "Sorry, you have reached the maximum number of attempts. Please restart the registration process.";
			} else {
				$_SESSION["registration_data"]["code_attempt"] += 1;
				$error_message = "Invalid verification code. Please try again.";
			}
		} else {
			// Verification code correct.
			$sql = "INSERT INTO user (name, loginid, password, email, join_date, gender) VALUES (?, ?, ?, ?, ?, ?)";

			$conn = get_conn();

			if ($query = $conn->prepare($sql)) {
				$query->bind_param("ssssss",
					$data["name"], $data["loginid"], $data["password"], $data["email"], $current_dt, $data["gender"]
				);

				if (!$query->execute()) {
					// Something went wrong.
					$error_validate = TRUE;
					$error_message = "An error has been encountered. Please try again later.";
				}

				$query->close();
			} else {
				$error_validate = TRUE;
				$error_message = "An error has been encountered. Please try again later.";
			}

			$conn->close();

			if ($error_validate === FALSE) {
				// Code is verified.
				session_end();
				header("Location: login.php");
			}
		}
	}
}
