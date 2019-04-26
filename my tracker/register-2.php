<?php
include ($_SERVER['DOCUMENT_ROOT'].'/PV/email.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/encryption.php');
if (($_POST['username']==null) or  ($_POST['email']==null) or ($_POST['password']==null))
{
  echo "<script type='text/javascript'>alert(\"Not authorized!!\")</script>";
  echo "<script type='text/javascript'>window.location.href = '/PV/register.php';</script>";
}
else
{
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
    function validate_questions(){
     var q1 = document.getElementById("q1").value;
              var q2 = document.getElementById("q2").value;
               var q3 = document.getElementById("q3").value;
            if ((q1==q2)||(q1==q3)||(q2==q3)){
              alert("Security Questions cannot be repeated!");
               return false;
            }}
    </script>
    </head>
<body>
  <div class="login-form">
    <h3 class="text-center">Sign Up for<a style="{text-decoration:none;}" href="/PV/index.html"> Application </h3></a><br>
 <br>
  <form class="login-form" onsubmit="return validate_questions();" action="/PV/process-registration-form.php" method="post">
    <div class="avatar" size="auto">
      <img src="/PV/img/user.png" alt="Avatar">
    </div> <p>Answer the following questions in-order to complete registration.</p>
<div class="form-group"><label>Security Question- 1</label>
                <select class="form-control" id="q1" name="q1" required>
                 <option>Which is your favourite place?</option>
                  <option >Who is your favourite teacher?</option>
                      <option>Name any place starting with the letter X. </option>
                      <option>What is the name of your favorite childhood friend?</option>
                      <option>Who is your childhood sports hero?</option>
                       <option>What was the name of the hospital where you were born?</option>
                        <option>In what city or town did you meet your spouse/partner?</option>
                         <option>What is the name of the place your wedding reception was held?</option>
                          <option>What was the make and model of your first car?</option>
                           <option>What was your favorite place to visit as a child?</option>
                </select></div>
                 <div class="form-group"><input type="password" class="form-control input-lg" placeholder="Answer for Question- 1" name="a1" id="a1"  pattern="[a-zA-Z\d\.]{3,24}" title="Should contain only alphanumeric upto 24 digits" required></div>
                   <div class="form-group"><label>Security Question- 2</label>
                <select class="form-control" id="q2" name="q2" required>
                  <option>Which is your favourite place?</option>
                  <option >Who is your favourite teacher?</option>
                      <option>Name any place starting with the letter X. </option>
                      <option>What is the name of your favorite childhood friend?</option>
                      <option>Who is your childhood sports hero?</option>
                       <option>What was the name of the hospital where you were born?</option>
                        <option>In what city or town did you meet your spouse/partner?</option>
                         <option>What is the name of the place your wedding reception was held?</option>
                          <option>What was the make and model of your first car?</option>
                           <option>What was your favorite place to visit as a child?</option>
                </select></div>
                 <div class="form-group"><input type="password" class="form-control input-lg" pattern="[a-zA-Z\d\.]{3,24}" title="Should contain only alphanumeric upto 24 digits" placeholder="Answer for Question- 2" name="a2" id="a2" required></div>
                     <div class="form-group"><label>Security Question- 3</label>
                <select class="form-control" id="q3" name="q3" required>
              <option>Which is your favourite place?</option>
                  <option >Who is your favourite teacher?</option>
                      <option>Name any place starting with the letter X. </option>
                      <option>What is the name of your favorite childhood friend?</option>
                      <option>Who is your childhood sports hero?</option>
                       <option>What was the name of the hospital where you were born?</option>
                        <option>In what city or town did you meet your spouse/partner?</option>
                         <option>What is the name of the place your wedding reception was held?</option>
                          <option>What was the make and model of your first car?</option>
                           <option>What was your favorite place to visit as a child?</option>
                </select></div>
                 <div class="form-group"><input type="password" class="form-control input-lg" placeholder="Answer for Question- 3" name="a3" id="a3" pattern="[a-zA-Z\d\.]{3,24}" title="Should contain only alphanumeric upto 24 digits" required></div>

                  <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
      <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
      <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
      <input type="hidden" name="confirmPassword" value="<?php echo $_POST['confirmPassword']; ?>">

                     <div class="form-group clearfix">  <input type="button" class="btn btn-primary btn-lg pull-left" name="back" onclick="window.location.href='/PV/register.php'" value="Back">
                 <div class="form-group clearfix">  <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Sign up">
          </div></form>
  <div class="hint-text">Have an account? <a href="/PV/login.php">Sign in here</a></div>
</div>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</body>
</html>
<?php } ?>