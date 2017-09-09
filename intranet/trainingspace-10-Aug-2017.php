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
		
	$currentmenu = "Training Venue";

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
	// $customerno = $_GET['customerno'];
	
	 $e_action = $_GET['e_action'];
	 $ctab = $_GET['ctab'];
	 $type = $_REQUEST['type'];
	
	
	if($ctab=="")
	{
		$ctab = 0;
	}
	
	$customertype = array();
	
	if($id != "" && $e_action == 'edit' && $ctab == '0')
	{
		
		$str = "SELECT *,date_format(_CreatedDateTime,'%d/%m/%Y %h:%i:%s %p') as _submitteddate FROM ".$tbname."_venues WHERE _ID = '".$id."' ";
		$rst = mysql_query("set names 'utf8';");


		
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			
			$trainerrefno = replaceSpecialCharBack($rs["_TraningVenuNo"]);
            $traningvenuename = replaceSpecialCharBack($rs["_VenueName"]);
			$venueownerID = replaceSpecialCharBack($rs["_OwnerID"]);
            $venuCatID = replaceSpecialCharBack($rs["_VenueCat"]);
            $venuTypeID = replaceSpecialCharBack($rs["_VenueType"]);
            $cobankaccount = replaceSpecialCharBack($rs["_CorporateBankAc"]);			
			$specialisedprogram = replaceSpecialCharBack($rs["_SpecialisedProgram"]);
			$memcommencDate = mysqlToDatepicker($rs["_MemberDate"]);
			$amenitiesservice = replaceSpecialCharBack($rs["_AmenitiesService"]);
			$equipmentavailable = replaceSpecialCharBack($rs["_EquipmentAvailable"]);
			$venuepoc = replaceSpecialCharBack($rs["_EmailvenuePoc"]);
			$hpnopoc = replaceSpecialCharBack($rs["_HP"]);
			$membershipType = replaceSpecialCharBack($rs["_membershipStatus"]);
			$status = replaceSpecialCharBack($rs["_Status"]);
            $reasonforsuspension = replaceSpecialCharBack($rs["_SuspensionReason"]);
			
			




			$btnSubmit = "Update";
		}
	}else
	{
	
		$customertype = array($_REQUEST['type']);
		
	}

	if($trainerrefno == "")
	{
		 
		 $trainerrefno = generatetranVenueNo();
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
			
		
            if (document.FormName0.traningvenuename.value == 0)
				errormsg += "Please fill in 'Training Venue Name'.\n";
						
			if (document.FormName0.venueownername.value == 0)
				errormsg += "Please fill in 'Trainer Name'.\n";

                if (document.FormName0.trainercategory.value == 0)
				errormsg += "Please select in 'Trainer Category'.\n";

                 if (document.FormName0.nricfin.value == 0)
				errormsg += "Please fill in 'NRIC No'.\n";

                 if (document.FormName0.occupation.value == 0)
				errormsg += "Please fill in 'Occupation'.\n";

                 if (document.FormName0.residentialaddress.value == 0)
				errormsg += "Please fill in 'Residential Address'.\n";

                if (document.FormName0.handphone.value == 0)
				errormsg += "Please fill in 'Handphone'.\n";

                  if (document.FormName0.email.value == 0)
				errormsg += "Please fill in 'E-mail Address'.\n";

                if (document.FormName0.bankname.value == 0)
				errormsg += "Please fill in 'Bank Name'.\n";

                  if (document.FormName0.accountname.value == 0)
				errormsg += "Please fill in 'Account Name'.\n";

               if (document.FormName0.accountnumber.value == 0)
				errormsg += "Please fill in 'Account Number'.\n";

                  if (document.FormName0.employername.value == 0)
				errormsg += "Please fill in 'Employer Name'.\n";


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
                                          <td align="left" class="TitleStyle"><b>Traning Venue</b></td>
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
                                                    echo "Edit Training Venue";
                                                }
                                                else
                                                {
                                                    echo "Add Training Venue";
                                                }
											  ?>                                              
								  </td>
								  <td align="right" style="padding-right:2px; vertical-align:bottom"> <a href="trainingspaces.php" class="TitleLink">List/Search Trainers</a>
                                              
                                              <?php
											  if($id != "")
											  {
											  ?>
                                              
                                               | <a href="trainingspace.php" class="TitleLink">Add New</a>
                                                  
                                              <?php
											  }
											  ?>
                                              
                                              </td>
                                  </tr>



   <tr>
                                    <td><div class="toptab">
                                        <ul>
                                        <li <?php if($ctab==0){ ?> style="background-color:#a9a9a9;" <?php } ?>>
                                            <?php if($id!=""){ ?>
                                            <a href="?ctab=<?=encrypt("0",$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>" style="text-decoration:none;"> Training Venue Profile</a>
                                            <?php }else{ ?>
                                            Training Venue Profile
                                            <?php } ?>
                                          </li>
                                        <li <?php if($ctab==1){ ?> style="background-color:#a9a9a9;" <?php } ?>>
                                            <?php if($id!=""){ ?>
                                            <a href="?ctab=<?=encrypt("1",$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&customerno=<?=encrypt($customerno,$Encrypt)?>&companyname=<?=encrypt($companyname,$Encrypt)?>" style="text-decoration:none;">Performance</a>
                                            <?php }else{ ?>
                                          Performance
                                            <?php } ?>
                                          </li>
                                          <li <?php if($ctab==2){ ?> style="background-color:#a9a9a9;" <?php } ?>>
                                            <?php if($id!=""){ ?>
                                            <a href="?ctab=<?=encrypt("2",$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&companyname=<?=encrypt($companyname,$Encrypt)?>" style="text-decoration:none;"> Venue Schedule</a>
                                            <?php }else{ ?>
                                         Venue Schedule
                                            <?php } ?>
                                          </li>
                                          
                                            
                                       
                                      </ul>
                                      </div></td>
                                  </tr>

  <tr>
                                    <td><?php if($ctab==0){ ?>
								  <tr><td height="5"></td></tr>
								 
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
                                        <form name="FormName0" action="trainingspaces_action.php"  method="post" onsubmit="return validateForm0();" enctype="multipart/form-data">
                                        <input type="hidden" id="id" name="id" value="<?=$id?>" />
                                        
                                        <input type="hidden" name="e_action" value="<?=($e_action == "" ? "addnew" : "edit")?>" />
                                        <input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
                                        <input type="hidden" name="ctab" value="<?=$ctab?>" />
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                          <tr>
                                          <td valign="top">
                                              
                                           <table width="100%" cellpadding="0" cellspacing="0" border="0">
											
										
											<tr>
                                                <td valign="middle" width="150px">Training Venue Name</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="traningvenuename" name="traningvenuename" value="<?=$traningvenuename?>" class="txtbox1" style="width:250px;" required/>
                                                  <span class="detail_red">*</span></td>
                                            </tr>
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>


<tr>
                                                <td  valign="middle" width="150px">Owner Name</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                                <? $str = "SELECT _ID,_FullName FROM ".$tbname."_venueowners ORDER BY _ID";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="venueownername" id="venueownername" class="dropdown1  chosen-select" >
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $venueownerID) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_FullName"]; ?>&nbsp;</option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select><span class="detail_red">*</span>
                                                </td>
                                            </tr>



                                             <!--  <tr>
                                                <td valign="middle" width="150px">Owner Name</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="ownername" name="ownername" value="<?=$ownername?>" class="txtbox1" style="width:250px;" />
                                                  <span class="detail_red">*</span></td>
                                            </tr>-->
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>


<tr>
                                                <td  valign="middle" width="150px">Training Venue Category</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                                <? $str = "SELECT _ID,_VenueCatName FROM ".$tbname."_venuecat ORDER BY _ID";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="venuecategory" id="venuecategory" class="dropdown1  chosen-select" >
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $venuCatID) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_VenueCatName"]; ?>&nbsp;</option>
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
                                                <td  valign="middle" width="150px"> Venue Type</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                                <? $str = "SELECT _ID,_VenueTypeName FROM ".$tbname."_venuetype ORDER BY _ID";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="venuetype" id="venuetype" class="dropdown1  chosen-select">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $venuTypeID) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_VenueTypeName"]; ?>&nbsp;</option>
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
                                            <td valign="middle" style="width:150px">Corporate Bank Account </td>
                                            <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                            <td valign="middle"><input type="text" tabindex="" id="cobankaccount" name="cobankaccount" value="<?=$cobankaccount?>" size="60" class="txtbox1 " style="width: 250px;"> <span class="detail_red">*</span> </td>
                                            </tr>

                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>

                            
                                             <tr>
                                                <td valign="middle">Specialised Programs</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="2" id="specialisedprogram" name="specialisedprogram" value="<?=$specialisedprogram?>" class="txtbox1" style="width:250px;"/><span class="detail_red">*</span></td>
                                            </tr>

                                           <tr>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                             </tr>
                                             <tr>
                                            <td valign="middle" style="width:150px">Membership Commencement date</td>
                                            <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                            <td valign="middle"><input type="text" tabindex="" id="memcommencDate" name="memcommencDate" value="<?=$memcommencDate == ""?date('d/m/Y'):$memcommencDate?>" size="60" class="txtbox1 datepicker" style="width: 200px;">   <b> (DD/MM/YYYY)</b></td>
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
                                                <td valign="middle" width="150px">Training Venue Owner Ref No</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="" autocomplete="off" id="trainingvenuerefno" name="trainingvenuerefno" value="<?=$trainerrefno?>" class="txtlabel" readonly="readonly" style="width:250px;"></td>
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
                                                <td valign="middle">Amenities Service</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="12" id="amenitiesservice" name="amenitiesservice" value="<?=$amenitiesservice?>" class="txtbox1" style="width:250px;"></td>
                                              </tr>

                                             <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                            </tr>
                                         
                                             <tr>
                                                <td valign="middle">Equipment available</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle" ><input type="text" tabindex="12" id="equipmentavailable" name="equipmentavailable" value="<?=$equipmentavailable?>" class="txtbox1" style="width:250px;"></td>
                                            </tr>
                                              
                                               <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                            
                                              <tr>
                                                <td valign="middle">Email<br/>Venue Point-of-Contac(POC)</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="13" id="venuepoc" name="venuepoc" value="<?=$venuepoc?>" class="txtbox1" style="width:250px;" required></td>
                                              </tr>

                                                  <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                            </tr>
                                              
                                              <tr>
                                                <td valign="middle">HP No <br/>Venue Point-of-Contac(POC)</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="13" id="hpnopoc" name="hpnopoc" value="<?=$hpnopoc?>" class="txtbox1" style="width:250px;" required><span class="detail_red">*</span></td>
                                              </tr>

                                               <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>


                                    	<tr >
										<td valign="middle">Specialised Fitness Training</td>
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
                                                <td  valign="middle" width="150px"> Membership Status</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                                <? $str = "SELECT _ID,_MembershipType FROM ".$tbname."_membershipstatus ORDER BY _ID";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="membershipstatus" id="membershipstatus" class="dropdown1  chosen-select">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $membershipType) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_MembershipType"]; ?>&nbsp;</option>
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
                                                <td valign="middle">Reason for Suspension   / De-list</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="2" id="reasonforsuspension" name="reasonforsuspension" value="<?=$reasonforsuspension?>" class="txtbox1" style="width:250px;"/></td>
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
                                      <td height="55"></td>
                                     
                                 </tr>
<tr>
<td>
  <table cellpadding="0" cellspacing="0" border="0" width="100%">


                                          
                                            <tr>
                                            <td valign="top" colspan="2" ></td>
                                                    
                                             <td align="center" >
                                            <input type="button" class="button1" name="btnBack" value="< Back" onclick="window.location='trainingspaces.php?type=<?=encrypt($type,$Encrypt)?>'" />&nbsp;
                                            <input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
                                                </td>
                                          </tr>
                                                
                                                </table>
                                          
                                          
                                            
                                          </table>
                                          </td>
                                          </tr>
                                      </form>
                                        </td>
                                          </tr>
                                        <? } ?>
                                          <?php if($ctab==1){ ?>
                                    
                                        <form name="FormName1" method="post" action="">

  <!--<table width="100%" cellpadding="0" cellspacing="0" border="0">

                                                <tr>
												  <td height="15"></td></tr>
											<tr>
                                                <td  valign="middle" width="150px">Average training hours contributed weekly (over past two month)</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                             <input type="text" tabindex="1" id="avgtraininghours" name="avgtraininghours" value="<?=$avgtraininghours?>" class="txtbox1" style="width:250px;" />
                                                </td>
                                            </tr>
											 <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>
											<tr>
                                                <td valign="middle" width="150px">Total training sessions conducted</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="totaltraisession" name="totaltraisession" value="<?=$totaltraisession?>" class="txtbox1" style="width:250px;" />
                                               </td>
                                            </tr>
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>

                                               <tr>
                                                <td valign="middle" width="150px">Average weekly training session conducted</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="aveweeklytimisession" name="aveweeklytimisession" value="<?=$aveweeklytimisession?>" class="txtbox1" style="width:250px;" />
                                                  </td>
                                            </tr>
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>

                                             <tr>
                                                <td valign="middle" width="150px">Number of training sessions cancelled</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="nooftraingsession" name="nooftraingsession" value="<?=$nooftraingsession?>" class="txtbox1" style="width:250px;" />
                                                  </td>
                                            </tr>

    <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                     </table>-->
                                          
                                         <tr>
                                          <td valign="top">
                                              
                                           <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
												  <td height="15"></td></tr>
												<tr>
                                                <td  valign="middle" width="200px">Average training hours contributed weekly (over past two month)</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                             <input type="text" tabindex="1" id="avgtraininghours" name="avgtraininghours" value="<?=$avgtraininghours?>" class="txtbox1" style="width:220px;" />
                                                </td>
                                            </tr>
											 <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>
											<tr>
                                                <td valign="middle" width="150px">Total training sessions conducted</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="totaltraisession" name="totaltraisession" value="<?=$totaltraisession?>" class="txtbox1" style="width:220px;" />
                                               </td>
                                            </tr>
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>

                                             <tr>
                                              <td valign="middle" width="150px">Average weekly training session conducted</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="aveweeklytimisession" name="aveweeklytimisession" value="<?=$aveweeklytimisession?>" class="txtbox1" style="width:220px;" />
                                                  </td>
                                            </tr>
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>

 <tr>
                                              <td valign="middle" width="150px">Number of training sessions cancelled</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="nooftraingsession" name="nooftraingsession" value="<?=$nooftraingsession?>" class="txtbox1" style="width:220px;" />
                                                  </td>
                                            </tr>
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="15"></td>
											 </tr>






  </table>
                                          
                                          </td>
                                          
                                    
                                          
                                          <td valign="top" align="right">
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tbllabel">
                                               
                                                <tr>
                                                    <td  width="200px" valign="middle"></td>
                                                    <td valign="middle">&nbsp;&nbsp;</td>
                                                    <td valign="middle"></td>
                                                </tr>
                                               <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                              
                                                <tr>
                                                    <td  width="200px" valign="middle">Number and % of Satisfactory Review (3 stars and above)</td>
                                                    <td valign="middle">&nbsp;:&nbsp;</td>
                                                    <td valign="middle"><input type="text" tabindex="1" id="noofperSatireview" name="noofperSatireview" value="<?=$noofperSatireview?>" class="txtbox1" style="width:220px;" /></td>
                                                </tr>
                                                
                                                 <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>

                                  <tr>
                                                    <td valign="middle">Number and % of Unsatisfactory Review (2 stars and below)</td>
                                                    <td valign="middle">&nbsp;:&nbsp;</td>
                                                    <td valign="middle"><input type="text" tabindex="1" id="noofperUnsatireview" name="noofperUnsatireview" value="<?=$noofperUnsatireview?>" class="txtbox1" style="width:220px;" /></td>
                                                </tr>
                                                
                                                 <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>

                                         <tr>
                                                    <td valign="middle">Paid out income (past 2 month)</td>
                                                    <td valign="middle">&nbsp;:&nbsp;</td>
                                                    <td valign="middle"><input type="text" tabindex="1" id="paidoutincome" name="paidoutincome" value="<?=$paidoutincome?>" class="txtbox1" style="width:220px;" /></td>
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
                                     
                                      <td height="75"></td>
                                 </tr>
                                 <tr>

                                            <td colspan="2" height="5"></td>
                                          </tr>
                                          
                                            <tr>
                                            <td colspan="2" ><input type="hidden" name="cntCheck" value="<?php echo $i-1; ?>" /></td>
                                          </tr>
                                            <tr>
                                            <td colspan="1" class="pageno"><?php
                                                  if($MaxPage > 0) echo "Page: ";
                                                  for ($i=1; $i<=$MaxPage; $i++)
                                                  {
                                                      if ($i == $PageNo)
                                                      {
                                                          print "<a class=\"selected\" href='?PageNo=". encrypt($i,$Encrypt) . $QureyUrl ."' class='menulink'>".$i."</a> ";
                                                      }
                                                      else
                                                      {
                                                          print "<a class=\"unselect\" href='?PageNo=" . encrypt($i,$Encrypt) . $QureyUrl ."' class='menulink'>".$i."</a> ";
                                                      }
                                                  }
                                              ?></td>
                                          </tr>
                                            <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                            <tr>
                                           
                                                    
                                             <td align="center" >
                                            <input type="button" class="button1" name="btnBack" value="< Back" onclick="window.location='trainingspaces.php?type=<?=encrypt($type,$Encrypt)?>'" />&nbsp;
                                          
                                                </td>
                                          </tr>
                                          </table>
                                        </form>
                                        <?php } ?>
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
$("#add_new").click(function () { 

    $("#maintable").each(function () {
       
        var tds = '<tr>';
        jQuery.each($('tr:last td', this), function () {
            tds += '<td>' + $(this).html() + '</td>';
        });
        tds += '</tr>';
        if ($('tbody', this).length > 0) {
            $('tbody', this).append(tds);
        } else {
            $(this).append(tds);
        }
    });
});
</script>