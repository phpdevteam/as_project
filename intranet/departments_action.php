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
	$Department = trim($_REQUEST['DepartmentName']);	
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
		$str = "SELECT * FROM ".$tbname."_departments WHERE _departmentname = '". replaceSpecialChar($Department) ."' and _status = 1 ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = 'departments.php?PageNo=".$PageNo."&error=1&CountryName=".$Department."'</script>";
			exit();
		}
		
		$str = "INSERT INTO ".$tbname."_departments (_departmentname, _subdate, _subby, _status) VALUES(";
		if($Department != "")
			$str = $str . "'" . replaceSpecialChar($Department) . "', ";
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
		$strSQL = $strSQL . "'Add New Country', ";
		if ($Department != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($Department) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'departments.php?PageNo=".$PageNo."&done=1'</script>";
		exit();
	}
	else if($e_action == "Edit")
	{
		
		$str = "UPDATE ".$tbname."_departments SET ";
		if($Department != "")
			$str = $str . "_departmentname = '" . replaceSpecialChar($Department) . "', ";
		else
			$str = $str . "_departmentname = null, ";					
		$str = $str . "_subdate = '" . replaceSpecialChar($subdate) . "', ";
		$str = $str . "_subby = '" . replaceSpecialChar($subby) . "', ";	
		$str = $str . "_status = '" . replaceSpecialChar($status) . "' ";	
		$str = $str . "WHERE _id = '".$id."' ";
		mysql_query($str);

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . replaceSpecialChar($subby) . "', ";
		$strSQL = $strSQL . "'" . replaceSpecialChar($subip) . "', ";
		$strSQL = $strSQL . "'" . replaceSpecialChar($subdate) . "', ";
		$strSQL = $strSQL . "'Edit Departments', ";
		if ($Department != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($Department) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);

		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'departments.php?PageNo=".$PageNo."&done=2'</script>";
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
		
		$str = "SELECT DISTINCT _departmentname FROM ".$tbname."_departments WHERE (" . $emailString . ") ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			while($rs = mysql_fetch_assoc($rst))
			{	
				$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
				$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
				$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
				$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
				$strSQL = $strSQL . "'Delete Departments', ";
				if ($rs["_departmentname"] != "")
				{
					$strSQL = $strSQL . "'" . replaceSpecialChar($rs["_departmentname"]) . "' ";
				}
				else
				{
					$strSQL = $strSQL . "null ";
				}
				$strSQL = $strSQL . ")";
				mysql_query($strSQL);				
			}
		}
		
		$str = "UPDATE ".$tbname."_departments SET _status = '2' ";
		$str = $str . " WHERE (" . $emailString . ") ";
		mysql_query($str);			
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'departments.php?done=3'</script>";
		exit();
	}
?>