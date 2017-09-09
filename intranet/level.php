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
	$Operations = GetAccessRights(14);
				if(count($Operations)== 0)
				{
				 echo "<script language='javascript'>history.back();</script>";
				}
	
	$btnSubmit = "Add New";
	$id = $_GET['id'];
	$e_action = $_GET['e_action'];
	$currentmenu = "Settings";
	
	if($id != "" && $e_action == 'edit')
	{
		$str = "SELECT * FROM ".$tbname."_level WHERE _ID = '".$id."' ";
		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			$LevelName = $rs["_LevelName"];	
			$status = $rs["_Status"];				
			$btnSubmit = "Update";
		}
	}

	if($_GET['error'] == 1)
	{
		$LevelName = $_GET["LevelName"];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo $gbtitlename; ?></title>
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
	 
		function validateForm()
		{
			var errormsg;
            errormsg = "";					
            if (document.FormName.LevelName.value == 0)
                errormsg += "Please fill in 'Level'.\n";
						
            if ((errormsg == null) || (errormsg == ""))
            {
                document.FormName.btnSubmit.disabled=true;
                return true;
            }
            else
            {
                alert(errormsg);
                return false;
            }
		}
		
		
		function validateForm3()
		{
			if(checkSelected('CustCheckbox', document.FormName2.cntCheck.value) == false)
			{
				alert("Please select at least one checkbox.");
				document.FormName2.AllCheckbox.focus();
				return false;
			}
			else
			{
				if(confirm('Are you sure you want to archive the selected Record(s)?') == true)
				{
					
					document.forms.FormName2.action = "level_action.php";
					document.forms.FormName2.submit();
				}
			}
		}

		function checkSelected(msgtype, count)
		{
			for(var i=1 ; i<=count; i++)
			{
				if(eval("document.FormName2." + msgtype + i + ".type") == "checkbox")
				{
					if(eval("document.FormName2." + msgtype + i + ".checked") == true)
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
			CheckUnChecked('CustCheckbox',document.FormName2.cntCheck.value,document.getElementById('AllCheckbox'));
		
		}
		function CheckUnChecked(msgType, count, chkbxName)
		{
			if (chkbxName.checked==true)
			{

				for (var i = 1; i<=count; i++)
				{
					 eval("document.FormName2."+msgType+i+".checked = true");
					
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
					 eval("document.FormName2."+msgType+i+".checked = false");
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
		
	</script>
</head>
<body>
	<table align="center" width="970" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="align:center;">
		<tr>
			<td valign="top">
			<div class="maintable">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top">
							<?php include('topbar.php'); ?>
						</td>
					</tr>
				
					<tr>
						<td class="inner-block" width="970" align="left" valign="top">	
						<div class="m">	
						<!-- START TABLE FOR DIVISION - PRASHANT -->
						<table width="100%" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<!-- <td width="20%" valign="top" align="left"> -->
							<!-- START CODE FOR LEFT MENU - PRASHANT -->
							<?php
								//$CurrPage = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); /* Getting File Name */
								//include "setting_leftmenu.php";
							?>
							<!-- END CODE FOR LEFT MENU - PRASHANT -->
							<!-- </td> -->
							<td>
							
							<!-- START CODE FOR MAIN CONTENT - PRASHANT -->

						
						<!--
						Start Contact
						-->
							<table cellpadding="0" cellspacing="0" border="0">
								<tr>
								  <td align="left" class="TitleStyle"><b>Settings - System - User Groups & Access Rights </b></td>
								</tr>
								<tr><td height=""></td></tr>
							</table>
							<form name="FormName" action="level_action.php" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?=$id?>" />
							<input type="hidden" name="e_action" value="<?=($e_action == "" ? "AddNew" : "Edit")?>" />
							<input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
									<td style="padding-top:5px;" colspan="3"><b>Add User Group</b></td>
								</tr>
								<tr><td height="5"></td></tr>
								<tr>
									<td width="120">User Group </td>
									<td width="10">&nbsp;:&nbsp;</td>
									<td><input type="text" tabindex="" name="LevelName" value="<?=$LevelName?>" class="txtbox1" style="width:220" /> <span class="detail_red">*</span></td>
								</tr>								
								<tr><td height="5"></td></tr>
                                
                                <? if ($e_action=="edit") { ?>								
								<tr>
									<td nowrap>System Status</td>
									<td>&nbsp;:&nbsp;</td>
									<?php
									$sel_status_y = "";
									$sel_status_n = "";
									if($status == 1){
										$sel_status_y = "checked='checked'";
										$sel_status_n="";
									}
									else
									{
										
										if($e_action!='edit')
										{
											$sel_status_y="checked='checked'";
											$sel_status_n ="" ;
											
										}
										else
										{
											$sel_status_y="";
											$sel_status_n ="checked='checked'";
										}
									}
									?>		
									<td><input type="radio"   tabindex="" <?php echo $sel_status_y; ?> name="status" value="1" id="RadioGroup1_0" class="radio" />Live
									<input type="radio"   tabindex="" <?php echo $sel_status_n; ?> name="status" value="2" id="RadioGroup1_1" class="radio" />Archive</td>   
								</tr>    
                                <? } ?> 
                                
                                <tr><td height="5"></td></tr>
                                
								<tr>
									<td colspan="2">&nbsp;</td>
									<td>
                                    
                                    <input type="button" class="button1" name="btnBack" value="< Back" onclick="window.location='settings.php';" />&nbsp;&nbsp;
										<input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />									</td>
										
								</tr>
							</table>
							</form>
							<?php
								if ($_GET["done"] == 1)
								{
									echo "<div align='left'><font color='#FF0000'>Level has been added successfully.<br></font></div>";
								}
								if ($_GET["done"] == 2)
								{
									echo "<div align='left'><font color='#FF0000'>Level has been edited successfully.<br></font></div>";
								}
								if ($_GET["done"] == 3)
								{
									echo "<div align='left'><font color='#FF0000'>Level has been archived successfully.<br></font></div>";
								}
								/* START CODE FOR SUCCESS EDIT ON ACCESSRIGHTS - HARESH */
								if ($_GET["done"] == 4)
								{
									echo "<div align='left'><font color='#FF0000'>Access Right has been edited successfully.<br></font></div>";
								}
								/* END CODE FOR SUCCESS EDIT ON ACCESSRIGHTS - HARESH */
								if ($_GET["error"] == 1)
								{
									echo "<div align='left'><font color='#FF0000'>Level [".$LevelName."] is existed in the system. Please enter another Level.<br></font></div>";
								}
							?>
							<?php
							$sortBy = trim($_GET["sortBy"]);
							$sortArrange = trim($_GET["sortArrange"]);
							
							$Keywords 		= trim($_GET["Keywords"]);

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
							$str1 = "SELECT l._ID, l._LevelName, l._SubDate,  l._Status, u._Fullname as _SubBy, ss._statusname 
							FROM ".$tbname."_level l 
							INNER JOIN ".$tbname."_systemstatus ss ON ss._id = l._Status  
							INNER JOIN ".$tbname."_user u ON u._ID = l._SubBy  
							";							
							if($Keywords != "")
							{
							$str1 .=" and _LevelName Like '". $Keywords."'";		
							}

							if (trim($sortBy) != "" && trim($sortArrange) != "")
								$str2 = $str1 . "ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
							else
								$str2 = $str1 . "ORDER BY _Status,_LevelName LIMIT $StartRow,$PageSize ";
							
							
							
							
							$TRecord = mysql_query("set names 'utf8';");	
							$result = mysql_query("set names 'utf8';");
							
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
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
									<td colspan="2"><b>User Group List</b></td>
								</tr>
                                
                                
                                 <form name="search_form" action="level.php" method="get" onsubmit="clearDefault()">
                                <tr> 
                                  <td><input type="text" tabindex="" title="Group Name" name="Keywords" id="Keywords" value="<?=$Keywords?>" class="defaultText" />&nbsp;&nbsp;<input type="submit" name="btnSearch" class="button1" value="Search" /></td>                                  
                                </tr>
                                </form>
                                
								<tr><td colspan="2" height="5"></td></tr>
								<tr>
									<td colspan="2" class="pageno">
									<?php
										$QureyUrl = "&amp;Keywords=".$Keywords."&amp;sortBy=".$sortBy."&amp;sortArrange=".$sortArrange."";
											$pageshowlimit = 20;
                        $pageshowpoint = $_GET['pageshowpoint'];
                        if ($pageshowpoint != "" && is_numeric($pageshowpoint)) {
                          $pageshowpoint = (int) $pageshowpoint;
                        } else {
                          $pageshowpoint = 0;
                        }
                        $pageshowstart = (int) $pageshowpoint + 1;
                        $pageshowend = (int) $pageshowpoint + (int) $pageshowlimit;

                        if ((int) $pageshowpoint == 0) {
                          $sProjectPrev = "";
                        } elseif ((int) $pageshowpoint > 0) {
                          $sProjectPrev = "<a href='?PageNo=" . ((int) $pageshowpoint - (int) $pageshowlimit + 1) . "&amp;pageshowpoint=" . ((int) $pageshowpoint - (int) $pageshowlimit) . $QureyUrl . "' class='menulink'>Previous " . $pageshowlimit . "</a> ";
                        }

                        if ((int) $MaxPage <= (int) $pageshowend) {
                          $sProjectNext = "";
                        } elseif ((int) $MaxPage > (int) $pageshowend) {
                          $sProjectNext = "<a href='?PageNo=" . ((int) $pageshowpoint + (int) $pageshowlimit + 1) . "&amp;pageshowpoint=" . ((int) $pageshowpoint + (int) $pageshowlimit) . $QureyUrl . "' class='menulink'>Next " . $pageshowlimit . "</a> ";
                        }               

                        
                        if ($sProjectPrev != ""){
                            print $sProjectPrev . "&nbsp;&nbsp;";
                        }
                          
                        if ((int) $MaxPage < (int) $pageshowend) {
                            $untilpage = (int) $MaxPage;
                        } else {
                            $untilpage = (int) $pageshowend;
                        }

                        if ((int) $untilpage == 0) {
                          $untilpage = 1;
                        }
                      
                        if($MaxPage > 0) echo "Page: ";

                        for ($i = (int) $pageshowstart; $i <= (int) $untilpage; $i++) 
                        {
                            if ($i == $PageNo)
                            {
                                print "<a class=\"selected\" href='?PageNo=". $i. "&amp;pageshowpoint=" . $_GET['pageshowpoint'] . $QureyUrl ."' class='menulink'>".$i."</a> ";
                            }
                            else
                            {
                                print "<a class=\"unselect\" href='?PageNo=" . $i. "&amp;pageshowpoint=" . $_GET['pageshowpoint'] . $QureyUrl ."' class='menulink'>".$i."</a> ";
                            }
                        }
                
                        if ($sProjectNext != "") {
                          print "&nbsp;&nbsp;" . $sProjectNext;
                        }
										
									if (trim($sortArrange) == "DESC")
										$sortArrange = "ASC";
									elseif (trim($sortArrange) == "ASC")
										$sortArrange = "DESC";
									else
										$sortArrange = "DESC";

									?>
									</td>
								</tr>
                                <tr>
                                <td align="left">
                                    <?
								
										if ($RecordCount > 0)
										{
											
											
							if(in_array("Archive",$Operations))
							{
									?>
									
                                    <input type="button" class="button1" name="btnSubmit2" value="Archive" onclick="return validateForm3();" style="width:100px;" />
                                    
                                    &nbsp;
                                    <?
										}
										}
									
									?>
									</td>
                                	<td align="right">
                                    
                                    <?php
									
							if(in_array("Add",$Operations))
							{
								?>
                                    
                                    <a href="level.php" class="TitleLink">Add New</a>
                                    
                                    <?php
							}
							?>
                                   
									</td>   </tr>
								<tr><td colspan="2" height="5"></td></tr>
								<tr>
									<td colspan="2">
                                    
                                     <form name="FormName2" method="post" action="">
                            	<input type="hidden" name="e_action" value="curdelete" />
                                    
										<table cellspacing="0" cellpadding="2" width="100%" border="0" class="grid">
											<tr>
                                            
                                            <td class="gridheader" width="30" align="center"><input name="AllCheckbox" id="AllCheckbox" type="checkbox" value="All" onclick="CheckUnChecked('CustCheckbox',document.FormName2.cntCheck.value,this);" /></td>
												
												<td class="gridheader" width="30" align="center">No.</td>
												<td class="gridheader">&nbsp;&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_LevelName&amp;sortArrange=<?=$sortArrange?>" class="link1">User Group</a></td>
												<!-- START CODE FOR ADD ACCESS RIGHTS HEADING - HARESH -->
												                                        <td class="gridheader" align="center">&nbsp;&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=l._SubDate&amp;sortArrange=<?=$sortArrange?>&amp;Keywords=<?=$Keywords?>" class="link1">Submitted Date</a></td>
                                                <td class="gridheader" align="center">&nbsp;&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=l._SubBy&amp;sortArrange=<?=$sortArrange?>&amp;Keywords=<?=$Keywords?>" class="link1">Submitted By</a></td>
                                                <td class="gridheader" align="center">&nbsp;&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=l._Status&amp;sortArrange=<?=$sortArrange?>&amp;Keywords=<?=$Keywords?>" class="link1">System Status</a></td>  
                                                
                                                						
													<td width="80" class="gridheader" align="center">Access Right</td>
												<!-- END CODE FOR ADD ACCESS RIGHTS HEADING - HARESH -->
												<td class="gridheader" width="80" align="center">Edit</td>
											</tr>
											<?php
											if($RecordCount!="")
											{
												$i = 1;
												$Rowcolor = "gridline1";
												while($rs = mysql_fetch_assoc($result))
												{
													$bil = $i + ($PageNo-1)*$PageSize;	
													if  ($Rowcolor == "gridline2")
														$Rowcolor = "gridline1";
													else
														$Rowcolor = "gridline2";
	
													if($id == $rs["_ID"]) $Rowcolor = "gridline3";
													?>
													<tr >
                                                    
                                                    <td id="Row1ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="30" align="center">
													  <input name="CustCheckbox<?php echo $i; ?>" type="checkbox" value="<?php echo $rs["_ID"]; ?>" onclick="setActivities(this.form.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>');" />
														</td>
														<td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
														<td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="left" >&nbsp;
														<?php													
														echo $rs["_LevelName"]
														?>&nbsp;
														</td> 
                                                        
                                                         <td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="center">&nbsp;<?php echo $rs["_SubDate"]!=""?date(DEFAULT_DATEFORMAT,strtotime(replaceSpecialCharBack($rs["_SubDate"]))):"" ?>&nbsp;</td>
                                                        <td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="center">&nbsp;<?php echo $rs["_SubBy"]; ?>&nbsp;</td>
                                                        <td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="center">&nbsp;<?php echo $rs["_statusname"]; ?>&nbsp;</td>  
														
														<!-- START CODE FOR ADD ACCESS RIGHTS ROW - HARESH -->
														
														<td id="Row7ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<? if($rs["_ID"]!='1'){?><a href="accessright.php?PageNo=<?=$PageNo?>&amp;id=<?=$rs["_ID"]?>&amp;e_action=edit" class="TitleLink">Manage</a><? } ?>&nbsp;</td>
														
														<!-- END CODE FOR ADD ACCESS RIGHTS ROW - HARESH -->
														
														<td id="Row8ID<?=$i?>"  class="<?php echo $Rowcolor; ?>" valign="top" align="center">&nbsp;<? if($rs["_ID"]!='1'){?>
                                                        
                                 <?php                       
							if(in_array("Edit",$Operations))
							{
								?>
                                                        
                                                        <a href="?PageNo=<?=$PageNo?>&amp;id=<?=$rs["_ID"]?>&amp;e_action=edit" class="TitleLink">Edit</a><? } ?>&nbsp;
														<?php
														}
														?>
                                                        </td>
                                                        </tr>
													<?php
													$i++;
												}											
											} else {
												echo "<tr><td colspan='8' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											?>
                                            
                                            <tr><td colspan="2" height="5"><input type="hidden" name="cntCheck" value="<?php echo $i-1; ?>" /></td></tr>
                                            
										</table>
                                        
                                        </form>
                                       
                                        
									</td>
								</tr>
								<tr><td colspan="2" height="5"></td></tr>
								 <tr>
                                <td align="left">
                                    <?
								
										if ($RecordCount > 0)
										{
											
							if(in_array("Archive",$Operations))
							{
									?>
									
                                    <input type="button" class="button1" name="btnSubmit2" value="Archive" onclick="return validateForm3();" style="width:100px;" />
                                    
                                    &nbsp;
                                    <?
										}
										
										}
									
									?>
									</td>
                                	<td align="right">
                                
                                   
									</td>   </tr>
								<tr><td colspan="2" height="5"></td></tr>
								<tr>
									<td colspan="2" class="pageno">
									<?php
										$QureyUrl = "&amp;Keywords=".$Keywords."&amp;sortBy=".$sortBy."&amp;sortArrange=".$sortArrange."";
											$pageshowlimit = 20;
                        $pageshowpoint = $_GET['pageshowpoint'];
                        if ($pageshowpoint != "" && is_numeric($pageshowpoint)) {
                          $pageshowpoint = (int) $pageshowpoint;
                        } else {
                          $pageshowpoint = 0;
                        }
                        $pageshowstart = (int) $pageshowpoint + 1;
                        $pageshowend = (int) $pageshowpoint + (int) $pageshowlimit;

                        if ((int) $pageshowpoint == 0) {
                          $sProjectPrev = "";
                        } elseif ((int) $pageshowpoint > 0) {
                          $sProjectPrev = "<a href='?PageNo=" . ((int) $pageshowpoint - (int) $pageshowlimit + 1) . "&amp;pageshowpoint=" . ((int) $pageshowpoint - (int) $pageshowlimit) . $QureyUrl . "' class='menulink'>Previous " . $pageshowlimit . "</a> ";
                        }

                        if ((int) $MaxPage <= (int) $pageshowend) {
                          $sProjectNext = "";
                        } elseif ((int) $MaxPage > (int) $pageshowend) {
                          $sProjectNext = "<a href='?PageNo=" . ((int) $pageshowpoint + (int) $pageshowlimit + 1) . "&amp;pageshowpoint=" . ((int) $pageshowpoint + (int) $pageshowlimit) . $QureyUrl . "' class='menulink'>Next " . $pageshowlimit . "</a> ";
                        }               

                        
                        if ($sProjectPrev != ""){
                            print $sProjectPrev . "&nbsp;&nbsp;";
                        }
                          
                        if ((int) $MaxPage < (int) $pageshowend) {
                            $untilpage = (int) $MaxPage;
                        } else {
                            $untilpage = (int) $pageshowend;
                        }

                        if ((int) $untilpage == 0) {
                          $untilpage = 1;
                        }
                      
                        if($MaxPage > 0) echo "Page: ";

                        for ($i = (int) $pageshowstart; $i <= (int) $untilpage; $i++) 
                        {
                            if ($i == $PageNo)
                            {
                                print "<a class=\"selected\" href='?PageNo=". $i. "&amp;pageshowpoint=" . $_GET['pageshowpoint'] . $QureyUrl ."' class='menulink'>".$i."</a> ";
                            }
                            else
                            {
                                print "<a class=\"unselect\" href='?PageNo=" . $i. "&amp;pageshowpoint=" . $_GET['pageshowpoint'] . $QureyUrl ."' class='menulink'>".$i."</a> ";
                            }
                        }
                
                        if ($sProjectNext != "") {
                          print "&nbsp;&nbsp;" . $sProjectNext;
                        }
										
									if (trim($sortArrange) == "DESC")
										$sortArrange = "ASC";
									elseif (trim($sortArrange) == "ASC")
										$sortArrange = "DESC";
									else
										$sortArrange = "DESC";

									?>
									</td>
								</tr>
                               
								<tr><td>&nbsp;</td></tr>
							</table>
							
						<!-- END CODE FOR MAIN CONTENT - PRASHANT -->
							
							</td>
						</tr>
						</table>	
						<!-- END TABLE FOR DIVISION - PRASHANT -->
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
