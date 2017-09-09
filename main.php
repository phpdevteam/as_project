<?php 
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
	
	 $SQOperations = GetAccessRights(71);
	 $POOperations = GetAccessRights(114);
	 $DOOperations = GetAccessRights(111);
	 $CustOperations = GetAccessRights(61);
	 $InvOperations = GetAccessRights(339);
	 
	 
	
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
        
        	<table width="99%" class="grid" cellspacing="0" cellpadding="0" id="tblsqapprove">
				<tr>
					<td class="gridheader" align="center" colspan="9">
					<b>SQ To Approve</b>&nbsp;
					</td>
				</tr>
                
                <tr>
					<td class="gridheader" width="30" align="center">No.</td>
                                              
                                                
												<td class="gridheader" align="center"><a href="?sortBy=_quotationno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">SQ No</a></td>
                                                
                                                <td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1" >Customer</a></td>
                                                
                                                         
                                                 <td class="gridheader" align="center"><a href="?sortBy=_customerid&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Description</a></td>
                                                
                                                  <td class="gridheader"  align="center"><a href="?sortBy=_nettotal&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Amount</a></td>                                 
                                                  <td class="gridheader datecolumn"  align="center"><a href="?sortBy=_subby&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Submitted By</a></td>
												
                                                   <td class="gridheader datecolumn"  align="center"><a href="?sortBy=_subdate&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">Submitted Date</a></td>
                                                                                          											
												  <td class="gridheader"  align="center"><a href="?sortBy=_sqstatus&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=sqapprove#tblsqapprove" class="link1">SQ Status</a></td>                                 
                                                 
                                                   		<td class="gridheader" align="center" style="width:5%">Edit</td>
                                                   
				</tr>
        
        <?php
				
				
				$str = "Select * From ".$tbname."_approvers Where _Module = 'SQ' 
		and ( _FirstApprovers = '". $_SESSION["userid"] ."' or _SecApprovers = '". $_SESSION["userid"] ."') ";
			
		$myrst = mysql_query($str);
		$mycount = mysql_num_rows($myrst);
		
		if($mycount > 0 )
		{
				$myrow = mysql_fetch_assoc($myrst);
				
					$str1 = "SELECT sq._customerid,qstatus._StatusName as _sqstatus,sq._ID,sq._quotationno,Date_Format(sq._subdate,'%d/%m/%Y') as _subdate,sq._quotationdate, usr._Fullname as _subby,cust._companyname,sq._customerid,cust._memberid as _memberid,_nettotal, sq._quotationremarks,sq._internalremarks,IF(sq._status = 1, 'Live', 'Draft') as Status  
					FROM ".$tbname."_salequotations  sq
					LEFT JOIN cd_sqstatus qstatus ON sq._sqstatus = qstatus._ID 
							LEFT JOIN ".$tbname."_customer cust ON sq._customerid = cust._ID 
							LEFT JOIN ".$tbname."_user usr ON sq._subby = usr._ID WHERE sq._status = 1 and sq._sqstatus = 1 ";
							
					
					if($myrow["_SecApprovers"] != $_SESSION["userid"])
					{				
					 
						if($myrow["_FirstApprovers"] == $_SESSION["userid"])
						{
							$str1 .= " and _nettotal <= " . $myrow["_FirstAmt"] ;
						}
					
					}
									
					$result = mysql_query($str1, $connect) or die(mysql_error());
					$RecordCount = mysql_num_rows($result);
					
					
					
					
				  if($tbl == "sqapprove")
					{
				
						if (trim($sortArrange) == "DESC")
									$sortArrange = "ASC";
								elseif (trim($sortArrange) == "ASC")
									$sortArrange = "DESC";
								else
									$sortArrange = "DESC";						
									
						if (trim($sortBy) != "" && trim($sortArrange) != "")
							$str1 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)."";
						else
							$str1 = $str1 . " ORDER BY sq._ID DESC ";
					
					}
						
					
					
			  if($viewall != "sqapprove")
					{
						$str1 .=" limit 0," . $limitCount;
					}			
				
				//echo $str1;
							
				    $result = mysql_query($str1, $connect);
					
			 ?>
		
				
				<?php
			
							
				    if ($RecordCount > 0) {
											$i = 1;											
											while($rs = mysql_fetch_assoc($result))
											{
												$bil = $i;	
												if  ($Rowcolor == "gridline2")
													$Rowcolor = "gridline1";
												else
													$Rowcolor = "gridline2";
													
												 if ($id == $rs["_ID"]) {
														$Rowcolor = "gridline3";
													}	
												?>
												<tr >
												
													<td  class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
                                                                                                       
													<td  class="<?php echo $Rowcolor; ?>" width="100"  align="center">
										
  		
     						<?php                       
							if(in_array("Edit",$SQOperations))
							{
								?> <a href="salesquotation.php?id=<?=encrypt($rs["_ID"],$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>">
									<?=replaceSpecialCharBack($rs["_quotationno"])?>
                                    </a>
                                   <?php
													
									}
									else
									{
									
									?>  
                                    <?=replaceSpecialCharBack($rs["_quotationno"])?>
                                   <?php
													
									}  
									?>               
                                                    </td>
                                                    
                                                    <td  class="<?php echo $Rowcolor; ?>" align="left" >
													
													
                                                    	<?php                       
							if(in_array("Edit",$CustOperations))
							{
								?> <a href="customer.php?id=<?=encrypt($rs["_customerid"],$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>">
									<?=replaceSpecialCharBack($rs["_companyname"])?>
                                    </a>
                                   <?php
													
									}
									else
									{
									
									?> 
                                    
                                    <?=replaceSpecialCharBack($rs["_companyname"])?>
                                    
                                    <?php
									}
									?>
                                             
                                                    
                                                    </td>
                                                  
                                                    <td  class="<?php echo $Rowcolor; ?>" align="left" ><?=replaceSpecialCharBack($rs["_address"])?></td>
                                                       
                                                    <td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack(number_format($rs["_nettotal"],2))?></td>
													
                                                    <td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_subby"])?></td>
                                                    
													<td  class="<?php echo $Rowcolor; ?>" align="center" ><?php echo replaceSpecialCharBack($rs["_subdate"]) ?></td>		
                                                    
                                                    <td  class="<?php echo $Rowcolor; ?>" align="center" ><?php echo replaceSpecialCharBack($rs["_sqstatus"]) ?></td>
                                                                    													
													<td  class="<?php echo $Rowcolor; ?>" align="center">
                                                    <?php
														$Operations = GetAccessRights(71);
														
														if(in_array("Edit",$Operations))
															{
													?>	
                                                    
                                                    
                                                    <a href="salesquotation.php?id=<?=encrypt($rs["_ID"],$Encrypt)?>&e_action=<?=encrypt('edit',$Encrypt)?>&pageshowpoint=<?=encrypt($_GET['pageshowpoint'],$Encrypt)?>" class="TitleLink">Edit</a>
                                                    
                                                    
                                                    <?php
															}
								
									?>  
                                                    
                                                    
                                                    </td>

												</tr>
												<?php
												$i++;
												}
												
					  }
											} else {
												echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											
				
											?>
                                            
                                            
                                            
										</table>
			</div>
            
             <? if($RecordCount > $limitCount ){ ?>
             
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
            
            <table width="99%" class="grid" cellspacing="0" cellpadding="0" id="tblpoapprove">
				<tr>
					<td class="gridheader" align="center" colspan="9">
					<b>PO To Approve</b>&nbsp;
					</td>
				</tr>
                
                	<tr>
					<td class="gridheader" width="30" align="center">No.</td>
                                              
                                                
												<td class="gridheader"  align="center"><a href="?sortBy=_purchaseorderno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=poapprove#tblpoapprove" class="link1">PO No</a></td>
                                                
                                                <td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=poapprove#tblpoapprove" class="link1">Supplier</a></td>
                                                
                                                         
                                                 <td class="gridheader" align="center"><a href="?sortBy=_address1&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=poapprove#tblpoapprove" class="link1">Description</a></td>
                                                
                                                  <td class="gridheader"  align="center"><a href="?sortBy=_nettotal&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=poapprove#tblpoapprove" class="link1">Amount</a></td>                                 
                                                   <td class="gridheader datecolumn"  align="center"><a href="?sortBy=_subby&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=poapprove#tblpoapprove" class="link1">Submitted By</a></td>
												
                                                   <td class="gridheader datecolumn"  align="center"><a href="?sortBy=_subdate&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=poapprove#tblpoapprove" class="link1">Submitted Date</a></td>
                                                                                          											
												<td class="gridheader"  align="center"><a href="?sortBy=_postatus&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=poapprove#tblpoapprove" class="link1">PO Status</a></td>                                 
                                                 
                                                 
                                                   
                                                   		<td class="gridheader" align="center" style="width:5%">Edit</td>
                                                   
				</tr>
            
            <?php
				
				
				
					$str = "Select * From ".$tbname."_approvers Where _Module = 'Purchase' 
		and ( _FirstApprovers = '". $_SESSION["userid"] ."' or _SecApprovers = '". $_SESSION["userid"] ."') ";
					
		$myrst = mysql_query($str);
		$mycount = mysql_num_rows($myrst);
		
		if($mycount > 0 )
		{
				$myrow = mysql_fetch_assoc($myrst);
				
					 $str1 = "SELECT sq._supplierid,pos._StatusName as _postatus,sq._address1,sq._ID,sq._purchaseorderno,Date_Format(sq._createddate,'%d/%m/%Y') as _subdate,sq._purchaseorderdate, usr._Fullname as _subby,cust._companyname,sq._supplierid,sq._address1, _nettotal, sq._remarks,IF(sq._status = 1, 'Live', 'Draft') as Status  
					FROM ".$tbname."_purchaseorders  sq
					LEFT JOIN ".$tbname."_postatus pos ON pos._ID = sq._postatus
							LEFT JOIN ".$tbname."_customer cust ON sq._supplierid = cust._ID 
							LEFT JOIN ".$tbname."_user usr ON sq._createdby = usr._ID WHERE sq._status = 1 and sq._postatus = 1 ";
				
					
					if($myrow["_SecApprovers"] != $_SESSION["userid"])
					{
					
						if($myrow["_FirstApprovers"] == $_SESSION["userid"])
						{
							$str1 .= " and _nettotal <= " . $myrow["_FirstAmt"] ;
						}
					
					}
					
					
					
					
					$result = mysql_query($str1, $connect);
					$RecordCount = mysql_num_rows($result);
					
					 if($tbl == "poapprove")
					{
				
						if (trim($sortArrange) == "DESC")
									$sortArrange = "ASC";
								elseif (trim($sortArrange) == "ASC")
									$sortArrange = "DESC";
								else
									$sortArrange = "DESC";						
									
						if (trim($sortBy) != "" && trim($sortArrange) != "")
							$str1 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)."";
						else
							$str1 = $str1 . " ORDER BY sq._ID DESC ";
					
					}
					
					
						if($viewall != "poapprove")
					{
						$str1 .=" limit 0," . $limitCount;
					}
					
							
					 $result = mysql_query($str1, $connect);
					 
					 ?>
			
			
				<?php
						
										
				     if ($RecordCount > 0) {
											$i = 1;											
											while($rs = mysql_fetch_assoc($result))
											{
												$bil = $i;	
												if  ($Rowcolor == "gridline2")
													$Rowcolor = "gridline1";
												else
													$Rowcolor = "gridline2";
													
												 if ($id == $rs["_ID"]) {
														$Rowcolor = "gridline3";
													}	
												?>
												<tr >
												
													<td  class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
                                                                                                       
													<td  class="<?php echo $Rowcolor; ?>" width="100"  align="center">
													
													
													<?php                       
							if(in_array("Edit",$POOperations))
							{
								?> <a href="purchaseorder.php?id=<?=encrypt($rs["_ID"],$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>">
									<?=replaceSpecialCharBack($rs["_purchaseorderno"])?>
                                    </a>
                                   <?php
																	
									}
									else
									{
									
									?>  
                                    <?=replaceSpecialCharBack($rs["_purchaseorderno"])?>
                                   <?php
													
									}  
									?>   
											   
                                                    </td>
                                                    
                                                    <td  class="<?php echo $Rowcolor; ?>" align="left" >
													
													<?php                       
							if(in_array("Edit",$CustOperations))
							{
								?> <a href="customer.php?id=<?=encrypt($rs["_supplierid"],$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>">
									<?=replaceSpecialCharBack($rs["_companyname"])?>
                                    </a>
                                   <?php
													
									}
									else
									{
									
									?>  
                                    <?=replaceSpecialCharBack($rs["_companyname"])?>
                                   <?php
													
									}  
									?>  
                                                    
                                                    </td>
                                                  
                                                    <td  class="<?php echo $Rowcolor; ?>" align="left" ><?=replaceSpecialCharBack($rs["_address1"])?></td>
                                                       
                                                    <td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack(number_format($rs["_nettotal"],2))?></td>
													
                                                    <td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_subby"])?></td>
                                                    
													<td  class="<?php echo $Rowcolor; ?>" align="center" ><?php echo replaceSpecialCharBack($rs["_subdate"]) ?></td>		
                                                     
                                                     <td  class="<?php echo $Rowcolor; ?>" align="center" ><?php echo replaceSpecialCharBack($rs["_postatus"]) ?></td>		
                                                     
                                                                    													
													<td  class="<?php echo $Rowcolor; ?>" align="center">
                                                    <?php
														$Operations = GetAccessRights(114);
														
														if(in_array("Edit",$Operations))
															{
													?>
                                                    
                                                    <a href="purchaseorder.php?id=<?=encrypt($rs["_ID"],$Encrypt)?>&e_action=<?=encrypt('edit',$Encrypt)?>&pageshowpoint=<?=encrypt($_GET['pageshowpoint'],$Encrypt)?>" class="TitleLink">Edit</a>
                                                    
                                                    <?php
															}
															?>
                                                    
                                                    </td>

												</tr>
												<?php
												$i++;
												}
												
					  }
											} else {
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
		$Operations = GetAccessRights(89);
	if(count($Operations) >  0)
	{
		?>
                  
                   <br />
		<div>
        
        	<table width="99%" class="grid" cellspacing="0" cellpadding="0" id="tblpocreate">
				<tr>
					<td class="gridheader" align="center" colspan="9">
					<b>PO To Create</b>&nbsp;
					</td>
				</tr>
        
        <?php
				
				
				
				
				
					$str1 = "SELECT sq._customerid,qstatus._StatusName as _sqstatus,sq._ID,sq._quotationno,Date_Format(sq._subdate,'%d/%m/%Y') as _subdate,sq._quotationdate, usr._Fullname as _subby,cust._companyname,sq._customerid,cust._memberid as _memberid, _nettotal, sq._quotationremarks,sq._internalremarks,IF(sq._status = 1, 'Live', 'Draft') as Status 
					
					 FROM ".$tbname."_salequotations  sq
					 LEFT JOIN cd_sqstatus qstatus ON sq._sqstatus = qstatus._ID 
					        inner join ".$tbname."_po_tocreate pot ON sq._id = pot._OrderID
							and pot._IsDone = 'N' LEFT JOIN ".$tbname."_customer cust ON sq._customerid = cust._ID 
							LEFT JOIN ".$tbname."_user usr ON sq._subby = usr._ID WHERE sq._status = 1 and sq._sqstatus = 3 ";
							
					
					$str2 = $str1 . " Group By pot._OrderID";
					$result = mysql_query($str2, $connect);
					$RecordCount = mysql_num_rows($result);
					
					
					if($tbl == "pocreate")
					{
				
						if (trim($sortArrange) == "DESC")
									$sortArrange = "ASC";
								elseif (trim($sortArrange) == "ASC")
									$sortArrange = "DESC";
								else
									$sortArrange = "DESC";						
									
						if (trim($sortBy) != "" && trim($sortArrange) != "")
							$str1 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)."";
						else
							$str1 = $str1 . " ORDER BY sq._ID DESC ";
					
					}
					
					$str1 = $str1 . " Group By pot._OrderID";
					 
					if($viewall != "pocreate")
					{
						$str1 .=" limit 0," . $limitCount;
					}
					
					
							
					 $result = mysql_query($str1, $connect);?>
        
		
				<tr>
					<td class="gridheader" width="30" align="center">No.</td>
                                              
                                                
												<td class="gridheader"  align="center"><a href="?sortBy=_quotationno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=pocreate#tblpocreate" class="link1">SQ No</a></td>
                                                
                                                <td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=pocreate#tblpocreate" class="link1" >Customer</a></td>
                                                     
                                                 <td class="gridheader" align="center"><a href="?sortBy=_address&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=pocreate#tblpocreate" class="link1">Description</a></td>
                                                
                                                  <td class="gridheader"  align="center"><a href="?sortBy=_nettotal&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=pocreate#tblpocreate" class="link1">Amount</a></td>   

  <td class="gridheader datecolumn"  align="center"><a href="?sortBy=_subby&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=pocreate#tblpocreate" class="link1">Submitted By</a></td>												  
                                                
                                                   <td class="gridheader datecolumn"  align="center"><a href="?sortBy=_subdate&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=pocreate#tblpocreate" class="link1">Submitted Date</a></td>
                                                   
                                                   <td class="gridheader"  align="center"><a href="?sortBy=_sqstatus&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=pocreate#tblpocreate" class="link1">SQ Status</a></td>                                 
                                                                                       											
												 
                                                   		<td class="gridheader" align="center" style="width:5%">Create</td>
                                                   
				</tr>
				<?php
					 
				      if ($RecordCount > 0) {
											$i = 1;											
											while($rs = mysql_fetch_assoc($result))
											{
												$bil = $i;	
												if  ($Rowcolor == "gridline2")
													$Rowcolor = "gridline1";
												else
													$Rowcolor = "gridline2";
													
												 if ($id == $rs["_ID"]) {
														$Rowcolor = "gridline3";
													}	
												?>
												<tr >
												
													<td  class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
                                                                                                       
													<td  class="<?php echo $Rowcolor; ?>" width="100"  align="center">
                                                    <?php                       
							if(in_array("Edit",$SQOperations))
							{
								?> <a href="salesquotation.php?id=<?=encrypt($rs["_ID"],$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>">
									<?=replaceSpecialCharBack($rs["_quotationno"])?>
                                    </a>
                                   <?php
													
									}
									else
									{
									
									?>  
                                    <?=replaceSpecialCharBack($rs["_quotationno"])?>
                                   <?php
													
									}  
									?>   
                                                    
                                                    </td>
                                                    
                                                    <td  class="<?php echo $Rowcolor; ?>" align="left" >
													
													<?php                       
							if(in_array("Edit",$CustOperations))
							{
								?> <a href="customer.php?id=<?=encrypt($rs["_customerid"],$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>">
									<?=replaceSpecialCharBack($rs["_companyname"])?>
                                    </a>
                                   <?php
													
									}
									else
									{
									
									?>  
                                    <?=replaceSpecialCharBack($rs["_companyname"])?>
                                   <?php
													
									}  
									?>   
                                                    
                                                    </td>
                                                  
                                                    <td  class="<?php echo $Rowcolor; ?>" align="left" ><?=replaceSpecialCharBack($rs["_address"])?></td>
                                                       
                                                    <td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack(number_format($rs["_nettotal"],2))?></td>
													
                                                    <td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_subby"])?></td>
                                                    
													<td  class="<?php echo $Rowcolor; ?>" align="center" ><?php echo replaceSpecialCharBack($rs["_subdate"]) ?></td>		
                                                    
                                                    <td  class="<?php echo $Rowcolor; ?>" align="center" ><?php echo replaceSpecialCharBack($rs["_sqstatus"]) ?></td>		
                                                                                                                           													
													<td  class="<?php echo $Rowcolor; ?>" align="center">
                                                       <?php
														$Operations = GetAccessRights(114);
														
														if(in_array("Add",$Operations))
															{
													?>
                                                    
                                                    
                                                    <a href="purchaseorder.php?sqid=<?=encrypt($rs["_ID"],$Encrypt)?>&pageshowpoint=<?=encrypt($_GET['pageshowpoint'],$Encrypt)?>" class="TitleLink">Create </a>
                                                    
                                                    <?php
															}
															?>
                                                    
                                                    </td>

												</tr>
												<?php
												$i++;
												}
											} else {
												echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											
				
											?>
                                            
                                            
                                            
										</table>
			</div>
            
              <? if($RecordCount > $limitCount ){ ?>
             
             <div align="right">
            <input type="button" class="button1" name="btnicVewAll" value="View All" onclick="window.location='?viewall=pocreate'" style="width:100px;" />
			&nbsp;&nbsp;&nbsp;</div>
			
			<? }
           
          
	}
	?>
    
    <?php
	
	$RecordCount = 0;
	
		$Operations = GetAccessRights(76);
	if(count($Operations) >  0)
	{
		?>
           
           
              <br />
		<div>
        
        <table width="99%" class="grid" cellspacing="0" cellpadding="0" id="tblitempick">
				<tr>
					<td class="gridheader" align="center" colspan="10">
					<b>Items To Pick</b>
					</td>
				</tr>
        
        <?php
				
				
				
				
				
					$str1 = "SELECT sum(pot._Qty) as _Qty,
					(Select _Title From  ".$tbname."_salequotationitems Where _QutotationId = sq._ID) as _description,
					sq._customerid,qstatus._StatusName as _sqstatus,sq._ID,sq._quotationno,Date_Format(sq._subdate,'%d/%m/%Y') as _subdate,sq._quotationdate, usr._Fullname as _subby,cust._companyname,sq._customerid,cust._memberid as _memberid, _nettotal, sq._quotationremarks,sq._internalremarks,IF(sq._status = 1, 'Live', 'Draft') as Status  
					FROM ".$tbname."_salequotations  sq
					LEFT JOIN cd_sqstatus qstatus ON sq._sqstatus = qstatus._ID 
					        inner join ".$tbname."_topick pot ON sq._id = pot._QuotationID
							and pot._IsDone = 'N' 
							LEFT JOIN ".$tbname."_customer cust ON sq._customerid = cust._ID 
							LEFT JOIN ".$tbname."_user usr ON sq._subby = usr._ID WHERE sq._status = 1 and sq._sqstatus = 3 ";
							
					
					echo $str1 .=  " Group By  sq._ID ";
					
					 $result = mysql_query($str1, $connect);
					 $RecordCount = mysql_num_rows($result);
					
					
					
						
						if($tbl == "itempick")
					{
				
						if (trim($sortArrange) == "DESC")
									$sortArrange = "ASC";
								elseif (trim($sortArrange) == "ASC")
									$sortArrange = "DESC";
								else
									$sortArrange = "DESC";						
									
						if (trim($sortBy) != "" && trim($sortArrange) != "")
							$str1 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)."";
						else
							$str1 = $str1 . " ORDER BY sq._ID DESC ";
					
					}
					
					
						
							
					 if($viewall != "itempick")
					{
						$str1 .=" limit 0," . $limitCount;
					}
							
					 $result = mysql_query($str1, $connect);?>
        
			
				<tr>
					<td class="gridheader" width="30" align="center">No.</td>
                                              
                                                
												<td class="gridheader"  align="center"><a href="?sortBy=_quotationno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=itempick#tblitempick" class="link1">SQ No</a></td>
                                                
                                                <td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=itempick#tblitempick" class="link1" >Customer</a></td>
                                                
                                                         
                                                 <td class="gridheader" align="center"><a href="?sortBy=_address&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=itempick#tblitempick" class="link1">Description</a></td>
                                                
                                                <td class="gridheader"  align="center"><a href="?sortBy=_Qty&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=itempick#tblitempick" class="link1">Total Qty</a></td>                                 
                                                
                                                
                                                  <td class="gridheader"  align="center"><a href="?sortBy=_nettotal&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=itempick#tblitempick" class="link1">Amount</a></td>                                 
                                                
                                                  <td class="gridheader datecolumn"  align="center"><a href="?sortBy=_subby&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=itempick#tblitempick" class="link1">Submitted By</a></td>
                                                
                                                   <td class="gridheader datecolumn"  align="center"><a href="?sortBy=_subdate&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=itempick#tblitempick" class="link1">Submitted Date</a></td>
                                                                                          											
												 
                                                  <td class="gridheader"  align="center"><a href="?sortBy=_sqstatus&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=itempick#tblitempick" class="link1">SQ Status</a></td>
                                                        
                                                 
                                                   		<td class="gridheader" align="center" style="width:5%">Pick</td>
                                                   
				</tr>
				<?php
 
							
				      if ($RecordCount > 0) {
											$i = 1;											
											while($rs = mysql_fetch_assoc($result))
											{
												$bil = $i;	
												if  ($Rowcolor == "gridline2")
													$Rowcolor = "gridline1";
												else
													$Rowcolor = "gridline2";
													
												 if ($id == $rs["_ID"]) {
														$Rowcolor = "gridline3";
													}	
												?>
												<tr >
												
													<td  class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
                                                                                                       
													<td  class="<?php echo $Rowcolor; ?>" width="100"  align="center">
													
													<?php                       
							if(in_array("Edit",$SQOperations))
							{
								?> <a href="salesquotation.php?id=<?=encrypt($rs["_ID"],$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>">
									<?=replaceSpecialCharBack($rs["_quotationno"])?>
                                    </a>
                                   <?php
													
									}
									else
									{
									
									?>  
                                    <?=replaceSpecialCharBack($rs["_quotationno"])?>
                                   <?php
													
									}  
									?>  
                                                    
                                                    
                                                    </td>
                                                    
                                                    <td  class="<?php echo $Rowcolor; ?>" align="left" >
													
													
													<?php                       
							if(in_array("Edit",$CustOperations))
							{
								?> <a href="customer.php?id=<?=encrypt($rs["_customerid"],$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>">
									<?=replaceSpecialCharBack($rs["_companyname"])?>
                                    </a>
                                   <?php
													
									}
									else
									{
									
									?>  
                                    <?=replaceSpecialCharBack($rs["_companyname"])?>
                                   <?php
													
									}  
									?>  
                                                    
                                                    
                                                    
                                                    </td>
                                                  
                                                    <td  class="<?php echo $Rowcolor; ?>" align="left" ><?=replaceSpecialCharBack($rs["_description"])?></td>
                                                       
                                                       <td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_Qty"])?></td>
                                                       
                                                    <td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack(number_format($rs["_nettotal"],2))?></td>
													
													<td  class="<?php echo $Rowcolor; ?>" align="center" ><?php echo replaceSpecialCharBack($rs["_subby"]) ?></td>	
													
                                                    <td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_subdate"])?></td>
                                                    
                                                     <td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_sqstatus"])?></td>
                                                    
														
                                                                    													
													<td  class="<?php echo $Rowcolor; ?>" align="center">
                                                       <?php
														$Operations = GetAccessRights(76);
														
														if(count($Operations) > 0)
															{
													?>
                                                    
                                                    <a href="pickitem.php?sqid=<?=encrypt($rs["_ID"],$Encrypt)?>" class="TitleLink">Pick </a>
                                                    
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
                                            
                                            
                                            
										</table>
			</div>
           
             <? if($RecordCount > $limitCount ){ ?>
             
             <div align="right">
            <input type="button" class="button1" name="btnicVewAll" value="View All" onclick="window.location='?viewall=itempick'" style="width:100px;" />
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
        
        	<table width="99%" class="grid" cellspacing="0" cellpadding="0" id="tbldocreate">
				<tr>
					<td class="gridheader" align="center" colspan="9">
					<b>DO To Create</b>
					</td>
				</tr>
        
        <?php
				
				
				
				
				
					$str1 = "SELECT sq._ID,qstatus._StatusName as _sqstatus,sq._quotationno,Date_Format(sq._subdate,'%d/%m/%Y') as _subdate,sq._quotationdate, usr._Fullname as _subby,cust._companyname,sq._customerid,cust._memberid as _memberid, _nettotal, sq._quotationremarks,sq._internalremarks,IF(sq._status = 1, 'Live', 'Draft') as Status  
					
					FROM ".$tbname."_salequotations  sq
					LEFT JOIN cd_sqstatus qstatus ON sq._sqstatus = qstatus._ID 
					        inner join ".$tbname."_do_tocreate pot ON sq._id = pot._QuotationID
							and pot._IsDone = 'N' LEFT JOIN ".$tbname."_customer cust ON sq._customerid = cust._ID 
							LEFT JOIN ".$tbname."_user usr ON sq._subby = usr._ID WHERE sq._status = 1 and sq._sqstatus = 3 
							Group By pot._QuotationID
							
							";
					
					
					
						$result = mysql_query($str1, $connect);
						 $RecordCount = mysql_num_rows($result);	
						 
						 
						 if($tbl == "docreate")
					{
				
						if (trim($sortArrange) == "DESC")
									$sortArrange = "ASC";
								elseif (trim($sortArrange) == "ASC")
									$sortArrange = "DESC";
								else
									$sortArrange = "DESC";						
									
						if (trim($sortBy) != "" && trim($sortArrange) != "")
							$str1 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)."";
						else
							$str1 = $str1 . " ORDER BY sq._ID DESC ";
					
					}	
						
							if($viewall != "docreate")
					{
						$str1 .=" limit 0," . $limitCount;
					}
							
					 $result = mysql_query($str1, $connect); ?>
		
				<tr>
					<td class="gridheader" width="30" align="center">No.</td>
                                              
                                                
												<td class="gridheader"  align="center"><a href="?sortBy=_quotationno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=docreate#tbldocreate" class="link1">SQ No</a></td>
                                                
                                                <td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=docreate#tbldocreate" class="link1" >Customer</a></td>
                                                
                                                         
                                                 <td class="gridheader" align="center"><a href="?sortBy=_address&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=docreate#tbldocreate" class="link1">Description</a></td>
                                                
                                                  <td class="gridheader"  align="center"><a href="?sortBy=_nettotal&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=docreate#tbldocreate" class="link1">Amount</a></td>  

   <td class="gridheader datecolumn"  align="center"><a href="?sortBy=_subby&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=docreate#tbldocreate" class="link1">Submitted By</a></td>												  
                                                
                                                   <td class="gridheader datecolumn"  align="center"><a href="?sortBy=_subdate&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=docreate#tbldocreate" class="link1">Submitted Date</a></td>
                                                      
                                                       <td class="gridheader"  align="center"><a href="?sortBy=_sqstatus&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=docreate#tbldocreate" class="link1">SQ Status</a></td>  
                                     											
												
                                                   		<td class="gridheader" align="center" style="width:5%">Create</td>
                                                   
				</tr>
				<?php
			 
							
				      if ($RecordCount > 0) {
											$i = 1;											
											while($rs = mysql_fetch_assoc($result))
											{
												$bil = $i;	
												if  ($Rowcolor == "gridline2")
													$Rowcolor = "gridline1";
												else
													$Rowcolor = "gridline2";
													
												 if ($id == $rs["_ID"]) {
														$Rowcolor = "gridline3";
													}	
												?>
												<tr >
												
													<td  class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
                                                                                                       
													<td  class="<?php echo $Rowcolor; ?>" width="100"  align="center">
													
													
													<?php                       
							if(in_array("Edit",$SQOperations))
							{
								?> <a href="salesquotation.php?id=<?=encrypt($rs["_ID"],$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>">
									<?=replaceSpecialCharBack($rs["_quotationno"])?>
                                    </a>
                                   <?php
													
									}
									else
									{
									
									?>  
                                    <?=replaceSpecialCharBack($rs["_quotationno"])?>
                                   <?php
													
									}  
									?>   
                                                    
                                                    
                                                    </td>
                                                    
                                                    <td  class="<?php echo $Rowcolor; ?>" align="left" >
													
													<?php                       
							if(in_array("Edit",$CustOperations))
							{
								?> <a href="customer.php?id=<?=encrypt($rs["_customerid"],$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>">
									<?=replaceSpecialCharBack($rs["_companyname"])?>
                                    </a>
                                   <?php
													
									}
									else
									{
									
									?>  
                                    <?=replaceSpecialCharBack($rs["_companyname"])?>
                                   <?php
													
									}  
									?>  
                                                    
                                                    
                                                    </td>
                                                  
                                                    <td  class="<?php echo $Rowcolor; ?>" align="left" ><?=replaceSpecialCharBack($rs["_address"])?></td>
                                                       
                                                    <td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack(number_format($rs["_nettotal"],2))?></td>
													
                                                   
                                                    
													<td  class="<?php echo $Rowcolor; ?>" align="center" ><?php echo replaceSpecialCharBack($rs["_subby"]) ?></td>	




 <td  class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_subdate"])?></td>													
        
        <td  class="<?php echo $Rowcolor; ?>" align="center" ><?php echo replaceSpecialCharBack($rs["_sqstatus"]) ?></td>	

                                                                    													
													<td  class="<?php echo $Rowcolor; ?>" align="center">
                                                       <?php
														$Operations = GetAccessRights(111);
														
														if(in_array("Add",$Operations))
															{
													?>
                                                    
                                                    <a href="deliveryorder.php?sqid=<?=encrypt($rs["_ID"],$Encrypt)?>" class="TitleLink">Create </a>
                                                    
                                                    <?php
															}
															?>
                                                    
                                                    </td>

												</tr>
												<?php
												$i++;
												}
											} else {
												echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											
				
											?>
                                            
                                            
                                            
										</table>
			</div>
           
            <? if($RecordCount > $limitCount ){ ?>
             
             <div align="right">
            <input type="button" class="button1" name="btnicVewAll" value="View All" onclick="window.location='?viewall=docreate'" style="width:100px;" />
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
        
        <?php
				
				   $str = "SELECT 
					if(isnull(sq._customerid),do._customerid,sq._customerid) as _customerid,
					if(isnull(do._ID),'',do._ID) as _DoID,
					if(isnull(sq._ID),'',sq._ID) as _SqID,
					qstatus._StatusName as _sqstatus,
					dstatus._StatusName as _dostatus,
					 do._deliveryorderno,sq._quotationno,
					if(isnull(sq._subdate),Date_Format(do._createddate,'%d/%m/%Y'),Date_Format(sq._subdate,'%d/%m/%Y')) as _subdate,
					if(isnull(usr2._Fullname),usr1._Fullname,usr2._Fullname) as _subby,
					if(isnull(cust2._companyname),cust1._companyname,cust2._companyname) as _companyname,
					if(isnull(sq._nettotal),do._nettotal,sq._nettotal) as _nettotal
					
					 FROM ".$tbname."_invoice_tocreate pot
					 
					  
					 left join ".$tbname."_deliveryorders  do
					 LEFT JOIN cd_dostatus dstatus ON do._dostatus = dstatus._ID 
					 ON pot._OrderID = do._id and pot._IsDone = 'N' and do._status = 1
					 
					 LEFT JOIN ".$tbname."_customer cust1 
					  ON do._customerid = cust1._ID 
					 LEFT JOIN ".$tbname."_user usr1 
					 ON do._createdby = usr1._ID 
					 
					 
					 left join ".$tbname."_salequotations  sq
					 ON sq._id = pot._SQID and pot._IsDone = 'N' and sq._status = 1
					 LEFT JOIN cd_sqstatus qstatus ON sq._sqstatus = qstatus._ID 
					 LEFT JOIN ".$tbname."_customer cust2 
					 ON sq._customerid = cust2._ID 
					 LEFT JOIN ".$tbname."_user usr2 
					 ON sq._subby = usr2._ID
					 
					 WHERE pot._IsDone = 'N' ";
					 
					 $result = mysql_query($str, $connect);
					 $RecordCount = mysql_num_rows($result);
					 
					 
					 if($tbl == "invcreate")
					{
				
						if (trim($sortArrange) == "DESC")
									$sortArrange = "ASC";
								elseif (trim($sortArrange) == "ASC")
									$sortArrange = "DESC";
								else
									$sortArrange = "DESC";						
									
						if (trim($sortBy) != "" && trim($sortArrange) != "")
							$str1 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)."";
						else
							$str1 = $str1 . " ORDER BY sq._ID DESC ";
					
					}	
					 
					 	if($viewall != "invcreate")
					{
						$str .=" limit 0," . $limitCount;
					}
						
					$result = mysql_query($str, $connect);?>
        
        
         <form action="invoice_action.php" method="get" name="FormName" id="FormName" onsubmit="return validateForm();">
              <input type="hidden" name="e_action" id="myEaction" value="dotoinvoice" />
                
        
			<table width="99%" class="grid" cellspacing="0" cellpadding="0" id="tblinvcreate">
				<tr>
					<td class="gridheader" align="center" colspan="11">
					<b>Invoice To Create</b>
					</td>
				</tr>
				<tr>
                
                 <td class="gridheader" width="30" align="center">&nbsp;</td>
                       
					<td class="gridheader" width="30" align="center">No.</td>
                                              
                                                
												<td class="gridheader"  align="center"><a href="?sortBy=_quotationno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=invcreate#tblinvcreate" class="link1">SQ No</a></td>
                                                
                                                <td class="gridheader"  align="center"><a href="?sortBy=_deliveryorderno&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=invcreate#tblinvcreate" class="link1">DO No</a></td>
                                                                                              
                                                
                                                <td class="gridheader"  align="center"><a href="?sortBy=_companyname&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=invcreate#tblinvcreate" class="link1" >Customer</a></td>
                                                
                                                         
                                                
                                                  <td class="gridheader"  align="center"><a href="?sortBy=_nettotal&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=invcreate#tblinvcreate" class="link1">Amount</a></td>                                 
                                                   <td class="gridheader datecolumn"  align="center"><a href="?sortBy=_subby&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=invcreate#tblinvcreate" class="link1">Submitted By</a></td>
												
												
                                                   <td class="gridheader datecolumn"  align="center"><a href="?sortBy=_subdate&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=invcreate#tblinvcreate" class="link1">Submitted Date</a></td>
                                                                                          											
												<td class="gridheader"  align="center"><a href="?sortBy=_sqstatus&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=invcreate#tblinvcreate" class="link1">SQ Status</a></td>                                 
                                                  
                                                  <td class="gridheader"  align="center"><a href="?sortBy=_dostatus&sortArrange=<?=$sortArrange?><?=$extraURL?>&tbl=invcreate#tblinvcreate" class="link1">DO Status</a></td>                                 
                                                  
                                                   
                                                   		<td class="gridheader" align="center" style="width:5%">Create</td>
                                                   
				</tr>
				<?php
					
				    if ($RecordCount > 0) {
											$i = 1;											
											while($rs = mysql_fetch_assoc($result))
											{
												$bil = $i;	
												if  ($Rowcolor == "gridline2")
													$Rowcolor = "gridline1";
												else
													$Rowcolor = "gridline2";
												
												?>
												<tr >
												
                                                
                                                <td id="Row1ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="30" align="center">
                                                
                                                
                                                <?php
												if($rs["_SqID"] == "")
												{
													?>
                                                <input name="orderids[]" type="checkbox"   tabindex="" class="orderID" value="<?php echo $rs["_DoID"]; ?>" onclick="setActivities(this, <?php echo $i; ?>,'<?=$Rowcolor?>',11);" />
                                                
                                                <?php
													}
													else
													{	
												?>
                                                <input name="sqids[]" type="checkbox"   tabindex="" class="orderID" value="<?php echo $rs["_SqID"]; ?>" onclick="setActivities(this, <?php echo $i; ?>,'<?=$Rowcolor?>',11);" />
                                                
                                                <?php
													}
													
													?>
                                                
                                                </td>
                          
                                                
													<td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
                                                                                                       
													
                                                    <td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="100"  align="center">
													
													
                                                    <?php                       
							if(in_array("Edit",$SQOperations))
							{
								?> <a href="salesquotation.php?id=<?=encrypt($rs["_SqID"],$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>" target="_blank">
									<?=replaceSpecialCharBack($rs["_quotationno"])?>
                                    </a>
                                   <?php
													
									}
									else
									{
									
									?> 
                                    
                                    <?=replaceSpecialCharBack($rs["_quotationno"])?>
                                    
                                    <?php
									}
									?>
                                 
                                                    
                                                    </td>
                                                    
                                                    
                                                    <td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="100"  align="center">
													
													
                                                    <?php                       
							if(in_array("Edit",$DOOperations))
							{
								?> <a href="deliveryorder.php?id=<?=encrypt($rs["_DoID"],$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>">
									<?=replaceSpecialCharBack($rs["_deliveryorderno"])?>
                                    </a>
                                   <?php
													
									}
									else
									{
									
									?> 
                                    
                                    <?=replaceSpecialCharBack($rs["_deliveryorderno"])?>
                                    
                                    <?php
									}
									?>
                                 
                                                    
                                                    </td>
                                                    
                                                    <td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" >
													
													<?php                       
							if(in_array("Edit",$CustOperations))
							{
								?> <a href="customer.php?id=<?=encrypt($rs["_customerid"],$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>">
									<?=replaceSpecialCharBack($rs["_companyname"])?>
                                    </a>
                                   <?php
													
									}
									else
									{
									
									?>  
                                    <?=replaceSpecialCharBack($rs["_companyname"])?>
                                   <?php
													
									}  
									?>  
                                    
                                    </td>
                                                  
                                                    
                                                    <td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack(number_format($rs["_nettotal"],2))?></td>
													
                                                    <td id="Row7ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_subby"])?></td>
                                                    
													<td id="Row8ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?php echo replaceSpecialCharBack($rs["_subdate"]) ?></td>		
                                                      
                                                      <td id="Row9ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?php echo replaceSpecialCharBack($rs["_sqstatus"]) ?></td>		
                                                      
                                                        <td id="Row10ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?php echo replaceSpecialCharBack($rs["_dostatus"]) ?></td>		
                                                                  													
													<td id="Row11ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">
                                                       <?php
														$Operations = GetAccessRights(90);
														
														if(in_array("Add",$Operations))
															{
													?>
                                                    
                                                    <a href="invoice.php?orderid=<?=encrypt($rs["_DoID"],$Encrypt)?>&sqid=<?=encrypt($rs["_SqID"],$Encrypt)?>" class="TitleLink">Create </a>
                                                    
                                                    <?php
															}
															?>
                                                    
                                                    </td>

												</tr>
												<?php
												$i++;
												}
											} else {
												echo "<tr><td colspan='11' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											
				
											?>
                                            
                                            
                                            
										</table>
                                        
<input name="totalItems" id="totalItems"  type="hidden" value="<?=$i?>" />
             
                                        </form>
			</div>
            
                 
           
                   <? if($RecordCount > $limitCount ){ ?>
             
             <div align="right">
            <input type="button" class="button1" name="btnicVewAll" value="View All" onclick="window.location='?viewall=invcreate'" style="width:100px;" />
			&nbsp;&nbsp;&nbsp;</div>
			
			<? }
          
			?>
        
        
        
        
	<?php
	}
	?>
               
    
           <?php

		$RecordCount = 0;
	 
	$Operations = GetAccessRights(339);
	if(count($Operations) >  0)
	{
		?>
           
           
           <br/> 
     
		<!--<div>
        
        <?php
				 $showStr = "P._Description,P._ID as pID,P._ProductCode,PCAT._CategoryName,PSUBCAT._SubCategoryName,PBRAND._BrandName,P._ProductName,P._Model,_TotalQty as _TotalQty ";				 
				 
				 
				 $joinStr = ''.$tbname.'_categories as PCAT on P._CategoryID = PCAT._ID
				  left join '.$tbname.'_subcategories as PSUBCAT on P._SubCategoryID = PSUBCAT._ID 
				  left join '.$tbname.'_brand as PBRAND on P._BrandID= PBRAND._ID 
				  inner join '.$tbname.'_systemstatus as SS on P._status= SS._ID ';
									
				    $str = " Select ". $showStr ." 
				   From ". $tbname . "_products P 
				   left join ". $joinStr . "  Where P._type = 1
				   and ( P._TotalQty <= ( Select _AlertQty From 
				    ".$tbname."_invalert limit 1) or P._TotalQty is null)";
			 
					$str .= " Group By P._ID Order By P._ProductCode" ; 
					
					
					 $result = mysql_query($str, $connect);
					$RecordCount = mysql_num_rows($result);
					
					
					if($tbl == "invalert")
					{				
						if (trim($sortArrange) == "DESC")
									$sortArrange = "ASC";
								elseif (trim($sortArrange) == "ASC")
									$sortArrange = "DESC";
								else
									$sortArrange = "DESC";						
									
						if (trim($sortBy) != "" && trim($sortArrange) != "")
							$str1 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)."";
						else
							$str1 = $str1 . " ORDER BY sq._ID DESC ";
					
					}	
					
				   	if($viewall != "invalert")
					{
						$str .= " limit 0," . $limitCount;
					}
				
				   
				   $result = mysql_query($str, $connect);
				   ?>
			<table width="99%" class="grid" cellspacing="0" cellpadding="0">
				<tr>
					<td class="gridheader" align="center" colspan="8">
					<b>Low Inventory Alert</b>
					</td>
				</tr>
				<tr>
					<td class="gridheader" width="30" align="center">No.</td>
                                           
										   <td class="gridheader"  align="center">
                <a href="?PageNo=<?=$PageNo?>&sortBy=_ProductCode<?=$ExtraUrl?>&tbl=invalert" class="link1">
                Prod Code</a></td>
												
										   <td class="gridheader" align="center">
                  <a href="?PageNo=<?=$PageNo?>&sortBy=_ProductName<?=$ExtraUrl?>&tbl=invalert" class="link1">Description</a></td>
												
												 <td class="gridheader">
                <a href="?PageNo=<?=$PageNo?>&sortBy=_Model<?=$ExtraUrl?>&tbl=invalert" class="link1">Model</a></td>
                                           
                                                                                    
                                            <td class="gridheader">
                 <a href="?PageNo=<?=$PageNo?>&sortBy=_BrandName<?=$ExtraUrl?>&tbl=invalert" class="link1">Brand</a></td>
                                            
                                           
                                            
                                             <td class="gridheader"  align="right">
                <a href="?PageNo=<?=$PageNo?>&sortBy=_TotalQty<?=$ExtraUrl?>&tbl=invalert" class="link1">Total Qty</a>
                                            </td>
                  <td class="gridheader" align="center" style="width:5%">Create</td>
                                                   
				</tr>
				<?php
				
			      if ($RecordCount > 0) {
											$i = 1;											
											while($rs = mysql_fetch_assoc($result))
											{
												
													$Rowcolor = "gridline1";
												
												?>
												<tr >
												<td id="Row1ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $i; ?>&nbsp;</td>
                                                <td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="100"  align="center">
                                                <a href="productsummary.php?bid=0&itemid=<?=$rs["pID"]?>" class="TitleLink"><?=$rs["_ProductCode"]?></a></td>
                                                <td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" ><?=$rs["_Description"]?></td>
                                              
                                                <td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" ><?=$rs["_Model"]?></td>
                                             <td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" ><?=$rs["_BrandName"]?></td> 
                                                
                                                 <td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="right" ><?=$rs["_TotalQty"]==""?0.00:$rs["_TotalQty"]?></td> 
                                                                													
													<td  class="<?php echo $Rowcolor; ?>" align="center">
                                                      
                                                        <?php
														$Operations = GetAccessRights(114);
														
														if(in_array("Add",$Operations))
															{
													?>
                                                    
                                                    
                                                    <a href="purchaseorder.php?itemid=<?=encrypt($rs["pID"],$Encrypt)?>&pageshowpoint=<?=encrypt($_GET['pageshowpoint'],$Encrypt)?>" class="TitleLink">Create </a>
                                                    
                                                    <?php
															}
															?>
                                                      
                                                    
                                                    </td>

												</tr>
												<?php
												$i++;
												}
											} else {
												echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
											}
											
				
											?>
                                            
                                            
                                            
										</table>
			</div>-->
           
           <? if($RecordCount > $limitCount ){ ?>
             
             <div align="right">
            <input type="button" class="button1" name="btnicVewAll" value="View All" onclick="window.location='?viewall=invalert'" style="width:100px;" />
			&nbsp;&nbsp;&nbsp;</div>
			
			<? }
	}
	?>   
                  
    
		<br />
        
        
         <?php

		$RecordCount = 0;
	 
		$Operations = GetAccessRights(12);
	if(count($Operations) >  0)
	{
		?>
           
           
           <br/> 
     
		<div>
        
        <?php
					$str = "SELECT app._ID,date_format(app._SubmittedDate,'%d/%m/%Y') as _SubmittedDate,_Title,IF(app._status = 1, 'Live', 'Archived') as _status,usr._Fullname,stff._Fullname as _StaffRef,Concat(date_format(app._Date,'%d/%m/%Y'),'( ',_From,' - ',_To,' )') as _AppDate FROM ".$tbname."_appointments app
							left join ".$tbname."_user stff on app._StaffRef=stff._ID
							left Join ".$tbname."_user AS usr ON app._SubmittedBy = usr._ID
							WHERE app._StaffRef = '". $_SESSION["userid"] ."'
							 and app._Date = '". date("Y-m-d") ."' " ;
							
					
					
					 $result = mysql_query($str, $connect);
					$RecordCount = mysql_num_rows($result);
					
					
					if($tbl == "myapp")
					{				
						if (trim($sortArrange) == "DESC")
									$sortArrange = "ASC";
								elseif (trim($sortArrange) == "ASC")
									$sortArrange = "DESC";
								else
									$sortArrange = "DESC";						
									
						if (trim($sortBy) != "" && trim($sortArrange) != "")
							$str1 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)."";
						else
							$str1 = $str1 . " ORDER BY app._ID DESC ";
					
					}	
					
				   	if($viewall != "myapp")
					{
						$str .= " limit 0," . $limitCount;
					}
				
				   
				   $result = mysql_query($str, $connect);
				   ?>
			<table cellspacing="0" cellpadding="3" width="100%" border="0" class="grid" >
                                   
                                   
                                   
                                   <tr>
					<td class="gridheader" align="center" colspan="8">
					<b>My Appointment Today</b>
					</td>
				</tr>
                                   
                                    <tr>
                                   <td class="gridheader" width="30" align="center">No.</td>
                                    <td class="gridheader" width="200" align="center">Date/Time</td>
                                    <td class="gridheader" align="center"><a href="?PageNo=<?=$PageNo?>&amp;sortBy=_Title<?=$ExtraUrl?>" class="link1">Event Title</a></td>
                                    <td class="gridheader"  align="center"><a href="?PageNo=<?=$PageNo?>&amp;sortBy=_StaffRef<?=$ExtraUrl?>" class="link1">Staff Ref</a></td>
									<td class="gridheader datecolumn"  align="center"><a href="?PageNo=<?=$PageNo?>&amp;sortBy=_Fullname<?=$ExtraUrl?>" class="link1">Submitted By</a></td>
                                    <td class="gridheader datecolumn"  align="center"><a href="?PageNo=<?=$PageNo?>&amp;sortBy=_SubmittedDate<?=$ExtraUrl?>" class="link1">Submitted Date</a></td>
                                    
                                    <td class="gridheader"  align="center"><a href="?PageNo=<?=$PageNo?>&amp;sortBy=_status<?=$ExtraUrl?>" class="link1">System Status</a></td>
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
                                    <tr  class="clickableRow" href="appointment.php?PageNo=<?=$PageNo?>&amp;id=<?=encrypt($rs["_ID"],$Encrypt)?>&amp;e_action=<?=encrypt('edit',$Encrypt)?>&amp;pageshowpoint=<?=$_GET['pageshowpoint']?>" style="cursor:pointer">
                                    <td id="Row1ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $i; ?>&nbsp;</td>
                                    <td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="100"  align="center"><?=replaceSpecialCharBack($rs["_AppDate"])?></td>
                                    <td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left"><?=$rs['_Title']?></td>
                                    <td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" ><?php echo replaceSpecialCharBack($rs["_StaffRef"]) ?></td>
                                   
                                                                       <td id="Row7ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_Fullname"])?></td>
                                    <td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?=replaceSpecialCharBack($rs["_SubmittedDate"])?></td>

                                    <td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" ><?=replaceSpecialCharBack($rs["_status"])?></td>
                                    <td id="Row7ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;
                           
                            
                               
                                    
                                    <a href="appointment.php?PageNo=<?=$PageNo?>&amp;id=<?=encrypt($rs["_ID"],$Encrypt)?>&amp;e_action=<?=encrypt('edit',$Encrypt)?>&amp;pageshowpoint=<?=$_GET['pageshowpoint']?>" class="TitleLink">Edit</a>
                                    
                                     
                                    </td>
                                    
                                  </tr>
                                    <?php
												$i++;
												}
											} else {
												echo "<tr><td colspan='8' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
														}
											?>
                                  </table>
			</div>
           
           <? if($RecordCount > $limitCount ){ ?>
             
             <div align="right">
            <input type="button" class="button1" name="btnmyappVewAll" value="View All" onclick="window.location='?viewall=myapp'" style="width:100px;" />
			&nbsp;&nbsp;&nbsp;</div>
			
			<? }
	}
	?>   
                  
    
		<br />
        
		<div>
			<table width="99%" class="grid" cellspacing="0" cellpadding="0">
				<tr>
					<td class="gridheader" align="center" colspan="4">
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
              
              
              
              
              
            </table>
            
		</td>
	</tr>			
	</table>
		
	</td>
</tr>
</table>
</body>
</html>
<?php		
include('../dbclose.php');
?>