<?php
define('DB_SERVER','localhost');
define('DB_USER','HealthyStyle');
define('DB_PASS' ,'bkrPX66h9T73sFLi');
define('DB_NAME', '_wellness_4_all_');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

?>

