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
<title>Expense Manager Home</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
       
</head>
<body ><br><br><br>
<div class="login-form">
  <button type="button" onclick="window.location.href='/PV/dashboard.php'" class="btn btn-default">Main Menu</button>
    <button type="button" onclick="window.location.href='/PV/usr/ExpenseManager/dashboard.php'" class="btn btn-default">Home</button>
   <button type="button" onclick="window.location.href='/PV/logout.php'" class="btn btn-default">LogOut</button>
        </button></p>

  <?php
echo "<h4 align='center'>Welcome ".strtoupper($_SESSION['username'])."</h4>"; 
echo "<h5 align='center'><i>"."This is your ExpenseManager Home Page"."</i></h5><br><br>";
 ?>
        <div class="form-group"><font size="4"><ul align="center" class="list-group" >

  <li class="list-group-item"> <a href="/PV/usr/ExpenseManager/add-expense.php">Add Expenses</a></li>
  <li class="list-group-item"> <a href="/PV/usr/ExpenseManager/view-expense.php">View Expenses</a></li>
  <li class="list-group-item">  <a href="/PV/usr/ExpenseManager/display-data.php">Update Expenses</a></li>
  <li class="list-group-item"> <a href="/PV/usr/ExpenseManager/search.php">Search Expenses</a></li>
      <li class="list-group-item"> <a href="/PV/usr/ExpenseManager/delete-expense.php">Delete Expenses</a></li>
       <li class="list-group-item"> <a href="/PV/usr/ExpenseManager/import-budget.php">Import Expenses</a></li>
         <li class="list-group-item"> <a href="/PV/usr/ExpenseManager/dollar.php">Dollar Value</a></li>
                <li class="list-group-item"> <a href="/PV/usr/ExpenseManager/statistics.php">Statistics</a></li>
</ul></font></div>
</body>
   <br><br><p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html> 
