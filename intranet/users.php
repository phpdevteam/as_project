<?php
	ini_set('display_errors',0); 
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
    }
	include('../global.php');	
	include('../include/functions.php'); 
		include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");
	
	$Operations = GetAccessRights(25);
	if(count($Operations)== 0)
	{
	 echo "<script language='javascript'>history.back();</script>";
	}

	$currentmenu = "Settings";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?=$gbtitlename?></title>
		<link rel="stylesheet" type="text/css" href="../css/admin.css" />			
	<script type="text/javascript" src="../js/validate.js"></script>
    <? include('jquerybasiclinks10_3.php'); ?>
    <? include('../jqueryinclude.php'); ?>
    <link rel="stylesheet" href="../jquery/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="../jquery/autocomplete/docsupport/prism.css">
    <link rel="stylesheet" href="../jquery/autocomplete/chosen.css" />
<script type="text/javascript" src="../jquery/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
   <script type="text/javascript" src="../js/functions.js"></script>
	<script type="text/javascript" language="javascript">
		<!--
		function validateForm3()
		{
			if(checkSelected('CustCheckbox', document.User.cntCheck.value) == false)
			{
				alert("Please select at least one checkbox.");
				document.User.AllCheckbox.focus();
				return false;
			}
			else
			{
				if(confirm('Are you sure you want to archive the selected User(s)?') == true)
				{
					document.forms.User.action = "useraction.php";
					document.forms.User.submit();
				}
			}
		}

		function checkSelected(msgtype, count)
		{
			for(var i=1 ; i<=count; i++)
			{
				if(eval("document.User." + msgtype + i + ".type") == "checkbox")
				{
					if(eval("document.User." + msgtype + i + ".checked") == true)
					{
						return true;
					}
				}
			}
			return false;
		}
		function clear1()
		{
			document.getElementById('AllCheckbox').checked=false;
			CheckUnChecked('CustCheckbox',document.User.cntCheck.value,document.getElementById('AllCheckbox'));
		
		}
		function CheckUnChecked(msgType, count, chkbxName)
		{
		
			if (chkbxName.checked==true)
			{

				for (var i = 1; i<=count; i++)
				{
					 eval("document.User."+msgType+i+".checked = true");
					 for(var j=1;j<=8;j++)
					 {
						document.getElementById('Row'+j+'ID'+i).className='gridline3'; // Cross-browser
					 }
				}
				
			}
			else
			{
			
				var rowcolor ='gridline1';
				for (var i = 1; i<=count; i++)
				{
					 eval("document.User."+msgType+i+".checked = false");
					 if(rowcolor=='gridline2')
					 {
						 rowcolor='gridline1';
					 }
					 else
					 {
						  rowcolor='gridline2';
					 }
					 for(var j=1;j<=8;j++)
					 {
						
						document.getElementById('Row'+j+'ID'+i).className=rowcolor; // Cross-browser
					 }
				}
			}
		}
		
		function setActivities(fromfield,rowid,rowcolor) { 
			
			if(fromfield.checked == true)
			{				
				for(var i=1;i<=8;i++)
				{
					document.getElementById('Row'+i+'ID'+rowid).className='gridline3'; // Cross-browser
				}
			}
			else
			{
				for(var i=1;i<=8;i++)
				{
					document.getElementById('Row'+i+'ID'+rowid).className=rowcolor; // Cross-browser
				}
			}
		}
		
		function ClearAll()
		{
			for (var i=0;i<document.user_search_form.elements.length;i++) {
				if (document.user_search_form.elements[i].type == "text" || document.user_search_form.elements[i].type == "textarea")
					document.user_search_form.elements[i].value = "";  
				else if (document.user_search_form.elements[i].type == "select-one")
					document.user_search_form.elements[i].selectedIndex = 0;
				else if (document.user_search_form.elements[i].type == "checkbox")
					document.user_search_form.elements[i].checked = false;
			}
		}
		
		function clearDefault()
		{
		 var Username = $("#Username").val();	 
		 if(Username == "Enter User Name")
			 {
				 $("#Username").val("");	
			 } 
			 
		  var Fullname = $("#Fullname").val();	 
		 if(Fullname == "Enter Full Name")
			 {
				 $("#Fullname").val("");	
			 } 
			 
 
		 
		  var servicename1 = $("#servicename1").val();	 
		 if(servicename1 == "Enter Service Name")
			 {
				 $("#servicename1").val("");	
			 } 
			 
			 
		 }
		
		
		//-->
	</script>
</head>
<body>
	<table align="center" width="970" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="align:center;">
		<tr>
			<td valign="top">
			<div class="maintable">
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top">
							<?php include('topbar.php'); ?>
						</td>
					</tr>
			
					<tr>
						<td class="inner-block" align="left" valign="top">
						<div class="m">	
						<!-- START TABLE FOR DIVISION - PRASHANT -->
						<table width="100%" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<!--<td width="15%" valign="top" align="left">-->
							<!-- START CODE FOR LEFT MENU - PRASHANT -->
							<?php
								//$CurrPage = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); /* Getting File Name */
								//include "setting_leftmenu.php";
							?>
							<!-- END CODE FOR LEFT MENU - PRASHANT -->
							<!--</td>-->
							<td>
							
							<!-- START CODE FOR MAIN CONTENT - PRASHANT -->
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
					<td align="left" class="TitleStyle"><b>Settings - System - Users</b></td>
								</tr>
								<tr><td height=""></td></tr>
							</table>
							<?php
							if ($_GET["done"] == 1)
							{
								echo "<div align='left'><font color='#FF0000'>User has been added successfully.<br></font></div>";
							}
							if ($_GET["done"] == 2)
							{
								echo "<div align='left'><font color='#FF0000'>User has been edited successfully.<br></font></div>";
							}
							if ($_GET["done"] == 3)
							{
								echo "<div align='left'><font color='#FF0000'>User has been deleted successfully.<br></font></div>";
							}
							if($_REQUEST['rec']!='')
							{		
								if($_REQUEST['rec'] == '0')
								{
									$str = "<br />File Data Successfully inserted. ";
									if(isset($_GET['error']) && $_GET['error'] != ""){
										$str .= "<br />In uploaded file problem on those rows ".$_GET['error'].".";
									}
									echo "<div align='left'><font color='#FF0000'>$str</font></div>";
								}
								if($_REQUEST['rec'] == '3')
								{
									echo "<script language='javascript'>alert('File already exist');window.location.href='import_users.php';</script>";
								}
							
								if($_REQUEST['rec'] == '4')
								{
									echo "<script language='javascript'>alert('Upload Valid CSV File');window.location.href='import_users.php';</script>";
								}
								
							}
							?>
							<br />
							<div>
							<?php
							$sortBy 		= trim($_GET["sortBy"]);
							$sortArrange	= trim($_GET["sortArrange"]);
							
							$Username	 	= trim($_GET["Username"]);	
							$Fullname 		= trim($_GET["Fullname"]);		
							$Department 	= trim($_GET["Department"]);
							$UserLevel 		= trim($_GET["UserLevel"]);

							//Set the page size
							$PageSize = 10;
							$StartRow = 0;
							
							//Set the page no
							if(empty($_GET['PageNo']))
							{
								if($StartRow == 0)
								{
									$PageNo = $StartRow + 1;
								}
							}
							else
							{
								$PageNo = $_GET['PageNo'];
								$StartRow = ($PageNo - 1) * $PageSize;
							}
							
							//Set the counter start


							if($PageNo % $PageSize == 0)
							{
								$CounterStart = $PageNo - ($PageSize - 1);
							}
							else

							{
								$CounterStart = $PageNo - ($PageNo % $PageSize) + 1;
							}
							
							//Counter End
							$CounterEnd = $CounterStart + ($PageSize - 1);

							$i = 1;
							$Rowcolor = "gridline1";
							
							//display user according to priveledges
							/*if($_SESSION['levelid']==1)
							{
							$str1 = "SELECT user.* FROM ".$tbname."_user user ";									
							$str1 .= "WHERE user._Deleted IS NULL AND user._LevelID <> 4 ";
							}
							else 
							{
							$str1 = "SELECT user.* FROM ".$tbname."_user user ";									
							$str1 .= "WHERE user._Deleted IS NULL AND user._LevelID <> 1 AND user._LevelID <> 4 ";		
							}*/
							//$str2 = $str1 . "ORDER BY _Currencies LIMIT $StartRow,$PageSize ";
							
							$str1 = "select U.*, L._LevelName
									from ".$tbname."_user U left join ".$tbname."_level L on U._LevelID = L._ID  where U._ID!='$AdminId' ";
							
							if ($Username != "") $str1 = $str1 . " AND _Username LIKE '%".replaceSpecialChar($Username)."%' ";
							
							if ($Fullname != "") $str1 = $str1 . " AND _Fullname LIKE '%".replaceSpecialChar($Fullname)."%' ";
						
							if ($Department != "") $str1 = $str1 . " AND _DepartmentID = '".replaceSpecialChar($Department)."' ";
							
							if ($UserLevel != "") $str1 = $str1 . " AND _LevelID = '".replaceSpecialChar($UserLevel)."' ";
	

							if (trim($sortBy) != "" && trim($sortArrange) != "")
								$str2 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
							else
								$str2 = $str1 . " ORDER BY U._status,_Fullname LIMIT $StartRow,$PageSize ";
							
							//echo $str2;
							//exit;
							
							$TRecord = mysql_query($str1, $connect);
							$result = mysql_query($str2, $connect);
							
							//Total of record
							$RecordCount = mysql_num_rows($TRecord);
							
							//Set Maximum Page
							$MaxPage = $RecordCount % $PageSize;
							if($RecordCount % $PageSize == 0)
							{
								$MaxPage = $RecordCount / $PageSize;
							}
							else
							{
								$MaxPage = ceil($RecordCount / $PageSize);
							}
							?>
							
							<form name="user_search_form" action="users.php" method="get" onsubmit="clearDefault()">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                              <tr>
                                <td>
                                  <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                      <td colspan="6"><b>Quick Search/List</b></td>
                                    </tr>
                                    <tr>
                                      <td height="5"></td>
                                    </tr>
                                    <tr>
                                       <td><input type="text" tabindex="" name="Username" id="Username" value="<?=$Username?>" style="width:150"  title="Enter User Name"  class="defaultText"  /></td>
                                      <td><input type="text" tabindex="" name="Fullname" id="Fullname" value="<?=$Fullname?>"  title="Enter Full Name"  class="defaultText"  style="width:150" /></td>
                                      <td><select  tabindex="" name="UserLevel" class="dropdown1 chosen-select">
                                        <option value="">-- Select One --</option>
                                        <?
											$query = "select * from ".$tbname."_level order by _LevelName";
											$row = mysql_query($query,$connect);
											while($data=mysql_fetch_assoc($row)){
										?>
                                        <option value="<?=$data['_ID']?>" <? if($data['_ID']==$UserLevel) echo " selected"; ?>> 
											&nbsp;<?=$data['_LevelName'];?>&nbsp;
										</option>
                                        <?	} ?>
                                      </select></td>
                                      <td> <input type="button" class="button1" name="btnBack" value="< Back" onclick="window.location='settings.php'" /> &nbsp; <input type="submit" name="btnSearch" class="button1" value="Search" />
									  </td>
                                    </tr>
                                   
                                    
                                </table>
								</td>
                              </tr>
                            </table>
							</form>							
							<form name="User" method="post" action="">
                            <table style="margin-top:10px;" cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
									<td colspan="1" class="pageno">
                                    
									<?php
										$QureyUrl = "&amp;Username=".$Username."&amp;Fullname=".$Fullname.
													"&amp;Department=".$Department."&amp;UserLevel=".$UserLevel.
													"&amp;sortBy=".$sortBy."&amp;sortArrange=".$sortArrange;
										if($MaxPage > 0) echo "Page: ";
										for ($i=1; $i<=$MaxPage; $i++)
										{
											if ($i == $PageNo)
											{
												print "<a class=\"selected\" href='?PageNo=". $i . $QureyUrl ."' class='menulink'>".$i."</a> ";
											}
											else
											{
												print "<a class=\"unselect\" href='?PageNo=" . $i . $QureyUrl ."' class='menulink'>".$i."</a> ";
											}
										}

									if (trim($sortArrange) == "DESC")
										$sortArrange = "ASC";
									elseif (trim($sortArrange) == "ASC")
										$sortArrange = "DESC";
									else
										$sortArrange = "DESC";
									?>
									</td>
									<?php
									if ($RecordCount > 0)
										{
										?>
									<td><div align="right"><?php print "$RecordCount record(s) founds - You are at page $PageNo  of $MaxPage"; ?></div></td>
									<?php } ?>
								</tr>
								
									
								<tr><td colspan="2" height="5"><input type="hidden" name="e_action" value="delete" /></td></tr>
								<tr>
									<td align="left">
									<!--
									<input type="button" name="back" class="button1" value="Back To Settings" onclick="window.location='settings.php'" style="width:100px;" />
									-->
                                    <?
								
										if ($RecordCount > 0)
										{
											
											
							if(in_array("Archive",$Operations))
							{
									?>
									
                                    <input type="button" class="button1" name="btnSubmit2" value="Archive" onclick="return validateForm3();" style="width:100px;" />
                                    
                                   
									</td>
									<?
							}
										}
									
									?>
									<td align="right">	
                                   		
                                        <?php
										
							if(in_array("Add",$Operations))
							{
								?>
                                        					
                                    	<a href="user.php" class="TitleLink">Add New User</a>
                                   <?php
							}
							?>
									</td>
								</tr>
								<tr><td colspan="2" height="5"></td></tr>
								<tr>
									<td colspan="2">
										<table cellspacing="0" cellpadding="3" width="100%" border="0" class="grid" >
											<tr>
												<td class="gridheader" width="30" align="center"><input name="AllCheckbox" id="AllCheckbox" type="checkbox"   tabindex="" value="All" onclick="CheckUnChecked('CustCheckbox',document.User.cntCheck.value,this);" /></td>
												<td class="gridheader" width="30" align="center">No.</td>
												<td class="gridheader">
													 <a href="?PageNo=<?=$PageNo?>&amp;sortBy=_Username&amp;sortArrange=<?=$sortArrange?>&amp;Username=<?=$Username?>&amp;Fullname=<?=$Fullname?>&amp;UserLevel=<?=$UserLevel?>" class="link1">User Name</a>
												</td>
												
												<td class="gridheader">
													 <a href="?PageNo=<?=$PageNo?>&amp;sortBy=_Fullname&amp;sortArrange=<?=$sortArrange?>&amp;Username=<?=$Username?>&amp;Fullname=<?=$Fullname?>&amp;UserLevel=<?=$UserLevel?>" class="link1">Full Name</a>
												</td>
												
												<td class="gridheader">
													 <a href="?PageNo=<?=$PageNo?>&amp;sortBy=_Email&amp;sortArrange=<?=$sortArrange?>&amp;Username=<?=$Username?>&amp;Fullname=<?=$Fullname?>&amp;UserLevel=<?=$UserLevel?>" class="link1">Email</a>
												</td>
												
												
												<td class="gridheader">
													<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_LevelName&amp;sortArrange=<?=$sortArrange?>&amp;Username=<?=$Username?>&amp;Fullname=<?=$Fullname?>&amp;UserLevel=<?=$UserLevel?>" class="link1">User Level</a>
												</td>
												
												
												<td class="gridheader"  align="center">
													<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_Status&amp;sortArrange=<?=$sortArrange?>&amp;Username=<?=$Username?>&amp;Fullname=<?=$Fullname?>&amp;UserLevel=<?=$UserLevel?>" class="link1">System Status</a>
												</td>
                                                
                                               
												<td class="gridheader" align="center">Edit</td>
                                               
											</tr>
											<?php
											if ($RecordCount > 0) {
											$i = 1;											
											while($rs = mysql_fetch_assoc($result))
											{
												$bil = $i + ($PageNo-1)*$PageSize;	
												if  ($Rowcolor == "gridline2")
													$Rowcolor = "gridline1";
												else
													$Rowcolor = "gridline2";
													
												 if ($id == $rs["_ID"]) {
														$Rowcolor = "gridline3";
													}	
												?>
												<tr >
													<td id="Row1ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="30" align="center">
													  <input name="CustCheckbox<?php echo $i; ?>" type="checkbox"   tabindex="" value="<?php echo $rs["_ID"]; ?>" onclick="setActivities(this.form.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>');" />
													</td>
													<td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
													<td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="100"><?=$rs["_Username"]?></td>
													<td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" ><?=$rs["_Fullname"]?></td>
													<td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" ><?php echo $rs["_Email"] ?></td>

													
													<td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" ><?=$rs["_LevelName"]?></td>
													
													<td id="Row7ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?php if($rs["_Status"]==1) {echo "Live" ;} else {echo "Archived"; }?></td>                                                    
                                                  
													<td id="Row8ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">
                                   <?php                 
                                                    
							if(in_array("Edit",$Operations))
							{
								?>
                                                    
                                                    
                                                    &nbsp;<a href="user.php?PageNo=<?=$PageNo?>&amp;id=<?=$rs["_ID"]?>&amp;e_action=edit" class="TitleLink">Edit</a>&nbsp;</td>
                                                <?php } ?>  
												</tr>
												<?php
												$i++;
												}
											} else {
												echo "<tr><td colspan='8' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
														}
											?>
										</table>
									</td>
								</tr>
								<tr><td colspan="2" height="5"></td></tr>
								<tr>
									<td align="left">
									<!--
									<input type="button" name="back" class="button1" value="Back To Settings" onclick="window.location='settings.php'" style="width:100px;"/>
									-->
                                    <?
									
										if ($RecordCount > 0)
										{
											
											
							if(in_array("Archive",$Operations))
							{
									?>
									
                                    <input type="button" class="button1" name="btnSubmit2" value="Archive" onclick="return validateForm3();" style="width:100px;" />
                                   </td>
									 <?
									 
							}
										}
									
									?>
									<td align="right"> 
																
                                    						
									</td>
								</tr>								
								<tr><td colspan="2" height="5"><input type="hidden" name="cntCheck" value="<?php echo $i-1; ?>" /></td></tr>
								<tr>
									<td colspan="1" class="pageno">
                                    
									<?php
										if($MaxPage > 0) echo "Page: ";
										for ($i=1; $i<=$MaxPage; $i++)
										{
											if ($i == $PageNo)
											{
												print "<a class=\"selected\" href='?PageNo=". $i . $QureyUrl ."' class='menulink'>".$i."</a> ";
											}
											else
											{
												print "<a class=\"unselect\" href='?PageNo=" . $i . $QureyUrl ."' class='menulink'>".$i."</a> ";
											}
										}
									?>
									</td>
									
								</tr>
							<tr><td>&nbsp;</td></tr>	
							</table>
							</form>														
						  </div>
							<!-- END CODE FOR MAIN CONTENT - PRASHANT -->
							
							</td>
						</tr>
						</table>	
						<!-- END TABLE FOR DIVISION - PRASHANT -->
						
						<!--
						Start Contact
						-->
					</div>		
						</td>
					</tr>
				</table>
			</div>
			</td>
		</tr>
	</table>
    
       <? include('jqueryautocomplete.php') ?>
    
</body>
</html>
<?php		
include('../dbclose.php');
?>