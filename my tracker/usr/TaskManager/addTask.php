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
<title>Add Task</title>

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
  <button type="button" onclick="window.location.href='/PV/usr/TaskManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
  
 <form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
     <h3 class="text-center">Add Task</h3><br>
        <div class="form-group"> <input type="text" class="form-control input-lg" placeholder="Task Name" name="tname" id="name" required></div>
             <div class="form-group">Task Start Date:<br> <input class="form-control input-lg" type="date" name="sdate" id="sdate"  min="2018-01-01" max="2020-01-01" required></div>
             <div class="form-group">Task Start Time:<br> <input class="form-control input-lg" type="time" name="stime" id="sdate" required></div>
             <div class="form-group">Task End Date:<br> <input class="form-control input-lg" type="date" name="edate" id="sdate"  min="2018-01-01" max="2020-01-01" required></div>
             <div class="form-group">Task Time:<br> <input class="form-control input-lg" type="time" name="etime"  required></div>
            <div class="form-group"> <textarea name="taskDesc" class="form-control input-lg" placeholder="Please describe the Task/Problem"  rows=7 cols=7 maxlength=1000 required></textarea><br></div>
       <div class="form-group clearfix">  <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Add Task">
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
  $desc=addslashes($taskDesc);
  if ($edate<$sdate )
{
 echo "<script type='text/javascript'>alert(\"End Date cannot be less than Start Date!\")</script>";
}
 else if ($edate==$sdate and $etime<$stime )
{
 echo "<script type='text/javascript'>alert(\"End Time cannot be less than Start Time!\")</script>";
}
else
{
$check_task_query="SELECT * from task where ((taskName='$tname') and (startDate='$sdate') and (stime='$stime') and (endDate='$edate') and (etime='$etime') and  (uid='$uid'));";
      $res=mysqli_query($conn,$check_task_query);
      if (mysqli_num_rows($res) > 0) {
          echo "<script type='text/javascript'>alert(\"This task already exists!!\")</script>";
       }
else{
$sql = "INSERT INTO task (`uid`,`taskName`,`taskDesc`,`startDate`,`stime`,`endDate`,`etime`,`addedBy`,`taskStatus`) VALUES('$uid','$tname','$desc','$sdate','$stime','$edate','$etime','user','Created')";
if (mysqli_query($conn, $sql)) {
  echo "<script type='text/javascript'>alert(\"Task has been added!!\")</script>";
   $message="<p>Welcome to Application"."<br><br>"."This is an email notification to notify that a task has been added."."<br><br>"."Task Details"."<br><br>"."Task Name: ".$tname."<br>"."Start Date and Time: ".$sdate." ".date('h:i:s a',$stime)."<br>"."End Date and Time: ".$edate." ".date('h:i:s a',$etime)."<br>"."Task Status:  Created"."<br>"."Task Description: ".$taskDesc."<br><br>"."---------------------------------------"."<br><br><br>"."Copyright PV Group 2018</p>";
      $subject="New Task Added.";
      send_email($email,$message,$subject);
} else {
    echo "Error adding Task! " . mysqli_error($conn);
}
mysqli_close($conn);
}
}
}
?>
