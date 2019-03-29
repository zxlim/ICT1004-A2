<?php define("CLIENT", TRUE);
require_once("serverside/base.php");

//echo "Logout Successfully ";

session_end();   // function that Destroys Session
header("Location: index.php");