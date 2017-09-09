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

	$programtypeID = replaceSpecialChar($_REQUEST['programtypeID']);
	$programsubtypeID = replaceSpecialChar($_REQUEST['programsubtypeID']);
	$programsubsubtypeID = replaceSpecialChar($_REQUEST['programsubsubtypeID']);
    $maxperson = replaceSpecialChar($_REQUEST['maxperson']);
    $status = replaceSpecialChar($_REQUEST['status']);
    


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
		$str = "UPDATE ".$tbname."_trainingchargesdetails SET _Status = 2 WHERE (" . $emailString1 . ") ";

		mysql_query($str);

		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'programcharge.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('2',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($id,$Encrypt)."'</script>";
		exit();
	}






	if($e_action == 'addnew')
	{
		$str = "INSERT INTO ".$tbname."_trainingcharges 
				(_TrainingTypeID,_TrainingSubTypeID,_TrainingSubSubTypeID,_Status,_CreatedDateTime,_UpdatedDateTime)
				VALUES(";
		
		if($programtypeID != "") $str = $str . "'" . $programtypeID . "', ";
		else $str = $str . "null, ";
		
		if($programsubtypeID != "") $str = $str . "'" . $programsubtypeID . "', ";
		else $str = $str . "null, ";
		
		if($programsubsubtypeID != "") $str = $str . "'" . $programsubsubtypeID . "', ";
        else $str = $str . "null, ";
        
		$str = $str . "'1', ";
		
		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
	
		$str = $str . "'" . date("Y-m-d H:i:s") . "' ";
		
        $str = $str . ") ";
        
     
	
		mysql_query('SET NAMES utf8');

		
		$result = mysql_query($str) or die(mysql_error().$str);
		if($result==1)
		{
			$programchargid = mysql_insert_id();
		}

		
			$minimum_array[] = $_REQUEST['minimum'];
			$institution_array[] = $_REQUEST['maximum'];
            $normalprice_array[] = $_REQUEST['price'];
            $nsmanprice_array[] = $_REQUEST['nsmanprice'];
			
	/*echo"<pre>";
	print_r($_REQUEST['attFile']);
	echo"</pre>";
	exit;*/


//add data of child table of  as_trainingchargesdetails
		 
	
			for ($i = 0; $i < count($_REQUEST['minimum']); $i++) {
	
			$str = "INSERT INTO ".$tbname."_trainingchargesdetails(_TrainingChargesID,_MinPerson,_MaxPerson,_TotalCost,_NSManTotal,_Status,_CreatedDateTime,_UpdatedDateTime) VALUES (";
	
			if($programchargid != "") $str = $str . "'" . $programchargid . "', ";
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
		$strSQL = $strSQL . "'Add Program Charges', ";
		
		if ($programtypeID != "") $strSQL = $strSQL . "'" . replaceSpecialChar($programtypeID) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'programcharge.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('1',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($programchargid,$Encrypt)."'</script>";
		exit();
		
	}
	else if($e_action=='edit')
	{
		$str = "UPDATE ".$tbname."_trainingcharges SET ";
		
		if($programtypeID != "") $str = $str . "_TrainingTypeID = '" . $programtypeID . "', ";
		else $str = $str . "_TrainingTypeID = null, ";

		if($programsubtypeID != "") $str = $str . "_TrainingSubTypeID = '" . $programsubtypeID . "', ";
		else $str = $str . "_TrainingSubTypeID = null, ";

		if($programsubsubtypeID != "") $str = $str . "_TrainingSubSubTypeID = '" . $programsubsubtypeID . "', ";
		else $str = $str . "_TrainingSubSubTypeID = null, ";

		if($status != "") $str = $str . "_Status =  '" . $status . "', ";
		else $str = $str . "_Status =  null, ";
	
		$str = $str . "_UpdatedDateTime = '" . date("Y-m-d H:i:s") . "' ";
		
		$str = $str . " WHERE _ID = '".$id."' ";
		
		//echo $str;
		//exit();
		mysql_query('SET NAMES utf8');
		mysql_query($str) or die(mysql_error());

	//
		$sql = "DELETE FROM ".$tbname."_trainingchargesdetails WHERE _TrainingChargesID=$id AND `_Status` NOT IN ('2') ";
		mysql_query('SET NAMES utf8');
		$result = mysql_query($sql) or die(mysql_error().$sql);


		$srno_array[] = $_REQUEST['srno'];
		$minimum_array[] = $_REQUEST['minimum'];
		$institution_array[] = $_REQUEST['maximum'];
		$price_array[] = $_REQUEST['price'];
		
/*echo"<pre>";
print_r($_REQUEST['attFile']);
echo"</pre>";
exit;*/


//add data of child table of  as_trainingchargesdetails
		 
	
for ($i = 0; $i < count($_REQUEST['minimum']); $i++) {
	
			$str = "INSERT INTO ".$tbname."_trainingchargesdetails(_TrainingChargesID,_MinPerson,_MaxPerson,_TotalCost,_NSManTotal,_Status,_CreatedDateTime,_UpdatedDateTime) VALUES (";
	
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
		$strSQL = $strSQL . "'Edit Program Charges', ";
		
		if ($id != "") $strSQL = $strSQL . "'" . replaceSpecialChar($id) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
	
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'programcharge.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('2',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($id,$Encrypt)."'</script>";
		exit();
	}
	else if($e_action == 'delete')
	{		
		$emailString = "";

		$emailStringaggr = "";
	
		$cntCheck = $_POST["cntCheck"];
		for ($i=1; $i<=$cntCheck; $i++)
		{
			if ($_POST["CustCheckbox".$i] != "")
			{
				$emailString = $emailString . "_ID = '" . $_POST["CustCheckbox".$i] . "' OR ";

			
			}
		}
	
		$emailString = substr($emailString, 0, strlen($emailString)-4);

		
		
		
		$str = "UPDATE ".$tbname."_trainingcharges SET _Status = 2 WHERE (" . $emailString . ") ";
	
		mysql_query($str);


	

		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Delete Program Charges', ";
		
		if ($emailString != "") $strSQL = $strSQL . "'" . replaceSpecialChar($emailString) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'programcharges.php?PageNo=".$PageNo."&done=3'</script>";
		exit();
	}

?>