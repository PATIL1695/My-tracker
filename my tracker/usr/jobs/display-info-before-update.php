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
<title>Update Jobs Applied</title>

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
</head>
<body>
<div align="center"  style= "width: 1100px;" class="login-form">
  <br><br><br>
 <div class="btn-group" role="group" aria-label="...">
  <button type="button" onclick="window.location.href='/PV/user-home.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/jobs/index.php'" class="btn btn-default">Job Home</button>
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
$view_jobs = mysqli_query($conn,"SELECT * FROM jobs where uid='$uid'");
$count = mysqli_num_rows($view_jobs);
  if($count==0)
  {
    echo "Looks like you haven't applied for any jobs!";
  }
  else{
     $i=1;
    echo "<p><strong><i>You have applied for ".$count." jobs!</i></strong></p>";
echo '<div class="table-responsive">';
echo '<table class="table table-striped table-dark ">
<thead>
<tr>
<th scope="col"></th>
<th scope="col">Sl. No.</th>
<th scope="col">Company Name</th>
<th scope="col">Designation</th>
<th scope="col">Applied On</th>
<th scope="col">Interviewed On</th>
<th scope="col">Application Status</th>
<th scope="col">Job Type</th>
<th scope="col">Comment</th>
<th scope="col">Action</th>
</tr>
</thead>';
while($row = mysqli_fetch_array($view_jobs))
{
echo "<tbody>"; 
echo "<tr>";
echo "<th scope='row'>";
echo "<td>" . $i . "</td>";  
echo "<td>" . $row['company'] . "</td>";
echo "<td>" . $row['designation'] . "</td>";
echo "<td>" . $row['applied_on'] . "</td>";
echo "<td>" . $row['interviewed_on'] . "</td>";
echo "<td>" . $row['status'] . "</td>";
echo "<td>" . $row['type'] . "</td>";
echo "<td>" . $row['comment'] . "</td>";
$i+=1;
echo "<td align='center'>".'<a style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;" href=update-jobs-applied.php?job_id='.$row['job_id'].'>Update</a></td>';
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
   
