<?php

session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']==""){
	echo "<script language='javascript'>window.location='login.php';</script>";
}else{
	include('../global.php');
	include('../include/functions.php');  include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");       
	$Fullname = trim($_POST["Fullname"]);
	$Fname = trim($_POST["Fname"]);
	$Lname = trim($_POST["Lname"]);
	$Encrypt = "mysecretkey";
	$NewPassword = rawurldecode(encrypt($_POST["NewPassword"], $Encrypt));
	$Email = trim($_POST["Email"]);	
	$Remarks = trim($_POST["Remarks"]);
	
	
		$strSQL = "UPDATE ".$tbname."_user SET ";

		$strSQL = $strSQL . "_Fullname = '";
			if ($Fname != "")
			{
			$strSQL = $strSQL.replaceSpecialChar($Fname) . " ";
			}else{
				$strSQL = $strSQL."";
			}
			if ($Lname != "")
			{
			$strSQL = $strSQL.replaceSpecialChar($Lname) . "',";
			}else{
				$strSQL = $strSQL."',";
			}
		
		if ($Fname != ""){
			$strSQL = $strSQL . "_Fname = '" . replaceSpecialChar($Fname) . "', ";
		}else{
			$strSQL = $strSQL . "_Fname = null, ";
		}
		if ($Lname != ""){
			$strSQL = $strSQL . "_Lname = '" . replaceSpecialChar($Lname) . "', ";
		}else{
			$strSQL = $strSQL . "_Lname = null, ";
		}
		
		if (trim($NewPassword) != ""){
			$strSQL = $strSQL . "_Password = '" . replaceSpecialChar($NewPassword) . "', ";
		}
				
		if ($Email != ""){
			$strSQL = $strSQL . "_Email = '" . replaceSpecialChar($Email) . "', ";
		}else{
			$strSQL = $strSQL . "_Email = null, ";
		}
	
		if($CorrectPassword == "Yes"){
			$strSQL .= "_LastPasswordUpdate = '" . date("Y-m-d H:i:s") . "', ";
		}		
		
		if ($Remarks != ""){
			$strSQL = $strSQL . "_Remarks = '" . replaceSpecialChar($Remarks) . "' ";
		}else{
			$strSQL = $strSQL . "_Remarks = null ";
		}
		
		$strSQL = $strSQL . "WHERE _ID = '" . $_SESSION['userid'] . "'";
	
		//echo $strSQL;
		//exit();
	
		mysql_query($strSQL);
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Edit User Profile', ";
		
		if ($Fullname != ""){
			$strSQL = $strSQL . "'" . replaceSpecialChar($Fullname) . "' ";
		}else{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);	

	include('../dbclose.php');
	
	if(($_SESSION["UpdatePassword"]=="Yes") && ($CorrectPassword == "Yes")){
		echo "<script language='javascript'>window.location='logout.php';</script>";
	}else{
		echo "<script language='javascript'>window.location='userprofile.php?done=1';</script>";
	}
}
?>