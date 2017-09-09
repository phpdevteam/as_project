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
	
	// echo '<pre>';print_r($_REQUEST);
	// echo '<pre>';print_r($_FILES);
	// die;
	$clientname = replaceSpecialChar($_REQUEST['clientname']);
	$customerno = replaceSpecialChar($_REQUEST['customerno']);
	$address1 = replaceSpecialChar($_REQUEST['address1']);
	$address2 = replaceSpecialChar($_REQUEST['address2']);
	$address3 = replaceSpecialChar($_REQUEST['address3']);
	$telephone1 = replaceSpecialChar($_REQUEST['telephone1']);
	$telephone2 = replaceSpecialChar($_REQUEST['telephone2']);
	$postalcode = replaceSpecialChar($_REQUEST['postalcode']);
	$email = replaceSpecialChar($_REQUEST['email']);
	$cityid = replaceSpecialChar($_REQUEST['cityid']);
	$stateproid = replaceSpecialChar($_REQUEST['stateproid']);
	$countryid = replaceSpecialChar($_REQUEST['countryid']);
	$remarks = replaceSpecialChar($_REQUEST['remarks']);
	$internalremarks = replaceSpecialChar($_REQUEST['internalRemarks']);
	$systemstatus = replaceSpecialChar($_REQUEST['status']);
	$nricfin = replaceSpecialChar($_REQUEST['nricfin']);
	$nsmen = replaceSpecialChar($_REQUEST['nsmen']);
	$iptprog = replaceSpecialChar($_REQUEST['iptprog']);
	$creditava = replaceSpecialChar($_REQUEST['creditava']);
	$unusedamount = replaceSpecialChar($_REQUEST['unusedamount']);
	$dob = datepickerToMySQLDate($_REQUEST['dob']);
	$height = replaceSpecialChar($_REQUEST['height']);
	$medhistory = replaceSpecialChar($_REQUEST['medhistory']);
	$weight = replaceSpecialChar($_REQUEST['weight']);
	$workrecprofile = replaceSpecialChar($_REQUEST['workrecprofile']);
	$phyactiprofile = replaceSpecialChar($_REQUEST['phyactiprofile']);
	$contacttitle = replaceSpecialChar($_REQUEST['contacttitle']);
	
	/* //Upload file
	if ($_FILES["attFile"]["size"] > 0)
	{
		if ($_FILES["attFile"]["error"] > 0)
		{			
			echo "Return Code: " . $_FILES["attFile"]["error"] . "<br />";
		}
		else
		{			
			$OriginalFileName = $_FILES["attFile"]["name"];
			$splitfilename = strtolower($_FILES["attFile"]["name"]) ; 
			$exts = explode(".", $splitfilename) ; 
			$n = count($exts)-1; 
			$exts = $exts[$n]; 
			$datetime = date("YmdHis") . generateNumStr(4);

			$FileName = "";
			$FileName = $datetime . "." . $exts;

			if (file_exists($AdminTopCMSImagesPath . $FileName))
			{
				echo $FileName . " already exists. ";
			}
			else
			{
				  $_FILES["attFile"]['tmp_name'];
				  move_uploaded_file( $_FILES["attFile"]['tmp_name'] , $AdminTopCMSImagesPath . $FileName );
				  chmod($AdminTopCMSImagesPath . $FileName, 0777);
				
			}
		}
		
		if($FileName != "")
		{
			$fields = array();
			$attfile = array();
			$str = "Show columns From ".$tbname."_files  Where Field <> '_id' ";

			$result = mysql_query($str) or die(mysql_error() . $str);

			while($row = mysql_fetch_assoc($result)) {
			   $fields[] = $row['Field'];
			}
			
			
			$values = array();
			foreach ($fields as $field) {
				$value = $attfile[$field];
				$values[] = $value===null ? 'null' : "'".replaceSpecialChar($value)."'";
			}
			echo $str = "INSERT INTO ".$tbname."_files(".implode(',', $fields).") VALUES (".implode(',', $values).")";
	 
			mysql_query($str) or die(mysql_error() . $str);

		}
	} */
	// die;
	
	if($e_action == 'addnew')
	{
		$str = "INSERT INTO ".$tbname."_client 
				(_customerid,_contacttitle,_fullname,_nricfin,_nsmen,_address1,_address2,_address3,_postalcode,_hp,_hp2,_email,_cityid,_countryid
				,_dob,_height,_weight,_medhistory,_iptprog,_creditava,_TotalUnUsedAmount,_workrecprofile,_phyactiprofile,_remarks,_internalremarks,
				_status,_createddate,_createdby,_updateddate,_updatedby)
				VALUES(";
		
		if($customerno != "") $str = $str . "'" . $customerno . "', ";
		else $str = $str . "null, ";
		
		if($contacttitle != "") $str = $str . "'" . $contacttitle . "', ";
		else $str = $str . "null, ";
		
		if($clientname != "") $str = $str . "'" . $clientname . "', ";
		else $str = $str . "null, ";
		
		
		if($nricfin != "") $str = $str . "'" . $nricfin . "', ";
		else $str = $str . "null, ";
		
		if($nsmen != "") $str = $str . "'" . $nsmen . "', ";
		else $str = $str . "null, ";
		
		if($address1 != "") $str = $str . "'" . $address1 . "', ";
		else $str = $str . "null, ";
		
		if($address2 != "") $str = $str . "'" . $address2 . "', ";
		else $str = $str . "null, ";
		
		if($address3 != "") $str = $str . "'" . $address3 . "', ";
		else $str = $str . " null, ";
        
		if($postalcode != "") $str = $str . "'" . $postalcode . "', ";
		else $str = $str . "null, ";
		
		if($telephone1 != "") $str = $str . "'" . $telephone1 . "', ";
		else $str = $str . "null, ";
		
		if($telephone2 != "") $str = $str . "'" . $telephone2 . "', ";
		else $str = $str . "null, ";
		
		if($email != "") $str = $str . "'" . $email . "', ";
		else $str = $str . "null, ";
		
		if($cityid  != "") $str = $str . "'" . $cityid . "', ";
		else $str = $str . "null, ";
		
		if($countryid != "") $str = $str . "'" . $countryid . "', ";
		else $str = $str . "null, ";
		
		if($dob != "") $str = $str . "'" . $dob . "', ";
		else $str = $str . "null, ";
		
		if($height != "") $str = $str . "'" . $height . "', ";
		else $str = $str . "null, ";
		
		if($weight != "") $str = $str . "'" . $weight . "', ";
		else $str = $str . "null, ";
		
		if($medhistory != "") $str = $str . "'" . $medhistory . "', ";
		else $str = $str . "null, ";
		
		if($iptprog != "") $str = $str . "'" . $iptprog . "', ";
		else $str = $str . "null, ";
		
		if($creditava != "") $str = $str . "'" . $creditava . "', ";
		else $str = $str . "null, ";

				
		if($unusedamount != "") $str = $str . "'" . $unusedamount . "', ";
		else $str = $str . "null, ";
		
		if($workrecprofile != "") $str = $str . "'" . $workrecprofile . "', ";
		else $str = $str . "null, ";
		
		if($phyactiprofile != "") $str = $str . "'" . $phyactiprofile . "', ";
		else $str = $str . "null, ";
		
		if($remarks != "") $str = $str . "'" . $remarks . "', ";
		else $str = $str . "null, ";
		
		if($internalremarks != "") $str = $str . "'" . $internalremarks . "', ";
		else $str = $str . "null, ";
		
		if($systemstatus != "") $str = $str . "'" . $systemstatus . "', ";
		else $str = $str . "null, ";

		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		$str = $str . "'" . $_SESSION['userid'] . "', ";
		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		$str = $str . "'" . $_SESSION['userid'] . "' ";
		$str = $str . ") ";
	
		mysql_query('SET NAMES utf8');
		//echo $str;
		//exit();
		
		$result = mysql_query($str) or die(mysql_error().$str);
		if($result==1)
		{
			$customerid = mysql_insert_id();
		}
		
		//Save files into table.
		$_pageid= $customerid;
		$_type = "I";
		include("savefiles.php");
		
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add Client', ";
		
		if ($companyname != "") $strSQL = $strSQL . "'" . replaceSpecialChar($companyname) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'customer.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('1',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($customerid,$Encrypt)."'</script>";
		exit();
		
	}
	else if($e_action=='edit')
	{
		$str = "UPDATE ".$tbname."_client SET ";
		
		if($contacttitle != "") $str = $str . "_contacttitle = '" . $contacttitle . "', ";
		else $str = $str . "_contacttitle = null, ";
				
		if($clientname != "") $str = $str . "_fullname = '" . $clientname . "', ";
		else $str = $str . "_fullname = null, ";
				
		if($nricfin != "") $str = $str . "_nricfin = '" . $nricfin . "', ";
		else $str = $str . "_nricfin = null, ";
				
		if($nsmen != "") $str = $str . "_nsmen = '" . $nsmen . "', ";
		else $str = $str . "_nsmen = null, ";
				
		if($address1 != "") $str = $str . "_address1 =  '" . $address1 . "', ";
		else $str = $str . "_address1 =  null, ";
		
		if($address2 != "") $str = $str . "_address2 =  '" . $address2 . "', ";
		else $str = $str . "_address2 =  null, ";
		
		if($address3 != "") $str = $str . "_address3 =  '" . $address3 . "', ";
		else $str = $str . "_address3 =  null, ";
		
		if($telephone1 != "") $str = $str . "_hp = '" . $telephone1 . "', ";
		else $str = $str . "_hp = null, ";
		
		if($telephone2 != "") $str = $str . "_hp2 = '" . $telephone2 . "', ";
		else $str = $str . "_hp2 = null, ";
		
		if($postalcode != "") $str = $str . "_postalcode = '" . $postalcode . "', ";
		else $str = $str . "_postalcode = null, ";
		
		if($email != "") $str = $str . "_email = '" . $email . "', ";
		else $str = $str . "_email = null, ";
		
		if($cityid != "") $str = $str . "_cityid = '" . $cityid . "', ";
		else $str = $str . "_cityid = null, ";
		
		if($countryid != "") $str = $str . "_countryid = '" . $countryid . "', ";
		else $str = $str . "_countryid = null, ";
		
		if($dob != "") $str = $str . "_dob = '" . $dob . "', ";
		else $str = $str . "_dob = null, ";
		
		if($height != "") $str = $str . "_height = '" . $height . "', ";
		else $str = $str . "_height = null, ";
		
		if($weight != "") $str = $str . "_weight = '" . $weight . "', ";
		else $str = $str . "_weight = null, ";
		
		if($medhistory != "") $str = $str . "_medhistory = '" . $medhistory . "', ";
		else $str = $str . "_medhistory = null, ";
		
		if($iptprog != "") $str = $str . "_iptprog = '" . $iptprog . "', ";
		else $str = $str . "_iptprog = null, ";
		
		if($creditava != "") $str = $str . "_creditava = '" . $creditava . "', ";
		else $str = $str . "_creditava = null, ";

		if($unusedamount != "") $str = $str . "_TotalUnUsedAmount = '" . $unusedamount . "', ";
		else $str = $str . "_TotalUnUsedAmount = null, ";
		
		if($workrecprofile != "") $str = $str . "_workrecprofile = '" . $workrecprofile . "', ";
		else $str = $str . "_workrecprofile = null, ";
		
		if($phyactiprofile != "") $str = $str . "_phyactiprofile = '" . $phyactiprofile . "', ";
		else $str = $str . "_phyactiprofile = null, ";
		
		if($remarks != "") $str = $str . "_remarks = '" . $remarks . "', ";
		else $str = $str . "_remarks = null, ";
		
		if($internalremarks != "") $str = $str . "_internalremarks = '" . $internalremarks . "', ";
		else $str = $str . "_internalremarks = null, ";
		
		if($systemstatus != "") $str = $str . "_status = '" . $systemstatus . "', ";
		else $str = $str . "_status = null, ";
		
		$str = $str . "_updateddate = '" . date("Y-m-d H:i:s") . "', ";
		$str = $str . "_updatedby = '" . $_SESSION['userid'] . "' ";	
		
		$str = $str . " WHERE _id = '".$id."' ";
		
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
		$strSQL = $strSQL . "'Edit Client', ";
		
		if ($id != "") $strSQL = $strSQL . "'" . replaceSpecialChar($id) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
	
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'customer.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('2',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($id,$Encrypt)."'</script>";
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
				$emailString = $emailString . "_id = '" . $_POST["CustCheckbox".$i] . "' OR ";
			}
		}
	
		$emailString = substr($emailString, 0, strlen($emailString)-4);
		
		
		$str = "UPDATE ".$tbname."_client SET _status = 2 WHERE (" . $emailString . ") ";
	
		mysql_query($str);
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Delete Client', ";
		
		if ($emailString != "") $strSQL = $strSQL . "'" . replaceSpecialChar($emailString) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'customers.php?PageNo=".$PageNo."&done=3'</script>";
		exit();
	}
?>