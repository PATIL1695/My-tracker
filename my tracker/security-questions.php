<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
        $email = $_SESSION['email'];
    }
if (($_SESSION["authenticated"] != 'true') and ($_SESSION["user"]!=='true'))

{
echo "<script type='text/javascript'>window.location.href = '/PV/simple_logout.php';</script>";
}
include ($_SERVER['DOCUMENT_ROOT'].'/PV/email.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');

 
	$number=rand(1,3);
	$question_query = "SELECT question FROM security_questions WHERE (q_id = '$number'and uid='$uid')";
	$question_result = mysqli_query($conn,$question_query) or die(mysqli_error($conn));
	$row = mysqli_fetch_row($question_result);
	$question=$row[0];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Security question check</title>
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

<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">        
	
	<p>Please answer the below Security-Question to login:</p>
        <div class="form-group"> <p class="form-control input-lg">  <?php echo $question; ?><br></div>
        	<div class="form-group"> <input type="password" class="form-control input-lg" placeholder="Answer" name="answer" required><br></div>
        	 <input type="hidden" class="form-control input-lg" name="q_id"value= "<?php echo $number; ?>" hidden>
        <div class="form-group clearfix"> <input type="submit" class="btn btn-primary btn-lg pull-right" value="Submit"></div>
        </form>
        <div class="hint-text">Forgot Password?<a href="/PV/forget-password.php">Click here to reset</a></div></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 


                           
<?php
if (isset($_POST['answer'])){
$answer= md5($_POST['answer']);
$q_id= $_POST['q_id'];



$notification_query = "SELECT subscribe FROM users WHERE uid='$uid'";
$notification_result = mysqli_query($conn,$notification_query) or die(mysqli_error($conn));
$row1 = mysqli_fetch_row($notification_result);
$val=$row1[0];

$answer_query = "SELECT answer FROM security_questions WHERE q_id = '$q_id' and uid='$uid'";
$answer_result = mysqli_query($conn,$answer_query) or die(mysqli_error($conn));
$row = mysqli_fetch_row($answer_result);
$ans=$row[0];
if ($answer==$ans){
// Get Last Login
$getll = mysqli_query($conn,"SELECT last_login FROM users WHERE uid = '$uid' ") or die( "<b>Error:</b> Something went wrong!"); 
$LL = mysqli_fetch_row($getll);
// Set session variable
$_SESSION['lastlogin'] = $LL[0];

// Update New LastLogin
$updatelog = mysqli_query($conn,"UPDATE users SET last_login = now() WHERE uid = '$uid' ") or die( "<b>Error:</b> Something went wrong!");

$message="<p>Hello User,<br>Welcome to the Application."."<br><br><br>"."New sign-in to your PV account
."."<br><br>".$email."<br><br><br>"."We're sending an email just to confirm that this was you. "."<br><br><br>"."---------------------------------------------"."<br><br><br>"."Copyright PV Group 2018</p>";
$subject="Login Alert";
if ($val==1){
send_email($email,$message,$subject);    
}
else{
    echo "";
}
//header("location: /PV/pv-home.html");
unset($_SESSION["sec_ques"]);
echo "<script type='text/javascript'>window.location.href = '/PV/user-home.php';</script>";

}
else{
echo "<script type='text/javascript'>alert(\"Wrong answer! Login again!\")</script>";
echo "<script type='text/javascript'>window.location.href = '/PV/simple_logout.php';</script>";
}
}
?>



