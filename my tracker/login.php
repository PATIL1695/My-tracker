<?php
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/email.php');
define('CLIENT_ID', '340876954104-99ele4r0dk01s24iehv18ki7m07m71tp.apps.googleusercontent.com');
/* Google App Client Secret */
define('CLIENT_SECRET', '1e1UjqFlMxE6UebRh_mQwuJa');
/* Google App Redirect Url */
define('CLIENT_REDIRECT_URL', 'http://prajwalvenkatesh.com/PV/google/gauth.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome to Application</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<link rel="stylesheet" href="/PV/google/google.css">
</head>
<body >
<div class="login-form">
<h3 class="text-center">Welcome to <a style="{text-decoration:none;}" href="/PV/index.html">Application</h3></a><br>
<div class="wrapper">
<button onclick="window.location.href='<?= 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online' ?>'" class="loginBtn loginBtn--google">
  Login with Google
</button>
</div><br>
<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">  
  <div class="avatar">
      <img src="/PV/img/user.png" alt="Avatar">
    </div>      
        <div class="form-group"> <input type="text" class="form-control input-lg" placeholder="Email or Username" name="username" required><br></div>
          <div class="form-group"><input type="password"  class="form-control input-lg" placeholder="Password" name="password" required></div>
             <!-- <div class="form-group"><input type="checkbox" name="rememberme" value="1"> Remember Me</div> -->
        <div class="form-group clearfix"> <input type="submit" class="btn btn-primary btn-lg pull-right" value="Log in"></div>
        </form>
         <div class="hint-text">New to the Application?<a href="/PV/register.php">Sign up for a new account</a></div>
        <div class="hint-text">Forgot Password?<a href="/PV/forget-password.php">Click here to reset</a></div></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 


                            
<?php
if (isset($_POST['username']) and isset($_POST['password'])){
$username=$email = $_POST['username'];
$password = md5($_POST['password']);
$user_query = "SELECT * FROM `users` WHERE ( username='$username' OR email = '$username')  and password='$password' and role='user'";
$admin_query = "SELECT * FROM `users` WHERE( username='$username' OR email = '$username')  and password='$password' and role='admin'";
$user_result = mysqli_query($conn, $user_query) or die(mysqli_error($conn));
$admin_result = mysqli_query($conn, $admin_query) or die(mysqli_error($conn));
$user_count = mysqli_num_rows($user_result);
$admin_count = mysqli_num_rows($admin_result);
if ($user_count == 1 ){
$uid_query="SELECT uid,email FROM users WHERE ((username ='$username' or email ='$email')and act_status='1')";
$uid_result = mysqli_query($conn,$uid_query) or die(mysqli_error($conn));
$row = mysqli_fetch_row($uid_result);
$uid=$row[0];
$email=$row[1];
session_start();
$_SESSION['username'] = $username;
$_SESSION['uid'] = $uid;
$_SESSION['email'] = $email;
$_SESSION["authenticated"] = 'true';
$_SESSION["user"] = 'true';
// Get Last Login
$getll = mysqli_query($conn,"SELECT last_login FROM users WHERE uid = '$uid' ") or die( "<b>Error:</b> Something went wrong!"); 
$LL = mysqli_fetch_row($getll);
// Set session variable
$_SESSION['lastlogin'] = $LL[0];

// Update New LastLogin
$updatelog = mysqli_query($conn,"UPDATE users SET last_login = now() WHERE uid = '$uid' ") or die( "<b>Error:</b> Something went wrong!");

//header("location: /PV/user-home.html");
echo "<script type='text/javascript'>window.location.href = '/PV/security-questions.php';</script>";
}
elseif ($admin_count == 1){
$uid_query="SELECT uid,email FROM users WHERE (username ='$username' or email ='$email')";
$uid_result = mysqli_query($conn,$uid_query) or die(mysqli_error($conn));
$row = mysqli_fetch_row($uid_result);
$uid=$row[0];
$email=$row[1];
session_start();
$_SESSION['username'] = $username;
$_SESSION['uid'] = $uid;
$_SESSION['email'] = $email;
$_SESSION["authenticated"] = 'true';
$_SESSION["admin"] = 'true';
// Get Last Login
$getll = mysqli_query($conn,"SELECT last_login FROM users WHERE uid = '$uid' ") or die( "<b>Error:</b> Something went wrong!"); 
$LL = mysqli_fetch_row($getll);
// Set session variable
$_SESSION['lastlogin'] = $LL[0];

// Update New LastLogin
$updatelog = mysqli_query($conn,"UPDATE users SET last_login = now() WHERE uid = '$uid' ") or die( "<b>Error:</b> Something went wrong!");

    echo "<script type='text/javascript'>window.location.href = '/PV/admin-home.php';</script>";
}
else{
echo "<script type='text/javascript'>alert(\"Login failed! Wrong Username or Password!\")</script>";
}
}
?>



