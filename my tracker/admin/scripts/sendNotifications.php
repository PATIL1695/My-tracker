<?php
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php'); 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/email.php'); 
function getEmail($uid,$conn)
{
$getEmail = mysqli_query($conn,"SELECT * FROM users where uid='$uid'");
$erow = mysqli_fetch_array($getEmail);
$email= $erow['email'];
return $email;
}

function writeComment($message)
{
	$filename=$_SERVER['DOCUMENT_ROOT'].'/PV/admin/scripts/logs/'.'SendNotificationLog-'.date("Y-m-d:h:m:sa");
	$fh = fopen($filename, 'a');
	fwrite($fh, $message."\n");
	fclose($fh);	
}

function getUsers($conn)
{
$getUserList = mysqli_query($conn,"SELECT uid FROM task group by uid");
$count = mysqli_num_rows($getUserList);
  if($count==0)
  {
    echo "No tasks were created!";
    $message=date("Y-m-d h:m:sa").": No tasks were created!";
    writeComment($message);
    exit();
  }
 else
 {
 	while($row = mysqli_fetch_array($getUserList))
 	{
 	$uid=$row['uid'];
 	getTaskList($conn,$uid);
 	}
}
 mysqli_close($conn);
}

function getTaskList($conn,$uid)
{
$getTaskList = mysqli_query($conn,"SELECT * FROM task where taskStatus!='Completed' and uid='$uid'");
$email=getEmail($uid,$conn);
	$body='';
 	while($row = mysqli_fetch_array($getTaskList))
 	{
 	$tid=$row['taskId'];
 	$tname=$row['taskName'];
 	$sdate=$row['startDate'];
 	$stime=$row['stime'];
 	$edate=$row['endDate'];
 	$etime=$row['etime'];
 	$desc=$row['taskDesc'];
 	$msg="Task Details"."<br><br>"."Task Name: ".$tname."<br>"."Start Date and Time: ".$sdate." ".date('h:i:s a',$stime)."<br>"."End Date and Time: ".$edate." ".date('h:i:s a',$etime)."<br>"."Task Status:  Created"."<br>"."Task Description: ".$desc."<br><br>"."</p>";
 	$message=date("Y-m-d h:m:sa").": UID: ". $uid."; Email: ". $email." Task Id= ".$tid." Task Name: ".$tname." Start Day and Time: ".$sdate." ".date('h:i:s a',$stime)." End Date and Time: ".$edate." ".date('h:i:s a',$etime)." Task Description: ".$desc."\n";
    writeComment($message);
    $body.=$msg;
 	}
 	sendFinalEmail($email,$body);
 }

function sendFinalEmail($email,$body)
{
	$subject="Daily Pending Task Summary";
	$content="<p>Welcome to Application"."<br><br>"."This is an email notification to remind you that following task(s) are pending as of ".date("m-d-Y").".<br><br>";
	$footer="<p>Note: This is an auto-generated email.</p>"."<br><br>"."---------------------------------------"."<br><br><br>"."Copyright PV Group 2018</p>";
	$fbody=$content."\n".$body."\n\n".$footer;
    send_email($email,$fbody,$subject);
}

getUsers($conn);
?>




   