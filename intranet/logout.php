<?php
session_start();
$userid = $_SESSION['userid'];
$user = $_SESSION['user'];
$loginTime = $_SESSION['loginTime'];	
$sessionInfo = session_id() . $user . $loginTime;	
$winlocation="window.location= 'login.php';";
include('../global.php');
include('../include/functions.php');  include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");

if (strlen($userid) != 0 && strlen($user) != 0 && strlen($loginTime) != 0 && strlen($sessionInfo) != 0)
{
    $strSQL = "UPDATE ".$tbname."_logginglog SET _DateTimeOut = '".date("Y-m-d H:i:s")."' WHERE _UserID = '" .replaceSpecialChar($userid). "' AND _SessionInfo = '" .replaceSpecialChar($sessionInfo). "'";
    mysql_query($strSQL);
    session_unset();
    session_destroy();
}
include('../dbclose.php');
echo "<script>";
echo "alert('You have successfully logged out!')";
echo "</script>";
echo "<script>";
echo $winlocation;
echo "</script>";
?>