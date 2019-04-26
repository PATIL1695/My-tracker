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
 <title>View all reminders</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<script type="text/javascript">
function show_confirm()
    {
    var r=confirm("Selected item will be parmanently deleted!");
    if (r==true)
    {return true;
    }
    else
    {
    return false;
    }
    }
  </script>
</head>
<body>
<div align="center"  style= "width: 850px;" class="login-form">
  <br><br><br>
 <div class="btn-group" role="group" aria-label="...">
<button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/TaskManager/Reminder/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
<h3 align="center">Displaying all reminders</h3>
    <br>
<?php
$view_user = mysqli_query($conn,"SELECT * FROM reminder where uid='$uid'");
$count = mysqli_num_rows($view_user);
  if($count==0)
  {
    echo "<h3>No reminder to display!</h3>";
  }
  else{
        $i=1;
    echo "<p><strong><i>You have for ".$count." reminders!</i></strong></p>";
echo '<div class="table-responsive">';
echo '<table class="table table-striped table-dark">
<thead><tr>
<th scope="col">Sl. No.</th>
<th scope="col">Reminder Name</th>
<th scope="col">Reminder Date</th>
<th scope="col">Reminder Time</th>
<th scope="col">Location</th>
<th scope="col">Description</th>
<th scope="col">Action</th>
</tr>
</thead>';

while($row = mysqli_fetch_array($view_user))
{
echo "<tbody>"; 
echo "<tr>";
echo "<td>" . $i . "</td>";
echo "<td>" . $row['rName'] . "</td>";
echo "<td>" . $row['rDate'] . "</td>";
echo "<td>" . $row['rTime'] . "</td>";
echo "<td>" . $row['place'] . "</td>";
echo "<td>" . $row['rDesc'] . "</td>";
echo "<td align='center'>".'<a style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;" href=updateReminder.php?reminder_id='.$row['rId'].'>Update</a>'.' <i><strong> OR </i></strong> '.'<a onClick="return show_confirm();"style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;" href=delete-reminder.php?reminder_id='.$row['rId'].'>Delete</a>'.'</td>';

echo "</tr>";
$i+=1;
}
echo "</tbody>";
echo "</table>";

mysqli_close($conn);
}
?>
</div>
 <br><br><p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</body>
</html>
   