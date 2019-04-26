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
<title>Delete expense</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<link rel="stylesheet" href="/PV/google/google.css">
<script>
function show_confirm()
    {
    var r=confirm("Selected items will be parmanently deleted!");
    if (r==true)
    {return true;
    }
    else
    {
    return false;
    }
    }

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
</script>
</head>
<body >
<div align="center" style= "width: 500px;" class="login-form" ><br><br><br>
   <div  class="btn-group" role="group" aria-label="...">
    <button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/ExpenseManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
   <h3 align="center"><strong>Delete expense by</strong></h3>
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
        <div class="form-group clearfix"> <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Submit"></div>
        </form>
      </div>
</body>
 
</html> 

}
<?php
 if ( isset( $_POST['submit'] ) ){
    extract($_POST); 
    if ($sel=="month"){
      $table="monthlyexpense";
      $col="month";
      $start=$smonth.'-00';
      $end=$emonth.'-00';

    }
    elseif ($sel=="date") {
        $table="dailyexpense";
        $col="pdate";
        $cri=$pdate;
        $start=$sdate.'-00';
        $end=$edate.'-00';
    }
    elseif ($sel=="year") {
        $table="dailyexpense";
        $col="pdate";
        $cri=$pdate;
    }
    else{
        $table=null;
    }
 
  $view_query = mysqli_query($conn, "SELECT * FROM $table WHERE (($col>='$start' and $col<='$end') and uid='$uid')  ORDER BY $col ASC");
  $count = mysqli_num_rows($view_query);

  if($count==0)
  {
    echo"<p align='center'><strong>Looks like there is no expense for the selection made.</p></strong>";
  }
  else{
     $i=1;
    echo "<p align='center'><strong><i>You have ".$count." expenses matching your selection!</i></strong></p>";
echo '<form align="center" style= "width: 850px;"method="post" class="login-form" id="form1" action="delete-expense.php">';
echo '<div  class="table table-responsive">';
echo '<table class="table table table-bordered">
<thead>
<tr>
<th scope="col"></th>
<th scope="col">Sl. No.</th>
<th scope="col">Date/Month(yyyy-mm-dd)</th>
<th scope="col">Item</th>';
if ($col=="month"){
echo '<th scope="col">Allocated Value(In $)</th>
<th scope="col">Spent(In $)</th>';}
else{
echo '<th scope="col">Value(In $)</th>';
}
echo '<th scope="col">Description</th>
<th scope="col">Currency</th>
<th scope="col">Mode of Payment</th>
<th scope="col">Category</th>
</tr>
</thead>';
while($row = mysqli_fetch_array($view_query))
{
echo "<tbody>"; 
echo "<tr>";
echo '<td>';
echo '<input type="checkbox" name="delete_id[]" value='.$row['id'].'>'."</td>";
echo "<td>" . $i . "</td>"; 
echo "<td>" . $row[$col] . "</td>";
echo "<td>" . $row['item'] . "</td>";
if ($col=="month"){
echo "<td>" . $row['value'] . "</td>";
echo "<td>" . $row['spent'] . "</td>";
}
else{
echo "<td>" . $row['value'] . "</td>";
}
echo "<td>" . $row['comment'] . "</td>";
echo "<td>" . $row['currency'] . "</td>";
echo "<td>" . $row['mode'] . "</td>";
echo "<td>" . $row['category'] . "</td>";
$dsum+=$row['value'];
$i+=1;
echo "</tr>";
$curr=$row['currency'];
}

echo "</tbody>";
echo "</table>";
echo "</div>";

echo '<input name="table" type="hidden" id="table" value="'.$table.'"/>';
echo '<input name="name" type="hidden" id="name" value="'.$name.'"/>';
echo '<div style="margin-top:20px;">
         <div style=" float:left;">
           <input name="delete" type="submit" id="delete" value="Delete" onClick="return show_confirm();" style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;">
           &nbsp;
         </div>
         <div style="clear:both;"></div>
    </div>    
</form>'; 
mysqli_close($conn);
if ($sel=="month"){
  $sm=date('F', strtotime($smonth));
  $sy=date('Y', strtotime($smonth));
  $em=date('F', strtotime($emonth));
  $ey=date('Y', strtotime($emonth));
print "<p align='center'><strong><i>Total expenses from ".$sm.", ".$sy." - ".$em.", ".$ey." = ".$dsum."</i></strong></p>";}
else{
  $s=date("jS F, Y", strtotime($sdate));
  $e=date("jS F, Y", strtotime($edate));
echo "<p align='center'><strong><i>Total expenses for ".$s." - ".$e." = ".$dsum." (In $)"."</i></strong></p>";
}
echo '</div>';
echo '<p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>';
}
}
?>
<!-- Delete Item code -->
<?php
if ( isset( $_POST['delete'] ) ){
  extract($_POST);
$delete_id = $_POST['delete_id'];
if($delete_id==null)
{
echo "<script type='text/javascript'>alert(\"Nothing selected to delete!\")</script>";
}
else
{
$delete_count = count($delete_id);
 // echo "<script type='text/javascript'>alert(\"File name with ".$uid." already exists!\")</script>";
for($i=0;$i<$delete_count;$i++)
{
   $deleting_id = $delete_id[$i];
   if($delete_query1= mysqli_query($conn,"Delete from $table where id='$deleting_id' and uid='$uid'"))
   {
   echo "<script type='text/javascript'>alert(\"Expense deleted successful!\")</script>";
   // echo "<script type='text/javascript'>window.location.href = '/PV/usr/ExpenseManager/delete-expense.php';</script>";
 }
   else{
   echo "<script type='text/javascript'>alert(\"Expense delete was unsuccessful!\")</script>";
   echo "<script type='text/javascript'>window.location.href = '/PV/usr/ExpenseManager/delete-expense.php';</script>";}
   }
mysqli_close($conn);
}
}

?>