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
<title>Create folder</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<script>
$(function(){ 
   $("#type").on('change', function(){
     if ($('#type').val()=="resume"){

        var Dir="/home4/prajwalv/public_html/PV/admin/Uploaded_Resume/";
      }
      else{
       var Dir="/home4/prajwalv/public_html/PV/admin/Uploaded_CoverLetter/";
      }
      //Make an ajax call 
      $( "#files" ).html( '<option>Loading...</option>' );
      $.get( "select-file-for-download.php?Dirs=" + encodeURIComponent(Dir), function( data ) {
        //Update the files dropdown 
        $( "#files" ).html( data ); 
      });
   });
});

</script>
</head>
<body >    

  <div class="login-form">
    <br><br><br>
 <div class="btn-group" role="group" aria-label="...">
<button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
    <button type="button" onclick="window.location.href='/PV/usr/myDrive/dashboard.php'" class="btn btn-default">Drive Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
        </button>
</div><br><br>
 
 <form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="post">
     <h3 class="text-center">Create Folder</h3><br>
           <p><i>Please enter the name of the folder to be created.
            Filename contains only letters and digits (3-8 char).Symbols are not accepted.<i></p>
 <div class="form-group"><input type="text" class="form-control input-lg" name="folderName" placeholder="Folder Name" pattern="[a-zA-Z\d\.]{3,15}"  title="Must contain  (3-15) characters. Only use alphabets and digits." required></div>

 <div class="form-group clearfix">  <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Create Folder">
          </div></form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p><br><br>
</html>   

<?php
if(isset( $_POST['submit'])) {
  extract($_POST); 
  $path=$_SERVER['DOCUMENT_ROOT'].'/PV/usrDrive/'.md5($uid).'/'.$folderName.'/';
$status1=validateFilename($folderName);
if ($status1==1){
  $status2=filenameExists($folderName,$path);
  if($status2==1){
    createFolder($path);
     echo "<script type='text/javascript'>alert(\"Folder name with ".$folderName." created successfully!\")</script>";
      exit();
  }
  else{
    echo "<script type='text/javascript'>alert(\"Folder name with ".$folderName." already exists!\")</script>";
    exit();
  }
}
else{
  echo "<script type='text/javascript'>alert(\"Invalid folder name!\")</script>";
  exit();
}
}
?>




