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
<title>Add bank password</title>
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
     <h3 class="text-center">Add bank password into database</h3><br>
              <div class="form-group"><input type="text" class="form-control input-lg"  name="vendorname" placeholder="Bank Name" required></div>
              <div class="form-group"><input type="text" class="form-control input-lg"  name="ifsc" placeholder="IFSC Code"></div>
               <div class="form-group"><label>Account Type</label>
                <select class="form-control input-lg"  name="accounttype">
                  <option>Savings</option>
                  <option>Checking</option>
                  <option>Loan</option>
                  <option>Current</option>
                  <option>Other</option>
                   <option>None</option>
                </select>    </div>
              <div class="form-group"><input type="text" class="form-control input-lg"  name="accountno" placeholder="Account Number" pattern="([0-9]){8,20}"></div>
              <div class="form-group"><input type="text" class="form-control input-lg"  name="username" placeholder="User Name" pattern="[A-Za-z\d\.]{5,}" required></div>
              <div class="form-group"><input type="password" class="form-control input-lg"  name="password" placeholder="Password" required></div>
              <div class="form-group"><input type="email" class="form-control input-lg"  name="email" placeholder="Email" " pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}" title="Must be of the format, someone@abc.abc"  required></div>
              <div class="form-group"><input type="tel" class="form-control input-lg"  name="phoneno" placeholder="Phone number"></div>
              <div class="form-group"><input type="text" class ="form-control" name="cardno" placeholder="Card Number"  pattern="([0-9]){16}" title="Should contain only 16 digit numbers(0-9)"  required></div>
              
           <div class="form-group"><label>Card Type-1</label>
                <select class="form-control input-lg"  name="cardtype1" required>
                  <option>Credit Card</option>
                  <option>Debit Card</option>
                  <option>Foreign Currency Card</option>
                  <option>Tarvel Card</option>
                    <option>Gift Card</option>
                      <option>Others</option>
                </select></div>
           <div class="form-group"><label>Card Type-2</label>
                <select class="form-control input-lg"  name="cardtype2" required>
                  <option>Visa</option>
                  <option>Master Card</option>
                  <option>Rupay</option>
                  <option>Other</option>             
          </select></div>
          <div class="form-group"> Card Expiry:
           <input type="date" class ="form-control" name="cardexp"  required></div>
          <div class="form-group"><input type="password" class="form-control input-lg"  name="cardpin" placeholder="Card Pin" pattern="([0-9]){4}" title="Should contain only 4 digit numbers(0-9)" required></div>
        <div class="form-group"><input type="password"  class="form-control input-lg"  name="cardcvv" placeholder="Card CVV" pattern="([0-9]){3}" title="Should contain only 3 digit numbers(0-9)"  required></div>
            <div class="form-group clearfix">  <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Add">
          </div></form></div>
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
  $password=encryptPassword($password);
  $cardpin=encryptPassword($cardpin);
  $cardcvv=encryptPassword($cardcvv); 
  $check_email_query="select * from bank where (vendorname='$vendorname' and cardno='$cardno');";

      $res=mysqli_query($conn,$check_email_query);

      if (mysqli_num_rows($res) > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($res);
        if (($vendorname==$row['vendorname']) and ($cardno==$row['cardno']))
            {
                echo "<script type='text/javascript'>alert(\"$vendorname for $cardno already exists! Try with different one!\")</script>";
            }
       } 
       else
       {
    if(mysqli_query($conn,"INSERT INTO bank (`uid`,`vendorname`,`ifsc`,`accounttype`,`accountno`,`username`,`password`,`email`,`phoneno`,`cardtype1`,`cardtype2`,`cardno`,`cardexp`,`cardpin`,`cardcvv`) VALUES('$uid','$vendorname','$ifsc','$accounttype','$accountno','$username','$password','$email','$phoneno','$cardtype1','$cardtype2','$cardno','$cardexp','$cardpin','$cardcvv')")) { 
      echo "<script type='text/javascript'>alert(\"Bank details added sucessfully!!\")</script>";
    die(); 
  }
   else { 
    echo "Error: " . "<br>" . mysqli_error($conn); 
  } 
  mysqli_close($conn); 
}
}
?>
 