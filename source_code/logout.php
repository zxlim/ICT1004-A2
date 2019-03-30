<?php define("CLIENT", TRUE);
define("REQUIRE_AUTH", TRUE);
require_once("serverside/base.php");

$_SESSION["is_authenticated"] = FALSE;
$session_is_authenticated = FALSE;

session_end();

header("Location: login.php");