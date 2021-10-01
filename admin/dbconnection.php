<?php
define('DB_SERVER','localhost');
define('DB_USER','Wellness_admin');
define('DB_PASS' ,'jma7B75Pxf90NzB8');
define('DB_NAME', '_wellness_4_all_');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

?>

