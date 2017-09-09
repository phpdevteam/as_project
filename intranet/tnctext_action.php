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
	$PageNo = $_REQUEST['PageNo'];
	$DateTime = date("Y-m-d H:i:s");

	$title = trim($_POST["title"]);
	$tnc = trim($_POST["tnc"]);
	$module = trim($_POST["module"]);
	$modulename = trim($_POST["modulename"]);
	$status	= trim($_POST["status"]);
	
	$Encrypt = "mysecretkey";
	
	
	if($e_action == "AddNew")
	{		
		$str = "INSERT INTO ".$tbname."_tnctext 
				(_title,_tnc,_mode,_status,_subdate,_subby)
				VALUES(";
		if($title != "") $str = $str . "'" . replaceSpecialChar($title) . "', ";
		else $str = $str . "null, ";
		
		if($tnc != "") $str = $str . "'" . replaceSpecialChar($tnc) . "', ";
		else $str = $str . "null, ";
		
		if($modulename != "") $str = $str . "'" . replaceSpecialChar($modulename) . "', ";
		else $str = $str . "null, ";
		
		$str = $str . "1, ";
		
		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		$str = $str . "'" . $_SESSION['userid'] . "' ";
			
		$str = $str . ") ";

		mysql_query($str);
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add New T&amp;C', ";
		
		if ($title != "") $strSQL = $strSQL . "'" . replaceSpecialChar($title) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
		
				
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'tnctexts.php?module=". $module ."&PageNo=".$PageNo."&done=1'</script>";
		exit();
	
	}else if($e_action == "Edit"){
		
		$str = "UPDATE ".$tbname."_tnctext SET ";
		if ($title != "")		
			$str = $str . "_title = '" . replaceSpecialChar($title) . "', ";
			
		if ($tnc != "")		
			$str = $str . "_tnc = '" . replaceSpecialChar($tnc) . "', ";
			
		if($status != "")		
			$str = $str . "_status = '" . replaceSpecialChar($status) . "' ";		
		else		
			$str = $str . "_status = null ";
				
		$str = $str . " WHERE _id = '" . $id . "' ";

		mysql_query($str);
		
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Edit Brand', ";
		if ($Fullname != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($Fullname) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'tnctexts.php?module=". $module ."&PageNo=".$PageNo."&done=2'</script>";
        
		exit();
	
	}elseif ($e_action == 'delete'){
		
		
		$emailString = "";
	
		$cntCheck = $_POST["cntCheck"];
		for ($i=1; $i<=$cntCheck; $i++)
		{
			if ($_POST["CustCheckbox".$i] != "")
			{
				$emailString = $emailString . "_id = '" . $_POST["CustCheckbox".$i] . "' OR ";
				
				$emailStringSQ = $emailString . "_id = '" . $_POST["CustCheckbox".$i] . "' OR ";
				
			}
		}
	
		$emailString = substr($emailString, 0, strlen($emailString)-4);		
		
		
		$str = "UPDATE ".$tbname."_tnctext SET _status = '2' ";
		$str = $str . " WHERE (" . $emailString . ")" ;
		mysql_query($str);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location='tnctexts.php?module=". $module ."&done=3';</script>";
		exit();
	}	
?>