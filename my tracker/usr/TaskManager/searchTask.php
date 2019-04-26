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
<title>Search task</title>
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
<body >
<div class="login-form"><br><br><br>
   <div  class="btn-group" role="group" aria-label="...">
    <button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/TaskManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
   <h3 align="center"><strong>Search for tasks</strong></h3>
<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">       
  <p>Please select the category</p>
            <div class="form-group"> <select class="form-control input-lg" name="searchby">
                  <option value="taskName">Task Name</option>
                  <option value="taskStatus">Task Status</option>
                  <option value="taskDesc">Task Description</option>
                </select></div>
                 <div class="form-group">      <input type="text" class="form-control input-lg" name="keyword" placeholder="Keyword" required ></div>
        <div class="form-group clearfix"> <input type="submit" class="btn btn-primary btn-lg pull-right" name="search" value="Search"></div>
        </form>
</div>
</body>
 
</html> 

<?php
 if ( isset( $_POST['search'] ) ){
    extract($_POST); 
 $search_query = mysqli_query($conn, "SELECT * FROM task
    WHERE ((taskDesc LIKE '%{$keyword}%' OR taskStatus LIKE '%{$keyword}%' OR taskName LIKE '%{$keyword}%') and (uid='$uid'))");
$count = mysqli_num_rows($search_query);
  if($count==0)
  {
    echo"<p align='center'><strong>Your search did not fetch any result.</p></strong>";
  }
  else{
     $i=1;
    echo "<p align='center'><strong><i>Your search yielded ".$count." results!</i></strong></p>";
echo '<div align="center" style= "width: 850px;" class="login-form">';
echo '<div  class="table table-responsive">';
echo '<table class="table table table-bordered">
<thead>
<tr>
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
<th scope="col">Action</th>
</tr>
</thead>';
echo"<p><br><strong>Dispalying result based on search by keyword "."'".$keyword."'"."</p></strong>";

while($row = mysqli_fetch_array($search_query))
{
echo "<tbody>"; 
echo "<tr>";
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
$i+=1;
echo "<td align='center'>".'<a style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;" href=updateTask.php?task_id='.$row['taskId'].'>Update</a>'.' <i><strong> OR </i></strong> '.'<a onClick="return show_confirm();"style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;" href=delete-specific-task.php?task_id='.$row['taskId'].'>Delete</a>'.'</td>';
echo "</tr>";
}
echo "</tbody>";
echo "</table>";
echo "</div>";
mysqli_close($conn);
echo '</div>';
echo '<p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>';
}
}
?>


