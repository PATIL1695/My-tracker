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
<title>View expense</title>
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
<div class="login-form"><br><br><br>
   <div  class="btn-group" role="group" aria-label="...">
    <button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
  <button type="button" onclick="window.location.href='/PV/usr/ExpenseManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
</div><br><br>
   <h3 align="center"><strong>View expense by</strong></h3>
<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">       
            <p>Please select the category</p>
            <div class="form-group"> <select class="form-control input-lg" onchange="display();" id="sel" name="sel" required>
            <option value="select" selected="select">--Select--</option>
            <option value="month">Month</option>
            <option value="date">Date</option>
            </select></div>
             <div class="form-group">  <input type="month" name="month" id="month"  style="display:none;" default="2018-01" class="form-control name_list" min=2017-01 max=2020-12  /></div>
           <div class="form-group"> <input type="date" name="pdate"  id="pdate"  style="display:none;" default="2018-01-01" class="form-control name_list" min=2017-01-01 max=2020-12-31 /></div>
        <div class="form-group clearfix"> <input type="submit" class="btn btn-primary btn-lg pull-right" name="view" value="View"></div>
        </form>
</div>
</body>
 
</html> 

<?php
 if ( isset( $_POST['view'] ) ){
    extract($_POST); 
    if ($sel=="month"){
      $table="monthlyexpense";
      $col="month";
      $cri=$month.'-00';
       $month=date('F', strtotime($month));
       $year=date('Y', strtotime($month));
    }
    elseif ($sel=="date") {
        $table="dailyexpense";
        $col="pdate";
        $cri=$pdate;
       $day= date('l', strtotime($pdate));
       $date= date('d', strtotime($pdate));
       $month=date('F', strtotime($pdate));
       $year=date('Y', strtotime($pdate));
    }
    elseif ($sel=="year") {
        $table="";
        $col="";
        $cri=null;
    }
    else{
        $table=null;
    }
  $view_query = mysqli_query($conn, "SELECT * FROM $table WHERE ($col='$cri' and uid='$uid') ORDER BY $col ASC ");
  $count = mysqli_num_rows($view_query);
  if($count==0)
  {
    echo"<p align='center'><strong>Looks like there is no expense for the selection made.</p></strong>";
  }
  else{
     $i=1;
    echo "<p align='center'><strong><i>You have ".$count." expenses matching your selection!</i></strong></p>";
echo '<div align="center" style= "width: 850px;" class="login-form">';
echo '<div  class="table table-responsive">';
echo '<table class="table table table-bordered">
<thead>
<tr>
<th scope="col">Sl. No.</th>
<th scope="col">Date/Month(yyyy-mm-dd)</th>
<th scope="col">Item</th>';
if ($col=="month"){
echo '<th scope="col">Allocated Value(In $)</th>
<th scope="col">Spent(In $)</th>';
}
else{
echo '<th scope="col">Value(In $)</th>';
}
echo '<th scope="col">Description</th>
<th scope="col">Currency</th>
<th scope="col">Mode of Payment</th>
<th scope="col">Category</th>
<th scope="col">Action</th>
</tr>
</thead>';
while($row = mysqli_fetch_array($view_query))
{
echo "<tbody>"; 
echo "<tr>";
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
echo "<td align='center'>".'<a style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;" href=update-expense.php?temp='.urlencode(encryptPassword($table)).'&expense_id='.$row['id'].'>Update</a>'.' <i><strong> OR </i></strong> '.'<a onClick="return show_confirm();" style="background:#F52126; color:#fff; border:none; font-size:12px; padding:4px 8px;" href=delete-specific-expense.php?temp='.urlencode(encryptPassword($table)).'&expense_id='.$row['id'].'>Delete</a>'.'</td>';
$dsum+=$row['value'];
$i+=1;
echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</div>";
mysqli_close($conn);

if ($sel=="month"){
echo "<p><strong><i>Total expenses for ".$month.", ".$year." = ".$dsum." (In $)"."</i></strong></p>";
}
else{
echo "<p><strong><i>Total expenses for ".$day.", ".$date." -".$month.", ".$year." = ".$dsum." (In $)"."</i></strong></p>";
}
echo '</div>';
echo '<p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>';
}
}
?>


