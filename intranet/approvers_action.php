<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	include('../global.php');
	include('../include/functions.php');
	include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");


	$module =trim( $_REQUEST['modulename']);
	$approver1 = trim($_REQUEST['approver1']);	
	$amt1 = trim($_REQUEST['maxAmt1']) == '' ? '0.00' : trim($_REQUEST['maxAmt1']);	
	// $approver2 = trim($_REQUEST['approver2']);
	$approver2 = trim($_REQUEST['approver2']) == '' ? '0' : trim($_REQUEST['approver2']);	
	
	
	$id = $_REQUEST['id'];
	if ($id == "")
	{
		$str = "Insert into ".$tbname."_approvers(_Module,_FirstApprovers,_FirstAmt,_SecApprovers,_SubmittedDate,_SubmittedBy) Values "; 
		$str .= "(";
		$str .= "'". replaceSpecialChar($module) ."',";
		$str .= "'". replaceSpecialChar($approver1) ."',";
		$str .= "'". replaceSpecialChar($amt1) ."',";
		$str .= "'".replaceSpecialChar($approver2) ."',";
		$str = $str . "'" . date("Y-m-d H:i:s") . "',";
		$str = $str . "'" . $_SESSION['userid'] . "'";
		$str .= ")";
	
		
		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect) or die(mysql_error());
	}
	else
	{
		$str = "Update ".$tbname."_approvers ";
		$str .= " Set _FirstApprovers = '". replaceSpecialChar($approver1) ."',";
		$str .= " _FirstAmt = '". replaceSpecialChar($amt1) ."',";
		$str .= " _SecApprovers = '". replaceSpecialChar($approver2) ."'";
		$str .= " Where _ID = '". $id ."'";		
		

		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect) or die(mysql_error());
	}
	
	include('../dbclose.php');
	echo "<script language='JavaScript'>window.alert('Record has been updated successfully!');</script>";
	echo "<script language='JavaScript'>window.location = 'settings.php'</script>";
	exit();
?>