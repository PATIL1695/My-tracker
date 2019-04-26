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
<title>Unsubscribe from getting mails</title>

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
  <button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
  
 <form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
     <h3 class="text-center">Unsubscribe from receiving e-mail notifications</h3><br>
     <?php
      $notification_query = "SELECT subscribe FROM users WHERE uid='$uid'";
      $notification_result = mysqli_query($conn,$notification_query) or die(mysqli_error($conn));
      $row1 = mysqli_fetch_row($notification_result);
      $val=$row1[0];
      if ($val==0)
      {
        echo "<p><i>Currently, you have NOT subscribed to receive e-mail notifications.<BR></i> </p>";
      }
      else
      {
        echo "<p><i>Currently, you have subscribed to receive e-mail notifications.<BR></i></p> ";
      }
      ?>
<p>Do you wish to unsubscribe from receiving e-mail notifications about login alerts and other sensitive informations?</p>
 <div class="form-group"><input type="radio"  name="inp" value="yes" checked>Yes</input></div>
 <div class="form-group"><input type="radio"  name="inp" value="no">No</input></div>
<div class="form-group clearfix">  <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Submit">
          </div></form></div>
</form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 

<?php
if($uid==NULL or $uid=="")
  {
    echo "<script type='text/javascript'>alert(\"Uid cannot be null!\")</script>";
  }
 if ( isset( $_POST['submit'] ) ){
  extract($_POST);
  if ($inp=='yes')
  {
    $sql = "UPDATE users SET subscribe='0' where uid='$uid'";
if (mysqli_query($conn, $sql)) {
  echo "<script type='text/javascript'>alert(\"You will no longer receive e-mail notifications!\")</script>";
   echo "<script type='text/javascript'>window.location.href = '/PV/user-home.php';</script>";
} else {
    echo "Error updating value! " . mysqli_error($conn);
}
  }
  else
  {
     $sql = "UPDATE users SET subscribe='1' where uid='$uid'";
if (mysqli_query($conn, $sql)) {
  echo "<script type='text/javascript'>alert(\"You will receive e-mail notifications!\")</script>";
   echo "<script type='text/javascript'>window.location.href = '/PV/user-home.php';</script>";
} else {
    echo "Error updating value! " . mysqli_error($conn);
}
echo "<script type='text/javascript'>window.location.href = '/PV/user-home.php';</script>";
  }
}
// Closing Connection with Server.
mysqli_close($conn);
?>
    