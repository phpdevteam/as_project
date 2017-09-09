<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
		exit();
    }
	include('../global.php');	
	include('../include/functions.php');include('access_rights_function.php'); 
	include("fckeditor/fckeditor.php");

    $Operations = GetAccessRights(61);
	if(count($Operations)== 0)
	{
		echo "<script language='javascript'>history.back();</script>";
	}	
	
	 $SQOperations = GetAccessRights(71);
		
	$currentmenu = "Customer";

	$btnSubmit = "Submit";
	
	foreach($_GET as $k=>$v)
	{
	   $_GET[$k] = decrypt($v,$Encrypt);
	}
 	foreach($_REQUEST as $k=>$v)
	{
	   $_REQUEST[$k] = decrypt($v,$Encrypt);
	}
	foreach($_POST as $k=>$v)
	{
	   $_POST[$k] = decrypt($v,$Encrypt);
	}
	
	 $id = $_GET['id'];
	 $customerno = $_GET['customerno'];
	 $companyname = $_GET['companyname'];
	 $e_action = $_GET['e_action'];
	 $ctab = $_GET['ctab'];
	 $type = $_REQUEST['type'];
	 //$memberid = $_REQUEST["memberid"]; 
	// var_dump($_REQUEST);
	 
	if($ctab=="")
	{
		$ctab = 0;
	}
	
	$customertype = array();
	
	if($id != "" && $e_action == 'edit' && $ctab == '0')
	{
		
		$str = "SELECT *,date_format(_createddate,'%d/%m/%Y %h:%i:%s %p') as _submitteddate FROM ".$tbname."_client WHERE _id = '".$id."' ";
		$rst = mysql_query("set names 'utf8';");	
		
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			
			$contacttitle = replaceSpecialCharBack($rs["_contacttitle"]);
			$clientname = replaceSpecialCharBack($rs["_fullname"]);
			$nricfin = replaceSpecialCharBack($rs["_nricfin"]);
			$nsmen = replaceSpecialCharBack($rs["_nsmen"]);
			$customerno = $rs["_customerid"];
			$address1 = replaceSpecialCharBack($rs["_address1"]);
			$address2 = replaceSpecialCharBack($rs["_address2"]);
			$address3 = replaceSpecialCharBack($rs["_address3"]);
			$telephone1 = replaceSpecialCharBack($rs["_hp"]);
			$telephone2 = replaceSpecialCharBack($rs["_hp2"]);
			$dob = mysqlToDatepicker($rs["_dob"]);
			$height = replaceSpecialCharBack($rs["_height"]);
			$weight = replaceSpecialCharBack($rs["_weight"]);
			$medhistory = replaceSpecialCharBack($rs["_medhistory"]);
			$iptprog = replaceSpecialCharBack($rs["_iptprog"]);
            $creditava = replaceSpecialCharBack($rs["_creditava"]);
            $unusedamount = replaceSpecialCharBack($rs["_TotalUnUsedAmount"]);
			$workrecprofile = replaceSpecialCharBack($rs["_workrecprofile"]);
			$phyactiprofile = replaceSpecialCharBack($rs["_phyactiprofile"]);
			$status = $rs["_status"];
			$postalcode = replaceSpecialCharBack($rs["_postalcode"]);
			$email = replaceSpecialCharBack($rs["_email"]);
			$cityid = $rs["_cityid"];
			$countryid = $rs["_countryid"];
			$remarks = replaceSpecialCharBack($rs["_remarks"]);
			$internalremarks = replaceSpecialCharBack($rs["_internalremarks"]);
			$btnSubmit = "Update";
		}
	}else
	{
	
		$customertype = array($_REQUEST['type']);
		
	}

	if($customerno == "")
	{
		 
		 $customerno = generateCustomerNo();
	}
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $gbtitlename; ?></title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
	<script type="text/javascript" src="../js/validate.js"></script>
    <link rel="stylesheet" href="../jquery/autocomplete/docsupport/prism.css">
  <link rel="stylesheet" href="../jquery/autocomplete/chosen.css" />
    <? include('jquerybasiclinks10_3.php'); ?>
       
    <script type="text/javascript" src="../js/functions.js"></script>
     <script type="text/javascript" src="../js/qtip.js"></script>
	<script type="text/javascript" language="javascript">
		<!--
		//Info Tab
		
		function validateForm0()
		{
			var errormsg;
			errormsg = "";		
			
			var x=document.FormName0.email.value;
			if(x != "")
			{
				var atpos=x.indexOf("@");
				var dotpos=x.lastIndexOf(".");
				if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
				{
				   errormsg += "Invalid Email.\n";
				 }
		    }
						
			if (document.FormName0.companyname.value == 0)
				errormsg += "Please fill in 'Company Name'.\n";
			
			if ((errormsg == null) || (errormsg == ""))
			{
				if (document.FormName0.e_action.value == "Edit")
				{
					var x = window.confirm("Are you sure you want to edit this record?")
					if (x)
					{
					document.FormName0.btnSubmit.disabled=true;
					return true;
					}
					else
					{
					return false;
					}
	
				}
				else
				{
					document.FormName0.btnSubmit.disabled=true;
					return true;
				}	
			}
			else
			{
				alert(errormsg);
				return false;
			}
		}
		
		// Contact Person
		function validateForm1()
		{
			if(!checkSelected('FormName1', 'CustCheckbox', document.FormName1.cntCheck.value))
			{
				alert("Please select at least one checkbox.");
				document.FormName1.AllCheckbox.focus();
				return false;
			}
			else
			{
				if(confirm('Are you sure you want to delete this record?'))
				{
					document.forms.FormName1.action = "contactperson_action.php?cid=<?=$id?>";
					document.forms.FormName1.submit();
				}
                 return true;
			}
		}

	
		// Corres Note
		function validateForm2()
		{
			if(!checkSelected('FormName2', 'CustCheckbox', document.FormName2.cntCheck.value))
			{
				alert("Please select at least one checkbox.");
				document.FormName2.AllCheckbox.focus();
				return false;
			}
			else
			{
				if(confirm('Are you sure you want to delete this record?'))
				{
					document.forms.FormName2.action = "corresnote_action.php?cid=<?=$id?>";
					document.forms.FormName2.submit();
				}
                  return true;
			}
		}
		
		// SQ
		function validateForm5()
		{
			
			if(!checkSelected('FormName5', 'CustCheckbox', document.FormName5.cntCheck.value))
			{
				alert("Please select at least one checkbox.");
				document.FormName5.AllCheckbox.focus();
				return false;
			}
			else
			{
				if(confirm('Are you sure you want to delete this record?'))
				{
					document.forms.FormName5.action = "salesquotation_action.php?e_action=SQArchive";
					document.forms.FormName5.submit();
				}
                  return true;
			}
		}
		
		// Corres Note
		function validateForm4()
		{
			if(!checkSelected('FormName4', 'CustCheckbox', document.FormName4.cntCheck.value))
			{
				alert("Please select at least one checkbox.");
				document.FormName4.AllCheckbox.focus();
				return false;
			}
			else
			{
				if(confirm('Are you sure you want to delete this record?'))
				{
					$.post('salesorder_action.php?cid=<?=$id?>',$('#FormName4').serialize(),function(data){
						location.reload();
					});
				}
                                return true;
			}
		}
		
		$(function() {
			$( "#contractor" ).chosen();
		});
		//-->
	</script>
	</head>
	<body>
    <table align="center" width="970" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="align:center;">
      <tr>
        <td valign="top"><div class="maintable">
            <table width="970" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><?php include('topbar.php'); ?></td>
              </tr>
            	<tr>
                    <td class="inner-block" width="970" align="left" valign="top"><div class="m">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                        <tr>
                            <td>
                            
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tr>
                                          <td align="left" class="TitleStyle"><b>Contacts</b></td>
                                        </tr>
                                        <tr><td height=""></td></tr>
                                    </table>
                                   <br/>
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                    <td align="left"><b>
                                      <?
                                                if($id != "" || $e_action == 'edit')
                                                {
                                                    echo "Edit Contacts";
                                                }
                                                else
                                                {
                                                    echo "Add Contacts";
                                                }
											  ?>                                              
								  </td>
								  <td align="right" style="padding-right:2px; vertical-align:bottom"> <a href="customers.php" class="TitleLink">List/Search Contacts</a>
                                              
                                              <?php
											  if($id != "")
											  {
											  ?>
                                              
                                               | <a href="customer.php" class="TitleLink">Add New</a>
                                                  
                                              <?php
											  }
											  ?>
                                              
                                              </td>
                                  </tr>
								  <tr><td height="5"></td></tr>
								  <tr>
									 <td align="left" class="TitleStyle" colspan="2"><b><i>Basic Info</i> </b></td>
									</tr>
                                    <tr><td height=""></td></tr>
                                  </table>
                                  
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                  
                                  <tr><td>
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
                                            echo "<div align='left'><font color='#FF0000'>Record has been deleted successfully.<br></font></div>";
                                        }
                                        if ($_GET["error"] == 1)
                                        {
                                            echo "<div align='left'><font color='#FF0000'>MemberID [".$memberid."] is existed in the system. Please enter another MemberID.<br></font></div>";
                                        }
                                    ?></td>
                                    </tr>
                                    
                                      <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                  
                                  
                                    <tr>
                                    <td>
                                        <form name="FormName0" action="customer_action.php"  method="post" onsubmit="return validateForm0();" enctype="multipart/form-data">
                                        <input type="hidden" id="id" name="id" value="<?=$id?>" />
                                        <input type="hidden" id="customerno" name="customerno" value="<?=$customerno?>" />
                                        <input type="hidden" name="e_action" value="<?=($e_action == "" ? "addnew" : "edit")?>" />
                                        <input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
                                        <input type="hidden" name="ctab" value="<?=$ctab?>" />
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                          <tr>
                                          <td valign="top">
                                              
                                           <table width="100%" cellpadding="0" cellspacing="0" border="0">
											<tr>
                                                <td  valign="middle" width="150px">Contact Title</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                                <? $str = "SELECT _id,_salutation FROM ".$tbname."_salutation ORDER BY _id";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="contacttitle" id="contacttitle" class="dropdown1  chosen-select">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_salutation"]; ?>" <?php if($rs["_salutation"] == $contacttitle) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_salutation"]; ?>&nbsp;</option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select><span class="detail_red">*</span>
                                                </td>
                                            </tr>
											 <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>
											<tr>
                                                <td valign="middle" width="150px">Client Name</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="clientname" name="clientname" value="<?=$clientname?>" class="txtbox1" style="width:250px;" />
                                                  <span class="detail_red">*</span></td>
                                            </tr>
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>
											 <tr>
                                                <td valign="middle" width="150px">NRIC/FIN</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="nricfin" name="nricfin" value="<?=$nricfin?>" class="txtbox1" style="width:250px;" />
                                                  <span class="detail_red">*</span></td>
                                            </tr>
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>
											  <tr>
                                                <td valign="middle">NS Men</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                 <td valign="middle"><input type="radio"   tabindex="7" name="nsmen" value="Y" <?=$nsmen=='Y'?'checked="checked"':''?> />
                                                Yes
                                                <input type="radio"   tabindex="7" name="nsmen" value="N" <?=$nsmen=='N' || $nsmen == ''?'checked="checked"':''?> />
                                                No</td>
                                              </tr>
                                              
                                               <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                           <tr>
                                                <td valign="middle">Undertaking IPT Program</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                 <td valign="middle"><input type="radio"   tabindex="7" name="iptprog" value="Y" <?=$iptprog=='Y'?'checked="checked"':''?> />
                                                Yes
                                                <input type="radio"   tabindex="7" name="iptprog" value="N" <?=$iptprog=='N'  || $iptprog == ''?'checked="checked"':''?> />
                                                No</td>
                                              </tr>
                                              
                                               <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                             <tr>
                                                <td valign="middle">Address1</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="2" id="address1" name="address1" value="<?=$address1?>" class="txtbox1" style="width:250px;"/></td>
                                            </tr>
                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                                <tr>
                                                <td  valign="middle">Address2</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="3" id="address2" name="address2" value="<?=$address2?>" class="txtbox1" style="width:250px;"/></td>
                                            </tr>
                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                                <tr>
                                                <td  valign="middle">Address3</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td  valign="middle"><input type="text" tabindex="4" id="address3" name="address3" value="<?=$address3?>" class="txtbox1" style="width:250px;"/></td>
                                            </tr>
                                            
                                               <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                               <tr>
                                            <td valign="middle">Country</td>
                                            <td valign="middle">&nbsp;:&nbsp;</td>
                                            <td valign="middle" ><select  tabindex="6" name="countryid" id="countryid" class="dropdown1 chosen-select" style="width:250px;">
                                                        <option value="">--select--</option>
                                                        <?php
                                                            $sql = "SELECT * FROM ".$tbname."_countries ORDER BY if(UPPER(_countryname)= 'SINGAPORE',1,_countryname)";
                                                            $res = mysql_query($sql) or die(mysql_error());
                                                            if(mysql_num_rows($res) > 0){
                                                                while($rec = mysql_fetch_array($res)){
                                                                    ?><option <?php if($rec['_id'] == $countryid || ($id =="" && $rec['_countryname'] == "Singapore")){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_id']; ?>"><?php echo $rec['_countryname']; ?></option><?php
                                                                }
                                                            }
                                                        ?>
                                                        </select>
                                            </td>
                                            </tr>
                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                         
                                              <tr>
                                                    <td  valign="middle">City</td>
                                                        <td  valign="middle">&nbsp;:&nbsp;</td>
                                                        <td valign="middle" >
                                                            <select  tabindex="10" name="cityid" id="cityid" class="dropdown1 chosen-select" style="width:250px;">
                                                            <option value="">--select--</option>
                                                            <?php
															
															if($stateproid != "")
												{
												
                                                                $sql = "SELECT * FROM ".$tbname."_cities  
															
																Where _stateid = '". $stateproid."'
																ORDER BY  if(UPPER(_cityname)= 'SINGAPORE',1,_cityname) ";
                                                                $res = mysql_query($sql) or die(mysql_error());
                                                                if(mysql_num_rows($res) > 0){
                                                                    while($rec = mysql_fetch_array($res)){
                                                                        ?><option <?php if($rec['_id'] == $cityid  || ($id == ""  && $rec['_cityname'] == "Singapore")){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_id']; ?>"><?php echo $rec['_cityname']; ?></option><?php
                                                                    }
                                                                }
																
												}else
												{
													
													 $sql = "SELECT * FROM ".$tbname."_cities 
													Where _cityname = 'Singapore' ";
                                                    $res = mysql_query($sql) or die(mysql_error());
                                                    if(mysql_num_rows($res) > 0){
                                                        while($rec = mysql_fetch_array($res)){
                                                                ?><option <?php if($rec['_id'] == $cityid  || ($id == ""  && $rec['_cityname'] == "Singapore")){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_id']; ?>"><?php echo $rec['_cityname']; ?></option><?php
                                                                    }
                                                                }
												}
                                                            ?>
                                                          </select>
                                                    
                                                    </td>
                                              </tr>
                                               <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                         
                                             <tr>
                                                <td valign="middle">Postal Code</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle" ><input type="text" tabindex="12" id="postalcode" name="postalcode" value="<?=$postalcode?>" class="txtbox1" style="width:250px;"></td>
                                            </tr>
                                            
                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                     </table>
                                          
                                          </td>
                                          
                                          <td width="30px"></td>
                                          
                                          <td valign="top" align="right">
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tbllabel">
                                              <tr>
                                                <td valign="middle" width="150px">Client Ref No</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="" autocomplete="off" id="customerno" name="customerno" value="<?=$customerno?>" class="txtlabel" readonly="readonly" style="width:250px;font-size: 9pt;"></td>
                                              </tr>
                                              
                                               <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                              
                                                <tr>
                                                    <td valign="middle">Submitted By</td>
                                                    <td valign="middle">&nbsp;:&nbsp;</td>
                                                    <td valign="middle"><?= $subby ==""?$_SESSION['user']: $subby ?></td>
                                                </tr>
                                                
                                                 <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                             
                                              <tr>
                                                <td valign="middle">Submitted Date/Time</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><span><?=$subdate == ""?date('d/m/Y h:i:s A'):$subdate ?> </span></td>
                                              </tr>
                                              
                                               <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                              <tr>
                                                    <td valign="middle">System&nbsp;Status&nbsp;</td>
                                                    <td valign="middle">&nbsp;:&nbsp;</td>
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
                                                    <td valign="middle"><input type="radio"   tabindex="9" <?php echo $sel_status_y; ?> name="status" value="1" id="RadioGroup1_0" class="radio" />Live
                                                    <input type="radio"   tabindex="9" <?php echo $sel_status_n; ?> name="status" value="2" id="RadioGroup1_1" class="radio" />Archive</td>   
                                                </tr>  
                                                
                                                 <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>

									<tr >
										<td valign="middle">Upload NSmen ID</td>
										<td valign="middle">&nbsp;:&nbsp;</td>
										<td>
										<?php
											$sql = " select * from ".$tbname."_files Where _pageid= '".replaceSpecialChar($id)."'
													and _type='I' ";
											$sirst = mysql_query($sql);
											$sirow = mysql_fetch_assoc($sirst);
											$picpod = $sirow["_file"];
											
										if($picpod != "")
										{ ?> 
											 <a href="<?php echo $AdminTopCMSImagesPath;?><?php echo $picpod;?>" target="_blank" style="color:#FF0000; font-family:arial; font-size:11px;"><?php echo $picpod;?></a>&nbsp;
											 <a href="javascript:void(0);" onClick="if(confirm('Are you sure you want to delete this?')) { window.open('admin_removefile.php?ID=<?php echo $sirow["_id"];?>&Types=I','personalize','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=500,height=300,left=100,top=100'); return true; }" onMouseOver="write_it('Delete File');return true;" class="link1">[<img src="../images/delfilepic.gif" border="0" alt="Delete File"> Delete File]</a>
										<? }
										else {?>
											<input type="file" name="attFile[]" size="40" class="txtbox1">
														
										<?php
										}
										 ?>
										</td>
									</tr>
								 <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                               
                                              <tr>
                                                <td valign="middle">HP</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="11" id="telephone1" name="telephone1" value="<?=$telephone1?>" class="txtbox1" style="width:250px;"></td>
                                              </tr>
                                              
                                               <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                              
                                              <tr>
                                                <td valign="middle">NOK & Contact No</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="13" id="telephone2" name="telephone2" value="<?=$telephone2?>" class="txtbox1" style="width:250px;"></td>
                                              </tr>
                                              
                                               <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                              <tr>
                                                <td valign="middle">Email</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="19" id="email" name="email" value="<?=$email?>" class="txtbox1" style="width:250px;" ></td>
                                              </tr>
											  
									<tr>
										<td height="5"></td>
										<td height="5"></td>
										<td height="5"></td>
									</tr>
                                              <tr>
                                                <td valign="middle">Credits ($) available</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="19" id="creditava" name="creditava" value="<?=$creditava?>" class="txtbox1" style="width:250px;" ></td>
                                              </tr>

                                              <tr>
										<td height="5"></td>
										<td height="5"></td>
										<td height="5"></td>
									</tr>
                                              <tr>
                                                <td valign="middle">Un-used Amount</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="19" id="unusedamount" name="unusedamount" value="<?=$unusedamount?>" class="txtbox1" style="width:250px;" ></td>
                                              </tr>
                                             
                                                                                     
                                          </table>
                                          </td>
                                          
                                          </tr>
                                          
									<tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
									</tr>
									<tr>
										 <td align="left" class="TitleStyle" colspan="2"><b><i>Bio-Data</i> </b></td>
									</tr>
									<tr>
                                      <td height="10"></td>
                                      <td height="10"></td>
                                      <td height="10"></td>
									</tr>
									<tr>
										<td colspan="3">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                    <td valign="top" style="width:150px">DOB</td>
                                                    <td valign="top" width="10px">&nbsp;:&nbsp;</td>
                                                    <td valign="top">
														<div style="width: 38%;float: left;">
															<input type="text" tabindex="" id="dob" name="dob" value="<?=$dob == ""?date('d/m/Y'):$dob?>" size="60" class="txtbox1 datepicker" style="width: 200px;">   <b> (DD/MM/YYYY)</b>
														</div>
														<div style="width: 56%;float: left;margin-left: 6%;">Height<span style="margin-left: 25%;">:</span>
															 <input type="text" tabindex="" id="height" name="height" value="<?=$height?>" size="60" class="txtbox1" > <b>(Cm)</b>
														</div>
													</td>
                                                </tr>
                                                
                                                  <tr>
													  <td height="5"></td>
													  <td height="5"></td>
													  <td height="5"></td>
												 </tr>
												 <tr>
                                                    <td valign="top" style="width:150px">Medical History</td>
                                                    <td valign="top" width="10px">&nbsp;:&nbsp;</td>
                                                    <td valign="top">
														<div style="width: 38%;float: left;">
															 <textarea  tabindex="" id="medhistory" name="medhistory"  class="textarea1" style="height: 100px;"><?=$medhistory?></textarea>
														</div>
														<div style="width: 56%;float: left;margin-left: 6%;">Weight<span style="margin-left: 25%;">:</span>
															  <input type="text" tabindex="" id="weight" name="weight" value="<?=$weight?>" size="60" class="txtbox1"> <b>(kg)</b>
														</div>
														
													</td>
                                                </tr>                                                
                                                  <tr>
													  <td height="5"></td>
													  <td height="5"></td>
													  <td height="5"></td>
												 </tr>
											</table>
										</td>
									</tr>
									<tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
									</tr>
									<tr>
										 <td align="left" class="TitleStyle" colspan="2"><b><i>Work and Recreation profile </i> </b></td>
									</tr>
									<tr>
                                      <td height="10"></td>
                                      <td height="10"></td>
                                      <td height="10"></td>
									</tr>
									<tr>
										<td colspan="3">
											<div style="width: 48%;float: left;">
												Work and Recreation Profile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
												<select  tabindex="6" name="workrecprofile" id="workrecprofile" class="dropdown1 chosen-select" style="width:250px;">
													<option value="">--select--</option>
													<option value="1" <?= ($workrecprofile == '1') ? 'selected' : '';?> >Self Employed / Freelancer</option>
													<option value="2" <?= ($workrecprofile == '2') ? 'selected' : '';?> >Sedentary Office work</option>
													<option value="3" <?= ($workrecprofile == '3') ? 'selected' : '';?> >Medium Physical Demand work (e.g. storeman, trainer, lifeguard etc.)</option>
													<option value="4" <?= ($workrecprofile == '4') ? 'selected' : '';?> >High Physical Demand work (e.g. Military, Police, Fire Fighter, Shipbuilding etc.)</option>
													<option value="5" <?= ($workrecprofile == '5') ? 'selected' : '';?> >NSman (SAF/SPF/SCDF) and eligible for IPPT</option>
													<option value="6" <?= ($workrecprofile == '6') ? 'selected' : '';?> >Active in Sports</option>
												</select>
											</div>
											<div style="width: 46%;float: left;margin-left: 6%;">
												Physical Activity Profile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
												<select  tabindex="6" name="phyactiprofile" id="phyactiprofile" class="dropdown1 chosen-select" style="width:250px;">
													<option value="">--select--</option>
													<option value="1" <?= ($phyactiprofile == '1') ? 'selected' : '';?>>Seldom exercise</option>
													<option value="2" <?= ($phyactiprofile == '2') ? 'selected' : '';?>>Exercises once a week</option>
													<option value="3" <?= ($phyactiprofile == '3') ? 'selected' : '';?>>Exercise 2 - 3 times a week</option>
													<option value="4" <?= ($phyactiprofile == '4') ? 'selected' : '';?>>Exercise 4 - 6 times a week</option>
												</select>
											</div>
										</td>
									</tr>
									
									
									
									
									<tr>
                                      <td height="55"></td>
                                      <td height="55"></td>
                                      <td height="55"></td>
									</tr>
									
									
									  <tr>
                                            <td colspan="3">
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                    <td valign="top" style="width:150px">Remarks (Client)</td>
                                                    <td valign="top" width="10px">&nbsp;:&nbsp;</td>
                                                    <td valign="top"><?php 													
													$sBasePath = 'fckeditor/';
													$oFCKeditor = new FCKeditor('remarks');
													$oFCKeditor->Width = "100%";
													$oFCKeditor->Height = "400px";
													$oFCKeditor->BasePath = $sBasePath;
													$oFCKeditor->Value = replaceSpecialCharBack($remarks);
													$oFCKeditor->Create();
													
												?></td>
                                                </tr>
                                                
                                                  <tr>
													  <td height="5"></td>
													  <td height="5"></td>
													  <td height="5"></td>
												 </tr>
																
                                                <tr>
                                                    <td valign="top"  style="width:112px">Internal Remarks </td>
                                                    <td valign="top" >&nbsp;:&nbsp;</td>
                                                    <td valign="top"><?php 													
													$sBasePath = 'fckeditor/';
													$oFCKeditor = new FCKeditor('internalRemarks');
													$oFCKeditor->Width = "100%";
													$oFCKeditor->Height = "400px";
													$oFCKeditor->BasePath = $sBasePath;
													$oFCKeditor->Value = replaceSpecialCharBack($internalremarks);
													$oFCKeditor->Create();
													
												?></td>
                                                </tr>
                                                
                                                
                                                
                                                <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                          
                                            <tr>
                                            <td valign="top" colspan="2"></td>
                                                    
                                             <td align="left" >
                                            <input type="button" class="button1" name="btnBack" value="< Back" onclick="window.location='customers.php?type=<?=encrypt($type,$Encrypt)?>'" />&nbsp;
                                            <input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
                                                </td>
                                          </tr>
                                                
                                                </table>
                                            </td>
                                          </tr>
                                          
                                            
                                          </table>
                                      </form>
                                      
                                    </td>
                                  </tr>
                                  </table>
                              
                            </td>
                          </tr>
                        <tr>
                            <td>&nbsp;</td>
                          </tr>
                      </table>
                      </div></td>
              </tr>
          </table>
          </div></td>
      </tr>
    </table>
    <? include('jqueryautocomplete.php') ?>
</body>
</html>
<?php		
include('../dbclose.php');
?>