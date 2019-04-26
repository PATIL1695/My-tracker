<?php
include('database.php');
session_start();
if ( isset( $_POST['submit'] ) ){
extract($_POST);
$star=$_POST['rating'];
if($uid==null)
{
    echo "<script type='text/javascript'>alert(\"Unauthorized Access!\")</script>";
    echo "Redirecting to homepage...";
    echo "<script type='text/javascript'>window.location.href = '/PV/index.html';</script>";
}
else
{
if($star<1)
{
    echo "<script type='text/javascript'>alert(\"Rating cannot be empty!\")</script>";
    echo "<script type='text/javascript'>javascript:history.go(-1)</script>";
}
else{
$insert_query="INSERT INTO user_review (`uid`,`star`,`comment`,`reason`) VALUES('$uid','$star','$comment','$reason')"; 
if ($conn->query($insert_query) === TRUE) 
{
	unset($_SESSION["uid"]);
    echo "<script type='text/javascript'>alert(\"Thanks for the feedback!\")</script>";
     echo "<script type='text/javascript'>window.location.href = '/PV/index.html';</script>";
}
else
{
echo "Error: " . $sql . "<br>" . $conn->error;
echo "<script type='text/javascript'>window.location.href = '/PV/index.html';</script>";
}
$conn->close();  
}
}
}
?>