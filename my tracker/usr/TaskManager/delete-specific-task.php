<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
    }
include ($_SERVER['DOCUMENT_ROOT'].'/PV/session_expiry.php'); 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php'); 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/usr/user-authenticate.php');
// get value of id that sent from address bar

$id=$_GET['task_id'];
if($id!=null){
// Retrieve data from database 
$sql="SELECT * FROM task WHERE (taskId = '$id' and uid='$uid')";
$result=mysqli_query($conn,$sql);
$rows=mysqli_fetch_array($result);
?>
<html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Delete Specific task</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
</head>
<body>
	<div align="center"  style= "width: 1000px;" class="login-form">
  <br><br><br>
 <div class="btn-group" role="group" aria-label="...">

</div><br><br></div>
<body>
<?php
if($uid==NULL or $uid=="")
  {
    echo "<script type='text/javascript'>alert(\"Something went wrong!\")</script>";
    exit();
  }
 $sql="DELETE from task where (taskId='$id' and uid='$uid')" ;
$result=mysqli_query($conn,$sql) or die ("Error");
// if successfully updated. 
if($result){
	echo "<script type='text/javascript'>alert(\"Item deleted successful!\")</script>";
 echo "<script type='text/javascript'>window.location.href = '/PV/usr/TaskManager/dashboard.php';</script>";
  // echo "<script type='text/javascript'>javascript:history.go(-2)</script>";
  // header("Refresh:2; url='/PV/usr/jobs/display-info-before-update.php'");
echo "<BR>";
}
else {
echo "<script type='text/javascript'>alert(\"Error while deleting!!\")</script>";
 echo "<script type='text/javascript'>window.location.href = '/PV/usr/TaskManager/dashboard.php';</script>";
}
}
else
{
 echo "<script type='text/javascript'>alert(\"Something went wrong!\")</script>";
  echo "<script type='text/javascript'>window.location.href = '/PV/usr/TaskManager/dashboard.php';</script>";
}
?>