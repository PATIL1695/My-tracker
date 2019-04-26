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
include ($_SERVER['DOCUMENT_ROOT'].'/PV/function.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dollar</title>

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
</head>
<body >    

  <div class="login-form">
    <br><br><br>
 <div class="btn-group" role="group" aria-label="...">
  <button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/ExpenseManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
<form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
   <h3 class="text-center"><bold> Add Dollar Value</bold></h3><br>
   <p>Month</p>
<div class="form-group"> <input type="month"  class ="form-control input-lg" name="month" required></div>
   <p> Dollar Value(in INR)</p>
   <div class="form-group"> <input  type="number"  class ="form-control input-lg" name="value" step="any"></div>
<div class="form-group clearfix"> <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit"  value="Add" /></div>
</form></div>
</body>
</html> 
   
<?php
if ( isset( $_POST['submit'] ) ){
  extract($_POST);
  $nmonth=$month."-00";
  $check_query="select * from dollar where (month='$nmonth' and uid='$uid');";
      $res=mysqli_query($conn,$check_query);
        $row = mysqli_fetch_assoc($res);
        if ($nmonth==$row['month'])
            {
                 echo "<script type='text/javascript'>alert(\"Dollar value for ".$month." already exists!\")</script>";
            }
else{
      $add_query = "INSERT INTO dollar (`uid`,`month`,`dollar`) VALUES('$uid','$nmonth','$value')";
      $query1_result = mysqli_query($conn, $add_query) or die(mysqli_error($conn));
      if($query1_result){
         echo "<script type='text/javascript'>alert(\"Dollar value added successful!\")</script>";
 echo "<script type='text/javascript'>window.location.href = '/PV/usr/ExpenseManager/dollar.php';</script>";
      }

else{
   echo "<script type='text/javascript'>alert(\"Dollar value added unsuccessful!\")</script>";
 echo "<script type='text/javascript'>window.location.href = '/PV/usr/ExpenseManager/dashboard.php';</script>";
      }
}
}
?>

<!-- Update Dollar Value -->
<?php
echo "<h3 align='center'>Update Dollar Value</h3>";
$view_query = mysqli_query($conn, "SELECT * FROM dollar WHERE uid='$uid' ORDER BY month ASC");
  $count = mysqli_num_rows($view_query);
  if($count==0)
  {
    echo"<p align='center'><strong>Looks like there is no dollar value added.</p></strong>";
  }
  else{
     $i=1;
echo '<div align="center" class="login-form">';
echo '<div  class="table table-responsive">';
echo '<table class="table table table-bordered">
<thead>
<tr>
<th scope="col">Sl. No.</th>
<th scope="col">Date/Month(yyyy-mm-dd)</th>
<th scope="col">Value(in INR)</th>
<th scope="col">Action</th>
</tr>
</thead>';
while($row = mysqli_fetch_array($view_query))
{
$mon=substr($row['month'],0,7);
$m=$mon.'-02';
$month=date('F', strtotime($m));
$year=date('Y', strtotime($m));
echo "<tbody>"; 
echo "<tr>";
echo "<td>" . $i . "</td>"; 
echo "<td>" . $month.' - '.$year . "</td>";
echo "<td>" . $row['dollar'] . "</td>";
$i+=1;
echo "<td align='center'>".'<a style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;" href=update-dollar.php?temp='.$row['id'].'>Update</a></td>';
echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</div>";
mysqli_close($conn);
echo '</div>';
echo '<p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>';
}

?>