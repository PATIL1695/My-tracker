<?php
include ($_SERVER['DOCUMENT_ROOT'].'/PV/email.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');
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
  <body>
    <div class="login-form">
      <br>      <h3 class="text-center">Reset Password for the <a style="{text-decoration:none;}" href="/PV/index.html"> Application </h3></a><br>
<form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">  
	<p>Please enter your registered email.</p>
          <div class="form-group"><input type="text" class="form-control input-lg"placeholder="Registered Email" name="username" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}" title="Must be of the format, someone@abc.abc"  required></div>
         <div class="form-group clearfix"> <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Submit"></div>
</form>
<p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</body>
</html>
<?php
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
if (isset($_POST['submit'])){
extract($_POST);
$user_query = "SELECT * FROM `users` WHERE   email = '$username' and role='user'";
$admin_query = "SELECT * FROM `users` WHERE email = '$username' and role='admin'";
$user_result = mysqli_query($conn, $user_query) or die(mysqli_error($conn));
$admin_result = mysqli_query($conn, $admin_query) or die(mysqli_error($conn));
$user_count = mysqli_num_rows($user_result);
$admin_count = mysqli_num_rows($admin_result);
if ($user_count == 1 ){
$uid_query="SELECT uid,email FROM users WHERE email ='$username'and act_status='1'";
$uid_result = mysqli_query($conn,$uid_query) or die(mysqli_error($conn));
$row = mysqli_fetch_row($uid_result);
$uid=$row[0];
$email=$row[1];
$link_id=generateRandomString(64);
$activation_link='http://www.prajwalvenkatesh.com/PV/reset-password.php?token='.$link_id.'&email='.$email;
$message="<p>Welcome to the Application."."<br><br><br>"."You are receiving this email for your password reset."."<br><br>"."Your can reset your password by clicking the below URL."."<br><br>"."Click on the link to reset your password,"."<br>".$activation_link."<br><br><br>"."Note: The link can be used only once."."<br><br><br>"."---------------------------------------"."<br><br><br>"."Copyright PV Group 2018</p>";
$subject="Reset password link.";
send_email($email,$message,$subject);
$insert_to_reset = "UPDATE users SET token='$link_id' where uid='$uid'";
$result2 = mysqli_query($conn,$insert_to_reset);
echo "<script type='text/javascript'>alert(\"Email has been sent! Please check your inbox.\")</script>";
//header("location: /PV/pv-home.html");
echo "<script type='text/javascript'>window.location.href = '/PV/login.php';</script>";
}
elseif ($admin_count == 1){
$uid_query="SELECT email FROM users WHERE email ='$username'and act_status='NULL'";
$uid_result = mysqli_query($conn,$uid_query) or die(mysqli_error($conn));
$row = mysqli_fetch_row($uid_result);
$email=$row[0];
$link_id=generateRandomString(32);
     $activation_link='http://www.prajwalvenkatesh.com/PV/reset-password.php?token='.$link_id.'&email='.$email;
 $message="<p>Welcome to the Application."."<br><br><br>"."You are receiving this email for your password reset!."."<br><br>"."Your can access your account by clicking the below URL."."<br><br>"."Click on the link to reset your password,"."<br>".$activation_link."<br><br><br>"."Note: The link can be used only once."."<br><br><br>"."---------------------------------------"."<br><br><br>"."Copyright PV Group 2018</p>";
 $subject="Reset password link.";
 send_email($email,$message,$subject);
$insert_to_reset = "UPDATE users SET token='$link_id' where  uid='$uid'";
echo "<script type='text/javascript'>alert(\"Email has been sent! Please check your inbox.\")</script>";
//header("location: /PV/admin-home.html");
echo "<script type='text/javascript'>window.location.href = '/PV/login.php';</script>";
}
else{
echo "<script type='text/javascript'>alert(\"This email is not registered.\")</script>";
//echo "<script>setTimeout(\"location.href = '/PV/login.php';\",1500);</script>";
echo "<script type='text/javascript'>window.location.href = '/PV/login.php';</script>";
}
}
?>
