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
	$Level = trim($_POST['LevelName']);	
	$PageNo = $_POST['PageNo'];
	$Counts = trim($_POST["Counts"]);
	
	$status = trim($_POST["status"]);
		
			
	if($e_action == "AddNew")
	{
		$str = "SELECT * FROM ".$tbname."_level WHERE _LevelName = '". replaceSpecialChar($Level) ."' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = 'level.php?PageNo=".$PageNo."&error=1&LevelName=".$Level."'</script>";
			exit();
		}
		
		
		$str = "INSERT INTO ".$tbname."_level (_LevelName,_SubDate,_SubBy,_Status) VALUES(";
		if($Level != "")
			$str = $str . "'" . replaceSpecialChar($Level) . "', ";
		else
			$str = $str . "null, ";	
			
			$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		
		$str = $str . "'" . $_SESSION['userid'] . "', ";	
			
					
		$str = $str . "1) ";
		
		//echo $str;
		//exit();
		mysql_query($str);

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add New Level', ";
		if ($Level != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($Level) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'level.php?PageNo=".$PageNo."&done=1'</script>";
		exit();
	}
	else if($e_action == "Edit")
	{
		
		$str = "UPDATE ".$tbname."_level SET ";
		if($Level != "")
			$str = $str . "_LevelName = '" . replaceSpecialChar($Level) . "', ";
		else
			$str = $str . "_LevelName = null, ";
			
		$str = $str . "_SubDate = '" . date("Y-m-d H:i:s") . "', ";
		$str = $str . "_SubBy = '" . $_SESSION['userid'] . "', ";	
			
			
		if($status != "")
			$str = $str . "_Status = '" . replaceSpecialChar($status) . "' ";
		else
			$str = $str . "_Status = null ";					
			
		$str = $str . "WHERE _ID = '".$id."' ";
		mysql_query($str);

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Edit Level', ";
		if ($Level != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($Level) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);

		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'level.php?PageNo=".$PageNo."&done=2'</script>";
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
		
		$str = "SELECT DISTINCT _LevelName FROM ".$tbname."_level WHERE (" . $emailString . ") ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			while($rs = mysql_fetch_assoc($rst))
			{	
				$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
				$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
				$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
				$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
				$strSQL = $strSQL . "'Delete User Group', ";
				if ($rs["_LevelName"] != "")
				{
					$strSQL = $strSQL . "'" . replaceSpecialChar($rs["_LevelName"]) . "' ";
				}
				else
				{
					$strSQL = $strSQL . "null ";
				}
				$strSQL = $strSQL . ")";
				mysql_query($strSQL);				
			}
		}
		
		$str = "UPDATE ".$tbname."_level SET _Status = '2' ";
		$str = $str . " WHERE (" . $emailString . ") ";
		mysql_query($str);	
	
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'level.php?done=3'</script>";
		exit();
	}
?>