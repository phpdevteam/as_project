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
		
	$currentmenu = "Traing Venue";

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
	 $trainerrefno = $_GET['ownerno'];
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



	if($id != "" && $e_action == 'edit' && $ctab == '0')
	{
		
	$str = "SELECT _VenueRefNo,_Ownertitle,_FullName,_Nric,_HP,_Email,_Address,_MembershipCommenceDate,_Status,_MembershipStatus,_ReasonForSuspensionDelist FROM ".$tbname."_venueowners WHERE _ID = '".$id."' ";
		$rst = mysql_query("set names 'utf8';");	
		
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			
			$trainerrefno = replaceSpecialCharBack($rs["_VenueRefNo"]);
			$ownertitle = replaceSpecialCharBack($rs["_Ownertitle"]);	
			$ownername = $rs["_FullName"];
			$nric = replaceSpecialCharBack($rs["_Nric"]);
			$hp = replaceSpecialCharBack($rs["_HP"]);
			$email = replaceSpecialCharBack($rs["_Email"]);
            $memcommencDate1 =$rs["_MembershipCommenceDate"];
            $memcommencDate = date("d/m/Y", strtotime($memcommencDate1));
			$address = replaceSpecialCharBack($rs["_Address"]);
            $status = $rs["_Status"];   
			$trainerrefno12 = replaceSpecialCharBack($rs["_VenueRefNo"]);
            $membershipType = $rs["_MembershipStatus"];
            $reasonforsuspension = $rs["_ReasonForSuspensionDelist"];
			$btnSubmit = "Update";

            
		}
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
             var x1 = document.forms["FormName0"]["ownertitle"].value;
             var x5 = document.forms["FormName0"]["ownername"].value;
             var x2 = document.forms["FormName0"]["nric"].value;
             var x3 = document.forms["FormName0"]["email"].value;
             var x4 = document.forms["FormName0"]["hp"].value;
             var x6 = document.forms["FormName0"]["membershipstatus"].value;

            if (x1 == "") {
            alert("Please select in 'Owner Title'.\n");
            return false;
            }
    
            if (x5 == "") {
            alert("Please fill in 'Owner Name'.\n");
            return false;
            }
            if (x2 == "") {
            alert("Please fill in 'NRIC/FIN'.\n");
            return false;
            }
            if (x3== "") {
            alert("Please fill in 'Email'.\n");
            return false;
            }
                if (x4 == "") {
            alert("Please fill in 'HP'.\n");
            return false;
            }
            if (x6 == "") {
            alert("Please select in 'Membership Status'.\n");
            return false;
            }          


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
		
	
   
 function validateForm5()
 {
     if(!checkSelected('FormName5','CustCheckbox', document.FormName5.cntCheck.value))
     {
         alert("Please select at least one checkbox.");
         document.FormName5.AllCheckbox.focus();
         return false;
     }
     else
     {
         if(confirm('Are you sure you want to archive the selected Record(s)?'))
         {
             document.forms.FormName5.action = "venueschedule_action.php?id=<?=$id?>";
             document.forms.FormName5.submit();
         }
     }
 }//-->
	</script>

<script>

$(function () {
        $("input[name='chkPassPort1']").click(function () {
            if ($("#chkYes1").is(":checked")) {
                $("#dvPassport1").show();
                 $("#dvPassport12").hide();
            } else {
                   $("#dvPassport12").show();
                $("#dvPassport1").hide();
              
            }
        });
    });
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
                                        <tr><td height="5"></td></tr>
                                    </table>
                                   
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
                                                    echo "Add Owner";
                                                }
                                               if($ctab==0){ ?>
                                              > Basic Info
                                              <?php } ?>
                                              <?php if($ctab==1){ ?>
                                              > Training Venue Profile
                                              <?php } ?>
                                              <?php if($ctab==2){ ?>
                                              > Performance
                                              <?php }?>
                                               <?
                                              if($ctab==3){ ?>
                                              >Venue Schedule
                                              <?php } ?>
                                              </b></td><td align="right" style="padding-right:2px; vertical-align:bottom"> <a href="trainingspaces.php" class="TitleLink">List/Search Traning Venue</a>
                                              
											  
											  
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
                                    <td height="5"></td>
                                  </tr>
                                  </table>
                                  
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                    <td><div class="toptab">
                                        <ul>
                                        <li <?php if($ctab==0){ ?> style="background-color:#a9a9a9;" <?php } ?>>
                                            <?php if($id!=""){ ?>
                                            <a href="?ctab=<?=encrypt("0",$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>" style="text-decoration:none;">Basic Info</a>
                                            <?php }else{ ?>
                                            Basic Info
                                            <?php } ?>
                                          </li>
                                        <li <?php if($ctab==1){ ?> style="background-color:#a9a9a9;" <?php } ?>>
                                            <?php if($id!=""){ ?>
                                            <a href="?ctab=<?=encrypt("1",$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&ownerno=<?=encrypt($trainerrefno,$Encrypt)?>&ownername=<?=encrypt($companyname,$Encrypt)?>" style="text-decoration:none;">Training Venue Profile</a>
                                            <?php }else{ ?>
                                           Training Venue Profile
                                            <?php } ?>
                                          </li>
                                          <li <?php if($ctab==2){ ?> style="background-color:#a9a9a9;" <?php } ?>>
                                            <?php if($id!=""){ ?>
                                            <a href="?ctab=<?=encrypt("2",$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&ownerno=<?=encrypt($trainerrefno,$Encrypt)?>" style="text-decoration:none;">Performance</a>
                                            <?php }else{ ?>
                                            Performance
                                            <?php } ?>
                                          </li>
                                          
                                            <li <?php if($ctab==3){ ?> style="background-color:#a9a9a9;" <?php } ?>>
                                            <?php if($id!=""){ ?>
                                            <a href="?ctab=<?=encrypt("3",$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&ownerno=<?=encrypt($trainerrefno,$Encrypt)?>" style="text-decoration:none;">Venue Schedule </a>
                                            <?php }else{ ?>
                                         Venue Schedule
                                            <?php } ?>
                                          </li>
										  
										    <li <?php if($ctab==4){ ?> style="background-color:#a9a9a9;" <?php } ?>>
                                            <?php if($id!=""){ ?>
                                            <a href="?ctab=<?=encrypt("4",$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&ownerno=<?=encrypt($trainerrefno,$Encrypt)?>" style="text-decoration:none;">Venue Wallet </a>
                                            <?php }else{ ?>
                                                Venue Wallet 
                                            <?php } ?>
                                          </li>
                                           
                                        
                                   <!--    <li> <?php if($ctab==4 ){ ?> style="background-color:#a9a9a9;" <?php } ?>>
                                        
                                          <?php if($id!=""){ ?>
                                          <a href="?ctab=<?=encrypt('4',$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>" style="text-decoration:none;">Pdts/Svcs Warranty History</a>
										  <?php }else{ ?>Pdts/Svcs Warranty History<?php } ?></li>-->
                                                  
                                      </ul>
                                      </div></td>
                                  </tr>
                                  
                                  
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
                                    <td><?php if($ctab==0){ ?>
                                        <form name="FormName0" action="trainingspaces_action.php"  method="post" onsubmit="return validateForm0();" enctype="multipart/form-data">
                                        <input type="hidden" id="id" name="id" value="<?=$id?>" />
                                        <input type="hidden" id="ownerno" name="ownerno" value="<?=$trainerrefno?>" />
                                        <input type="hidden" name="e_action" value="<?=($e_action == "" ? "addnew" : "edit")?>" />
                                        <input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
                                        <input type="hidden" name="ctab" value="<?=$ctab?>" />
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                          <tr>
                                          <td valign="top">
                                              
                                           <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                          <tr>
                                      <td height="15"></td>
                                      <td height="15"></td>
                                      <td height="15"></td>
                                 </tr>
                                            <tr>
                                                <td  valign="middle" width="150px">Owner Title</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                                <? $str = "SELECT _id,_salutation FROM ".$tbname."_salutation ORDER BY _id";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="ownertitle" id="ownertitle" class="dropdown1  chosen-select">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_salutation"]; ?>" <?php if($rs["_salutation"] == $ownertitle) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_salutation"]; ?>&nbsp;</option>
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
                                                <td valign="middle">Owner Full Name </td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="2" id="ownername" name="ownername" value="<?=$ownername?>" class="txtbox1" style="width:250px;"/>
												<span class="detail_red">*</span></td>
                                            </tr>
                                             <tr>
                                        <td height="5"></td>
                                        <td height="5"></td>
                                        <td height="5"></td>
                                                </tr>
                                                <tr>
                                                <td  valign="middle">NRIC/FIN </td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="3" id="nric" name="nric" value="<?=$nric?>" class="txtbox1" style="width:250px;"/></td>
                                            </tr>
                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                                <tr>
                                                <td  valign="middle">Email</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td  valign="middle"><input type="text" tabindex="4" id="email" name="email" value="<?=$email?>" class="txtbox1" style="width:250px;"/></td>
                                            </tr>
                                            
                                          
                                             
                                               <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                             </tr>
                                         
                                             <tr>
                                                <td valign="middle">HP</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle" ><input type="text" tabindex="12" id="hp" name="hp" value="<?=$hp?>" class="txtbox1" style="width:250px;">
												<span class="detail_red">*</span></td>
                                            </tr>
                                            
                                             <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                            </tr>

                                                 <tr>
                                                <td valign="middle">Address</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle" ><input type="text" tabindex="12" id="address" name="address" value="<?=$address?>" class="txtbox1" style="width:250px;">
												<span class="detail_red">*</span></td>
                                            </tr>
                                            <tr>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                        </tr>
                                              <tr>
                                            <td valign="middle" style="width:150px">Membership Commencement date</td>
                                            <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                            <td valign="middle"><input type="text" tabindex="" id="memcommencDate" name="memcommencDate" value="<?=$memcommencDate == ""?date('d/m/Y'):$memcommencDate?>" size="60" class="txtbox1 datepicker" style="width: 160px;">   <b> (DD/MM/YYYY)</b></td>
                                            </tr>
                                         
                                            <tr>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                        </tr>


                                         <tr>
                                         <td  valign="middle">Membership Status</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td  valign="middle"> <? $str = "SELECT _ID,_MembershipType FROM ".$tbname."_membershipstatus ORDER BY _ID";
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
                                                </select><span class="detail_red">*</span></td>
                                         </tr>
                                         <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                         <tr>
                                        
                                                  <td  valign="middle">Reason for Suspension /<br/> De-list	</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><textarea  tabindex="" id="reasonforsuspension" name="reasonforsuspension"  class="textarea1" style="height:70px;"><?=$reasonforsuspension?></textarea>
                                            
                                                </td>
                                               
                                         </tr>
								 
                                            </table>
                                          
                                          </td>
                                          
                                          <td width="30px"></td>
                                          
                                          <td valign="top" align="right">
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tbllabel">

                                            <tr>
                                      <td height="15"></td>
                                      <td height="15"></td>
                                      <td height="15"></td>
                                 </tr>
                                              <tr>
                                                <td valign="middle" width="150px">VO Ref ID</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                 <td valign="middle"><input type="text" tabindex="" autocomplete="off" id="trainingvenuerefno" name="trainingvenuerefno" value="<?=$trainerrefno?>" class="txtlabel" readonly="readonly" style="width:250px;font-size: 9pt;"></td>
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
                                      <td height="15"></td>
                                      <td height="15"></td>
                                      <td height="15"></td>
                                 </tr>
								 <!--********************-->
								
                                          </table>
                                          </td>
                                          
                                          </tr>
                                          
                                                
                                                
                                                <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                          
                                            <tr>
                                            <td valign="top" colspan="2"></td>
                                                    
                                             <td align="left" >
                                            <input type="button" class="button1" name="btnBack" value="< Back" onclick="window.location='trainingspaces.php?type=<?=encrypt($type,$Encrypt)?>'" />&nbsp;
                                            <input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
                                                </td>
                                          </tr>
                                                
                                                </table>
                                            </td>
                                          </tr>
                                          
                                            
                                          </table>
                                      </form>
                                        <? } ?>
                                        <?php if($ctab==1){ ?>
                                        <?php
                                                    $sortBy 		= trim($_GET["sortBy"]);
                                                    $sortArrange	= trim($_GET["sortArrange"]);
                                                    
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
                                                    $Rowcolor = "gridline1";
                                                    
                                                    $str1 = "SELECT v.*,vo._FullName,vc._VenueCatName,vt._VenueTypeName,m._MembershipType,u._Fname FROM ".$tbname."_venues v  LEFT JOIN  ".$tbname."_venueowners vo ON v._OwnerID = vo._ID 
											LEFT JOIN  ".$tbname."_venuecat vc ON v._VenueCat = vc._ID  
											LEFT JOIN  ".$tbname."_venuetype vt ON v._VenueType = vt._ID 
											LEFT JOIN  ".$tbname."_membershipstatus m ON v._membershipStatus = m._ID  
                                            LEFT JOIN  ".$tbname."_user u ON v._CreatedBy = u._ID  
								                  where  v._OwnerID = '".$id."' ";	

                                               
                                                    
                                                    if (trim($sortBy) != "" && trim($sortArrange) != "")
                                                        $str2 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
                                                    else
                                                        $str2 = $str1 . " ORDER BY v._ID LIMIT $StartRow,$PageSize ";
                                                   
                                                 //echo $str1;
                                                    $TRecord = mysql_query($str1, $connect);
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
                                                    ?>
                                        <form name="FormName1" method="post" action="">
                                        <?php 

                                             $trainerrefno11 = $_GET['ownerno'];
                                                ?>
                                            <table  cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                            <td height="5" colspan="3"><b><?=$ownername?> (<?=$trainerrefno11?>)</b></td>
                                          </tr>
                                            <tr>
                                           
                                          </tr>
                                            <tr>
                                            <td colspan="1" class="pageno"><?php
                                                  $QureyUrl = "&amp;ctab=".encrypt($ctab,$Encrypt)."&amp;id=".encrypt($id,$Encrypt)."&amp;sortBy=".encrypt($sortBy,$Encrypt)."&amp;sortArrange=".encrypt($sortArrange,$Encrypt);
                                                  $QureyUrl2 = "&amp;ctab=".encrypt($ctab,$Encrypt)."&amp;id=".encrypt($id,$Encrypt);
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
              
                                              if (trim($sortArrange) == "DESC")
                                                  $sortArrange = "ASC";
                                              elseif (trim($sortArrange) == "ASC")
                                                  $sortArrange = "DESC";
                                              else
                                                  $sortArrange = "DESC";
                                              ?></td>
                                              <?php
                                              if ($RecordCount > 0)
                                                  {
                                                  ?>
                                            <td><div align="right" style="padding-right:10px; vertical-align:bottom"><?php print "$RecordCount record(s) founds - You are at page $PageNo  of $MaxPage"; ?></div></td>
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
                                                <input type="button" class="button1" name="btnSubmit2" value="Delete" onclick="return validateForm1();" style="width:100px;" />
                                                </td>
                                            <?
                                                }
                                           
                                            ?>
                                            <td align="right" style="padding-right:10px; vertical-align:bottom"><a href="venue.php?oid=<?=encrypt($id,$Encrypt)?>&ownerref=<?=encrypt($trainerrefno,$Encrypt)?>" class="TitleLink">Add Training Venue</a></td>
                                          </tr>
                                          
                                          
                                           <tr>
                                            <td colspan="2" height="5"></td>
                                          </tr>
                                            
                                            <tr>
                                            <td colspan="2"><table cellspacing="0" cellpadding="0" width="100%" border="0" class="grid" >
                                                <tr>
                                                <td class="gridheader" align="center"><input name="AllCheckbox" id="AllCheckbox" type="checkbox"   tabindex="" value="All" onclick="CheckUnChecked('FormName1','CustCheckbox',document.FormName1.cntCheck.value,this,'12');" /></td>
                                                <td class="gridheader" align="center">No.</td>
                                                <td class="gridheader">&nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_TraningVenuNo',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt).$QureyUrl2?>" class="link1">Traning Venue Owner<br/> Ref Number</a></td>
                                                <td class="gridheader" align="center">&nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_VenueName',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt).$QureyUrl2?>" class="link1">Traning Venue Name</a></td>
                                                <td class="gridheader" align="center">&nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_VenueCatName',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt).$QureyUrl2?>" class="link1">Venue Category</a></td>
                                                <td class="gridheader">&nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_VenueTypeName',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt).$QureyUrl2?>" class="link1"> Venue Type</a></td>
                                                <td class="gridheader" align="center">&nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_DefaultVenue',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt).$QureyUrl2?>" class="link1">Default ?</a></td>                                              
                                                <td class="gridheader" align="center">&nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_CreatedBy',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt).$QureyUrl2?>" class="link1">Submitted By</a></td>
												  <td class="gridheader" align="center">&nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_CreatedDateTime',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt).$QureyUrl2?>" class="link1">Submitted Date</a></td>

                                                <td class="gridheader">&nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_Status',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt).$QureyUrl2?>" class="link1">System Status</a></td>
        
                                                <td class="gridheader" align="center">Edit</td>
                                              </tr>
                                                <?php
                                                                        if ($RecordCount > 0) {
                                                                        $i = 1;											
                                                                        while($rs = mysql_fetch_assoc($result))
                                                                        {
                                                                            
                                                                                $trainerrefno11 =  $rs["_TraningVenuNo"];
                                                                         
                                                                            $bil = $i + ($PageNo-1)*$PageSize;	
                                                                            if  ($Rowcolor == "gridline2")
                                                                                $Rowcolor = "gridline1";
                                                                            else
                                                                                $Rowcolor = "gridline2";
                                                                                
                                                                             if ($rs["_defaultuser"] == 1 && $ctab =="1") {
                                                                                    $Rowcolor = "graycolorrow";
                                                                                }
                                                                            
                                                                            ?>
                                                <tr class="clickableRow" href="venue.php?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;id=<?=encrypt($rs["_ID"],$Encrypt)?>&amp;cid=<?=encrypt($id,$Encrypt)?>&amp;e_action=<?=encrypt('edit',$Encrypt)?>&amp;type=<?=encrypt('cu',$Encrypt)?>" style="cursor:pointer" >
                                                <td id="Row1ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">
                                                <input name="CustCheckbox<?php echo $i; ?>" type="checkbox"   tabindex="" value="<?php echo $rs["_ID"]; ?>" onclick="setActivities(this.form.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>','12');" /></td>
                                                <td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
                                                <td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center"><?php echo $rs["_TraningVenuNo"] ?></td>
                                                <td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left"><?php echo $rs["_VenueName"] ?></td>
                                                <td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?php echo $rs["_VenueCatName"] ?></td>
                                                <td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?=$rs["_VenueTypeName"]?></td>
                                                <td id="Row7ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?= ($rs['_DefaultVenue'] == '1' ? 'Yes' : 'No')?></td>
                                                <td id="Row8ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?=$rs["_Fname"]?></td>
                                                <td id="Row9ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left"><?= $createdate = date("d/m/Y", strtotime($rs["_CreatedDateTime"]))?> </td>
                                                <td id="Row10ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" ><?= ($rs['_Status'] == '1' ? 'Live' : 'Archive')?></td>          
                                               
                                                <td id="Row12ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<a href="venue.php?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;id=<?=encrypt($rs["_ID"],$Encrypt)?>&amp;ownerid=<?=encrypt($id,$Encrypt)?>&amp;e_action=<?=encrypt('edit',$Encrypt)?>" class="TitleLink">Edit</a>&nbsp;</td>
                                              </tr>
                                                <?php
                                                                            $i++;
                                                                            }
                                                                        } else {
                                                                            echo "<tr><td colspan='11' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
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
                                                <input type="button" class="button1" name="btnSubmit2" value="Delete" onclick="return validateForm1();" style="width:100px;" />                                        </td>
                                            <?
                                                                    }
                                                             
                                                                ?>
                                            <td align="right" style="padding-right:10px; vertical-align:bottom"><a href="venue.php?oid=<?=encrypt($id,$Encrypt)?>&ownerref=<?=encrypt($trainerrefno,$Encrypt)?>" class="TitleLink">Add Training Venue</a></td>
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
                                          </table>
                                        </form>
                                        <?php } ?>
                                        <?php if($ctab==2){ ?>
                                        <?php
                                          $sortBy 		= trim($_GET["sortBy"]);
                                          $sortArrange	= trim($_GET["sortArrange"]);
                                          
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
                                          $Rowcolor = "gridline1";
										  
									/*	  $str = "SELECT *,concat_ws(',',_address1,_address2,_address3) as _contactaddress FROM ".$tbname."_customer  WHERE _ID = '".$id."' ";
											$rst = mysql_query("set names 'utf8';");	
											$rst = mysql_query($str, $connect);
											if(mysql_num_rows($rst) > 0)
											{
												$rs = mysql_fetch_assoc($rst);
												
									
												$customerno = $rs["_customerid"];		
												$companyname = replaceSpecialCharBack($rs["_companyname"]);
									
											}
                                          
                                          $str1 = "select ch.*,date_format(ch._date,'%d/%m/%Y') as _date
                                                  from ".$tbname."_correshistory ch where  _customerid = '".$id."' ";	
                                          
                                          
                                          if (trim($sortBy) != "" && trim($sortArrange) != "")
                                              $str2 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
                                          else
                                              $str2 = $str1 . " ORDER BY _ID LIMIT $StartRow,$PageSize ";
                                                                          
                                          $TRecord = mysql_query($str1, $connect);
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
                                          }*/
                                          ?>
                                        <form name="FormName2" method="post" action="">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                        <!-- <td height="5" colspan="3"><b><?=$ownername?> (<?=$trainerrefno?>)</b></td>-->
                                          </tr>
                                            
                                          
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


                                        <?php if($ctab==3){ ?>
                                                    <?php


                                                    $trainerrefno22 = $_GET['ownerno'];
                                                    $id = $_GET['id'];
                                                    $sortBy 		= trim($_GET["sortBy"]);
                                                    $sortArrange	= trim($_GET["sortArrange"]);

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
                                                    $Rowcolor = "gridline1";
                                                    $str1 = "SELECT  ve.*,p._ProgramName FROM ".$tbname."_venueavailableslot ve  LEFT JOIN  ".$tbname."_trainingprogram p ON ve._ProgramID = p._ID 
                                                    
                                                          where ve._Status= '1' AND   ve._VenueID = '".$id."' ";	
                                   
                                                            if (trim($sortBy) != "" && trim($sortArrange) != "")
                                                                $str2 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
                                                            else
                                                                $str2 = $str1 . " ORDER BY ve._ID LIMIT $StartRow,$PageSize ";
                                                           
                                                         //echo $str1;
                                                            $TRecord = mysql_query($str1, $connect);
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
                                                    ?>
                                                    <form name="FormName5" method="post" action="" >
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
                                                      
                                                            if ($_GET["done"] == 4)
                                                            {
                                                                echo "<div align='left'><font color='#FF0000'>Record is existed in the system. Please enter another record.<br></font></div>";
                                                            }
                                                        ?></td></tr>
                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                         
                                                            <tr><td colspan="3"><b>(<?=$trainerrefno22?> )<?php echo $trainerrefno12;?></b></td></tr>
                                                            <tr><td height="5"></td></tr>
                                                            <tr>
                                                                <td colspan="1" class="pageno">
                                                                
                                                                <?php
                                                                    $QureyUrl = "&amp;ctab=".encrypt($ctab,$Encrypt)."&amp;id=".encrypt($id,$Encrypt)."&amp;sortBy=".encrypt($sortBy,$Encrypt)."&amp;sortArrange=".encrypt($sortArrange,$Encrypt);
                                                                    $QureyUrl2 = "&amp;ctab=".encrypt($ctab,$Encrypt)."&amp;id=".encrypt($id,$Encrypt);
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
                                
                                                                if (trim($sortArrange) == "DESC")
                                                                    $sortArrange = "ASC";
                                                                elseif (trim($sortArrange) == "ASC")
                                                                    $sortArrange = "DESC";
                                                                else
                                                                    $sortArrange = "DESC";
                                                                ?>
                                                                </td>
                                                                <?php
                                                                if ($RecordCount > 0)
                                                                    {
                                                                    ?>
                                                                <td><div align="right"><?php print "$RecordCount record(s) founds - You are at page $PageNo  of $MaxPage"; ?></div></td>
                                                                <?php } ?>
                                                            </tr>
                                                            
                                                                
                                                            <tr><td colspan="2" height="5"><input type="hidden" name="e_action" value="delete" /></td></tr>
                                                            <tr>
                                                                <td align="left">
                                                            
                                                                <?
                                                               
                                                                    if ($RecordCount > 0)
                                                                    {
                                                                ?>
                                                                
                                                                <input type="button" class="button1" name="btnSubmit2" value="Archive" onclick="return validateForm5();" style="width:100px;" /></td>
                                                                <?
                                                                    }
                                                               
                                                                ?>
                                                                <td align="right">	
                                                                                    
                                                                <a href="venueschedule.php?vid=<?=encrypt($id,$Encrypt)?>" class="TitleLink">Add New</a>

                                                                    
                                                                
                                                                </td>
                                                            </tr>
                                                            <tr><td colspan="2" height="5"></td></tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <table cellspacing="0" cellpadding="3" width="100%" border="0" class="grid" >
                                                                        <tr>
                                                                        <td class="gridheader" align="center"><input name="AllCheckbox" id="AllCheckbox" type="checkbox"   tabindex="" value="All" onclick="CheckUnChecked('FormName1','CustCheckbox',document.FormName1.cntCheck.value,this,'12');" /></td>
                                                                            <td class="gridheader" align="center">No.</td>
                                                                            
                                                                            <td class="gridheader"  width ="150px"  align="center">
                                                                                &nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_ProgramName',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt).$QureyUrl2?>" class="link1">Program Name</a>
                                                                            </td>
                                                                            <td class="gridheader" width ="120px"  align="center">
                                                                                &nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_Date',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt).$QureyUrl2?>" class="link1" > Date</a>
                                                                            </td>
                                                                           
                                                                           
                                                                            <td class="gridheader" width ="100px" align="center">
                                                                                &nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_StartTime',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt).$QureyUrl2?>" class="link1">Time From</a>
                                                                            </td>
                                                                            <td class="gridheader"  width ="100px" align="center">
                                                                                &nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_EndTime',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt).$QureyUrl2?>" class="link1">Time To</a>
                                                                            </td>
                                                                            <td class="gridheader"  width ="100px" align="center">
                                                                                &nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_ProgramID',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt).$QureyUrl2?>" class="link1"> Submitted By </a>
                                                                            </td>
                                                                            <td class="gridheader" align="center">
                                                                                &nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_CreatedDateTime',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt).$QureyUrl2?>" class="link1"> Submitted Date</a>
                                                                            </td>
                                                                            <td class="gridheader" align="center">
                                                                                &nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_Status',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt).$QureyUrl2?>" class="link1"> System Status</a>
                                                                            </td>
                                                                           
                                                                            <td class="gridheader" align="center">Edit</td>
                                                                            
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
                                                                                
                                                                             if ($id == $rs["_ID"] && $ctab =="2") {
                                                                                    $Rowcolor = "gridline3";
                                                                                }
                                                                            
                                                                            ?>
                                                                           <tr class="clickableRow" href="trainerschedule.php?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;id=<?=encrypt($rs["_ID"],$Encrypt)?>&amp;trainername=<?=encrypt($trainername,$Encrypt)?>&amp;e_action=<?=encrypt('edit',$Encrypt)?>&amp;type=<?=encrypt('cu',$Encrypt)?>" style="cursor:pointer" >
                                                                           <td id="Row1ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">
                                                                           <input name="CustCheckbox<?php echo $i; ?>" type="checkbox"   tabindex="" value="<?php echo $rs["_ID"]; ?>" onclick="setActivities(this.form.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>','12');" /></td>
                                                                                
                                                                              
                                                                                <td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
                                                                                <td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center"><?=replaceSpecialCharBack($rs['_ProgramName'])?></td>
                                                                                <td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center"><?php echo mysqlToDatepicker($rs["_Date"]) ?></td>
                                                                                <td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?php echo $rs["_StartTime"] ?></td>
                                                                                <td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?php echo $rs["_EndTime"] ?></td>
                                                                                <td id="Row7ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?= $_SESSION['user']?></td>
                                                                                                            
                                                                                <td id="Row8ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center"><?= $createdate = date("d/m/Y", strtotime($rs["_CreatedDateTime"]))?> </td>
                                                                                <td id="Row9ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" ><?= ($rs['_Status'] == '1' ? 'Live' : 'Archive')?></td>          
                                                                               
                                                                                <td id="Row10ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<a href="venueschedule.php?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;id=<?=encrypt($rs["_ID"],$Encrypt)?>&amp;e_action=<?=encrypt('edit',$Encrypt)?>" class="TitleLink">Edit</a>&nbsp;</td>
                                                                              </tr>
                                                                            <?php
                                                                            $i++;
                                                                            }
                                                                        } else {
                                                                            echo "<tr><td colspan='8' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
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
                                                                
                                                                <input type="button" class="button1" name="btnSubmit2" value="Archive" onclick="return validateForm5();" style="width:100px;" /></td>
                                                                 <?
                                                                    }                                                     
                                                                ?>
                                                                <td align="right"> 
                                                                    
                                                                    <a href="<?php echo $sales_page_name; ?>.php" class="TitleLink">Add New</a>
                                                                                                  
                                                                </td>
                                                            </tr>								
                                                            <tr><td colspan="2" height="5"><input type="hidden" name="cntCheck" value="<?php echo $i-1; ?>" /></td></tr>
                                                            <tr>
                                                                <td colspan="1" class="pageno">
                                                                
                                                                <?php
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
                                                                ?>
                                                                </td>
                                                                
                                                            </tr>
                                                        <tr><td>&nbsp;</td></tr>	
                                                        </table>
                                                        </form>
                                                       
                                                    <?php } ?>
								
                                                    <?php if($ctab==4){ ?>

                                            <?php
                                                    $sortBy 		= trim($_GET["sortBy"]);
                                                    $sortArrange	= trim($_GET["sortArrange"]);

                                                    
                                                    $trainerid = $_GET['id'];
                                                    $trainername  = $_GET['trainername'];
                                                            
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
                                                    $Rowcolor = "gridline1";
                                                    
                                            $str1 = "SELECT  ta.*,p._ProgramName FROM ".$tbname."_trainersavailableslot ta  LEFT JOIN  ".$tbname."_trainingprogram p ON ta._ProgramID = p._ID 
											
								                  where ta._Status= '1' AND   ta._TrainerID = '".$trainerid."' ";	


                                              
                                                    
                                                    if (trim($sortBy) != "" && trim($sortArrange) != "")
                                                        $str2 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
                                                    else
                                                        $str2 = $str1 . " ORDER BY ta._ID LIMIT $StartRow,$PageSize ";
                                                   
                                                 //echo $str1;
                                                   // $TRecord = mysql_query($str1, $connect);
                                                  //  $result = mysql_query($str2, $connect);
                                                    
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
                                        <form name="FormName5" method="post" action="">

                                        <?php 

                                                $trainerid = $_GET['id'];
                                                $trainername  = $_GET['trainername'];
                                 
                                                ?>
                                            <table  cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                           <td height="5"></td>
                                           </tr>

                                            <tr>
                                            <td height="5" colspan="3"><b>My Wallet</b></td>
                                          </tr>
                                           
                                             <tr>
                                           <td height="15"></td>
                                           </tr>
                                           <tr>
                                            <td height="5" colspan="3">Outstanding  Amount : $ <input type="text" tabindex="1" id="outstandingamount" name="outstandingamount" value="<?=$outstandingamount?>" class="txtbox1" style="width:80px;padding:3px;" /></td>
                                         </tr>

                                         <tr>
                                           <td height="15"></td>
                                           </tr>
                                           <tr>
                                           <td>
                                           <?php    
 
                                                    $sel_status_y = "";
                                                    $sel_status_n = "";
                                                    if($mng_perflag == 'Yes'){
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
                                         <input type="radio"   tabindex="9" <?php echo $sel_status_y; ?> name="chkPassPort1" value="Yes" id="chkYes1"  /> &nbsp;&nbsp;Payment Summary(Past 3 Months)&nbsp;&nbsp;&nbsp;&nbsp;
                                          <input type="radio"   tabindex="9" <?php echo $sel_status_n; ?> name="chkPassPort1" value="No" id="chkNo1"  /> &nbsp;&nbsp;Current Payment Activities
                                            </td>
                                            </tr></table>


                                                   
                                            <div id="dvPassport1"  <?php if($mng_perflag == 'Yes' OR $mng_perflag =='') { ?>  style="display:block";   <?php } else  { ?>   style="display:none";  <?php } ?>>

                                                     
                                            <table  cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                           <td height="15"></td>
                                           </tr>
                                            <tr>
                                            <td height="5" colspan="3"><b>Payment Summary(Past 3 Months)</b></td>
                                          </tr>
                                          <tr>
                                           <td height="15"></td>
                                           </tr>
                                          <tr>
                                                       
                                                        <td class="gridheader" width="30" align="center">No.</td>
                                                      
                                                        <td class="gridheader" width="200" align="center">
                                                            &nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_ProgramName<?=$ExtraUrl?>" class="link1">Payment Peroid Monthly</a>
                                                        </td>
                                                       
                                                        <td class="gridheader" width="100" align="center">
                                                            &nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_ProgramCatName<?=$ExtraUrl?>" class="link1">Amount</a>
														</td>
														<td class="gridheader" width="130" align="center">
                                                            &nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_TypeName<?=$ExtraUrl?>" class="link1">Payment Status</a>
														</td>
													  
                                                        <td class="gridheader datecolumn"  width="50" align="center">
															<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_TotalAmount<?=$ExtraUrl?>" class="link1">
                                                            &nbsp;Payment Due Date</a>
                                                        </td>
                                                        <td class="gridheader datecolumn"  width="50" align="center">
															<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_TotalAmount<?=$ExtraUrl?>" class="link1">
                                                            &nbsp;View Details</a>
                                                        </td>

                                          </table>


                                               </div>



                                               
<div id="dvPassport12"  <?php if( $mng_perflag =='No') { ?>  style="display:block";   <?php } else  { ?>   style="display:none";  <?php } ?>>
                                            <table  cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                           <td height="15"></td>
                                           </tr>
                                            <tr>
                                            <td height="5" colspan="3"><b> Current Payment Activities</b></td>
                                          </tr>
                                          <tr>
                                           <td height="15"></td>
                                           </tr>
                                           <tr>

                                          <td class="gridheader" width="30" align="center">No.</td>
                                                      
                                                        <td class="gridheader" width="150" align="center">
                                                            &nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_ProgramName<?=$ExtraUrl?>" class="link1">Date</a>
                                                        </td>
                                                       
                                                        <td class="gridheader" width="100" align="center">
                                                            &nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_ProgramCatName<?=$ExtraUrl?>" class="link1">Time</a>
														</td>
														<td class="gridheader" width="130" align="center">
                                                            &nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_TypeName<?=$ExtraUrl?>" class="link1">Pament Type</a>
														</td>
													  
                                                        <td class="gridheader datecolumn"  width="50" align="center">
															<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_TotalAmount<?=$ExtraUrl?>" class="link1">
                                                            &nbsp;Program</a>
                                                        </td>
                                                        <td class="gridheader datecolumn"  width="50" align="center">
															<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_TotalAmount<?=$ExtraUrl?>" class="link1">
                                                            &nbsp;Venue</a>
                                                        </td>
                                                        <td class="gridheader datecolumn"  width="50" align="center">
															<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_TotalAmount<?=$ExtraUrl?>" class="link1">
                                                            &nbsp;No Of Participant Fee</a>
                                                        </td>
                                                        <td class="gridheader datecolumn"  width="50" align="center">
															<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_TotalAmount<?=$ExtraUrl?>" class="link1">
                                                            &nbsp;Payment Mode</a>
                                                        </td>
                                                        <td class="gridheader datecolumn"  width="50" align="center">
															<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_TotalAmount<?=$ExtraUrl?>" class="link1">
                                                            &nbsp;Venue Fee</a>
                                                        </td>

</tr>






                                          </table>

</div>






                                        </table>
                                        </form>

                                        <?php } ?>
                                       <?php 
                                        if($ctab==5){
                            
                                    $sortBy 		= trim($_GET["sortBy"]);
                                    $sortArrange	= trim($_GET["sortArrange"]);                                   
                                    $Keywords 		= trim($_GET["Keywords"]);                                   
                                    $toDate         = trim($_GET['toDate']);
                                    $fromDate       = trim($_GET['fromDate']);                                   
                                    $jobNo          = trim($_GET['jobNo']);                                  
                                    $companyName    = $_GET["companyName"];	
                                    $customerID     = $_GET["customerID"];
                                    $phone          = ($_REQUEST['customerID']);
                                    $priority       = ($_REQUEST['priority']);
                                    $date           = ($_REQUEST['date']);
                                    $chargable      = ($_REQUEST['chargable']);
                                    $tnc            = ($_REQUEST['tnc']);
                                    $remarks        = ($_REQUEST['remarks']);
                                    $maintenanceContractNo = ($_REQUEST['maintenanceContractNo']);
                                    $systemStatus    = ($_REQUEST['systemStatus']);
                                    $personInCharge  = ($_REQUEST['personInCharge']);
                                    $personInChargeContact = ($_REQUEST['personInChargeContact']);
                                    
                                
                                    if($SearchBy=="AdvSearch")
                                        $Keywords = "";
        
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
                                    $Rowcolor = "gridline1";
                                    
                                
                                    $str1 = "SELECT sq.*, qt._Fullname AS _createdperson, com._companyname, _mcno FROM ".$tbname."_jobsheets sq 
                                    LEFT JOIN ".$tbname."_user qt ON qt._ID = sq._createdby 
                                    LEFT JOIN ".$tbname."_customer com ON com._ID = sq._customerid  
                                    LEFT JOIN ".$tbname."_maintenancecontract mc ON mc._id = sq._maintenancecontractno 
                                    WHERE sq._status = 'Live'  ";
                                    
                                    
                                    if($Keywords!="")
                                    {
                                        $str1 = $str1 . " AND (_jobno LIKE '%".replaceSpecialChar($Keywords)."%' ";
                                                                    
                                        $str1 = $str1 . " OR _maintenancecontractno LIKE '".replaceSpecialChar($Keywords)."' ";
                                        
                                        $str1 = $str1 . " OR _reportdate = '".replaceSpecialChar($Keywords)."' ";
                                        
                                        $str1 = $str1 . " OR _status LIKE '%".replaceSpecialChar($Keywords)."%' ";
                                        
                                        $str1 = $str1 . " OR _personincharge LIKE '%".replaceSpecialChar($Keywords)."%' ";
                                        
                                        $str1 = $str1 . " OR _personinchargecontact LIKE '%".replaceSpecialChar($Keywords)."%' ";
                                        
                                        $str1 = $str1 . " OR _phone LIKE '%".replaceSpecialChar($Keywords)."%' ";
                                        
                                        $str1 = $str1 . " OR _date LIKE '%".replaceSpecialChar($Keywords)."%' ";
                                        
                                        $str1 = $str1 . " OR _priority LIKE '%".replaceSpecialChar($Keywords)."%' ";
                                        
                                        $str1 = $str1 . " OR _chargeable LIKE '%".replaceSpecialChar($Keywords)."%' ";
                                        
                                        $str1 = $str1 . " OR sq._remarks LIKE '%".replaceSpecialChar($Keywords)."%' ";
                                        
                                        $str1 = $str1 . " OR _tnc LIKE '%".replaceSpecialChar($Keywords)."%' ) ";
                                        
                                    }else
                                    {
                                        if ($jobNo != "") $str1 = $str1 . " AND _jobno LIKE '%".replaceSpecialChar($jobNo)."%' ";
                                        
                                        if ($fromDate != "" && $toDate == "") $str1 = $str1 . " AND date(_reportdate) >= '".date("Y-m-d",strtotime(replaceSpecialChar($fromDate)))."' ";
                                        if ($fromDate == "" && $toDate != "") $str1 = $str1 . " AND date(_reportdate) <= '".date("Y-m-d",strtotime(replaceSpecialChar($toDate)))."' ";
                                        if ($fromDate != "" && $toDate != "") $str1 = $str1 . " AND (date(_reportdate) >= '".date("Y-m-d",strtotime(replaceSpecialChar($fromDate)))."' AND date(_reportdate) <= '".date("Y-m-d",strtotime(replaceSpecialChar($toDate)))."') ";
                                                                    
                                        if ($maintenanceContractNo != "") $str1 = $str1 . " AND _maintenancecontractno LIKE '".replaceSpecialChar($maintenanceContractNo)."' ";
                                        
                                        if ($systemStatus != "") $str1 = $str1 . " AND _status = '".replaceSpecialChar($systemStatus)."' ";
                                        
                                        if ($personInCharge != "") $str1 = $str1 . " AND _personincharge = %".replaceSpecialChar($personInCharge)."' ";
                                        
                                        if ($personInChargeContact != "") $str1 = $str1 . " AND _personinchargecontact = '".replaceSpecialChar($personInChargeContact)."' ";
                                        
                                        if ($phone != "") $str1 = $str1 . " AND _phone = '".replaceSpecialChar($phone)."' ";
                                        
                                        if ($date != "") $str1 = $str1 . " AND _date = '".date('Y-m-d',strtotime(replaceSpecialChar($date)))."' ";
                                        
                                        if ($priority != "") $str1 = $str1 . " AND _priority LIKE '%".replaceSpecialChar($priority)."%' ";
                                        
                                        if ($chargable != "") $str1 = $str1 . " AND _chargeable = '".replaceSpecialChar($chargable)."' ";
                                        
                                        if ($remarks != "") $str1 = $str1 . " AND sq._remarks LIKE '%".replaceSpecialChar($remarks)."%' ";
                                        
                                        if ($tnc != "") $str1 = $str1 . " AND _tnc LIKE '%".replaceSpecialChar($tnc)."%' ";
                                                                    
                                    }
                                    
                                    if (trim($sortBy) != "" && trim($sortArrange) != "")
                                        $str2 = $str1 . " ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
                                    else
                                        $str2 = $str1 . " ORDER BY sq._id DESC LIMIT $StartRow,$PageSize ";
                                    
                                
                                    $TRecord = mysql_query('SET NAMES utf8');
                                    $result = mysql_query('SET NAMES utf8');
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
                                        ?>
                                                              
                                    <form name="FormName" method="post" action="">
                                        <table style="margin-top:10px;" cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tr><td colspan="2"><strong>Job Sheet List</strong></td></tr>
                                        <tr>
                                            <td colspan="1" class="pageno">
                                            
                                            <?php
                                                $QureyUrl = "&amp;jobNo=".$_REQUEST['jobNo']."&amp;Keywords=".$Keywords."&amp;SearchBy=".$SearchBy.
                                                            "&amp;companyName=".$_REQUEST['companyName']."&amp;customerID=".$_REQUEST['customerID'].
                                                            "&amp;date=".$date."&amp;phone=".$phone."&amp;priority=".$priority.
                                                            "&amp;chargable=".$chargable."&amp;remarks=".$remarks.
                                                            "&amp;tnc=".$tnc."&amp;maintenanceContractNo=".$maintenanceContractNo.
                                                            "&amp;systemStatus=".$systemStatus."&amp;personInCharge=".$personInCharge."&amp;personInChargeContact=".$personInChargeContact.
                                                            "&amp;sortBy=".$sortBy."&amp;sortArrange=".$sortArrange;
                                                if($MaxPage > 0) echo "Page: ";
                                                for ($i=1; $i<=$MaxPage; $i++)
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
        
                                            if (trim($sortArrange) == "DESC")
                                                $sortArrange = "ASC";
                                            elseif (trim($sortArrange) == "ASC")
                                                $sortArrange = "DESC";
                                            else
                                                $sortArrange = "DESC";
                                            ?>
                                            </td>
                                            <?php
                                            if ($RecordCount > 0)
                                                {
                                                ?>
                                            <td><div align="right"><?php print "$RecordCount record(s) founds - You are at page $PageNo  of $MaxPage"; ?></div></td>
                                            <?php } ?>
                                        </tr>
                                        
                                            
                                        <tr><td colspan="2" height="5"><input type="hidden" name="e_action" value="delete" /></td></tr>
                                        <tr>
                                            <td align="left">
                                            
                                            <?
                                            
                                                if ($RecordCount > 0)
                                                {
                                            ?>
                                            
                                            <input type="button" class="button1" name="btnSubmit2" value="Archive" onclick="return validateForm3();" style="width:110px;" />
                                            
                                            &nbsp;<input type="button" class="button1" name="btnReset2" value="Clear Selection" style="width:100px;" onclick="CheckUnChecked('FormName','CustCheckbox',document.FormName.cntCheck.value,this,'9');" />
                                            </td>
                                            <?
                                                }
                                            
                                            ?>
                                            <td align="right"><a href="#" class="TitleLink" id="SearchByAdv">Advanced Search</a> | <a href="jobsheet.php" class="TitleLink">Add Job Sheet</a></td>
                                        </tr>
                                        <tr><td colspan="2" height="5"></td></tr>
                                        <tr>
                                            <td colspan="2">
                                            
                                                <table cellspacing="0" cellpadding="3" width="100%" border="0" class="grid" >
                                                    <tr>
                                                        <td class="gridheader" align="center"><input name="AllCheckbox" id="AllCheckbox" type="checkbox"   tabindex="" value="All" onclick="CheckUnChecked('CustCheckbox',document.FormName.cntCheck.value,this);" /></td>
                                                        <td class="gridheader" align="center">No.</td>
                                                        <td class="gridheader"><a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_jobno',$Encrypt)?><?=$QureyUrl?>" class="link1">Job No</a></td>                                                
                                                        <td class="gridheader"><a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_companyname',$Encrypt)?><?=$QureyUrl?>" class="link1">Company Name</a></td>												
                                                        <td class="gridheader"><a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_mcno',$Encrypt)?><?=$QureyUrl?>" class="link1">Maintenance Contract No.</a></td>                                              
                                                        <td class="gridheader"><a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_chargable',$Encrypt)?><?=$QureyUrl?>" class="link1">Chargable</a></td>												
                                                        <td class="gridheader"><a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_createdby',$Encrypt)?><?=$QureyUrl?>" class="link1">Created By</a></td>
                                                        <td class="gridheader"><a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_updateddate',$Encrypt)?><?=$QureyUrl?>" class="link1">Updated Date</a></td>                                              
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
                                                            
                                                         if ($id == $rs["_id"]) {
                                                                $Rowcolor = "gridline3";
                                                            }	
                                                        ?>
                                                        <tr >
                                                            <td id="Row1ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">
                                                              <input name="CustCheckbox<?php echo $i; ?>" type="checkbox"   tabindex="" value="<?php echo $rs["_id"]; ?>" onclick="setActivities(this.form.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>','12');" />
                                                            </td>
                                                            <td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
                                                            <td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="100"><?=replaceSpecialCharBack($rs["_jobno"])?></td>
                                                            <td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="100"><?=replaceSpecialCharBack($rs["_companyname"])?></td>
                                                            <td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" ><?php echo replaceSpecialCharBack($rs["_maintenancecontractno"]) ?></td>													
                                                            <td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" ><?=replaceSpecialCharBack($rs["_chargable"])=='1'?'Yes':''?></td>
                                                            <td id="Row7ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" ><?=replaceSpecialCharBack($rs["_createdperson"])?></td>
                                                            <td id="Row8ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left"><?=$rs['_updateddate']!=""?date(DEFAULT_DATEFORMAT,strtotime(replaceSpecialCharBack($rs["_updateddate"]))):""?></td>
                                                            <td id="Row9ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<a href="jobsheet.php?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;id=<?=encrypt($rs["_id"],$Encrypt)?>&amp;e_action=<?=encrypt('edit',$Encrypt)?>&amp;pageshowpoint=<?=encrypt($_GET['pageshowpoint'],$Encrypt)?>" class="TitleLink">Edit</a>
        
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
                                            
                                            <input type="button" class="button1" name="btnSubmit2" value="Archived" onclick="return validateForm3();" style="width:110px;" />
                                           
                                            &nbsp;<input type="button" class="button1" name="btnReset2" value="Clear Selection" style="width:100px;" onclick="CheckUnChecked('FormName','CustCheckbox',document.FormName.cntCheck.value,this,'9');" />
                                            </td>
                                             <?
                                                }
                                            ?>
                                            <td align="right"> 			
                                                <a href="#" class="TitleLink" id="SearchByAdv">Advanced Search</a> | <a href="jobsheet.php" class="TitleLink">Add Job Sheet</a> 
                                            </td>
                                        </tr>								
                                        <tr><td colspan="2" height="5"><input type="hidden" name="cntCheck" value="<?php echo $i-1; ?>" /></td></tr>
                                        <tr>
                                            <td colspan="1" class="pageno">
                                            
                                            <?php
                                                if($MaxPage > 0) echo "Page: ";
                                                for ($i=1; $i<=$MaxPage; $i++)
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
                                            ?>
                                            </td>
                                            
                                        </tr>
                                    <tr><td>&nbsp;</td></tr>	
                                    </table>
                                    </form>
                                        <? } ?> 
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