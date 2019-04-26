<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
    }
include ($_SERVER['DOCUMENT_ROOT'].'/PV/session_expiry.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/usr/user-authenticate.php'); 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/encryption.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/PV/function.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Reminder Home Page</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.alert-bad {
    padding: 3px;
    background-color: #f44336;
    color: white;
}

.alert-good {
    padding: 3px;
    background-color: #008000;
    color: white;
}
</style> 
</head>
<body ><br><br><br>
<div class="login-form">
   <button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
    <button type="button" onclick="window.location.href='/PV/usr/TaskManager/Reminder/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
        </button></p></p>
  <?php
        echo "<h4 align='center'>Welcome ".strtoupper($_SESSION['username'])."</h4>"; 
  echo "<h5 align='center'><i>"."This is your Reminder Home Page"."</i></h5>"; ?>
<div class="alert-good">
<?php
$format_date=timeZoneConvert(date('Y-m-d'), 'MDT', 'PDT');
$today=substr($format_date, 0, 10);
$get_today_task = mysqli_query($conn,"SELECT * FROM reminder where rDate='$today' and uid='$uid'");
$count = mysqli_num_rows($get_today_task);
if ($count==0)
{
  echo "<p align='center'>You don't have any reminder for today!</p>";
}
else{
echo "<h4><bold>Today's reminder(s):</bold></h4>";
$i=1;
while($row=mysqli_fetch_array($get_today_task))
{
echo $i.") ".$row['rName']."<br>";
$i+=1;
}
}
?>
</div><br>
        <div class="form-group"><font size="4"><ul align="center" class="list-group" >
  <li class="list-group-item"> <a href="/PV/usr/TaskManager/Reminder/addReminder.php">Add Reminder</a></li>
   <li class="list-group-item"> <a href="/PV/usr/TaskManager/Reminder/viewReminder.php">View/Update/Delete Reminder</a></li>
  </ul></font></div>
</body>
   <br><br><p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 

