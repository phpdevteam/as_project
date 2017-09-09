<?php
error_reporting(0);
//Local
$tbname="as";
$projectname = "One Active Space";

//test
$hostname = "localhost";
$database = "devnwzso_as";
//$username = "devnwzso_as";
//$password = "epnWguZ~T0uM";

$username = "root";
$password = "";
$connect = mysql_connect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR);

?>
