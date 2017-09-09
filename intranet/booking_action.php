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
	
	// echo '<pre>';print_r($_REQUEST);
	// echo '<pre>';print_r($_FILES);
	// die;
	$programname = replaceSpecialChar($_REQUEST['programname']);




 if($e_action == 'delete')
	{		
		$emailString = "";

		$cntCheck = $_POST["cntCheck"];
		for ($i=1; $i<=$cntCheck; $i++)
		{
			if ($_POST["CustCheckbox".$i] != "")
			{
				$emailString = $emailString . "_ID = '" . $_POST["CustCheckbox".$i] . "' OR ";

			}
		}
	
		$emailString = substr($emailString, 0, strlen($emailString)-4);
		$str = "UPDATE ".$tbname."_trainingprogram SET _Status = 2 WHERE (" . $emailString . ") ";
    
		mysql_query($str);
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Delete Program', ";
		
		if ($emailString != "") $strSQL = $strSQL . "'" . replaceSpecialChar($emailString) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'bookings.php?PageNo=".$PageNo."&done=3'</script>";
		exit();
	}

?>