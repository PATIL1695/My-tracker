<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
        $email = $_SESSION['email'];
    }
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/email.php');
require_once('google-login-api.php');
/* Google App Client Id */
define('CLIENT_ID', '340876954104-99ele4r0dk01s24iehv18ki7m07m71tp.apps.googleusercontent.com');

/* Google App Client Secret */
define('CLIENT_SECRET', '1e1UjqFlMxE6UebRh_mQwuJa');

/* Google App Redirect Url */
define('CLIENT_REDIRECT_URL', 'http://prajwalvenkatesh.com/PV/google/gauth.php');

// Google passes a parameter 'code' in the Redirect Url
if(isset($_GET['code'])) {
	try {
		$gapi = new GoogleLoginApi();
		
		// Get the access token 
		$data = $gapi->GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);
		
		// Get user information
		$user_info = $gapi->GetUserProfileInfo($data['access_token']);
 		
		
		// echo '<pre>';print_r($user_info); echo '</pre>';

		// Now that the user is logged in you may want to start some session variables
		$_SESSION['logged_in'] = 1;
		$username=$user_info['emails'][0]['value'];
		$user_query = "SELECT email,uid FROM `users` WHERE email = '$username' and role='user'";
		$user_result = mysqli_query($conn, $user_query) or die(mysqli_error($conn));
		$row = mysqli_fetch_row($user_result);
		$uid=$row[1];
		if($row[0]==$username)
		{	
			echo "Please wait, while we direct you to the home page! Redirecting....!";
			session_start();
			$_SESSION['email'] = $_SESSION['username'] = $username;
			$_SESSION['uid'] = $row[1];
			$_SESSION["authenticated"] = 'true';
			$_SESSION["user"] = 'true';
			$getll = mysqli_query($conn,"SELECT last_login FROM users WHERE uid = '$uid' ") or die( "<b>Error:</b> Something went wrong!"); 
			$LL = mysqli_fetch_row($getll);
			// Set session variable
			$_SESSION['lastlogin'] = $LL[0];

			// Update New LastLogin
			$updatelog = mysqli_query($conn,"UPDATE users SET last_login = now() WHERE uid = '$uid' ") or die( "<b>Error:</b> Something went wrong!");
			$notification_query = "SELECT email,subscribe FROM users WHERE uid='$uid'";
			$notification_result = mysqli_query($conn,$notification_query) or die(mysqli_error($conn));
			$row1 = mysqli_fetch_row($notification_result);
			$val=$row1[1];
			$email=$row1[0];
				$message="<p>Hello User,<br>Welcome to the Application."."<br><br><br>"."New sign-in to your PV account (Google Sign-In)
			."."<br><br>".$email."<br><br><br>"."We're sending an email just to confirm that this was you. "."<br><br><br>"."---------------------------------------------"."<br><br><br>"."Copyright PV Group 2018</p>";
			$subject="Login Alert";
			if ($val==1){
			send_email($email,$message,$subject);    
			}
			else{
			    echo "";
			}
			echo "<script type='text/javascript'>window.location.href = '/PV/user-home.php';</script>";

		}
		else
		{
			echo "<script type='text/javascript'>alert(\"This email doesn't match any records in our database! \")</script>";
			echo "<script type='text/javascript'>window.location.href = '/PV/simple_logout.php';</script>";
		}

		// You may now want to redirect the user to the home page of your website
		 //header('Location: /app/home.html');
		// echo "<script type='text/javascript'>window.location.href = '/app/home.html';</script>";

	}
	catch(Exception $e) {
		echo $e->getMessage();
		exit();
			echo "<script type='text/javascript'>window.location.href = '/PV/simple_logout.php';</script>";
	}
}

?>