<?php



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
	$PageNo = $_REQUEST['PageNo'];
	$DateTime = date("Y-m-d H:i:s");
	
	//var_dump($_REQUEST);
	$Username = trim($_POST["Username"]);
	$Fname = trim($_POST["FName"]);
	$Behaveperson	= trim($_POST["behaveperson"]);
	$status	= trim($_POST["status"]);
	
	$Encrypt = "mysecretkey";
	if($e_action=="AddNew"){
		$Password = rawurldecode(encrypt($_POST["Password"], $Encrypt));
	}else if($e_action=="Edit"){
		$NewPassword = rawurldecode(encrypt($_POST["NewPassword"], $Encrypt));
	}
	
	$Email = trim($_POST["Email"]);	
	$LevelID = trim($_POST["LevelID"]);
	$LevelID = trim($_POST["usergroupid"]);
	$Department = trim($_POST["Department"]);
	$jobtitle = trim($_POST["jobtitle"]);
	$managerid = trim($_POST["managerid"]);
	$remarks = trim($_POST["remarks"]);
	
	if($e_action == "AddNew")
	{		
		$str = "INSERT INTO ".$tbname."_user 
				(_Username,_Fullname,_Fname,_Password,_Email,_JobTitle,_DepartmentID,_LevelID,_ManagerID,_Remarks,_Status)
				VALUES(";
		if($Username != "") $str = $str . "'" . replaceSpecialChar($Username) . "', ";
		else $str = $str . "null, ";
		
		if($Fname != "") $str = $str . "'" . replaceSpecialChar($Fname) . "', ";
		else $str = $str . "null,";
		
		if($Fname != "") $str = $str . "'" . replaceSpecialChar($Fname) . "', ";
		else $str = $str . "null,";
		
		if($Password != "") $str = $str . "'" . replaceSpecialChar($Password) . "', ";
		else $str = $str . "null, ";
		
		if($Email != "") $str = $str . "'" . replaceSpecialChar($Email) . "', ";
		else $str = $str . "null, ";
		
		if($jobtitle != "") $str = $str . "'" . replaceSpecialChar($jobtitle) . "', ";
		else $str = $str . "null,";
		
		if($Department != "") $str = $str . "'" . replaceSpecialChar($Department) . "', ";
		else $str = $str . "null, ";
		
		if($LevelID != "") $str = $str . "'" . replaceSpecialChar($LevelID) . "', ";
		else $str = $str . "null, ";
		
		if($managerid != "") $str = $str . "'" . replaceSpecialChar($managerid) . "', ";
		else $str = $str . "null, ";
		
		if($remarks != "") $str = $str . "'" . replaceSpecialChar($remarks) . "', ";
		else $str = $str . "null, ";
								
		if($status != "") $str = $str . "'" . replaceSpecialChar($status) . "' ";
		else $str = $str . "null ";
			
		$str = $str . ") ";
	
		
		
		mysql_query($str);
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add New User', ";
		
		if ($Fullname != "") $strSQL = $strSQL . "'" . replaceSpecialChar($Fullname) . "' ";
		 $strSQL = $strSQL . "null ";
	
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
		//capture action into audit log database
		
		$str = "SELECT MAX(_ID) AS MaxID FROM ".$tbname."_user ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0) {
			$rs = mysql_fetch_assoc($rst);
			$MaxID = $rs['MaxID'];							
		}

		// new code added by nirav 
		if($group != "")
		{
		$str = "insert into ntt_group_user_detail(_GroupID,_UserId,_BookTypeID) values(".$group.",".$MaxID.",0)";
		mysql_query($str);
		}
		// end of the new code
				
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'users.php?PageNo=".$PageNo."&done=1'</script>";
		exit();
	
	}else if($e_action == "Edit"){
	
		$oldGroup="";
		if($group != "")
		{
		$str = "select _GroupID from ntt_user where _ID='" . $id . "' ";
		$rsGroupList=mysql_query($str);
		if(mysql_num_rows($rsGroupList)>0)
		{
			$recGroupList=mysql_fetch_array($rsGroupList);
			
			if(trim($recGroupList[_GroupID])!="")
			{
			$oldGroup=trim($recGroupList[_GroupID]);
			}
		}
		}
	
		$str = "UPDATE ".$tbname."_user SET ";
		if ($NewPassword != "")		
			$str = $str . "_Password = '" . replaceSpecialChar($NewPassword) . "', ";
			
		$str = $str . "_Fullname = '";
		if($Fname != "")
			{
				$str = $str.replaceSpecialChar($Fname)."' ,";
			}
		else
			{
				$str = $str."";
			}
			
			$str = $str . "_Fname = '";
		if($Fname != "")
			{
				$str = $str.replaceSpecialChar($Fname)."' ,";
			}
		else
			{
				$str = $str."";
			}
					
		if($Email != "") $str = $str . "_Email = '" . replaceSpecialChar($Email) . "', ";		
		else $str = $str . "_Email = null, ";
		
		if($LevelID != "") $str = $str . "_LevelID = '" . replaceSpecialChar($LevelID) . "', ";		
		else $str = $str . "_LevelID = null, ";
		
		if($jobtitle != "") $str = $str . "_JobTitle = '" . replaceSpecialChar($jobtitle) . "', ";		
		else $str = $str . "_JobTitle = null, ";
		
		
		if($remarks  != "") $str = $str . "_Remarks = '" . replaceSpecialChar($remarks) . "', ";		
		else $str = $str . "_Remarks = null, ";
		
			
		if($DateTime != "")		
			$str = $str . "_ModifiedDate = '" . replaceSpecialChar($DateTime) . "' ,";		
		else		
			$str = $str . "_ModifiedDate = null ,";
		
		if($managerid != "") $str = $str . "_ManagerID = '" . replaceSpecialChar($managerid) . "', ";		
		else $str = $str . "_ManagerID = null, ";
	
		if($status != "")		
			$str = $str . "_Status = '" . replaceSpecialChar($status) . "' ";		
		else		
			$str = $str . "_Status = null ";
				
		$str = $str . " WHERE _ID = '" . $id . "' ";
		
		//echo $str;
		//exit();
		mysql_query($str);
		
		
		//capture action into audit log database
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Edit User', ";
		if ($Fullname != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($Fullname) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'users.php?PageNo=".$PageNo."&done=2'</script>";
        
		exit();
	
	}elseif ($e_action == 'delete'){
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
	
		$str = "SELECT DISTINCT _Fname FROM ".$tbname."_user WHERE (" . $emailString . ") ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			while($rs = mysql_fetch_assoc($rst))
			{
				$str = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
				$str = $str . "'" . $_SESSION['userid'] . "', ";
				$str = $str . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
				$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
				$str = $str . "'Delete User', ";
				if ($rs["_Fname"] != "")
				{
					$str = $str . "'" . str_replace("'", '&#39;', $rs["_Fname"]) . "' ";
				}
				else
				{
					$str = $str . "null ";
				}
				$str = $str . ")";
				mysql_query($str);
			}
		}
		$str = "UPDATE ".$tbname."_user SET _Status = 2 ";
		$str = $str . " WHERE (" . $emailString . ") ";
		
		mysql_query($str);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location='users.php?done=3';</script>";
		exit();
	}	
?>