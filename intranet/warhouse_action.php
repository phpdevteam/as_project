<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	include('../global.php');
	include('../include/functions.php');	include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");
	
	$e_action = $_REQUEST['e_action'];
	$id = trim($_REQUEST['id']);
	$WarhouseName = trim($_POST['WarhouseName']);	
	$PageNo = $_POST['PageNo'];
	$type = $_REQUEST['type'];
	$Counts = trim($_POST["Counts"]);
	$_SESSION['user'];
	$status	= trim($_POST["status"]);
//	exit();
	//var_dump($_REQUEST);
//	exit();
		
			
	if($e_action == "AddNew")
	{
		$str = "SELECT * FROM ".$tbname."_warhouses WHERE _warhouseName = '". replaceSpecialChar($WarhouseName) ."' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = 'warhouses.php?PageNo=".$PageNo."&error=1&CategoryName=".$WarhouseName."'</script>";
			exit();
		}
		
		
		$str = "INSERT INTO ".$tbname."_warhouses (_warhouseName,_subby,_subdate,_status) VALUES(";
		if($WarhouseName != "")
			$str = $str . "'" . replaceSpecialChar($WarhouseName) . "', ";
		else
			$str = $str . "null, ";		
		
		$str = $str . "'" . $_SESSION['user'] . "', ";	
		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		$str = $str . "'1') ";

		
		
		//echo $str;
		//exit();
		mysql_query($str);

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add New Category', ";
		if ($WarhouseName != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($WarhouseName) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'warhouses.php?PageNo=".$PageNo."&done=1'</script>";
		exit();
	}
	else if($e_action == "Edit")
	{
		
		$str = "UPDATE ".$tbname."_warhouses SET ";
		if($WarhouseName != "")
			$str = $str . "_warhouseName = '" . replaceSpecialChar($WarhouseName) . "', ";
		else
			$str = $str . "_warhouseName = null, ";		
			
				$str = $str . "_subby = '" . $_SESSION['userid'] . "', ";	
		$str = $str . "_subdate = '" . date("Y-m-d H:i:s") . "', ";	
			
		if($status != "")		
			$str = $str . "_Status = '" . replaceSpecialChar($status) . "' ";		
		else		
			$str = $str . "_Status = null ";			
			
		$str = $str . " WHERE _ID = '".$id."' ";
		mysql_query($str) or (die (mysql_error()));

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Edit Category', ";
		if ($WarhouseName != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($WarhouseName) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);

		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'warhouses.php?PageNo=".$PageNo."&done=2'</script>";
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
		
		$str = "SELECT DISTINCT _warhouseName FROM ".$tbname."_warhouses WHERE (" . $emailString . ") ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			while($rs = mysql_fetch_assoc($rst))
			{	
				$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
				$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
				$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
				$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
				$strSQL = $strSQL . "'Delete Currency', ";
				if ($rs["_warhouseName"] != "")
				{
					$strSQL = $strSQL . "'" . replaceSpecialChar($rs["_warhouseName"]) . "' ";
				}
				else
				{
					$strSQL = $strSQL . "null ";
				}
				$strSQL = $strSQL . ")";
				mysql_query($strSQL);				
			}
		}
		
		$str = "UPDATE ".$tbname."_warhouses SET _status = '2' ";
		$str = $str . " WHERE (" . $emailString . ") ";
		mysql_query($str);			
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'warhouses.php?done=3'</script>";
		exit();
		
	}
?>