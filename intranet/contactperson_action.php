<?
session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	include('../global.php');	
	include('../include/functions.php');
	include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");
	$e_action = $_REQUEST['e_action'];
	$id = trim($_REQUEST['id']);
	$cid = trim($_REQUEST['cid']);
	$PageNo = $_REQUEST['PageNo'];
	$DateTime = date("Y-m-d H:i:s");
	$type = $_REQUEST['type'];
//var_dump($_REQUEST);
//exit();
	$contacttitle = replaceSpecialChar($_REQUEST['contacttitle']);
	$customerno = replaceSpecialChar($_REQUEST['customerno']);
	$contactname = replaceSpecialChar($_REQUEST['contactname']);
	
	
	$address1 = replaceSpecialChar($_REQUEST["address1"]);
	$address2 = replaceSpecialChar($_REQUEST["address2"]);
	$address3 = replaceSpecialChar($_REQUEST["address3"]);
	
	
	$contactcountryid = replaceSpecialChar($_REQUEST['contactcountryid']);
	$stateproid = replaceSpecialChar($_REQUEST['stateproid']);
	$contactcityid = replaceSpecialChar($_REQUEST['contactcityid']);
	$contacttel = replaceSpecialChar($_REQUEST['contacttel']);
	$main2 = replaceSpecialChar($_REQUEST['main2']);
	$direct = replaceSpecialChar($_REQUEST['direct']);
	$contactfax = replaceSpecialChar($_REQUEST['contactfax']);
	$contactPostalcode = replaceSpecialChar($_REQUEST['contactPostalcode']);
	$contacturl = replaceSpecialChar($_REQUEST['contacturl']);
	$contactemail = replaceSpecialChar($_REQUEST['contactemail']);
	$contactremarks = replaceSpecialChar($_REQUEST['contactremarks']);
	$internalremarks = replaceSpecialChar($_REQUEST['internalremarks']);
	$contacttype = replaceSpecialChar($_REQUEST['contacttype']);
	$billcompanyname = replaceSpecialChar($_REQUEST['billcompanyname']);
	$systemstatus = replaceSpecialChar($_REQUEST['systemstatus']);
	
	$contactdepartment = replaceSpecialChar($_REQUEST['contactdepartment']);
	
	$contacttel2 = replaceSpecialChar($_REQUEST['contacttel2']);
	$defaultuser = replaceSpecialChar($_REQUEST['defaultuser']);
	
	
	
	if($type  == 'uc'){
		$customerpagename = "contractor.php";
	}else if($type  == 'me'){
		$customerpagename = "member.php";
	}else if($type  == 'c'){
		$customerpagename = "maincontractor.php";
	}else
		$customerpagename = "customer.php";
	
	if($e_action == 'addnew')
	{
		$str = "INSERT INTO ".$tbname."_contactperson 
				(_customerid,_contacttitle,_contactname,_customerno,_address1,_address2,_address3,_contactcountry,_contactstate,_contactcity,_contacttel,_contacttel2,_main2,_direct,_contactfax,_postalcode,_contacturl,_contactemail,_contactremarks,_internalremarks,_billingcompany,_status,_contactdepartment,_defaultuser,_submittedby,_submitteddate)
				VALUES(";
		if($cid != "") $str = $str . "'" . $cid . "', ";
		else $str = $str . "null, ";
				
		if($contacttitle != "") $str = $str . "'" . $contacttitle . "', ";
		else $str = $str . "null, ";
		
		if($contactname != "") $str = $str . "'" . $contactname . "', ";
		else $str = $str . "null, ";
		
		if($customerno != "") $str = $str . "'" . $customerno . "', ";
		else $str = $str . "null, ";
		
		if($address1 != "") $str = $str . "'" . $address1 . "', ";
		else $str = $str . "null, ";
		
		if($address2 != "") $str = $str . "'" . $address2 . "', ";
		else $str = $str . "null, ";
		
		if($address3 != "") $str = $str . "'" . $address3 . "', ";
		else $str = $str . "null, ";
		
		if($contactcountryid != "") $str = $str . "'" . $contactcountryid . "', ";
		else $str = $str . "null, ";
		
		if($stateproid != "") $str = $str . "'" . $stateproid . "', ";
		else $str = $str . "null, ";
		
		if($contactcityid != "") $str = $str . "'" . $contactcityid . "', ";
		else $str = $str . "null, ";
		
		if($contacttel != "") $str = $str . "'" . $contacttel . "', ";
		else $str = $str . "null, ";
		
		if($contacttel2 != "") $str = $str . "'" . $contacttel2 . "', ";
		else $str = $str . "null, ";
		
		if($main2 != "") $str = $str . "'" . $main2 . "', ";
		else $str = $str . "null, ";
		
		if($direct != "") $str = $str . "'" . $direct . "', ";
		else $str = $str . "null, ";
		
		if($contactfax != "") $str = $str . "'" . $contactfax . "', ";
		else $str = $str . "null, ";
		
		if($contactPostalcode != "") $str = $str . "'" . $contactPostalcode . "', ";
		else $str = $str . "null, ";
		
		if($contacturl != "") $str = $str . "'" . $contacturl . "', ";
		else $str = $str . "null, ";
		
		if($contactemail != "") $str = $str . "'" . $contactemail . "', ";
		else $str = $str . "null, ";
		
		if($contactremarks != "") $str = $str . "'" . $contactremarks . "', ";
		else $str = $str . "null, ";
		
		if($internalremarks != "") $str = $str . "'" . $internalremarks . "', ";
		else $str = $str . "null, ";
		
		if($billcompanyname != "") $str = $str . "'" . $billcompanyname . "', ";
		else $str = $str . "null, ";
		
		if($systemstatus != "") $str = $str . "'" . $systemstatus . "', ";
		else $str = $str . "null, ";	
		
		if($contactdepartment != "") $str = $str . "'" . $contactdepartment . "', ";
		else $str = $str . "null, ";
		
		
		if($defaultuser != "") $str = $str . "'" . $defaultuser . "', ";
		else $str = $str . "null, ";	
		
		
		$str = $str . "'" .  $_SESSION['userid']  . "', ";
		$str = $str . "'" . date("Y-m-d H:i:s") . "' ";
		
		$str = $str . ") ";
		
		//echo $str;
		//exit();
		mysql_query('SET NAMES utf8');
		$result = mysql_query($str);
		$id = mysql_insert_id();
		
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Customer > Add Contact Person', ";
		
		if ($contactname != "") $strSQL = $strSQL . "'" . replaceSpecialChar($contactname) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
	                                        
		include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = 'contactperson.php?ctab=".encrypt('1',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&cid=".encrypt($cid,$Encrypt)."&id=".encrypt($id,$Encrypt)."&type=".encrypt($type,$Encrypt)."&done=".encrypt('1',$Encrypt)."'</script>";
		exit();
		
	}else if($e_action=='edit' || $e_action=='duplicate')
	{
		
		$str = "UPDATE ".$tbname."_contactperson SET ";
		
		if($contacttitle != "") $str = $str . "_contacttitle = '" . $contacttitle . "', ";
		else $str = $str . "_contacttitle = null, ";
		
		if($contactname != "") $str = $str . "_contactname = '" . $contactname . "', ";
		else $str = $str . "_contactname = null, ";
		
		if($address1 != "") $str = $str . "_address1 =  '" . $address1 . "', ";
		else $str = $str . "_address1 =  null, ";
		
				if($address2 != "") $str = $str . "_address2 =  '" . $address2 . "', ";
		else $str = $str . "_address2 =  null, ";
		
				if($address3 != "") $str = $str . "_address3 =  '" . $address3 . "', ";
		else $str = $str . "_address3 =  null, ";
		
		if($contacttel != "") $str = $str . "_contacttel = '" . $contacttel . "', ";
		else $str = $str . "_contacttel = null, ";
		
		if($contacttel2 != "") $str = $str . "_contacttel2 = '" . $contacttel2 . "', ";
		else $str = $str . "_contacttel2 = null, ";
		
		if($main2 != "") $str = $str . "_main2 = '" . $main2 . "', ";
		else $str = $str . "_main2 = null, ";
		
		if($direct != "") $str = $str . "_direct = '" . $direct . "', ";
		else $str = $str . "_direct = null, ";
		
		if($contactfax != "") $str = $str . "_contactfax = '" . $contactfax . "', ";
		else $str = $str . "_contactfax = null, ";
		
		
		if($contactcountryid != "") $str = $str . "_contactcountry = '" . $contactcountryid . "', ";
		else $str = $str . "_contactcountry = null, ";
		
		if($stateproid != "") $str = $str . "_contactstate = '" . $stateproid . "', ";
		else $str = $str . "_contactstate = null, ";
		
		if($contactcityid != "") $str = $str . "_contactcity = '" . $contactcityid . "', ";
		else $str = $str . "_contactcity = null, ";	
		
		if($contactPostalcode != "") $str = $str . "_postalcode = '" . $contactPostalcode . "', ";
		else $str = $str . "_postalcode = null, ";
		
		if($contacturl != "") $str = $str . "_contacturl = '" . $contacturl . "', ";
		else $str = $str . "_contacturl = null, ";
		
		if($contactemail != "") $str = $str . "_contactemail = '" . $contactemail . "', ";
		else $str = $str . "_contactemail = null, ";
		
		if($contactremarks != "") $str = $str . "_contactremarks = '" . $contactremarks . "', ";
		else $str = $str . "_contactremarks = null, ";
		
		if($internalremarks != "") $str = $str . "_internalremarks = '" . $internalremarks . "', ";
		else $str = $str . "_internalremarks = null, ";
		
		if($contactdepartment != "") $str = $str . "_contactdepartment = '" . $contactdepartment . "', ";
		else $str = $str . "_contactdepartment = null, ";
		
		if($systemstatus != "") $str = $str . "_status = '" . $systemstatus . "', ";
		else $str = $str . "_status = null, ";
		
		if($defaultuser != "") $str = $str . "_defaultuser = '" . $defaultuser . "', ";
		else $str = $str . "_defaultuser = null, ";
		
		if($contacttype != "") $str = $str . "_contacttype = '" . $contacttype . "' ";
		else $str = $str . "_contacttype = null ";
	
		$str = $str . " WHERE _id = '".$id."' ";
		
		//echo $str;
		//exit();
		mysql_query('SET NAMES utf8');
		mysql_query($str) or die(mysql_error());
		
		if($e_action=='duplicate')
		{
			$str = "INSERT INTO ".$tbname."_contactperson 
				(_customerid,_contacttitle,_contactname,_address1,_address2,_address3,_contacttel,_contactfax,_contacturl,_contactemail,_contactremarks,_thirdpartycompanyid,_thirdpartycontactid,_contacttype)
				VALUES(";
			if($cid != "") $str = $str . "'" . $cid . "', ";
			else $str = $str . "null, ";
					
			if($contacttitle != "") $str = $str . "'" . $contacttitle . "', ";
			else $str = $str . "null, ";
			
			if($contactname != "") $str = $str . "'" . $contactname . "', ";
			else $str = $str . "null, ";
			
			if($address1 != "") $str = $str . "'" . $address1 . "', ";
			else $str = $str . "null, ";
			
			if($address2 != "") $str = $str . "'" . $address2 . "', ";
			else $str = $str . "null, ";
			
			
			if($address3 != "") $str = $str . "'" . $address3 . "', ";
			else $str = $str . "null, ";
			
			
			if($contacttel != "") $str = $str . "'" . $contacttel . "', ";
			else $str = $str . "null, ";
			
			if($contactfax != "") $str = $str . "'" . $contactfax . "', ";
			else $str = $str . "null, ";
			
			if($contacturl != "") $str = $str . "'" . $contacturl . "', ";
			else $str = $str . "null, ";
			
			if($contactemail != "") $str = $str . "'" . $contactemail . "', ";
			else $str = $str . "null, ";
			
			if($contactremarks != "") $str = $str . "'" . $contactremarks . "', ";
			else $str = $str . "null, ";
			
			if($thirdpartycompanyid != "") $str = $str . "'" . $thirdpartycompanyid . "', ";
			else $str = $str . "null, ";
			
			if($thirdpartycontactid != "") $str = $str . "'" . $thirdpartycontactid . "', ";
			else $str = $str . "null, ";		
			
			if($contacttype != "") $str = $str . "'" . $contacttype . "' ";
			else $str = $str . "null ";
			
			$str = $str . ") ";
			
			mysql_query('SET NAMES utf8');
			$result = mysql_query($str);
			
			
			
			//capture action into audit log database
			$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
			$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
			$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
			$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
			$strSQL = $strSQL . "'Customer > Duplicate Contact Person', ";
			
			if ($contactname != "") $strSQL = $strSQL . "'" . replaceSpecialChar($contactname) . "' ";
			else $strSQL = $strSQL . "null ";
		
			$strSQL = $strSQL . ")";
			mysql_query('SET NAMES utf8');
			mysql_query($strSQL);
			//capture action into audit log database	
		}
	
			
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Customer > Edit Contact Person', ";
		
		if ($contactname != "") $strSQL = $strSQL . "'" . replaceSpecialChar($contactname) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
	if($e_action == 'edit')
		echo "<script language='JavaScript'>window.location = 'contactperson.php?ctab=".encrypt('1',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&cid=".encrypt($cid,$Encrypt)."&id=".encrypt($id,$Encrypt)."&type=".encrypt($type,$Encrypt)."&done=".encrypt('2',$Encrypt)."'</script>";
	else
		echo "<script language='JavaScript'>window.location = 'contactperson.php?ctab=".encrypt('1',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&cid=".encrypt($cid,$Encrypt)."&id=".encrypt($id,$Encrypt)."&type=".encrypt($type,$Encrypt)."&done=".encrypt('3',$Encrypt)."'</script>";
	exit();
	}else if($e_action == 'delete')
	{
		
		$emailString = "";
	
		echo $cntCheck = $_POST["cntCheck"];
		
		for ($i=1; $i<=$cntCheck; $i++)
		{
			if ($_POST["CustCheckbox".$i] != "")
			{
				$emailString = $emailString . "_id = '" . $_POST["CustCheckbox".$i] . "' OR ";
			}
		}
		$emailString = substr($emailString, 0, strlen($emailString)-4);
		
		
		 $str = "DELETE FROM ".$tbname."_contactperson  WHERE (" . $emailString . ") ";
		//exit();
		
		mysql_query($str);
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Customer > Delete Contact Person', ";
		
		if ($contactname != "") $strSQL = $strSQL . "'" . replaceSpecialChar($contactname) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = '".$customerpagename."?ctab=".encrypt('1',$Encrypt)."&id=".encrypt($cid,$Encrypt)."&type=".encrypt($type,$Encrypt)."'</script>";
		exit();
	}
?>