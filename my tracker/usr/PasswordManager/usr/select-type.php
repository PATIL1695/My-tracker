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
<title>Select Vendor</title>

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
  <button type="button" onclick="window.location.href='/PV/usr/PasswordManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
  
 <form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
     <h3 class="text-center">Select Vendor</h3><br>
       <div class="form-group"> <label>Vendor Type</label><br>
                <select class="form-control input-lg" name="vendortype">
                  <option>Bank</option>
                  <option selected="Others">Others</option>
                </select></div>
       <div class="form-group clearfix">  <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Select">
          </div></form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 

<?php

 if ( isset( $_POST['submit'] ) ){
  extract($_POST);
  if($vendortype=='Bank')
  {
     echo "<script type='text/javascript'>window.location.href = '/PV/usr/PasswordManager/usr/bank-password.php';</script>";
  }
  else
  {
     echo "<script type='text/javascript'>window.location.href = '/PV/usr/PasswordManager/usr/other-password.php';</script>";
}  }
?>
 