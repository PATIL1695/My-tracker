<?php
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');
include($_SERVER['DOCUMENT_ROOT'].'/PV/function.php');
include($_SERVER['DOCUMENT_ROOT'].'/PV/email.php');

function getEmail($uid,$conn)
{
$getEmail = mysqli_query($conn,"SELECT * FROM users where uid='$uid'");
$erow = mysqli_fetch_array($getEmail);
$email= $erow['email'];
return $email;
}

function writeComment($message)
{
	$filename=$_SERVER['DOCUMENT_ROOT'].'/PV/admin/scripts/logs/'.'SendReminderNotificationLog-'.date("Y-m-d:h:m:sa");
	$fh = fopen($filename, 'a');
	fwrite($fh, $message."\n");
	fclose($fh);	
}

function getUsers($conn)
{
$getUserList = mysqli_query($conn,"SELECT uid FROM reminder group by uid");
$count = mysqli_num_rows($getUserList);
  if($count==0)
  {
    echo "No reminders were created!";
    $message=date("Y-m-d h:m:sa").": No reminders were created!";
    writeComment($message);
    exit();
  }
 else
 {
 	while($row = mysqli_fetch_array($getUserList))
 	{
 	$uid=$row['uid'];
 	getReminderList($conn,$uid);
 	}
}
 mysqli_close($conn);
}

function getReminderList($conn,$uid)
{
$format_date=timeZoneConvert(date('Y-m-d'), 'MDT', 'PDT');
$today=substr($format_date, 0, 10);
$format_time=timeZoneConvert(date('h:m:s'), 'MDT', 'PDT');
$time=substr($format_time, 11, 19);
echo $time;
$getReminderList = mysqli_query($conn,"SELECT * FROM reminder where rDate='$today'and  uid='$uid'");
$email=getEmail($uid,$conn);
	$body='';
 	while($row = mysqli_fetch_array($getReminderList))
 	{
 	$rid=$row['rId'];
 	$rname=$row['rName'];
 	$rdate=$row['rDate'];
 	$rtime=$row['rtime'];
 	$place=$row['place'];
 	$desc=$row['rDesc'];
 	$msg="Reminder Details"."<br><br>"."Reminder Name: ".$rname."<br>"."Start Date and Time: ".$rdate." ".date('h:i:s a',$rtime)."<br>"."Location: ".$place."<br>"."Reminder Description: ".$desc."<br><br>"."</p>";

 	$message=date("Y-m-d h:m:sa").": UID: ". $uid."; Email: ". $email." Reminder Id= ".$rid." Reminder Name: ".$rname." Start Day and Time: ".$rdate." ".date('h:i:s a',$rtime)." Reminder Description: ".$desc."\n";
    writeComment($message);
    $body.=$msg;
 	}
 	sendFinalEmail($email,$body);
 }

function sendFinalEmail($email,$body)
{
	$subject="Reminder:";
	$content="<p>Welcome to Application"."<br><br>"."This is an email notification to remind you that following are the reminder(s) for ".date("m-d-Y h:m:sa").".<br><br>";
	$footer="<p>Note: This is an auto-generated email.</p>"."<br><br>"."---------------------------------------"."<br><br><br>"."Copyright PV Group 2018</p>";
  if($body==null){
      $message=date("Y-m-d h:m:sa").": UID: ". $uid."; Email: ". $email."No Reminders to Add";
  }
  else{
	$fbody=$content."\n".$body."\n\n".$footer;
   send_email($email,$fbody,$subject);
}
}

getUsers($conn);
?>




   