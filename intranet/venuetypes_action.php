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
	$VenueTypeName = trim($_POST['VenueTypeName']);	
	$bookwithoutprog = trim($_POST['bookwithoutprog']);	
	$PageNo = $_POST['PageNo'];
	$type = $_REQUEST['type'];
	$Counts = trim($_POST["Counts"]);
	$_SESSION['user'];
	
	$status = $_REQUEST['status'];
	
//	exit();
	//var_dump($_REQUEST);
//	exit();
	


			
	if($e_action == "AddNew")
	{
		$str = "SELECT * FROM ".$tbname."_venuetype WHERE _VenueTypeName = '". replaceSpecialChar($VenueTypeName) ."'";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = 'venuetypes.php?type=".$type."&PageNo=".$PageNo."&error=1&VenueTypeName=".$VenueTypeName."'</script>";
			exit();
		}
		
		
		$str = "INSERT INTO ".$tbname."_venuetype (_VenueTypeName,_BookWithoutProg,_SubmittedBy,_CreatedDate,_Status) VALUES(";
		if($VenueTypeName != "")
			$str = $str . "'" . replaceSpecialChar($VenueTypeName) . "', ";
		else
			$str = $str . "null, ";		

		if($bookwithoutprog != "")
		$str = $str . "'" . replaceSpecialChar($bookwithoutprog) . "', ";
		else
			$str = $str . "null, ";	
		
		$str = $str . "'" . $_SESSION['userid'] . "', ";	
		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		$str = $str . "'1') ";

		
		mysql_query($str);

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add New Venue Type', ";
		if ($VenueTypeName != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($VenueTypeName) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'venuetypes.php?type=".$type."&PageNo=".$PageNo."&done=1'</script>";
		exit();
	}
	else if($e_action == "Edit")
	{
		
		$str = "SELECT * FROM ".$tbname."_venuetype WHERE _VenueTypeName = '". replaceSpecialChar($VenueTypeName) ."'  and _ID <> '". $id ."' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = 'venuetypes.php?type=".$type."&PageNo=".$PageNo."&id=". $id ."&error=1&VenueTypeName=".$VenueTypeName."'</script>";
			exit();
		}
		
		$str = "UPDATE ".$tbname."_venuetype SET ";
		if($VenueTypeName != "")
			$str = $str . "_VenueTypeName = '" . replaceSpecialChar($VenueTypeName) . "', ";
		else
			$str = $str . "_VenueTypeName = null, ";	
			
		if($bookwithoutprog != "")
		$str = $str . "_BookWithoutProg = '" . replaceSpecialChar($bookwithoutprog) . "', ";
	    else
		$str = $str . "_BookWithoutProg = null, ";
			
			
		$str = $str . "_SubmittedBy = '" . $_SESSION['userid'] . "', ";	
		$str = $str . "_CreatedDate = '" . date("Y-m-d H:i:s") . "', ";				
			
			
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
		$strSQL = $strSQL . "'Edit Venue Type', ";
		if ($VenueTypeName != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($VenueTypeName) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);

		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'venuetypes.php?PageNo=".$PageNo."&done=2&type=".$type."'</script>";
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
		
		$str = "SELECT DISTINCT _VenueTypeName FROM ".$tbname."_venuetype WHERE (" . $emailString . ") ";
		//$str = "SELECT * FROM ".$tbname."_locations WHERE _ID = '".$id."' ";
		//$str = "SELECT DISTINCT _currencyshortname FROM ".$tbname."_currencies WHERE (" . $emailString . ") ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			while($rs = mysql_fetch_assoc($rst))
			{	
				$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
				$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
				$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
				$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
				$strSQL = $strSQL . "'Delete Venue Type', ";
				if ($rs["_VenueCatName"] != "")
				{
					$strSQL = $strSQL . "'" . replaceSpecialChar($rs["_VenueTypeName"]) . "' ";
				}
				else
				{
					$strSQL = $strSQL . "null ";
				}
				$strSQL = $strSQL . ")";
				mysql_query($strSQL);				
			}
		}
		
		$str = "UPDATE ".$tbname."_venuetype SET _Status = '2' ";
		$str = $str . " WHERE (" . $emailString . ") ";
		mysql_query($str);	
	
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'venuetypes.php?done=3&type=".$type."'</script>";
		exit();
		
	}
?>