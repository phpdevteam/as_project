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

	
    $AdminfilePath = "uploadfiles/";


    if($_REQUEST['e_action'] == "objdelete")
	{
		$file = $_REQUEST["file"];
		
		$str = "SELECT * FROM ".$tbname."_companyinfo ";
		
		
		$rst = mysql_query($str, $connect);
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
		    if($file == 1)
			{
				$FileName = $rs['_letterheadimage1'];
			}
			
			//echo $AdminfilePath . $FileName;
				
           	if (file_exists($AdminfilePath . $FileName))
				{	
					
					unlink($AdminfilePath . $FileName);
					if($file == 1)
					{
						$strSQL = "UPDATE ".$tbname."_companyinfo SET ";
						$strSQL = $strSQL . " _letterheadimage1 = null ";	
						mysql_query($strSQL);
					}	
				}				
		}
	
		$str = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$str = $str . "'" . $_SESSION['userid'] . "', ";
		$str = $str . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
		$str = $str . "'Delete Company File Image', ";
		if ($FileName != "")
		{
			$str = $str . "'" . str_replace("'", '&#39;', $FileName) . "' ";
		}
		else
		{
			$str = $str . "null ";
		}
		$str = $str . ")";
		mysql_query($str);
	 
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.alert('File has been deleted successfully!');</script>";
		echo "<script language='JavaScript'>window.location = 'companyinfo.php'</script>";
		exit();

	}	
	
	$id = trim($_REQUEST['id']);
	$companyname1 = trim($_REQUEST['companyname1']);
	$companyaddress1 = trim($_REQUEST['companyaddress1']);	
	$companyaddress2 = trim($_REQUEST['companyaddress2']);
	$companyaddress3 = trim($_REQUEST['companyaddress3']);
	$companytelephone = trim($_REQUEST['telephone']);
	$companyfax = trim($_REQUEST['fax']);
	$countryid = trim($_REQUEST['companycountryid']);
	$postalcode = trim($_REQUEST['postalcode']);	
	$defaultcurrency = trim($_REQUEST['defaultcurrency']);
	
	$companylhead1 = "";
	
	$file1 = trim($_FILES['firstfile']["name"]);
	if($file1)
	{
		move_uploaded_file( $_FILES["firstfile"]['tmp_name'] , "uploadfiles/".$_FILES['firstfile']["name"]);
		$companylhead1 = $_FILES['firstfile']["name"];
	}
		
	$id = $_REQUEST['id'];
	if ($id == "")
	{
		$str = "Insert Into ".$tbname."_companyinfo Values "; 
		$str .= "(";
		$str .= "'". replaceSpecialChar($companyname1) ."',";
		$str .= "'". replaceSpecialChar($companyaddress1) ."',";
		
		$str .= "'". replaceSpecialChar($companyaddress2) ."',";
		$str .= "'". replaceSpecialChar($companyaddress3) ."',";
		if($companylhead1!="")
		$str .= "'". $companylhead1 ."',";
		$str .= "'". $countryid ."',";
		$str .= "'". $postalcode ."',";
		$str .= "'". $defaultcurrency ."'";
		$str .= ")";
		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect) or die(mysql_error());
	}
	else
	{
		$str = "Update ".$tbname."_companyinfo ";
		$str .= " Set _companyname1 = '". replaceSpecialChar($companyname1) ."',";
		if($companylhead1!="")
		$str .= " _letterheadimage1  = '". $companylhead1 ."',";
		$str .= " _companyaddress1 = '". replaceSpecialChar($companyaddress1) ."',";
		$str .= " _companyaddress2 = '". replaceSpecialChar($companyaddress2) ."',";
		$str .= " _companyaddress3 = '". replaceSpecialChar($companyaddress3) ."', ";
		$str .= " _companytelephone = '". replaceSpecialChar($companytelephone) ."', ";
		$str .= " _companyfax = '". replaceSpecialChar($companyfax) ."', ";
		$str .= " _countryid = ". $countryid .", ";
		$str .= " _postalcode = '". replaceSpecialChar($postalcode) ."', ";
		$str .= " _defaultcurrency = '". replaceSpecialChar($defaultcurrency) ."' ";
		$str .= " WHERE _id = '".$id. "'";
		$rst = mysql_query("set names 'utf8';");	
		//echo $str;
		//exit();
		$rst = mysql_query($str, $connect) or die(mysql_error());
	}
	
	include('../dbclose.php');
	echo "<script language='JavaScript'>window.alert('Record has been updated successfully!');</script>";
	echo "<script language='JavaScript'>window.location = 'companyinfo.php'</script>";
	exit();
?>