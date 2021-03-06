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
<html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Update Task</title>

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
</head>
<body>
<div align="center"  style= "width: 1000px;" class="login-form">
  <br><br><br>
 <div class="btn-group" role="group" aria-label="...">
  <button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/TaskManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>

<h3 align="center">Click on Update button of any item you wish to update.</h3>
    <br>

<?php
if($uid==NULL or $uid=="")
  {
    echo "<script type='text/javascript'>alert(\"Something went wrong!\")</script>";
    exit();
  }
$view_jobs = mysqli_query($conn,"SELECT * FROM task where uid='$uid'");
$count = mysqli_num_rows($view_jobs);
  if($count==0)
  {
    echo "Looks like you haven't added any task!";
  }
  else{
     $i=1;
    echo "<p><strong><i>You have ".$count." tasks!</i></strong></p>";
echo '<div class="table-responsive">';
echo '<table class="table table-striped table-dark ">
<thead>
<tr>
<th scope="col"></th>
<th scope="col">Sl. No.</th>
<th scope="col">Task Name</th>
<th scope="col">Start Date</th>
<th scope="col">Start Time</th>
<th scope="col">End Date</th>
<th scope="col">End Time</th>
<th scope="col">Completed Date</th>
<th scope="col">Completed Time</th>
<th scope="col">Task Status</th>
<th scope="col">Description</th>

</tr>
</thead>';
while($row = mysqli_fetch_array($view_jobs))
{
echo "<tbody>"; 
echo "<tr>";
echo "<th scope='row'>";
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
echo "<td>" . $row['taskStatus'] . "</td>";
echo "<td>" . $row['taskDesc'] . "</td>";

$i+=1;
echo "<td align='center'>".'<a style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;" href=updateTask.php?task_id='.$row['taskId'].'>Update</a></td>';
echo "</tr>";
}
echo "</tbody>";
echo "</table>";
echo "</div>";
}
mysqli_close($conn);
?>
</div>
 <br><br><p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</body>
</html>
   