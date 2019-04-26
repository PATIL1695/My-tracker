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
<title>Update Jobs Applied</title>

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
  <button type="button" onclick="window.location.href='/PV/usr/jobs/index.php'" class="btn btn-default">Job Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
<?php
// get value of id that sent from address bar
$id=$_GET['job_id'];
// Retrieve data from database 
$sql="SELECT * FROM jobs WHERE (job_id = '$id' and uid='$uid')";
$result=mysqli_query($conn,$sql);
$rows=mysqli_fetch_array($result);
$company=$rows['company'];
?>
<form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
   <h3 class="text-center"><bold>Update for <?php echo "'".$company."'"; ?></bold></h3><br>
   <p>Company Name</p>
   <div class="form-group"> <input  type="text"  class ="form-control input-lg" name="company" value="<?php echo $rows['company']; ?>"></div>
   <p>Designation</p>
<div class="form-group"> <input type="text"  class ="form-control input-lg" name="designation" value="<?php echo $rows['designation']; ?>" >
  <p>Job-Type</p>
<div class="form-group">
                <select  class ="form-control input-lg" name="type">
                	<option value="<?php echo $rows['type']; ?>"><?php echo $rows['type'].'(Selected)'; ?></option>
                     <option>On-Campus</option>
                  <option>Internship</option>
                      <option>Full-Time</option>
                        <option>Others</option>
                </select> </div>
                <p>Job Status</p>
<div class="form-group">
                <select  class ="form-control input-lg" name="status">
                	<option value="<?php echo $rows['status']; ?>"><?php echo $rows['status'].'(Selected)'; ?></option>
                  <option>Rejected</option>
                   <option>Applied</option>
                  <option>Reviewed</option>
                   <option>Cleared</option>
                  <option>Interviewed</option>
                  <option>Others</option>
                </select>
              </div>
              <p>Applied On</p>
<div class="form-group"> <input type="date"  class ="form-control input-lg" name="applied_on" value="<?php echo $rows['applied_on']; ?>"></div>
<p>Interviewed On</p>
<div class="form-group"> <input type="date"  class ="form-control input-lg" name="interviewed_on" value="<?php echo $rows['interviewed_on']; ?>">
</div>
<p>Comments</p>
	<div class="form-group"><textarea name="comment"   class ="form-control input-lg" class="form-control input-lg"  rows=6 cols=6 maxlength=3000 ><?php echo $rows['comment']; ?> </textarea>
</div>
<input name="id" type="hidden" id="id" value="<?php echo $rows['job_id']; ?>"/>
<div class="form-group clearfix"> <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit"  value="Update" /></td></div>
</form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 
   
<?php
if ( isset( $_POST['submit'] ) ){
	extract($_POST);
$sql="UPDATE jobs SET company= '$company',designation= '$designation',type= '$type',status= '$status', applied_on= '$applied_on', interviewed_on= '$interviewed_on', comment= '$comment' where (job_id='$id' and uid='$uid')" ;

$result=mysqli_query($conn,$sql) or 
die ("Error");

// if successfully updated. 
if($result){
	echo "<script type='text/javascript'>alert(\"Update successful!\")</script>";
 echo "<script type='text/javascript'>window.location.href = '/PV/usr/jobs/display-info-before-update.php';</script>";
  // echo "<script type='text/javascript'>javascript:history.go(-2)</script>";
  // header("Refresh:2; url='/PV/usr/jobs/display-info-before-update.php'");

echo "<BR>";

}

else {
echo "ERROR";echo "<script type='text/javascript'>alert(\"Error while updating!!\")</script>";
 echo "<script type='text/javascript'>window.location.href = '/PV/usr/jobs/index.php';</script>";}
}
?>