<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	include('../global.php');
	include('../include/functions.php');
include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");	
	
	$e_action = $_REQUEST['e_action'];
	$id = trim($_REQUEST['id']);
	$SubSubTypeName = trim($_REQUEST['SubSubTypeName']);	
	$TypeID = trim($_REQUEST['TypeID']);
	$SubTypeID = trim($_REQUEST['SubTypeID']);
	$PageNo = $_REQUEST['PageNo'];
	$Counts = trim($_REQUEST["Counts"]);
	$subdate = date("Y-m-d H:i:s");
	$subby = $_SESSION['userid'];
	$subip = $_SERVER['REMOTE_ADDR'];
	if($_REQUEST['status']=="")
	{
		$status = 1;
	}
	else
	{
		$status = $_REQUEST['status'];
	}
		
			
	if($e_action == "Add")
	{
		$str = "SELECT * FROM ".$tbname."_trainingsubsubtype WHERE _SubSubTypeName = '". replaceSpecialChar($SubSubTypeName) ."' and _Status = 1 ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = 'protraingsubsubtype.php?PageNo=".$PageNo."&error=1&SubSubTypeName=".$SubSubTypeName."'</script>";
			exit();
		}
		
		$str = "INSERT INTO ".$tbname."_trainingsubsubtype (_SubSubTypeName, _TypeID,_SubTypeID,_CreatedDateTime,_Status) VALUES(";
		if($SubSubTypeName != "")
			$str = $str . "'" . replaceSpecialChar($SubSubTypeName) . "', ";
		else
			$str = $str . "null, ";	
		if($TypeID != "")
			$str = $str . "'" . replaceSpecialChar($TypeID) . "', ";
		else
			$str = $str . "null, ";	
		if($SubTypeID != "")
			$str = $str . "'" . replaceSpecialChar($SubTypeID) . "', ";
		else
			$str = $str . "null, ";	
		$str = $str . "'" . replaceSpecialChar($subdate) . "', ";
	
		$str = $str . "'" . replaceSpecialChar($status) . "' ";				
		$str = $str . ") ";
		mysql_query('SET NAMES utf8');
		mysql_query($str);

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . replaceSpecialChar($subby) . "', ";
		$strSQL = $strSQL . "'" . replaceSpecialChar($subip) . "', ";
		$strSQL = $strSQL . "'" . replaceSpecialChar($subdate) . "', ";
		$strSQL = $strSQL . "'Add New Sub Sub Type', ";
		if ($SubSubTypeName != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($SubSubTypeName) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'protraingsubsubtype.php?PageNo=".$PageNo."&done=1'</script>";
		exit();
	}
	else if($e_action == "Edit")
	{
		
		$str = "UPDATE ".$tbname."_trainingsubsubtype SET ";
		if($SubSubTypeName != "")
			$str = $str . "_SubSubTypeName = '" . replaceSpecialChar($SubSubTypeName) . "', ";
		else
			$str = $str . "_SubSubTypeName = null, ";	
		if($TypeID != "")
			$str = $str . "_TypeID = '" . replaceSpecialChar($TypeID) . "', ";
		else
			$str = $str . "_TypeID = null, ";	
		if($SubTypeID != "")
			$str = $str . "_SubTypeID = '" . replaceSpecialChar($SubTypeID) . "', ";
		else
			$str = $str . "_SubTypeID = null, ";					
		$str = $str . "_CreatedDateTime = '" . replaceSpecialChar($subdate) . "', ";
	
		$str = $str . "_Status = '" . replaceSpecialChar($status) . "' ";	
		$str = $str . "WHERE _id = '".$id."' ";
		mysql_query('SET NAMES utf8');
		mysql_query($str);

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . replaceSpecialChar($subby) . "', ";
		$strSQL = $strSQL . "'" . replaceSpecialChar($subip) . "', ";
		$strSQL = $strSQL . "'" . replaceSpecialChar($subdate) . "', ";
		$strSQL = $strSQL . "'Edit Sub Sub Type', ";
		if ($SubSubTypeName != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($SubSubTypeName) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);

		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'protraingsubsubtype.php?PageNo=".$PageNo."&done=2'</script>";
		exit();
	}
	else if($e_action == "curdelete")
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
		
		$str = "SELECT DISTINCT _SubSubTypeName FROM ".$tbname."_trainingsubsubtype WHERE (" . $emailString . ") ";
		$rst = mysql_query('SET NAMES utf8');
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			while($rs = mysql_fetch_assoc($rst))
			{	
				$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
				$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
				$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
				$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
				$strSQL = $strSQL . "'Delete Sub Sub Type', ";
				if ($rs["_SubSubTypeName"] != "")
				{
					$strSQL = $strSQL . "'" . replaceSpecialChar($rs["_SubSubTypeName"]) . "' ";
				}
				else
				{
					$strSQL = $strSQL . "null ";
				}
				$strSQL = $strSQL . ")";
				mysql_query('SET NAMES utf8');
				mysql_query($strSQL);				
			}
		}
		
		$str = "UPDATE ".$tbname."_trainingsubsubtype SET _Status = '2' ";
		$str = $str . " WHERE (" . $emailString . ") ";
		mysql_query($str);			
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'protraingsubsubtype.php?done=3'</script>";
		exit();
	}
?>