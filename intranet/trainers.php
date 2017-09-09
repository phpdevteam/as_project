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
	
	$Operations = GetAccessRights(61);
	if(count($Operations)== 0)
	{
	 echo "<script language='javascript'>history.back();</script>";
	}
	
	$colCount = "13";
	//var_dump($_GET);
	
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
		
		$(function(){
				 var screenWidth = (screen.width-(screen.width/3));
				if(screenWidth<965)
					screenWidth = 965;
				
				$('#SearchByAdv').click(function(event) {
  				event.preventDefault();
				$('#AdvancedSearch').show();
				$('#QuickSearch').hide();
				$('#CustomersList').hide();
			});	
		
				<?
				if($_GET['SearchBy']=='AdvSearch'){?>
				
				$('#AdvancedSearch').hide();
				$('#QuickSearch').show();
				$('#CustomersList').show();
				<? }else if($_GET['SearchBy']=='AdvSearch1'){ ?>
			 			
				$('#AdvancedSearch').show();
				$('#QuickSearch').hide();
				$('#CustomersList').hide();
				
			<? }else{ ?>
				
				$('#AdvancedSearch').hide ();
				$('#QuickSearch').show();
				$('#CustomersList').show();
				<? }?>
		
		});
			
		function validateForm3()
		{
			if(!checkSelected('FormName','CustCheckbox', document.FormName.cntCheck.value))
			{
				alert("Please select at least one checkbox.");
				document.FormName.AllCheckbox.focus();
				return false;
			}
			else
			{
				if(confirm('Are you sure you want to archive the selected Record(s)?'))
				{
					document.forms.FormName.action = "trainer_action.php";
					document.forms.FormName.submit();
				}
			}
		}
		
		function clearDefault()
		{
		 var keyword = $("#Keywords").val();	 
		 if(keyword == "Enter Any Keywords")
			 {
				 $("#Keywords").val("");	
			 } 
			 
			 
		  var clientName = $("#clientName").val();	 
		 if(clientName == "Enter Company Name")
			 {
				 $("#clientName").val("");	
			 } 
			 
		 }

		function export2CSV()
	{
		document.forms.FormName.action ="exportexcel.php?name=trainerlist";
	    document.forms.FormName.submit();	
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
                        
                        	<table width="100%" cellspacing="0" cellpadding="0" border="0">
						<tr>							
							<td>							
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
								  <td align="left" class="TitleStyle"><b>Trainers</b></td>
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

                                            $sortBy 		= trim($_GET["sortBy"]);										  
                                            $sortArrange	= trim($_GET["sortArrange"]);
											
											if (trim($sortArrange) == "DESC")
												$sortArrange = "ASC";
											elseif (trim($sortArrange) == "ASC")
												$sortArrange = "DESC";
											else
												$sortArrange = "DESC";
														
                                            $Keywords 		= trim($_GET["Keywords"]);
                                            $trainerno		= trim($_GET["trainerno"]);	
                                            $trainerName	= trim($_GET["trainerName"]);	
                                            $trainerCat 	= trim($_GET["trainerCat"]);
											$nric 		    = trim($_GET["nric"]);
											$address3 		= trim($_GET["address3"]);
                                            $telephone	 	= trim($_GET["telephone"]);
                                            $fax 			= trim($_GET['fax']);										
                                            $email 			= trim($_GET['email']);
                                            $postalcode     = trim($_GET['postalcode']);
											$trainername    = trim($_GET['trainername']);
											$programtype    = trim($_GET['programtype']);
											$location       = trim($_GET['location']);
											$nsipt          = trim($_GET['nsipt']);
											
											
											 $status =   trim($_GET['status']);	
											 
											  if(!isset($_GET['status']))
												$status = 1;			
											
                                           
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
                                            
                                        
                                            $str1 = "SELECT tr.*,tcat._TrainerCatName  FROM ".$tbname."_trainers AS tr LEFT JOIN as_trainerscat tcat ON tr._TrainerCatID = tcat._ID  WHERE tr._ID > 0";

                                            if($Keywords != "Enter Any Keywords" && $Keywords != "")
                                            {
												 $str1 = $str1 . " AND (tr._FullName LIKE '%".replaceSpecialChar($Keywords)."%' ";
                                                
                                                 $str1 = $str1 . " OR tr._TrainerRefNo LIKE '%".replaceSpecialChar($Keywords)."%' ";

												 $str1 = $str1 . " OR tr._FullNameChines LIKE '%".replaceSpecialChar($Keywords)."%' ";

												 $str1 = $str1 . " OR tcat._TrainerCatName	 LIKE '%".replaceSpecialChar($Keywords)."%' ";
												
										         $str1 = $str1 . " OR tr._Nric LIKE '%".replaceSpecialChar($Keywords)."%' ";

										         $str1 = $str1 . " OR tr._Nationality LIKE '%".replaceSpecialChar($Keywords)."%' ";

											     $str1 = $str1 . " OR tr._CountryDob LIKE '%".replaceSpecialChar($Keywords)."%' ";

											     $str1 = $str1 . " OR tr._Race LIKE '%".replaceSpecialChar($Keywords)."%' ";

												 $str1 = $str1 . " OR tr._Bankname LIKE '%".replaceSpecialChar($Keywords)."%' ";

												 $str1 = $str1 . " OR tr._Accountname LIKE '%".replaceSpecialChar($Keywords)."%' ";

												 $str1 = $str1 . " OR tr._Accountnumber LIKE '%".replaceSpecialChar($Keywords)."%' ";

												 $str1 = $str1 . " OR tr._EmployerName LIKE '%".replaceSpecialChar($Keywords)."%' ";
									            
                                                 $str1 = $str1 . " OR tr._address LIKE '%".replaceSpecialChar($Keywords)."%' ";

												 $str1 = $str1 . " OR tr._Handphone LIKE '%".replaceSpecialChar($Keywords)."%' ";
											  
                                                 $str1 = $str1 . " OR tr._email LIKE '%".replaceSpecialChar($Keywords)."%') ";
                                                
                                               
                                            }
                                            
                                            else if($trainerName != "Enter Trainer Name" && $trainerName != "")
                                            {
												
                                                $str1 = $str1 . " AND (tr._FullName LIKE '%".replaceSpecialChar($trainerName)."%' )";
											}

											 else if($trainerCat != "Search Trainer Category" && $trainerCat != "")
                                            {
												
                                                $str1 = $str1 . " AND (tcat._TrainerCatName LIKE '%".replaceSpecialChar($trainerCat)."%' )";
											}
											 else if($nric != "Enter NRIC" && $nric != "")
                                            {
												
                                                $str1 = $str1 . " AND (tr._Nric LIKE '%".replaceSpecialChar($nric)."%' )";
											}

											 else if($email != "Enter Email" && $email != "")
                                            {
												
                                                $str1 = $str1 . " AND (tr._Email LIKE '%".replaceSpecialChar($email)."%' )";
											}
                                            else
                                            {
												
												 if ($trainerno != "" && $trainerno2 != "") $str1 = $str1 . " AND tr._TrainerRefNo between '".replaceSpecialChar($trainerno)."'  and '".replaceSpecialChar($trainerno2)."'";
												
                                                 else if ($trainerno != "") $str1 = $str1 . " AND tr._TrainerRefNo LIKE '%".replaceSpecialChar($trainerno)."%' ";
                                           
                                                if($status != "")
												{
													$str1 = $str1 . " AND tr._Status = ". $status ."";						
												}
												
											
                                                
												if ($postalcode != "") $str1 = $str1 . " AND tr._Postalcode = '".replaceSpecialChar($postalcode)."' ";
												
                                            }
                                            
											$str1 .= " GROUP BY tr._ID ";
                                            
                                            if (trim($sortBy) != "" && trim($sortArrange) != "")
                                                $str2 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
                                            else
                                                $str2 = $str1 . " ORDER BY tr._ID LIMIT $StartRow,$PageSize ";

                                            $str3 = $str1;
                                            
											if (trim($sortBy) != "" && trim($sortArrange) != "")
                                                $str3 .= " ORDER BY ".trim($sortBy)." ".trim($sortArrange);

										    $_SESSION['trainerlist'] = $str3;
											
                                            $TRecord = mysql_query('SET NAMES utf8');
                                            $result = mysql_query('SET NAMES utf8');
                                            $TRecord = mysql_query($str1, $connect);
                                            $result = mysql_query($str2, $connect) or die(mysql_error());
                                                                    
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
                                            
                                            $QureyUrl = "&amp;type=".$_REQUEST['type']."&amp;Keywords=".$Keywords."&amp;SearchBy=".$SearchBy.
                                                                    "&amp;trainerName=".$_REQUEST['trainerName']."&amp;trainerno=".$_REQUEST['trainerno']."&amp;precompanyname=".$_REQUEST['precompanyname']."&amp;address=".$_REQUEST['address'].
                                                                    "&amp;telephone=".$telephone.
                                                                    "&amp;email=".$email.
                                                                    "&amp;remarks=".$remarks.
                                                                    "&amp;sortBy=".$sortBy.
																	"&amp;sortArrange=".$sortArrange;
                                                                    
                                                                    
                                           $ExtraUrl = "&amp;type=".$_REQUEST['type']."&amp;Keywords=".$Keywords."&amp;SearchBy=".$SearchBy.
                                                                    "&amp;trainerName=".$_REQUEST['trainerName']."&amp;trainerno=".$_REQUEST['trainerno']."&amp;address=".$_REQUEST['address'].
                                                                    "&amp;telephone=".$telephone.
                                                                    "&amp;email=".$email.
                                                                    "&amp;remarks=".$remarks.
                                                                    "&amp;sortArrange=".$sortArrange;
                                            
                                                /* '''''''''''''''''''''''''''''''''''''''''''''''''''''''' */
												//echo $ExtraUrl ;
												//echo $QureyUrl;
                                             ?>
                               
                                 		<div id="QuickSearch">
                                            <form name="QuickSearch" action="trainers.php" method="get" onsubmit="clearDefault()">
                                             <input type="hidden" name="status" value="<?=$status?>" />
                                             <input type="hidden" name="cstatus" value="<?=$cstatus?>" />
                                             <input type="hidden" name="type" value="<?=$type?>" />
                                              <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                              
												<tr>
													<td align="left" colspan="6"><b>Quick Search/List Clients</b></td>   
														<td align="right" style="padding-right:2px;">
														<?php                       
														if(in_array("Add",$Operations))
														{
															?>
																
																<a href="trainer.php?type=<?=$_REQUEST['type']?>" class="TitleLink">Add New</a>
																
																<?php
														}
														?>
																
														</td>  
													</tr>
													
													<tr><td height="5"></td></tr>
                                              
                                                    <tr>
														<td class="defaultTextlbl"><input name="Keywords" type="text" tabindex="" title="Enter Any Keywords" class="defaultText" id="Keywords" value="<?=$Keywords?>" maxlength="255"/></td>
														<td width="5"></td>
														<td class="defaultTextlbl"><input name="trainerno" type="text" tabindex="" title="Search Trainers Ref"  class="defaultText" id="trainerno" value="<?=$trainerno?>" maxlength="255" /></td>
														<td width="5"></td>
														<td class="defaultTextlbl"><input name="trainerName" type="text" tabindex="" title="Enter Trainer Name" class="defaultText" id="trainerName" value="<?=$trainerName?>" maxlength="255" /></td>
														<td width="5"></td>
														<td colspan="3"></td>
                                                    </tr>
													<tr><td height="5"></td> </tr>
													<tr>
														<td class="defaultTextlbl"><input name="email" type="text" tabindex="" title="Enter Email" class="defaultText" id="email" value="<?=$email?>" maxlength="255"/></td>
														<td width="5"></td>
														<td class="defaultTextlbl"><input name="trainerCat" type="text" tabindex="" title="Search Trainer Category"  class="defaultText" id="trainerCat" value="<?=$trainerCat?>" maxlength="255" /></td>
														<td width="5"></td>
														<td colspan="3">
															<input name="nric" type="text" tabindex="" title="Enter NRIC" class="defaultText" id="nric" value="<?=$nric?>" maxlength="255" />
														</td>
                                                    </tr>
													<tr><td height="5"></td> </tr>
													<tr>
														<td colspan="3">
															<input type="submit" name="btnSearch" class="button1" value="Search" />
															<input type="button" name="btnSearch" class="button1" onclick="ClearAll('QuickSearch');" value="Clear All" />       </td>
                                                    </tr>
                                                </table>
                                            </form>	
                                    	</div>
                                 	</td> </tr>
									
									<tr><td height="5"></td></tr>
                                    
                                    <tr><td align="left" class="TitleStyle" colspan="2"></td></tr>
                                    
                                    <tr><td align="left"  colspan="2">
                                    	<div id="CustomersList" style="clear:both">	
                                                      Filtered By:<br />	
                                        Training Type: 
										<?php
										if($trainingtype != "")
										{
										?>  
											<a href="trainers.php?status=" class="TitleLink" id="SearchByAdv">All</a>
										<?php
										}
										else
										{
										?>
										
											<a href="trainers.php?status="  class="currentfilter" >All</a>
										
										<?php
										}
										?>
										| 
										<?php
										if($trainingtype !=  1)
										{
										?>  
											<a href="trainers.php?status=1" class="TitleLink">Personal Training</a>
										<?php
										}
										else
										{
										?>
											<a href="trainers.php?status=1"  class="currentfilter">Personal Training</a>
										<?php
										}
										?>
										|
										<?php
										if($trainingtype != 2)
										{
										?>  
											<a href="trainers.php?status=2" class="TitleLink">Group Training</a>
										<?php
										}
										else
										{
										?>
											<a href="trainers.php?status=2"  class="currentfilter">Group Training</a>
										<?php
										}
										?>
                                         <br />	
										System Status: 
										<?php
										if($status != "")
										{
										?>  
											<a href="trainers.php?status=" class="TitleLink" >All</a>
										<?php
										}
										else
										{
										?>
											<a href="trainers.php?status="  class="currentfilter" >All</a>
										<?php
										}
										?>
										| 
										<?php
										if($status !=  1)
										{
										?>  
											<a href="trainers.php?status=1" class="TitleLink">Live</a>
										<?php
										}
										else
										{
										?>
											<a href="trainers.php?status=1"  class="currentfilter">Live</a>
										<?php
										}
										?>
										|
										<?php
										if($status != 2)
										{
										?>  
											<a href="trainers.php?status=2" class="TitleLink">Archive</a>
										<?php
										}
										else
										{
										?>
											<a href="trainers.php?status=2"  class="currentfilter">Archive</a>
										<?php
										}
										?>
                                         
                                        <form name="FormName" method="post" action="">
                                            <table style="margin-top:10px;" cellpadding="0" cellspacing="0" border="0" width="100%">
                                       			 <td colspan="1" class="pageno">
												 <?php
										
										
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
											}	?></td>
													<?php
													if ($RecordCount > 0)
														{
														?>
                                                    <td><div align="right"><?php print "$RecordCount record(s) founds - You are at page $PageNo  of $MaxPage"; ?></div></td>
                                                    <?php } ?>
                                            
                                                                            
                                        <tr><td colspan="2" height="5"><input type="hidden" name="e_action" value="delete" /></td></tr>
                                        <tr>
                                            <td align="left">									
                                            <?
                                            
                                                if ($RecordCount > 0)
                                                {
                                            ?>
                                            
                                            <?php                       
							if(in_array("Archive",$Operations))
							{
								?>
                                            
                                            <input type="button" class="button1" name="btnSubmit2" value="Archive" onclick="return validateForm3();" style="width:110px;" />
                                            &nbsp;
                                            <?php
							}
							
							?>
                            
                               <?php                       
							if(in_array("Export",$Operations))
							{
								?>
                                            
                                            
                                            <input type="button" class="button1" name="btnExportCSV" value="Export To Excel" onclick="javascript:export2CSV();"   style="width:110px;" />
                                            
                                             <?php
							}
							
							?>
                                            </td>
                                            <?
                                                }
                                            
                                            ?>
                                            <td align="right"></td>
                                        </tr>
                                        <tr><td colspan="2" height="5"></td></tr>
                                        <tr>
                                            <td colspan="2">
                                            
                                                <table cellspacing="0" cellpadding="3" width="100%" border="0" class="grid" >
                                                    <tr>
                                                        <td class="gridheader" width="30" align="center"><input name="AllCheckbox" id="AllCheckbox" type="checkbox"   tabindex="" value="All" onclick="CheckUnChecked('FormName','CustCheckbox',document.FormName.cntCheck.value,this,'<?=$colCount?>');" /></td>
                                                        <td class="gridheader" width="30" align="center">No.</td>
                                                        <td class="gridheader" width="100" align="center"><a href="?PageNo=<?=$PageNo?>&amp;sortBy=_TrainerRefNo<?=$ExtraUrl?>" class="link1">Tranier Ref No.</a></td>
                                                        <td class="gridheader" width="150" align="center">
                                                            &nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_FullName<?=$ExtraUrl?>" class="link1">Trainer Name</a>
                                                        </td>
                                                       
                                                        <td class="gridheader" width="150" align="center">
                                                            &nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_TrainerCatName	<?=$ExtraUrl?>" class="link1">Trainer Category</a>
														</td>
														<td class="gridheader" width="110" align="center">
                                                            &nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_Handphone<?=$ExtraUrl?>" class="link1">Contact Num</a>
														</td>
													  
                                                        <td class="gridheader datecolumn"   align="center">
															<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_Nric<?=$ExtraUrl?>" class="link1">
                                                            &nbsp;NRIC </a>
                                                        </td>
                                                        
                                                        <td class="gridheader" width="100"  align="center">
                                                            &nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_Status<?=$ExtraUrl?>" class="link1">Status</a>
                                                        </td>
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
                                                        <tr class="clickableRow" href="trainer.php?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;id=<?=encrypt($rs["_ID"],$Encrypt)?>&amp;e_action=<?=encrypt("edit",$Encrypt)?>" style="cursor:pointer" >
                                                            <td id="Row1ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="30" align="center">
                                                              <input name="CustCheckbox<?php echo $i; ?>" type="checkbox"   tabindex="" value="<?php echo $rs["_ID"]; ?>" onclick="setActivities(this.form.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>','<?=$colCount?>');" />
                                                               <input name="searchID[]" type="hidden" value="<?php echo $rs["_ID"]; ?>" />
                                                            </td>
                                                            <td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
                                                            <td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $rs['_TrainerRefNo']; ?>&nbsp;</td>
                                                            <td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="100"><?=replaceSpecialCharBack($rs["_FullName"])?></td>
                                                            <td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" ><?php echo ($rs['_TrainerCatName']) ?></td>
                                                            <td id="Row8ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_Handphone"])?></td>
                                                            <td id="Row9ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_Nric"])?></td>
                                                            <td id="Row10ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?= ($rs['_Status'] == '1' ? 'Live' : 'Archive')?></td> 
                                                           
                                                                                                        
                                                            <td id="Row12ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;
															<?php                       
															if(in_array("Edit",$Operations))
															{
																?>
																
																<a href="trainer.php?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;id=<?=encrypt($rs["_ID"],$Encrypt)?>&amp;e_action=<?=encrypt("edit",$Encrypt)?>" class="TitleLink">Edit</a>
																
																<?php
														
															} ?>
                                                            
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
                                                                }
                                                    ?>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr><td colspan="2" height="5"></td></tr>
                                        <tr>
                                            <td align="left">
                                            
                                            <?
                                                if ($RecordCount > 0)
                                                {
                                            ?>
                                            
                                             <?php                       
							if(in_array("Archive",$Operations))
							{
								?>
                                            <input type="button" class="button1" name="btnSubmit2" value="Archive" onclick="return validateForm3();" style="width:110px;" />
                                            &nbsp;
                                            
                                            
                           <?php
							}
							
							?>
                            
                               <?php                       
							if(in_array("Export",$Operations))
							{
								?>
                                            <input type="button" class="button1" name="btnExportCSV" value="Export To Excel" onclick="javascript:export2CSV();"   style="width:110px;" />
                                            
                                             <?php
							}
							
							?>
                            
                            <?
                                                }
                                            ?>
                                            
                                            </td>
                                             
                                            <td align="right"> 			
                                                
                                            </td>
                                        </tr>								
                                        <tr><td colspan="2" height="5"><input type="hidden" name="cntCheck" value="<?php echo $i-1; ?>" /></td></tr>
                                        <tr>
                                            <td colspan="1" class="pageno">
                                            <?php
                                            
                                            /*if ($sProjectPrev != "")
                                                  {
                                                      print $sProjectPrev . "&nbsp;&nbsp;";
                                                  }
                                                  
                                                if($MaxPage > 0) echo "Page: ";
                                                for ($i = (int) $pageshowstart; $i <= (int) $untilpage; $i++) 
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
                                                
                                                if ($sProjectNext != "") {
                                              print "&nbsp;&nbsp;" . $sProjectNext;
                                          }
                                            ?>*/
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
                        
                     /*   if (trim($sortArrange) == "DESC")
                            $sortArrange = "ASC";
                        elseif (trim($sortArrange) == "ASC")
                            $sortArrange = "DESC";
                        else
                            $sortArrange = "DESC";*/
									
									?>
                                            </td>
                                            
                                        </tr>
                                    <tr><td>&nbsp;</td></tr>	
                                    </table>
                                         </form>														
                                    </div>
                                    </td></tr>
                            </table>
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