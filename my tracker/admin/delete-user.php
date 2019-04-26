<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
    } 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/session_expiry.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/admin/admin-authenticate.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/function.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Admin delete user</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 <script>
function show_confirm()
    {
    var r=confirm("Selected users will be parmanently deleted!");
    if (r==true)
    {return true;
    }
    else
    {
    return false;
    }
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<link rel="stylesheet" href="/PV/css/review.css">
</head>
<body>
<div align="center" style= "width: 411px;" class="login-form">
  <br><br><br>
 <div class="btn-group" role="group" aria-label="...">
  <button type="button" onclick="window.location.href='/PV/admin-home.php'" class="btn btn-default">Back</button>
  <button type="button" onclick="window.location.href='/PV/admin-home.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
<h3 align="center">Click on the user(s) you wish to delete.</h3>
    
<?php
if($uid==NULL or $uid=="")
  {
    echo "<script type='text/javascript'>alert(\"Something went wrong!\")</script>";
    exit();
  }
$view_user = mysqli_query($conn,"SELECT * FROM users where role ='user'");
$count = mysqli_num_rows($view_user);
  if($count==0)
  {
    echo "<h3>No users to delete!</h3>";
  }
  else{
    $i=1;
    echo "<p align='center'><strong><i>There are ".$count." users!</i></strong></p>";
echo '<form method="post" id="form1" action="delete-user.php">';
echo '<div class="table-responsive">';
echo '<table class="table table table-bordered">
<thead><tr>
<th scope="col"></th>
<th scope="col">Sl. No.</th>
<th scope="col">Email</th>
<th scope="col">Role</th>
</tr>
</thead>';
while($row = mysqli_fetch_array($view_user))
{
echo "<tbody>"; 
echo "<tr>";
echo '<td>';
echo '<input type="checkbox" name="delete_id[]" value='.$row['uid'].'>'."</td>";
echo "<td>" . $i . "</td>";
echo "<td>" . $row['email'] . "</td>";
echo "<td>" . $row['role'] . "</td>";
echo "</tr>";
$i+=1;
}
echo "</tbody>";
echo "</table>";
echo "</div>";    
echo '<div style="margin-top:20px;">
         <div style=" float:left;">
           <input name="delete" type="submit" id="delete" value="Delete" onClick="return show_confirm();" style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;">
           &nbsp;
         </div>
         <div style="clear:both;"></div>
    </div>    
</form>'; 
 if ( isset( $_POST['delete'] ) ){
$delete_id = $_POST['delete_id'];
if($delete_id==null)
{
echo "<script type='text/javascript'>alert(\"Nothing selected to delete!\")</script>";
}
else
{
$delete_count = count($delete_id);
for($i=0;$i<$delete_count;$i++)
{
   $deleting_id = $delete_id[$i];
   $delete_query1= mysqli_query($conn,"Delete from users where uid='$deleting_id'");
   $delete_query2= mysqli_query($conn,"Delete from jobs where uid='$deleting_id'");
   $delete_query3 = mysqli_query($conn,"Delete from security_questions where uid='$deleting_id'");
   $delete_query4= mysqli_query($conn,"Delete from user_review where uid='$deleting_id'");
   $delete_query5 = mysqli_query($conn,"Delete from bank where uid='$deleting_id'");
   $delete_query6 = mysqli_query($conn,"Delete from general where uid='$deleting_id'");
   $delete_query7 = mysqli_query($conn,"Delete from task where uid='$deleting_id'");
    $delete_query8= mysqli_query($conn,"Delete from monthlyexpense where uid='$uid'");
      $delete_query9 = mysqli_query($conn,"Delete from dailyexpense where uid='$uid'");
      $delete_query10 = mysqli_query($conn,"Delete from dollar where uid='$uid'");
     $dir= $_SERVER['DOCUMENT_ROOT'].'/PV/usr/myDrive/'.md5($uid).'/';
    rmdir_recursive($dir);
   echo "<script type='text/javascript'>window.location.href = '/PV/admin/delete-user.php';</script>";
}
mysqli_close($conn);
}
}
}
?>
</div>
 <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</body>
</html>