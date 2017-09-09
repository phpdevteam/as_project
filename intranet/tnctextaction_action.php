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
	
	//var_dump($_REQUEST);
	$Brandname = trim($_POST["Brandname"]);
	//$Fname = trim($_POST["FName"]);
	//$Behaveperson	= trim($_POST["behaveperson"]);
	$status	= trim($_POST["status"]);
	
	$Encrypt = "mysecretkey";
	
	
	if($e_action == "AddNew")
	{		
		$str = "INSERT INTO ".$tbname."_brand 
				(_BrandName,_Status,_subdate,_subby)
				VALUES(";
		if($Brandname != "") $str = $str . "'" . replaceSpecialChar($Brandname) . "', ";
		else $str = $str . "null, ";
		
		if($status != "") $str = $str . "'" . replaceSpecialChar($status) . "', ";
		else $str = $str . "null, ";
		
		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		$str = $str . "'" . $_SESSION['userid'] . "' ";
			
		$str = $str . ") ";
		echo $str;
		mysql_query($str);
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add New Brand', ";
		
		if ($Brandname != "") $strSQL = $strSQL . "'" . replaceSpecialChar($Brandname) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
		
				
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'productbrands.php?PageNo=".$PageNo."&done=1'</script>";
		exit();
	
	}else if($e_action == "Edit"){
		
		$str = "UPDATE ".$tbname."_brand SET ";
		if ($Brandname != "")		
			$str = $str . "_Password = '" . replaceSpecialChar($Brandname) . "', ";
			
		if($status != "")		
			$str = $str . "_Status = '" . replaceSpecialChar($status) . "' ";		
		else		
			$str = $str . "_Status = null ";
				
		$str = $str . " WHERE _ID = '" . $id . "' ";
		
		echo $str;
		//exit();
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
		echo "<script language='JavaScript'>window.location = 'productbrands.php?PageNo=".$PageNo."&done=2'</script>";
        
		exit();
	
	}elseif ($e_action == 'delete'){
		
		$str = "UPDATE ".$tbname."_user SET _Deleted = '1' ";
		$str = $str . " WHERE _ID = '" . $id . "' ";
		mysql_query($str);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location='productbrands.php?done=3';</script>";
		exit();
	}	
?>