<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
    }
include ($_SERVER['DOCUMENT_ROOT'].'/PV/session_expiry.php'); 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php'); 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/email.php'); 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/usr/user-authenticate.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Update Reminders</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
</head>
<body >    

  <div class="login-form">
    <br><br><br>
 <div class="btn-group" role="group" aria-label="...">
 <button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/TaskManager/Reminder/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
<?php
// get value of id that sent from address bar
$id=$_GET['reminder_id'];
// Retrieve data from database 
$email_query="SELECT * FROM users WHERE uid='$uid'";
$email_result = mysqli_query($conn,$email_query) or die(mysqli_error($conn));
$row = mysqli_fetch_array($email_result);
$email=$row['email'];
$sql="SELECT * FROM reminder WHERE (rId = '$id' and uid='$uid')";
$result=mysqli_query($conn,$sql);
$rows=mysqli_fetch_array($result);
$rname=$rows['rName'];
?>
<form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
   <h3 class="text-center"><bold>Update for <?php echo "'".$rname."'"; ?></bold></h3><br>
   <p>Task Name</p>
   <div class="form-group"> <input  type="text"  class ="form-control input-lg" name="rname" value="<?php echo $rows['rName']; ?>"></div>
   <p>Reminder Date</p>
<div class="form-group"> <input type="date"  class ="form-control input-lg" name="rdate" value="<?php echo $rows['rDate']; ?>" ></div>
   <p>Reminder Time</p>
<div class="form-group"><input type="time" class ="form-control input-lg"  name="rtime" value="<?php echo $rows['rTime']; ?>" ></div>
   <p>Location</p>
<div class="form-group"><input type="text" class ="form-control input-lg"  name="place" value="<?php echo $rows['place']; ?>" ></div>
<p>Description</p>
  <div class="form-group"><textarea name="rdesc" class="form-control input-lg"  rows=4 cols=4 maxlength=250 ><?php echo $rows['rDesc']; ?> </textarea></div>

<input name="id" type="hidden" id="id" value="<?php echo $rows['rId']; ?>"/>
<div class="form-group clearfix"> <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit"  value="Update" /></div>
</form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 
   
<?php
if ( isset( $_POST['submit'] ) ){
  extract($_POST);
    $desc=addslashes($rdesc);
$sql="UPDATE reminder SET rName= '$rname',rDate= '$rdate',rTime= '$rtime',place= '$place',rDesc= '$desc' where (rId='$id' and uid='$uid')" ;
$result=mysqli_query($conn,$sql) or die ("Error");
// if successfully updated. 
if($result){
echo "<script type='text/javascript'>alert(\"Update successful!\")</script>";
echo "<script type='text/javascript'>window.location.href = '/PV/usr/TaskManager/Reminder/viewReminder.php';</script>";
echo "<BR>";
}
else {
echo "ERROR";echo "<script type='text/javascript'>alert(\"Error while updating!!\")</script>";
 echo "<script type='text/javascript'>window.location.href = '/PV/usr/TaskManager/Reminder/dashboard.php';</script>";}
}
?>
