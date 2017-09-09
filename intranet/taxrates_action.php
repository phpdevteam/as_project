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
	$ratename = trim($_REQUEST['ratename']);	
	$rate = trim($_REQUEST['rate']);	
	$startdate1			= explode("/",$_POST["startdate"]);
	$startdate 			= $startdate1[2].'-'.$startdate1[1].'-'.$startdate1[0];
	$enddate1			= explode("/",$_POST["enddate"]);
	$enddate 			= $enddate1[2].'-'.$enddate1[1].'-'.$enddate1[0];
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
		$str = "SELECT * FROM ".$tbname."_gstmaster WHERE _ratename = '". replaceSpecialChar($ratename) ."' and _startdate = '". replaceSpecialChar($startdate) ."' and _enddate = '". replaceSpecialChar($enddate) ."' and _status = 1 ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = 'taxrates.php?PageNo=".$PageNo."&error=1&ratename=".$ratename."'</script>";
			exit();
		}
	 
		
		$str = "INSERT INTO ".$tbname."_gstmaster (_ratename, _rate, _startdate, _enddate, _subdate, _subby, _status) VALUES(";
		if($ratename != "")
			$str = $str . "'" . replaceSpecialChar($ratename) . "', ";
		else
			$str = $str . "null, ";	
		if($rate != "")
			$str = $str . "'" . replaceSpecialChar($rate) . "', ";
		else
			$str = $str . "null, ";		
		if($startdate != "")
			$str = $str . "'" . replaceSpecialChar($startdate) . "', ";
		else
			$str = $str . "null, ";
		if($enddate != "")
			$str = $str . "'" . replaceSpecialChar($enddate) . "', ";
		else
			$str = $str . "null, ";	
		$str = $str . "'" . replaceSpecialChar($subdate) . "', ";
		$str = $str . "'" . replaceSpecialChar($subby) . "', ";	
		$str = $str . "'" . replaceSpecialChar($status) . "' ";				
		$str = $str . ") ";
		
		mysql_query($str);

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . replaceSpecialChar($subby) . "', ";
		$strSQL = $strSQL . "'" . replaceSpecialChar($subip) . "', ";
		$strSQL = $strSQL . "'" . replaceSpecialChar($subdate) . "', ";
		$strSQL = $strSQL . "'Add New Tax Rate', ";
		if ($ratename != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($ratename) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'taxrates.php?PageNo=".$PageNo."&done=1'</script>";
		exit();
	}
	else if($e_action == "Edit")
	{
		$str = "SELECT * FROM ".$tbname."_gstmaster WHERE _ratename = '". replaceSpecialChar($ratename) ."' and _startdate = '". replaceSpecialChar($startdate) ."' and _enddate = '". replaceSpecialChar($enddate) ."' and _status = 1
		and _id <> '". $id ."' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = 'taxrates.php?PageNo=".$PageNo."&error=1&ratename=".$ratename."&id=$id&e_action=edit'</script>";
			exit();
		}
		
		
		$str = "UPDATE ".$tbname."_gstmaster SET ";
		if($ratename != "")
			$str = $str . "_ratename = '" . replaceSpecialChar($ratename) . "', ";
		else
			$str = $str . "_ratename = null, ";	
		if($rate != "")
			$str = $str . "_rate = '" . replaceSpecialChar($rate) . "', ";
		else
			$str = $str . "_rate = null, ";				
		if($startdate != "")
			$str = $str . "_startdate = '" . replaceSpecialChar($startdate) . "', ";
		else
			$str = $str . "_startdate = null, ";
		if($enddate != "")
			$str = $str . "_enddate = '" . replaceSpecialChar($enddate) . "', ";
		else
			$str = $str . "_enddate = null, ";			
		$str = $str . "_subdate = '" . replaceSpecialChar($subdate) . "', ";
		$str = $str . "_subby = '" . replaceSpecialChar($subby) . "', ";	
		$str = $str . "_status = '" . replaceSpecialChar($status) . "' ";	
		$str = $str . "WHERE _id = '".$id."' ";
		mysql_query($str);

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . replaceSpecialChar($subby) . "', ";
		$strSQL = $strSQL . "'" . replaceSpecialChar($subip) . "', ";
		$strSQL = $strSQL . "'" . replaceSpecialChar($subdate) . "', ";
		$strSQL = $strSQL . "'Edit Tax Rate', ";
		if ($ratename != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($ratename) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);

		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'taxrates.php?PageNo=".$PageNo."&done=2'</script>";
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
		
		$str = "SELECT DISTINCT _ratename FROM ".$tbname."_gstmaster WHERE (" . $emailString . ") ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			while($rs = mysql_fetch_assoc($rst))
			{	
				$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
				$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
				$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
				$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
				$strSQL = $strSQL . "'Delete Tax Rate', ";
				if ($rs["_ratename"] != "")
				{
					$strSQL = $strSQL . "'" . replaceSpecialChar($rs["_ratename"]) . "' ";
				}
				else
				{
					$strSQL = $strSQL . "null ";
				}
				$strSQL = $strSQL . ")";
				mysql_query($strSQL);				
			}
		}
		
		$str = "UPDATE ".$tbname."_gstmaster SET _status = '2' ";
		$str = $str . " WHERE (" . $emailString . ") ";
		mysql_query($str);			
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'taxrates.php?done=3'</script>";
		exit();
	}
?>