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
    $ID5 = trim($_REQUEST['ID5']);
	// echo '<pre>';print_r($_REQUEST);
	// echo '<pre>';print_r($_FILES);
    // die;
    

  
	$communityname = replaceSpecialChar($_REQUEST['communityname']);
	$createdby = replaceSpecialChar($_REQUEST['createdby']);
	$approvedstatus = replaceSpecialChar($_REQUEST['approvedstatus']);
	$status = replaceSpecialChar($_REQUEST['status']);
	$comdescription = replaceSpecialChar($_REQUEST['comdescription']);
	$combelifs = replaceSpecialChar($_REQUEST['combelifs']);

    $file444 = replaceSpecialChar($_REQUEST['file444']);

  
    
    $ImageName =$_FILES['ImageName'];


	if($e_action == 'addnew')
	{
		$str = "INSERT INTO ".$tbname."_communities 
				(_CommunityName,_OurBelief,_Description,_CreatedBy ,_ApprovedStatus,_Status,_ImageName,_CreatedDateTime,_UpdatedDateTime)
				VALUES(";
		
		if($communityname != "") $str = $str . "'" . $communityname . "', ";
		else $str = $str . "null, ";

		if($combelifs != "") $str = $str . "'" . $combelifs . "', ";
		else $str = $str . "null, ";
		

		if($comdescription != "") $str = $str . "'" . $comdescription . "', ";
		else $str = $str . "null, ";
		
		
		if($createdby != "") $str = $str . "'" . $createdby . "', ";
		else $str = $str . "null, ";
		
		if($approvedstatus != "") $str = $str . "'" . $approvedstatus . "', ";
		else $str = $str . "null, ";
		
		
		if($status != "") $str = $str . "'" . $status . "', ";
		else $str = $str . "null, ";
		
		if($ImageName["name"][0] != "") $str = $str . "'" .  $ImageName["name"][0] . "', ";
        else $str = $str . "null, ";
        
		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		
		$str = $str . "'" . date("Y-m-d H:i:s") . "'";
		
        $str = $str . ") ";
       
	
		mysql_query('SET NAMES utf8');
		//echo $str;
		//exit();
		
		$result = mysql_query($str) or die(mysql_error().$str);
		if($result==1)
		{
			$communicateid = mysql_insert_id();
		}
		
		//Save files into table.
		$_pageid= $communicateid;
		$_type = "I";
		//include("savefiles.php");
		
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add Communities', ";
		
		if ($communityname != "") $strSQL = $strSQL . "'" . replaceSpecialChar($communityname) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'communities.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('1',$Encrypt)."'</script>";
		exit();
		
	}
	else if($e_action=='edit')
	{
		$str = "UPDATE ".$tbname."_communities SET ";
		
		if($communityname != "") $str = $str . "_CommunityName = '" . $communityname . "', ";
		else $str = $str . "_CommunityName = null, ";

		if($combelifs != "") $str = $str . "_OurBelief = '" . $combelifs . "', ";
		else $str = $str . "_OurBelief = null, ";

		if($comdescription != "") $str = $str . "_Description = '" . $comdescription . "', ";
		else $str = $str . "_Description = null, ";
				
		if($createdby != "") $str = $str . "_CreatedBy = '" . $createdby . "', ";
		else $str = $str . "_CreatedBy = null, ";
				
		if($approvedstatus != "") $str = $str . "_ApprovedStatus = '" . $approvedstatus . "', ";
		else $str = $str . "_ApprovedStatus = null, ";
				
		if($status != "") $str = $str . "_Status = '" . $status . "', ";
		else $str = $str . "_Status = null, ";
				
		if($file444 == "") $str = $str . "_ImageName =  '" . $ImageName["name"][0]  . "', ";
		else $str = $str . "_ImageName =  '" . $file444  . "', ";
		
		$str = $str . "_UpdatedDateTime  = '" . date("Y-m-d H:i:s") . "' ";
	
		
		$str = $str . " WHERE _ID = '".$id."' ";
		
	
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
		$strSQL = $strSQL . "'Edit Communities', ";
		
		if ($id != "") $strSQL = $strSQL . "'" . replaceSpecialChar($id) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
	
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'communitie.php?id=".encrypt($id,$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&done=".encrypt('2',$Encrypt)."'</script>";
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
		
		
		$str = "UPDATE ".$tbname."_communities SET _Status = 2 WHERE (" . $emailString . ") ";
	
		mysql_query($str);
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Delete Communities', ";
		
		if ($emailString != "") $strSQL = $strSQL . "'" . replaceSpecialChar($emailString) . "' ";
		else $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query('SET NAMES utf8');
		mysql_query($strSQL);
		//capture action into audit log database
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'communities.php?PageNo=".$PageNo."&done=3'</script>";
		exit();
    }
    


    if($e_action == 'deletefile')
	{

        $str = "UPDATE ".$tbname."_communities SET `_ImageName` = null WHERE `_ID` = '$ID5'";
				
        mysql_query($str);

        include('../dbclose.php');
        echo "<script language='JavaScript'>alert('File Deleted'); window.opener.location.reload(); window.close();</script>";
		exit();
    }
?>