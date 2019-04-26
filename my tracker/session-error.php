<?php
echo "Session Expired! Inactivity for 10 minutes caused this session timeout." . "<br>";
echo "Please login to continue!" . "<br>";
echo "<script>setTimeout(\"location.href = '/PV/index.html';\",2500);</script>";
?>