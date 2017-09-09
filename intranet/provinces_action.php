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
	
	//var_dump($_REQUEST);
	$e_action = $_REQUEST['e_action'];
	$id = trim($_REQUEST['id']);
	$cid = trim($_REQUEST['cid']);
	$Province = trim($_POST['ProvinceName']);	
	$countryid = trim($_POST['countryid']);	
	$PageNo = $_POST['PageNo'];
	$Counts = trim($_POST["Counts"]);
	
	$status	= trim($_POST["status"]);
		
			
	if($e_action == "AddNew")
	{
		$str = "SELECT * FROM ".$tbname."_provinces WHERE _provincename = '". replaceSpecialChar($Province) ."' and _countryid = '". $cid ."' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = 'provinces.php?PageNo=".$PageNo."&error=1&ProvinceName=".$Province."&cid=". $cid ."'</script>";
			exit();
		}
		
		
		$str = "INSERT INTO ".$tbname."_provinces (_provincename,_countryid,_subdate,_subby,_status) VALUES(";
		if($Province != "")
			$str = $str . "'" . replaceSpecialChar($Province) . "', ";
		else
			$str = $str . "null, ";	
			
			if($countryid != "")
			$str = $str . "'" . replaceSpecialChar($countryid) . "', ";
		else
			$str = $str . "null, ";
			
		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		
		$str = $str . "'" . $_SESSION['userid'] . "','1' ";		
		$str = $str . ") ";
		
		//echo $str;
		//exit();
		mysql_query($str) or die(mysql_error());

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add New Province', ";
		if ($Province != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($Province) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'provinces.php?PageNo=".$PageNo."&done=1'</script>";
		exit();
	}
	else if($e_action == "Edit")
	{
		
		$str = "UPDATE ".$tbname."_provinces SET ";
		
		if($countryid != "")
			$str = $str . "_countryid = '" . replaceSpecialChar($countryid) . "', ";
		else
			$str = $str . "_countryid = null ,";					
			
	    if($status != "")		
			$str = $str . "_Status = '" . replaceSpecialChar($status) . "', ";		
		else		
			$str = $str . "_Status = null, ";
			
				$str = $str . "_subby = '" . $_SESSION['userid'] . "', ";	
		$str = $str . "_subdate = '" . date("Y-m-d H:i:s") . "', ";		
		
		
		if($Province != "")
			$str = $str . "_provincename = '" . replaceSpecialChar($Province) . "' ";
		else
			$str = $str . "_provincename = null ";					
			
		$str = $str . "WHERE _id = '".$id."' ";
		mysql_query($str);

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Edit Province', ";
		if ($Province != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($Province) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);

		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'provinces.php?PageNo=".$PageNo."&done=2'</script>";
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
				$emailString = $emailString . "_id = '" . $_POST["CustCheckbox".$i] . "' OR ";
			}
		}
		
		$emailString = substr($emailString, 0, strlen($emailString)-4);
		
		$str = "SELECT DISTINCT _provincename FROM ".$tbname."_provinces WHERE (" . $emailString . ") ";
			//	echo $str;
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			while($rs = mysql_fetch_assoc($rst))
			{	
				$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
				$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
				$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
				$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
				$strSQL = $strSQL . "'Delete Location', ";
				if ($rs["_provincename"] != "")
				{
					$strSQL = $strSQL . "'" . replaceSpecialChar($rs["_provincename"]) . "' ";
				}
				else
				{
					$strSQL = $strSQL . "null ";
				}
				$strSQL = $strSQL . ")";
				mysql_query($strSQL);				
			}
		}
		
		$str = "UPDATE ".$tbname."_provinces SET _status = '2' ";
		$str = $str . " WHERE (" . $emailString . ") ";
		//echo $str;
		//exit();
		mysql_query($str);	
	
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'provinces.php?done=3'</script>";
		exit();
	}
?>