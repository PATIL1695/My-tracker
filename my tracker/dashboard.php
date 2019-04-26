<?php 
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
    }
include($_SERVER['DOCUMENT_ROOT'].'/PV/usr/user-authenticate.php');
function timeZoneConvert($fromTime, $fromTimezone, $toTimezone,$format = 'Y-m-d h:i:s a') {
     // create timeZone object , with fromtimeZone
    $from = new DateTimeZone($fromTimezone);
     // create timeZone object , with totimeZone
    $to = new DateTimeZone($toTimezone);
    // read give time into ,fromtimeZone
    $orgTime = new DateTime($fromTime, $from);
    // fromte input date to ISO 8601 date (added in PHP 5). the create new date time object
    $toTime = new DateTime($orgTime->format("c"));
    // set target time zone to $toTme ojbect.
    $toTime->setTimezone($to);
    // return reuslt.
    return $toTime->format($format);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>User Home</title>
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

  <?php
  $last_login=$_SESSION['lastlogin'];
if($last_login=="0000-00-00 00:00:00")
{
echo "<h4 align='center'>Welcome ".strtoupper($_SESSION['username'])."</h4>"; 
echo "<h5 align='center'><i>"."This is your first login"."</i></h5><br><br>";
}
else{
  $last_login1=timeZoneConvert($last_login, 'MDT', 'PDT');
echo "<h4 align='center'>Welcome ".strtoupper($_SESSION['username'])."</h4>"; 
echo "<h5 align='center'><i>Last Login: ".$last_login1.' PDT'."</i></h5><br><br>";
}
 ?>
        <div class="form-group"><font size="4"><ul align="center" class="list-group" >

       
  <li class="list-group-item "><a href="/PV/usr/update-password.php">Update Account Password</a></li>
       <li class="list-group-item"> <a href="/PV/usr/update-email.php">Update Account Email</a></li>
       <li class="list-group-item"> <a href="/PV/usr/jobs/index.php">Jobs Home</a></li>
              <li class="list-group-item"> <a href="/PV/usr/ExpenseManager/dashboard.php">Expense Mananger Home</a></li>
                        <li class="list-group-item"> <a href="/PV/usr/PasswordManager/dashboard.php">Password Mananger Home</a></li>
                        <li class="list-group-item "><a href="/PV/usr/myDrive/dashboard.php">myDrive</a></li>
                        <li class="list-group-item"> <a href="/PV/usr/TaskManager/dashboard.php">Task Mananger Home</a></li>
<li class="list-group-item"> <a href="/PV/usr/unsubscribe-mail.php">Unsubscribe from getting e-mail notifications</a></li>
 <li class="list-group-item"> <a href="/PV/usr/notify-admin.php">Notify Admin</a></li>
       <li class="list-group-item"> <a href="/PV/usr/delete-account.php">Delete Account</a></li>
</ul></font></div>
</body>
   <br><br><p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 
