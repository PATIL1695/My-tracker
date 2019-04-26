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
 <title>Delete task</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 <script>
function show_confirm()
    {
    var r=confirm("Selected tasks will be parmanently deleted!");
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
</head>
<body>
<div align="center"  style= "width: 900px;"class="login-form">
  <br><br><br>
 <div class="btn-group" role="group" aria-label="...">
 <button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/TaskManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
<h3 align="center">Click on the tasks(s) you wish to delete.</h3>
    
<?php
if($uid==NULL or $uid=="")
  {
    echo "<script type='text/javascript'>alert(\"Something went wrong!\")</script>";
    exit();
  }
$view_user = mysqli_query($conn,"SELECT * FROM task where uid='$uid'");
$count = mysqli_num_rows($view_user);
  if($count==0)
  {
    echo "<h3>No tasks to delete!</h3>";
  }
  else{
     $i=1;
    echo "<p><strong><i>You have for ".$count." tasks!</i></strong></p>";
echo '<form method="post" id="form1" action="deleteTask.php">';
echo '<div class="table-responsive">';
echo '<table class="table table table-bordered">
<thead><tr>
<th scope="col"></th>
<th scope="col">Sl. No.</th>
<th scope="col">Task Name</th>
<th scope="col">Start Date</th>
<th scope="col">Start Time</th>
<th scope="col">End Date</th>
<th scope="col">End Time</th>
<th scope="col">Completed Date</th>
<th scope="col">Completed Time</th>
<th scope="col">Description</th>
<th scope="col">Task Status</th>
</tr>
</thead>';
while($row = mysqli_fetch_array($view_user))
{
echo "<tbody>"; 
echo "<tr>";
echo '<td>';
echo '<input type="checkbox" name="delete_id[]" value='.$row['taskId'].'>'."</td>";
echo "<td>" . $i . "</td>";
echo "<td>" . $row['taskName'] . "</td>";
echo "<td>" . $row['startDate'] . "</td>";
echo "<td>" . date('h:i a',strtotime($row['stime'])) . "</td>";
echo "<td>" . $row['endDate'] . "</td>";
echo "<td>" .date('h:i a',strtotime($row['etime'])) . "</td>";
if($row['taskStatus']=="Completed"){
echo "<td>" . $row['completedDate'] . "</td>";
echo "<td>" .date('h:i a',strtotime($row['ctime'])) . "</td>";
}
else{
echo "<td>" . '-' . "</td>";
echo "<td>" .'-'. "</td>";
}
echo "<td>" . $row['taskDesc'] . "</td>";
echo "<td>" . $row['taskStatus'] . "</td>";
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
   $delete_query1= mysqli_query($conn,"Delete from task where taskId='$deleting_id' and uid='$uid'");
   echo "<script type='text/javascript'>window.location.href = '/PV/usr/TaskManager/deleteTask.php';</script>";
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