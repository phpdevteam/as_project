<?php
		session_start();
		if(!isset($_SESSION['user']) || $_SESSION['user']=="")
		{
		echo "<script language='javascript'>window.location='login.php';</script>";
		exit();
		}
		include('../global.php');	
		include('../include/functions.php');  
		include('access_rights_function.php'); 
 
		
		$ID = trim($_GET["ID"]);
		$Types = trim($_GET["Types"]);
		
		$dirName = $AdminTopCMSImagesPath;
		
		 $str = "SELECT * FROM ".$tbname."_files WHERE _ID = '" . $ID . "' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			  $ImageFile = $rs["_file"];
			 
		}
		
		 
		
		if($ImageFile != "")
		{
			if (file_exists($dirName . $ImageFile))
			{
				unlink($dirName . $ImageFile);
			}	
		}
		
	       $dirName = $AdminTopCMSImagesPath;
			
			$str = "Delete From ".$tbname."_files ";
			$str = $str . "WHERE _ID = '" . $ID . "'";
			
			mysql_query($str) or die(mysql_error());
			
		 
		$str = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$str = $str . "'" . $_SESSION['userid'] . "', ";
		$str = $str . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$str = $str . "'" . date("Y-m-d H:i:s") . "', ";		
		$str = $str . "'Remove " . $Types . " File', ";
		if ($ImageFile != "")
		{
			$str = $str . "'" . replaceSpecialChar($ImageFile) . "' ";
		}
		$str = $str . ")";
		mysql_query($str);

		include('../dbclose.php');
		
		if($_GET['flag'] == 1)
		{
			echo "<script language='javascript'>alert('File Deleted'); window.location = 'admin_edittalentcv.php';</script>";
		}
		else{
			echo "<script language='JavaScript'>alert('File Deleted'); window.opener.location.reload(); window.close();</script>";
		}
	
?>