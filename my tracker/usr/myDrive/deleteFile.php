<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
    }
include ($_SERVER['DOCUMENT_ROOT'].'/PV/session_expiry.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/usr/user-authenticate.php'); 
$path=$_SERVER['DOCUMENT_ROOT'].'/PV/usrDrive/'.md5($uid).'/';
    /* AJAX check  */
 if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    //Check for passed dir exist 
    $folder = $_GET['Dirs'];

    if(!file_exists($folder)) {
      exit('Folder Not Found');
    }

    $out = '';

    $files = array_filter(glob($folder.'/*'), 'is_file');
      foreach($files as $val){
          $out .= '<option value="'.$val.'">'.basename($val)."</option>\n";
      }
    //Output the file options
    exit($out);

 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Delete your files</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<script>
$(function(){ 
   $("#folderName").on('change', function(){
        var item=$('#folderName').val();
        var Dir="<?php echo $path; ?>"+item;
      //Make an ajax call 
      $( "#files" ).html( '<option>Loading...</option>' );
      $.get( "downloadFile.php?Dirs=" + encodeURIComponent(Dir), function( data ) {
        //Update the files dropdown 
        $( "#files" ).html( data ); 
      });
   });
});

</script>
</script>
</head>
<body >    

  <div class="login-form">
    <br><br><br>
 <div class="btn-group" role="group" aria-label="...">
  <button type="button" onclick="window.location.href='/PV/user-home.php'" class="btn btn-default">Main Menu</button>
 <button type="button" onclick="window.location.href='/PV/usr/myDrive/dashboard.php'" class="btn btn-default">Drive Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
 
 <form class="login-form"  action="<?php echo $_SERVER['PHP_SELF']; ?>"  enctype="multipart/form-data" method="post">
     <h3 class="text-center">Select which file you like to delete </h3><br>
        
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
              <div class="form-group">  <label>Please select a file you wish to delete.</label> <select class="form-control" id="files" name="mFiles" required>
                </select></div>
 <div class="form-group clearfix">  <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Delete file">
          </div>
<?php
if(isset( $_POST['submit'])) {
    extract($_POST);
$file_len=strlen($path)+strlen($folderName);
$fileName=substr($mFiles,$file_len+1);
$filepath=$path.$folderName.'/'.$fileName;
if(unlink($filepath)){
echo "<script type='text/javascript'>alert(\"File ".$fileName." deleted!\")</script>";
        }
        else{
echo "<script type='text/javascript'>alert(\"File ".$fileName." could not be deleted!\")</script>";
        }
} 
?>
</form>
</div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p><br><br>
</html>  
