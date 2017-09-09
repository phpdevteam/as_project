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
	$SubTypeName = trim($_POST['SubTypeName']);	
	$nosession = trim($_POST['nosession']);	
	$TypeID = trim($_POST['TypeID']);	
	$PageNo = $_POST['PageNo'];
	$Counts = trim($_POST["Counts"]);
	
	$status	= trim($_POST["status"]);
		
			
	if($e_action == "AddNew")
	{
		$str = "SELECT * FROM ".$tbname."_trainingsubtype WHERE _SubTypeName = '". replaceSpecialChar($SubTypeName) ."' and _TypeID = '". $cid ."' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = 'protraingsubtype.php?PageNo=".$PageNo."&error=1&SubTypeName=".$SubTypeName."&cid=". $cid ."'</script>";
			exit();
		}
		
		
		$str = "INSERT INTO ".$tbname."_trainingsubtype (_SubTypeName,_TypeID,_NoSession,_CreatedDateTime,_Status) VALUES(";
		
		if($SubTypeName != "")
			$str = $str . "'" . replaceSpecialChar($SubTypeName) . "', ";
		else
			$str = $str . "null, ";	
			
		if($TypeID != "")
			$str = $str . "'" . replaceSpecialChar($TypeID) . "', ";
		else
			$str = $str . "null, ";

		if($nosession != "")
			$str = $str . "'" . replaceSpecialChar($nosession) . "', ";
		else
			$str = $str . "null, ";
			
		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		
		$str = $str . "'1' ";		
		$str = $str . ") ";
		
		//echo $str;
		//exit();
		mysql_query($str) or die(mysql_error());

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add New Programs Sub Type	', ";
		if ($SubTypeName != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($SubTypeName) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'protraingsubtype.php?PageNo=".$PageNo."&done=1'</script>";
		exit();
	}
	else if($e_action == "Edit")
	{
		
		$str = "UPDATE ".$tbname."_trainingsubtype SET ";
		
		if($TypeID != "")
			$str = $str . "_TypeID = '" . replaceSpecialChar($TypeID) . "', ";
		else
			$str = $str . "_TypeID = null ,";					
			
	    if($status != "")		
			$str = $str . "_Status = '" . replaceSpecialChar($status) . "', ";		
		else		
			$str = $str . "_Status = null, ";
			
			if($nosession != "")		
			$str = $str . "_NoSession = '" . replaceSpecialChar($nosession) . "', ";		
		else		
			$str = $str . "_NoSession = null, ";
			

		$str = $str . "_CreatedDateTime = '" . date("Y-m-d H:i:s") . "', ";		
		
		
		if($SubTypeName != "")
			$str = $str . "_SubTypeName	 = '" . replaceSpecialChar($SubTypeName) . "' ";
		else
			$str = $str . "_SubTypeName	 = null ";					
			
		$str = $str . "WHERE _ID = '".$id."' ";
		mysql_query($str);

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Edit Programs Sub Type', ";
		if ($SubTypeName != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($SubTypeName) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);

		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'protraingsubtype.php?PageNo=".$PageNo."&done=2'</script>";
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
		
		$str = "SELECT DISTINCT _SubTypeName	 FROM ".$tbname."_trainingsubtype WHERE (" . $emailString . ") ";
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
				$strSQL = $strSQL . "'Delete Programs Sub Type', ";
				if ($rs["_SubTypeName"] != "")
				{
					$strSQL = $strSQL . "'" . replaceSpecialChar($rs["_SubTypeName"]) . "' ";
				}
				else
				{
					$strSQL = $strSQL . "null ";
				}
				$strSQL = $strSQL . ")";
				mysql_query($strSQL);				
			}
		}
		
		$str = "UPDATE ".$tbname."_trainingsubtype SET _Status = '2' ";
		$str = $str . " WHERE (" . $emailString . ") ";
		//echo $str;
		//exit();
		mysql_query($str);	
	
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'protraingsubtype.php?done=3'</script>";
		exit();
	}
?>