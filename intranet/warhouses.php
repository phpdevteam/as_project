<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
    }
	include('../global.php');	
	include('../include/functions.php');  include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");
	
	 $Operations = GetAccessRights(154);
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
		 $str = "SELECT * FROM ".$tbname."_warhouses WHERE _ID = '".$id."'";
		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			$WarhouseName = $rs["_warhouseName"];	
			$status = $rs["_status"];				
			$btnSubmit = "Update";
		}
	}

	if($_GET['error'] == 1)
	{
		$WarhouseName = $_GET["warhouseName"];
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
		<!--
		function validateForm()
		{
			var errormsg;
            errormsg = "";					
            if (document.FormName.WarhouseName.value == 0)
                errormsg += "Please fill in 'Warhouse'.\n";
						
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
					
					document.forms.FormName2.action = "warhouse_action.php?e_action=curdelete";
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
			//alert(count);
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
		function ClearAll()
		{
			for (var i=0;i<document.search_form.elements.length;i++) {
				if (document.search_form.elements[i].type == "text" || document.search_form.elements[i].type == "textarea")
					document.search_form.elements[i].value = "";  
				else if (document.search_form.elements[i].type == "select-one")
					document.search_form.elements[i].selectedIndex = 0;
				else if (document.search_form.elements[i].type == "checkbox")
					document.search_form.elements[i].checked = false;
			}
		}
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
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
								  <td align="left" class="TitleStyle"><b>Settings &gt;  System &gt; Warehouses </b></td>
								</tr>
								<tr><td height=""></td></tr>
							</table>
							<form name="FormName" action="warhouse_action.php" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?=$id?>" />
                            <input type="hidden" name="type" value="<?=$type?>" />
							<input type="hidden" name="e_action" value="<?=($e_action == "" ? "AddNew" : "Edit")?>" />
							<input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
									<td style="padding-top:5px;" colspan="3"><b>Warehouses </b></td>
								</tr>
								<tr><td height="10"></td></tr>
								<tr>
									<td width="120"  valign="middle">Warehouse</td>
									<td width="10"  valign="middle">&nbsp;:&nbsp;</td>
									<td  valign="middle"><input type="text" tabindex="" name="WarhouseName" value="<?=$WarhouseName?>" class="txtbox1" style="width:220" /> <span class="detail_red">*</span></td>
								</tr>	
                                
                                   <? if ($e_action=="edit") { ?>								
								<tr>
									<td nowrap>&nbsp;Status&nbsp;</td>
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
                                							
								<tr><td height="10"></td></tr>
								<tr>
									<td colspan="2">&nbsp;</td>
									<td>
                                    	<input type="button" class="button1" name="btnBack" value="< Back" onclick="window.location='settings.php';" />&nbsp;&nbsp;
										<input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
										
								</tr>
							</table>
							</form>
							<?php
								if ($_GET["done"] == 1)
								{
									echo "<div align='left'><font color='#FF0000'>Category has been added successfully.<br></font></div>";
								}
								if ($_GET["done"] == 2)
								{
									echo "<div align='left'><font color='#FF0000'>Category has been edited successfully.<br></font></div>";
								}
								if ($_GET["done"] == 3)
								{
									echo "<div align='left'><font color='#FF0000'>Category has been deleted successfully.<br></font></div>";
								}
								if ($_GET["error"] == 1)
								{
									echo "<div align='left'><font color='#FF0000'>Category [".$CategoryName."] is existed in the system. Please enter another Category.<br></font></div>";
								}
							?>
							<?php
							$sortBy = trim($_GET["sortBy"]);
							$sortArrange = trim($_GET["sortArrange"]);
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
							$str1 = "SELECT _ID,IF(_status = 1, 'Live', 'Archived') as _status,_warhouseName,_subdate,_subby FROM ".$tbname."_warhouses where _status <> '0'";							
							
							if ($Keywords != "") $str1 = $str1 . " and _warhouseName LIKE '%".replaceSpecialChar($Keywords)."%' ";
							
							if (trim($sortBy) != "" && trim($sortArrange) != "")
								$str2 = $str1 . "ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
							else
								$str2 = $str1 . "ORDER BY _warhouseName LIMIT $StartRow,$PageSize ";
							
							$TRecord = mysql_query("set names 'utf8';");	
							$result = mysql_query("set names 'utf8';");
							
							$TRecord = mysql_query($str1, $connect);
							$result = mysql_query($str2, $connect);
							
							//echo $str1;
							//echo $str2;
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
									<td colspan="2"><b>Warhouse List</b></td>
								</tr>
								<form name="search_form" action="warhouses.php" method="get" onsubmit="clearDefault()">
                                <tr> 
                                  <td><input type="text" tabindex="" title="Warehouse Name" name="Keywords" id="Keywords" value="<?=$Keywords?>" class="defaultText" />&nbsp;&nbsp;<input type="submit" name="btnSearch" class="button1" value="Search" /></td>                                  
                                </tr>
                                </form>
								<tr>
									<td colspan="2" class="pageno">
									<?php
										$QureyUrl = "&amp;sortBy=".$sortBy."&amp;sortArrange=".$sortArrange."";
										if($MaxPage > 0) echo "Page: ";
										for ($i=1; $i<=$MaxPage; $i++)
										{
											if ($i == $PageNo)
											{
												print "<a href='?PageNo=". $i . $QureyUrl ."' class='menulink selected'>".$i."</a> ";
											}
											else
											{
												print "<a href='?PageNo=" . $i . $QureyUrl ."' class='menulink unselect'>".$i."</a> ";
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
								</tr>
								<tr><td colspan="2" height="5">
                                  <?php                       
							if(in_array("Archive",$Operations))
							{
								?>
                                
                                
                                <input type="button" class="button1" name="btnSubmit2" value="Archive" onclick="return validateForm3();" style="width:100px;" />
							<?php
							}
							?>
                            
                            </td></tr>
                            	<!--
								<tr><td><input type="button" name="back" class="button1" value="Back To Settings" onclick="window.location='settings.php'" style="width:100px;"/></td></tr>
								-->
                                <tr>
                                <td align="right">
                                    
                                      <?php                       
							if(in_array("Add",$Operations))
							{
								?>
                                    <a href="warhouses.php" class="TitleLink">Add New</a>
                                   
                                   <?php
							}
							?>
                                   
									</td>  
                                </tr>
                                
                                
								<tr><td colspan="2" height="5"></td></tr>
								<tr>
									<td colspan="2">
										<table cellspacing="0" cellpadding="2" width="100%" border="0" class="grid">
                                        <form name="FormName2" method="post" action="warhouse_action.php">
											<tr>
	                                            <td class="gridheader" width="30" align="center"><input name="AllCheckbox" id="AllCheckbox" type="checkbox"   tabindex="" value="All" onclick="CheckUnChecked('CustCheckbox',document.FormName2.cntCheck.value,this);" /></td>
												<td class="gridheader" width="30" align="center">No.</td>
												<td class="gridheader">&nbsp;&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_warhouseName&amp;sortArrange=<?=$sortArrange?>" class="link1">Warhouse</a></td>
                                                 <td class="gridheader datecolumn" align="center">&nbsp;&nbsp;<a href="" class="link1">Submitted By</a></td>
												
												<td class="gridheader datecolumn" align="center">&nbsp;&nbsp;<a href="" class="link1">Submitted Date</a></td>
                                               
                                                <td class="gridheader" align="center">&nbsp;&nbsp;<a href="" class="link1">System Status</a></td>
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
													  		<input name="CustCheckbox<?php echo $i; ?>" type="checkbox"   tabindex="" value="<?php echo $rs["_ID"]; ?>" onclick="setActivities(this.form.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>');" />
														</td>
														<td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
														<td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="left" >&nbsp;
														<?php													
														echo $rs["_warhouseName"]
														?>&nbsp;
														</td>   
 <td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="center">&nbsp;<?php echo $rs["_subby"]; ?>&nbsp;</td>
														
                                                        <td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="center">&nbsp;<?php echo $rs["_subdate"]!=""?date(DEFAULT_DATEFORMAT,strtotime(replaceSpecialCharBack($rs["_subdate"]))):"" ?>&nbsp;</td>
                                                       
                                                        <td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="center">&nbsp;<?php echo $rs["_status"]; ?>&nbsp;</td>                                                
														<td id="Row7ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="center">&nbsp;
                                                        
                                                        <?php                       
							if(in_array("Edit",$Operations))
							{
								?>
                                                        
                                                        <a href="?PageNo=<?=$PageNo?>&amp;id=<?=$rs["_ID"]?>&amp;e_action=edit&amp;type=1 " class="TitleLink">Edit</a>&nbsp;
                                                        
                                                        <?php
							}
							?>
                                                        
                                                        </td>
													</tr>
													<?php
													$i++;
												}											
											} else {
												echo "<tr><td colspan='4' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											?>
                                            <input type="hidden" name="cntCheck" value="<?php echo $i-1; ?>" /></form>
										</table>
									</td>
								</tr>
								<tr><td colspan="2" height="5"></td></tr>
								<!--
								<tr><td><input type="button" name="back" class="button1" value="Back To Settings" onclick="window.location='settings.php'" style="width:100px;"/></td></tr>
								-->
								<tr><td colspan="2" height="5">
                                
                                <?php                       
							if(in_array("Archive",$Operations))
							{
								?>
                                
                                <input type="button" class="button1" name="btnSubmit2" value="Archive" onclick="return validateForm3();" style="width:100px;" />
                                
                                <?php
							}
							?>
                                
                                
                                </td></tr>
								<tr>
									<td colspan="2" class="pageno">
									<?php
										if($MaxPage > 0) echo "Page: ";
										for ($i=1; $i<=$MaxPage; $i++)
										{
											if ($i == $PageNo)
											{
												print "<a href='?PageNo=". $i . $QureyUrl ."' class='menulink selected'>".$i."</a> ";
											}
											else
											{
												print "<a href='?PageNo=" . $i . $QureyUrl ."' class='menulink unselect'>".$i."</a> ";
											}
										}
									?>
									</td>
								</tr>
								
                                
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
</body>
</html>
<?php		
include('../dbclose.php');
?>