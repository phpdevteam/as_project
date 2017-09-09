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
   

	$currentmenu = "Settings";	
	
	
	$module = $_GET['module'];
	$id = $_GET['id'];
	$e_action = $_GET['e_action'];
	$btnSubmit = "Add New";
	
		if($module == 1){
			$modulename = "PO";
			
			$modulename1 = "Purchase Orders";
			
			 $Operations = GetAccessRights(252);
				if(count($Operations)== 0)
				{
				 echo "<script language='javascript'>history.back();</script>";
				}	
	}
		else if($module == 2) {
			$modulename = "INV";
			$modulename1 = "Invoices";
			 $Operations = GetAccessRights(260);
				if(count($Operations)== 0)
				{
				 echo "<script language='javascript'>history.back();</script>";
				}	
			 }
			 else if($module == 3) {
			$modulename = "RC";
			$modulename1 = "Receipts";
			 $Operations = GetAccessRights(268);
				if(count($Operations)== 0)
				{
				 echo "<script language='javascript'>history.back();</script>";
				}	
			 }
		else if($module == 4){
			$modulename = "SQ";
			$modulename1 = "SQ";
			 $Operations = GetAccessRights(244);
				if(count($Operations)== 0)
				{
				 echo "<script language='javascript'>history.back();</script>";
				}	
			
			}
			
			else if($module == 5){
			$modulename = "DO";
			$modulename1 = "DO";
			 $Operations = GetAccessRights(337);
				if(count($Operations)== 0)
				{
				 echo "<script language='javascript'>history.back();</script>";
				}	
			
			}
			
		if($id != "" && $e_action == 'edit')
	{
		
		$str = "select * from ".$tbname."_tnctext where _id= '".$id."' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			
			$id= $rs['_id'];
			$title = $rs['_title'];
			$tncRemarks = replaceSpecialCharBack($rs['_tnc']); 
			$status = $rs['_status'];
			
			$PageStatus = "Edit T&amp;C";
			$btnSubmit = "Update";
		}
	}
	
	
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?=$gbtitlename?></title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />			
	<script type="text/javascript" src="../js/validate.js"></script>
    <? include('jquerybasiclinks10_3.php'); ?>
     <link rel="stylesheet" href="../jquery/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
      <link rel="stylesheet" href="../jquery/autocomplete/chosen.css" />
<script type="text/javascript" src="../jquery/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    <script type="text/javascript" src="../js/functions.js"></script>
	<script type="text/javascript" language="javascript">
		<!--
		function validateForm()
		{
			var errormsg;
            errormsg = "";					
				
				if (document.tnctext.title.value == 0)
                errormsg += "Please fill in 'Title'.\n";
						
            if ((errormsg == null) || (errormsg == ""))
            {
                document.tnctext.btnSubmit.disabled=true;
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
			if(checkSelected('CustCheckbox', document.tncText.cntCheck.value) == false)
			{
				alert("Please select at least one checkbox.");
				document.tncText.AllCheckbox.focus();
				return false;
			}
			else
			{
				if(confirm('Are you sure you want to delete the selected tncText(s)?') == true)
				{
					document.tncText.action = "tnctext_action.php";
					document.tncText.submit();
				}
			}
		}

		function checkSelected(msgtype, count)
		{
			for(var i=1 ; i<=count; i++)
			{
				if(eval("document.tncText." + msgtype + i + ".type") == "checkbox")
				{
					if(eval("document.tncText." + msgtype + i + ".checked") == true)
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
			CheckUnChecked('CustCheckbox',document.tncText.cntCheck.value,document.getElementById('AllCheckbox'));
		
		}
		function CheckUnChecked(msgType, count, chkbxName)
		{
		
			if (chkbxName.checked==true)
			{

				for (var i = 1; i<=count; i++)
				{
					 eval("document.tncText."+msgType+i+".checked = true");
					 for(var j=1;j<=5;j++)
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
					 eval("document.tncText."+msgType+i+".checked = false");
					 if(rowcolor=='gridline2')
					 {
						 rowcolor='gridline1';
					 }
					 else
					 {
						  rowcolor='gridline2';
					 }
					 for(var j=1;j<=5;j++)
					 {
						
						document.getElementById('Row'+j+'ID'+i).className=rowcolor; // Cross-browser
					 }
				}
			}
		}
		
		function setActivities(fromfield,rowid,rowcolor) { 
			
			if(fromfield.checked == true)
			{				
				for(var i=1;i<=5;i++)
				{
					document.getElementById('Row'+i+'ID'+rowid).className='gridline3'; // Cross-browser
				}
			}
			else
			{
				for(var i=1;i<=5;i++)
				{
					document.getElementById('Row'+i+'ID'+rowid).className=rowcolor; // Cross-browser
				}
			}
		}
		
		function ClearAll()
		{
			for (var i=0;i<document.tncSearchForm.elements.length;i++) {
				if (document.tncSearchForm.elements[i].type == "text" || document.tncSearchForm.elements[i].type == "textarea")
					document.tncSearchForm.elements[i].value = "";  
				else if (document.tncSearchForm.elements[i].type == "select-one")
					document.tncSearchForm.elements[i].selectedIndex = 0;
				else if (document.tncSearchForm.elements[i].type == "checkbox")
					document.tncSearchForm.elements[i].checked = false;
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
								  <td align="left" class="TitleStyle"><b>Settings > <?=$modulename1?> > T&C Texts</b></td>
								</tr>
								<tr><td height=""></td></tr>
							</table>
                            
                            
                            <form name="tnctext" action="tnctext_action.php" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
							<input type="hidden"  name="id" value="<?=$id?>" />
                            <input type="hidden"  name="module" value="<?=$module?>" />
                             <input type="hidden"  name="modulename" value="<?=$modulename?>" />
							<input type="hidden" name="e_action" value="<?=($e_action == "" ? "AddNew" : "Edit")?>" />
							<input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								
                                
                                
                                <tr>
									<td style="padding-top:5px;" colspan="3"><b>T&C Texts</b></td>
								</tr>
								
								<tr><td height="5"></td></tr>
								<tr>
									<td nowrap>&nbsp;Title&nbsp;</td>
									<td>&nbsp;:&nbsp;</td>
									<td>
									
										<input type="text" tabindex="" id="title" name="title" value="<?=$title?>" size="60" class="txtbox1" /> <span class="detail_red">*</span> 
								
									</td>
								</tr>
								
                                <tr><td height="5"></td></tr>  
                                
                                  <tr>
                                                <td>T&amp;C</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td width="700">
                                                
                                                  <?php 													
													$sBasePath = 'fckeditor/';
													$oFCKeditor = new FCKeditor('tnc');
													$oFCKeditor->Width = "760px";
													$oFCKeditor->Height = "400px";
													$oFCKeditor->BasePath = $sBasePath;
													$oFCKeditor->Value = replaceSpecialCharBack($tncRemarks);
													$oFCKeditor->Create();
													
												?>
                                                
                                                </td>
                                            </tr>								
                                            <tr><td height="5"></td></tr>     
                                
                                 <? if ($e_action=="edit") { ?>		
                                
                                <tr><td width="130">&nbsp;System Status&nbsp;</td>
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
									<input type="radio"   tabindex="" <?php echo $sel_status_n; ?> name="status" value="2" id="RadioGroup1_1" class="radio" />Archive</td></tr>
                                <tr><td height="5"></td></tr>
                                
                                <?php
								 }
								 ?>
                                
								<tr>
									<td colspan="2">&nbsp;</td>
									<td>
										  <input type="button" name="btnBack" class="button1" value="< Back" onclick="window.location='settings.php'" />&nbsp;
                                          <input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
									</td>
								</tr>
							</table>
							</form>
                            
							<?php
							if ($_GET["done"] == 1)
							{
								echo "<div align='left'><font color='#FF0000'>tncText has been added successfully.<br></font></div>";
							}
							if ($_GET["done"] == 2)
							{
								echo "<div align='left'><font color='#FF0000'>tncText has been edited successfully.<br></font></div>";
							}
							if ($_GET["done"] == 3)
							{
								echo "<div align='left'><font color='#FF0000'>tncText has been deleted successfully.<br></font></div>";
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
							
							}
							?>
							<br />
							<div>
							<?php
							$sortBy 		= trim($_GET["sortBy"]);
							$sortArrange	= trim($_GET["sortArrange"]);
							
							$Keywords	 	= trim($_GET["Keywords"]);	
					
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
						
							$str1 = "select * from ".$tbname."_tnctext where _mode = '" . $modulename ."' ";
														
							if ($Keywords != "") $str1 = $str1 . " AND (_title LIKE '%".replaceSpecialChar($Keywords)."%' Or _tnc like '%".replaceSpecialChar($Keywords)."%') ";
							

							if (trim($sortBy) != "" && trim($sortArrange) != "")
								$str2 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
							else
								$str2 = $str1 . " ORDER BY _status,_title LIMIT $StartRow,$PageSize ";
							
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
							
							<form name="tncSearchForm" action="tnctexts.php" method="get">
                              <input type="hidden" name="module" value="<?=$module?>" />
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                              <tr>
                                <td>
                                  <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                      <td><b>T&amp;C List</b></td>
                                      
                                    </tr>
                                    <tr>
                                      <td height="5"></td>
                                    </tr>
                                    <tr>
                                      <td width="200px"><input name="Keywords" type="text" tabindex="" title="Enter Any Keywords" class="defaultText" id="Keywords" value="<?=$Keywords?>" /></td>
                                      <td>
                                        <input type="submit" name="btnSearch" class="button1" value="Search" />
                          
                                      </td>
                                    </tr>
                              
                                </table>
								</td>
                              </tr>
                            </table>
							</form>							
							<form name="tncText" method="post" action="">
                            <input type="hidden" name="module" value="<?=$module?>" />
                
                            <table style="margin-top:10px;" cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
									<td colspan="1" class="pageno">
                                    
									<?php
										$QureyUrl = "&amp;Keywords=".$Keywords."&amp;".
												
													"&amp;sortBy=".$sortBy."&amp;sortArrange=".$sortArrange . "&amp;module=".$module;
										if($MaxPage > 0) echo "Page: ";
										for ($i=1; $i<=$MaxPage; $i++)
										{
											if ($i == $PageNo)
											{
												print "<a class=\"selected\" href='?module=".$module ."&PageNo=". $i . $QureyUrl ."#tblresult' class='menulink'>".$i."</a> ";
											}
											else
											{
												print "<a class=\"unselect\" href='?module=".$module ."&PageNo=" . $i . $QureyUrl ."#tblresult' class='menulink'>".$i."</a> ";
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
									?>
                                    
                                     <?php                       
							if(in_array("Archive",$Operations))
							{
								?>
									
                                   
                                    <input type="button" class="button1" name="btnSubmit2" value="Archive" onclick="return validateForm3();" style="width:100px;" />
                                   
								
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
                                    	<a href="tnctexts.php?module=<?=$module?>" class="TitleLink">Add New</a> 
                                   <?php
							}
							?>
                                   
									</td>
									
								</tr>
								<tr><td colspan="2" height="5"></td></tr>
								<tr>
									<td colspan="2">
										<table id="tblresult" cellspacing="0" cellpadding="3" width="100%" border="0" class="grid" >
											<tr>
												<td class="gridheader" width="30" align="center"><input name="AllCheckbox" id="AllCheckbox" type="checkbox"   tabindex="" value="All" onclick="CheckUnChecked('CustCheckbox',document.tncText.cntCheck.value,this);" /></td>
												<td class="gridheader" width="30" align="center">No.</td>
												<td class="gridheader">
													&nbsp;<a href="?module=<?=$module?>&PageNo=<?=$PageNo?>&amp;sortBy=_title&amp;sortArrange=<?=$sortArrange?>&amp;tncTextname=<?=$Keywords?>#tblresult" class="link1">Title Name</a>
												</td>
												
												<td class="gridheader"  align="center">
													&nbsp;<a href="?module=<?=$module?>&PageNo=<?=$PageNo?>&amp;sortBy=_status&amp;sortArrange=<?=$sortArrange?>&amp;tncTextname=<?=$Keywords?>#tblresult" class="link1">System Status</a>
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
													
												 if ($id == $rs["_id"]) {
														$Rowcolor = "gridline3";
													}	
												?>
												<tr >
													<td id="Row1ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="30" align="center">
													  <input name="CustCheckbox<?php echo $i; ?>" type="checkbox"   tabindex="" value="<?php echo $rs["_id"]; ?>" onclick="setActivities(this.form.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>');" />
													</td>
													<td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
													<td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="300"><?=$rs["_title"]?></td>
													<td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" width="200"><?php if($rs["_status"]==1) {echo "Live" ;} else {echo "Archived"; }?></td>                                                    
                                                  
													<td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" width="100">&nbsp;
                                                     <?php                       
							if(in_array("Edit",$Operations))
							{
								?>
                                                    
                                                    <a href="tnctexts.php?PageNo=<?=$PageNo?>&amp;module=<?=$module?>&amp;id=<?=$rs["_id"]?>&amp;e_action=edit" class="TitleLink">Edit</a>&nbsp;
                                                    
                                                    <?php
							}
							?>
                                                    
                                                    </td>
                                                  
												</tr>
												<?php
												$i++;
												}
											} else {
												echo "<tr><td colspan='5' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
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
									?>
                                    
                                     <?php                       
							if(in_array("Archive",$Operations))
							{
								?>
									
                                    <input type="button" class="button1" name="btnSubmit2" value="Archive" onclick="return validateForm3();" style="width:100px;" />
                                   
                                   
									</td>
									 <?
										}
										
										}
									
									?>
								
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
												print "<a class=\"selected\" href='?module=".$module ."&PageNo=". $i . $QureyUrl ."#tblresult' class='menulink'>".$i."</a> ";
											}
											else
											{
												print "<a class=\"unselect\" href='?module=".$module ."&PageNo=" . $i . $QureyUrl ."#tblresult' class='menulink'>".$i."</a> ";
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
</body>
</html>
<?php		
include('../dbclose.php');
?>