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



function combine_keys_with_arrays($keys, $arrays) {
    $results = array();

    foreach ($arrays as $subKey => $arr)
    {
       foreach ($keys as $index => $key)
       {
           $results[$key][$subKey] = $arr[$index];    
       }
    }

    return $results;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Add Expense</title>

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<script>
  function display(){
    var item1 = document.getElementById('sel').value ;
    console.log(item1);
    if(item1 == "month" ){
        document.getElementById("month").style.display="block";
        document.getElementById("pdate").style.display="none";
        document.getElementById("year").style.display="none";
      }
      else if(item1=="date"){
        document.getElementById("pdate").style.display="block";
        document.getElementById("month").style.display="none";
        document.getElementById("year").style.display="none";
      }
            else {
               document.getElementById("month").style.display="none";
               document.getElementById("pdate").style.display="none";
               document.getElementById("year").style.display="block";
            }
}


$(document).ready(function(){
  var i=1;
  $('#add').click(function(){
    i++;
    $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="item[]" placeholder="Item" class="form-control name_list" required/></td><td><input type="number" name="value[]" required placeholder="0.00" step="any" class="form-control name_list" /></td> <td width="27%"><select class="form-control input-lg" name="mode[]" required><option selected="Cash">Cash</option><option value="Credit-Card">Credit Card</option><option value="Debit-Card">Debit Card</option><option value="Others">Others</option></select></td><td width="27%"><select class="form-control input-lg" name="category[]" required><option value="Rent">Rent</option> <option value="Utilities">Utilities</option><option value="Groceries">Groceries</option><option value="Internet">Internet</option><option value="Cafe">Cafe</option><option value="Restaurant">Restaurant</option><option value="Recharge">Recharge</option> <option value="Recharge">Travel</option><option value="Others">Others</option></select></td><td width="30%"><textarea id="comment" name="comment[]" class="form-control input-lg" placeholder="Notes"  rows=2 cols=2 maxlength=500 ></textarea><td><br><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
  });
  
  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
  });
  
  $('#submit').click(function(){    
    $.ajax({
      url:"name.php",
      method:"POST",
      data:$('#add_name').serialize(),
      success:function(data)
      {
        alert(data);
        $('#add_name')[0].reset();
      }
    });
  });
  
});
</script>
</head>
<body >    

  <div align="center" align="center" style= "width: 900px;" class="login-form">
    <br><br><br>
 <div  align="center" class="btn-group" role="group" aria-label="...">
<button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/ExpenseManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
  
 <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">  
              <h4><strong>Add Expense</strong></h4>   
            <p>Please select the category</p>
            <div class="form-group"> <select class="form-control input-lg" onchange="display();" id="sel" name="sel" required>
            <option value="select">--Select--</option>
            <option value="month">Month</option>
            <option value="date">Date</option>
            </select></div>
             <div class="form-group"> <input  type="month" name="month" id="month"  style="display:none;" default="2018-01" class="form-control name_list" min=2017-01 max=2020-12  /></div>
           <div class="form-group"> <input type="date" name="pdate"  id="pdate"  style="display:none;" default="2018-01-01" class="form-control name_list" min=2017-01-01 max=2020-12-31 /></div>
 <div class="form-group"><p>Currency</p>
<select name="currency" id="currency" class="form-control input-lg" disabled>
        <option value="dollar" selected="dollar">Dollar</option>
        <option value="rs">INR</option>
     </select></div>
          <div class="table-responsive">
            <table class="table table-bordered" id="dynamic_field">
              <h3>Expense List</h3>
              <tr>
                <td width="27%"><input type="text" name="item[]" placeholder="Item" class="form-control name_list" required /></td>
                <td width="20%"><input type="number" name="value[]" placeholder="0.00" step="any" class="form-control name_list" required /></td>
                 <td width="27%"><select class="form-control input-lg" name="mode[]" placeholder="Mode" required>Mode
                  <option selected="Cash">Cash</option>
                  <option value="Credit-Card">Credit Card</option>
                  <option value="Debit-Card">Debit Card</option>
                  <option value="Others">Others</option>
                </select></td>
                <td width="27%"><select class="form-control input-lg" name="category[]" placeholder="Category" required>
                  <option value="Rent">Rent</option>
                  <option value="Utilities">Utilities</option>
                  <option value="Internet">Internet</option>
                  <option value="Cafe">Cafe</option>
                  <option value="Restaurant">Restaurant</option>
                  <option value="Groceries">Groceries</option>
                  <option value="Recharge">Recharge</option>
                  <option value="Recharge">Travel</option>
                  <option value="Others">Others</option>
                </select></td>
                  <td><textarea id="comment" name="comment[]" class="form-control input-lg" placeholder="Notes"  rows=2 cols=2 maxlength=500 ></textarea></
                <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
              </tr>
            </table>
          </div>
          <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Add Expense"><br><br>
       </form></div>
</body>
   <p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 

<?php
if ( isset( $_POST['submit'] ) ){
extract($_POST); 
if ($sel=="month"){
      $table="monthlyexpense";
      $col="month";
     $cri=$month."-00";
      $pmonth=$cri;
    }
    elseif ($sel=="date") {
        $table="dailyexpense";
        $col="pdate";
        $cri=$pdate;
        $pmonth=substr($pdate,0,7).'-00';
    }
    elseif ($sel=="year") {
        $table="dailyexpense";
        $col="pdate";
      }
    else{
        $table=null;
    }
$currency=strtoupper($currency);
$count=count($item);
$count2=count($value);
if ($pdate=="0000-00-00" or $count<0 or $count2<0)
{
  echo "<script type='text/javascript'>alert(\"Please enter correct values!!\")</script>";
}
else{
$index=range(1,$count);
$res=combine_keys_with_arrays($index, array('item'=> $item,'value' => $value,'desc'=> $comment,'mode'=>$mode,'category'=>$category));
foreach ($res as $key) {
  $item=strtoupper($key['item']);
  $value=$key['value'];
  $desc=addslashes($key['desc']);
  $mode=$key['mode'];
  $category=$key['category'];
  $check_job_query="SELECT * from $table where ((item='$item') and ($col='$cri') and  (uid='$uid'));";

      $res=mysqli_query($conn,$check_job_query);
      if (mysqli_num_rows($res) > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($res);
        $str2=strtoupper($row['item']);
        $str3=$row[$col]; 
        if (($item==$str2)  and ($cri==$str3))
            {
                echo "<script type='text/javascript'>alert(\"This item already exists!!\")</script>";
                break;
       } 
     }
else{
$insert_exp = "INSERT INTO $table (`uid`,$col,`item`,`value`,`currency`,`mode`,`category`,`comment`) VALUES('$uid','$cri','$item','$value','DOLLAR','$mode','$category','$desc')";
$exp_result = mysqli_query($conn, $insert_exp) or die(mysqli_error($conn));
} 
if ($sel=="month"){
  $month=date('F', strtotime($month));
  $year=date('Y', strtotime($month));
 echo "<script type='text/javascript'>alert(\"".$month.", ".$year." expense added successfully!!\")</script>";
}
else{
   echo "<script type='text/javascript'>alert(\"".date("jS F, Y", strtotime($cri))." expense added successfully!!\")</script>";
}
}
}
}
?>
