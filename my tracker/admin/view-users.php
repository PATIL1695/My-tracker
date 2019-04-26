<?php
include ($_SERVER['DOCUMENT_ROOT'].'/PV/session_expiry.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/admin/admin-authenticate.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Admin view user</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<link rel="stylesheet" href="/PV/css/review.css">
</head>
<body>
<div align="center"  style= "width: 650px;" class="login-form">
  <br><br><br>
 <div class="btn-group" role="group" aria-label="...">
  <button type="button" onclick="window.location.href='/PV/admin-home.php'" class="btn btn-default">Back</button>
  <button type="button" onclick="window.location.href='/PV/admin-home.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
<h3 align="center">Displaying all users</h3>
    <br>
<?php
$view_user = mysqli_query($conn,"SELECT * FROM users where role='user'");
$count = mysqli_num_rows($view_user);
  if($count==0)
  {
    echo "<h3>No users to display!</h3>";
  }
  else{
     $i=1;
    echo "<p><strong><i>There are ".$count." users!</i></strong></p>";
echo '<div class="table-responsive">';
echo '<table class="table table-striped table-dark">
<thead><tr>
<th scope="col">Sl. No.</th>
<th scope="col">Username</th>
<th scope="col">Email</th>
<th scope="col">Account Created On</th>
<th scope="col">Last Login</th>
<th scope="col">Role</th>
</tr>
</thead>';

while($row = mysqli_fetch_array($view_user))
{
echo "<tbody>"; 
echo "<tr>";
echo "<td>" . $i . "</td>"; 
echo "<td>" . $row['username'] . "</td>";
echo "<td>" . $row['email'] . "</td>";
echo "<td>" . $row['created_on'] . "</td>";
echo "<td>" . $row['last_login'] . "</td>";
echo "<td>" . $row['role'] . "</td>";
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
   