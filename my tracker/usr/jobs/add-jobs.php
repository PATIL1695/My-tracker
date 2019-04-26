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
<title>Add Jobs Applied</title>

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
  
 <form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
     <h3 class="text-center">Add jobs applied into database</h3><br>
<div class="form-group"><input type="text" class ="form-control input-lg"  placeholder="Company Name" name="company" required>   </div>
<div class="form-group"><input type="text" class ="form-control input-lg"  placeholder="Designation" name="designation" required>   </div>
    
             <div class="form-group"> <label>Application Status</label>
                <select class="form-control input-lg" name="status" required>
                  <option>Rejected</option>
                   <option selected="Applied">Applied</option>
                  <option>Reviewed</option>
                  <option>Interviewed</option>
                  <option>Cleared</option>
                  <option>Others</option>
                </select> </div>
                <div class="form-group"><label>Job Type</label>
                <select class="form-control" name="type" required>
                  <option>On-Campus</option>
                  <option selected="Internship">Internship</option>
                      <option>Full-Time</option>
                        <option >Others</option>
                </select></div>
            <div class="form-group">Applied On:<br> <input class="form-control input-lg" type="date" name="applied_on" min="2018-01-01" max="2020-01-01" required></div>
             <div class="form-group"> <textarea name="comment" class="form-control input-lg" placeholder="Comments"  rows=5 cols=5 maxlength=2000 ></textarea><br></div>
           
       <div class="form-group clearfix">  <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Add Job">
          </div></form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 

<?php

if($uid==NULL or $uid=="")
  {
    echo "<script type='text/javascript'>alert(\"Something went wrong!\")</script>";
    exit();
  }
 if ( isset( $_POST['submit'] ) ){
  extract($_POST);
  $str1=strtoupper($company); 
  $str3=strtoupper($designation);
  $str5=strtoupper($type); 
  $str7=$applied_on; 
  $check_job_query="SELECT * from jobs where ((company='$company') and (designation='$designation') and (applied_on='$applied_on') and (type='$type')  and (uid='$uid'));";

      $res=mysqli_query($conn,$check_job_query);

      if (mysqli_num_rows($res) > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($res);
        
        $str2=strtoupper($row['company']); 
      
        $str4=strtoupper($row['designation']); 
      
        $str6=strtoupper($row['type']);
        $str8=$row['applied_on'];
        if (($str1==$str2)  and ($str3==$str4) and ($str5==$str6)  and ($str7==$str8))
            {
                echo "<script type='text/javascript'>alert(\"This job already exists!!\")</script>";
       } 
     }
       else
       {
   
    $add_job_query="INSERT INTO jobs (`uid`,`company`,`designation`,`applied_on`,`status`,`type`,`comment`) VALUES('$uid','$company','$designation','$applied_on','$status','$type','$comment')";
    if(mysqli_query($conn,$add_job_query)){
      echo "<script type='text/javascript'>alert(\"Job has been added successfully!\")</script>";
  }
   else { 
    echo "Error while adding job! " . "<br>" . mysqli_error($conn); 
  } 
 mysqli_close($conn); 
}
}

?>
