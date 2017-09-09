<?
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
	$cid = trim($_REQUEST['cid']);
	
	$PageNo = $_REQUEST['PageNo'];
	$type = $_REQUEST['type'];
	$DateTime = date("Y-m-d H:i:s");
	
	if($type  == 'uc'){
		$customerpagename = "contractor.php";
	}else if($type  == 'me'){
		$customerpagename = "member.php";
	}else
		$customerpagename = "customer.php";
	
	$notetypeid = replaceSpecialChar($_REQUEST['notetypeid']);
	$notetitle = replaceSpecialChar($_REQUEST['notetitle']);
	$subject = replaceSpecialChar($_REQUEST['notetitle']);
	$description = replaceSpecialChar($_REQUEST['description']);
	$date = datepickerToMySQLDateTime($_REQUEST['date']);
	
	
	if($e_action == 'addnew')
	{
		$str = "INSERT INTO ".$tbname."_correshistory 
				(_customerid,_notetypeid,_notetitle,_subject,_description,_date,_submittedby,_submitteddate)
				VALUES(";
		if($cid != "") $str = $str . "'" . $cid . "', ";
		else $str = $str . "null, ";
				
		if($notetypeid != "") $str = $str . "'" . $notetypeid . "', ";
		else $str = $str . "null, ";
		
		
		if($notetitle != "") $str = $str . "'" .$notetitle . "', ";
		else $str = $str . "null, ";
		
		if($subject != "") $str = $str . "'" .$subject . "', ";
		else $str = $str . "null, ";
		
		if($description != "") $str = $str . "'" . $description . "', ";
		else $str = $str . "null, ";
		
		if($date != "") $str = $str . "'" . $date . "', ";
		else $str = $str . "null, ";
		
		$str = $str . "'" . ($_SESSION['userid']) . "', ";
		$str = $str . "'" . ($DateTime) . "' ";
		
		$str = $str . ") ";
		
		mysql_query('SET NAMES utf8');
		$result = mysql_query($str);
				
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Customer > Add Corres Note', ";
		
		if ($description != "") $strSQL = $strSQL . "'" . replaceSpecialChar($description) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = '".$customerpagename."?ctab=".encrypt('2',$Encrypt)."&id=".encrypt($cid,$Encrypt)."&type=".encrypt($type,$Encrypt)."'</script>";
		exit();
		
	}else if($e_action=='edit')
	{
		
		$str = "UPDATE ".$tbname."_correshistory SET ";
		
		if($notetypeid != "") $str = $str . "_notetypeid = '" . $notetypeid . "', ";
		else $str = $str . "_notetypeid = null, ";
		
		if($notetitle != "") $str = $str . "_notetitle = '" . $notetitle . "', ";
		else $str = $str . "_notetitle = null, ";
		
		if($subject != "") $str = $str . "_subject = '" . $subject . "', ";
		else $str = $str . "_subject = null, ";
		
		if($description != "") $str = $str . "_description = '" . $description . "', ";
		else $str = $str . "_description = null, ";
		
		if($date != "") $str = $str . "_date =  '" . $date . "' ";
		else $str = $str . "_date =  null ";
		
		$str = $str . " WHERE _id = '".$id."' ";
		
		mysql_query('SET NAMES utf8');
		mysql_query($str) or die(mysql_error());
	
			
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Customer > Edit Corres Note', ";
		
		if ($description != "") $strSQL = $strSQL . "'" . replaceSpecialChar($description) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = '".$customerpagename."?ctab=".encrypt('2',$Encrypt)."&id=".encrypt($cid,$Encrypt)."&type=".encrypt($type,$Encrypt)."'</script>";
		exit();
	}else if($e_action == 'delete')
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
		
		
		$str = "DELETE FROM ".$tbname."_correshistory  WHERE (" . $emailString . ") ";
		
		mysql_query($str);
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Customer > Delete Corres Note', ";
		
		if ($description != "") $strSQL = $strSQL . "'" . replaceSpecialChar($description) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = '".$customerpagename."?ctab=".encrypt('2',$Encrypt)."&id=".encrypt($cid,$Encrypt)."&type=".encrypt($type,$Encrypt)."'</script>";
		exit();
	}
?>