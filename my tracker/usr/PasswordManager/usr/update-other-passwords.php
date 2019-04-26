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
<title>Update other passwords</title>

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<script>
function displayifOther1(){
    var item1 = document.getElementById('vendortype').value ;
    if(item1 == "Others" )
        document.getElementById("new_textbox").style.display="block";
      else 
        document.getElementById("new_textbox").style.display="none";
}

function displayifOther2(){
    var item2= document.getElementById('vendorname').value ;
    if(item2 == "Others" )
        document.getElementById("new_textbox2").style.display="block";
      else 
        document.getElementById("new_textbox2").style.display="none";
}

 </script>
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
$sql="SELECT * FROM general WHERE (id = '$id' and uid='$uid')";
$result=mysqli_query($conn,$sql);
$rows=mysqli_fetch_array($result);
$vend=$rows['vendorname'];
?>

<form class="login-form"  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
  <h3 class="text-center"><bold>Update for <?php echo "'".$vend."'"; ?></bold></h3><br>
<p>Vendor Type</p>
<div class="form-group">
                <select name="vendortype" class ="form-control input-lg"  id="vendortype" onchange="displayifOther1();" >
                	<option value="<?php echo $rows['vendortype']; ?>"><?php echo $rows['vendortype'].'(Selected)'; ?></option>
                 <option>Email</option>
                  <option>Online Shopping </option>
                  <option>Social Media</option>
                  <option>Others</option>
                </select> </div>
<div class="form-group">  <input type="text" class ="form-control input-lg" placeholder="Please Specify" name="new_textbox" id="new_textbox" style="display:none;" ></div>
<p>Vendorname</p><div class="form-group">
                <select   id="vendorname" class ="form-control input-lg" onchange="displayifOther2();" name="vendorname">
                	<option value="<?php echo $rows['vendorname']; ?>"><?php echo $rows['vendorname'].'(Selected)'; ?></option>
                 <option>Gmail</option>
                  <option>Outlook</option>
                  <option>Facebook</option>
                  <option>Twitter</option>
                  <option>Amazon</option>
                  <option>Flipkart</option>
                  <option>Instagram</option>
                  <option>Others</option>
                </select>
</div>
<div class="form-group">  <input class ="form-control input-lg" type="text" class="form-control input-lg" placeholder="Please Specify"  name="new_textbox2" id="new_textbox2" style="display:none;"></div>
<p>Phone No.</p>
<div class="form-group"> <input class ="form-control input-lg"  type="tel" name="phoneno" value="<?php echo $rows['phoneno']; ?>">
</div><p>Email</p>
<div class="form-group"> <input class ="form-control input-lg" type="email" name="email" value="<?php echo $rows['email']; ?>" ></div><p>Username</p>
<div class="form-group"> <input class ="form-control input-lg" type="text" name="username" value="<?php echo $rows['username']; ?>"></div><p>Password</p>
<div class="form-group"> <input class ="form-control input-lg" type="text" name="password" value="<?php echo decryptPassword($rows['password']); ?>"></div>
<input name="id" type="hidden" id="id" value="<?php echo $rows['id']; ?>"/>
<div class="form-group clearfix"> <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Update"></div>
</form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 
      
<?php
if ( isset( $_POST['submit'] ) ){
	extract($_POST);
  $password=encryptPassword($password);
$sql="UPDATE general SET vendorname= '$vendorname',vendortype= '$vendortype',phoneno= '$phoneno',email= '$email', password= '$password' where (id='$id' and uid='$uid')" ;

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