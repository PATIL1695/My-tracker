<?php
include ($_SERVER['DOCUMENT_ROOT'].'/PV/email.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');
if (isset($_GET['token'])&&($_GET['email'])){
$token = $conn->real_escape_string($_GET['token']);
$email=$conn->real_escape_string($_GET['email']);
//Retrieve data from table where row that match this passkey
$sql1 = "SELECT uid,email FROM users WHERE token='$token' AND email='$email'";
$result1 = mysqli_query($conn,$sql1);
//If successfully queried
if ($result1)
{
    //Count how many has this passkey
    $count = mysqli_num_rows($result1);
    //if found this passkey,retieve data from table temp_members
    if ($count == 1)
    {
        $rows = mysqli_fetch_row($result1);
        $uid = $rows[0];
        $email=$rows[1];
        session_start();
        $_SESSION['uid'] = $uid;
        $_SESSION['email'] = $email;
        echo "Redirecting to reset password";
        echo "<script type='text/javascript'>window.location.href = '/PV/resetPassword.php';</script>";
                
    }
        else
    {
       echo "<script type='text/javascript'>alert(\"Invalid reset link!\")</script>";
       echo "<script type='text/javascript'>window.location.href = '/PV/index.html';</script>";
    }
}
}
?>

 