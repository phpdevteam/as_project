<?
session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
		exit();
	}
	include('../global.php');	
	include('../include/functions.php');
	include('access_rights_function.php'); 
    include("fckeditor/fckeditor.php");
	$e_action = $_REQUEST['e_action'];
	$id = trim($_REQUEST['id']);
	$PageNo = $_REQUEST['PageNo'];
	$DateTime = date("Y-m-d H:i:s");
	
	// echo '<pre>';print_r($_REQUEST);die;
	$ownertitle = replaceSpecialChar($_REQUEST['ownertitle']);
	$ownername  = replaceSpecialChar($_REQUEST['ownername']);
	$nric       = replaceSpecialChar($_REQUEST['nric']);
	$email      = replaceSpecialChar($_REQUEST['email']);
	$hp         = replaceSpecialChar($_REQUEST['hp']);
	$memcommencDate = datepickerToMySQLDate($_REQUEST['memcommencDate']);
	$trainingvenuerefno = replaceSpecialChar($_REQUEST['trainingvenuerefno']);
	$address   = replaceSpecialChar($_REQUEST["address"]);
	$status    = replaceSpecialChar($_REQUEST['status']);
	$membershipstatus    = replaceSpecialChar($_REQUEST['membershipstatus']);
	$reasonforsuspension    = replaceSpecialChar($_REQUEST['reasonforsuspension']);
	

	
if($e_action == 'addnew')
	{
		
		
		$str = "INSERT INTO ".$tbname."_venueowners 
		(_VenueRefNo,_Ownertitle,_FullName,_Nric,_Email,_HP,_MembershipCommenceDate,_Address,_MembershipStatus,_ReasonForSuspensionDelist,_CreatedBy,_CreatedDateTime)VALUES(";
		
		if($trainingvenuerefno != "") $str = $str . "'" . $trainingvenuerefno . "', ";
		else $str = $str . "null, ";
		
		if($ownertitle != "") $str = $str . "'" . $ownertitle . "', ";
		else $str = $str . "null, ";
		
		if($ownername != "") $str = $str . "'" . $ownername . "', ";
		else $str = $str . "null, ";
		
		
		if($nric != "") $str = $str . "'" . $nric . "', ";
		else $str = $str . "null, ";
		
		if($email != "") $str = $str . "'" . $email . "', ";
		else $str = $str . "null, ";
		
		if($hp != "") $str = $str . "'" . $hp . "', ";
		else $str = $str . "null, ";
		
		if($memcommencDate != "") $str = $str . "'" . $memcommencDate . "', ";
		else $str = $str . "null, ";
		
		if($address != "") $str = $str . "'" . $address . "', ";
		else $str = $str . "null, ";

		if($membershipstatus != "") $str = $str . "'" . $membershipstatus . "', ";
		else $str = $str . "null, ";

		if($reasonforsuspension != "") $str = $str . "'" . $reasonforsuspension . "', ";
		else $str = $str . "null, ";

		$str = $str . "'" . $_SESSION['userid'] . "', ";

		$str = $str . "'" . date("Y-m-d H:i:s") . "'";
		$str = $str . ") ";
	
		mysql_query('SET NAMES utf8');
	
		
		$result = mysql_query($str) or die(mysql_error());
                if($result==1)
                {
                    $trainerownerid = mysql_insert_id();
                }
				
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add OwnerName', ";
		
		if ($ownername != "") $strSQL = $strSQL . "'" . replaceSpecialChar($ownername) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'trainingspace.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('1',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($trainerownerid,$Encrypt)."'</script>";
		exit();
		
}else if($e_action=='edit')
{
	
		$str = "UPDATE ".$tbname."_venueowners SET ";
		
		if($trainingvenuerefno != "") $str = $str . "_VenueRefNo = '" . $trainingvenuerefno . "', ";
		else $str = $str . "_VenueRefNo = null, ";
				
		if($ownertitle != "") $str = $str . "_Ownertitle =  '" . $ownertitle . "', ";
		else $str = $str . "_Ownertitle =  null, ";
		
		if($ownername != "") $str = $str . "_FullName =  '" . $ownername . "', ";
		else $str = $str . "_FullName =  null, ";
		
		if($nric != "") $str = $str . "_Nric =  '" . $nric . "', ";
		else $str = $str . "_Nric =  null, ";
		
		if($email != "") $str = $str . "_Email = '" . $email . "', ";
		else $str = $str . "_Email = null, ";
		
		if($hp != "") $str = $str . "_HP = '" . $hp . "', ";
		else $str = $str . "_HP = null, ";
		
		
		if($memcommencDate != "") $str = $str . "_MembershipCommenceDate = '" . $memcommencDate . "', ";
		else $str = $str . "_MembershipCommenceDate = null, ";
		
		if($address != "") $str = $str . "_Address = '" . $address . "', ";
		else $str = $str . "_Address = null, ";

		if($membershipstatus != "") $str = $str . "_MembershipStatus = '" . $membershipstatus . "', ";
		else $str = $str . "_MembershipStatus = null, ";
	
		if($reasonforsuspension != "") $str = $str . "_ReasonForSuspensionDelist = '" . $reasonforsuspension . "', ";
		else $str = $str . "_ReasonForSuspensionDelist = null, ";
	
	
		if($status != "") $str = $str . "_Status = '" . $status . "', ";
		else $str = $str . "_Status = null, ";
	

		$str = $str . "_UpdatedDateTime = '" . date("Y-m-d H:i:s") . "', ";
		$str = $str . "_UpdatedBy = '" . $_SESSION['userid'] . "' ";	
		
		$str = $str . " WHERE _ID = '".$id."' ";
		
		//echo $str;
	//exit();
		mysql_query('SET NAMES utf8');
		mysql_query($str) or die(mysql_error());
	
			
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Edit OwnerName', ";
		
		if ($ownername != "") $strSQL = $strSQL . "'" . replaceSpecialChar($ownername) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
	
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'trainingspace.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('2',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($id,$Encrypt)."'</script>";
		exit();
}else if($e_action == 'delete')
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
		
		
		$str = "UPDATE ".$tbname."_venueowners SET _Status = 2 WHERE (" . $emailString . ") ";
	
		mysql_query($str);
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Delete OwnerName', ";
		
		if ($ownername != "") $strSQL = $strSQL . "'" . replaceSpecialChar($ownername) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'trainingspaces.php?PageNo=".$PageNo."&done=3'</script>";
		exit();
}
?>