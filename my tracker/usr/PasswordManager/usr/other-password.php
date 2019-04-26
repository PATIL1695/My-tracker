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
<title>Add other password</title>

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
  
 <form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
     <h3 class="text-center">Add other password into database</h3><br>

             <div class="form-group"> <label>Vendor Type</label>
                <select class="form-control input-lg" name="vendortype"  id="vendortype" onchange="displayifOther1();" required>
                  <option>Email</option>
                  <option>Online Shopping </option>
                  <option>Social Media</option>
                  <option>Others</option>
                </select> </div>
                <div class="form-group">  <input type="text" class="form-control input-lg" placeholder="Please Specify" name="new_textbox" id="new_textbox" style="display:none;" ></div>
                <div class="form-group"><label>Vendor Name</label>
                <select class="form-control"  name="vendorname" id="vendorname" onchange="displayifOther2();" required>
                  <option>Gmail</option>
                  <option>Outlook</option>
                  <option>Facebook</option>
                  <option>Twitter</option>
                  <option>Amazon</option>
                  <option>Flipkart</option>
                  <option>Instagram</option>
                  <option>Others</option>
                </select></div>
               <div class="form-group">  <input type="text" class="form-control input-lg" placeholder="Please Specify"  name="new_textbox2" id="new_textbox2" style="display:none;" ></div>
             <div class="form-group"> <input type="tel" class="form-control input-lg"  name="phoneno" placeholder="Phone number" required> </div>
         <div class="form-group"> <input type="email" class="form-control input-lg"  placeholder="Email" name="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}" title="Must be of the format, someone@abc.abc" required> </div>
           <div class="form-group"><input type="text" class ="form-control input-lg"  placeholder="Username" name="username" required>   </div>
            <div class="form-group"><input type="password"  class="form-control input-lg"  placeholder="Password" name="password" id="password" required> </div>
       <div class="form-group clearfix">  <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Add">
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
  $password=encryptPassword($password); 
  if ($vendorname=="Others")
  {
    $vendorname=$_POST['new_textbox2'];
  }
  else{
    $vendorname=$_POST['vendorname'];
  }

  if ($vendortype=="Others")
  {
    $vendortype=$_POST['new_textbox'];
  }
  else{
    $vendortype=$_POST['vendortype'];
    // echo "<script type='text/javascript'>alert(\"File ".$vendortype." deleted!\")</script>";
  }
  $check_email_query="select * from general where ((username='$username' or email='$email') and (vendorname='$vendorname')and (vendortype='$vendortype') and (uid='$uid'));";

      $res=mysqli_query($conn,$check_email_query);

      if (mysqli_num_rows($res) > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($res);
        if (($username==$row['username'])  and ($vendorname==$row['vendorname']))
            {
                echo "<script type='text/javascript'>alert(\"$username already exists for $vendorname!Try with a different username.\")</script>";
            }

            elseif (($email==$row['email'])  and ($vendorname==$row['vendorname']))
            {
                echo "<script type='text/javascript'>alert(\"$email already exists for $vendorname!Try with a different email.\")</script>";
            }

       } 
       else
       {
   
    if(mysqli_query($conn,"INSERT INTO general (`uid`,`vendorname`,`vendortype`,`username`,`email`,`phoneno`,`password`) VALUES('$uid','$vendorname','$vendortype','$username','$email','$phoneno','$password')")) { 
      echo "<script type='text/javascript'>alert(\"Details added Successfully!\")</script>";
    die(); 
  }
   else { 
    echo "Error2: " . "<br>" . mysqli_error($conn); 
  } 
  mysqli_close($conn); 
}
}
?>

        

