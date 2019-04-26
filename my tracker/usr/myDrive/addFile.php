<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
    }
include ($_SERVER['DOCUMENT_ROOT'].'/PV/session_expiry.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/function.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/usr/user-authenticate.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Add Files</title>
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
  <button type="button" onclick="window.location.href='/PV/usr/myDrive/dashboard.php'" class="btn btn-default">Drive Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
 
 <form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>"  enctype="multipart/form-data" method="post">
     <h3 class="text-center">Upload File </h3><br>
 <div class="form-group"><label>Please select a folder:</label>
   <select class="form-control" name="folderName" id="folderName" required >
<option value="">- Select Folder -
<?php 
 $path=$_SERVER['DOCUMENT_ROOT'].'/PV/usrDrive/'.md5($uid).'/';
// $dirPath = dir($path);
$dirPath = scandir($path);
// while (($file = $dirPath->read()) !== false)
foreach ($dirPath as $file) 
{
  if (($file=='.') or($file=='..')){
    echo "";
  } 
  else{
   echo "<option value=\"" . trim($file) . "\">" . $file . "\n";
  }
}
?>
</select></div>
<p><i>Accepted file formats are .pdf,.docx, .csv, .jpeg, .txt, .pptx, and .png only! (Max file size 20MB).</i></p>
 <div class="form-group"><input type="file" class ="form-control input-lg" name="file" required></div>
 <div class="form-group clearfix">  <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Upload">
          </div></form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p><br><br>
</html>   

<?php


if(isset( $_POST['submit'])) {
  extract($_POST); 
if ($_FILES['file']['type']=='application/pdf' or $_FILES['file']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' or  $_FILES['file']['type']=='image/jpeg' or $_FILES['file']['type']=='image/png' or $_FILES['file']['type'] == 'text/plain' or $_FILES['file']['type'] == 'application/vnd.ms-excel' or $_FILES['file']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' or $_FILES['file']['type'] == 'application/vnd.ms-powerpoint'  or $_FILES['file']['type'] == 'application/vnd.openxmlformats-officedocument.presentationml.presentation' ){ 

$max_size=9999999999999999;
$fileName=$_FILES['file']['name'];
$actual_size=$_FILES['file']['size'];
#echo $actual_size;
$path=$_SERVER['DOCUMENT_ROOT'].'/PV/usrDrive/'.md5($uid).'/'.$folderName.'/'.$fileName;
$status1=checkFilesize($actual_size,$max_size);
if ($status1==0)
{
 $status2=filenameExists($fileName,$path);
 if($status2==1)
 {
 if(move_uploaded_file($_FILES['file']['tmp_name'],$path))
 {
   echo "<script type='text/javascript'>alert(\"The file ". basename( $_FILES['file']['name'])." is uploaded successsfully!!\")</script>";
 }
 else {
   echo "<script type='text/javascript'>alert(\"Problem uploading file!\")</script>";
 }
 }
else
{
 echo "<script type='text/javascript'>alert(\"File name with ".$fileName." already exists!\")</script>";
 exit();
}
}
else
{
 echo "<script type='text/javascript'>alert(\"Filesize must not exceed 20MB!\")</script>";
 exit();
}

}

else {
   echo "<script type='text/javascript'>alert(\"Not a valid file format! Please upload only .pdf,.docx, .csv, .jpeg, .txt,.pptx, and .png  file.\")</script>";
}
}
?>
