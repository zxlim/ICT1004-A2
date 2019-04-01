<?php
##############################
# login.php
# Logic for processing user authentication.
##############################

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}

if ($session_is_authenticated === TRUE) {
	header("HTTP/1.1 403 Forbidden");
	header("Location: index.php");
	die("You are not allowed to access the requested resource.");
}

require_once("serverside/functions/validation.php");
require_once("serverside/functions/database.php");
require_once("serverside/functions/security.php");

$delay = FALSE;
$error_login = FALSE;
$error_message = "Invalid credentials.";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	// POST request.

	if (isset($_POST["loginid"]) === FALSE || validate_notempty($_POST["loginid"]) === FALSE) {
		$error_login = TRUE;
		$error_message = "Please enter your Login ID.";
	} else if (isset($_POST["password"]) === FALSE || validate_notempty($_POST["password"]) === FALSE) {
		$error_login = TRUE;
		$error_message = "Please enter your password.";
	} else {
		// Input fields validated.
		$sql = "SELECT id, loginid, name, password, admin FROM user WHERE loginid = ?";

		$conn = get_conn();

		if ($query = $conn->prepare($sql)) {
			$query->bind_param("s", $_POST["loginid"]);
			$query->execute();
			$query->bind_result($id, $loginid, $name, $password, $is_admin);

			if ($query->fetch()) {
				if (pw_verify($_POST["password"], $password) === TRUE) {
					// Authentication successful.
					session_start();
					$_SESSION["is_authenticated"] = TRUE;
					$_SESSION["is_admin"] = (bool)$is_admin;
					$_SESSION["user_id"] = (int)($id);
					$_SESSION["user_loginid"] = $loginid;
					$_SESSION["user_name"] = $name;
				} else {
					// Password mismatch.
					$delay = TRUE;
					$error_login = TRUE;
				}

				// Unset the value of the password variable.
				unset($password);
			} else {
				// No such Login ID.
				$delay = TRUE;
				$error_login = TRUE;
			}

			$query->close();
		} else {
			// Something went wrong.
			$error_login = TRUE;
			$error_message = "An error has been encountered. Please try again later.";
		}

		$conn->close();

		if ($delay === TRUE) {
			// Deter brute force attempts.
			sleep(2);
		} else if ($error_login === FALSE) {

            $conn = get_conn();
            $sql = "SELECT admin from user WHERE loginid = '".$loginid."'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if($row["admin"] == 0 || $row["admin"] == NULL){
                    header("Location: index.php");
                }
            }
            $conn->close();

			header("Location: admin_page.php");
		}
	}
}
