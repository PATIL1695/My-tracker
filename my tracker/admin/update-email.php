<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
    }
include ($_SERVER['DOCUMENT_ROOT'].'/PV/session_expiry.php'); 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php'); 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/admin/admin-authenticate.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/email.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Update Email</title>

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<script>
      function validate(){
           var a = document.getElementById("email").value;
            var b = document.getElementById("confirmEmail").value;
            if (a!=b) {
               alert("Emails do no match!");
               return false;
            }
        }
    </script>
</head>
<body >    

  <div class="login-form">
    <br><br><br>
 <div class="btn-group" role="group" aria-label="...">
  <button type="button" onclick="window.location.href='/PV/admin-home.php'" class="btn btn-default">Back</button>
  <button type="button" onclick="window.location.href='/PV/admin-home.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
  
 <form class="login-form" onsubmit="return validate()" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
     <h3 class="text-center">Update Email</h3><br>
     <p>Please enter the current password.</p>
      <div class="form-group"><input type="password" class="form-control input-lg" placeholder="Current Password" name="currentPassword" id="currentPassword" required></div>
      <p>Please enter the new e-mail.</p>
        <div class="form-group"> <input type="text" class="form-control input-lg" placeholder="Email" name="email" id="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}" title="Must be of the format, someone@abc.abc" required></div>
            <div class="form-group"><input type="text" class="form-control input-lg" placeholder="Confirm Email" name="confirmEmail" id="confirmEmail" required></div>
       <div class="form-group clearfix">  <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Update">
          </div></form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 


<?php
if($uid==NULL or $uid=="")
  {
    echo "<script type='text/javascript'>alert(\"Something went wrong!\")</script>";
    exit();
  }
if ( isset( $_POST['submit'] ) ){
  extract($_POST);
$currentPassword =md5($_POST["currentPassword"]);

$password_query = "SELECT password FROM users WHERE uid='$uid'";
$password_result = mysqli_query($conn,$password_query) or die(mysqli_error($conn));
$row1 = mysqli_fetch_row($password_result);
$pass=$row1[0];
if ($pass==$currentPassword)
{
$sql = "UPDATE users SET email='$email' where uid='$uid'";
if (mysqli_query($conn, $sql)) {
   $message="<p>Hello Admin,<br><br>Welcome to the Application."."<br><br><br>"."Email was updated to your PV account."."<br><br><br>"."Please note:We're sending an email just to confirm that this activity was done by you.<br>Please contact us if it was not done by you "."<br><br><br>"."---------------------------------------------"."<br><br><br>"."Copyright PV Group 2018</p>";
$subject="Admin Notification: Email updated successful";
send_email($email,$message,$subject);
  echo "<script type='text/javascript'>alert(\"Email sucessfully changed!!\")</script>";
   echo "<script type='text/javascript'>window.location.href = '/PV/admin-home.php';</script>";
} else {
    echo "Error updating Email! " . mysqli_error($conn);
}}
else{
    echo "<script type='text/javascript'>alert(\"Entered password is wrong!!\")</script>";
   echo "<script type='text/javascript'>window.location.href = '/PV/admin/update-email.php';</script>";
}
mysqli_close($conn);
}
?>
