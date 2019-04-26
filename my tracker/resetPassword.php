<?php
include ($_SERVER['DOCUMENT_ROOT'].'/PV/email.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
        $email = $_SESSION['email'];
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Reset Password</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<link rel="stylesheet" href="/PV/google/google.css">
</head>
  <script>
      function validate(){
           var a = document.getElementById("password").value;
            var b = document.getElementById("confirmPassword").value;
            if (a!=b) {
               alert("Passwords do no match!");
               return false;
            }
        }
    </script>

   <body>
  <div class="login-form">
    <br><h3 class="text-center">Reset Password for the <a style="{text-decoration:none;}" href="/PV/index.html"> Application </h3></a><br>
         <form class="login-form" onsubmit="return validate()"  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
     <div class="form-group">   <input type="password" class="form-control input-lg" placeholder="Password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required></div>
<div class="form-group">       <input type="password" class="form-control input-lg" placeholder="Confirm Password" name="confirmPassword" id="confirmPassword" required></div>
       <div class="form-group clearfix"><input type="submit" class="btn btn-primary btn-lg pull-right"  name="reset" value="Reset"></div>
        </form>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</body>
</html>
          
<?php
if (isset($_POST['reset'])){
  extract($_POST);
$password =md5($_POST["confirmPassword"]);
$sql = "UPDATE users SET password='$password', token='null' where uid='$uid'";
if (mysqli_query($conn, $sql)) {
  $message="<p>Welcome to the Application."."<br><br><br>"."Password was reset to your PV account."."<br><br><br>"."Click here to access your account,<br>http://prajwalvenkatesh.com/PV<br>We're sending an email just to confirm that this was you.<br>Please contact us if it was not done by you "."<br><br><br>"."---------------------------------------------"."<br><br><br>"."Copyright PV Group 2018</p>";
$subject="Password reset successful";
send_email($email,$message,$subject);
  echo "<script type='text/javascript'>alert(\"Password reset successful!\")</script>";
 echo "<script type='text/javascript'>window.location.href = '/PV/login.php';</script>";
} else {
    echo "Error updating Password! " . mysqli_error($conn);
}
mysqli_close($conn);
unset($_SESSION["uid"]);
unset($_SESSION["email"]);
session_destroy();
}
?>