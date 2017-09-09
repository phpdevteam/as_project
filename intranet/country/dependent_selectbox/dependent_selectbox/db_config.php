<?php
$host= "localhost";
$username= "root";
$password = "";
$db_name = "devnwzso_as";
$db = new mysqli($host,$username,$password,$db_name);
if($db->connect_error)
{
	die("connection failed:". $db->connect_error);
	
}
?>