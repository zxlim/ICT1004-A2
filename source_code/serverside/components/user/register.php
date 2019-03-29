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

require_once("serverside/functions/validation.php");
require_once("serverside/functions/database.php");
require_once("serverside/functions/security.php");
require ('serverside/PHPMailer/PHPMailerAutoload.php');
//require_once("serverside/vendor/zxcvbn.php");

//use ZxcvbnPhp\Zxcvbn;

// define variables and set to empty values
$gender = $loginid = $name = $email = $pwd = $pwdcfm = $verificationcode = "";
$genderError = $loginidErr = $nameErr = $emailErr = $pwdErr = $pwdcfmErr = $chbxErr = "";
$error = 0;
$mail = new PHPMailer(true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    if (empty($_POST["firstname"])) {
//        $firstnameErr = "Please enter your first name";
//    } else {
//        $firstname = test_input($_POST["firstname"]);
//    }
//    if (empty($_POST["lastname"])) {
//        $lastnameErr = "Please enter your last name";
//    } else {
//        $lastname = test_input($_POST["lastname"]);
//    }
    if (empty($_POST["name"])) {
        $nameErr = "Please enter your name";
        $error = 1;

    } else {
        $name = test_input($_POST["name"]);
    }

    if (empty($_POST["loginid"])) {
        $loginidErr = "Please enter a Login ID";
        $error = 1;

    } else {
        $loginid = test_input($_POST["loginid"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Please enter a email address";
        $error = 1;

    } else {
        $email = test_input($_POST["email"]);
    }

    if (empty($_POST["pwd"])) {
        $pwdErr = "Please enter the Password";
        $error = 1;

    } else {
        $pwd = test_input($_POST["pwd"]);
    }
    if (empty($_POST["pwdcfm"])) {
        $pwdcfmErr = "Please enter the confirmed Password";
        $error = 1;

    } else {
        $pwdcfm = test_input($_POST["pwdcfm"]);
    }
    if (empty($_POST["gender"])) {
        $genderError = "Please select a gender";
        $error = 1;

    } else {
        $gender = test_input($_POST["gender"]);
    }

    //Also need to tell them if loginID already existed, need to supply another
    if(!empty($_POST["loginid"])){
        $conn = get_conn();
        $sql = $result = "";
        $sql = "SELECT * FROM user WHERE loginid='$loginid'";
        $results = mysqli_query($conn, $sql);
        $dbarray = mysqli_fetch_assoc($results);

        if ($dbarray) { // if array exists
            $loginidErr = "LoginID already exist";
            $error = 1;
        }

    }

    if(!empty($_POST["email"])) {
        $conn = get_conn();
        $sql = $result = "";
        $sql = "SELECT * FROM user WHERE email='$email'";
        $results = mysqli_query($conn, $sql);
        $dbarray = mysqli_fetch_assoc($results);

        if ($dbarray) { // if array exists
            $emailErr = "Email already exist";
            $error = 1;
        }
    }

    if(!empty($_POST["email"])){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Please enter a valid email address";
            $error = 1;
        }
    }
    if (!empty($_POST["pwd"])) {
        if(strlen($pwd) < 8 || (!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $pwd))){
            $pwdErr = "Your password should be alphanumeric and contains at least 8 characters";
            $error = 1;
        }
    }
    if (!empty($_POST["pwdcfm"])) {
        if($pwdcfm != $pwd){
            $pwdcfmErr = "Your password confirm does not match your password";
            $error = 1;
        }
    }


    if ($error == 0) {

        // In this condition, you need to check for email verification also.
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP

//    $mail->Host       = 'smtp.mailgun.org';  // Specify main and backup SMTP servers
//    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
//    $mail->Username   = 'ict1004@fasttrade.zxlim.xyz';                     // SMTP username
//    $mail->Password   = '958246cb4df682de04c806c1bf7245fa4e348a7cd2ba6c21ba60af6ab61a2c70';                               // SMTP password

            $mail->Host       = 'smtp.mailgun.org';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'postmaster@fasttrade.zxlim.xyz';                     // SMTP username
            $mail->Password   = '7327c6e86a1ef1914fef0579249ed265-985b58f4-9669320e';                               // SMTP password

            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            //$mail->Port       = 587;                                  // TCP port to connect to
            $mail->Port       = 587;
            //Recipients
            $mail->setFrom('no-reply@fasttrade.zxlim.xyz', 'Mailer');
            $mail->addAddress('piedutch111@gmail.com', 'Joe User');     // Add a recipient
            // $mail->addAddress('ellen@example.com');               // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Email Verification from FastTrade';

            //Generate a random code
            $verificationcode = md5(uniqid(rand(), true));
            session_start();
            $_SESSION["vericode"] = $verificationcode;

            $mail->Body    = 'Hello '.$name.'!'.'<br><br>You have entered <b>'.$email.'</b> as your email address. <br><br> Verify your account by using this code! <br><br> '.$verificationcode;
            // <b>in bold!</b>
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        //HASH THE REGISTERED PASSWORD HERE BEFORE INSERTING INTO ARRAY
        $pwd = pw_hash($pwd);

        session_start();
        $registerArray = array($name, $loginid, $pwd, $email, $gender);
        $_SESSION["registerArray"] = $registerArray;
        echo "<script> location.href='verification.php'; </script>";
        exit;
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//if ($_SERVER["REQUEST_METHOD"] == "POST") {
////    $firstname = test_input($_POST["firstname"]);
////    $lastname = test_input($_POST["lastname"]);
//    $email = test_input($_POST["email"]);
//    $pwd = test_input($_POST["pwd"]);
//    $pwdcfm = test_input($_POST["pwdcfm"]);
//}



//    $result = mysqli_query($conn, $sql);
//    if (mysqli_num_rows($result) > 0) {
//        while($row = mysqli_fetch_assoc($result)) {
//            echo $row["name"];
//        }
//    }

    //Get datetime from function here



//}