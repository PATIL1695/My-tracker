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
<title>View Passwords</title>

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
</head>
<body >    

  <div align="center" style= "width: 750px;" class="login-form">
    <br><br><br>
 <div  class="btn-group" role="group" aria-label="...">
  <button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/PasswordManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
    <h3 class="text-center"><strong>Displaying passwords</strong></h3><br>
<?php
if($uid==NULL or $uid=="")
  {
    echo "<script type='text/javascript'>alert(\"Something went wrong!\")</script>";
    exit();
  }
echo "<h4><strong>Displaying Other Passwords</strong></h4>";
$view_user = mysqli_query($conn,"SELECT * FROM general where uid ='$uid'");
$count = mysqli_num_rows($view_user);
  if($count==0)
  {
    echo "No records to display!";
  }
   else{
    $i=1;
    echo "<p><strong><i>You have ".$count." other passwords!</i></strong></p>";
echo '<div class="table-responsive">';
echo '<table class="table table-striped table-dark ">
<thead>
<tr>
<th scope="col"></th>
<th scope="col">Sl. No.</th>
<th scope="col">Vendor Name</th>
<th scope="col">Vendor Type</th>
<th scope="col">Email</th>
<th scope="col">Phone No.</th>
<th scope="col">Username</th>
<th scope="col">Password</th>
</tr>
</thead>';

while($row = mysqli_fetch_array($view_user))
{
echo "<tbody>"; 
echo "<tr>";
echo "<th scope='row'>";
echo "<td>" . $i . "</td>";  
echo "<td>" . $row['vendorname'] . "</td>";
echo "<td>" . $row['vendortype'] . "</td>";
echo "<td>" . $row['email'] . "</td>";
echo "<td>" . $row['phoneno'] . "</td>";
echo "<td>" . $row['username'] . "</td>";
echo "<td>" . decryptPassword($row['password']) . "</td>";
echo "</tr>";
$i+=1;
}
echo "</tbody>";
echo "</table>";
echo "</div>";
}
echo "<h4><strong>Displaying Bank Passwords</strong></h4>";

$view_user = mysqli_query($conn,"SELECT * FROM bank where uid ='$uid'");
$count = mysqli_num_rows($view_user);
  if($count==0)
  {
    echo "Nothing to display!";
  }
  else
  {
      $i=1;
    echo "<p><strong><i>You have ".$count." bank passwords!</i></strong></p>";
echo '<div class="table-responsive">';
echo '<table class="table table-striped table-dark">
<thead>
<tr>
<th scope="col"></th>
<th scope="col">Sl.No.</th>
<th scope="col">Bank Name</th>
<th scope="col">IFSC Code</th>
<th scope="col">Account Type</th>
<th scope="col">Account No</th>
<th scope="col">Username</th>
<th scope="col">Password</th>
<th scope="col">Email</th>
<th scope="col">Phone No</th>
<th scope="col">Card Type-1</th>
<th scope="col">Card Type-2</th>
<th scope="col">Card No.</th>
<th scope="col">Card Expiry</th>
<th scope="col">Card PIN</th>
<th scope="col">Card CVV</th>
</tr>
</thead>';

while($row = mysqli_fetch_array($view_user))
{
echo "<tbody>"; 
echo "<tr>";
echo "<th scope='row'>";
echo "<td>" . $i . "</td>";  
echo "<td>" . $row['vendorname'] . "</td>";
echo "<td>" . $row['ifsc'] . "</td>";
echo "<td>" . $row['accounttype'] . "</td>";
echo "<td>" . $row['accountno'] . "</td>";
echo "<td>" . $row['username'] . "</td>";
echo "<td>" . decryptPassword($row['password']) . "</td>";
echo "<td>" . $row['email'] . "</td>";
echo "<td>" . $row['phoneno'] . "</td>";
echo "<td>" . $row['cardtype1'] . "</td>";
echo "<td>" . $row['cardtype2'] . "</td>";
echo "<td>" . $row['cardno'] . "</td>";
echo "<td>" . $row['cardexp'] . "</td>";
echo "<td>" . decryptPassword($row['cardpin']) . "</td>";
echo "<td>" . decryptPassword($row['cardcvv']) . "</td>";
echo "</tr>";
$i+=1;
}
echo "</tbody>";
echo "</table>";
echo "</div>";
mysqli_close($conn);
}
?>

</div>
</body><br><br>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 