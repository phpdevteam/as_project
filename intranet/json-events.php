<?php
	session_start();
	include('../global.php');	
    include('../include/functions.php'); 
	include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");
	$pagename = "Json Events";
	
	$events = array();
	$resources = array();
	
	$RequestAll = $_REQUEST;
	
	$action = $RequestAll['action'];
	$id = $RequestAll['id'];
	$sdate = $RequestAll['sdate'];
	$stime= $RequestAll['stime'];
	$edate = $RequestAll['edate'];
	$etime = $RequestAll['etime'];
	$res = $RequestAll['res'];
	$keywords = $RequestAll['keywords'];
	$m = $RequestAll['m'];
	$staff = decrypt($RequestAll['staff'],$Encrypt);
	
	
	$appDate = $RequestAll["appDate"];
	
	if($action == 'get')
	{
	
		   $str = "Select usr._Fullname,RB._Date,RB._From,RB._To,RB._ID,
		   RB._StaffRef,RB._Title as _Title 
		   From ".$tbname."_appointments RB 
		   left join ".$tbname."_user usr on (RB._StaffRef = usr._ID)";
		   
		   
		   $start = $RequestAll['start'];
		$end = $RequestAll['end'];
		
		if($start!="")
		{
			$str .=" Where Date(RB._Date) between from_unixtime(". $start.", '%Y-%m-%d') 
  and from_unixtime(". $end .", '%Y-%m-%d') ";
		}
		
		if($keywords!="")
		{
			$str .=" And (_Fullname like '%". $keywords ."%'
			Or _Title like '%". $keywords ."%')";
		}
		
		if($m == "m")
		{
			$str .=" And _StaffRef = '". $staff ."'";
		}
		
			if($m == "o")
		{
			$str .=" And _StaffRef <> '". $staff ."'";
		}
		
		$str .= " and RB._Status = 1 ";
		
		// echo $str;
		
		  $result = mysql_query($str) or die(mysql_error());
		
		  $RecordCount = mysql_num_rows($result);

		 if ($RecordCount > 0) {
				$i = 1;											
				while($rs = mysql_fetch_assoc($result))
				{
					$start = $rs['_Date']." ".$rs['_From'];
					$end = $rs['_Date']." ".$rs['_To'];
					$eventsArray['id'] =  $rs['_ID'];					
					$eventsArray['title'] = $rs['_Title'] . " (" . $rs['_Fullname'] .")";
					$eventsArray['start'] = $start;
					$eventsArray['end'] = $end;
					$eventsArray['allDay'] = "";
					$eventsArray['resourceId'] = $rs['_StaffRef'];			
					$events[] = $eventsArray;
				}
			}
			
		 
		echo json_encode($events);
	}
	
	else if($action == 'getres')
	{
		$filterStr ="";
		$str = " Select * From ".$tbname."_user Where _Status = 1 and _Username is not null ";
		$result = mysql_query($str);
		
		$RecordCount = mysql_num_rows($result);
				
		 if ($RecordCount > 0) {
				$i = 1;											
				while($rs = mysql_fetch_assoc($result))
				{
					$resArray['id'] =  $rs['_ID'];
					$resArray['name'] = $rs['_Username'];
					$resArray['color'] = "red";
					
					$resources[] = $resArray;
				}
			}
			
		echo json_encode($resources);
	}
	else if($action == 'changeStaff')
	{		
		mysql_query(" Update ".$tbname."_appointments set _StaffRef='". $res ."' Where 
		_ID='". $id ."'");
	
		echo "<script language='JavaScript'>window.location = 'calendar.php'</script>";
		
	}
	
	else if($action == 'getDetail')
	{
		 
		 $filterStr .= ' RB._ID = "'.$RequestAll["eventid"].'" ';
		   
		
		$str = " Select *,date_format(RB._Date,'%d/%m/%Y') as _Date 
		From ".$tbname."_appointments RB 
					".
							" Where " . $filterStr;
		$result = mysql_query($str);
		$myrow = mysql_fetch_assoc($result);

          ?>       
      
      Event Title : <a class="TitleLink" target="_blank" href="appointment.php?f=cal&id=<?=encrypt($myrow["_ID"],$Encrypt)?>&amp;e_action=<?=encrypt('edit',$Encrypt)?>"><?=$myrow["_Title"]?></a><br/><br/>
      
      Date : <?=$myrow["_Date"]?><br/><br/>   
      Time : From <?=$myrow["_From"]?> To  <?=$myrow["_To"]?> <br/><br/>
      Staff Ref :  
      <!--Staff Ref : <input id="id" name="id" type="hidden" value="<?=$myrow["_ID"]?>" />
      <select  tabindex="" id="res" name="res" class="dropdown1 chosen-select" >
                        
                        <option value="">---Select One---</option>
                        
							<?php
							
	$comquery = "SELECT _ID,_FullName FROM ".$tbname."_user WHERE _status = 1
	 and _Username is not null  ";	 
	
	$comrow = mysql_query('SET NAMES utf8');
	$comrow = mysql_query($comquery,$connect);
	
	$RecordCount = mysql_num_rows($comrow);
				
		 if ($RecordCount > 0) {
				$i = 1;											
				 while($comdata = mysql_fetch_assoc($comrow)){
		
		?>
<option value="<?php echo $comdata["_ID"]; ?>" 
<?=$comdata['_ID']==$myrow["_StaffRef"]?"Selected":""?>>
<?=replaceSpecialCharBack($comdata['_FullName'])?></option>
                                <?php
                                }
                            }
                            ?>
                        </select><br/><br/>   -->     
     
                    
	<?php			
		
	}
	
	else if($action == 'add')
	{
		$date = date('Y-m-d', strtotime(str_replace('-', '/', $sdate)));
			
		$str = " Select * From ".$tbname."_appointments Where _ID='". $id ."' AND _status =1";
		$rs = mysql_query($str);
		
		if(mysql_num_rows($rs) > 0 )
		{
		      mysql_query(" Update ".$tbname."_appointments
					Set _Date = '" .$date."' ,
					_From = '" .$stime."' ,
					_To = '" .$etime."' ,
					_IsAssign = 'Y' ,
					_StaffRef = '" .$res."' 
					Where _ID='". $id ."'");
				
		}
		else
		{
			$myidarr = explode("_",$id);
			$myid = $myidarr[0];
			$mytype = $myidarr[1];
			
			mysql_query(" Update ".$tbname."_appointments
					Set 
					_IsAssign = 'Y' ,
					_StaffRef = '" .$res."' 
					Where _ID='". $myid ."'");
	
			
		}
		
	}
	else if($action == 'delete')
	{
		
		mysql_query(" Update ".$tbname."_appointments set _status=2 Where 
		_ID='". $id ."'");
		
		echo "<script language='JavaScript'>window.location = 'calendar.php'</script>";
		
	}
		
?>
