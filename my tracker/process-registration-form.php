<?php
include ($_SERVER['DOCUMENT_ROOT'].'/PV/email.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/encryption.php');
 if ( isset( $_POST['submit'] ) ){
  extract($_POST);
  $username=$_POST["username"];
  $email=$_POST["email"];
  $pass=$_POST["confirmPassword"];
  $password=md5($pass); 
  $ans1=md5($a1);
  $ans2=md5($a2);
  $ans3=md5($a3);

   $check_temp_user_query="select * from tmp_users where (username='$username' or email='$email');";
      $res=mysqli_query($conn,$check_temp_user_query);
      if (mysqli_num_rows($res) > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($res);
        if (strtoupper($username)==strtoupper($row['username']) OR (strtoupper($email)==strtoupper($row['email'])))
            {
                echo "<script type='text/javascript'>alert(\"Username/Email already exists!Please check your inbox to activate the account!\")</script>";
                 echo "<script type='text/javascript'>window.location.href = '/PV/register.php';</script>";
            }
       } 
      else{

  $check_email_query="select * from users where (username='$username' or email='$email');";

      $res=mysqli_query($conn,$check_email_query);

      if (mysqli_num_rows($res) > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($res);
        if (strtoupper($username)==strtoupper($row['username']))
            {
                echo "<script type='text/javascript'>alert(\"Username already exists!Try with a different username.\")</script>";
                 echo "<script type='text/javascript'>window.location.href = '/PV/register.php';</script>";
            }
            
        elseif (strtoupper($email)==strtoupper($row['email']))
        {
             echo "<script type='text/javascript'>alert(\"Email already exists!Try with a different email.\")</script>";
              echo "<script type='text/javascript'>window.location.href = '/PV/register.php';</script>";
        }

       } 
       else
       {
        $uid=generateRandomString(15);
        $link_id=generateRandomString(32);
        $activation_link='http://www.prajwalvenkatesh.com/PV/check-email-activation.php?passkey='.$link_id;
        $message="<p>Welcome to the Application."."<br><br><br>"."Thanks for signing up!."."<br><br>"."Your account has been created,you can access your account after activating by clicking the below URL."."<br><br>"."Click on the link to activate,"."<br>".$activation_link."<br><br><br>"."Note: The link can be used only once."."<br><br><br>"."---------------------------------------"."<br><br><br>"."Copyright PV Group 2018</p>";
        $subject="Registration Confirmation.";
       if(mysqli_query($conn,"INSERT INTO tmp_users (`uid`,`username`,`email`,`password`,`activate_link`) VALUES('$uid','$username','$email','$password','$link_id')")) { 
      $Question_query1 = "INSERT INTO security_questions (`q_id`,`uid`,`question`,`answer`) VALUES('1','$uid','$q1','$ans1')";
      $Question_query2 = "INSERT INTO security_questions (`q_id`,`uid`,`question`,`answer`) VALUES('2','$uid','$q2','$ans2')";
      $Question_query3 = "INSERT INTO security_questions (`q_id`,`uid`,`question`,`answer`) VALUES('3','$uid','$q3','$ans3')";
      $query1_result = mysqli_query($conn, $Question_query1) or die(mysqli_error($conn));
      $query2_result = mysqli_query($conn, $Question_query2) or die(mysqli_error($conn));
      $query3_result = mysqli_query($conn, $Question_query3) or die(mysqli_error($conn));
send_email($email,$message,$subject);
  if(($query3_result==true) and ($query2_result==true) and ($query2_result==true)) {     
   echo "<script type='text/javascript'>alert(\"Registered Successfully!Please check your inbox for activation link.\")</script>";
    echo "<script type='text/javascript'>window.location.href = '/PV/login.php';</script>";

    die(); 
  }
   else { 
    echo "Error:Adding security Questions!! " . "<br>" . mysqli_error($conn); 
  } 
    echo "";
    die(); 
  }
   else { 
    echo "Error:while creating account!!" . "<br>" . mysqli_error($conn); 
  } 

  mysqli_close($conn); 
}
}
}
?>

