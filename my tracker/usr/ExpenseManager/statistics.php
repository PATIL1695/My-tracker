<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
        $uid = $_SESSION['uid'];
    } 
include ($_SERVER['DOCUMENT_ROOT'].'/PV/session_expiry.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/database.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/function.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/encryption.php');
include ($_SERVER['DOCUMENT_ROOT'].'/PV/usr/user-authenticate.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Statistics</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<link rel="stylesheet" href="/PV/google/google.css">
<script>
  function display(){
    var item1 = document.getElementById('sel').value ;
    console.log(item1);
    if(item1 == "month" ){
        document.getElementById("smonth").style.display="block";
         document.getElementById("emonth").style.display="block";
        document.getElementById("sdate").style.display="none";
        document.getElementById("edate").style.display="none";
      }
      else if(item1=="date"){
       document.getElementById("sdate").style.display="block";
         document.getElementById("edate").style.display="block";
        document.getElementById("smonth").style.display="none";
        document.getElementById("emonth").style.display="none";
      }
            else {
               document.getElementById("smonth").style.display="none";
               document.getElementById("sdate").style.display="none";
               document.getElementById("edate").style.display="none";
               document.getElementById("sdate").style.display="none";
            }
}
function show_confirm()
    {
    var r=confirm("Selected item will be parmanently deleted!");
    if (r==true)
    {return true;
    }
    else
    {
    return false;
    }
    }
</script>
</head>
<body >
<div align="center" style= "width: 500px;" class="login-form"><br><br><br>
   <div  class="btn-group" role="group" aria-label="...">
    <button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/ExpenseManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
   <h3 align="center"><strong>Statistics</strong></h3>
<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">       
            <p>Please select the category</p>
       <div class="form-group"> <select class="form-control input-lg" onchange="display();" id="sel" name="sel" required>
            <option value="select" selected="select">--Select--</option>
            <option value="month">Month</option>
            <option value="date">Date</option>
            </select></div><p>Please select Start and End Range</p>
            <div class="container-name">
             <div style= "display: inline-block;" class="form-group">  <input type="month" name="smonth" id="smonth"  style="display:none;" default="2018-01" class="form-control name_list" min=2017-01 max=2020-12 /></div>
             <div   style= "display: inline-block;"class="form-group">  <input type="month" name="emonth" id="emonth"  style="display:none;" default="2018-01" class="form-control name_list" min=2017-01 max=2020-12  /></div></div>
             <div class="container-name"><div style= "display: inline-block;"class="form-group"> <input type="date" name="sdate"  id="sdate"  style="display:none;" default="2018-01-01" class="form-control name_list" min=2017-01-01 max=2020-12-31 /></div>
                <div style= "display: inline-block;" class="form-group"> <input type="date" name="edate"  id="edate"  style="display:none;" default="2018-01-01" class="form-control name_list" min=2017-01-01 max=2020-12-31 /></div></div>
        <div class="form-group clearfix"> <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Go"></div>
        </form>
</div>
</body>
 
</html> 

<?php
function getMonthSummary($uid,$conn,$smonth,$emonth)
{
  $sm=date('F', strtotime($smonth));
  $sy=date('Y', strtotime($smonth));
  $em=date('F', strtotime($emonth));
  $ey=date('Y', strtotime($emonth));

$start    = new DateTime($smonth);
$start->modify('first day of this month');
$end      = new DateTime($emonth);
$end->modify('first day of next month');
$interval = DateInterval::createFromDateString('1 month');
$period   = new DatePeriod($start, $interval, $end);
$i=1;
print "<p align='center'><strong><i>Summary of your expenses from ".$sm.", ".$sy." - ".$em.", ".$ey."</i></strong></p>";
echo '<div align="center" style= "width: 850px;" class="login-form">';
echo '<div  class="table table-responsive">';
echo '<table class="table table table-bordered">
<thead>
<tr>
<th scope="col">Sl. No.</th>
<th scope="col">Month(yyyy-mm)</th>
<th scope="col">Allocated Value(In $)</th>
<th scope="col">Money Spent(In $)</th>
<th scope="col">(Spent-Allocated)Difference(In $)</th>
<th scope="col">Dollar Value(In INR)</th>
<th scope="col">Allocated Value(In INR)</th>
<th scope="col">Money Spent(In INR)</th>
<th scope="col">(Spent-Allocated)Difference(In INR)</th>
</tr>
</thead>';
foreach ($period as $dt) {
  // echo $dt->format("Y-m")."\n";
  $allocated_sum=0;
  $actual_spent=0;
  $difference=0;
  $mon=(string)($dt->format("Y-m-00"));
  $dollar=getDollarValue($mon,$uid,$conn);
  if($dollar==null){
    $dollar_value ="$ value not set!";
  }
  else{
    $dollar_value=$dollar;
  }
  $query = mysqli_query($conn, "SELECT * FROM monthlyexpense WHERE (month='$mon' and uid='$uid')  ORDER BY month ASC");
  while($row = mysqli_fetch_array($query))
{
  $allocated_sum+=$row['value'];
  $actual_spent+=$row['spent'];
  $difference=$actual_spent-$allocated_sum;
}
  echo "<tbody>"; 
  echo "<tr>";
  echo "<td>" . $i . "</td>"; 
  echo "<td>" .substr($mon,0,7)."(".date('F', strtotime(substr($mon,0,7))).')'. "</td>";
  echo "<td>" . number_format((float)$allocated_sum, 2, '.', '') . "</td>";
  echo "<td>" . number_format((float)$actual_spent, 2, '.', '') . "</td>";
  echo "<td>" . number_format((float)$difference, 2, '.', '') . "</td>";
  echo "<td>" .number_format((float)$dollar_value, 2, '.', '') . "</td>";
  echo "<td>" . number_format((float)$allocated_sum * $dollar_value, 2, '.', ''). "</td>";
  echo "<td>" . number_format((float)$actual_spent  *$dollar_value, 2, '.', '')."</td>";
  echo "<td>" . number_format((float)$difference * $dollar_value, 2, '.', ''). "</td>";
  $i+=1;
  echo "</tr>";
$allocated_total+=$allocated_sum;
$actual_total+=$actual_spent;
}
echo "<p align='center'><strong><i>Total allocated money(In $) = ".$allocated_total."</i></strong></p><br>";
echo "<p align='center'><strong><i>Total spent money(In $) = ".$actual_total."</i></strong></p><br>";
}

function getDateSummary($uid,$conn,$sdate,$edate)
{
  $s=date("jS F, Y", strtotime($sdate));
  $e=date("jS F, Y", strtotime($edate));


echo '<div align="center" style= "width: 850px;" class="login-form">';
echo '<div  class="table table-responsive">';
echo '<table class="table table table-bordered">
<thead>
<tr>
<th scope="col">Sl. No.</th>
<th scope="col">Month(yyyy-mm)</th>
<th scope="col">Money Spent(In $)</th>
<th scope="col">Dollar Value(In INR)</th>
<th scope="col">Money Spent(In INR)</th>
</tr>
</thead>';
print "<p align='center'><strong><i>Summary of your expenses from ".$s." - ".$e."</i></strong></p>";
$i=1;
$query = mysqli_query($conn, "SELECT sum(value) AS 'sum',month(pdate)AS 'date', year(pdate) as year FROM dailyexpense WHERE (pdate>='$sdate' and pdate<='$edate' and uid='$uid') GROUP BY month(pdate) ORDER BY pdate ASC"); 
  while($row = mysqli_fetch_array($query))
  {
  echo "<tbody>"; 
  echo "<tr>";
  echo "<td>" . $i . "</td>"; 
  echo "<td>" . date("F", mktime(0, 0, 0,$row['date'], 10)).", ".$row['year'] . "</td>"; 
  $mon="2018-".$row['date']."-00";
  $dollar=getDollarValue($mon,$uid,$conn);
  if($dollar==null){
    $dollar_value ="$ value not set!";
  }
  else{
    $dollar_value=$dollar;
  }
  echo "<td>" . number_format((float)$row['sum'], 2, '.', '') . "</td>";
    echo "<td>" .number_format((float)$dollar_value, 2, '.', ''). "</td>";
  echo "<td>" . number_format((float)$row['sum']*$dollar_value, 2, '.', '') . "</td>";
  $i+=1;
  echo "</tr>";
$total+=$row['sum'];
}
echo "<p align='center'><strong><i>Total money spent(In $) = ".$total."</i></strong></p><br>";
}





if ( isset( $_POST['submit'] ) ){
    extract($_POST); 

if(($emonth<$smonth)OR($edate<$sdate)){
  echo "<script type='text/javascript'>alert(\"End date/month cannot be less than start date/month!\")</script>";
  echo "<script type='text/javascript'>window.location.href = '/PV/usr/ExpenseManager/statistics.php';</script>";
}
else{
    if ($sel=="month"){
      $table="monthlyexpense";
      $col="month";
      $start=$smonth.'-00';
      $end=$emonth.'-00';

      //Calculations for month
       $monthQuery = mysqli_query($conn, "SELECT * FROM $table WHERE (($col>='$start' and $col<='$end')  and uid='$uid') ORDER BY $col ASC");
  $count = mysqli_num_rows($monthQuery);
  if($count==0)
  {
    echo"<p align='center'><strong>Looks like there is no statistics available for the range selected.</p></strong>";
  }
  else{
     $i=1;
echo "<h3 align='center'><strong>Statistics</strong></h3>";
echo "<p align='center'><strong><i>You have ".$count." expense records matching your selection!</i></strong></p>";
echo '<div align="center" style= "width: 850px;" class="login-form">';
echo '<div  class="table table-responsive">';
echo '<table class="table table table-bordered">
<thead>
<tr>
<th scope="col">Sl. No.</th>
<th scope="col">Date/Month(yyyy-mm-dd)</th>
<th scope="col">Item</th>
<th scope="col">Allocated Value(In $)</th>
<th scope="col">Spent(In $)</th>
<th scope="col">Description</th>
<th scope="col">Currency</th>
<th scope="col">Mode of Payment</th>
<th scope="col">Category</th>
<th scope="col">Action</th>
</tr>
</thead>';
while($row = mysqli_fetch_array($monthQuery))
{
echo "<tbody>"; 
echo "<tr>";
echo "<td>" . $i . "</td>"; 
echo "<td>" . $row[$col] . "</td>";
echo "<td>" . $row['item'] . "</td>";
echo "<td>" . $row['value'] . "</td>";
echo "<td>" . $row['spent']."</td>";
echo "<td>" . $row['comment'] . "</td>";
echo "<td>" . $row['currency'] . "</td>";
echo "<td>" . $row['mode'] . "</td>";
echo "<td>" . $row['category'] . "</td>";
echo "<td align='center'>".'<a style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;" href=update-expense.php?temp='.urlencode(encryptPassword($table)).'&expense_id='.$row['id'].'>Update</a>'.' <i><strong> OR </i></strong> '.'<a onClick="return show_confirm();" style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;" href=delete-specific-expense.php?temp='.urlencode(encryptPassword($table)).'&expense_id='.$row['id'].'>Delete</a>'.'</td>';

$i+=1;
echo "</tr>";
}
echo "</tbody>";
echo "</table>";
echo "</div>";
echo '</div>';
getMonthSummary($uid,$conn,$smonth,$emonth);
echo '<p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>';
}
    }
    elseif ($sel=="date") {
        $table="dailyexpense";
        $start=$sdate;
        $end=$edate;
        $col="pdate";
        $s=date("jS F, Y", strtotime($start));
        $e=date("jS F, Y", strtotime($end));
        $sm=substr($sdate,0,7).'-00';
        $em=substr($edate,0,7).'-00';
        //Calculations for date
         $dateQuery = mysqli_query($conn, "SELECT * FROM $table WHERE (($col>='$start' and $col<='$end')  and uid='$uid') ORDER BY $col ASC");
  $count = mysqli_num_rows($dateQuery);
  if($count==0)
  {
    echo"<p align='center'><strong>Looks like there is no statistics available for the range selected.</p></strong>";
  }
  else{
     $i=1;
echo "<h3 align='center'><strong>Statistics</strong></h3>";
echo "<p align='center'><strong><i>You have ".$count." expense records matching your selection!</i></strong></p>";
echo '<div align="center" style= "width: 900px;" class="login-form">';
echo '<div  class="table table-responsive">';
echo '<table class="table table table-bordered">
<thead>
<tr>
<th scope="col">Sl. No.</th>
<th scope="col">Date(yyyy-mm-dd)</th>
<th scope="col">Item</th>
<th scope="col">Value(In $)</th>
<th scope="col">Description</th>
<th scope="col">Currency</th>
<th scope="col">Mode of Payment</th>
<th scope="col">Category</th>
<th scope="col">Action</th>
</tr>
</thead>';
while($row = mysqli_fetch_array($dateQuery))
{
echo "<tbody>"; 
echo "<tr>";
echo "<td>" . $i . "</td>"; 
echo "<td>" . $row[$col] . "</td>";
echo "<td>" . $row['item'] . "</td>";
echo "<td>" . $row['value'] . "</td>";
echo "<td>" . $row['comment'] . "</td>";
echo "<td>" . $row['currency'] . "</td>";
echo "<td>" . $row['mode'] . "</td>";
echo "<td>" . $row['category'] . "</td>";
echo "<td align='center'>".'<a style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;" href=update-expense.php?temp='.urlencode(encryptPassword($table)).'&expense_id='.$row['id'].'>Update</a>'.' <i><strong> OR </i></strong> '.'<a onClick="return show_confirm();" style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;" href=delete-specific-expense.php?temp='.urlencode(encryptPassword($table)).'&expense_id='.$row['id'].'>Delete</a>'.'</td>';
$dsum+=$row['value'];
$i+=1;
echo "</tr>";
}
getDateSummary($uid,$conn,$sdate,$edate);
echo "</tbody>";
echo "</table>";
echo "</div>";
echo '</div>';
echo '<p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>';
}
    }
    else{
        $table=null;
    }
 
}
}
?>

