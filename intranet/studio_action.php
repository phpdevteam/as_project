<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']==""){
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	include('config.php');		
	$RequestAll = $_REQUEST;
	$pagename = "Settings -> Studios -> Studio";
	$DateTime = date("Y-m-d H:i:s");
	// echo '<pre>';print_r($RequestAll);
	if($RequestAll['e_action'] == "edit_studio")
	{
		$db->select(''.$tb_name.'_branch','_Studios',NULL,NULL,'_ID="'.$RequestAll['branch_id'].'"',NULL,NULL); // Table name, Column Names, FIRST JOIN TYPE, JOIN, WHERE conditions, GROUPBY, ORDER BY conditions
		$rs = $db->getResult();
		
		if(count($rs) > 0 )
		{
			$old_record = $rs[0]['_Studios'];
			$new_record = trim($RequestAll['studio_num']);
			if($new_record != $old_record)
			{
				if($old_record > $new_record)
				{
					$where = " _StudioNo > ".$new_record." AND _BranchId=".$RequestAll['branch_id']." ";
					$db->delete(''.$tb_name.'_studios',$where);
				}
				else
				{
					$db->select(''.$tb_name.'_studios','max(_StudioNo)',NULL,NULL,'_BranchId="'.$RequestAll['branch_id'].'"',NULL,NULL); // Table name, Column Names, FIRST JOIN TYPE, JOIN, WHERE conditions, GROUPBY, ORDER BY conditions
					$rs1 = $db->getResult();
					if(count($rs1) > 0 )
					{
						$max_num = trim($rs1[0]['max(_StudioNo)']) != '' ? $rs1[0]['max(_StudioNo)'] : 0;
					}
					else{
						$max_num = 0;
					}
					$insert_num = $new_record - $max_num;
					for($m=1;$m<=$insert_num; $m++)
					{
						$db->insert(''.$tb_name.'_studios',array('_StudioNo'=>$max_num+$m,'_BranchId'=>replaceSpecialChar($RequestAll['branch_id']),'_CreatedDate'=>$DateTime));  // Table name, column names and respective values
						$rs = $db->getResult();
					}
				}
			}
			$db->update(''.$tb_name.'_branch',array('_Studios'=>replaceSpecialChar($new_record)),'_ID="'.$RequestAll['branch_id'].'"'); // Table name, column names and values, WHERE conditions
			$rs = $db->getResult();
		}
		
		$db->insert(''.$tb_name.'_auditlog',array('_UserID'=>$_SESSION['userid'],'_IPAddress'=>$_SERVER['REMOTE_ADDR'],'_LogDate'=>$DateTime,'_Event'=>'Add / Edit Studio','_PageName'=>$pagename,'_TableName'=>"_studios"));  // Table name, column names and respective values
		$rs = $db->getResult();  

		//End Log	
		$db->disconnect();
		echo "<script language='JavaScript'>window.location = 'studio.php?done=1'</script>";
		exit();		
	}
	else if($RequestAll['e_action'] == "add_teacher")
	{
		$particu_studio = trim($RequestAll['studio_id']);
		
		if($particu_studio != '')
		{
			$implod_string = implode('!@#',$RequestAll['teacherID'][$particu_studio]);
			$db->update(''.$tb_name.'_studios',array('_TeacherId'=>trim($implod_string)),'_ID="'.trim($RequestAll['StudioID'.$particu_studio]).'"'); // Table name, column names and values, WHERE conditions
			$rs = $db->getResult();
		}
		else{
			
			for($m = 1;$m<=$RequestAll['total_rec'];$m++)
			{
				$stuID = trim($RequestAll['StudioID'.$m]);
				if(count($RequestAll['teacherID'][$m]) > 0)
				{
					$implod_string = implode('!@#',$RequestAll['teacherID'][$m]);
					$db->update(''.$tb_name.'_studios',array('_TeacherId'=>trim($implod_string)),'_ID="'.trim($stuID).'"'); // Table name, column names and values, WHERE conditions
					$rs = $db->getResult();
				}
				else{
					$db->update(''.$tb_name.'_studios',array('_TeacherId'=>''),'_ID="'.trim($stuID).'"'); // Table name, column names and values, WHERE conditions
					$rs = $db->getResult();
				}
			}
		}
		// die;
		//End Log	
		$db->disconnect();
		echo "<script language='JavaScript'>window.location = 'studio.php?done=1'</script>";
		exit();
	}
	else if($RequestAll['e_action'] == "Archive")
	{	
		$emailString = "";
		
		for ($i=1; $i<=$RequestAll['cntCheck']; $i++)
		{
			if ($RequestAll['CustCheckbox'.$i] != "")
			{
				$emailString = $emailString . "_ID = '" . $RequestAll['CustCheckbox'.$i] . "' OR ";

				//Start Log

					$db->insert(''.$tb_name.'_auditlog',array('_UserID'=>$_SESSION['userid'],'_IPAddress'=>$_SERVER['REMOTE_ADDR'],'_LogDate'=>$DateTime,'_Event'=>$RequestAll['e_action'],'_PageName'=>$pagename,'_TranID'=>$RequestAll['CustCheckbox'.$i],'_TableName'=>"_branch"));  // Table name, column names and respective values
					$rs = $db->getResult();  

				//End Log
			}
		}
	
		$emailString = substr($emailString, 0, strlen($emailString)-4);
	
		$db->update(''.$tb_name.'_branch',array('_StatusID'=>"2"),$emailString);
	
		$db->disconnect();
		echo "<script language='JavaScript'>window.location='branches.php?done=3';</script>";
		exit();		
	}
?>