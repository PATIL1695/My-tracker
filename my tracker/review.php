<?php
include ($_SERVER['DOCUMENT_ROOT'].'/PV/encryption.php');
$uid=htmlentities(decryptPassword($_GET['logoffUserAttributeTemp']));
if($uid==null)
{
    echo "<script type='text/javascript'>alert(\"Unauthorized Access!\")</script>";
    echo "Redirecting to homepage...";
    echo "<script type='text/javascript'>window.location.href = '/PV/index.html';</script>";
}
else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Review Page</title>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="/PV/css/style.css">
<link rel="stylesheet" href="/PV/css/review.css">
<script>
function displayifOther(){
    var item1 = document.getElementById('reason').value ;
    if(item1 != "Other" )
        document.getElementById("comment").style.display="block";
      else 
        document.getElementById("comment").style.display="none";
}
</script>
</head>
<body>
   
<div class="login-form">
  <form class="login-form" action="/PV/register-feedback.php" method="post">
    <div class="form-group">
            <p>You are now logged-out.</p>
           <strong><p>Thank you for using the Application.</p></strong> <hr>
      <p>Please rate your experience on the scale of 1 to 5.</p>
<fieldset class="rating"  >
    <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars" ></label>
    
    <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
    
    <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
    
    <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
    <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Pathetic - 1 stars"></label>
    
</fieldset></div><br><br>
            <p>Please tell us what went wrong.</p>
             <input type="hidden" name="uid" value='<?php echo htmlspecialchars($uid);?>' >
             <fieldset class="reason" id="reason" onchange="displayifOther();" >
            <input type="radio" name="reason" value="Login or password issue"> Login or Register or Password issue.<br>
            <input type="radio" name="reason" value="Problem while adding jobs"> Problem while adding jobs.<br>
            <input type="radio" name="reason" value="Problem while updating jobs"> Problem while updating jobs.<br>
            <input type="radio" name="reason" value="Problem while viewing jobs"> Problem while viewing jobs.<br> 
            <input type="radio" name="reason" value="Problem while deleting jobs"> Problem while deleting job.<br>
            <input type="radio" name="reason" value="Problem while uploading files"> Problem while uploading files.<br>
            <input type="radio" name="reason" value="Problem while downloading files"> Problem while downloading files.<br> 
            <input type="radio" name="reason" value=" The site was slow or unresponsive"> The site was slow or unresponsive.<br>
              <input type="radio" name="reason" value="Other"> Other problem.<br><hr>
                     <div class="form-group"> <textarea id="comment" name="comment" class="form-control input-lg" placeholder="Please specify the problem(500 characters).."  rows=5 cols=5 maxlength=500 ></textarea><br></div>
              </fieldset>
          
            <div class="form-group clearfix"><input type="submit" class="btn btn-primary btn-lg pull-left" name="submit" value="Submit Feedback"></div>
  </form>     
</body>
<p class="m-0 text-center text-white">© Copyright 2018 PV Group</p>
</html>
<?php } ?>