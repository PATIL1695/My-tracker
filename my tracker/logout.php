<?php
session_start();
include ($_SERVER['DOCUMENT_ROOT'].'/PV/encryption.php');
unset($_SESSION["username"]);
unset($_SESSION["password"]);
unset($_SESSION["email"]);
unset($_SESSION["authenticated"]);
$uid=urlencode(encryptPassword($_SESSION['uid']));
if(session_destroy())
{
//header("Location: /PV/review.php?logoffUserAttributeTemp=$uid");
	header("Location: /PV/login.php");
}
?>