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


require_once("serverside/functions/validation.php");
require_once("serverside/functions/database.php");
require_once("serverside/vendor/zxcvbn.php");
require_once("serverside/functions/security.php");
require_once("serverside/components/session.php");

// define variables and set to empty values
$loginid = $pwd = "";
$error = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["loginid"])) {
        $loginidErr = "Please enter a Login ID";
        $error += 1;
    } else {
        $loginid = test_input($_POST["loginid"]);
    }
    if (empty($_POST["pwd"])) {
        $pwdErr = "Please enter the Password";
        $error += 1;
    } else {
        $pwd = test_input($_POST["pwd"]);
    }

    if ($error == 0) {
        $conn = get_conn();
        $dbarray = $sql = $dbpwd = $result = "";


        //Call the DB and get the hash and compare with the hashed input pwd here.
        //$pwd = pw_hash($pwd); //Hashed input pwd

        //Querying hashed pwd in DB
        $sql = "SELECT * FROM user WHERE loginid='$loginid'";
        $results = mysqli_query($conn, $sql);
        $dbarray = mysqli_fetch_assoc($results);

        if ($dbarray) { // if array exists
           // echo "Input password: " . $pwd; // This is the input hashed password of the loginID
           // echo "       Password in DB: " . $dbarray["password"]; // This is the DB hashed password of the loginID

            if(!pw_verify($pwd, $dbarray["password"])){
                echo "Wrong Password";
            } else {
                session_start();
                $_SESSION["loginid"] = $loginid;
                $_SESSION["user_id"] = $dbarray["id"];
                echo "<script> location.href='index.php'; </script>";
                exit;
            }
        }
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

#use ZxcvbnPhp\Zxcvbn;
