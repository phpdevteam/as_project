<?
session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
		exit();
	}
	include('../global.php');	
	include('../include/functions.php');
	include('access_rights_function.php'); 
	include("fckeditor/fckeditor.php");
	$e_action = $_REQUEST['e_action'];
	$e_action12 = $_REQUEST['action12'];
	$id = trim($_REQUEST['id']);
	$PageNo = $_REQUEST['PageNo'];
    $DateTime = date("Y-m-d H:i:s");
    

    $minimum =$_REQUEST['minimum'];

echo "<pre>";
print_r($minimum);
echo"</pre>";
exit;
echo "hiiiiiiii";
exit;


    ?>