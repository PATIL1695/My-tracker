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
include ($_SERVER['DOCUMENT_ROOT'].'/PV/email.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Add Reminder</title>

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
 <div  align="center" class="btn-group" role="group" aria-label="...">
<button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/TaskManager/Reminder/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
  
 <form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
     <h3 class="text-center">Add Reminder</h3><br>
        <div class="form-group">Remind me about: <input type="text" class="form-control input-lg" placeholder="Remind me about" name="rname" id="name" required></div>
             <div class="form-group">Reminder Date:<br> <input class="form-control input-lg" type="date" name="rdate" id="sdate"  min="2018-01-01" max="2020-01-01" required></div>
             <div class="form-group">Reminder Time:<br> <input class="form-control input-lg" type="time" name="rtime" id="sdate" required></div>
             <div class="form-group">Location: <input type="text" class="form-control input-lg" placeholder="Place" name="place" id="name" ></div>
             <div class="form-group">Description: <textarea name="rdesc" class="form-control input-lg" placeholder="Comments"  rows=3 cols=3 maxlength=1000></textarea><br></div>
       <div class="form-group clearfix">  <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Add Reminder">
          </div></form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 


<?php

if($uid==NULL or $uid=="")
  {
    echo "<script type='text/javascript'>alert(\"Something went wrong!\")</script>";
    exit();
  }
if ( isset( $_POST['submit'] ) ){
  $email_query="SELECT * FROM users WHERE uid='$uid'";
$email_result = mysqli_query($conn,$email_query) or die(mysqli_error($conn));
$row = mysqli_fetch_array($email_result);
$email=$row['email'];
  extract($_POST);
  $desc=addslashes($rDesc);
$check_reminder_query="SELECT * from reminder where ((rName='$rname') and (rDate='$rdate') and (rTime='$rtime') and (place='$place')  and  (uid='$uid'));";
      $res=mysqli_query($conn,$check_reminder_query);
      if (mysqli_num_rows($res) > 0) {
          echo "<script type='text/javascript'>alert(\"This reminder already exists!!\")</script>";
       }
else{
$sql = "INSERT INTO reminder (`uid`,`rName`,`rDesc`,`rDate`,`rTime`,`place`) VALUES('$uid','$rname','$rdesc','$rdate','$rtime','$place')";
if (mysqli_query($conn, $sql)) {
  echo "<script type='text/javascript'>alert(\"Reminder has been added!!\")</script>";
} else {
    echo "Error adding Reminder! " . mysqli_error($conn);
}
mysqli_close($conn);
}
}
?>
