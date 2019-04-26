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
<title>Import jobs applied password</title>
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
  <button type="button" onclick="window.location.href='/PV/user-home.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/jobs/index.php'" class="btn btn-default">Job Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
 
 <form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>"  enctype="multipart/form-data" method="post">
     <h3 class="text-center">Import jobs applied </h3><br>
           <p>Please use .csv file format files.</p>
 <div class="form-group"><input type="file" class ="form-control input-lg" name="file" ></div>
 <div class="form-group clearfix">  <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Import">
          </div></form>
</body></div>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p><br><br>
   <p align="center">Logs:</p>
</html>   

<?php
if($_FILES){
  //Checking if file is selected or not
  if($_FILES['file']['name'] != "" or $_FILES['name']==null) { 
        //Checking if the file is plain text or not
  if(isset($_FILES) && $_FILES['file']['type'] != 'text/plain' and $_FILES['file']['type'] != 'application/vnd.ms-excel') {
    echo "<script type='text/javascript'>alert(\"Not a valid file format! Please upload only '.csv' file.\")</script>";
  exit();
  } 
function display_output($success)
{
    if($success==1)
    {
    echo "<p align='center'>Data imported successfully!" ."</p><br>";
    }
    else
    {
      echo "<p align='center'>Error while importing data!"."</p><br>";
    }
}

function check_for_duplicate($conn,$uid,$company,$designation,$type)
{
   $duplicate_flag=0;
   $check_job_query="SELECT * from jobs where ((company='$company') and (designation='$designation')and (type='$type') and (uid='$uid'));";

      $res=mysqli_query($conn,$check_job_query);

      if (mysqli_num_rows($res) > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($res);
         $str1=strtoupper($row['company']); 
        $str2=strtoupper($row['designation']); 
        $str3=strtoupper($row['type']);
       if (($company==$str1)  and ($designation==$str2) and ($type=$str3))
            {
                echo "This job already exists!!";
                $duplicate_flag=1;
                return $duplicate_flag;
       } 
            else
  $duplicate_flag=0;
  return $duplicate_flag;
       }
   }
  


function insert_job_applied($conn,$uid,$company,$designation,$applied_on,$status,$type,$comment) {
    $success=0;
    $cardno=0;
    $duplicate_flag=check_for_duplicate($conn,$uid,$company,$designation,$type);
    if($duplicate_flag==0)
    {
     $add_job_query="INSERT INTO jobs (`uid`,`company`,`designation`,`applied_on`,`status`,`type`,`comment`) VALUES('$uid','$company','$designation','$applied_on','$status','$type','$comment')";
    $result=mysqli_query($conn,$add_job_query);
    if ($result == 1){
    $success=1;
    return $success;
      }
    }
        else
    {
        $success=0;
        return $success;
      }
    mysqli_close($conn);
}

    $fileName = $_FILES['file']['tmp_name'];

  if ($_FILES['file']['type']=='application/vnd.ms-excel'){ //text file implementation
 
  //csv implementation 
   $csv_file = fopen($fileName, "r");
   while (($line = fgetcsv($csv_file, 10000, ",")) !== FALSE)
   {
    $company=strtoupper($line[0]);
    $designation=strtoupper($line[1]);
    $applied_on=$line[2];
    $status=$line[3];
    $type=strtoupper($line[4]);
    $comment=$line[5];
    $success=insert_job_applied($conn,$uid,$company,$designation,$applied_on,$status,$type,$comment);
    display_output($success);
}
  }
}
}
//end csv
?> 

