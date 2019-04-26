<?php
function validateFilename($folderName){
  if (preg_match("/^[a-zA-Z\d\.]{3,15}$/", $folderName))
  {
    return 1;
  }
  else
  {
    return 0;
  }
}

function filenameExists($folderName,$path){
  if (file_exists($path)) {
    return 0 ;
  }
  else{
    return 1;
  }
}

function createFolder($path){
  mkdir($path, 0777, true);
}

function checkFilesize($actual_size,$max_size)
{
  if ($actual_size>$max_size)
  {
    return 1;
  }
else 
{
  return 0;
}
}

function rmdir_recursive($dir) {
    $it = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
    $it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
    foreach($it as $file) {
        if ($file->isDir()) rmdir($file->getPathname());
        else unlink($file->getPathname());
    }
    rmdir($dir);
}


function getDollarValue($month,$uid,$conn)
{
 
  $getDollarQuery=mysqli_query($conn, "SELECT * FROM dollar WHERE (month='$month' and uid='$uid')");
  $row = mysqli_fetch_array($getDollarQuery);
  $dollar_value=$row['dollar'];
if ($dollar_value==0 or $dollar_value==null){
  return null;
}
  else
  {
  return $dollar_value;
}
}


function timeZoneConvert($fromTime, $fromTimezone, $toTimezone,$format = 'Y-m-d h:i:s a') {
     // create timeZone object , with fromtimeZone
    $from = new DateTimeZone($fromTimezone);
     // create timeZone object , with totimeZone
    $to = new DateTimeZone($toTimezone);
    // read give time into ,fromtimeZone
    $orgTime = new DateTime($fromTime, $from);
    // fromte input date to ISO 8601 date (added in PHP 5). the create new date time object
    $toTime = new DateTime($orgTime->format("c"));
    // set target time zone to $toTme ojbect.
    $toTime->setTimezone($to);
    // return reuslt.
    return $toTime->format($format);
  }
?>