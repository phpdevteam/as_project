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
		
	$currentmenu = "Trainer";

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
		
		$str = "SELECT *,date_format(_CreatedDateTime,'%d/%m/%Y %h:%i:%s %p') as _submitteddate FROM ".$tbname."_trainers WHERE _ID = '".$id."' ";
		$rst = mysql_query("set names 'utf8';");


		
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			
			$trainertitle = replaceSpecialCharBack($rs["_Trainertitle"]);
            $trainerrefno = replaceSpecialCharBack($rs["_TrainerRefNo"]);
			$trainername = replaceSpecialCharBack($rs["_FullName"]);
            $FullNameChines = replaceSpecialCharBack($rs["_FullNameChines"]);
            $TrainerCatID = replaceSpecialCharBack($rs["_TrainerCatID"]);
            $nricfin = replaceSpecialCharBack($rs["_Nric"]);			
			$Occupation = replaceSpecialCharBack($rs["_Occupation"]);
			$nationality = $rs["_Nationality"];
			$dob = mysqlToDatepicker($rs["_Dob"]);
			$cofbirth = replaceSpecialCharBack($rs["_CountryDob"]);
			$sex = replaceSpecialCharBack($rs["_Sex"]);
			$maritalstatus = replaceSpecialCharBack($rs["_MaritalStatus"]);
			$finno = replaceSpecialCharBack($rs["_FinNo"]);
			$status = replaceSpecialCharBack($rs["_Status"]);
			$expirtdate = mysqlToDatepicker($rs["_ExpiryDate"]);
			$race = replaceSpecialCharBack($rs["_Race"]);
			$raceofother = replaceSpecialCharBack($rs["_RaceOther"]);
			$typeofpass = replaceSpecialCharBack($rs["_TypePass"]);
			$residentialaddress = replaceSpecialCharBack($rs["_Address"]);
			$postalcode = replaceSpecialCharBack($rs["_Postalcode"]);
			$hometelno = replaceSpecialCharBack($rs["_HomeNo"]);
			$handphone = $rs["_Handphone"];		
			$email = replaceSpecialCharBack($rs["_Email"]);
			$bankname = $rs["_Bankname"];
			$accountname = $rs["_Accountname"];
			$accountnumber = replaceSpecialCharBack($rs["_Accountnumber"]);
			$employername = replaceSpecialCharBack($rs["_EmployerName"]);
            $addressofemployer = $rs["_EmployerAddress"];
			$employerpostalcode = $rs["_EmployerPostalcode"];
			$employertelno = replaceSpecialCharBack($rs["_EmployerTelno"]);
			$employerfaxno = replaceSpecialCharBack($rs["_EmployerFaxno"]);
            $selfprofile = replaceSpecialCharBack($rs["_Selfprofile"]);

            $MpDeclaration1 = replaceSpecialCharBack($rs["_MpDeclaration1"]);
            $MpDeclaration2 = $rs["_MpDeclaration2"];
			$MpDeclaration3 = $rs["_MpDeclaration3"];
			$MpDeclaration4 = replaceSpecialCharBack($rs["_MpDeclaration4"]);
			$AnswerOfYes = replaceSpecialCharBack($rs["_AnswerOfYes"]);
            $footersignature = replaceSpecialCharBack($rs["_FooterSignature"]);
             $footerdate = mysqlToDatepicker($rs["_FooterDate"]);




			$btnSubmit = "Update";
		}
	}else
	{
	
		$customertype = array($_REQUEST['type']);
		
	}

	if($trainerrefno == "")
	{
		 
		 $trainerrefno = generateTrainerNo();
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
     
<script src='jquery-1.9.1.min.js'></script>
	<script type="text/javascript" language="javascript">
		<!--
		//Info Tab



    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
		
function validateForm0()
		{


			var errormsg;
			errormsg = "";		
			
		
       	   if (document.FormName0.trainertitle.value == 0)
				errormsg += "Please select in 'Trainer Title'.\n";
						
			if (document.FormName0.trainername.value == 0)
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
		

		function validateForm3()
		{
			
				document.forms.FormName0.action = "trainer_action.php?action12=delete1";
					document.forms.FormName0.submit();
				}
			



     function validateForm4()
		{
			
				document.forms.FormName0.action = "trainer_action.php?action22=delete2";
					document.forms.FormName0.submit();
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
                                          <td align="left" class="TitleStyle"><b>Trainers</b></td>
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
                                                    echo "Edit Trainer";
                                                }
                                                else
                                                {
                                                    echo "Add Trainer";
                                                }
											  ?>                                              
								  </td>
								  <td align="right" style="padding-right:2px; vertical-align:bottom"> <a href="trainers.php" class="TitleLink">List/Search Trainers</a>
                                              
                                              <?php
											  if($id != "")
											  {
											  ?>
                                              
                                               | <a href="trainer.php" class="TitleLink">Add New</a>
                                                  
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
                                            <a href="?ctab=<?=encrypt("0",$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>" style="text-decoration:none;">Trainer Profile</a>
                                            <?php }else{ ?>
                                            Trainer Profile
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
                                            <a href="?ctab=<?=encrypt("2",$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&companyname=<?=encrypt($companyname,$Encrypt)?>" style="text-decoration:none;"> Training Schedule</a>
                                            <?php }else{ ?>
                                         Training Schedule
                                            <?php } ?>
                                          </li>
                                          
                                            
                                       
                                      </ul>
                                      </div></td>
                                  </tr>

  <tr>
                                    <td><?php if($ctab==0){ ?>
								  <tr><td height="5"></td></tr>
								  <tr>
									 <td align="left" class="TitleStyle" colspan="2"><b><i>PERSONAL PARTICULARS</i> </b></td>
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
                                            echo "<div align='left'><font color='#FF0000'>TrainerID [".$trainerrefno."] is existed in the system. Please enter another MemberID.<br></font></div>";
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
                                        <form name="FormName0" action="trainer_action.php"  method="post" onsubmit="return validateForm0();" enctype="multipart/form-data">
                                        <input type="hidden" id="id" name="id" value="<?=$id?>" />
                                        
                                        <input type="hidden" name="e_action" value="<?=($e_action == "" ? "addnew" : "edit")?>" />
                                        <input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
                                        <input type="hidden" name="ctab" value="<?=$ctab?>" />
                                         <input type="hidden" name="srno" value="<?=$srno?>" />
                                        
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                          <tr>
                                          <td valign="top">
                                              
                                           <table width="450px" cellpadding="0" cellspacing="0" border="0">
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
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tbllabel" style="margin-right:110px;">
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
                                          
									<tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
									</tr>
									<tr>
										 <td align="left" class="TitleStyle" colspan="2"><b><i>Bank Details </i> </b></td>
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
										</td>
									</tr>
									<tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="15"></td>
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
											
											<div style="width: 46%;float: left;">
											<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>	
											</div>

                                             <div style="width: 46%;float: left;margin-left: 6%;">
                                             
											<b>Office Contact Nos. </b>
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
                                      <td height="10"></td>
                                      <td height="10"></td>
                                      <td height="10"></td>
									</tr>
									<tr>
										<td colspan="3">
											
											<div style="width: 46%;float: left; ">
										Postal Code    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
										<input type="text" tabindex="19" id="employerpostalcode" name="employerpostalcode" value="<?=$employerpostalcode?>" class="txtbox1" style="width:250px;" >
											</div>
                                           
										</td>
									</tr>
                                    	<tr>
                                      <td height="25"></td></tr>
									
                                    <tr>
                                            <td colspan="3">
                                            	<tr>
										 <td align="left" class="TitleStyle" colspan="2"><b><i>DETAILS OF QUALIFICATIONS  </i> </b></td>
									</tr>
                                    	<tr>
                                      <td height="10"></td></tr>
									
                                     <tr>
                                                 <td><b><i style="font-size:14px;color:#2C6AAC;">Academic Qualifications</i></b></td></tr> 



                                    <tr>
                                    <td width="300px;"></td>
                                    <td width="300px;"></td>

                                    <td>
                                        <button type="button" id='addmore'  class="button1" style="text-align:left;width:130px;margin-left: 263px;"><b>+ Add New Certificate</b></button></td></tr>
                                        <tr>
                                        <td height="20"></td></tr>

                                    <table id="demo123" border="0" cellspacing="0"  class="grid" style="text-align:center;width:895px;" >
                                            <tr>
                                                <th  width="5%"class="gridheader"><input name="AllCheckbox" id="AllCheckbox" type="checkbox"   tabindex="" class='check_all' value="All"  onclick="select_all()" onclick="CheckUnChecked('FormName','CustCheckboxq',document.FormName.cntCheck1.value,this,'<?=$colCount?>');" /></th>
                                                <th width="5%" class="gridheader" style="font-size:12px;">S / No</th>
                                                <th width="30%" class="gridheader" style="font-size:12px;">Highest Academic Qualifications Attained<br/>
                                                                    [e.g. Bachelor of Arts, PhD (Finance), etc.]                 
                                                </th>
                                                <th width="30%" class="gridheader" style="font-size:12px;">Name of Institution / Examination Board</th>
                                                <th class="gridheader" width="10px" style="font-size:12px;">From (Year)</th>
                                                <th class="gridheader"  width="10px" style="font-size:12px;">To (Year)</th>
                                                <input type="hidden" name="cntCheck1" value="<?php echo $i-1; ?>" />
                                            </tr>
                                            <tr>

                                            

                                    <?php 
                                    if($e_action == 'edit')
                                    
                                    {

                                        $str1= "SELECT * FROM ".$tbname."_trainerqualification WHERE _TranerID = '$id' and _Status=1";


                                  
                                        $rst = mysql_query("set names 'utf8';");
                                        $i=1;
                                            $rst = mysql_query($str1, $connect) or die(mysql_error());

                                            $total=mysql_num_rows($rst);
                                            
                                            if(mysql_num_rows($rst) > 0)
                                            {                                   
                                            while($rs = mysql_fetch_assoc($rst))
                                            { 
                                                $srno           = $rs['_SrNo'];
                                                $qualification  = $rs['_AcdQualifications'];
                                                $institution    = $rs['_InstitutionName'];            
                                                $from           = $rs['_From'];
                                                $to             = $rs['_To'];
                                              
                                            ?>
                                                <td  class="gridline2">
                                                 <input name="CustCheckboxq<?php echo $i; ?>" type="checkbox"  class="case"  tabindex="" value="<?php echo $rs["_ID"]; ?>" onclick="setActivities(this.form.CustCheckboxq<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>','<?=$colCount?>');" />
                                                
                                                <!--<input type='checkbox' class='case' name="CustCheckbox<?php echo $i; ?>" value="<?php echo $rs["_ID"];?>" onclick="setActivities(this.FormName0.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>','<?=$colCount?>');"/>-->
                                                
                                                </td>
                                                <td class="gridline2"><input type='text' id='srno' name='srno[]' value="<?php echo $srno;?>" style="width:15px;border:0px;"></td>
                                                <td  class="gridline2"><input type='text' id='qualification' name='qualification[]' value="<?php echo $qualification;?>" style="width:290px"/></td>
                                                <td  class="gridline2"><input type='text' id='institution' name='institution[]'   value="<?php echo $institution;?>" style="width:290px"/></td>
                                                <td  class="gridline2"><input type='text' id='from' name='from[]'  onkeypress="return isNumber(event)" maxlength="4" value="<?php echo $from;?>" style="width:90px"/></td>
                                                <td  class="gridline2"><input type='text' id='to' name='to[]' onkeypress="return isNumber(event)" maxlength="4" value="<?php echo $to;?>"  style="width:90px"/> </td>
                                            </tr>	
                                  
                                    <?php
                                    
                                              $i++;
                                                }
                                                 }
                                                    ?>
 <input type="hidden" name="cntCheck1" value="<?php echo $i-1; ?>" />        
                                        <?php } else{?>
                                    <tr>
                                    <td class="gridline2"><input type='checkbox' class='case'  name="AllCheckbox1" id="AllCheckbox1"value="All" onclick="CheckUnChecked('FormName0','CustCheckboxq',document.FormName0.cntCheck1.value,this,'<?=$colCount?>');"  /></td>
                                                <td class="gridline2" width="16px;"><input type='text' id='srno' name='srno[]'  style="width:0px;border:0px;">1</td>
                                                <td class="gridline2"><input type='text' id='qualification' name='qualification[]' style="width:290px"/></td>
                                                <td class="gridline2"><input type='text' id='institution' name='institution[]' style="width:290px"/></td>
                                                <td class="gridline2"><input type='text' id='from' name='from[]' onkeypress="return isNumber(event)" maxlength="4"  style="width:90px"/></td>
                                                <td class="gridline2"><input type='text' id='to' name='to[]' onkeypress="return isNumber(event)" maxlength="4" style="width:90px"/> </td>
                                                

                                          <?php } ?>

                                          
                                            </tr>
                                            </table>

                                    <br/>

                                            <button type="button" id='delete' class="button1"   onclick="return validateForm3();"   style="text-align:center;width:70px;"><b>  Delete</b></button>
                                            <!--<button type="button" class='addmore'>+ Add New Certificate</button>-->
                                
                                    <br/>
                                    <br/>



                                <table cellpadding="0" cellspacing="0" border="0" width="950px;">
                                    <tr>

                                <td><b><i style="font-size:14px;color:#2C6AAC;">Relevant Professional Qualifications</i></b></td></tr> 

                                <tr>
                                <td width="670;"></td>
                             <td>
                            <button type="button" id="addmore1" class="button1" style="text-align:left;width:130px;margin-left: 90px;"><b>+ Add New Certificate</b></button></td></tr>
                            <tr>
                            <td height="10"></td></tr>

                           <table id="test123" border="0" cellspacing="0"  style="text-align:center;width:890px;" >
                                <tr>
                                    <th class="gridheader"  width="20px"><input name="AllCheckbox1" id="AllCheckbox1" type="checkbox"   tabindex="" class='check_all' value="All"  onclick="select_all2()" onclick="CheckUnChecked2('FormName','CustCheckboxr',document.FormName.cntCheck2.value,this,'<?=$colCount?>');" /></th>
                                    <th class="gridheader" width="5%" style="font-size:12px;">S / No</th>
                                    <th class="gridheader" width="100px" style="font-size:12px;">Course Attended  <br/>(e.g. Yoga Instructor Course) </th>                
                                    
                                    <th class="gridheader"  width="100px" style="font-size:12px;">Qualifications Obtained <br/>(e.g. Yoga Instructor Certificate) </th>
                                    
                                    <th class="gridheader"  width="100px" style="font-size:12px;">Name of Institution / <br/>Examination Board</th>
                                    <th class="gridheader" width="20px" style="font-size:12px;">From (Year)</th>
                                    <th  class="gridheader" width="20px" style="font-size:12px;">To (Year)</th>
                                    
                                </tr>
                                <tr>
                            <?php 
                            if($e_action == 'edit')                           
                            {

                                    $str1= "SELECT * FROM ".$tbname."_trainerrelevantqualification WHERE _TranerID = '$id' and _Status=1";


                                    echo $str1;
                                    $rst = mysql_query("set names 'utf8';");

                                    $rst = mysql_query($str1, $connect) or die(mysql_error());
                                    $i=1;

                                    $total33=mysql_num_rows($rst);

                                    if(mysql_num_rows($rst) > 0)
                                    {
                                                                            
                                    while($rs = mysql_fetch_assoc($rst))
                                    { 
                                        $relSrno        = $rs['_RelevSrNo'];
                                        $courseatten    = $rs['_ReleCourseAttend'];
                                        $relqualiobtain = $rs['_ReleQualification'];  
                                        $relinstitution = $rs['_ReleInstitution'];          
                                        $relfrom        = $rs['_ReleFrom'];
                                        $relto          = $rs['_ReleTo'];
                                        $filename1     = $rs['_Filename1'];
                                        $filename1_array[]     = $rs['_Filename1'];

                                   
                                    ?>
                                <td class="gridline2" width="20px;" > <input name="CustCheckboxr<?php echo $i; ?>" type="checkbox"  class='case2'   tabindex="" value="<?php echo $rs["_ID"]; ?>" onclick="setActivities2(this.form.CustCheckboxr<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>','<?=$colCount?>');" style="width:15px;"/></td>
                                <td class="gridline2" width="20px;"><input type='text' id='relSrno' name='relSrno[]' value="<?php echo $relSrno;?>" style="width:15px;border:0px;"></td>
                                <td class="gridline2"  width="20px;"><input type='text' id='courseatten' name='courseatten[]' value="<?php echo $courseatten;?>" style="width:150px"/></td>
                                <!--<td><input type='text' id='relqualiobtain' name='relqualiobtain[]'   value="<?php echo $relqualiobtain;?>" style="width:200px"/></td>-->
                                <td class="gridline2"  width="20px;" ><input type="file"  name="attFile[]"  size="10" class="txtbox1" ><?php echo $filename1;?> <a href="<?php echo $AdminTopCMSImagesPath;?><?php echo $picpod;?>" target="_blank"     style="color:#FF0000; font-family:arial; font-size:11px;"></a>&nbsp;</td>
                                <td class="gridline2"><input type='text' id='relinstitution' name='relinstitution[]'   value="<?php echo $relinstitution;?>" style="width:150px"/></td>
                                <td class="gridline2"><input type='text' id='relfrom' name='relfrom[]'  onkeypress="return isNumber(event)" maxlength="4" value="<?php echo $relfrom;?>" style="width:90px"/></td>
                                <td class="gridline2"><input type='text' id='relto' name='relto[]' onkeypress="return isNumber(event)" maxlength="4" value="<?php echo $relto;?>"  style="width:90px"/> </td>
                                </tr>	
                             <?php
                               $i++;
                             }
                                 }
                                ?>
 <input type="hidden" name="cntCheck2" value="<?php echo $i-1; ?>" />   
   
   

                    <?php } else{?>
                    <tr>
                    <td class="gridline2"><input type='checkbox' class='case2'  name="AllCheckbox1" id="AllCheckbox1"value="All" onclick="CheckUnChecked2('FormName0','CustCheckboxr',document.FormName0.cntCheck2.value,this,'<?=$colCount?>');"  /></td>
                                <td class="gridline2" width="10px;"><input type='text' id='relSrno' name='relSrno[]'  style="width:0px;border:0px;">1</td>
                                <td class="gridline2" ><input type='text' id='courseatten' name='courseatten[]' style="width:150px"/></td>
                                <!--<td><input type='text' id='relqualiobtain' name='relqualiobtain[]' style="width:200px"/></td>-->
                                <td class="gridline2" ><input type="file" name="attFile[]" size="40" class="txtbox1"></td>                          
                                <td class="gridline2"><input type='text' id='relinstitution' name='relinstitution[]' style="width:150px"/></td>
                                <td class="gridline2"><input type='text' id='relfrom' name='relfrom[]' onkeypress="return isNumber(event)" maxlength="4"  style="width:90px"/></td>
                                <td class="gridline2"><input type='text' id='relto' name='relto[]' onkeypress="return isNumber(event)" maxlength="4" style="width:90px"/> </td>
                                
                     <?php } ?>
                            </tr>
                            <br/>
                            </table>

                            <input type="hidden" name="filename55" value="<?php echo  implode(',', $filename1_array); ?>" /> 
                            <tr>
                            <td height="10"></td></tr>
                            <tr>
                            <td>
                            <button type="button" id="delete1" class="button1"  onclick="return validateForm4();"    style="text-align:center;width:70px;"><b>  Delete</b></button>
                            </td>
                            </tr>
                             </td></tr>  
									<tr>
                                      <td height="55"></td>
                                      <td height="55"></td>
                                      <td height="55"></td>
									</tr>
									
									
									  <tr>
                                            <td colspan="3">
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                    <td valign="top" style="width:150px">Self Profile (to be typewritten)</td>
                                                    <td valign="top" width="10px">&nbsp;:&nbsp;</td>
                                                    <td valign="top"><textarea  tabindex="" id="selfprofile" name="selfprofile"  class="textarea1" style="height:120px;width:500px;"><?=$selfprofile?></textarea></td>
                                                </tr>
                                                
                                                  <tr>
													  <td height="15"></td>
												
												 </tr></table>
                                                 </td>
                                                 </tr>
																
                                        <tr>
                                            <td colspan="3">
                                               <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            	<tr>
										 <td align="left" class="TitleStyle" colspan="2"><b><i>MEDICAL & PERSONAL DECLARATION </i> </b></td>
									</tr>
                                              
                                                <tr>
                                      <td height="15"></td>
                                     
                                 </tr>
                                 <tr>
                                 <td>
                                            <p style="font-size:12px;"> Please answer the following questions and tick the appropriate box<br/>
                                            (the information declared will not automatically disqualify applicants from being shortlisted)</p></td></tr>

                                              <tr>
                                              <td width="82%">   <p style="font-size:13px;">1) Have you ever suffered, or are suffering from any medical history of pulmonary, nervous or mental health conditions,
                                               prolonged ill health,or impediment in speech or hearing or any physical impairment?
                                             </td>
                                             <td style="position: absolute;"><input type="radio"   tabindex="7" name="MpDeclaration1" value="Yes" <?=$MpDeclaration1=='Yes' || $MpDeclaration1 == ''?'checked="checked"':''?> />
                                              Yes
                                             <input type="radio"   tabindex="7" name="MpDeclaration1" value="No" <?=$MpDeclaration1=='No' ?'checked="checked"':''?> />
                                                No</td></tr>
                                   
                                            <tr>
                                            <td width="82%">   <p style="font-size:13px;">2) Have you ever been convicted in a court of law in Singapore or in any other country?
                                            </td>
                                            
                                            <td style="position: absolute;"><input type="radio"   tabindex="7" name="MpDeclaration2" value="Yes" <?=$MpDeclaration2=='Yes' || $MpDeclaration2 == ''?'checked="checked"':''?> />
                                              Yes
                                            <input type="radio"   tabindex="7" name="MpDeclaration2" value="No" <?=$MpDeclaration2=='No' ?'checked="checked"':''?> />
                                                No</td></tr>

                                                <tr>
                                            <td width="82%">   <p style="font-size:13px;">3) Have you ever been suspended, discharged or dismissed from the service by any employer?

                                                </td>
    
                                               <td style="position: absolute;"><input type="radio"   tabindex="7" name="MpDeclaration3" value="Yes" <?=$MpDeclaration3=='Yes' || $MpDeclaration3 == ''?'checked="checked"':''?> />
                                                Yes
                                                <input type="radio"   tabindex="7" name="MpDeclaration3" value="No" <?=$MpDeclaration3=='No' ?'checked="checked"':''?> />
                                                No</td></tr>

                                             <tr>
                                             <td width="82%">   <p style="font-size:13px;">4) Have you ever applied to be, or have been aOAS Trainer?

	                                          </td>
    
                                            <td style="position: absolute;"><input type="radio"   tabindex="7" name="MpDeclaration4" value="Yes" <?=$MpDeclaration4=='Yes' || $MpDeclaration4 == ''?'checked="checked"':''?> />
                                                Yes
                                                <input type="radio"   tabindex="7" name="MpDeclaration4" value="No" <?=$MpDeclaration4=='No' ?'checked="checked"':''?> />
                                                No</td></tr>                                       

                                                <tr>
                                                <td>  <p style="font-size:14px;">If your answer is “Yes” to any of the above, please provide brief factual information and documents <br/>(where relevant) 
                                                </tr>
                                                <tr>
                                                <td><textarea  tabindex="" id="AnswerOfYes" name="AnswerOfYes"  class="textarea1" style="height:80px;width:750px;"><?=$AnswerOfYes?></textarea></td></tr>
                                                <tr>
                                      <td height="15"></td>
                                     
                                 </tr>
                                </table></td></tr>
                                <tr>
                                <td>
                                    <table cellpadding="0" cellspacing="0" border="0" width="90%">
                                        <tr>
                                    <td align="left" class="TitleStyle" colspan="2"><b><i>	DECLARATION </i> </b></td>
									</tr>
                                    <tr>
                                      <td height="15"></td>
                                     
                                 </tr>
                                 <tr>
                                 <td>I declare that the particulars in this application are true, accurate and complete to the best of my knowledge and belief, and I have not wilfully suppressed any material fact.
                                </td>
                                </tr>
                                <tr>
                                <td height="55"></td>
                                     
                                 </tr>
                                 </table></td></tr>
                                 <tr>
                                 <td>
                                 
                                <table cellpadding="0" cellspacing="0" border="0" width="25%">
                                <tr>
                                <td><input type="text" tabindex="19" id="footersignature" name="footersignature" value="<?=$footersignature?>" class="txtbox1" style="width:250px;border:0" ></td></tr>

                                <tr>
                                   <td width="5%" style=" border-bottom:1.5px solid #000;" ></td>
                   
                                </tr></table>
                                </td></tr>
                                  <tr>
                                 <td>
                                 
                                <table cellpadding="0" cellspacing="0" border="0" width="25%"  style="float:right;margin-right: 10px;">
                                <tr>
                                <td><input type="text" tabindex="19" id="footerdate" name="footerdate" value="<?=$footerdate?>" class="txtbox1" style="width:250px;border:0" ></td></tr>

                                  <tr>
                                <td width="5%" style="border-bottom:1.5px solid #000;"></td>
                                
                                </tr></table>
                                <tr>
                                <td>
                                <table cellpadding="0" cellspacing="0"  width="25%">
                                <tr>
                                <td style="font-size:14px;">
                                Signature of Applicant</td></tr>
                                </table>
                                
                                <tr>
                                <td>
                                <table cellpadding="0" cellspacing="0"  width="25%"  style="float:right;">
                                <tr>
                                <td style="font-size:14px;">
                                Date</td></tr>
                                </table>
                                </td>
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

                                    
                                <input type="button" class="button1" name="btnBack" value="< Back" onclick="window.location='trainers.php?type=<?=encrypt($type,$Encrypt)?>'" />&nbsp;
                                <input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
                                    </td>
                                </tr>
                                    
                                    </table>
                                
                                </td>
                                 </tr> </table>

                                            
                                </table>
                                </td>
                                </tr>
                            </form>
                            </td>
                                </tr>
                            <? } ?>
                                <?php if($ctab==1){ ?>
                        
                            <form name="FormName1" method="post" action="">
                                          
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
                                                    <td valign="middle">Paid out income (past 1 month)</td>
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
                                            <td colspan="2" ><input type="hidden" name="cntCheck1" value="<?php echo $i-1; ?>" /></td>
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
                                            <input type="button" class="button1" name="btnBack" value="< Back" onclick="window.location='trainers.php?type=<?=encrypt($type,$Encrypt)?>'" />&nbsp;
                                          
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

<?php  
if($e_action == 'edit'){
    $a11 =  $total+1;
}else{

    $a11 = 2;
}
?>

<script>

 var k='<?php echo $a11;?>'

$("#addmore").on('click',function(){
    var data="<tr><td class='gridline2'><input type='checkbox' class='case'/></td><td class='gridline2'> <input type='text' id='srno' name='srno[]' value="+k+" style='width:15px;border:0px;'>"+"</td>";
    data +="<td class='gridline2'><input type='text' id='qualification"+k+"' name='qualification[]'   style='width:290px'/></td> <td class='gridline2'><input type='text' id='institution"+k+"' name='institution[]' style='width:290px'/></td><td class='gridline2'><input type='text' id='from"+k+"' name='from[]' onkeypress='return isNumber(event)' maxlength='4' style='width:90px'/></td><td class='gridline2'><input type='text' id='to"+k+"' name='to[]' onkeypress='return isNumber(event)' maxlength='4' style='width:90px'/></td></tr>";
	$('#demo123').append(data);
	k++;
});
</script>

<script>
function select_all() {
	$('input[class=case]:checkbox').each(function(){ 
		if($('input[class=check_all]:checkbox:checked').length == 0){ 
			$(this).prop("checked", false); 
		} else {
			$(this).prop("checked", true); 
		} 
	});
}

</script>

<?php  
if($e_action == 'edit') 
{
  $b11 =  $total33+1;;
}else{

    $b11 = 2;
}
?>

 <script>
 
var j='<?php echo $b11;?>';

$("#addmore1").on('click',function(){
    var data="<tr><td class='gridline2'><input type='checkbox' class='case'/></td><td class='gridline2'> <input type='text' id='relSrno' name='relSrno[]' value="+j+" style='width:15px;border:0px;'>"+"</td>";
    data +="<td class='gridline2'><input type='text' id='courseatten"+j+"' name='courseatten[]'   style='width:150px'/></td><td class='gridline2'> <input type='file' id='attFile"+j+"' name='attFile[]' size='40' class='txtbox1'></td> <td class='gridline2'><input type='text' id='relinstitution"+j+"' name='relinstitution[]' style='width:150px'/></td><td class='gridline2'><input type='text' id='relfrom"+j+"' name='relfrom[]' onkeypress='return isNumber(event)' maxlength='4' style='width:90px'/></td><td class='gridline2'><input type='text' id='relto"+j+"' name='relto[]' onkeypress='return isNumber(event)' maxlength='4' style='width:90px'/></td></tr>";
	$('#test123').append(data);
	j++;
});
</script>
<script>
$("#delete1").on('click', function() {
	$('.case:checkbox:checked').closest("tr").remove();

});
</script>




<script>
function select_all() {
	$('input[class=case]:checkbox').each(function(){ 
		if($('input[class=check_all]:checkbox:checked').length == 0){ 
			$(this).prop("checked", false); 
		} else {
			$(this).prop("checked", true); 
		} 
	});
}

</script>



<script>
function select_all2() {
	$('input[class=case2]:checkbox').each(function(){ 
		if($('input[class=check_all]:checkbox:checked').length == 0){ 
			$(this).prop("checked", false); 
		} else {
			$(this).prop("checked", true); 
		} 
	});
}

</script>