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
    $e_action12 = $_REQUEST['action12'];
    $e_action22 = $_REQUEST['action22'];
	$checkbox2 = $_REQUEST['checkbox2'];


	// echo '<pre>';print_r($_REQUEST);
	// echo '<pre>';print_r($_FILES);
	// die;
	$trainertitle = replaceSpecialChar($_REQUEST['trainertitle']);
	$trainername = replaceSpecialChar($_REQUEST['trainername']);
	$nameinchinese = replaceSpecialChar($_REQUEST['nameinchinese']);
	$trainercatID = replaceSpecialChar($_REQUEST['trainercategory']);
	$nricfin = replaceSpecialChar($_REQUEST['nricfin']);
	$occupation = replaceSpecialChar($_REQUEST['occupation']);
	$nationality = replaceSpecialChar($_REQUEST['nationality']);
	$dob= datepickerToMySQLDate($_REQUEST['dob']);
	$cofbirth = replaceSpecialChar($_REQUEST['cofbirth']);
	$sex = replaceSpecialChar($_REQUEST['sex']);
	$maritalstatus = replaceSpecialChar($_REQUEST['maritalstatus']);
	$finno = replaceSpecialChar($_REQUEST['finno']);
	$expirtdate = datepickerToMySQLDate($_REQUEST['expirtdate']);
	$race = replaceSpecialChar($_REQUEST['race']);
	$raceofother = replaceSpecialChar($_REQUEST['raceofother']);
	$typeofpass = replaceSpecialChar($_REQUEST['typeofpass']);
	$trainerno = replaceSpecialChar($_REQUEST['trainerno']);
	$status = replaceSpecialChar($_REQUEST['status']);
	$residentialaddress = replaceSpecialChar($_REQUEST['residentialaddress']);
	$postalcode = replaceSpecialChar($_REQUEST['postalcode']);
	$hometelno = replaceSpecialChar($_REQUEST['hometelno']);
	$handphone = replaceSpecialChar($_REQUEST['handphone']);
	$email = replaceSpecialChar($_REQUEST['email']);
	$bankname = replaceSpecialChar($_REQUEST['bankname']);
	$accountname = replaceSpecialChar($_REQUEST['accountname']);
	$accountnumber = replaceSpecialChar($_REQUEST['accountnumber']);
	$employername = replaceSpecialChar($_REQUEST['employername']);
	$addressofemployer = replaceSpecialChar($_REQUEST['addressofemployer']);
	$employerpostalcode = replaceSpecialChar($_REQUEST['employerpostalcode']);
	$employertelno = replaceSpecialChar($_REQUEST['employertelno']);
	$employerfaxno = replaceSpecialChar($_REQUEST['employerfaxno']);
   // $fitcertiname_array = $_REQUEST['fitcertiname'];
  // $filecount = count($fitcertiname_array);
   $selfprofile = replaceSpecialChar($_REQUEST['selfprofile']);

    $MpDeclaration1 = replaceSpecialChar($_REQUEST['MpDeclaration1']);
	$MpDeclaration2 = replaceSpecialChar($_REQUEST['MpDeclaration2']);
	$MpDeclaration3 = replaceSpecialChar($_REQUEST['MpDeclaration3']);
	$MpDeclaration4 = replaceSpecialChar($_REQUEST['MpDeclaration4']);
	$AnswerOfYes = replaceSpecialChar($_REQUEST['AnswerOfYes']);
	$footersignature = replaceSpecialChar($_REQUEST['footersignature']);
	$footerdate = ($_REQUEST['footerdate']);
	$attFiles = $_FILES["attFile"];
	
	$filename55_array[]= trim($_REQUEST['filename55']);




$flipped =explode(',', $_POST['filename55']);












    
 if($e_action12 == 'delete1')
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
		
		
		$str = "UPDATE ".$tbname."_trainerqualification SET _Status = 2 WHERE (" . $emailString1 . ") ";


		mysql_query($str);



	include('../dbclose.php');
    echo "<script language='JavaScript'>window.location = 'trainer.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('2',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($id,$Encrypt)."'</script>";
    exit();
}

if($e_action22 == 'delete2')
{	

 

$emailString2 = "";

$cntCheck2 = $_POST["cntCheck2"];


    for ($i=1; $i<=$cntCheck2; $i++)
    {
      
        if ($_POST["CustCheckboxr".$i] != "")
        {
           
            $emailString2 = $emailString2 . "_ID = '" . $_POST["CustCheckboxr".$i] . "' OR ";
         
        }
    }
 

    $emailString2 = substr($emailString2, 0, strlen($emailString2)-4);
    
    
    $str = "UPDATE ".$tbname."_trainerrelevantqualification SET _Status = 2 WHERE (" . $emailString2 . ") ";


    mysql_query($str);



include('../dbclose.php');
echo "<script language='JavaScript'>window.location = 'trainer.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('2',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($id,$Encrypt)."'</script>";
exit();
}



	if($e_action == 'addnew')
	{
		$str = "INSERT INTO ".$tbname."_trainers 
				(_Trainertitle,_TrainerRefNo,_FullName,_FullNameChines,_TrainerCatID,_Nric,_Occupation,_Nationality,_Dob,_CountryDob,_Sex,_MaritalStatus,_FinNo,_ExpiryDate,_Race,_RaceOther,_TypePass
				,_Status,_Address,_Postalcode,_HomeNo,_Handphone,_Email,_Bankname,_Accountname,_Accountnumber,_EmployerName,_EmployerAddress,_EmployerPostalcode,_EmployerTelno,_EmployerFaxno,_Selfprofile,
				_MpDeclaration1,_MpDeclaration2,_MpDeclaration3,_MpDeclaration4,_AnswerOfYes,_FooterSignature,_FooterDate,_CreatedBy,_CreatedDateTime,_UpdatedDateTime,_UpdatedBy)
				VALUES(";
		
		if($trainertitle != "") $str = $str . "'" . $trainertitle . "', ";
		else $str = $str . "null, ";
		
		if($trainerno != "") $str = $str . "'" . $trainerno . "', ";
		else $str = $str . "null, ";
		
		if($trainername != "") $str = $str . "'" . $trainername . "', ";
		else $str = $str . "null, ";
		
		
		if($nameinchinese != "") $str = $str . "'" . $nameinchinese . "', ";
		else $str = $str . "null, ";

		if($trainercatID != "") $str = $str . "'" . $trainercatID . "', ";
		else $str = $str . "null, ";
		
		if($nricfin != "") $str = $str . "'" . $nricfin . "', ";
		else $str = $str . "null, ";
		
		if($occupation != "") $str = $str . "'" . $occupation . "', ";
		else $str = $str . "null, ";
		
		
		if($nationality != "") $str = $str . "'" . $nationality . "', ";
		else $str = $str . "null, ";

		if($dob != "") $str = $str . "'" . $dob . "', ";
		else $str = $str . "null, ";
		
		if($cofbirth != "") $str = $str . "'" . $cofbirth . "', ";
		else $str = $str . " null, ";
        
		if($sex != "") $str = $str . "'" . $sex . "', ";
		else $str = $str . "null, ";
		
		if($maritalstatus != "") $str = $str . "'" . $maritalstatus . "', ";
		else $str = $str . "null, ";
		
		if($finno != "") $str = $str . "'" . $finno . "', ";
		else $str = $str . "null, ";
		
		if($expirtdate != "") $str = $str . "'" . $expirtdate . "', ";
		else $str = $str . "null, ";
		
		if($race  != "") $str = $str . "'" . $race . "', ";
		else $str = $str . "null, ";
		
		if($raceofother != "") $str = $str . "'" . $raceofother . "', ";
		else $str = $str . "null, ";
		
		if($typeofpass != "") $str = $str . "'" . $typeofpass . "', ";
		else $str = $str . "null, ";
		
		if($status != "") $str = $str . "'" . $status . "', ";
		else $str = $str . "null, ";
		
		if($residentialaddress != "") $str = $str . "'" . $residentialaddress . "', ";
		else $str = $str . "null, ";
		
		if($postalcode != "") $str = $str . "'" . $postalcode . "', ";
		else $str = $str . "null, ";
		
		if($hometelno != "") $str = $str . "'" . $hometelno . "', ";
		else $str = $str . "null, ";
		
		if($handphone != "") $str = $str . "'" . $handphone . "', ";
		else $str = $str . "null, ";
		
		if($email != "") $str = $str . "'" . $email . "', ";
		else $str = $str . "null, ";
		
		if($bankname != "") $str = $str . "'" . $bankname . "', ";
		else $str = $str . "null, ";
		
		if($accountname != "") $str = $str . "'" . $accountname . "', ";
		else $str = $str . "null, ";
		
		if($accountnumber != "") $str = $str . "'" . $accountnumber . "', ";
		else $str = $str . "null, ";
		
		if($employername != "") $str = $str . "'" . $employername . "', ";
		else $str = $str . "null, ";

			if($addressofemployer != "") $str = $str . "'" . $addressofemployer . "', ";
		else $str = $str . "null, ";
		
		if($employerpostalcode != "") $str = $str . "'" . $employerpostalcode . "', ";
		else $str = $str . "null, ";

	      if($employertelno != "") $str = $str . "'" . $employertelno . "', ";
		else $str = $str . "null, ";
		
		if($employerfaxno != "") $str = $str . "'" . $employerfaxno . "', ";
		else $str = $str . "null, ";

		if($selfprofile != "") $str = $str . "'" . $selfprofile . "', ";
		else $str = $str . "null, ";

			if($MpDeclaration1 != "") $str = $str . "'" . $MpDeclaration1 . "', ";
		else $str = $str . "null, ";
		
		if($MpDeclaration2 != "") $str = $str . "'" . $MpDeclaration2 . "', ";
		else $str = $str . "null, ";

	      if($MpDeclaration3 != "") $str = $str . "'" . $MpDeclaration3 . "', ";
		else $str = $str . "null, ";
		
		if($MpDeclaration4 != "") $str = $str . "'" . $MpDeclaration4 . "', ";
		else $str = $str . "null, ";

		if($AnswerOfYes != "") $str = $str . "'" . $AnswerOfYes . "', ";
		else $str = $str . "null, ";

		if($footersignature != "") $str = $str . "'" . $footersignature . "', ";
		else $str = $str . "null, ";

		if($footerdate != "") $str = $str . "'" . $footerdate . "', ";
		else $str = $str . "null, ";


        $str = $str . "'" . $_SESSION['userid'] . "', ";


		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		
		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		$str = $str . "'" . $_SESSION['userid'] . "' ";
		$str = $str . ") ";
	
		mysql_query('SET NAMES utf8');
		//echo $str;
		//exit();
		
	
		$result = mysql_query($str) or die(mysql_error().$str);
		if($result==1)
		{
			$trainerid = mysql_insert_id();
		}
		
		//Save files into table.
		$_pageid= $trainerid;
		$_type = "I";
		include("savefiles.php");


		
		$srno_array[] = $_REQUEST['srno'];
		$qualification_array[] = $_REQUEST['qualification'];
		$institution_array[] = $_REQUEST['institution'];
		$from_array[] = $_REQUEST['from'];
		$to_array[] = $_REQUEST['to'];
/*echo"<pre>";
print_r($_REQUEST['attFile']);
echo"</pre>";
exit;*/
//add data of child table of trainer
       $s=1;

	    for ($i = 0; $i < count($_REQUEST['qualification']); $i++) {

		$str = "INSERT INTO ".$tbname."_trainerqualification (_TranerID,_SrNo,_AcdQualifications,_InstitutionName,_From,_To,_Status) VALUES (";

	    if($trainerid != "") $str = $str . "'" . $trainerid . "', ";
		else $str = $str . "null, ";

		if($s!= "") $str = $str . "'" . $s. "', ";
		else $str = $str . "null, ";
	
    	

    	if($_REQUEST['qualification'][$i] != "") $str = $str . "'" . $_REQUEST['qualification'][$i] . "', ";
		else $str = $str . "null, ";
	

    	if($_REQUEST['institution'][$i] != "") $str = $str . "'" .$_REQUEST['institution'][$i] . "', ";
		else $str = $str . "null, ";

		if($_REQUEST['from'][$i] != "") $str = $str . "'" .$_REQUEST['from'][$i] . "', ";
		else $str = $str . "null, ";

		if($_REQUEST['to'][$i] != "") $str = $str . "'" . $_REQUEST['to'][$i] . "' ,";
		else $str = $str . "null, ";

		 $str = $str . "'1'";
			$str = $str . ")";


			mysql_query('SET NAMES utf8');
			$result = mysql_query($str) or die(mysql_error().$str);
          $s++;
		}

//add data of relavent education certificate
         $b=1;
	    for ($i = 0; $i < count($_REQUEST['courseatten']); $i++) {

		$str = "INSERT INTO ".$tbname."_trainerrelevantqualification (_TranerID,_RelevSrNo,_ReleCourseAttend,_ReleQualification,_ReleInstitution,_ReleFrom,_ReleTo,_Filename1,_Status) VALUES (";

	    if($trainerid != "") $str = $str . "'" . $trainerid . "', ";
		else $str = $str . "null, ";

		if($b!= "") $str = $str . "'" . $b . "', ";
		else $str = $str . "null, ";
	
    	

    	if($_REQUEST['courseatten'][$i] != "") $str = $str . "'" . $_REQUEST['courseatten'][$i] . "', ";
		else $str = $str . "null, ";
	

    	if($_REQUEST['relinstitution'][$i] != "") $str = $str . "'" .$_REQUEST['relinstitution'][$i] . "', ";
		else $str = $str . "null, ";

         if($_REQUEST['relinstitution'][$i] != "") $str = $str . "'" .$_REQUEST['relinstitution'][$i] . "', ";
		else $str = $str . "null, ";

		if($_REQUEST['relfrom'][$i] != "") $str = $str . "'" .$_REQUEST['relfrom'][$i] . "', ";
		else $str = $str . "null, ";

		if($_REQUEST['relto'][$i] != "") $str = $str . "'" . $_REQUEST['relto'][$i] . "' ,";
		else $str = $str . "null, ";

		
		if($attFiles['name'][$i] != "") $str = $str . "'" . $attFiles['name'][$i] . "', ";
        else $str = $str . "null ,";
        
        $str = $str . "'1'";
			$str = $str . ")";


			mysql_query('SET NAMES utf8');
			$result = mysql_query($str) or die(mysql_error().$str);
         $b++;
		}

		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add Trainer', ";
		
		if ($trainername != "") $strSQL = $strSQL . "'" . replaceSpecialChar($companyname) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'trainer.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('1',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($trainerid,$Encrypt)."'</script>";
		exit();
		
	}


	else if($e_action=='edit')
	{
		$str = "UPDATE ".$tbname."_trainers SET ";
		
		if($trainertitle != "") $str = $str . "_Trainertitle = '" . $trainertitle . "', ";
		else $str = $str . "_Trainertitle = null, ";

		
		if($trainerno != "") $str = $str . "_TrainerRefNo = '" . $trainerno . "', ";
		else $str = $str . "_TrainerRefNo = null, ";
				
		if($trainername != "") $str = $str . "_FullName = '" . $trainername . "', ";
		else $str = $str . "_FullName = null, ";
				
		if($nameinchinese != "") $str = $str . "_FullNameChines = '" . $nameinchinese . "', ";
		else $str = $str . "_FullNameChines = null, ";
				
		if($trainercatID != "") $str = $str . "_TrainerCatID = '" . $trainercatID . "', ";
		else $str = $str . "_TrainerCatID = null, ";
				
		if($nricfin != "") $str = $str . "_Nric =  '" . $nricfin . "', ";
		else $str = $str . "_Nric =  null, ";
		
		if($occupation != "") $str = $str . "_Occupation =  '" . $occupation . "', ";
		else $str = $str . "_Occupation =  null, ";
		
		if($nationality != "") $str = $str . "_Nationality =  '" . $nationality . "', ";
		else $str = $str . "_Nationality =  null, ";
		
		if($dob != "") $str = $str . "_Dob = '" . $dob . "', ";
		else $str = $str . "_Dob = null, ";
		
		if($cofbirth != "") $str = $str . "_CountryDob = '" . $cofbirth . "', ";
		else $str = $str . "_CountryDob = null, ";
		
		if($sex != "") $str = $str . "_Sex = '" . $sex . "', ";
		else $str = $str . "_Sex = null, ";
		
		if($maritalstatus != "") $str = $str . "_MaritalStatus = '" . $maritalstatus . "', ";
		else $str = $str . "_MaritalStatus = null, ";
		
		if($finno != "") $str = $str . "_FinNo = '" . $finno . "', ";
		else $str = $str . "_FinNo = null, ";
		
		if($expirtdate != "") $str = $str . "_ExpiryDate = '" . $expirtdate . "', ";
		else $str = $str . "_ExpiryDate = null, ";
		
		if($race != "") $str = $str . "_Race = '" . $race . "', ";
		else $str = $str . "_Race = null, ";
		
		if($raceofother != "") $str = $str . "_RaceOther = '" . $raceofother . "', ";
		else $str = $str . "_RaceOther = null, ";
		
		if($typeofpass != "") $str = $str . "_TypePass = '" . $typeofpass . "', ";
		else $str = $str . "_TypePass = null, ";
		
		if($status != "") $str = $str . "_Status = '" . $status . "', ";
		else $str = $str . "_Status = null, ";
		
		if($residentialaddress != "") $str = $str . "_Address = '" . $residentialaddress . "', ";
		else $str = $str . "_Address = null, ";
		
		if($postalcode != "") $str = $str . "_Postalcode = '" . $postalcode . "', ";
		else $str = $str . "_Postalcode = null, ";
		
		if($hometelno != "") $str = $str . "_HomeNo = '" . $hometelno . "', ";
		else $str = $str . "_HomeNo = null, ";
		
		if($handphone != "") $str = $str . "_Handphone = '" . $handphone . "', ";
		else $str = $str . "_Handphone = null, ";
		
		if($email != "") $str = $str . "_Email = '" . $email . "', ";
		else $str = $str . "_Email = null, ";
		
		if($bankname != "") $str = $str . "_Bankname = '" . $bankname . "', ";
		else $str = $str . "_Bankname = null, ";
		
		if($accountname != "") $str = $str . "_Accountname = '" . $accountname . "', ";
		else $str = $str . "_Accountname = null, ";
		

		if($accountnumber != "") $str = $str . "_Accountnumber = '" . $accountnumber . "', ";
		else $str = $str . "_Accountnumber = null, ";
		
		if($employername != "") $str = $str . "_EmployerName = '" . $employername . "', ";
		else $str = $str . "_EmployerName = null, ";

		
		if($addressofemployer != "") $str = $str . "_EmployerAddress = '" . $addressofemployer . "', ";
		else $str = $str . "_EmployerAddress = null, ";
		
		if($employerpostalcode != "") $str = $str . "_EmployerPostalcode = '" . $employerpostalcode . "', ";
		else $str = $str . "_EmployerPostalcode = null, ";

		
		if($employertelno != "") $str = $str . "_EmployerTelno = '" . $employertelno . "', ";
		else $str = $str . "_EmployerTelno = null, ";
		
		if($employerfaxno != "") $str = $str . "_EmployerFaxno = '" . $employerfaxno . "', ";
		else $str = $str . "_EmployerFaxno = null, ";

		if($selfprofile != "") $str = $str . "_Selfprofile = '" . $selfprofile . "', ";
		else $str = $str . "_Selfprofile = null, ";

	    if($MpDeclaration1 != "") $str = $str . "_MpDeclaration1 = '" . $MpDeclaration1 . "', ";
		else $str = $str . "_MpDeclaration1 = null, ";

		
		if($MpDeclaration2 != "") $str = $str . "_MpDeclaration2 = '" . $MpDeclaration2 . "', ";
		else $str = $str . "_MpDeclaration2 = null, ";
		
		if($MpDeclaration3 != "") $str = $str . "_MpDeclaration3= '" . $MpDeclaration3 . "', ";
		else $str = $str . "_MpDeclaration3 = null, ";

		
		if($MpDeclaration4 != "") $str = $str . "_MpDeclaration4 = '" . $MpDeclaration4 . "', ";
		else $str = $str . "_MpDeclaration4 = null, ";
		
		if($AnswerOfYes != "") $str = $str . "_AnswerOfYes = '" . $AnswerOfYes . "', ";
		else $str = $str . "_AnswerOfYes = null, ";

		if($footersignature != "") $str = $str . "_FooterSignature	 = '" . $footersignature . "', ";
		else $str = $str . "_FooterSignature	 = null, ";

		
		if($footerdate != "") $str = $str . "_FooterDate = '" . $footerdate . "', ";
		else $str = $str . "_FooterDate = null, ";

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

$sql = "DELETE FROM ".$tbname."_trainerqualification WHERE _TranerID=$id AND `_Status` NOT IN ('2') ";



mysql_query('SET NAMES utf8');
$result = mysql_query($sql) or die(mysql_error().$sql);


	$srno_array[] = $_REQUEST['srno'];
	$qualification_array[] = $_REQUEST['qualification'];
	$institution_array[] = $_REQUEST['institution'];
	$from_array[] = $_REQUEST['from'];
	$to_array[] = $_REQUEST['to'];

         $s=1;
	    for ($i = 0; $i < count($_REQUEST['qualification']); $i++) {

		$str = "INSERT INTO ".$tbname."_trainerqualification (_TranerID,_SrNo,_AcdQualifications,_InstitutionName,_From,_To,_Status) VALUES (";

	    if($id != "") $str = $str . "'" . $id . "', ";
		else $str = $str . "null, ";

		if($s!= "") $str = $str . "'" . $s . "', ";
		else $str = $str . "null, ";
	
    	if($_REQUEST['qualification'][$i] != "") $str = $str . "'" . $_REQUEST['qualification'][$i] . "', ";
		else $str = $str . "null, ";
	

    	if($_REQUEST['institution'][$i] != "") $str = $str . "'" .$_REQUEST['institution'][$i] . "', ";
		else $str = $str . "null, ";

		if($_REQUEST['from'][$i] != "") $str = $str . "'" .$_REQUEST['from'][$i] . "', ";
		else $str = $str . "null, ";

		if($_REQUEST['to'][$i] != "") $str = $str . "'" . $_REQUEST['to'][$i] . "', ";
		else $str = $str . "null, ";

		 $str = $str . "'1' ";
			$str = $str . ")";

			mysql_query('SET NAMES utf8');
			$result = mysql_query($str) or die(mysql_error().$str);
           $s++;
		}

$sql1 = "DELETE FROM ".$tbname."_trainerrelevantqualification WHERE _TranerID = $id AND `_Status` NOT IN ('2')";

mysql_query('SET NAMES utf8');
$result = mysql_query($sql1) or die(mysql_error().$sql1);


$relSrno_array[] = $_REQUEST['relSrno'];
$courseatten_array[] = $_REQUEST['courseatten'];
$relqualiobtain_array[] = $_REQUEST['relqualiobtain'];
$relinstitution_array[] = $_REQUEST['relinstitution'];
$relfrom_array[] = $_REQUEST['relfrom'];
$relto_array[] = $_REQUEST['relto'];
$attFiles = $_FILES["attFile"];
$b=1;




	    for ($i = 0; $i < count($_REQUEST['courseatten']); $i++) {

		


		$str = "INSERT INTO ".$tbname."_trainerrelevantqualification (_TranerID,_RelevSrNo,_ReleCourseAttend,_ReleQualification,_ReleInstitution,_ReleFrom,_ReleTo,_Filename1,_Status) VALUES (";

	    if($id != "") $str = $str . "'" . $id . "', ";
		else $str = $str . "null, ";

		if($b!= "") $str = $str . "'" . $b . "', ";
		else $str = $str . "null, ";
	
    	

    	if($_REQUEST['courseatten'][$i] != "") $str = $str . "'" . $_REQUEST['courseatten'][$i] . "', ";
		else $str = $str . "null, ";
	

    	if($_REQUEST['relinstitution'][$i] != "") $str = $str . "'" .$_REQUEST['relinstitution'][$i] . "', ";
		else $str = $str . "null, ";

         if($_REQUEST['relinstitution'][$i] != "") $str = $str . "'" .$_REQUEST['relinstitution'][$i] . "', ";
		else $str = $str . "null, ";

		if($_REQUEST['relfrom'][$i] != "") $str = $str . "'" .$_REQUEST['relfrom'][$i] . "', ";
		else $str = $str . "null, ";

		if($_REQUEST['relto'][$i] != "") $str = $str . "'" . $_REQUEST['relto'][$i] . "' ,";
		else $str = $str . "null, ";

		if($flipped[$i] != "") $str = $str . "'" . $flipped[$i] . "',";
        else $str = $str . "null, ";
        
        $str = $str . "'1'";
			$str = $str . ")";

			mysql_query('SET NAMES utf8');
			$result = mysql_query($str) or die(mysql_error().$str);
		  $b++;
		  
		



		}

		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Edit Trainer', ";
		
		if ($id != "") $strSQL = $strSQL . "'" . replaceSpecialChar($id) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
	
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'trainer.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('2',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($id,$Encrypt)."'</script>";
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
		
		
		$str = "UPDATE ".$tbname."_trainers SET _status = 2 WHERE (" . $emailString . ") ";
	
		mysql_query($str);
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Delete Trainer', ";
		
		if ($emailString != "") $strSQL = $strSQL . "'" . replaceSpecialChar($emailString) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'trainers.php?PageNo=".$PageNo."&done=3'</script>";
		exit();
	}



	
?>