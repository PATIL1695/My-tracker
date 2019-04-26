<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(empty($_SESSION["authenticated"]) || $_SESSION["user"] != 'true') {
    header('Location: /PV/usr/user-error.php');
}
?>