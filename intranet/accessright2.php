<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	else
	{
		include('../dbopen.php');
		include('../include/functions.php');include('access_rights_function.php'); 
		include("fckeditor/fckeditor.php");
		mysql_select_db($database, $connect) or die(mysql_error());									
		$UserID = $_POST["UserID"];
		//exit;
		$cntCheck = $_POST["cntCheck"];
		
		$sql = "SELECT * FROM ".$tbname."_level WHERE _ID = '" . $UserID . "' ";
		$rst = mysql_query($sql, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			$Username = $rs["_LevelName"];					
		}
		
		$str = "DELETE FROM ".$tbname."_accessright WHERE _UserID = '" . $UserID . "' ";
		mysql_query($str);
		for($i = 1; $i <= $cntCheck; $i++) 
		{
			if($_POST["MenuBox_$i"]!= "")
			{
				$temp = explode("_", $_POST["MenuBox_$i"]);
				
				if(count($temp)>1){
				
					$strSQL = "INSERT INTO ".$tbname."_accessright (_MID, _UserID, _Operation) 
								VALUES ('".$temp[0]."', '".$UserID."', '".$temp[1]."')";
					
				}else{
				
					$strSQL = "INSERT INTO ".$tbname."_accessright (_MID, _UserID) VALUES (";										
					if($_POST["MenuBox_$i"]!= "")
						$strSQL = $strSQL . "'" . $_POST["MenuBox_$i"] . "', ";
					else
						$strSQL = $strSQL . "null, ";						
					if($UserID != "")
						$strSQL = $strSQL . "'" . $UserID . "' ";
					else
						$strSQL = $strSQL . "null ";
					$strSQL = $strSQL . ")";
				}
				//echo $strSQL;
				
				
				mysql_query($strSQL);
			}													
		}
		//exit;
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID,_UserType,_IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SESSION['usertype'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Edit Access Right', ";
		if ($Username != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($Username) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";					
		mysql_query($strSQL);			
				
		include('../dbclose.php');
		//exit;
		echo "<script language='JavaScript'>window.location = 'level.php?done=4'</script>";
		
		/*if(isset($_SESSION['edituserfrompage']) && $_SESSION['edituserfrompage']!="")
			echo "<script language='javascript'>window.location='".$_SESSION['edituserfrompage']."&done=1';</script>";
		else		
			echo "<script language='javascript'>window.location='group.php?SearchBy=SearchBy1&done=1';</script>";*/
	}
?>
