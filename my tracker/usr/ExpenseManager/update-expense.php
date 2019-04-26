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
<title>Update Expense</title>

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<script>
  function display(){
    var x = document.getElementById("disp").value;
    console.log(x);
    if(x == "mon" ){
          document.getElementById("spent").style.display="block";
           document.getElementById("cdisp").style.display="block";
      }
      else{
        document.getElementById("spent").style.display="none";
         document.getElementById("cdisp").style.display="none";
      }
          
}


</script>
</head>
<body onload="display();" >    

  <div class="login-form">
    <br><br><br>
 <div class="btn-group" role="group" aria-label="...">
  <button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/ExpenseManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
<?php
// get value of id that sent from address bar
$id=$_GET['expense_id'];
$table=htmlentities(decryptPassword($_GET['temp']));
 
if (strpos($table, 'month') !== false) {
    $str="mon";
}
else{
      $str="date";
}

// Retrieve data from database 
$sql="SELECT * FROM $table WHERE (id = '$id' and uid='$uid')";
$result=mysqli_query($conn,$sql);
$rows=mysqli_fetch_array($result);
$item=$rows['item'];
if ($table=="monthlyexpense"){
$name="month";
$val=substr($rows[$name],0,7);
$type="month";
}
else{
$type="date";
$name="pdate";
$val=$rows[$name];
}
?>
<form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
   <h3 class="text-center"><bold>Update for <?php echo "'".$item."'"; ?></bold></h3><br>
   <p>Date/Month</p>
<div class="form-group"> <input type="<?php echo $type; ?>"  class ="form-control input-lg" name="udate" value="<?php echo $val; ?>">
</div>
   <p>Item</p>
   <div class="form-group"> <input  type="text"  class ="form-control input-lg" name="item" value="<?php echo $rows['item']; ?>"></div>
   <p>Value</p>
   <div class="form-group"> <input  type="number" class ="form-control input-lg" step="any" name="value" value="<?php echo $rows['value']; ?>"></div>
<input name="disp"  type="hidden" id="disp"  value="<?php echo $str; ?>"/>
   <p id="cdisp" style="display:none;">Spent Value</p>
   <div class="form-group"> <input  type="number"  class ="form-control input-lg" style="display:none;"  id="spent" name="spent" step="any" value="<?php echo $rows['spent']; ?>"></div>
     <p>Currency</p>
<div class="form-group">
                <select  class ="form-control input-lg" name="currency" disabled>
                  <option value="<?php echo $rows['type']; ?>"><?php echo $rows['currency'].'(Selected)'; ?></option>
                     <option value="dollar">Dollar</option>
                  <option value="inr">INR</option>
                </select> </div>
  <p>Mode of Payment</p>
   <div class="form-group"><select class="form-control input-lg" name="mode" placeholder="Mode" required>Mode
     <option value="<?php echo $rows['mode']; ?>"><?php echo $rows['mode'].'(Selected)'; ?></option>
                  <option value="Cash">Cash</option>
                  <option value="Credit-Card">Credit Card</option>
                  <option value="Debit-Card">Debit Card</option>
                  <option value="Others">Others</option>
                </select></td></div>
                <p>Category</p>
                <div class="form-group"><select class="form-control input-lg" name="category" placeholder="Category" required>
                   <option value="<?php echo $rows['category']; ?>"><?php echo $rows['category'].'(Selected)'; ?></option>
                    <option value="Rent">Rent</option>
                  <option value="Utilities">Utilities</option>
                  <option value="Internet">Internet</option>
                  <option value="Cafe">Cafe</option>
                  <option value="Restaurant">Restaurant</option>
                  <option value="Groceries">Groceries</option>
                   <option value="Recharge">Recharge</option>
                  <option value="Travel">Travel</option>
                  <option value="Others">Others</option>
                </select></td></div>
                <p>Description</p>
  <div class="form-group"><textarea name="comment"   class ="form-control input-lg" class="form-control input-lg"  rows=3 cols=3 maxlength=1000 ><?php echo $rows['comment']; ?> </textarea></div>
<input name="id" type="hidden" id="id" value="<?php echo $id; ?>"/>
<input name="type" type="hidden" id="type" value="<?php echo $type; ?>"/>
<input name="table" type="hidden" id="table" value="<?php echo $table; ?>"/>
<input name="name" type="hidden" id="name" value="<?php echo $name; ?>"/>
<div class="form-group clearfix"> <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit"  value="Update" /></div>
</form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 
   
<?php
if ( isset( $_POST['submit'] ) ){
  extract($_POST);
  if($type=="month"){
   $date=$udate."-00";
    $pmonth=$date;
  }
  else{
    $date=$udate;
     $pmonth=substr($udate,0,7).'-00';
    }

if($disp=="mon"){
$Query="UPDATE monthlyexpense SET item= '$item',value= '$value', spent='$spent',  currency= 'DOLLAR', $name= '$date', comment= '$comment', mode='$mode', category='$category' where (id='$id' and uid='$uid')" ;}
else{
$Query="UPDATE dailyexpense SET item= '$item',value= '$value',currency= 'DOLLAR', $name= '$date', comment= '$comment', mode='$mode', category='$category'  where (id='$id' and uid='$uid')" ;
}
$result=mysqli_query($conn,$Query) or 
die ("Error");

// if successfully updated. 
if($result){
  echo "<script type='text/javascript'>alert(\"Update successful!\")</script>";
 echo "<script type='text/javascript'>window.location.href = '/PV/usr/ExpenseManager/display-data.php';</script>";
echo "<BR>";

}

else {
echo "ERROR";echo "<script type='text/javascript'>alert(\"Error while updating!!\")</script>";
 echo "<script type='text/javascript'>window.location.href = '/PV/usr/ExpenseManager/dashboard.php';</script>";}
}
?>