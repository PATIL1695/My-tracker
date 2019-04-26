<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
    }
include ($_SERVER['DOCUMENT_ROOT'].'/PV/session_expiry.php'); 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php'); 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/usr/user-authenticate.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>View individual task(s)</title>
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

  <div class="login-form">
    <br><br><br>
 <div class="btn-group" role="group" aria-label="...">
 <button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/TaskManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
<?php
// get value of id that sent from address bar
$id=$_GET['task_id'];
// Retrieve data from database 
$sql="SELECT * FROM task WHERE (taskId = '$id' and uid='$uid')";
$result=mysqli_query($conn,$sql);
$rows=mysqli_fetch_array($result);
$tname=$rows['taskName'];

?>
<script language="javascript" type="text/javascript">
var id =10;
console.log(id);
</script>

<form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
   <h3 class="text-center"><bold>Task <?php echo "'".$tname."'"; ?> details</bold></h3><br>
   <p>Task Name</p>
   <div class="form-group"> <input  type="text"  class ="form-control input-lg" name="taskName" value="<?php echo $rows['taskName']; ?>" disabled></div>
   <p>Start Date</p>
<div class="form-group"> <input type="date"  class ="form-control input-lg" name="startDate" value="<?php echo $rows['startDate']; ?>" disabled></div>
   <p>Start Time</p>
<div class="form-group"><input type="time" class ="form-control input-lg"  name="stime" value="<?php echo $rows['stime']; ?>" disabled></div>
<p>End Date</p>
<div class="form-group"> <input type="date"  class ="form-control input-lg" name="endDate" value="<?php echo $rows['endDate']; ?>" disabled></div>
   <p>End Time</p>
<div class="form-group"><input type="time" class ="form-control input-lg"  name="etime" value="<?php echo $rows['etime']; ?>" disabled></div>
<p>Completed Date</p>
<div class="form-group"> <input type="date"  class ="form-control input-lg" name="completedDate" value="<?php echo $rows['completedDate']; ?>" disabled ></div>
   <p>Completed Time</p>
<div class="form-group"><input type="time" class ="form-control input-lg"  name="ctime" value="<?php echo $rows['ctime']; ?>" disabled ></div>
<p>Task Status</p>
<div class="form-group">
                <select class ="form-control input-lg" name="taskStatus" disabled>
          <option value="<?php echo $rows['taskStatus']; ?>"><?php echo $rows['taskStatus'].'(Selected)'; ?></option>
               <option>In-Progress</option>
            <option>Completed</option>
                <option>Created</option>
                  <option>Others</option>
          </select> </div>
<p>Task Description</p>
  <div class="form-group"><textarea name="taskDesc" disabled class="form-control input-lg"  rows=6 cols=6 maxlength=2000 ><?php echo $rows['taskDesc']; ?> </textarea></div>

<div class="form-group clearfix"> <input type="button" onclick="window.location.href='updateTask.php?task_id=<?php echo $id; ?>'" class="btn btn-primary btn-lg pull-left" value="Update" >


<div class="form-group clearfix"> <input type="button" onclick="window.location.href='delete-specific-task.php?task_id=<?php echo $id; ?>'; return show_confirm(); " class="btn btn-primary btn-lg pull-right" value="Delete"></div>
</form></div>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 
