<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	else
	{		 
		
													
		include('../global.php');
		include('../include/functions.php');
		include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");
	
		$UserID = trim($_GET["id"]);
		$PageNo = trim($_GET['PageNo']);
		$sql = "SELECT * FROM ".$tbname."_user WHERE _ID = '" . $UserID . "' ";
		$rst = mysql_query($sql, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			$Username = $rs["_Username"];
		}
		//
		$i=1;
		$str1 = "SELECT * FROM ".$tbname."_menu where _id <> 6 ORDER BY _Order ASC ";

			$rst1 = mysql_query($str1, $connect) or die(mysql_error());
			if(mysql_num_rows($rst1) > 0)
			{
				while($rs1 = mysql_fetch_assoc($rst1))
				{
					//$i++;
					$i=100;
				}
			}
			
		//
		$j=1;
		$str1 = "SELECT * FROM ".$tbname."_accessright WHERE _UserID = '" . $UserID . "' ";
			$rst1 = mysql_query($str1, $connect) or die(mysql_error());
			if(mysql_num_rows($rst1) > 0)
			{
				while($rs1 = mysql_fetch_assoc($rst1))
				{
					$j++;
				}
			}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title><?php echo $gbtitlename; ?></title>
		<link rel="stylesheet" type="text/css" href="../css/admin.css" />		
		<script type="text/javascript" src="../js/validate.js"></script>
		<script language="javascript">
		<!--								
		function ClearAll()
		{
			for (var i=0;i<document.AccessRight.elements.length;i++) {
				if (document.AccessRight.elements[i].type == "text" || document.AccessRight.elements[i].type == "textarea")
					document.AccessRight.elements[i].value = "";  
				else if (document.AccessRight.elements[i].type == "select-one")
					document.AccessRight.elements[i].selectedIndex = 0;
				else if (document.AccessRight.elements[i].type == "checkbox")
					document.AccessRight.elements[i].checked = false;
			}
		}
		
		function CheckUnChecked(formname, msgType, count, chkbxName)
		{
			if (chkbxName.checked==true)
			{
				for (var i = 1; i<=count; i++)
				{
					eval("document." + formname + "."+msgType+i+".checked = true");
				}
			}
			else
			{
				for (var i = 1; i<=count; i++)
				{
					eval("document." + formname + "."+msgType+i+".checked = false");
				}
			}
		}
		
		function checkSelected(formname, msgtype, count)
		{
			for(var i=1 ; i<=count; i++)
			{
				if(eval("document." + formname + "." + msgtype + i + ".type") == "checkbox")
				{
					if(eval("document." + formname + "." + msgtype + i + ".checked") == true)
					{
						return true;
					}
				}
			}
			return false;
		}
		
		function checkUnSelected(formname, msgtype, count)
		{
			for(var i=1 ; i<=count; i++)
			{
				if(eval("document." + formname + "." + msgtype + i + ".type") == "checkbox")
				{
					if(eval("document." + formname + "." + msgtype + i + ".checked") == false)
					{
						return false;
					}
				}
			}
			return true;
		}
		
		function All()
		{
			if(checkUnSelected('AccessRight', 'MenuBox_', document.AccessRight.cntCheck.value))
			{
				document.AccessRight.AllCheckbox.checked=true;	
			}					
			else
			{
				document.AccessRight.AllCheckbox.checked=false;								
			}
		}
		function isEmpty(data)
{
  var i;

  for (i=0; i < data.length; i++) {
    if (data.charAt(i) != ' ') {
      return false;
    }
  }
  return true;
}
		function WebCMSCheckUnChecked(formname, msgType, tickCheckbox, chkbxName)
		{
			var mySplitResult = tickCheckbox.split(",");
			if (chkbxName.checked==true)
			{
				for (var i = 0; i < mySplitResult.length; i++)
				{
					 if(!isEmpty(mySplitResult[i]))
					 	eval("document." + formname + "." + msgType + mySplitResult[i] + ".checked = true");
				}
			}
			else
			{
				for (var i = 0; i < mySplitResult.length; i++)
				{
					 if(!isEmpty(mySplitResult[i]))
					 	eval("document." + formname + "." + msgType + mySplitResult[i] + ".checked = false");
				}
			}
		}
		//-->
		</script>

		</head>
<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" >
	<table align="center" width="970" border="0" height="100%" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="align:center;">
		<tr>
			<td valign="top">
			<div class="maintable">
				<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">			
						<tr>
							<td valign="top">
								<?php include('topbar.php'); ?>
							</td>
							</tr>
							
						<tr>
							
						<td class="inner-block" width="970" align="left" valign="top">
						<div class="m">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr><td align="left" class="TitleStyle"><b>Settings - System - User Groups & Access Rights </b></td></tr>
										<tr><td height="10"></td></tr>						<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<form action="accessright2.php" method="post" name="AccessRight">
														<input type="hidden" name="UserID" value="<?php echo $UserID;?>">
														<tr>
														  <td align="left"><b>Add/Edit</b></td></tr>
														<tr>
															<td style="color:#000000; border-color:#c3c3c3; border-style:solid; border-width:1px;">
																<input name="AllCheckbox" type="checkbox"   tabindex="" value="All" onClick="CheckUnChecked('AccessRight','MenuBox_',document.AccessRight.cntCheck.value,this);"><b>Select All</b>&nbsp;&nbsp;&nbsp;
																<br><br>															
																<UL>															
																	<?php
																		$str1 = "SELECT * FROM ".$tbname."_menu WHERE (_PID = '0' OR _PID = '77777' )  AND _ID <> '8' ORDER BY _Order, _Title ASC ";
																		$rst1 = mysql_query($str1, $connect) or die(mysql_error());
																		if(mysql_num_rows($rst1) > 0)
																		{	
																			$k =1;
																			while($rs1 = mysql_fetch_assoc($rst1))
																			{	
																	?>		
																				<LI>
																					<input name="MenuBox_<?php echo $k; ?>" type="checkbox"   tabindex="" value="<?php echo $rs1["_ID"]; ?>" <?php															
																					$strr = "SELECT * FROM ".$tbname."_accessright WHERE _UserID = '" . $UserID . "' AND _MID = '" . $rs1["_ID"] . "' ORDER BY _ID ASC ";
																					$rstr = mysql_query($strr, $connect) or die(mysql_error());
																					if(mysql_num_rows($rstr) > 0)
																					{		
																						echo " checked ";
																					}
																					
																					?>
																					onClick="WebCMSCheckUnChecked('AccessRight', 'MenuBox_', document.AccessRight.MenuBox_Child_<?php echo $k; ?>.value, this); ">&nbsp;
																					
																					<b><?php echo $rs1["_Title"]; ?></b>
																					<?php
																						$MenuBox_Child_m .= $k . ",";
																						$m=$k;
																						$k++;
																					?>
																					<?php if($rs1["_PageName"]=="No"){ ?> <UL> <?php } ?>
																					
																					<?
																						$operation="";
																						
																						/*if($rs1["_ID"]==52 || $rs1["_ID"]==53 || $rs1["_ID"]==54 || $rs1["_ID"]==55 || $rs1["_ID"]==56 || $rs1["_ID"]==58 || $rs1["_ID"]==59){ 
																							
																							$operation = array("Add","Edit","Delete");
																						}*/
																						
																						
																						/*if($rs1["_ID"]==65){ 
																							$operation = array("Edit");
																						}*/
																								
																						if($operation!=""){
																							
																							foreach($operation as $ops){
																					?>	
																								<LI>
																									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																									<input name="MenuBox_<?php echo $k; ?>" type="checkbox"   tabindex="" value="<?php echo $rs1["_ID"]; ?>_<?=$ops;?>" 																														
																									<? 
																										$strr = "SELECT * FROM ".$tbname."_accessright WHERE _UserID = '" . $UserID . "' AND _MID = '" . $rs1["_ID"] . "' AND _Operation = '".$ops."' ORDER BY _ID ASC ";
																										$rstr = mysql_query($strr, $connect) or die(mysql_error());
																										if(mysql_num_rows($rstr) > 0){		
																											echo " checked ";
																										}																	
																									?> onClick="WebCMSCheckUnChecked('AccessRight', 'MenuBox_', document.AccessRight.MenuBox_Child_<?php echo $k; ?>.value, this);">&nbsp;&nbsp; - <?=$ops;?>
																								
																									<?	
																										$MenuBox_Child_m .= $k . ",";
																										$MenuBox_Child_n .= $k . ",";
																										$n=$k;
																										$k++;
																										
																										
																									?>
																								</LI>
																								
																								<input type="hidden" name="MenuBox_Child_<?php echo $n; ?>" value="<?php echo $MenuBox_Child_n; ?>">
																								
																								<? $MenuBox_Child_n = ""; ?>
																					<? 		}
																						
																						}else{			
																					
																							$str2 = "SELECT * FROM ".$tbname."_menu WHERE _PID = '" . $rs1["_ID"] . "' ORDER BY _Order ASC ";
																							$rst2 = mysql_query($str2, $connect) or die(mysql_error());
																							if(mysql_num_rows($rst2) > 0)
																							{
																								while($rs2 = mysql_fetch_assoc($rst2))
																								{			   	
																										
																						?>
																									<LI>
																										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="MenuBox_<?php echo $k; ?>" type="checkbox"   tabindex="" value="<?php echo $rs2["_ID"]; ?>" <?php															
																										$strr = "SELECT * FROM ".$tbname."_accessright WHERE _UserID = '" . $UserID . "' AND _MID = '" . $rs2["_ID"] . "' ORDER BY _ID ASC ";
																										$rstr = mysql_query($strr, $connect) or die(mysql_error());
																										if(mysql_num_rows($rstr) > 0)
																										{		
																											echo " checked ";
																										}																	
																										?> onClick="WebCMSCheckUnChecked('AccessRight', 'MenuBox_', document.AccessRight.MenuBox_Child_<?php echo $k; ?>.value, this); ">&nbsp;
																										<?php echo "- ".$rs2["_Title"]; ?>	
																										<?php
																											$MenuBox_Child_m .= $k . ",";
																											$MenuBox_Child_n .= $k . ",";
																											$n=$k;
																											$k++;
																										?>							
																										<?php if($rs2["_PageName"]=="No"){ ?> <UL> <?php } ?>
																										
																										<? 
																											$operation="";
																											// FOR SETTING LINKS
																											/*if($rs2["_ID"] == 49 || $rs2["_ID"] == 50 || $rs2["_ID"] == 51 || $rs2["_ID"] == 13 || $rs2["_ID"] == 22 || $rs2["_ID"] == 25 || $rs2["_ID"] == 74 || $rs2["_ID"] == 75){
																												$operation = array("Add", "Edit", "Delete");
																											}
																											 
																											// FOR USER LINKS
																											if($rs2["_ID"] == 5 || $rs2["_ID"] == 67 || $rs2["_ID"]==71  || $rs2["_ID"]==76 || $rs2["_ID"]==77 ){
																												$operation = array("Add", "Edit", "Delete");
																											}
																											if($rs2["_ID"] == 35){
																												$operation = array("Add", "Edit", "Delete","Archive");
																											}		
																											
																											if($rs2["_ID"] == 41){
																												$operation = array("Add","Edit", "Delete","AccessRights");
																											}		
																											*/
																											
																															
																											if($operation!=""){
																												
																												foreach($operation as $ops){
																										?>	
																													<LI>
																														&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																														<input name="MenuBox_<?php echo $k; ?>" type="checkbox"   tabindex="" value="<?php echo $rs2["_ID"]; ?>_<?=$ops;?>" 																														
																														<? 
																															$strr = "SELECT * FROM ".$tbname."_accessright WHERE _UserID = '" . $UserID . "' AND _MID = '" . $rs2["_ID"] . "' AND _Operation = '".$ops."' ORDER BY _ID ASC ";
																															$rstr = mysql_query($strr, $connect) or die(mysql_error());
																															if(mysql_num_rows($rstr) > 0){		
																																echo " checked ";
																															}																	
																														?> onClick="WebCMSCheckUnChecked('AccessRight', 'MenuBox_', document.AccessRight.MenuBox_Child_<?php echo $k; ?>.value, this);">&nbsp;&nbsp; - <?=$ops;?>
																													
																														<?	
																															$MenuBox_Child_m .= $k . ",";
																															$MenuBox_Child_n .= $k . ",";
																															$MenuBox_Child_p .= $k . ",";
																															$p=$k;
																															$k++;
																														?>
																													</LI>
																													
																													<input type="hidden" name="MenuBox_Child_<?php echo $p; ?>" value="<?php echo $MenuBox_Child_p; ?>">
																													
																													<? $MenuBox_Child_p = ""; ?>
																										<? 		}
																										
																											}else{
																											
																												$str3 = "SELECT * FROM ".$tbname."_menu WHERE _PID = '" . $rs2["_ID"] . "' ORDER BY _Order ASC ";				
																												$rst3 = mysql_query($str3, $connect) or die(mysql_error());
																												if(mysql_num_rows($rst3) > 0)
																												{
																													while($rs3 = mysql_fetch_assoc($rst3))
																													{ 
																										?>                
																														<LI>
																															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="MenuBox_<?php echo $k; ?>" type="checkbox"   tabindex="" value="<?php echo $rs3["_ID"]; ?>" <?php															
																															$strr = "SELECT * FROM ".$tbname."_accessright WHERE _UserID = '" . $UserID . "' AND _MID = '" . $rs3["_ID"] . "' ORDER BY _ID ASC ";
																															$rstr = mysql_query($strr, $connect) or die(mysql_error());
																															if(mysql_num_rows($rstr) > 0)
																															{		
																																echo " checked ";
																															}																	
																															?> onClick="WebCMSCheckUnChecked('AccessRight', 'MenuBox_', document.AccessRight.MenuBox_Child_<?php echo $k; ?>.value, this);">&nbsp;&nbsp;
																															<?php echo "- ".$rs3["_Title"]; ?>
																															<?php
																																$MenuBox_Child_m .= $k . ",";
																																$MenuBox_Child_n .= $k . ",";
																																$MenuBox_Child_p .= $k . ",";
																																$p=$k;
																																$k++;
																															?>
																															<? if($rs3["_PageName"]=="No"){ ?> <UL> <?php } ?>
																															
																																<?
																																	$operation="";
																																	
																																		
																																	
																																	/*if (($rs1["_ID"]==161) || //for Report > (Beside Misc Folder)
																																		($rs2["_PID"]==8) ||  // for and ALL Settings

																																		($rs3["_ID"]==62) || ($rs3["_ID"]==63) || ($rs3["_ID"]==64) || ($rs3["_ID"]==65) || ($rs3["_ID"]==66) || ($rs3["_ID"]==67) || ($rs3["_ID"]==68) || ($rs3["_ID"]==71) || $rs3["_ID"]==69 || $rs3["_ID"]==79 || $rs3["_ID"]==80 || $rs3["_ID"]==81 || $rs3["_ID"]==82 ){  
																																	
																																		$operation = array("Add", "Edit", "Delete");
																																	if($rs3["_ID"] == 9){
																																	$operation = array("Add", "Edit", "Delete","Archive");
																																	}
																																	
																																	
																																		if($rs3["_ID"]==49) array_push($operation, "Access Rights"); //for Setting > System > Groups
																																		
																																		if(($rs3["_ID"]==105) || ($rs3["_ID"]==109)) $operation = ""; //exception for Setting > System > Contacts, My Log Cards
																																		
																																		if(	($rs3["_PID"]==112) || //exception for Setting > Finance/HR
																																			($rs3["_PID"]==80) || //exception for Setting > Contacts
																																			($rs3["_ID"]==147) || ($rs3["_ID"]==148)) //exception for Setting > Report >  Sales Department, Purchase Report 
																																			
																																			$operation = "";
																																		
																																		
																																	}
																																	if($rs3["_ID"]==5 || $rs3["_ID"]==37 || $rs3["_ID"]==39 || $rs3["_ID"]==40 || $rs3["_ID"]==41 || $rs3["_ID"]==42){
																																	$operation = array("Add", "Edit", "Delete");
																																	}
																																	*/
																																	if($operation!=""){
																																		
																																		foreach($operation as $ops){
																																?>	
																																			<LI>
																																				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																																				<input name="MenuBox_<?php echo $k; ?>" type="checkbox"   tabindex="" value="<?php echo $rs3["_ID"]; ?>_<?=$ops;?>" 																														
																																				<? 
																																					$strr = "SELECT * FROM ".$tbname."_accessright WHERE _UserID = '" . $UserID . "' AND _MID = '" . $rs3["_ID"] . "' AND _Operation = '".$ops."' ORDER BY _ID ASC ";
																																					$rstr = mysql_query($strr, $connect) or die(mysql_error());
																																					if(mysql_num_rows($rstr) > 0){		
																																						echo " checked ";
																																					}																	
																																				?> onClick="WebCMSCheckUnChecked('AccessRight', 'MenuBox_', document.AccessRight.MenuBox_Child_<?php echo $k; ?>.value, this);">&nbsp;&nbsp; - <?=$ops;?>
																																			
																																				<?	
																																					$MenuBox_Child_m .= $k . ",";
																																					$MenuBox_Child_n .= $k . ",";
																																					$MenuBox_Child_p .= $k . ",";
																																					$MenuBox_Child_q .= $k . ",";
																																					$q=$k;
																																					$k++;
																																				?>
																																			</LI>
																																			
																																			<input type="hidden" name="MenuBox_Child_<?php echo $q ?>" value="<?php echo $MenuBox_Child_q; ?>">
																																			
																																			<? $MenuBox_Child_q = ""; ?>
																																<? 		}
																																
																																	}else{
																															
																																		$str4 = "SELECT * FROM ".$tbname."_menu WHERE _PID = '" . $rs3["_ID"] . "' ORDER BY _Order ASC ";				
																																		$rst4 = mysql_query($str4, $connect) or die(mysql_error());
																																		if(mysql_num_rows($rst4) > 0)
																																		{
																																			while($rs4 = mysql_fetch_assoc($rst4))
																																			{
																																?>
																																				<LI>
																																					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="MenuBox_<?php echo $k; ?>" type="checkbox"   tabindex="" value="<?php echo $rs4["_ID"]; ?>" <?php															
																																					$strr = "SELECT * FROM ".$tbname."_accessright WHERE _UserID = '" . $UserID . "' AND _MID = '" . $rs4["_ID"] . "' ORDER BY _ID ASC ";
																																					$rstr = mysql_query($strr, $connect) or die(mysql_error());
																																					if(mysql_num_rows($rstr) > 0)
																																					{		
																																						echo " checked ";
																																					}																	
																																					?> onClick="WebCMSCheckUnChecked('AccessRight', 'MenuBox_', document.AccessRight.MenuBox_Child_<?php echo $k; ?>.value, this);">&nbsp;&nbsp;<?php echo "- ".$rs4["_Title"]; ?>
																																					<?php
																																						$MenuBox_Child_m .= $k . ",";
																																						$MenuBox_Child_n .= $k . ",";
																																						$MenuBox_Child_p .= $k . ",";
																																						$MenuBox_Child_q .= $k . ",";
																																						$q=$k;
																																						$k++;
																																					?>
																																					<? if($rs4["_PageName"]=="No"){ ?> <UL> <?php } ?>
																																						
																																						<?
																																							$operation="";
																																							
																																							/*
																																							if(($rs4["_PID"]==147) || ($rs4["_PID"]==148) || ($rs2["_ID"]==80) || ($rs2["_ID"]==112)){ //for Setting > Report > Sales Department, Purchase Report, Setting > Contacts, Setting > Finance / HR
																																								
																																								$operation = array("Add", "Edit", "Delete");
																																								
																																							}
																																							*/		
																																							if($operation!=""){
																																								
																																								foreach($operation as $ops){
																																						?>	
																																									<LI>
																																										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																																										<input name="MenuBox_<?php echo $k; ?>" type="checkbox"   tabindex="" value="<?php echo $rs4["_ID"]; ?>_<?=$ops;?>" 																														
																																										<? 
																																											$strr = "SELECT * FROM ".$tbname."_accessright WHERE _UserID = '" . $UserID . "' AND _MID = '" . $rs4["_ID"] . "' AND _Operation = '".$ops."' ORDER BY _ID ASC ";
																																											$rstr = mysql_query($strr, $connect) or die(mysql_error());
																																											if(mysql_num_rows($rstr) > 0){		
																																												echo " checked ";
																																											}																	
																																										?> onClick="WebCMSCheckUnChecked('AccessRight', 'MenuBox_', document.AccessRight.MenuBox_Child_<?php echo $k; ?>.value, this);">&nbsp;&nbsp; - <?=$ops;?>
																																									
																																										<?	
																																											$MenuBox_Child_m .= $k . ",";
																																											$MenuBox_Child_n .= $k . ",";
																																											$MenuBox_Child_p .= $k . ",";
																																											$MenuBox_Child_q .= $k . ",";
																																											$MenuBox_Child_r .= $k . ",";
																																											$r=$k;
																																											$k++;
																																										?>
																																									</LI>
																																									
																																									<input type="hidden" name="MenuBox_Child_<?php echo $r ?>" value="<?php echo $MenuBox_Child_r; ?>">
																																									
																																									<? $MenuBox_Child_r = ""; ?>
																																						<? 		} 
																																							}
																																						?>
																																					<?php if($rs4["_PageName"]=="No"){ ?> </UL> <?php } ?>
																																					
																																				</LI>
																																				<input type="hidden" name="MenuBox_Child_<?php echo $q; ?>" value="<?php echo $MenuBox_Child_q; ?>">
																																<?php
																																				$MenuBox_Child_q = "";
																																			}
																																		}
																																	}
																																?>
																															<?php if($rs3["_PageName"]=="No"){ ?> </UL> <?php } ?>
																														</LI>		
																														<input type="hidden" name="MenuBox_Child_<?php echo $p; ?>" value="<?php echo $MenuBox_Child_p; ?>">
																										<?
																														$MenuBox_Child_p = "";
																													}
																												}
																											}
																										?>
																										<?php if($rs2["_PageName"]=="No"){ ?> </UL> <?php } ?>
																									</LI>
																									<input type="hidden" name="MenuBox_Child_<?php echo $n; ?>" value="<?php echo $MenuBox_Child_n; ?>">
																					<?php
																									$MenuBox_Child_n = "";
																								}
																							}
																						}
																					?>
																					
																					<?php if($rs1["_PageName"]=="No"){ ?> </UL> <?php } ?>
																				</LI>
																				<input type="hidden" name="MenuBox_Child_<?php echo $m; ?>" value="<?php echo $MenuBox_Child_m; ?>">
																	<?php 
																				$MenuBox_Child_m = "";
																			}
																		} 
																	?>	
																</UL>															
																<input type="hidden" name="cntCheck" value="<?php echo $k-1; ?>">
															</td>
														</tr>								
														<tr><td height="5"></td></tr>
														<tr>
															<td align="left"><input type="button" class="button1" value="&lt; Back" onClick="history.back()">
															&nbsp;<input type="submit" class="button1" name="btnSubmit" value="Submit">
															</td>
																													
														</tr>
														<tr><td height="5"></td></tr>
													</form>
												</table>
											</td>
										</tr>
									</table>
								</div>
					</td>
				</tr>
			</table>
		</body>
		</html>
<?php
		include('../dbclose.php');
	}
?>