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
	$oid = $_REQUEST['oid'];
	$removID = trim($_REQUEST['removID']);
	// echo '<pre>';print_r($_REQUEST);
	// echo '<pre>';print_r($_FILES);
	// die;
	$traningvenuename = replaceSpecialChar($_REQUEST['traningvenuename']);
	$venueownername = replaceSpecialChar($_REQUEST['ownername']);
	$venuecategory = replaceSpecialChar($_REQUEST['venuecategory']);
	$venuetype = replaceSpecialChar($_REQUEST['venuetype']);
	$cobankaccount = replaceSpecialChar($_REQUEST['cobankaccount']);
	$specialisedprogram = replaceSpecialChar($_REQUEST['specialisedprogram']);
	$memcommencDate = datepickerToMySQLDate($_REQUEST['memcommencDate']);
	$trainingvenuerefno = replaceSpecialChar($_REQUEST['trainingvenuerefno']);
	$amenitiesservice = replaceSpecialChar($_REQUEST['amenitiesservice']);
	$equipmentavailable = replaceSpecialChar($_REQUEST['equipmentavailable']);
	$venuepoc = replaceSpecialChar($_REQUEST['venuepoc']);
	$hpnopoc = replaceSpecialChar($_REQUEST['hpnopoc']);
	//$membershipstatus = replaceSpecialChar($_REQUEST['membershipstatus']);
	//$reasonforsuspension = replaceSpecialChar($_REQUEST['reasonforsuspension']);
	$status = replaceSpecialChar($_REQUEST['status']);
	$defaultvenue = replaceSpecialChar($_REQUEST['defaultvenue']);
	$venueaddress = replaceSpecialChar($_REQUEST['venueaddress']);
	$venuepostalcode = replaceSpecialChar($_REQUEST['venuepostalcode']);
	$capacity = replaceSpecialChar($_REQUEST['capacity']);
	$residentialaddress = replaceSpecialChar($_REQUEST['residentialaddress']);
	$venuedescription = replaceSpecialChar($_REQUEST['venuedescription']);
	$attFiles = $_FILES['attFile'];
	$ImageName =$_FILES['ImageName'];
	$file444 = replaceSpecialChar($_REQUEST['file444']);
		



	if($e_action == 'addnew')
	{
		$str = "INSERT INTO ".$tbname."_venues 
				(_VenueName,_TraningVenuNo,_OwnerID,_VenueCat,_VenueType,_CorporateBankAc,_SpecialisedProgram,_AmenitiesService,_EquipmentAvailable,_EmailvenuePoc,
				_HP,_ImageName,_Address,_PostalCode,_Capacity,_Description,_Status,_DefaultVenue,_CreatedBy,_CreatedDateTime,_UpdatedDateTime)
				VALUES(";
		
		if($traningvenuename != "") $str = $str . "'" . $traningvenuename . "', ";
		else $str = $str . "null, ";
		
		if($trainingvenuerefno != "") $str = $str . "'" . $trainingvenuerefno . "', ";
		else $str = $str . "null, ";
		
		if($venueownername != "") $str = $str . "'" . $venueownername . "', ";
		else $str = $str . "null, ";
		
		
		if($venuecategory != "") $str = $str . "'" . $venuecategory . "', ";
		else $str = $str . "null, ";

		if($venuetype != "") $str = $str . "'" . $venuetype . "', ";
		else $str = $str . "null, ";
		
		if($cobankaccount != "") $str = $str . "'" . $cobankaccount . "', ";
		else $str = $str . "null, ";
		
		if($specialisedprogram != "") $str = $str . "'" . $specialisedprogram . "', ";
		else $str = $str . "null, ";
		
		
		if($amenitiesservice != "") $str = $str . "'" . $amenitiesservice . "', ";
		else $str = $str . "null, ";

		if($equipmentavailable != "") $str = $str . "'" . $equipmentavailable . "', ";
		else $str = $str . "null, ";
		
		if($venuepoc != "") $str = $str . "'" . $venuepoc . "', ";
		else $str = $str . " null, ";
        
		if($hpnopoc != "") $str = $str . "'" . $hpnopoc . "', ";
		else $str = $str . "null, ";
		
	

		if($ImageName["name"][0] != "") $str = $str . "'" .  $ImageName["name"][0] . "', ";
		else $str = $str . "null, ";

	

		if($venueaddress != "") $str = $str . "'" . $venueaddress . "', ";
		else $str = $str . "null, ";

		if($venuepostalcode != "") $str = $str . "'" . $venuepostalcode . "', ";
		else $str = $str . "null, ";

		if($capacity != "") $str = $str . "'" . $capacity . "', ";
		else $str = $str . "null, ";

		if($venuedescription != "") $str = $str . "'" . $venuedescription . "', ";
		else $str = $str . "null, ";

		if($status != "") $str = $str . "'" . $status . "', ";
		else $str = $str . "null, ";

		
		if($defaultvenue != "") $str = $str . "'" . $defaultvenue . "', ";
		else $str = $str . "null, ";

        $str = $str . "'" . $_SESSION['userid'] . "', ";


		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		
		$str = $str . "'" . date("Y-m-d H:i:s") . "' ";
		
		$str = $str . ") ";
	
		mysql_query('SET NAMES utf8');
		//echo $str;
		//exit();
		
	
		$result = mysql_query($str) or die(mysql_error().$str);
		if($result==1)
		{
			$trainingvenuid = mysql_insert_id();
		}
		
		//Save files into table.
		$_pageid= $trainingvenuid;
		$_type = "I";
		include("savefiles.php");
		 
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add Traning Venue', ";
		
		if ($traningvenuename != "") $strSQL = $strSQL . "'" . replaceSpecialChar($traningvenuename) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'venue.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('1',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($trainingvenuid,$Encrypt)."'</script>";
		exit();
		
	}
    else if($e_action=='edit')
	{
		$str = "UPDATE ".$tbname."_venues SET ";
		
		if($traningvenuename != "") $str = $str . "_VenueName = '" . $traningvenuename . "', ";
		else $str = $str . "_VenueName = null, ";
	
		if($venuecategory != "") $str = $str . "_VenueCat = '" . $venuecategory . "', ";
		else $str = $str . "_VenueCat = null, ";
				
		if($venuetype != "") $str = $str . "_VenueType = '" . $venuetype . "', ";
		else $str = $str . "_VenueType = null, ";
				
		if($cobankaccount != "") $str = $str . "_CorporateBankAc =  '" . $cobankaccount . "', ";
		else $str = $str . "_CorporateBankAc =  null, ";
		
		if($specialisedprogram != "") $str = $str . "_SpecialisedProgram =  '" . $specialisedprogram . "', ";
		else $str = $str . "_SpecialisedProgram =  null, ";
		
		if($amenitiesservice != "") $str = $str . "_AmenitiesService = '" . $amenitiesservice . "', ";
		else $str = $str . "_AmenitiesService = null, ";
		
		if($equipmentavailable != "") $str = $str . "_EquipmentAvailable = '" . $equipmentavailable . "', ";
		else $str = $str . "_EquipmentAvailable = null, ";
		
		if($venuepoc != "") $str = $str . "_EmailvenuePoc = '" . $venuepoc . "', ";
		else $str = $str . "_EmailvenuePoc = null, ";
		
		if($hpnopoc != "") $str = $str . "_HP = '" . $hpnopoc . "', ";
		else $str = $str . "_HP = null, ";
		
		if($venueaddress != "") $str = $str . "_Address = '" . $venueaddress . "', ";
		else $str = $str . "_Address = null, ";

		if($venuepostalcode != "") $str = $str . "_PostalCode = '" . $venuepostalcode . "', ";
		else $str = $str . "_PostalCode = null, ";

		if($capacity != "") $str = $str . "_Capacity = '" . $capacity . "', ";
		else $str = $str . "_Capacity = null, ";

		if($venuedescription != "") $str = $str . "_Description = '" . $venuedescription . "', ";
		else $str = $str . "_Description = null, ";
	
		if($file444 == "") $str = $str . "_ImageName =  '" . $ImageName["name"][0]  . "', ";
		else $str = $str . "_ImageName =  '" . $file444  . "', ";


		if($status != "") $str = $str . "_Status = '" . $status . "', ";
		else $str = $str . "_Status = null, ";

        if($defaultvenue != "") $str = $str . "_DefaultVenue = '" . $defaultvenue . "', ";
		else $str = $str . "_DefaultVenue = null, ";
		
		$str = $str . "_UpdatedDateTime = '" . date("Y-m-d H:i:s") . "', ";
		$str = $str . "_UpdatedBy = '" . $_SESSION['userid'] . "' ";	
		
		$str = $str . " WHERE _ID = '".$id."' ";
		
		//echo $str;
		//exit();
		mysql_query('SET NAMES utf8');
		mysql_query($str) or die(mysql_error());
	
		//Save files into table.
		$_pageid= $id;
		$_type = "I";
		include("savefiles.php");
	
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Edit Traning Venue', ";
		
		if ($id != "") $strSQL = $strSQL . "'" . replaceSpecialChar($id) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
	
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'venue.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('2',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($id,$Encrypt)."&ownerno=".encrypt($trainingvenuerefno,$Encrypt)."'</script>";
		exit();
	}
   else if($e_action == 'delete')
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
		
		
		$str = "UPDATE ".$tbname."_venues SET _Status = 2 WHERE (" . $emailString . ") ";
	
		mysql_query($str);
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Delete Traing Venue', ";
		
		if ($emailString != "") $strSQL = $strSQL . "'" . replaceSpecialChar($emailString) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'trainingspace.php?ctab=".encrypt('1',$Encrypt)."&id=".encrypt($oid,$Encrypt)."&type=".encrypt($type,$Encrypt)."'</script>";
		exit();
    }

    if($e_action == 'deletefile')
     {

	$str = "UPDATE ".$tbname."_venues SET `_ImageName` = null WHERE `_ID` = '$removID'";
	
	mysql_query($str);

	include('../dbclose.php');
	echo "<script language='JavaScript'>alert('File Deleted'); window.opener.location.reload(); window.close();</script>";
	exit();
      }
?>