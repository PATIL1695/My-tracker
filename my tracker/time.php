<?php
  #http://www.php.net/manual/en/timezones.php List of Time Zones
  function showclienttime()
  {
    if(!isset($_COOKIE['GMT_bias']))
    {
?>
 <script type="text/javascript">
 var Cookies = {};
 Cookies.create = function (name, value, days) {
 if (days) {
 var date = new Date();
 date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
 var expires = "; expires=" + date.toGMTString();
 } else {
 var expires = "";
 }
 document.cookie = name + "=" + value + expires + "; path=/";
 this[name] = value;
 }
 var now = new Date();
 Cookies.create("GMT_bias",now.getTimezoneOffset(),1);
 //window.location = "<?php echo $_SERVER['PHP_SELF'];?>";
 </script>
 <?php
 } else {
 $fct_clientbias = $_COOKIE['GMT_bias'];
 }
 $fct_servertimedata = gettimeofday();
 $fct_servertime = $fct_servertimedata['sec'];
 $fct_serverbias = $fct_servertimedata['minuteswest'];
 $fct_totalbias = $fct_serverbias - $fct_clientbias;
 $fct_totalbias = $fct_totalbias * 60;
 $fct_clienttimestamp = $fct_servertime + $fct_totalbias;
 $fct_time = time();
 $fct_year = strftime("%Y", $fct_clienttimestamp);
 $fct_month = strftime("%B", $fct_clienttimestamp);
 $fct_day = strftime("%d", $fct_clienttimestamp);
 $fct_hour = strftime("%I", $fct_clienttimestamp);
 $fct_minute = strftime("%M", $fct_clienttimestamp);
 $fct_second = strftime("%S", $fct_clienttimestamp);
 $fct_am_pm = strftime("%p", $fct_clienttimestamp);
 echo $fct_day.", ".$fct_month." ".$fct_year." ( ".$fct_hour.":".$fct_minute.":".$fct_second." ".$fct_am_pm." )";
}
showclienttime();
?>