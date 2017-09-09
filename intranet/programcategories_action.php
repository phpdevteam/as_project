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
	$ProgramCategoryName = trim($_POST['ProgramCategoryName']);	
	$PageNo = $_POST['PageNo'];
	$type = $_REQUEST['type'];
	$Counts = trim($_POST["Counts"]);
	$_SESSION['user'];
	$removID = trim($_REQUEST['removID']);
	$status = $_REQUEST['status'];
	$communityID = $_REQUEST['communityID'];
	$ImageName =$_FILES['ImageName'];

    $file444 = replaceSpecialChar($_REQUEST['file444']);
	
//	exit();
	//var_dump($_REQUEST);
//	exit();
		
			
	if($e_action == "AddNew")
	{
		$str = "SELECT * FROM ".$tbname."_trainingprogramcat  WHERE _ProgramCatName = '". replaceSpecialChar($ProgramCategoryName) ."'";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = 'progcategories.php?type=".$type."&PageNo=".$PageNo."&error=1&ProgramCategoryName=".$ProgramCategoryName."'</script>";
			exit();
		}
		
		
		$str = "INSERT INTO ".$tbname."_trainingprogramcat (_ProgramCatName,_CommunityID,_ImageName, _SubmittedBy,_CreatedDateTime,_Status) VALUES(";
		if($ProgramCategoryName != "")
			$str = $str . "'" . replaceSpecialChar($ProgramCategoryName) . "', ";
		else
			$str = $str . "null, ";	
			
			if($communityID != "")
			$str = $str . "'" . replaceSpecialChar($communityID) . "', ";
		else
			$str = $str . "null, ";		
		
		if($ImageName["name"][0] != "") $str = $str . "'" .  $ImageName["name"][0] . "', ";
			else $str = $str . "null, ";

		$str = $str . "'" . $_SESSION['userid'] . "', ";	
		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		$str = $str . "'1') ";

      
		mysql_query($str);

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add New Program Category', ";
		if ($ProgramCategoryName != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($ProgramCategoryName) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'progcategories.php?type=".$type."&PageNo=".$PageNo."&done=1'</script>";
		exit();
	}
	else if($e_action == "Edit")
	{
		
		$str = "SELECT * FROM ".$tbname."_trainingprogramcat WHERE _ProgramCatName = '". replaceSpecialChar($ProgramCategoryName) ."'  and _ID <> '". $id ."' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = 'progcategories.php?type=".$type."&PageNo=".$PageNo."&id=". $id ."&error=1&VenueCategoryName=".$VenueCategoryName."'</script>";
			exit();
		}
		
		$str = "UPDATE ".$tbname."_trainingprogramcat SET ";
		if($ProgramCategoryName != "")
			$str = $str . "_ProgramCatName = '" . replaceSpecialChar($ProgramCategoryName) . "', ";
		else
			$str = $str . "_ProgramCatName = null, ";	

			if($communityID != "")
			$str = $str . "_CommunityID = '" . replaceSpecialChar($communityID) . "', ";
		else
			$str = $str . "_CommunityID = null, ";	
			
			if($file444 == "") $str = $str . "_ImageName =  '" . $ImageName["name"][0]  . "', ";
			else $str = $str . "_ImageName =  '" . $file444  . "', ";
			
		$str = $str . "_SubmittedBy = '" . $_SESSION['userid'] . "', ";	
		$str = $str . "_CreatedDateTime = '" . date("Y-m-d H:i:s") . "', ";				
			
			
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
		$strSQL = $strSQL . "'Edit Program Category', ";
		if ($ProgramCategoryName != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($ProgramCategoryName) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);

		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'progcategories.php?PageNo=".$PageNo."&done=2&type=".$type."'</script>";
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
		
		$str = "SELECT DISTINCT _ProgramCatName FROM ".$tbname."_trainingprogramcat WHERE (" . $emailString . ") ";
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
				$strSQL = $strSQL . "'Delete Program CategoryName', ";
				if ($rs["_ProgramCatName"] != "")
				{
					$strSQL = $strSQL . "'" . replaceSpecialChar($rs["_ProgramCatName"]) . "' ";
				}
				else
				{
					$strSQL = $strSQL . "null ";
				}
				$strSQL = $strSQL . ")";
				mysql_query($strSQL);				
			}
		}
		
		$str = "UPDATE ".$tbname."_trainingprogramcat SET _Status = '2' ";
		$str = $str . " WHERE (" . $emailString . ") ";
		mysql_query($str);	
	
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'progcategories.php?done=3&type=".$type."'</script>";
		exit();
		
	}


	if($e_action == 'deletefile')
	{

		$str = "UPDATE ".$tbname."_trainingprogramcat SET `_ImageName` = null WHERE `_ID` = '$removID'";
	
				
        mysql_query($str);

        include('../dbclose.php');
        echo "<script language='JavaScript'>alert('File Deleted'); window.opener.location.reload(); window.close();</script>";
		exit();
    }
?>