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
	$e_action12 = $_REQUEST['action12'];
	$id = trim($_REQUEST['id']);
	$PageNo = $_REQUEST['PageNo'];
	$DateTime = date("Y-m-d H:i:s");
	
	// echo '<pre>';print_r($_REQUEST);
	// echo '<pre>';print_r($_FILES);
	// die;
	$programname = replaceSpecialChar($_REQUEST['programname']);
	$ProCatID = replaceSpecialChar($_REQUEST['ProCatID']);
	$checkprotype = replaceSpecialChar($_REQUEST['chkPassPort1']);
	$trainerID = replaceSpecialChar($_REQUEST['trainerID']);
	$programtypeID = replaceSpecialChar($_REQUEST['programtypeID']);
	$programsubtypeID = replaceSpecialChar($_REQUEST['programsubtypeID']);
	$programsubsubtypeID = replaceSpecialChar($_REQUEST['programsubsubtypeID']);
	$maxperson = replaceSpecialChar($_REQUEST['maxperson']);
	//$shower = replaceSpecialChar($_REQUEST['shower']);
	//$towel = replaceSpecialChar($_REQUEST['towel']);
	//$premiumgym = replaceSpecialChar($_REQUEST['premiumgym']);
//	$loadedmvtcharge = replaceSpecialChar($_REQUEST['loadedmvtcharge']);
	$amount = replaceSpecialChar($_REQUEST['amount']);
	$maxtrinerfeesurcharge = replaceSpecialChar($_REQUEST['maxtrinerfeesurcharge']);
	$maxvenuefeesurcharge = replaceSpecialChar($_REQUEST['maxvenuefeesurcharge']);

	$description = replaceSpecialChar($_REQUEST['description']);
	$programduration = replaceSpecialChar($_REQUEST['programduration']);
	$programno = replaceSpecialChar($_REQUEST['programno']);
	$status = replaceSpecialChar($_REQUEST['status']);
    $progstatus = replaceSpecialChar($_REQUEST['progstatus']);
    $startdate = replaceSpecialChar($_REQUEST['startdate']);
	$enddate = replaceSpecialChar($_REQUEST['enddate']);
	$programdate = datepickerToMySQLDate($_REQUEST['programdate']);

	$needcertificate = replaceSpecialChar($_REQUEST['needcertificate']);
	$certificateremark = replaceSpecialChar($_REQUEST['certificateremark']);

//program details field
	$uniqueexperience = replaceSpecialChar($_REQUEST['uniqueexperience']);
	$fitnessoutcome = replaceSpecialChar($_REQUEST['fitnessoutcome']);
	$trainingduration = replaceSpecialChar($_REQUEST['trainingduration']);
	$background = replaceSpecialChar($_REQUEST['background']);
	$specialcharateristic = replaceSpecialChar($_REQUEST['specialcharateristic']);
	$programsynopsis = replaceSpecialChar($_REQUEST['programsynopsis']);
	$equipmentused = replaceSpecialChar($_REQUEST['equipmentused']);
	$address = replaceSpecialChar($_REQUEST['address']);
	$landmark = replaceSpecialChar($_REQUEST['landmark']);
	$publictransport = replaceSpecialChar($_REQUEST['publictransport']);
	$carpark = replaceSpecialChar($_REQUEST['carpark']);
	$amenitiesoftrainingvenue = replaceSpecialChar($_REQUEST['amenitiesoftrainingvenue']);
	$preparations = replaceSpecialChar($_REQUEST['preparations']);
	
	
	//delete in table value data  as_programpricing table
    if($e_action12 =='delete1')
	{	

		   $emailString1 = "";
		   
	       $cntCheck1 = $_POST["cntCheck1"];
		  for ($i=1; $i<=$cntCheck1; $i++)
		{
			if ($_POST["CustCheckboxq".$i] != "")
			{
				$emailString1 = $emailString1 . "_ID = '" . $_POST["CustCheckboxq".$i] . "' OR ";
				
			}
        }
       
		$emailString1 = substr($emailString1, 0, strlen($emailString1)-4);
		$str = "UPDATE ".$tbname."_programpricing SET _Status = 2 WHERE (" . $emailString1 . ") ";
		mysql_query($str);

		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'program.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('2',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($id,$Encrypt)."'</script>";
		exit();
	}

if($e_action == 'addnew')
{
		$str = "INSERT INTO ".$tbname."_trainingprogram 
				(_ProgramName,_ProgramRefID,_ProgramCatID,_IsFitnessExperience,_TrainerID,_TrainingTypeID,_TrainingSubTypeID,_TrainingSubSubTypeID,_MaxPerson,_MaxTrainerfeeSurcharge,_MaxVenuefeeSurcharge,_ProgramDuration,_NeedCertificates,_CertificateRemarks,_TotalAmount,_ProgramDescr,_Status,
                _CreatedDateTime,_CreatedBy,_UpdatedDateTime)
				VALUES(";
		
		if($programname != "") $str = $str . "'" . $programname . "', ";
		else $str = $str . "null, ";
		
		if($programno != "") $str = $str . "'" . $programno . "', ";
		else $str = $str . "null, ";
		
		if($ProCatID != "") $str = $str . "'" . $ProCatID . "', ";
		else $str = $str . "null, ";
		
		if($checkprotype != "") $str = $str . "'" . $checkprotype . "', ";
		else $str = $str . "null, ";

		if($trainerID != "") $str = $str . "'" . $trainerID . "', ";
		else $str = $str . "null, ";

		if($programtypeID != "") $str = $str . "'" . $programtypeID . "', ";
		else $str = $str . "null, ";

		
		if($programsubtypeID != "") $str = $str . "'" . $programsubtypeID . "', ";
		else $str = $str . "null, ";

		
		if($programsubsubtypeID != "") $str = $str . "'" . $programsubsubtypeID . "', ";
		else $str = $str . "null, ";

		if($maxperson != "") $str = $str . "'" . $maxperson . "', ";
		else $str = $str . "null, ";

		if($maxtrinerfeesurcharge != "") $str = $str . "'" . $maxtrinerfeesurcharge . "', ";
		else $str = $str . "null, ";

		if($maxvenuefeesurcharge != "") $str = $str . "'" . $maxvenuefeesurcharge . "', ";
		else $str = $str . "null, ";

		if($programduration != "") $str = $str . "'" . $programduration . "', ";
		else $str = $str . "null, ";

		if($needcertificate != "") $str = $str . "'" . $needcertificate . "', ";
		else $str = $str . "null, ";

		if($certificateremark != "") $str = $str . "'" . $certificateremark . "', ";
		else $str = $str . "null, ";

		
		if($amount != "") $str = $str . "'" . $amount . "', ";
		else $str = $str . "null, ";
		
		if($description != "") $str = $str . "'" . $description . "', ";
		else $str = $str . "null, ";
		
		if($status != "") $str = $str . "'" . $status . "', ";
		else $str = $str . "null, ";
		
		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		$str = $str . "'" . $_SESSION['userid'] . "', ";
		$str = $str . "'" . date("Y-m-d H:i:s") . "' ";
		
		$str = $str . ") ";
	
		mysql_query('SET NAMES utf8');

		
		$result = mysql_query($str) or die(mysql_error().$str);
		if($result==1)
		{
			$programid = mysql_insert_id();
		}


		$str = "INSERT INTO ".$tbname."_trainingprogramdetails 
		(_TrainingProgramID,_UniqueExperience,_FitnessOutcome,_TrainingDuration,_TrainerBackground,_TrainerSpecificCharacteristic,_ProgramSynopsis,_EquipmentUsed,_Address,_Landmark,_PublicTransport,_Carpark,_Amenities,_PreparationRequired,
		_CreatedDateTime)
		VALUES(";

		if($programid != "") $str = $str . "'" . $programid . "', ";
		else $str = $str . "null, ";

		if($uniqueexperience != "") $str = $str . "'" . $uniqueexperience . "', ";
		else $str = $str . "null, ";
	   
		if($fitnessoutcome != "") $str = $str . "'" . $fitnessoutcome . "', ";
		else $str = $str . "null, ";

		if($trainingduration != "") $str = $str . "'" . $trainingduration . "', ";
		else $str = $str . "null, ";

		if($background != "") $str = $str . "'" . $background . "', ";
		else $str = $str . "null, ";

		if($specialcharateristic != "") $str = $str . "'" . $specialcharateristic . "', ";
		else $str = $str . "null, ";

		if($programsynopsis != "") $str = $str . "'" . $programsynopsis . "', ";
		else $str = $str . "null, ";

		if($equipmentused != "") $str = $str . "'" . $equipmentused . "', ";
		else $str = $str . "null, ";

		if($address != "") $str = $str . "'" . $address . "', ";
		else $str = $str . "null, ";

		if($landmark != "") $str = $str . "'" . $landmark . "', ";
		else $str = $str . "null, ";

		if($publictransport != "") $str = $str . "'" . $publictransport . "', ";
		else $str = $str . "null, ";

		if($carpark != "") $str = $str . "'" . $carpark . "', ";
		else $str = $str . "null, ";

		if($amenitiesoftrainingvenue != "") $str = $str . "'" . $amenitiesoftrainingvenue . "', ";
		else $str = $str . "null, ";

		if($preparations != "") $str = $str . "'" . $preparations . "', ";
		else $str = $str . "null, ";

		$str = $str . "'" . date("Y-m-d H:i:s") . "' ";
		
		$str = $str . ") ";

	
		mysql_query('SET NAMES utf8');

		
		$result = mysql_query($str) or die(mysql_error().$str);




// insert data in as_trainingprogramaggregation table


/*$str = "INSERT INTO ".$tbname."_trainingprogramaggregation 
		(_ProgramID,_TrainerID,_ShowerCharge,_TowelCharge,_PremiumGymCharge,_LoadedMVTCharge,_IPAddress,_Status,_CreatedDateTime,_UpdatedDateTime)
		VALUES(";

			if($programid != "") $str = $str . "'" . $programid . "', ";
			else $str = $str . "null, ";

			if($trainerID != "") $str = $str . "'" . $trainerID . "', ";
			else $str = $str . "null, ";

			if($shower != "") $str = $str . "'" . $shower . "', ";
			else $str = $str . "null, ";

			
			if($towel != "") $str = $str . "'" . $towel . "', ";
			else $str = $str . "null, ";

			if($premiumgym != "") $str = $str . "'" . $premiumgym . "', ";
			else $str = $str . "null, ";

			
			if($loadedmvtcharge != "") $str = $str . "'" . $loadedmvtcharge . "', ";
			else $str = $str . "null, ";

			$str = $str . "'" . $_SERVER['REMOTE_ADDR'] . "', ";

			if($status != "") $str = $str . "'" . $status . "', ";
			else $str = $str . "null, ";

			$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
	
			$str = $str . "'" . date("Y-m-d H:i:s") . "' ";
			
			$str = $str . ") ";
		
			mysql_query('SET NAMES utf8');
	
			
			$result = mysql_query($str) or die(mysql_error().$str);*/

			$srno_array[]       = $_REQUEST['srno'];
			$minimum_array[]   = $_REQUEST['minimum'];
			$institution_array[] = $_REQUEST['maximum'];
			$price_array[]       = $_REQUEST['price'];
			$nsmanprice_array[] = $_REQUEST['nsmanprice'];

//add data of child table of  as_programpricing
		
			for ($i = 0; $i < count($_REQUEST['minimum']); $i++) {
	
			$str = "INSERT INTO ".$tbname."_programpricing(_ProgramID,_Min,_Max,_Price,_NsmanPrice,_Status,_CreatedDateTime,_UpdatedDateTime) VALUES (";
	
			if($programid != "") $str = $str . "'" . $programid . "', ";
			else $str = $str . "null, ";
	
	
			if($_REQUEST['minimum'][$i] != "") $str = $str . "'" . $_REQUEST['minimum'][$i] . "', ";
			else $str = $str . "null, ";
		
			if($_REQUEST['maximum'][$i] != "") $str = $str . "'" .$_REQUEST['maximum'][$i] . "', ";
			else $str = $str . "null, ";
	
			if($_REQUEST['price'][$i] != "") $str = $str . "'" .$_REQUEST['price'][$i] . "', ";
			else $str = $str . "null, ";

			if($_REQUEST['nsmanprice'][$i] != "") $str = $str . "'" .$_REQUEST['nsmanprice'][$i] . "', ";
			else $str = $str . "null, ";
	
			$str = $str . "'1',";
	
			$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
			
			$str = $str . "'" . date("Y-m-d H:i:s") . "' ";
			
			$str = $str . ")";
	
		mysql_query('SET NAMES utf8');
		$result = mysql_query($str) or die(mysql_error().$str);

			}

		//Save files into table.
		$_pageid= $programid;
		$_type = "I";
		include("savefiles.php");
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add Program', ";
		
		if ($programname != "") $strSQL = $strSQL . "'" . replaceSpecialChar($programname) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'program.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('1',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($programid,$Encrypt)."'</script>";
		exit();
		
	}
	else if($e_action=='edit')
	{
		$str = "UPDATE ".$tbname."_trainingprogram SET ";
		
		if($programname != "") $str = $str . "_ProgramName = '" . $programname . "', ";
		else $str = $str . "_ProgramName = null, ";
				
		if($ProCatID != "") $str = $str . "_ProgramCatID = '" . $ProCatID . "', ";
		else $str = $str . "_ProgramCatID = null, ";
		
		if($checkprotype != "") $str = $str . "_IsFitnessExperience = '" . $checkprotype . "', ";
		else $str = $str . "_IsFitnessExperience = null, ";

		if($trainerID != "") $str = $str . "_TrainerID = '" . $trainerID . "', ";
		else $str = $str . "_TrainerID = null, ";

		if($programtypeID != "") $str = $str . "_TrainingTypeID = '" . $programtypeID . "', ";
		else $str = $str . "_TrainingTypeID = null, ";

		if($programsubtypeID != "") $str = $str . "_TrainingSubTypeID = '" . $programsubtypeID . "', ";
		else $str = $str . "_TrainingSubTypeID = null, ";

		if($programsubsubtypeID != "") $str = $str . "_TrainingSubSubTypeID = '" . $programsubsubtypeID . "', ";
		else $str = $str . "_TrainingSubSubTypeID = null, ";
	
		if($amount != "") $str = $str . "_TotalAmount = '" . $amount . "', ";
		else $str = $str . "_TotalAmount = null, ";

		if($maxperson != "") $str = $str . "_MaxPerson = '" . $maxperson . "', ";
		else $str = $str . "_MaxPerson = null, ";

		if($maxtrinerfeesurcharge != "") $str = $str . "_MaxTrainerfeeSurcharge = '" . $maxtrinerfeesurcharge . "', ";
		else $str = $str . "_MaxTrainerfeeSurcharge = null, ";

		if($maxvenuefeesurcharge != "") $str = $str . "_MaxVenuefeeSurcharge = '" . $maxvenuefeesurcharge . "', ";
		else $str = $str . "_MaxVenuefeeSurcharge = null, ";

		
		if($programduration != "") $str = $str . "_ProgramDuration = '" . $programduration . "', ";
		else $str = $str . "_ProgramDuration = null, ";

		if($needcertificate != "") $str = $str . "_NeedCertificates = '" . $needcertificate . "', ";
		else $str = $str . "_NeedCertificates = null, ";

		if($certificateremark != "") $str = $str . "_CertificateRemarks = '" . $certificateremark . "', ";
		else $str = $str . "_CertificateRemarks = null, ";



		if($description != "") $str = $str . "_ProgramDescr =  '" . $description . "', ";
		else $str = $str . "_ProgramDescr =  null, ";
		
		if($status != "") $str = $str . "_Status =  '" . $status . "', ";
		else $str = $str . "_Status =  null, ";
	
		$str = $str . "_UpdatedDateTime = '" . date("Y-m-d H:i:s") . "' ";
		
		$str = $str . " WHERE _ID = '".$id."' ";

		mysql_query('SET NAMES utf8');
		mysql_query($str) or die(mysql_error());



		$str = "UPDATE ".$tbname."_trainingprogramdetails SET ";
		
		if($uniqueexperience != "") $str = $str . "_UniqueExperience = '" . $uniqueexperience . "', ";
		else $str = $str . "_UniqueExperience = null, ";
				
		if($fitnessoutcome != "") $str = $str . "_FitnessOutcome = '" . $fitnessoutcome . "', ";
		else $str = $str . "_FitnessOutcome = null, ";

		if($trainingduration != "") $str = $str . "_TrainingDuration = '" . $trainingduration . "', ";
		else $str = $str . "_TrainingDuration = null, ";

		if($background != "") $str = $str . "_TrainerBackground = '" . $background . "', ";
		else $str = $str . "_TrainerBackground = null, ";

		if($specialcharateristic != "") $str = $str . "_TrainerSpecificCharacteristic = '" . $specialcharateristic . "', ";
		else $str = $str . "_TrainerSpecificCharacteristic = null, ";


		if($programsynopsis != "") $str = $str . "_ProgramSynopsis = '" . $programsynopsis . "', ";
		else $str = $str . "_ProgramSynopsis = null, ";

		if($equipmentused != "") $str = $str . "_EquipmentUsed = '" . $equipmentused . "', ";
		else $str = $str . "_EquipmentUsed = null, ";

		if($address != "") $str = $str . "_Address = '" . $address . "', ";
		else $str = $str . "_Address = null, ";

		if($landmark != "") $str = $str . "_Landmark = '" . $landmark . "', ";
		else $str = $str . "_Landmark = null, ";

		if($publictransport != "") $str = $str . "_PublicTransport = '" . $publictransport . "', ";
		else $str = $str . "_PublicTransport = null, ";

		if($carpark != "") $str = $str . "_Carpark = '" . $carpark . "', ";
		else $str = $str . "_Carpark = null, ";


		if($amenitiesoftrainingvenue != "") $str = $str . "_Amenities = '" . $amenitiesoftrainingvenue . "', ";
		else $str = $str . "_Amenities = null, ";

		if($preparations != "") $str = $str . "_PreparationRequired = '" . $preparations . "' ";
		else $str = $str . "_PreparationRequired = null ";

		$str = $str . " WHERE _TrainingProgramID = '".$id."' ";
		

	
		mysql_query('SET NAMES utf8');
		mysql_query($str) or die(mysql_error());


	
// update data in as_trainingprogramaggregation table

	/*	$str = "UPDATE ".$tbname."_trainingprogramaggregation SET ";
		
		if($trainerID != "") $str = $str . "_TrainerID = '" . $trainerID . "', ";
		else $str = $str . "_TrainerID = null, ";
				
		if($shower != "") $str = $str . "_ShowerCharge = '" . $shower . "', ";
		else $str = $str . "_ShowerCharge = null, ";
		
		if($towel != "") $str = $str . "_TowelCharge = '" . $towel . "', ";
		else $str = $str . "_TowelCharge = null, ";

		if($premiumgym != "") $str = $str . "_PremiumGymCharge =  '" . $premiumgym . "', ";
		else $str = $str . "_PremiumGymCharge =  null, ";

		if($loadedmvtcharge != "") $str = $str . "_LoadedMVTCharge =  '" . $loadedmvtcharge . "', ";
		else $str = $str . "_LoadedMVTCharge =  null, ";
	
		if($status != "") $str = $str . "_Status =  '" . $status . "', ";
		else $str = $str . "_Status =  null, ";
	
		$str = $str . "_UpdatedDateTime = '" . date("Y-m-d H:i:s") . "' ";
		
		$str = $str . " WHERE _ProgramID = '".$id."' ";
		//echo $str;
		//exit();
		mysql_query('SET NAMES utf8');
		mysql_query($str) or die(mysql_error());*/
	
		//delete data in as_programpricing table
		$sql = "DELETE FROM ".$tbname."_programpricing WHERE _ProgramID=$id AND `_Status` NOT IN ('2') ";
		mysql_query('SET NAMES utf8');
		$result = mysql_query($sql) or die(mysql_error().$sql);


	//add data of child table of  as_programpricing
	$srno_array[]    = $_REQUEST['srno'];
	$minimum_array[] = $_REQUEST['minimum'];
	$institution_array[] = $_REQUEST['maximum'];
	$price_array[] = $_REQUEST['price'];
	$nsmanprice_array[] = $_REQUEST['nsmanprice'];


//update data of child table of  as_programpricing

		for ($i = 0; $i < count($_REQUEST['minimum']); $i++) {

		$str = "INSERT INTO ".$tbname."_programpricing(_ProgramID,_Min,_Max,_Price,_NsmanPrice,_Status,_CreatedDateTime,_UpdatedDateTime) VALUES (";

		if($id != "") $str = $str . "'" . $id . "', ";
		else $str = $str . "null, ";

		if($_REQUEST['minimum'][$i] != "") $str = $str . "'" . $_REQUEST['minimum'][$i] . "', ";
		else $str = $str . "null, ";

		if($_REQUEST['maximum'][$i] != "") $str = $str . "'" .$_REQUEST['maximum'][$i] . "', ";
		else $str = $str . "null, ";

		if($_REQUEST['price'][$i] != "") $str = $str . "'" .$_REQUEST['price'][$i] . "', ";
		else $str = $str . "null, ";

		if($_REQUEST['nsmanprice'][$i] != "") $str = $str . "'" .$_REQUEST['nsmanprice'][$i] . "', ";
		else $str = $str . "null, ";

		$str = $str . "'1',";

		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";

		$str = $str . "'" . date("Y-m-d H:i:s") . "' ";

		$str = $str . ")";

		mysql_query('SET NAMES utf8');
		$result = mysql_query($str) or die(mysql_error().$str);

		}


		//Save files into table.
		$_pageid= $id;
		$_type = "I";
		include("savefiles.php");
	
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Edit Program', ";
		
		if ($id != "") $strSQL = $strSQL . "'" . replaceSpecialChar($id) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
	
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'program.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('2',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($id,$Encrypt)."'</script>";
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
		$str = "UPDATE ".$tbname."_trainingprogram SET _Status = 2 WHERE (" . $emailString . ") ";
	
		mysql_query($str);
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Delete Program', ";
		
		if ($emailString != "") $strSQL = $strSQL . "'" . replaceSpecialChar($emailString) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'programs.php?PageNo=".$PageNo."&done=3'</script>";
		exit();
	}

?>