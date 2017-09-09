
<?php

session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']=="")
{
    echo "<script language='javascript'>window.location='login.php';</script>";
    exit();
}
include('../global.php');	
include('../include/functions.php');include('access_rights_function.php'); 
include("fckeditor/fckeditor.php");

$Operations = GetAccessRights(61);
if(count($Operations)== 0)
{
    echo "<script language='javascript'>history.back();</script>";
}	

 $SQOperations = GetAccessRights(71);


$programtype = $_POST['programtype'];




$sql= "select * from  as_trainingprogram  where _ID='$programtype' ";


$res = mysql_query($sql) or die(mysql_error());

while($res1 = mysql_fetch_array($res)){


    $MaxvenueFee = $res1['_MaxVenuefeeSurcharge'];
   
}
echo $MaxvenueFee;


?>
