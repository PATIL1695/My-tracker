<?php
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');

//Passkey that got from link
$passkey = $_GET['passkey'];
//global variable
$table1 = "tmp_users";
$table2 = "users";

//Retrieve data from table where row that match this passkey
$sql1 = "SELECT * FROM $table1 WHERE activate_link='$passkey'";
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
        $email = $rows[1];
        $password = $rows[2];
        $username = $rows[3];
        $role='user';
        $act_status='1';
        //Insert data that retrieve from "temp_members" into "registered_member"
        $sql2 = "INSERT INTO $table2(uid,username,email,password,role,act_status,created_on) VALUES('$uid','$username','$email','$password','$role','$act_status',now())";
        $result2 = mysqli_query($conn,$sql2);
    }

    else
    {
       echo "<script type='text/javascript'>alert(\"Wrong Activation code!\")</script>";
     echo "<script type='text/javascript'>window.location.href = '/PV/index.html';</script>";
    }

    //if successfully moved data,display message account has been activated and delete confirmation code from
    //"temp_members"

    if ($result2)
    {

        //Delete user information form "temp_members" that has the passkey
        $sql3 = "DELETE FROM $table1 WHERE activate_link = '$passkey'";
        $result3 = mysqli_query($conn,$sql3);
        echo "<script type='text/javascript'>alert(\"Your account is activated.You will be now redirected to login page.\")</script>";
     echo "<script type='text/javascript'>window.location.href = '/PV/login.php';</script>";

    }


}

?>
