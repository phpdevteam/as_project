<?php 
    // die;
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript' type='text/javascript'>window.location='login.php';</script>";
    }
	include('../global.php');	
	include('../include/functions.php'); 
	include('access_rights_function.php'); 
    include("fckeditor/fckeditor.php");
	
	$e_action = $_REQUEST['e_action'];
	$Operations = GetAccessRights(1);
	if(count($Operations)== 0)
	{
		echo "<script language='javascript'>history.back();</script>";
	}
	
	 // $SQOperations = GetAccessRights(71);
	 // $POOperations = GetAccessRights(114);
	 // $DOOperations = GetAccessRights(111);
	 // $CustOperations = GetAccessRights(61);
	 // $InvOperations = GetAccessRights(339);
	 
	 
	
	$currentmenu = "Dashboard";
	
	$viewall =  $_REQUEST['viewall'];
	$tbl =  $_REQUEST['tbl'];
	
    $extraURL = "&viewall=" . $viewall ;
	
	$sortBy 		= trim($_GET["sortBy"]);
	$sortArrange	= trim($_GET["sortArrange"]);
	
	$limitCount = 10;
	
	
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
		
    function validateForm()
		{
			
			if($("input:checked").length == 0)
			{
				alert("Please select at least one checkbox.");
				document.FormName.AllCheckbox.focus();
				return false;
			}
			else
			{
				document.forms.FormName.action = "invoice.php";
				document.forms.FormName.submit();
				
			}
		}
    </script>
    		
<style type="text/css">
	.DispAnnounce{
		text-align:left;
		background-color:#CCC;
	}
	.DispAnnounce th{
		text-align:left;
		font-weight:bold;
	}
	
	.ColorLink{
		text-decoration:none;
		color:#382D2C;
		font-size:11px;
		font-family:verdana;
	}
</style>
</head>
	<body>

		<table align="center" width="970" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="align:center;">
			<tr>
				<td valign="top"> 
					<div class="maintable">
						<table width="970" border="0" cellspacing="0" cellpadding="0">			
							<tr><td valign="top" colspan="2"><?php include('topbar.php'); ?></td></tr>
							<tr>
								<td class="inner-block" width="970" align="left" valign="top">	
							   
								
								<div class="m">		
								
									<table cellpadding="0" cellspacing="0" border="0" width="100%">
										<tr>
											<td align="left" class="TitleStyle"><b>Dashboard</b></td>
										</tr>
									</table>
								   
								
									
									
								<?php
								$RecordCount = 0;
								$Operations = GetAccessRights(106);
								if(count($Operations) >  0)
								{
									?>
									
									<br />
									<div>
										<table width="99%" class="" cellspacing="0" cellpadding="0" id="tblsqapprove">
											<tr>
												<td class="" align="left" colspan="9">
												<b>Active Space Operations Summary</b>&nbsp;
												</td>
											</tr>
											
											<tr>
												<td class="gridheader" width="30" align="center">No.</td>
												<td class="gridheader" align="center"><a href="?sortBy=_quotationno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Name</a></td>
												<td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1" >Current</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Increase/Decrease (compare to last month)</a></td>
											</tr>
									
											<?php
											if ($RecordCount > 0)
											{						 
												?>
												<tr >
													<td  class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
													<td  class="<?php echo $Rowcolor; ?>" align="left" ><?=replaceSpecialCharBack($rs["_description"])?></td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack(number_format($rs["_nettotal"],2))?></td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_subby"])?></td>
												</tr>
											<?php 
											}
											else {
												echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											
											?>
										</table>
									</div>
										
									<? if($RecordCount > $limitCount )
									{ ?>
									
										<div align="right">
										<input type="button" class="button1" name="btnicVewAll" value="View All" onclick="window.location='?viewall=sqapprove'" style="width:100px;" />
										&nbsp;&nbsp;&nbsp;</div>
									
									<? }
									?>

							   <?php
							   $RecordCount = 0;
									$Operations = GetAccessRights(100);
								if(count($Operations) >  0)
								{
									?>           
								   <br/> 
									<div>
										<table width="99%" class="" cellspacing="0" cellpadding="0" id="tblpoapprove">
											<tr>
												<td class="" align="left" colspan="9">
												<b>Active Space Operations Summary</b>&nbsp;
												</td>
											</tr>                
											 <tr>
												<td class="gridheader" width="30" align="center">No.</td>
												<td class="gridheader" align="center"><a href="?sortBy=_quotationno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Name</a></td>
												<td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1" >Current</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Average</a></td>
											</tr>
											<?php
											if ($RecordCount > 0)
											{						 
												?>
												<tr >
													<td  class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
													<td  class="<?php echo $Rowcolor; ?>" align="left" ><?=replaceSpecialCharBack($rs["_description"])?></td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack(number_format($rs["_nettotal"],2))?></td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_subby"])?></td>
												</tr>
											<?php 
											}
											else {
												echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											
											?>
										</table>
									</div>
									
									  <? if($RecordCount > $limitCount ){ ?>
									 
									 <div align="right">
									<input type="button" class="button1" name="btnicVewAll" value="View All" onclick="window.location='?viewall=poapprove'" style="width:100px;" />
									&nbsp;&nbsp;&nbsp;</div>
									
									<? }
								}
											
											
											  }
											  ?>
											  
											  
								
								<?php
								
								$RecordCount = 0;
								
								$Operations = GetAccessRights(76);
								if(count($Operations) >  0)
								{
									?>
									<br/> 
									<div>
										<table width="99%" class="" cellspacing="0" cellpadding="0" id="tblpoapprove">
											<tr>
												<td class="" align="left" colspan="9">
												<b>This week Bookings</b>&nbsp;
												</td>
											</tr>                
											<tr>
												<td class="gridheader" width="30" align="center">No.</td>
												<td class="gridheader" align="center"><a href="?sortBy=_quotationno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Number of Participants</a></td>
												<td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1" >Trainee Name</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Training Location</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Trainer Name</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Booking Status</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Submitted Date</a></td>
												<td class="gridheader" align="center">Edit</td>
											</tr>
											<?php
											if ($RecordCount > 0)
											{						 
												?>
												<tr >
													<td  class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
													<td  class="<?php echo $Rowcolor; ?>" align="left" >  </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" ></td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
												</tr>
											<?php 
											}
											else {
												echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											
											?>
										</table>
									</div>
									
									  <? if($RecordCount > $limitCount ){ ?>
									 
									 <div align="right">
									<input type="button" class="button1" name="btnicVewAll" value="View All" onclick="window.location='?viewall=poapprove'" style="width:100px;" />
									&nbsp;&nbsp;&nbsp;</div>
									
									<? }
								}
								?>
								
								<?php
								$RecordCount = 0;
								$Operations = GetAccessRights(72);
								if(count($Operations) >  0)
								{
									?>
									<br/> 
									<div>
										<table width="99%" class="" cellspacing="0" cellpadding="0" id="tblpoapprove">
											<tr>
												<td class="" align="left" colspan="9">
												<b>Training Booking with less Min-to-Start participant</b>&nbsp;
												</td>
											</tr>                
											<tr>
												<td class="gridheader" width="30" align="center">No.</td>
												<td class="gridheader" align="center"><a href="?sortBy=_quotationno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Training ID</a></td>
												<td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1" >Client Name</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Training Location</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Trainer Name</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Booking with less min-to-start</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Per Session Pricing</a></td>
												<td class="gridheader" align="center">Approval</td>
												<td class="gridheader" align="center">Cancel</td>
											</tr>
											<?php
											if ($RecordCount > 0)
											{						 
												?>
												<tr >
													<td  class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
													<td  class="<?php echo $Rowcolor; ?>" align="left" >  </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" ></td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
												</tr>
											<?php 
											}
											else {
												echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											
											?>
										</table>
									</div>
									
									  <? if($RecordCount > $limitCount ){ ?>
									 
									 <div align="right">
									<input type="button" class="button1" name="btnicVewAll" value="View All" onclick="window.location='?viewall=poapprove'" style="width:100px;" />
									&nbsp;&nbsp;&nbsp;</div>
									
									<? }
								}
								?>
								
								<?php
								
								$RecordCount = 0;
									$Operations = GetAccessRights(73);
								if(count($Operations) >  0)
								{
									?>
									<br/> 
									<div>
										<table width="99%" class="" cellspacing="0" cellpadding="0" id="tblpoapprove">
											<tr>
												<td class="" align="left" colspan="9">
												<b>Training Venue Approval</b>&nbsp;
												</td>
											</tr>                
											<tr>
												<td class="gridheader" width="30" align="center">No.</td>
												<td class="gridheader" align="center"><a href="?sortBy=_quotationno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Training Space Name</a></td>
												<td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1" >Venue Type/Charges</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Amenities Available</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Venue/Amenity Charges</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Status</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Submitted Date</a></td>
												<td class="gridheader" align="center">Approval</td>
											</tr>
											<?php
											if ($RecordCount > 0)
											{						 
												?>
												<tr >
													<td  class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
													<td  class="<?php echo $Rowcolor; ?>" align="left" >  </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" ></td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
												</tr>
											<?php 
											}
											else {
												echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											
											?>
										</table>
									</div>
									
									  <? if($RecordCount > $limitCount ){ ?>
									 
									 <div align="right">
									<input type="button" class="button1" name="btnicVewAll" value="View All" onclick="window.location='?viewall=poapprove'" style="width:100px;" />
									&nbsp;&nbsp;&nbsp;</div>
									
									<? }

								}
								?>
										   
								
									   <?php

									$RecordCount = 0;
								 
								$Operations = GetAccessRights(339);
								if(count($Operations) >  0)
								{
									?>
									<br/> 
									<div>
										<table width="99%" class="" cellspacing="0" cellpadding="0" id="tblpoapprove">
											<tr>
												<td class="" align="left" colspan="9">
												<b>Trainers Approval</b>&nbsp;
												</td>
											</tr>                
											<tr>
												<td class="gridheader" width="30" align="center">No.</td>
												<td class="gridheader" align="center"><a href="?sortBy=_quotationno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Trainer Name</a></td>
												<td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1" >Contact Num</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Address</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Description</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Status</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Submitted Date</a></td>
												<td class="gridheader" align="center">Approval</td>
											</tr>
											<?php
											if ($RecordCount > 0)
											{						 
												?>
												<tr >
													<td  class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
													<td  class="<?php echo $Rowcolor; ?>" align="left" >  </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" ></td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
												</tr>
											<?php 
											}
											else {
												echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											
											?>
										</table>
									</div>
									
									  <? if($RecordCount > $limitCount ){ ?>
									 
									 <div align="right">
									<input type="button" class="button1" name="btnicVewAll" value="View All" onclick="window.location='?viewall=poapprove'" style="width:100px;" />
									&nbsp;&nbsp;&nbsp;</div>
									
									<? }
								}
								?>   
							   
									<br />
									
									
								<?php

								$RecordCount = 0;
								 
								$Operations = GetAccessRights(12);
								if(count($Operations) >  0)
								{?>
									<br/> 
									<div>
										<table width="99%" class="" cellspacing="0" cellpadding="0" id="tblpoapprove">
											<tr>
												<td class="" align="left" colspan="9">
												<b>Latest 10 Trainees Registrations</b>&nbsp;
												</td>
											</tr>                
											<tr>
												<td class="gridheader" width="30" align="center">No.</td>
												<td class="gridheader" align="center"><a href="?sortBy=_quotationno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Client Name</a></td>
												<td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1" >Contact Num</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Address</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Description</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Status</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Submitted Date</a></td>
												<td class="gridheader" align="center">Approval</td>
											</tr>
											<?php
											if ($RecordCount > 0)
											{						 
												?>
												<tr >
													<td  class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
													<td  class="<?php echo $Rowcolor; ?>" align="left" >  </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" ></td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
												</tr>
											<?php 
											}
											else {
												echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											
											?>
										</table>
									</div>
									
									  <? if($RecordCount > $limitCount ){ ?>
									 
									 <div align="right">
									<input type="button" class="button1" name="btnicVewAll" value="View All" onclick="window.location='?viewall=poapprove'" style="width:100px;" />
									&nbsp;&nbsp;&nbsp;</div>
									
									<? }
								}
								
								$RecordCount = 0;
								 
								$Operations = GetAccessRights(360);
								if(count($Operations) >  0)
								{?>
									<br/> 
									<div>
										<table width="99%" class="" cellspacing="0" cellpadding="0" id="tblpoapprove">
											<tr>
												<td class="" align="left" colspan="9">
												<b>Client Adhoc Training Request</b>&nbsp;
												</td>
											</tr>                
											<tr>
												<td class="gridheader" width="30" align="center">No.</td>
												<td class="gridheader" align="center"><a href="?sortBy=_quotationno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Client Name</a></td>
												<td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1" >Contact Num</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Location</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Date/Time</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Submitted Date</a></td>
												<td class="gridheader" align="center">View</td>
											</tr>
											<?php
											if ($RecordCount > 0)
											{						 
												?>
												<tr >
													<td  class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
													<td  class="<?php echo $Rowcolor; ?>" align="left" >  </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" ></td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
												</tr>
											<?php 
											}
											else {
												echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											
											?>
										</table>
									</div>
									
									  <? if($RecordCount > $limitCount ){ ?>
									 
									 <div align="right">
									<input type="button" class="button1" name="btnicVewAll" value="View All" onclick="window.location='?viewall=poapprove'" style="width:100px;" />
									&nbsp;&nbsp;&nbsp;</div>
									
									<? }
								}
								
								$RecordCount = 0;
								 
								$Operations = GetAccessRights(361);
								if(count($Operations) >  0)
								{?>
									<br/> 
									<div>
										<table width="99%" class="" cellspacing="0" cellpadding="0" id="tblpoapprove">
											<tr>
												<td class="" align="left" colspan="9">
												<b>Training Conducted with Unsatisfactory Review</b>&nbsp;
												</td>
											</tr>                
											<tr>
												<td class="gridheader" width="30" align="center">No.</td>
												<td class="gridheader" align="center"><a href="?sortBy=_quotationno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Client Name</a></td>
												<td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1" >Trainer Name</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Location</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Date/Time</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Submitted Date</a></td>
												<td class="gridheader" align="center">View</td>
											</tr>
											<?php
											if ($RecordCount > 0)
											{						 
												?>
												<tr >
													<td  class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
													<td  class="<?php echo $Rowcolor; ?>" align="left" >  </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" ></td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
												</tr>
											<?php 
											}
											else {
												echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											
											?>
										</table>
									</div>
									
									  <? if($RecordCount > $limitCount ){ ?>
									 
									 <div align="right">
									<input type="button" class="button1" name="btnicVewAll" value="View All" onclick="window.location='?viewall=poapprove'" style="width:100px;" />
									&nbsp;&nbsp;&nbsp;</div>
									
									<? }
								}
								
								$RecordCount = 0;
								 
								$Operations = GetAccessRights(362);
								if(count($Operations) >  0)
								{?>
									<br/> 
									<div>
										<table width="99%" class="" cellspacing="0" cellpadding="0" id="tblpoapprove">
											<tr>
												<td class="" align="left" colspan="9">
												<b>Trainer with Expired CPR/AED</b>&nbsp;
												</td>
											</tr>                
											<tr>
												<td class="gridheader" width="30" align="center">No.</td>
												<td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1" >Trainer Name</a></td>
												<td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Contact Name</a></td>
												<td class="gridheader" align="center">View</td>
											</tr>
											<?php
											if ($RecordCount > 0)
											{						 
												?>
												<tr >
													<td  class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
													<td  class="<?php echo $Rowcolor; ?>" align="left" >  </td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" ></td>
													<td  class="<?php echo $Rowcolor; ?>" align="center" > </td>
												</tr>
											<?php 
											}
											else {
												echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											
											?>
										</table>
									</div>
									
									  <? if($RecordCount > $limitCount ){ ?>
									 
									 <div align="right">
									<input type="button" class="button1" name="btnicVewAll" value="View All" onclick="window.location='?viewall=poapprove'" style="width:100px;" />
									&nbsp;&nbsp;&nbsp;</div>
									
									<? }
								}
								?> 
								<br />
									
								<div>
									<table width="99%" class="" cellspacing="0" cellpadding="0">
										<tr>
											<td class="" align="left" colspan="4">
											<b>Login History For&nbsp;<?php echo date("F Y");?></b>&nbsp;
											</td>
										</tr>
										<tr>
											<td class="gridheader" align="center" width="20%">&nbsp;<b>Username</b>&nbsp;</td>
											<td class="gridheader" align="center" width="21%">&nbsp;<b>IP Address</b>&nbsp;</td>
											<td class="gridheader" align="center" width="22%">&nbsp;<b>Date / Time In</b>&nbsp;</td>
											<td class="gridheader" align="center" width="22%">&nbsp;<b>Date / Time Out</b>&nbsp;</td>
										</tr>
										<?php
										$i = 1;
										$Rowcolor = "gridline1";
										$sql1 = "SELECT * FROM ".$tbname."_logginglog 
										INNER JOIN ".$tbname."_user 
										ON ".$tbname."_logginglog._UserID = ".$tbname."_user._ID 
										WHERE YEAR(_DateTimeIn) = '" . date("Y") . "' AND MONTH(_DateTimeIn) = '" . date("n") . "' 
										AND _UserID = '" . $_SESSION['userid'] . "' GROUP BY _DateTimeIn DESC LIMIT 1,1";

										
										$rst1 = mysql_query($sql1, $connect);
										if(mysql_num_rows($rst1) > 0)
										{
											while ($row1 = mysql_fetch_array($rst1))
											{
											if($Rowcolor == "gridline2")
											$Rowcolor = "gridline1";
											elseif ($Rowcolor == "gridline1")
											$Rowcolor = "gridline2";
											?>
											<tr>
												<td class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $row1['_Username']; ?>&nbsp;</td>
												<td class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $row1['_IPAddress']; ?>&nbsp;</td>
												<td class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php if($row1['_DateTimeIn'] != "") { echo date("j M Y g:i:s A", strtotime($row1['_DateTimeIn'])); } ?>&nbsp;</td>
												<td class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php if($row1['_DateTimeOut'] != "") { echo date("j M Y g:i:s A", strtotime($row1['_DateTimeOut'])); } ?>&nbsp;</td>
											</tr>
										<?php
											}
										}
										?>
										
										<tr><td height="5"></td></tr>
										
									</table>
								</div>
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