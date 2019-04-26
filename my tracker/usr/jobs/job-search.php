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
<title>Search job applied</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<link rel="stylesheet" href="/PV/google/google.css">
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
  <button type="button" onclick="window.location.href='/PV/usr/jobs/index.php'" class="btn btn-default">Job Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
   <h3 align="center"><strong>Search for jobs applied</strong></h3>
<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">       
  <p>Please select the category</p>
            <div class="form-group"> <select class="form-control input-lg" name="searchby">
                  <option value="company">Company</option>
                  <option value="designation">Designation</option>
                  <option value="status">Status</option>
                  <option value="type">Type</option>
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
 $search_query = mysqli_query($conn, "SELECT * FROM jobs
    WHERE ((company LIKE '%{$keyword}%' OR designation LIKE '%{$keyword}%' OR status LIKE '%{$keyword}%' OR type LIKE '%{$keyword}%') and (uid='$uid'))");
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
<th scope="col">Company</th>
<th scope="col">Designation</th>
<th scope="col">Status</th>
<th scope="col">Applied On</th>
<th scope="col">Interviewed On</th>
<th scope="col">Type</th>
<th scope="col">Comment</th>
<th scope="col">Action</th>
</tr>
</thead>';
echo"<p><br><strong>Dispalying result based on search by keyword "."'".$keyword."'"."</p></strong>";

while($row = mysqli_fetch_array($search_query))
{
echo "<tbody>"; 
echo "<tr>";
echo "<td>" . $i . "</td>"; 
echo "<td>" . $row['company'] . "</td>";
echo "<td>" . $row['designation'] . "</td>";
echo "<td>" . $row['status'] . "</td>";
echo "<td>" . $row['applied_on'] . "</td>";
echo "<td>" . $row['interviewed_on'] . "</td>";
echo "<td>" . $row['type'] . "</td>";
echo "<td>" . $row['comment'] . "</td>";
$i+=1;
echo "<td align='center'>".'<a style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;" href=update-jobs-applied.php?job_id='.$row['job_id'].'>Update</a>'.' <i><strong> OR </i></strong> '.'<a onClick="return show_confirm();" style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;" href=delete-specific-job.php?job_id='.$row['job_id'].'>Delete</a>'.'</td>';
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


