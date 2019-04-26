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
<title>Import password</title>
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
  <button type="button" onclick="window.location.href='/PV/usr/PasswordManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
 
 <form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>"  enctype="multipart/form-data" method="post">
     <h3 class="text-center">Import password </h3><br>
           <p>Please use file format .csv or .txt.</p>
 <div class="form-group"><input type="file" class ="form-control input-lg" name="file" ></div>
 <div class="form-group clearfix">  <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Import">
          </div></form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p><br><br>
   <p align="center">Logs:</p>
</html>   

<?php
if($_FILES){
  //Checking if file is selected or not
  if($_FILES['file']['name'] != "" or $_FILES['name']==null) { 
        //Checking if the file is plain text or not
  if(isset($_FILES) && $_FILES['file']['type'] != 'text/plain' and $_FILES['file']['type'] != 'application/vnd.ms-excel') {
    echo "<script type='text/javascript'>alert(\"Not a valid file format! Please upload any '*.txt' or '*.csv' file.\")</script>";
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

function check_for_duplicate($uid,$conn,$vendortype,$vendorname,$cardno,$username,$email)
{
   $duplicate_flag=0;
   if($vendortype=='bank' or $vendortype=="Bank")
   {  
      $check_email_query="select * from bank where ((vendorname='$vendorname') and (cardno='$cardno'));";
      $res=mysqli_query($conn,$check_email_query);
      if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if (($vendorname==$row['vendorname']) and ($cardno==$row['cardno']))
            {
               echo "<p align='center'>$cardno for $vendorname already exist!"."</p><br>";
               $duplicate_flag=1;
               return $duplicate_flag;
            }
            else
  $duplicate_flag=0;
  return $duplicate_flag;
       }
   }
  else
  {

  $check_email_query="select * from general where ((username='$username' or email='$email') and (vendorname='$vendorname'));";
      $res=mysqli_query($conn,$check_email_query);
      if (mysqli_num_rows($res) > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($res);
        if (($username==$row['username'])  and ($vendorname==$row['vendorname']))
            {     

                echo "<p align='center'>$username for $vendorname already exist!"."</p><br>";
                 $duplicate_flag=1;
               return $duplicate_flag;
            }

            elseif (($email==$row['email'])  and ($vendorname==$row['vendorname']))
            {
               echo "<p align='center'>$email for $vendorname already exist!"."</p><br>";
                $duplicate_flag=1;
               return $duplicate_flag;
            }
            else
  $duplicate_flag=0;
  return $duplicate_flag;

       } 

}
}

function insert_bank_data($uid,$conn,$vendortype,$vendorname,$ifsc,$accounttype,$accountno,$username,$password,$email,$phoneno,$cardtype1,$cardtype2,$cardno,$cardexp,$cardpin,$cardcvv) {
    $success=0;
    $duplicate_flag=check_for_duplicate($uid,$conn,$vendortype,$vendorname,$cardno,$username,$email);
    if($duplicate_flag==0)
    {
    $add_data_query="INSERT INTO bank (`uid`,`vendorname`,`ifsc`,`accounttype`,`accountno`,`username`,`password`,`email`,`phoneno`,`cardtype1`,`cardtype2`,`cardno`,`cardexp`,`cardpin`,`cardcvv`) VALUES('$uid','$vendorname','$ifsc','$accounttype','$accountno','$username','$password','$email','$phoneno','$cardtype1','$cardtype2','$cardno','$cardexp','$cardpin','$cardcvv')";
    $result=mysqli_query($conn,$add_data_query);
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



function insert_general_data($uid,$conn,$vendorname,$vendortype,$username,$email,$phoneno,$password) {
    $success=0;
    $cardno=0;
    $duplicate_flag=check_for_duplicate($uid,$conn,$vendortype,$vendorname,$cardno,$username,$email);
    if($duplicate_flag==0)
    {
    $add_data_query="INSERT INTO general (`uid`,`vendorname`,`vendortype`,`username`,`email`,`phoneno`,`password`) VALUES('$uid','$vendorname','$vendortype','$username','$email','$phoneno','$password')";
    $result=mysqli_query($conn,$add_data_query);
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

  if ($_FILES['file']['type']!='application/vnd.ms-excel'){ //text file implementation
  //Getting and storing the temporary file name of the uploaded file
    $data = file($fileName,FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ;
    foreach ($data as $line) {
    $temp=( explode( ',', $line ) );
    $vendortype=$temp[0];
    if ($vendortype=='bank' or $vendortype=='Bank')
    {
    $vendorname=$temp[1];
    $ifsc=$temp[2];
    $accounttype=$temp[3];
    $accountno =$temp[4];
    $username =$temp[5];
    $password=encryptPassword($temp[6]);
    $email =$temp[7];
    $phoneno=$temp[8];
    $cardtype1=$temp[9];
    $cardtype2 =$temp[10];
    $cardno=$temp[11];
    $cardexp=$temp[12];
    $cardpin=encryptPassword($temp[13]);
    $cardcvv=encryptPassword($temp[14]);
    $success=insert_bank_data($uid,$conn,$vendortype,$vendorname,$ifsc,$accounttype,$accountno,$username,$password,$email,$phoneno,$cardtype1,$cardtype2,$cardno,$cardexp,$cardpin,$cardcvv);
    display_output($success);
}
else
{
    $vendorname=$temp[1];
    $email=$temp[2];
    $phoneno=$temp[3];
    $username =$temp[4];
    $password=encryptPassword($temp[5]);
    $success=insert_general_data($uid,$conn,$vendorname,$vendortype,$username,$email,$phoneno,$password);
    display_output($success);
  
 } }
}
//csv implementation 
else
{
   $csv_file = fopen($fileName, "r");
   while (($line = fgetcsv($csv_file, 10000, ",")) !== FALSE)
   {
    $vendortype=$line[0];
    if ($vendortype=='bank' or $vendortype=='Bank')
    {
    $vendorname=$line[1];
    $ifsc=$line[2];
    $accounttype=$line[3];
    $accountno =$line[4];
    $username =$line[5];
    $password=encryptPassword($line[6]);
    $email =$line[7];
    $phoneno=$line[8];
    $cardtype1=$line[9];
    $cardtype2 =$line[10];
    $cardno=$line[11];
    $cardexp=$line[12];
    $cardpin=encryptPassword($line[13]);
    $cardcvv=encryptPassword($line[14]);
    $success=insert_bank_data($uid,$conn,$vendortype,$vendorname,$ifsc,$accounttype,$accountno,$username,$password,$email,$phoneno,$cardtype1,$cardtype2,$cardno,$cardexp,$cardpin,$cardcvv);
    display_output($success);

}
else
{ 
    $vendorname=$line[1];
    $email=$line[2];
    $phoneno=$line[3];
    $username =$line[4];
    $password=encryptPassword($line[5]);
    $success=insert_general_data($uid,$conn,$vendorname,$vendortype,$username,$email,$phoneno,$password);
    display_output($success);
 }
  }
}
}

//end csv
}
?> 