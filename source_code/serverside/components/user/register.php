<?php
##############################
# register.php
# Logic for processing user registration.
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
require_once("serverside/functions/security.php");
require_once("serverside/functions/database.php");
require_once("serverside/vendor/PHPMailer.php");

use PHPMailer\PHPMailer\PHPMailer;


$error_register = FALSE;
$error_message = NULL;

$gender = "N";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// POST request.
	if (validate_notempty($_POST["name"]) === FALSE) {
		$error_register = TRUE;
		$error_name = "Please enter your name.";
	}
	
	if (validate_notempty($_POST["loginid"]) === FALSE) {
		$error_register = TRUE;
		$error_loginid = "Please enter a Login ID.";
	}

	if (validate_notempty($_POST["email"]) === FALSE) {
		$error_register = TRUE;
		$error_email = "Please enter your email address.";
	} else if (validate_email($_POST["email"]) === FALSE) {
		$error_register = TRUE;
		$error_email = "Please enter a valid email address.";
	}

	if (validate_notempty($_POST["gender"]) === FALSE) {
		// Gender is optional in the requirements spec sheet.
		$_POST["gender"] = "N";
		// $error_register = TRUE;
		// $error_gender = "Please select a gender.";
	}

	if (validate_notempty($_POST["password1"]) === FALSE) {
		$error_register = TRUE;
		$error_pw1 = "Please enter your password.";
	} else if (validate_notempty($_POST["password2"]) === FALSE) {
		$error_register = TRUE;
		$error_pw2 = "Please confirm your password.";
	} else if ($_POST["password1"] !== $_POST["password2"]) {
		$error_register = TRUE;
		$error_pw2 = "Please check that you have entered the correct password.";
	} else if (validate_password($_POST["password1"], array($_POST["name"], $_POST["loginid"], $_POST["email"]))) {
		$error_register = TRUE;
		$error_pw1 = "Please choose a stronger password.";
	}

	if ($error_register === FALSE) {
		// Second round: Enforce unique entries for some data.

		$sql_loginid = "SELECT id FROM user WHERE loginid = ?";
		$sql_email = "SELECT id FROM user WHERE email = ?";

		$conn = get_conn();

		if ($query = $conn->prepare($sql_loginid)) {
			$query->bind_param("s", $_POST["loginid"]);
			$query->execute();
			$query->bind_result($id);

			if ($query->fetch()) {
				$error_register = TRUE;
				$error_loginid = "Please choose another Login ID.";
			}

			$query->close();
		}

		if ($query = $conn->prepare($sql_email)) {
			$query->bind_param("s", $_POST["email"]);
			$query->execute();
			$query->bind_result($id);

			if ($query->fetch()) {
				$error_register = TRUE;
				$error_email = "Please choose another email address.";
			}

			$query->close();
		}

		$conn->close();
	}

	if ($error_register === FALSE) {
		// After passing second round.
		switch (trim($_POST["gender"])) {
			case "M":
				// Male.
				$gender = "M";
				break;
			case "F":
				// Female.
				$gender = "F";
				break;
			case "O":
				// Others.
				$gender = "O";
				break;
			default:
				// Not specified, prefer not to say.
				$gender = "N";
				break;
		}

		date_default_timezone_set(APP_TZ);

		if (session_isstarted() === TRUE) {
			session_restart();
		} else {
			session_start();
		}

		$_SESSION["is_register"] = TRUE;
		$_SESSION["registration_data"] = array(
			"name" => trim($_POST["name"]),
			"loginid" => trim($_POST["loginid"]),
			"password" => pw_hash($_POST["password1"]),
			"email" => trim($_POST["email"]),
			"gender" => $gender,
			"code" => trim(generate_token(12)),
			"code_attempt" => 0,
			"code_expiry" => (int)(strtotime(get_datetime(FALSE, 900))),
		);

		$data = $_SESSION["registration_data"];

		$mailer = new PHPMailer();
		$mailer->isSMTP();
		$mailer->SMTPDebug = 0;
		$mailer->Host = SMTP_HOST;
		$mailer->Port = SMTP_PORT;
		$mailer->SMTPSecure = SMTP_CRYPTO;
		$mailer->SMTPAuth = SMTP_AUTH;
		$mailer->Username = SMTP_USER;
		$mailer->Password = SMTP_PASS;
		$mailer->setFrom(SMTP_FROM, SMTP_FROM_NAME);
		$mailer->addReplyTo(SMTP_REPLY, SMTP_REPLY_NAME);
		$mailer->addAddress($data["email"], $data["name"]);
		$mailer->isHTML(true);
		$mailer->Subject = "[FastTrade 08] Please verify your email address";

		$mailer->Body = sprintf(
			("Hello %s,<br /><br />" .
			"Thank you for registering an account with us!<br />" .
			"In order to complete registration, you need to verify your email address using the following verification code:" .
			"<br /><br />" .
			"<strong>%s</strong>" .
			"<br /><br />" .
			"The verification code will expire in 15 minutes.<br />" .
			"If you did not perform this action, you may safely ignore this email." .
			"<br /><br /><br />" .
			"Yours sincerely,<br />FastTrade 08 Support<br />"),
			$data["name"], $data["code"]);

		$mailer->AltBody = sprintf(
			("Hello %s,\n\n" .
			"Thank you for registering an account with us!\n" .
			"In order to complete registration, you need to verify your email address using the following verification code:" .
			"\n\n%s\n\nThe verification code will expire in 15 minutes.\n" .
			"If you did not perform this action, you may safely ignore this email.\n\n\n" .
			"Yours sincerely,\nFastTrade Support"),
			$data["name"], $data["code"]);

		if (!$mailer->send()) {
			session_end();
			$error_register = TRUE;
			$error_message = "An error has been encountered. Please try again later.";
		} else {
			header("Location: verify.php");
		}
	}
}
