<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
    }
	include('../global.php');	
	include('../include/functions.php'); include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");

 $Operations = GetAccessRights(155);
				if(count($Operations)== 0)
				{
				 echo "<script language='javascript'>history.back();</script>";
				}		
		
	//var_dump($_REQUEST);
	
	$btnSubmit = "Add New";
	$id = $_GET['id'];
	$e_action = $_GET['e_action'];
	$type = $_GET['type'];
	$currentmenu = "Settings";
	
	if($id != "" && $e_action == 'edit')
	{
		$str = "SELECT * FROM ".$tbname."_locations WHERE _ID = '".$id."' ";
		
		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);			
			$warhouseId = $rs["_warhouseId"];			
			$LocationName = $rs["_LocationName"];			
			$status = $rs["_status"];	
			$btnSubmit = "Update";
		}
		else
		{
			$warhouseId  = 0;			
			$LocationName = 0;			
			
		}
	}
	
	if($e_action == 'detailedit')
	{
		$id = $_GET['id'];  
		$str = "SELECT * FROM ".$tbname."_locations WHERE _ID = '".$id."' ";
		
		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			
			$rs = mysql_fetch_assoc($rst);			
			$CategoryId = $rs["_warhouseId"];			
			$SubCategoryName = $rs["_LocationName"];			
			$btnSubmit = "Update";
		}
	}

	if($_GET['error'] == 1)
	{
		$WarehouseId = $_GET["WarehouseId"];
		$LocationName = $_GET["LocationName"];
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
			function clearDefault()
		{
			 var keywords = $("#Keywords").val();	 
			 if(keywords == "location")
			 {
				 $("#Keywords").val("");	
			 } 
	
		}
		function validateForm()
		{
			var errormsg;
            errormsg = "";	
			
									
            if (document.FormName.WarehouseId.value == 0)
                errormsg += "Please choose 'Warehouse'.\n";	
			
			if (document.FormName.LocationName.value == 0)
                errormsg += "Please fill in 'LocationName'.\n";

						
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
					
					document.forms.FormName2.action = "locations_action.php?e_action=curdelete";
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
						<!-- START TABLE FOR DIVISION -->
						<table width="100%" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<!-- <td width="20%" valign="top" align="left"> -->
							<!-- START CODE FOR LEFT MENU -->
							<?php
								//$CurrPage = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); /* Getting File Name */
								//include "setting_leftmenu.php";
							?>
							<!-- END CODE FOR LEFT MENU -->
						<!-- </td> -->
							<td>
							
							<!-- START CODE FOR MAIN CONTENT -->	
						
						<!--
						Start Contact
						-->
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
								  <td align="left" class="TitleStyle"><b>Settings - Warehouse - Locations</b></td>
								</tr>
								<tr><td height="5"></td></tr>
								<tr><td><?php
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
									echo "<div align='left'><font color='#FF0000'>Subcategory [".$SubCategoryName."] is existed in the system. Please enter another Subcategory.<br></font></div>";
								}
							?></td></tr>
							</table>
							<form name="FormName" action="locations_action.php" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?=$id?>" />
                            <input type="hidden" name="type" value="<?=$type?>" />
							<input type="hidden" name="e_action" value="<?=($e_action == "" ? "AddNew" : "Edit")?>" />
							<input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
									<td style="padding-top:5px;" colspan="3"><b>Add / Edit </b></td>
								</tr>
								<tr><td height="5"></td></tr>
								<tr>
									<td width="120"  valign="middle">Warehouse </td>
									<td width="10"  valign="middle">&nbsp;:&nbsp;</td>
									<td  valign="middle">
										<select  tabindex="" name="WarehouseId" id="WarehouseId" class="txtbox1  chosen-select" style="width:220">
										<option value="">--select--</option>
										<?php
											$sql = "SELECT * FROM ".$tbname."_warhouses";
											$res = mysql_query($sql) or die(mysql_error());
											if(mysql_num_rows($res) > 0){
												while($rec = mysql_fetch_array($res)){
													?><option <?php if($rec['_ID'] == $warhouseId){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_ID']; ?>"><?php echo $rec['_warhouseName']; ?></option><?php
												}
											}
										?>
										</select>
                                        <span class="detail_red">*</span>
									</td>
								</tr>								
								<tr><td height="5"></td></tr>
								<tr>
									<td width="120"  valign="middle">Location Name </td>
									<td width="10"  valign="middle">&nbsp;:&nbsp;</td>
									<td  valign="middle"><input type="text" tabindex="" name="LocationName" value="<?=$LocationName?>" class="txtbox1" style="width:220" /> <span class="detail_red">*</span></td>
								</tr>
                               <? if ($e_action=="edit") { ?>								
								<tr>
									<td  valign="middle">&nbsp;Status&nbsp;</td>
									<td  valign="middle">&nbsp;:&nbsp;</td>
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
									<td valign="middle"><input type="radio"   tabindex="" <?php echo $sel_status_y; ?> name="status" value="1" id="RadioGroup1_0" class="radio" />Live
									<input type="radio"   tabindex="" <?php echo $sel_status_n; ?> name="status" value="2" id="RadioGroup1_1" class="radio" />Archive</td>   
								</tr>  	
                                <? } ?>  						
								<tr><td height="5"></td></tr>
								<tr>
									<td colspan="2">&nbsp;</td>
									<td>
										<input type="button" class="button1" name="btnBack" value="< Back" onclick="window.location='settings.php';" />&nbsp;&nbsp;
										<input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
																			</td>
								</tr>
								<tr><td height="5"></td></tr>
							</table>
							</form>
							
							<?php
							$sortBy = trim($_GET["sortBy"]);
							$sortArrange = trim($_GET["sortArrange"]);
							$Keywords	 	= trim($_GET["Keywords"]);
							//Set the page size
							$PageSize = 20;
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
												
							$str1 = "SELECT l._ID,l._LocationName,l._subdate, ".$tbname."_warhouses._warhouseName,u._Fullname as _subby1,IF(l._status = 1, 'Live', 'Archived') as _status FROM ".$tbname."_locations l inner join  ".$tbname."_warhouses on ".$tbname."_warhouses._ID = l._warhouseId  left JOIN ".$tbname."_user u ON u._ID = l._subby where l._status <> '0' ";

							if ($Keywords != "") $str1 = $str1 . " AND l._LocationName LIKE '%".replaceSpecialChar($Keywords)."%' ";
							
							if (trim($sortBy) != "" && trim($sortArrange) != "")
								$str2 = $str1 . "ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
							else
								$str2 = $str1 . "ORDER BY l._LocationName LIMIT $StartRow,$PageSize ";
							
							$TRecord = mysql_query("set names 'utf8';");	
							$result = mysql_query("set names 'utf8';");
							
							//echo $str1;
							$TRecord = mysql_query($str1, $connect) or die(mysql_error());
							$result = mysql_query($str2, $connect) or die(mysql_error());
							
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
							<table cellpadding="2" cellspacing="0" border="0" width="100%">
									<tr>
									<td colspan="2"><b>Location List</b></td>
								</tr>
                               	<form name="search_form" action="locations.php" method="get" onsubmit="clearDefault()">
                                <tr> 
                                  <td><input type="text" tabindex="" title="Location Name" name="Keywords" id="Keywords" value="<?=$Keywords?>" class="defaultText" />&nbsp;&nbsp;<input type="submit" name="btnSearch" class="button1" value="Search" /></td>                                  
                                </tr>
                                </form>
                                <tr>
                                  <td></td>
                                </tr>
								<form name="FormName2" method="post" action="">
								<tr>
									<td class="pageno">
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
                                    <td align="right">
                                    
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
                                
                                                                <tr>
                                <td align="right">
                                    
                                      <?php                       
							if(in_array("Add",$Operations))
							{
								?>
                                    <a href="locations.php" class="TitleLink">Add New</a>
                                   
                                   <?php
							}
							?>
                                   
									</td>  
                                </tr>
                                
								<!--
								<tr><td><input type="button" name="back" class="button1" value="Back To Settings" onclick="window.location='settings.php'" style="width:100px;"/></td></tr>
								-->
								<tr><td colspan="2" height="5"></td></tr>
								<tr>
									<td colspan="2">
										<table cellspacing="0" cellpadding="2" width="100%" border="0" class="grid">
											<tr>
                                            	<td class="gridheader" width="30" align="center"><input name="AllCheckbox" id="AllCheckbox" type="checkbox"   tabindex="" value="All" onclick="CheckUnChecked('CustCheckbox',document.FormName2.cntCheck.value,this);" /></td>
												<td class="gridheader link1" width="30" align="center">No.</td>
												<td class="gridheader">&nbsp;&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_warhouseName&amp;sortArrange=<?=$sortArrange?>" class="link1">Warehouse Name</a></td>
												<td class="gridheader">&nbsp;&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_LocationName&amp;sortArrange=<?=$sortArrange?>" class="link1">Location Name</a></td>
                                                
												<td class="gridheader datecolumn" align="center">&nbsp;&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_subby1&amp;sortArrange=<?=$sortArrange?>" class="link1">Submitted By</a></td>
												
												<td class="gridheader datecolumn" align="center">&nbsp;&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_subdate&amp;sortArrange=<?=$sortArrange?>" class="link1">Submitted Date</a></td>
                                                
                                                <td class="gridheader" align="center">&nbsp;&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_status&amp;sortArrange=<?=$sortArrange?>" class="link1">System Status</a></td>
												<td class="gridheader sort TitleLink" width="80" align="center">Edit</td>
												
											</tr>
											<?php
											if($RecordCount!="")
											{
												$i = 1;
												//$Rowcolor = "gridline1";
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
														<td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="left" >&nbsp;
														<?php													
														echo $rs["_LocationName"]
														?>&nbsp;
														</td>    

 <td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="center">&nbsp;<?php echo $rs["_subby1"]; ?>&nbsp;</td>
														
                                                        <td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="center">&nbsp;<?php echo $rs["_subdate"]!=""?date(DEFAULT_DATEFORMAT,strtotime(replaceSpecialCharBack($rs["_subdate"]))):"" ?>&nbsp;</td>
                                                       
                                                        <td id="Row7ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="center">&nbsp;<?php echo $rs["_status"]; ?> &nbsp;</td>                                                                                           
														<td id="Row8ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="center">&nbsp;
                                                        
                                                        <?php                       
							if(in_array("Edit",$Operations))
							{
								?>
                                                        
                                                        <a href="?PageNo=<?=$PageNo?>&amp;id=<?=$rs["_ID"]?>&amp&e_action=edit" class="TitleLink">Edit</a>&nbsp;
                                                        
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
										</table>
									</td>
								</tr>
								<tr><td colspan="2" height="5"><input type="hidden" name="cntCheck" value="<?php echo $i-1; ?>" /></td></tr>
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
								<tr><td>&nbsp;</td></tr>
                                </form>
							</table>
							
							<!-- END CODE FOR MAIN CONTENT -->
							
							</td>
						</tr>
						</table>	
						<!-- END TABLE FOR DIVISION -->
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