<?php
session_start();
unset($_SESSION["username"]);
unset($_SESSION["password"]);
unset($_SESSION["email"]);
unset($_SESSION["authenticated"]);
if(session_destroy())
{
header("Location: /PV/login.php");
	// header("Location: /PV/index.html");
}
?>