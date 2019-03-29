<?php
##############################
# login.php
# Logic for processing email verification.
##############################

if (defined("CLIENT") === FALSE) {
	/**
	* Ghetto way to prevent direct access to "include" files.
	*/
	http_response_code(404);
	die();
}
require_once("serverside/base.php");
require_once("serverside/functions/database.php");
require_once("serverside/functions/security.php");

$gender = $loginid = $name = $email = $pwd = "";
$vericode = $vericodeErr ="";
$sessionveri = "";
$error = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["vericode"])) {
        $vericodeErr = "Please enter your verification code";
        $error += 1;
    } else {
        $vericode = test_input($_POST["vericode"]);
    }
    if ($error == 0) {
        //session_start();
        $sessionveri = $_SESSION["vericode"];
        //echo "User Input Veri Code-->   ".$vericode;
        //echo "Session Veri Code-->   ".$sessionveri;
       // if (isset($_SESSION['vericode'])) {

            if($sessionveri === $vericode){
                //echo "Verification Code Matches!", '<br>';
                //Insert new account to DB here.

                $conn = get_conn();
                $sql = $result = "";

                $name = $_SESSION["registerArray"][0];
                $loginid = $_SESSION["registerArray"][1];
                $pwd = $_SESSION["registerArray"][2];
                $email = $_SESSION["registerArray"][3];
                $gender = $_SESSION["registerArray"][4];

                $sql = "INSERT INTO user (name, loginid, password, email, gender)
                VALUES ('$name', '$loginid', '$pwd', '$email', '$gender')";

                if (mysqli_query($conn, $sql)) {
                    $last_id = mysqli_insert_id($conn);
                    //echo "New record created successfully. Last inserted ID is: " . $last_id;
                    $conn->close();
                    echo "<script> location.href='login.php'; </script>";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    $conn->close();
                }

//                foreach ($_SESSION["registerArray"] as $registerinfo){
//                    echo "Testing", '<br>';
//                    echo $registerinfo, '<br>';
//                }
            } else{
                echo "Don't match!";
            }
        //}
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

