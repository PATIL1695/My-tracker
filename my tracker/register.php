<?php
include ($_SERVER['DOCUMENT_ROOT'].'/PV/email.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/encryption.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<link rel="stylesheet" href="/PV/google/google.css">
  <script>
      function validate(){
           var a = document.getElementById("password").value;
            var b = document.getElementById("confirmPassword").value;
            if (a!=b) {
               alert("Passwords do no match!");
               return false;
            }
        }
    </script>
    </head>
<body>
  <div class="login-form">
    <h3 class="text-center">Sign Up for<a style="{text-decoration:none;}" href="/PV/index.html"> Application </h3></a><br>
 <br>
  <form class="login-form" onsubmit="return validate() ;" action="/PV/register-2.php" method="post">
    <div class="avatar">
      <img src="/PV/img/user.png" alt="Avatar">
    </div> 
                   <div class="form-group"><input type="text" class="form-control input-lg" name="username" placeholder="Username" pattern="[a-zA-Z\d\.]{5,}"  title="Must contain at least 5 characters. Only use alphabets and digits." required></div>
              <div class="form-group"> <input type="email" class="form-control input-lg" placeholder="Email" name="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}" title="Must be of the format, someone@abc.abc" required></div>
            <div class="form-group"> <input type="password"  class="form-control input-lg" placeholder="Password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required></div>
            <div class="form-group"><input type="password" class="form-control input-lg" placeholder="Confirm Password" name="confirmPassword" id="confirmPassword" required></div>
                 
       <div class="form-group clearfix">  <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Continue">
          </div></form>
  <div class="hint-text">Have an account? <a href="/PV/login.php">Sign in here</a></div>
</div>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</body>
</html>


