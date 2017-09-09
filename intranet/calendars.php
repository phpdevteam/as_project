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
	
	$Operations = GetAccessRights(70);
	if(count($Operations)== 0)
	{
	 echo "<script language='javascript'>history.back();</script>";
	}
	
	$COperations = GetAccessRights(62);
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>
    <?=$gbtitlename?>
    </title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
    <link rel="stylesheet" href="../jquery/autocomplete/chosen.css" />
	<script type="text/javascript" src="../js/validate.js"></script>
	<? include('jquerybasiclinks.php'); ?>
	<link rel="stylesheet" href="../jquery/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
	<script type="text/javascript" src="../jquery/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
	<script type="text/javascript" src="../js/functions.js"></script>
	<script type="text/javascript" language="javascript">
		<!--
		
		$(function(){

				$('#SearchByAdv').click(function(event) {
  				//event.preventDefault();
				$('#AdvancedSearch').show();
				$('#QuickSearch').hide();
				$('#polist').hide();
			});	
			
			<? if($_GET['SearchBy']=='AdvSearch'){ ?>
				
				$('#AdvancedSearch').hide();
				$('#QuickSearch').show();
				$('#polist').show();
				
			<? }
			 else if($_GET['SearchBy']=='AdvSearch1'){ ?>
			 				
				$('#AdvancedSearch').show();
				$('#QuickSearch').hide();
				$('#polist').hide();
				
			<? }else{ ?>
				
				$('#AdvancedSearch').hide();
				$('#QuickSearch').show();
				$('#polist').show();
			<? } ?>
			
		});
		
		function validateForm3()
		{
			if(checkSelected('FormName','CustCheckbox', document.FormName.cntCheck.value) == false)
			{
				alert("Please select at least one checkbox.");
				document.FormName.AllCheckbox.focus();
				return false;
			}
			else
			{
				if(confirm('Are you sure you want to archive the selected Record(s)?') == true)
				{
					document.forms.FormName.action = "appointments.php";
					document.forms.FormName.submit();
				}
			}
		}
		
		function export2CSV()
	{
		document.forms.FormName.action ="exportlist.php?name=applist";
	    document.forms.FormName.submit();	
	}

		//-->
		function showItemType()
		{  
			var sid = "<?=$subcategoryID?>";
			var ssid =  "<?=$subsubcategoryID?>";
			
			  $.post("../ajax/getCategorySQItem.php",{mytype:1,sid:sid,ssid:ssid},function(result){
			  $('#categoryID').html(result);
			  $( "#categoryID" ).trigger("chosen:updated"); 
			});	
								
		}
		
		
		function clearDefault()
		{
		 var keyword = $("#Keywords").val();	 
		 if(keyword == "Enter Any Keywords")
			 {
				 $("#Keywords").val("");	
			 } 
			 
			 
			  var appDate = $("#appDate").val();	 
		 if(appDate == "Select Event Date")
			 {
				 $("#appDate").val("");	
			 } 
			 
			 
			  var eTitle = $("#eTitle").val();	 
		 if(eTitle == "Enter Event Title")
			 {
				 $("#eTitle").val("");	
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
                <td valign="top"><?php include('topbar.php'); ?></td>
              </tr>
            <tr>
                <td class="inner-block" align="left" valign="top"><div class="m">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td><table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                            <td align="left" class="TitleStyle"><b>Appointments &gt; Appointment List</b></td>
                          </tr>
                          </table>
                        <?php
							if ($_GET["done"] == 1)
							{
								echo "<div align='left'><font color='#FF0000'>Record has been added successfully.<br></font></div>";
							}
							if ($_GET["done"] == 2)
							{
								echo "<div align='left'><font color='#FF0000'>Record has been edited successfully.<br></font></div>";
							}
							if ($_GET["done"] == 3)
							{
								echo "<div align='left'><font color='#FF0000'>Record has been archived successfully.<br></font></div>";
							}
							
							?>
                        <br />
                        <div>
                            <?php
							 $sortBy = trim($_GET["sortBy"]);
							//echo " SOrty BY <br><br>";
							 $sortArrange = trim($_GET["sortArrange"]);
							
							if (trim($sortArrange) == "DESC")
								 $sortArrange = "ASC";
							elseif (trim($sortArrange) == "ASC")
								 $sortArrange = "DESC";
							else
								 $sortArrange = "DESC";
							
							
							$Keywords 		= trim($_GET["Keywords"]);
							$appDate 	= trim($_GET["appDate"]);
							$eTitle 	= trim($_GET["eTitle"]);
							
							
							$appDate1 	= trim($_GET["appDate1"]);
							$eTitle1 	= trim($_GET["eTitle1"]);
							$fromTime = trim($_GET['startTime']);							
							$toTime = trim($_GET['endTime']);
							$staffRef = trim($_GET['staffRef']);
							
							
						
							if($SearchBy=="AdvSearch")
								$Keywords = "";

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
							$Rowcolor = "gridline1";
							
							$str1 = "SELECT app._ID,date_format(app._SubmittedDate,'%d/%m/%Y') as _SubmittedDate,_Title,IF(app._status = 1, 'Live', 'Archived') as _status,usr._Fullname,stff._Fullname as _StaffRef,Concat(date_format(app._Date,'%d/%m/%Y'),'( ',_From,' - ',_To,' )') as _AppDate FROM ".$tbname."_appointments app
							left join ".$tbname."_user stff on app._StaffRef=stff._ID
							left Join ".$tbname."_user AS usr ON app._SubmittedBy = usr._ID
							WHERE app._status = '1' " ;
							
							if($Keywords != "Enter Any Keywords" && $Keywords!="")
							{
								$str1 = $str1 . " AND (";
								
								$str1 .= "_Title LIKE '%".replaceSpecialChar($Keywords)."%' ";
									
								$str1 = $str1 . " OR stff._Fullname LIKE '%".replaceSpecialChar($Keywords)."%' ";
								
								$str1 = $str1 . " OR date_format(app._Date,'%d/%m/%Y') = '".$Keywords."' ";
								
								$str1 = $str1 . " OR date_format(app._SubmittedDate,'%d/%m/%Y') = '".$Keywords."' ";
								
								$str1 = $str1 . " OR usr._Fullname LIKE '%".replaceSpecialChar($Keywords)."%' ";
								
								$str1 .= ") ";
								
							} 
							
							else
							{							
								if($appDate != "")
								{
									
									$str1 = $str1 . " AND date_format(app._Date,'%d/%m/%Y')
									 = '".replaceSpecialChar($appDate)."' ";
								}
									
								 if($eTitle != "")
								{
									
									$str1 = $str1 . " AND _Title LIKE '%".replaceSpecialChar($eTitle)."%'";
									
								}
								
								if($appDate1 != "")
								{
									
									$str1 = $str1 . " AND date_format(app._Date,'%d/%m/%Y')
									 = '".replaceSpecialChar($appDate1)."' ";
								}								
								
								if($eTitle1 != "")
								{
									
									$str1 = $str1 . " AND _Title LIKE '%".replaceSpecialChar($eTitle1)."%'";
									
								}
								
								if($fromTime != "" && $toTime == "")
								{
									
									$str1 = $str1 . " AND _From = '".replaceSpecialChar($fromTime)."'";
									
								}
								
								if($fromTime != "" && $toTime != "")
								{
									
									$str1 = $str1 . " AND _From >= '".replaceSpecialChar($fromTime)."'
									and _To <= '".replaceSpecialChar($toTime)."'";
									
								}
								
								if($staffRef != "" )
								{
									
									$str1 = $str1 . " AND _StaffRef = '".replaceSpecialChar($staffRef)."' ";
									
								}
					
							}
							
							
							if (trim($sortBy) != "" && trim($sortArrange) != "")
								$str2 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
							else
								$str2 = $str1 . " ORDER BY app._Date DESC LIMIT $StartRow,$PageSize ";
								
								 $_SESSION["applist"] = $str1;
													
							$TRecord = mysql_query($str1, $connect) or die(mysql_error());
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
							
							$QureyUrl = "&amp;Keywords=".$Keywords."&amp;SearchBy=".$SearchBy.
											"&amp;sortBy=".encrypt($sortBy,$Encrypt).
											"&amp;sortArrange=".encrypt($sortArrange,$Encrypt);
											
							$ExtraUrl = "&amp;SearchBy=".$SearchBy.
											"&amp;sortArrange=".encrypt($sortArrange,$Encrypt);
											
							
							?>
                            <div id="QuickSearch">
                            <form name="QuickSearch" action="appointments.php" method="get" onsubmit="clearDefault()">
                                <table cellpadding="2" cellspacing="0" border="0" width="100%">
                                <tr>
                                	<td colspan="2"><b>Quick Search/List Appointment</b></td>
                                    <td align="right" colspan="3">
                                              <?php                       
							if(in_array("Advanced Search",$Operations))
							{
								?>
                                    
                                    <a href="#" class="TitleLink" id="SearchByAdv">Advanced Search</a>
                                    
                                     <?php
							}
							?>
                                    
                                      <?php                       
							if(in_array("Add",$Operations))
							{
								?>
                                    
                                     &nbsp;|&nbsp; <a href="appointment.php" class="TitleLink">Add Appointment </a>
                                     
                                  <?php
							}
							?>
                                    
                                      <?php                       
							if($COperations > 0)
							{
								?>
                                     
                                      &nbsp;|&nbsp; <a href="calendar.php" class="TitleLink">Calendar </a> 
                                      
                                       <?php
							}
							?>
                                      
                                      </td>
                                </tr>
                                <tr>
          
                                    <td class="defaultTextlbl"><input name="Keywords" type="text" tabindex="" title="Enter Any Keywords" class="defaultText" id="Keywords" value="<?=$Keywords?>" /></td>
                                    <td class="defaultTextlbl"> <input type="text" tabindex="" id="appDate" name="appDate" class="datepicker defaultText"  title="Select Event Date" value="<?=$appDate?>" ></td>
                                    <td class="defaultTextlbl"><input name="eTitle" type="text" tabindex="" title="Enter Event Title" class="defaultText"  id="eTitle" value="<?=$eTitle?>"/></td>
                                    <td><input type="submit" name="btnSearch2" class="button1" value="Search" />
                                    
                                     <input type="button" name="btnSearch" class="button1" onclick="ClearAll('QuickSearch');" value="Clear All" />       </td>
                                                    
                                    </td>
                                  </tr>
                              </table>
                              </form>
                            </div>
                            <div id="AdvancedSearch">
                            <form name="AdvancedSearch" action="appointments.php" method="get">
                                
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td colspan="2" align="left"><b>Advanced Search</b>
                                    <input name="SearchBy" type="hidden" value="AdvSearch" /></td>
                                    <td align="right">
                                    <div align="right">
                             
                                
                                <a href="appointments.php?SearchBy=" class="TitleLink" id="QuickSearc">Quick Search/List</a> 
                                
                                     <?php                       
							if(in_array("Add",$Operations))
							{
								?>
                                &nbsp;|&nbsp; <a href="appointment.php" class="TitleLink">Add Appointment </a>
                                
                                  <?php
							}
							?>
                                
                                    <?php                       
							if($COperations > 0)
							{
								?>
                                
                                &nbsp;|&nbsp; <a href="calendar.php" class="TitleLink">Calendar </a>
                                
                                <?php
							}
							?>
                                
                                </div>
                                    </td>
                                    
                                </tr>
                                 <tr>
                                      <td>Event Title</td>
                                      <td>&nbsp;:&nbsp;</td>
                                      <td >
                                      <input type="text" tabindex="" id="eTitle1" name="eTitle1" value="<?=$eTitle1?>" size="60" class="txtbox1">
                                      
                                  </tr>
                                  
                                  <tr><td height="5">  </td>
                        </tr>
                                 
                                  <tr>
                                      <td>Date</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td>
                                      <input type="text" tabindex="" id="appDate1" name="appDate1" class="datepicker txtbox1"  value="<?=$appDate1?>" >(DD/MM/YYYY)
                                    </td>
                                </tr>
                                 
                                 <tr><td height="5">  </td>
                        </tr>
                                 
                                  <tr>
                                      <td>Time</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td valign="top"><input type="text" tabindex="" id="startTime" name="startTime" value="<?php echo $fromTime; ?>" class="txtbox1 time-entry" style="width:100px" />
                        <span> to </span> <input type="text" tabindex="" id="endTime" name="endTime" value="<?php echo $toTime; ?>" class="txtbox1 time-entry" style="width:100px" />(HH:MM)<span class="detail_red">*</span>
									</td>
                                    
                                </tr>
                                
                                <tr><td height="5">  </td>
                        </tr>
                                
                                	<tr>
                                      <td width="">Staff Ref</td>
                                  	<td>&nbsp;:&nbsp;</td>
                                    <td>
									  
									     <?
							 $comquery = "SELECT _ID,_FullName FROM ".$tbname."_user WHERE _status = 1 ";
	 
	
	$comrow = mysql_query('SET NAMES utf8');
	$comrow = mysql_query($comquery,$connect);
							 ?>	
                       	  <select  tabindex="" name="staffRef" class="dropdown1 chosen-select">
                                <option value="">-- Select one --</option>
                               <? while($comdata = mysql_fetch_assoc($comrow)){
		
		?>
		<option value="<?=$comdata['_ID']?>" <? if($comdata['_ID']==$staffRef) {echo " selected='selected'"; }?>><?=replaceSpecialCharBack($comdata['_FullName'])?></option>	
	<? }?>
                            </select>
                                      </td>
                                  </tr>
                                  
                                  <tr><td height="5">  </td>
                        </tr>
                                
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td colspan="4">
                                     <input type="button" name="butCancel" id="butCancel" value="< Back" onClick="window.location='appointments.php'" class="button1">
                        
                                    
                                    <input type="submit" name="btnSearch" class="button1" value="Search" />
                                   
                                    <input type="button" class="button1" name="btnClearAll" value="Clear All" onclick="ClearAll('AdvancedSearch');" /></td>
                                  </tr>
                              </table>
                              </form>
                            </div>
                          <div id="polist">
                            <form name="FormName" method="post" action="">
                            <table style="margin-top:10px;" cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                <td colspan="2"><strong>Appointment List</strong></td>
                              </tr>
                                <tr>
                                <td colspan="1" class="pageno"><?php 
											$pageshowlimit = 2;
											
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
											  $sProjectPrev = "<a href='?PageNo=" . encrypt(((int) $pageshowpoint - (int) $pageshowlimit + 1) ,$Encrypt). "&amp;pageshowpoint=" . encrypt(((int) $pageshowpoint - (int) $pageshowlimit),$Encrypt) . $QureyUrl . "' class='menulink'>Previous " . $pageshowlimit . "</a> ";
											}
					
											if ((int) $MaxPage <= (int) $pageshowend) {
											  $sProjectNext = "";
											} elseif ((int) $MaxPage > (int) $pageshowend) {
											  $sProjectNext = "<a href='?PageNo=" . encrypt(((int) $pageshowpoint + (int) $pageshowlimit + 1),$Encrypt) . "&amp;pageshowpoint=" . encrypt(((int) $pageshowpoint + (int) $pageshowlimit),$Encrypt) . $QureyUrl . "' class='menulink'>Next " . $pageshowlimit . "</a> ";
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
													print "<a class=\"selected\" href='?PageNo=". encrypt($i,$Encrypt). "&amp;pageshowpoint=" . encrypt($_GET['pageshowpoint'],$Encrypt)  . $QureyUrl ."' class='menulink'>".$i."</a> ";
												}
												else
												{
													print "<a class=\"unselect\" href='?PageNo=" . encrypt($i,$Encrypt). "&amp;pageshowpoint=" . encrypt($_GET['pageshowpoint'],$Encrypt) . $QureyUrl ."' class='menulink'>".$i."</a> ";
												}
											}
									
											if ($sProjectNext != "") {
											  print "&nbsp;&nbsp;" . $sProjectNext;
											}
									?></td>
                                <?php
									if ($RecordCount > 0)
										{
										?>
                                <td><div align="right"><?php print "$RecordCount record(s) founds - You are at page $PageNo  of $MaxPage"; ?></div></td>
                                <?php } ?>
                              </tr>
                                <tr>
                                <td colspan="2" height="5"><input type="hidden" name="e_action" value="delete" /></td>
                              </tr>
                                <tr>
                                <td align="left"><?
									
										if ($RecordCount > 0)
										{
									?>
                                    
                                    
                                              <?php                       
							if(in_array("Archive",$Operations))
							{
								?>
                                    
                                    <input type="button" class="button1" name="btnSubmit2" value="Archive" onclick="return validateForm3();" style="width:110px;" />
                                    &nbsp;                                      &nbsp;
                                    
                                       <?php
							}
							
							?>
                            
                               <?php                       
							if(in_array("Export",$Operations))
							{
								?>
                                    <input type="button" class="button1" name="btnExportCSV" value="Export To Excel" onclick="javascript:export2CSV();"   style="width:110px;"/></td>
                                <?
										}
										
										}
									
									?>
                                <td align="right"></td>
                              </tr>
                                <tr>
                                <td colspan="2" height="5"></td>
                              </tr>
                                <tr>
                                <td colspan="2"><table cellspacing="0" cellpadding="3" width="100%" border="0" class="grid" >
                                    <tr>
                                    <td class="gridheader" width="30" align="center"><input name="AllCheckbox" id="AllCheckbox" type="checkbox"   tabindex="" value="All" onclick="CheckUnChecked('FormName','CustCheckbox',document.FormName.cntCheck.value,this,'9');" /></td>
                                    <td class="gridheader" width="30" align="center">No.</td>
                                    <td class="gridheader"  align="center">Date/Time</td>
                                    <td class="gridheader"><a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_ProductName',$Encrypt)?><?=$ExtraUrl?>" class="link1">Event Title</a></td>
                                    <td class="gridheader"><a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_Description',$Encrypt)?><?=$ExtraUrl?>" class="link1">Staff Ref</a></td>
									<td class="gridheader datecolumn"  align="center">Submitted By</td>
                                    <td class="gridheader datecolumn"  align="center">Submitted Date</td>
                                    
                                    <td class="gridheader">System Status</td>
                                    <td class="gridheader" align="center" style="width:5%">Edit</td>
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
                                    <td id="Row1ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="30" align="center"><input name="CustCheckbox<?php echo $i; ?>" type="checkbox"   tabindex="" value="<?php echo $rs["_ID"]; ?>" onclick="setActivities(this.form.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>','9');" /></td>
                                    <td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
                                    <td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="100"  align="center"><?=replaceSpecialCharBack($rs["_AppDate"])?></td>
                                    <td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left"><?=$rs['_Title']?></td>
                                    <td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" ><?php echo replaceSpecialCharBack($rs["_StaffRef"]) ?></td>
                                    <td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_Fullname"])?></td>
                                    <td id="Row7ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_SubmittedDate"])?></td>
                                    <td id="Row8ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" ><?=replaceSpecialCharBack($rs["_status"])?></td>
                                    <td id="Row9ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;
                           
                            
                               <?php                       
							if(in_array("Edit",$Operations))
							{
								?>
                                    
                                    <a href="appointment.php?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;id=<?=encrypt($rs["_ID"],$Encrypt)?>&amp;e_action=<?=encrypt('edit',$Encrypt)?>&amp;pageshowpoint=<?=encrypt($_GET['pageshowpoint'],$Encrypt)?>" class="TitleLink">Edit</a>
                                    
                                     <?php
							}
									?>
                                    </td>
                                    
                                  </tr>
                                    <?php
												$i++;
												}
											} else {
												echo "<tr><td colspan='10' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
														}
											?>
                                  </table></td>
                              </tr>
                                <tr>
                                <td colspan="2" height="5"></td>
                              </tr>
                                <tr>
                                <td align="left"><?
										if ($RecordCount > 0)
										{
									?>
                                    
                                    
                                              <?php                       
							if(in_array("Archive",$Operations))
							{
								?>
                                    
                                    <input type="button" class="button1" name="btnSubmit2" value="Archive" onclick="return validateForm3();" style="width:110px;" />
                                    &nbsp;                                      &nbsp;
                                    
                                       <?php
							}
							
							?>
                            
                               <?php                       
							if(in_array("Export",$Operations))
							{
								?>
                                    
                                    <input type="button" class="button1" name="btnExportCSV" value="Export To Excel" onclick="javascript:export2CSV();"   style="width:110px;"/></td>
                                <?
										}
										
										}
									?>
                                <td align="right"></td>
                              </tr>
                                <tr>
                                <td colspan="2" height="5"><input type="hidden" name="cntCheck" value="<?php echo $i-1; ?>" /></td>
                              </tr>
                                <tr>
                                <td colspan="1" class="pageno"><?php
										$pageshowlimit = 2;
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
											  $sProjectPrev = "<a href='?PageNo=" . encrypt(((int) $pageshowpoint - (int) $pageshowlimit + 1) ,$Encrypt). "&amp;pageshowpoint=" . encrypt(((int) $pageshowpoint - (int) $pageshowlimit),$Encrypt) . $QureyUrl . "' class='menulink'>Previous " . $pageshowlimit . "</a> ";
											}
					
											if ((int) $MaxPage <= (int) $pageshowend) {
											  $sProjectNext = "";
											} elseif ((int) $MaxPage > (int) $pageshowend) {
											  $sProjectNext = "<a href='?PageNo=" . encrypt(((int) $pageshowpoint + (int) $pageshowlimit + 1),$Encrypt) . "&amp;pageshowpoint=" . encrypt(((int) $pageshowpoint + (int) $pageshowlimit),$Encrypt) . $QureyUrl . "' class='menulink'>Next " . $pageshowlimit . "</a> ";
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
													print "<a class=\"selected\" href='?PageNo=". encrypt($i,$Encrypt). "&amp;pageshowpoint=" . encrypt($_GET['pageshowpoint'],$Encrypt) . $QureyUrl ."' class='menulink'>".$i."</a> ";
												}
												else
												{
													print "<a class=\"unselect\" href='?PageNo=" . encrypt($i,$Encrypt). "&amp;pageshowpoint=" . encrypt($_GET['pageshowpoint'],$Encrypt) . $QureyUrl ."' class='menulink'>".$i."</a> ";
												}
											}
									
											if ($sProjectNext != "") {
											  print "&nbsp;&nbsp;" . $sProjectNext;
											}
									?></td>
                              </tr>
                                <tr>
                                <td>&nbsp;</td>
                              </tr>
                              </table>
                          </form>
                          </div></td>
                      </tr>
                  </table>
                  </div></td>
              </tr>
          </table>
          </div></td>
      </tr>
    </table>
    
</body>
</html>
 <? include('jqueryautocomplete.php') ?>
<?php		

include('../dbclose.php');
?>