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
                                                <td  valign="middle" width="150px">Trainer Title</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                                <? $str = "SELECT _id,_salutation FROM ".$tbname."_salutation ORDER BY _id";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="trainertitle" id="trainertitle" class="dropdown1  chosen-select">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_salutation"]; ?>" <?php if($rs["_salutation"] == $trainertitle) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_salutation"]; ?>&nbsp;</option>
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
                                                <td valign="middle" width="150px">Trainer Name</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="trainername" name="trainername" value="<?=$trainername?>" class="txtbox1" style="width:250px;" />
                                                  <span class="detail_red">*</span></td>
                                            </tr>
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>

                                               <tr>
                                                <td valign="middle" width="150px">Name in Chinese Characters</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="nameinchinese" name="nameinchinese" value="<?=$FullNameChines?>" class="txtbox1" style="width:250px;" />
                                                  <span class="detail_red">*</span></td>
                                            </tr>
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>


<tr>
                                                <td  valign="middle" width="150px">Trainer Category</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                                <? $str = "SELECT _ID,_TrainerCatName FROM ".$tbname."_trainerscat ORDER BY _ID";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="trainercategory" id="trainercategory" class="dropdown1  chosen-select">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $TrainerCatID) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_TrainerCatName"]; ?>&nbsp;</option>
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
                                                <td valign="middle" width="150px">NRIC No/FIN No</td>
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
                                            <td valign="middle" style="width:150px">Expiry Date </td>
                                            <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                            <td valign="middle"><input type="text" tabindex="" id="expirtdate" name="expirtdate" value="<?=$expirtdate == ""?date('d/m/Y'):$expirtdate?>" size="60" class="txtbox1 datepicker" style="width: 200px;">   <b> (DD/MM/YYYY)</b></td>
                                            </tr>

                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>

                            
                                             <tr>
                                                <td valign="middle">Occupation</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="2" id="occupation" name="occupation" value="<?=$Occupation?>" class="txtbox1" style="width:250px;"/><span class="detail_red">*</span></td>
                                            </tr>

                                           <tr>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                             </tr>
                                            <tr>
                                            <td  valign="middle">Nationality</td>
                                            <td valign="middle">&nbsp;:&nbsp;</td>
                                            <td valign="middle"><input type="text" tabindex="3" id="nationality" name="nationality" value="<?=$nationality?>" class="txtbox1" style="width:250px;"/></td>
                                        </tr>
                                           <tr>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                             </tr>
                                          <tr>
                                            <td valign="middle" style="width:150px">Date of Birth </td>
                                            <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                            <td valign="middle"><input type="text" tabindex="" id="dob" name="dob" value="<?=$dob == ""?date('d/m/Y'):$dob?>" size="60" class="txtbox1 datepicker" style="width: 200px;">   <b> (DD/MM/YYYY)</b></td>
                                            </tr>

                                                        <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                            </tr>
                                             <tr>
                                                <td valign="middle">Country of Birth</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="2" id="cofbirth" name="cofbirth" value="<?=$cofbirth?>" class="txtbox1" style="width:250px;"/></td>
                                            </tr>


                                               <tr>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                             </tr>

                                                <tr>
                                                <td valign="middle">Sex</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                 <td valign="middle"><input type="radio"   tabindex="7" name="sex" value="Male" <?=$sex=='Male' || $sex == ''?'checked="checked"':''?> />
                                                Male
                                                <input type="radio"   tabindex="7" name="sex" value="Female" <?=$sex=='Female' ?'checked="checked"':''?> />
                                                Female</td>
                                              </tr>

                                                  <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                  </tr>
                                                    <tr>
                                                    <td valign="middle">Marital Status</td>
                                                    <td valign="middle">&nbsp;:&nbsp;</td>
                                                    <td valign="middle"><input type="radio"   tabindex="7" name="maritalstatus" value="Single" <?=$maritalstatus=='Single' || $maritalstatus == '' ?'checked="checked"':''?> />
                                                    Single 
                                                    <input type="radio"   tabindex="7" name="maritalstatus" value="Married" <?=$maritalstatus=='Married' ?'checked="checked"':''?> />
                                                    Married
                                                     <input type="radio"   tabindex="7" name="maritalstatus" value="Divorced" <?=$maritalstatus=='Divorced' ?'checked="checked"':''?> />
                                                    Divorced <br/>
                                                     <input type="radio"   tabindex="7" name="maritalstatus" value="Widowed" <?=$maritalstatus=='Widowed' ?'checked="checked"':''?> />
                                                    Widowed  
                                                     <input type="radio"   tabindex="7" name="maritalstatus" value="Separated" <?=$maritalstatus=='Separated' ?'checked="checked"':''?> />
                                                    Separated  </td>
                                                        </tr>

                                                     <tr>
                                                    <td height="5"></td>
                                                    <td height="5"></td>
                                                    <td height="5"></td>
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
                                                <td valign="middle" width="150px">Trainer Ref No</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="" autocomplete="off" id="trainerno" name="trainerno" value="<?=$trainerrefno?>" class="txtlabel" readonly="readonly" style="width:250px;"></td>
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

								
								 <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                               
                                              <tr>
                                                <td valign="middle">Residential Address</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><textarea  tabindex="" id="residentialaddress" name="residentialaddress"  class="textarea1" style="height:70px;"><?=$residentialaddress?></textarea><span class="detail_red">*</span></td>
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
                                              
                                              <tr>
                                                <td valign="middle"><b>Contact Nos. </b></td>                                               
                                              </tr>
                                              
                                                 <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                            </tr>
                                              
                                              <tr>
                                                <td valign="middle">Home No</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="13" id="hometelno" name="hometelno" value="<?=$hometelno?>" class="txtbox1" style="width:250px;"></td>
                                              </tr>

                                                  <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                            </tr>
                                              
                                              <tr>
                                                <td valign="middle">Handphone</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="13" id="handphone" name="handphone" value="<?=$handphone?>" class="txtbox1" style="width:250px;"><span class="detail_red">*</span></td>
                                              </tr>

                                               <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                              <tr>
                                                <td valign="middle">E-mail Address </td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="19" id="email" name="email" value="<?=$email?>" class="txtbox1" style="width:250px;" ><span class="detail_red">*</span></td>
                                              </tr>
											  
									<tr>
										<td height="5"></td>
										<td height="5"></td>
										<td height="5"></td>
									</tr>

                                       <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                  </tr>
                                                    <tr>
                                                    <td valign="middle">Race</td>
                                                    <td valign="middle">&nbsp;:&nbsp;</td>
                                                    <td valign="middle"><input type="radio"   tabindex="7" name="race" value="Chinese" <?=$race=='Chinese' || $race == '' ?'checked="checked"':''?> />
                                                    Chinese 
                                                    <input type="radio"   tabindex="7" name="race" value="Malay" <?=$race=='Malay' ?'checked="checked"':''?> />
                                                    Malay
                                                     <input type="radio"   tabindex="7" name="race" value="Indian" <?=$race=='Indian' ?'checked="checked"':''?> />
                                                    Indian <br/>
                                                     <input type="radio"   tabindex="7" name="race" value="Eurasian" <?=$race=='Eurasian' ?'checked="checked"':''?> />
                                                    Eurasian </td>
                                                        </tr>

                                                    
                                                    <tr>
                                                    <td height="5"></td>
                                                    <td height="5"></td>
                                                    <td height="5"></td>
                                                </tr>


                                                   <tr>
                                                <td valign="middle">Race Others (please specify)</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="2" id="raceofother" name="raceofother" value="<?=$raceofother?>" class="txtbox1" style="width:250px;"/></td>
                                            </tr>
                                               <tr>
                                                    <td height="5"></td>
                                                    <td height="5"></td>
                                                    <td height="5"></td>
                                                </tr>

                                                <tr>
                                                <td valign="middle">Type of Pass</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                 <td valign="middle"><input type="radio"   tabindex="7" name="typeofpass" value="Employment" <?=$typeofpass=='Employment' || $typeofpass == ''?'checked="checked"':''?> />
                                                Employment 
                                                <input type="radio"   tabindex="7" name="typeofpass" value="Dependent" <?=$typeofpass=='Dependent' ?'checked="checked"':''?> />
                                                Dependent 
                                                <input type="radio"   tabindex="7" name="typeofpass" value="Others" <?=$typeofpass=='Others' ?'checked="checked"':''?> />
                                                Others  </td>
                                              </tr>
                                                <tr>
                                                    <td height="5"></td>
                                                    <td height="5"></td>
                                                    <td height="5"></td>
                                                </tr>
                                            
                                            
                                                                                     
                                          </table>

                                          </td>
                                          
                                          </tr>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
										 <td align="left" class="TitleStyle" colspan="2"><b><i>Bank Details </i> </b></td>
									</tr>
									<tr>
                                      <td height="10"></td>
                                      <td height="10"></td>
                                      <td height="10"></td>
									</tr>

  <tr>
                                                    <td valign="top" style="width:150px">Bank Name</td>
                                                    <td valign="top" width="10px">&nbsp;:&nbsp;</td>
                                                    <td valign="top">
														
															<input type="text" tabindex="19" id="bankname" name="bankname" value="<?=$bankname?>" class="txtbox1" style="width:250px;" >
												
														
												<span class="detail_red">*</span>	</td>
                                                </tr>
                                                
                                                  <tr>
													  <td height="5"></td>
													  <td height="5"></td>
													  <td height="5"></td>
												 </tr>

                                                      <tr>
                                                    <td valign="top" style="width:150px">Account Name</td>
                                                    <td valign="top" width="10px">&nbsp;:&nbsp;</td>
                                                    <td valign="top">
														
															<input type="text" tabindex="19" id="accountname" name="accountname" value="<?=$accountname?>" class="txtbox1" style="width:250px;" >

												<span class="detail_red">*</span>	</td>
                                                </tr>
                                                       <tr>
													  <td height="5"></td>
													  <td height="5"></td>
													  <td height="5"></td>
												 </tr>


                                                   <tr>
                                                    <td valign="top" style="width:150px">Account Number</td>
                                                    <td valign="top" width="10px">&nbsp;:&nbsp;</td>
                                                    <td valign="top">
														
															<input type="text" tabindex="19" id="accountnumber" name="accountnumber" value="<?=$accountnumber?>" class="txtbox1" style="width:250px;" >

												<span class="detail_red">*</span>	</td>
                                                </tr>

												                                         
                                                  <tr>
													  <td height="5"></td>
													  <td height="5"></td>
													  <td height="5"></td>
												 </tr>
											</table>


									<tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
									</tr>
									<tr>
										 <td align="left" class="TitleStyle" colspan="2"><b><i>CURRENT EMPLOYER’S DETAILS </i> </b></td>
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
										<td colspan="3">
											
											<div style="width: 46%;float: left;">
												Employer Name  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
											<input type="text" tabindex="19" id="employername" name="employername" value="<?=$employername?>" class="txtbox1" style="width:250px;" ><span class="detail_red">*</span>
											</div>

                                             <div style="width: 46%;float: left;margin-left: 6%;">
                                             
											Tel. No.
                                            <input type="text" tabindex="19" id="employertelno" name="employertelno" value="<?=$employertelno?>" class="txtbox1" style="width:250px;" >												
											</div>
										</td>
									</tr>
                                                	<tr>
                                      <td height="10"></td>
                                      <td height="10"></td>
                                      <td height="10"></td>
									</tr>
									<tr>
										<td colspan="3">
											
											<div style="width: 46%;float: left; ">
												Address of Employer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
											<textarea  tabindex="" id="addressofemployer" name="addressofemployer"  class="textarea1" style="height:70px;"><?=$addressofemployer?></textarea>
											</div>
                                             <div style="width: 46%;float: left;margin-left: 6%;">
											Fax No.
                                            <input type="text" tabindex="19" id="employerfaxno" name="employerfaxno" value="<?=$employerfaxno?>" class="txtbox1" style="width:250px;" >												
											</div>
                                             
										</td>
									</tr> 




                                                  <tr>
													  <td height="5"></td>
													  <td height="5"></td>
													  <td height="5"></td>
												 </tr>
                                                 <tr>
										<td colspan="3">
											
											<div style="width: 46%;float: left; ">
										Postal Code    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
										<input type="text" tabindex="19" id="employerpostalcode" name="employerpostalcode" value="<?=$employerpostalcode?>" class="txtbox1" style="width:250px;" >
											</div>
                                           
										</td>
									</tr>
											</table>
										</td>
									</tr>
									

                          <tr>
<td>
	<button type="button" class='addmore'>+ Add </button>
	<table border="1" cellspacing="0" width="58%" style="text-align:center;">
		  <tr>
			
			<th width="10px">S / No</th>
			<th width="30px">Highest Academic Qualifications Attained<br/>
                                 [e.g. Bachelor of Arts, PhD (Finance), etc.]                 
            </th>
			<th width="50px;">>Name of Institution / Examination Board</th>
			<th width="10px">From (Year)</th>
			<th  width="10px">To (Year)</th>
			
		  </tr>
		  <tr>
		
			<td width="150px">1.</td>
			<td width="5px;">><input type='text' id='qualification' name='qualification[]' style="width:290px"/></td>
			<td width="5px;">><input type='text' id='institution' name='institution[]' style="width:290px"/></td>
			<td width="5px;">><input type='text' id='from' name='from[]' style="width:70px"/></td>
			<td width="5px;">><input type='text' id='to' name='to[]'  style="width:70px"/> </td>
			
		  </tr>
        

		</table>

	



                                            
                                                </td></tr>          
								
									
									
									
									
									
									
																
                                              
                                                
                                                
                                                
                                              
                                          
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


    <script>
var i=2;
$(".addmore").on('click',function(){
    var data="<tr><td><input type='checkbox' class='case' style='width:10px'/></td><td>"+i+".</td>";
    data +="<td><input type='text' id='qualification"+i+"' name='qualification[]' style='width:290px'/></td> <td><input type='text' id='institution"+i+"' name='institution[]' style='width:290px'/></td><td><input type='text' id='from"+i+"' name='from[]' style='width:70px'/></td><td><input type='text' id='to"+i+"' name='to[]' style='width:70px'/></td></tr>";
	$('table').append(data);
	i++;
});
</script>
<script>
$(".delete").on('click', function() {
	$('.case:checkbox:checked').parents("tr").remove();

});
</script>