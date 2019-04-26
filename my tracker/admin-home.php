<?php 
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
    }
include($_SERVER['DOCUMENT_ROOT'].'/PV/admin/admin-authenticate.php');
$last_login=date_create($_SESSION['lastlogin']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin home</title>
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
 <p align="right">  <button onclick="window.location.href='/PV/logout.php'"type="button" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-log-out"></span> Log out
        </button></p>
  <?php echo "<h4 align='center'>Welcome ".strtoupper($_SESSION['username'])."</h4>"; ?>
  <?php echo "<h5 align='center'><i>Last Login: ".date_format($last_login,"l, Y/m/d h:i:s A I")."</i></h5><br><br>";?>
        <div class="form-group"><font size="4"><ul align="center" class="list-group" >
  <li class="list-group-item "><a href="/PV/admin/update-password.php">Update Account Password</a></li>
  <li class="list-group-item "><a href="/PV/admin/update-email.php">Update Account Email</a></li>
  <li class="list-group-item"> <a href="/PV/admin/view-users.php">View Users</a></li>
  <li class="list-group-item"> <a href="/PV/admin/delete-user.php">Delete Users</a></li>
  <li class="list-group-item"> <a href="/PV/admin/delete-feedback.php">Delete User Feedback</a></li> 
  <li class="list-group-item"> <a href="/PV/admin/delete-temp-users.php">Delete Temp Users</a></li>
</ul></font></div>
</body>
   <br><br><p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 