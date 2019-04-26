<?php 
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
        $username = $_SESSION['username'];

    }
include($_SERVER['DOCUMENT_ROOT'].'/PV/usr/user-authenticate.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>User Job Home Page</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<link rel="stylesheet" href="/PV/google/google.css">
       
</head>
<body ><br><br><br>
<div class="login-form">
  <div class="btn-group" role="group" aria-label="...">
  <button type="button" onclick="window.location.href='/PV/user-home.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/jobs/index.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
        <?php
        echo "<h4 align='center'>Welcome ".strtoupper($_SESSION['username'])."</h4>"; 
echo "<h5 align='center'><i>"."This is your Job Home Page"."</i></h5><br><br>";?>
    <div class="form-group"><font size="4"><ul align="center" class="list-group" >
 <li class="list-group-item"> <a href="/PV/usr/jobs/add-jobs.php">Add jobs applied</a></li>
       <li class="list-group-item"> <a href="/PV/usr/jobs/display-info-before-update.php">Update jobs applied</a></li>
       <li class="list-group-item"> <a href="/PV/usr/jobs/delete-jobs.php">Delete jobs applied</a></li>
       <li class="list-group-item"> <a href="/PV/usr/jobs/view-all-jobs.php">View jobs applied</a></li>
  <li class="list-group-item"> <a href="/PV/usr/jobs/job-search.php">Search jobs applied</a></li>

    <li class="list-group-item"> <a href="/PV/usr/jobs/import-jobs.php">Import jobs applied</a></li>

</ul></font></div>
</body>
   <br><br><p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 
