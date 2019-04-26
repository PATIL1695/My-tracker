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
<title>Update Tasks</title>
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
  <button type="button" onclick="window.location.href='/PV/usr/TaskManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
<?php
// get value of id that sent from address bar
$id=$_GET['task_id'];
// Retrieve data from database 
$email_query="SELECT * FROM users WHERE uid='$uid'";
$email_result = mysqli_query($conn,$email_query) or die(mysqli_error($conn));
$row = mysqli_fetch_array($email_result);
$email=$row['email'];
$sql="SELECT * FROM task WHERE (taskId = '$id' and uid='$uid')";
$result=mysqli_query($conn,$sql);
$rows=mysqli_fetch_array($result);
$tname=$rows['taskName'];
?>
<form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
   <h3 class="text-center"><bold>Update for <?php echo "'".$tname."'"; ?></bold></h3><br>
   <p>Task Name</p>
   <div class="form-group"> <input  type="text"  class ="form-control input-lg" name="taskName" value="<?php echo $rows['taskName']; ?>"></div>
   <p>Start Date</p>
<div class="form-group"> <input type="date"  class ="form-control input-lg" name="startDate" value="<?php echo $rows['startDate']; ?>" ></div>
   <p>Start Time</p>
<div class="form-group"><input type="time" class ="form-control input-lg"  name="stime" value="<?php echo $rows['stime']; ?>" ></div>
<p>End Date</p>
<div class="form-group"> <input type="date"  class ="form-control input-lg" name="endDate" value="<?php echo $rows['endDate']; ?>" ></div>
   <p>End Time</p>
<div class="form-group"><input type="time" class ="form-control input-lg"  name="etime" value="<?php echo $rows['etime']; ?>" ></div>
<p>Completed Date</p>
<div class="form-group"> <input type="date"  class ="form-control input-lg" name="completedDate" value="<?php echo $rows['completedDate']; ?>" ></div>
   <p>Completed Time</p>
<div class="form-group"><input type="time" class ="form-control input-lg"  name="ctime" value="<?php echo $rows['ctime']; ?>" ></div>
<p>Task Status</p>
<div class="form-group">
                <select class ="form-control input-lg" name="taskStatus">
          <option value="<?php echo $rows['taskStatus']; ?>"><?php echo $rows['taskStatus'].'(Selected)'; ?></option>
               <option>In-Progress</option>
            <option>Completed</option>
                <option>Created</option>
                 <option>On-Hold</option>
                  <option>Others</option>
          </select> </div>
<p>Task Description</p>
  <div class="form-group"><textarea name="taskDesc" class="form-control input-lg"  rows=6 cols=6 maxlength=3000 ><?php echo $rows['taskDesc']; ?> </textarea></div>

<input name="id" type="hidden" id="id" value="<?php echo $rows['taskId']; ?>"/>
<div class="form-group clearfix"> <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit"  value="Update" /></div>
</form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 
   
<?php
function sendCompletedNotification($email,$taskName,$startDate,$stime,$endDate,$etime,$completedDate,$ctime,$taskDesc){
  $message="<p>Welcome to Application"."<br><br>"."This is an email notification to notify that a task has been completed."."<br><br>"."Task Summary"."<br><br>"."Task Name: ".$taskName."<br>"."Start Date and Time: "."<br>".$startDate." ".date('h:i:s a',$stime)."<br>"."End Date and Time: ".$endDate." ".date('h:i:s a',$etime)."<br>"."Completed Date and Time: ".$completedDate." ".date('h:i:s a',$ctime)."<br>"."Task Status:  Completed"."<br>"."Task Description: ".$taskDesc."<br><br>"."---------------------------------------"."<br><br><br>"."Copyright PV Group 2018</p>";
      $subject="Task Completed.";
      send_email($email,$message,$subject);
}


if ( isset( $_POST['submit'] ) ){
  extract($_POST);
    $desc=addslashes($taskDesc);
  if ($endDate<$startDate )
{
 echo "<script type='text/javascript'>alert(\"End Date cannot be less than Start Date!\")</script>";
}
 else if ($endDate==$startDate and $etime<$stime )
{
 echo "<script type='text/javascript'>alert(\"End Time cannot be less than Start Time!\")</script>";
}
else{
$sql="UPDATE task SET taskName= '$taskName',startDate= '$startDate',stime= '$stime',endDate= '$endDate', etime= '$etime',completedDate= '$completedDate', ctime= '$ctime', taskStatus= '$taskStatus', taskDesc= '$desc' where (taskId='$id' and uid='$uid')" ;
$result=mysqli_query($conn,$sql) or die ("Error");
echo $taskStatus;
if($taskStatus=="Completed"){
  sendCompletedNotification($email,$taskName,$startDate,$stime,$endDate,$etime,$completedDate,$ctime,$taskDesc);
}
else{
  echo "";
}
// if successfully updated. 
if($result){
echo "<script type='text/javascript'>alert(\"Update successful!\")</script>";
echo "<script type='text/javascript'>window.location.href = '/PV/usr/TaskManager/display-before-update.php';</script>";
echo "<BR>";
}
else {
echo "ERROR";echo "<script type='text/javascript'>alert(\"Error while updating!!\")</script>";
 echo "<script type='text/javascript'>window.location.href = '/PV/usr/TaskManager/dashboard.php';</script>";}
}
}
?>
