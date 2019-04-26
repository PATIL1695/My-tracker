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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Update Expense</title>

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
  <button type="button" onclick="window.location.href='/PV/usr/ExpenseManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
<?php
// get value of id that sent from address bar
$id=$_GET['temp'];
// Retrieve data from database 
$sql="SELECT * FROM dollar WHERE (id = '$id' and uid='$uid')";
$result=mysqli_query($conn,$sql);
$rows=mysqli_fetch_array($result);
$dollar=$rows['dollar'];
$val=substr($rows['month'],0,7);
?>
<form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
   <p>Month</p>
<div class="form-group"> <input type="month" class ="form-control input-lg" name="month" disabled value="<?php echo $val; ?>">
</div>
   <p>Old Value</p>
   <div class="form-group"> <input  type="number"  class ="form-control input-lg" name="item" value="<?php echo $dollar; ?>" disabled ></div>
   <p>New Dollar Value</p>
   <div class="form-group"> <input  type="number"  class ="form-control input-lg" name="value" step="any" placeholder="Enter new dollar value"></div>
    
<input name="id" type="hidden" id="id" value="<?php echo $id; ?>"/>
<div class="form-group clearfix"> <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit"  value="Update" /></div>
</form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 
   
<?php
if ( isset( $_POST['submit'] ) ){
  extract($_POST);
  if($value==0 or $value==null){
    $sql="SELECT * FROM dollar WHERE (id = '$id' and uid='$uid')";
$result=mysqli_query($conn,$sql);
$rows=mysqli_fetch_array($result);
$value=$rows['dollar'];
  }
  else{
    $value=$value;
  }
$sql1="UPDATE dollar SET dollar= '$value' where (id='$id' and uid='$uid')" ;

$result=mysqli_query($conn,$sql1) or 
die ("Error");

// if successfully updated. 
if($result){
  echo "<script type='text/javascript'>alert(\"Update successful!\")</script>";
 echo "<script type='text/javascript'>window.location.href = '/PV/usr/ExpenseManager/dollar.php';</script>";
echo "<BR>";

}

else {
echo "ERROR";echo "<script type='text/javascript'>alert(\"Error while updating!!\")</script>";
 echo "<script type='text/javascript'>window.location.href = '/PV/usr/ExpenseManager/dashboard.php';</script>";}
}
?>