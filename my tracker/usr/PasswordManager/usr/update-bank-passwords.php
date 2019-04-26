<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
    }
include ($_SERVER['DOCUMENT_ROOT'].'/PV/session_expiry.php'); 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php'); 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/encryption.php'); 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/usr/user-authenticate.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Update bank passwords</title>

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
<?php
// get value of id that sent from address bar
$id=$_GET['password_id'];
// Retrieve data from database 
$sql="SELECT * FROM bank WHERE (id = '$id' and uid='$uid')";
$result=mysqli_query($conn,$sql);
$rows=mysqli_fetch_array($result);
$vend=$rows['vendorname'];
?>

<form class="login-form"  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
  <h3 class="text-center"><bold>Update for <?php echo "'".$vend."'"; ?></bold></h3><br>
   <p>Bank Name</p>
<div class="form-group"> <input  class ="form-control input-lg" type="text" name="vendorname" value="<?php echo $rows['vendorname']; ?>">
</div>
<p>Bank Code(IFSC)</p>
<div class="form-group"> <input  class ="form-control input-lg" type="text" name="ifsc" value="<?php echo $rows['ifsc']; ?>">
</div>
<p>Account Type</p>
<div class="form-group">
                <select  class ="form-control input-lg" name="accounttype">
                	<option value="<?php echo $rows['accounttype']; ?>"><?php echo $rows['accounttype'].'(Selected)'; ?></option>
                  <option>Savings</option>
                  <option>Checking</option>
                  <option>Loan</option>
                  <option>Current</option>
                  <option>Other</option>
                   <option>None</option>
                </select> </div>
                <p>Account No.</p>
<div class="form-group"> <input  class ="form-control input-lg"  type="text" pattern="([0-9]){8,20}" name="accountno" value="<?php echo $rows['accountno']; ?>">
</div><p>Username</p>
<div class="form-group"> <input type="text"  class ="form-control input-lg" name="username" pattern="[A-Za-z\d\.]{5,}" value="<?php echo $rows['username']; ?>" >
</div><p>Password</p>
<div class="form-group"> <input type="text" name="password"  class ="form-control input-lg"  value="<?php echo decryptPassword($rows['password']); ?>"></div>
<p>Email</p><div class="form-group"> <input type="email"  class ="form-control input-lg" name="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}" title="Must be of the format, someone@abc.abc"   value="<?php echo $rows['email']; ?>"/>
</div>
<p>Phone No.</p><div class="form-group"> <input type="tel"  class ="form-control input-lg" name="phoneno" value="<?php echo $rows['phoneno']; ?>" ></div>
<p>Card No.</p><div class="form-group"> <input type="text"  class ="form-control input-lg" pattern="([0-9]){16}" title="Should contain only 16 digit numbers(0-9)" name="cardno" value="<?php echo $rows['cardno']; ?>">
</div>
<p>Card Type-1</p><div class="form-group">
                <select  class ="form-control input-lg" name="cardtype1">
                  <option value="<?php echo $rows['cardtype1']; ?>"><?php echo $rows['cardtype1'].'(Selected)'; ?></option>
                <option>Credit Card</option>
                  <option>Debit Card</option>
                  <option>Foreign Currency Card</option>
                  <option>Tarvel Card</option>
                    <option>Gift Card</option>
                      <option>Others</option>
                </select></div>
<p>Card Type-2</p><div class="form-group">
                <select   class ="form-control input-lg" name="cardtype2">
                  <option value="<?php echo $rows['cardtype2']; ?>"><?php echo $rows['cardtype2'].'(Selected)'; ?></option>
                  <option>Visa</option>
                  <option>Master Card</option>
                  <option>Rupay</option>
                  <option>Other</option>  
                </select>
</div>
<p>Card Expiry</p><div class="form-group"> <input  class ="form-control input-lg" type="date" name="cardexp" value="<?php echo $rows['cardexp']; ?>" />
</div>
<p>Card Pin</p><div class="form-group"> <input  class ="form-control input-lg" type="text" name="cardpin" pattern="([0-9]){4}" title="Should contain only 4 digit numbers(0-9)" value="<?php echo decryptPassword($rows['cardpin']); ?>" >
</div>
<p>Card CVV</p><div class="form-group"> <input  class ="form-control input-lg" type="text" name="cardcvv" pattern="([0-9]){3}" title="Should contain only 3 digit numbers(0-9)" value="<?php echo decryptPassword($rows['cardcvv']); ?>" >
</div>
<input name="id" type="hidden" id="id"  class ="form-control input-lg" value="<?php echo $rows['id']; ?>"/>
<div class="form-group clearfix"> <input  class="btn btn-primary btn-lg pull-right" type="submit" class="btn btn-primary btn-lg pull-right" name="submit"  value="Update" /></div>
</form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 
   
<?php
if ( isset( $_POST['submit'] ) ){
	extract($_POST);
  $password=encryptPassword($password);
  $cardpin=encryptPassword($cardpin);
  $cardcvv=encryptPassword($cardcvv);

$sql="UPDATE bank SET vendorname='$vendorname', ifsc='$ifsc', accounttype='$accounttype', accountno='$accountno', username='$username',password='$password', email='$email', phoneno='$phoneno', cardno='$cardno', cardtype1='$cardtype1',cardtype2='$cardtype2', cardexp='$cardexp',cardpin='$cardpin',cardcvv='$cardcvv' where (id='$id' and uid='$uid')" ;

$result=mysqli_query($conn,$sql) or 
die ("Error");

// if successfully updated. 
if($result){
	echo "<script type='text/javascript'>alert(\"Update successful!\")</script>";
 echo "<script type='text/javascript'>window.location.href = '/PV/usr/PasswordManager/usr/display-data-before-update.php';</script>";
echo "<BR>";

}

else {
echo "ERROR";echo "<script type='text/javascript'>alert(\"Error while updating!!\")</script>";
 echo "<script type='text/javascript'>window.location.href = '/PV/usr/PasswordManager/usr/display-data-before-update.php';</script>";}
}
?>