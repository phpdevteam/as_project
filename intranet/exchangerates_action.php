<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	include('../global.php');
	include('../include/functions.php');include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");	
	
	$e_action = $_REQUEST['e_action'];
	$id = trim($_REQUEST['id']);
	$currencyid = trim($_REQUEST['currencyid']);
	$fcurrencyid = trim($_REQUEST['fcurrencyid']);	
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
		$str = "SELECT * FROM ".$tbname."_exchangerates WHERE _currencyid = '". replaceSpecialChar($currencyid) ."' and _rate = '". replaceSpecialChar($rate) ."' and _startdate = '". replaceSpecialChar($startdate) ."' and _enddate = '". replaceSpecialChar($enddate) ."' and _status = 1 ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = 'exchangerates.php?PageNo=".$PageNo."&error=1&rate=".$rate."'</script>";
			exit();
		}
		
		$str = "INSERT INTO ".$tbname."_exchangerates (_fcurrencyid,_currencyid, _rate, _startdate, _enddate, _subdate, _subby, _status) VALUES(";
		if($fcurrencyid != "")
			$str = $str . "'" . replaceSpecialChar($fcurrencyid) . "', ";
		else
			$str = $str . "null, ";	
		
		if($currencyid != "")
			$str = $str . "'" . replaceSpecialChar($currencyid) . "', ";
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
		$strSQL = $strSQL . "'Add New Exchange Rate', ";
		if ($rate != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($rate) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'exchangerates.php?PageNo=".$PageNo."&done=1'</script>";
		exit();
	}
	else if($e_action == "Edit")
	{
		
		$str = "UPDATE ".$tbname."_exchangerates SET ";
		
		if($fcurrencyid != "")
			$str = $str . "_fcurrencyid = '" . replaceSpecialChar($fcurrencyid) . "', ";
		else
			$str = $str . "_fcurrencyid = null, ";
			
		if($currencyid != "")
			$str = $str . "_currencyid = '" . replaceSpecialChar($currencyid) . "', ";
		else
			$str = $str . "_currencyid = null, ";	
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
		$strSQL = $strSQL . "'Edit Exchange Rate', ";
		if ($rate != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($rate) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);

		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'exchangerates.php?PageNo=".$PageNo."&done=2'</script>";
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
		
		$str = "SELECT DISTINCT _rate FROM ".$tbname."_exchangerates WHERE (" . $emailString . ") ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			while($rs = mysql_fetch_assoc($rst))
			{	
				$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
				$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
				$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
				$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
				$strSQL = $strSQL . "'Delete Exchange Rate', ";
				if ($rs["_rate"] != "")
				{
					$strSQL = $strSQL . "'" . replaceSpecialChar($rs["_rate"]) . "' ";
				}
				else
				{
					$strSQL = $strSQL . "null ";
				}
				$strSQL = $strSQL . ")";
				mysql_query($strSQL);				
			}
		}
		
		$str = "UPDATE ".$tbname."_exchangerates SET _status = '2' ";
		$str = $str . " WHERE (" . $emailString . ") ";
		mysql_query($str);			
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'exchangerates.php?done=3'</script>";
		exit();
	}
?>