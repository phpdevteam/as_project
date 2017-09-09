<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
		exit();
    }
	include('../global.php');	
	include('../include/functions.php'); 
	include('access_rights_function.php'); 
	include("fckeditor/fckeditor.php");
		
	$currentmenu = "Contact Person";

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
	
	//var_dump($_GET);
	//exit();
	$btnSubmit = "Submit";
	$id    = $_GET['id'];
	$oid   = $_GET['oid'];
	$ownerref = $_GET["ownerref"];
	$ctab     =1;
	$e_action     = $_GET['e_action'];        
    $trainerrefno = $_GET['ownerno'];
    $ownerid      = $_GET['ownerid'];

	if($id != "" && $e_action == 'edit' )
	{
		$str = "SELECT v.*,vo._VenueRefNo,vo._FullName,date_format(v._CreatedDateTime,'%d/%m/%Y %h:%i:%s %p') as _submitteddate FROM ".$tbname."_venues v  inner join ".$tbname."_venueowners vo on v._OwnerID = vo._ID WHERE v._ID = '".$id."'  ";
		$rst = mysql_query("set names 'utf8';");

		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			
            $venuerefNo = replaceSpecialCharBack($rs["_VenueRefNo"]);
            $trainervenuerefNo = replaceSpecialCharBack($rs["_TraningVenuNo"]);
            $traningvenuename = replaceSpecialCharBack($rs["_VenueName"]);
			$ownerName = replaceSpecialCharBack($rs["_FullName"]);
            $venueownerID = replaceSpecialCharBack($rs["_OwnerID"]);
            $ownerid = replaceSpecialCharBack($rs["_OwnerID"]);
            $venuCatID = replaceSpecialCharBack($rs["_VenueCat"]);
            $venuTypeID = replaceSpecialCharBack($rs["_VenueType"]);
            $cobankaccount = replaceSpecialCharBack($rs["_CorporateBankAc"]);			
			$specialisedprogram = replaceSpecialCharBack($rs["_SpecialisedProgram"]);
			$memcommencDate = mysqlToDatepicker($rs["_MemberDate"]);
			$amenitiesservice = replaceSpecialCharBack($rs["_AmenitiesService"]);
			$equipmentavailable = replaceSpecialCharBack($rs["_EquipmentAvailable"]);
			$venuepoc = replaceSpecialCharBack($rs["_EmailvenuePoc"]);
			$hpnopoc = replaceSpecialCharBack($rs["_HP"]);
           // $membershipType = replaceSpecialCharBack($rs["_membershipStatus"]);
            $venueaddress = replaceSpecialCharBack($rs["_Address"]);
            $venuepostalcode = replaceSpecialCharBack($rs["_PostalCode"]);
            $capacity = replaceSpecialCharBack($rs["_Capacity"]);
			$status = replaceSpecialCharBack($rs["_Status"]);
            $defaultvenue = replaceSpecialCharBack($rs["_DefaultVenue"]);
           // $reasonforsuspension = replaceSpecialCharBack($rs["_SuspensionReason"]);
            $venuedescription = replaceSpecialCharBack($rs["_Description"]);
            $Imagename = replaceSpecialCharBack($rs["_ImageName"]);		
			$btnSubmit = "Update";
		}
	}
	
	else
	{
		$str = "SELECT * FROM ".$tbname."_venueowners  WHERE _ID = '".$oid."' ";

		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect);
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			$venuerefNo    = $rs["_VenueRefNo"];
			$ownerName     = $rs["_FullName"];
            $venueownerID  = $rs["_ID"];
			
		}
		
        }



        	
	if($trainervenuerefNo == "")
	{
		 
       $trainervenuerefNo = generateTrainervenuerefNo();
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
	function validateForm12()
		{
                var x1 = document.forms["FormName0"]["traningvenuename"].value;
                var x2 = document.forms["FormName0"]["venuecategory"].value;
                var x3 = document.forms["FormName0"]["venuetype"].value;
                var x4 = document.forms["FormName0"]["cobankaccount"].value;
                var x5 = document.forms["FormName0"]["specialisedprogram"].value;
               // var x6 = document.forms["FormName0"]["membershipstatus"].value;
                var x7 = document.forms["FormName0"]["hpnopoc"].value;


                if (x1 == "") {
                                alert("Please fill in 'Training Venue Name'.\n");
                                return false;
                              }
                        
                if (x2 == "") {
                                alert("Please select in 'Venue Category'.\n");
                                return false;
                                }
                if (x3 == "") {
                                alert("Please select in 'Venue Type'.\n");
                                return false;
                              }
                if (x4 == "") {
                            alert("Please fill in 'Corporate Bank Account'.\n");
                            return false;
                             }

                if (x5 == "") {
                            alert("Please fill in 'Specialised Programs	'.\n");
                            return false;
                              }
             
                if (x7== "") {
                                alert("Please fill in 'HP No '.\n");
                                return false;
                            }
        }
	
						
			
		//-->
	</script>

    
	</head>
<body>
	<table align="center" width="970" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="align:center;">
		<tr>
			<td valign="top">
			<div class="maintable">
				<table width="970" border="0" cellspacing="0" cellpadding="0">			
						<tr>
							<td valign="top">
								<?php include('topbar.php'); ?>
							</td>
							</tr>
							
						<tr>
							
						<td class="inner-block" width="970" align="left" valign="top">	
						<div class="m">	
						<table width="100%" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td>
                            
                         
                            
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tr>
                                          <td align="left" class="TitleStyle"><b>Traning Venue</b></td>
                                        </tr>
                                        <tr><td height=""></td></tr>
                                    </table>
                            
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                      <td align="left"><b>
                                      <?
											if($_GET['type'] == 'uc'){
												echo "Customers > Under Contractors > ";
											}
											else{
                                                echo " Training Venue -> ";
                                            }
										
									  	if($id != "" || $e_action == 'edit')
										{
											echo "Edit Venue";
										}
										else
										{
											echo "Add Venue";
										}
									  ?>
                                      </b></td> <td align="right" style="padding-right:25px; vertical-align:bottom"> <a href="trainingspaces.php" class="TitleLink">List/Search Training Venue</a>

                                              
                                               | <a href="trainingspace.php" class="TitleLink">Add New</a>
                                        
                                      </td>
                                    </tr>
                                    
                                </table>	
                                
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                     <tr>
                                    <td><div class="toptab">
                                        <ul>
                                        <li <?php if($ctab==0){ ?> style="background-color:#a9a9a9;" <?php } ?>>
                                            <?php if($id!=""){ ?>
                                            <a href="trainingspace.php?ctab=<?=encrypt("0",$Encrypt)?>&id=<?=encrypt($venueownerID,$Encrypt)?>&e_action=<?=encrypt("edit",$Encrypt)?>" style="text-decoration:none;">Basic Info</a>
                                            <?php }else{ ?>
                                            Basic Info
                                            <?php } ?>
                                          </li>
                                        <li <?php if($ctab==1){ ?> style="background-color:#a9a9a9;" <?php } ?>>
                                            <?php if($id!=""){ ?>
                                            <a href="trainingspace.php?ctab=<?=encrypt("1",$Encrypt)?>&id=<?=encrypt($ownerid,$Encrypt)?>&ownerno=<?=encrypt($venuerefNo,$Encrypt)?>&ownername=<?=encrypt($companyname,$Encrypt)?>" style="text-decoration:none;">Training Venue Profile</a>
                                            <?php }else{ ?>
                                           Training Venue Profile
                                            <?php } ?>
                                          </li>
                                          <li <?php if($ctab==2){ ?> style="background-color:#a9a9a9;" <?php } ?>>
                                            <?php if($id!=""){ ?>
                                            <a href="trainingspace.php?ctab=<?=encrypt("2",$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&ownerno=<?=encrypt($trainerrefno,$Encrypt)?>" style="text-decoration:none;">Performance</a>
                                            <?php }else{ ?>
                                            Performance
                                            <?php } ?>
                                          </li>
                                          
                                            <li <?php if($ctab==3){ ?> style="background-color:#a9a9a9;" <?php } ?>>
                                            <?php if($id!=""){ ?>
                                            <a href="?ctab=<?=encrypt("3",$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&companyname=<?=encrypt($companyname,$Encrypt)?>" style="text-decoration:none;">Venue Schedule </a>
                                            <?php }else{ ?>
                                         Venue Schedule
                                            <?php } ?>
                                          </li>
										  
										     <!--< <li <?php if($ctab==6){ ?> style="background-color:#a9a9a9;" <?php } ?>>
                                            <?php if($id!=""){ ?>
                                            <a href="?ctab=<?=encrypt("6",$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&companyname=<?=encrypt($companyname,$Encrypt)?>" style="text-decoration:none;">Special Rates </a>
                                            <?php }else{ ?>
                                            Specail Rate
                                            <?php } ?>
                                          </li>
                                           
                                        
                                     li <?php if($ctab==4 ){ ?> style="background-color:#a9a9a9;" <?php } ?>>
                                        
                                          <?php if($id!=""){ ?>
                                          <a href="?ctab=<?=encrypt('4',$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>" style="text-decoration:none;">Pdts/Svcs Warranty History</a>
										  <?php }else{ ?>Pdts/Svcs Warranty History<?php } ?></li>-->
                                                  
                                      </ul>
                                      </div></td>
                                  </tr>
                                
                                    <tr>
                                        <td>
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
                                        echo "<div align='left'><font color='#FF0000'>Record has been duplicated successfully.<br></font></div>";
                                    }
							
							?>
                                            <?php if($ctab==1){ ?>
                                            <form name="FormName0" id="FormName0" action="venue_action.php"  method="post" onsubmit="return validateForm12();" enctype="multipart/form-data">
                                            <input type="hidden" id="id" name="id" value="<?=$id?>" />
                                            <input type="hidden" id="ownername" name="ownername" value="<?=$venueownerID?>" />
                                               <input type="hidden" id="trainingvenuerefno" name="trainingvenuerefno" value="<?=$venuerefNo?>" />
                                            <input type="hidden" name="e_action" id="e_action" value="<?=($e_action == "" ? "addnew" : "edit")?>" />
                                            <input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
                                            <input type="hidden" name="type" value="<?=$_GET['type']?>" />
                                            <input type="hidden" name="ctab" value="<?=$ctab?>" />
                                            <input type="hidden" id="cid" name="cid" value="<?=$oid?>" /> 
                                            <input type="hidden" name="file444" value="<?=$Imagename?>" /> 
                                           
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">								
                                            
                                           <!-- <tr>
                                            	<td colspan="7" align="right" style="padding-right:25px">
                                                
                                                 <?  
												echo '<a href="trainingspace.php?ctab='.encrypt('1',$Encrypt).'&id='.encrypt($cid,$Encrypt).'&type='.encrypt($_GET['type'],$Encrypt).'&custno='.encrypt($customerno,$Encrypt).'" class="TitleLink">List Traning Venue</a>';
                                                ?>
                                                
                                                | 
                                                
                                              <?  
												echo '<a href="contactperson.php?cid='.encrypt($cid,$Encrypt).'&custno='.encrypt($customerno,$Encrypt).'" class="TitleLink">Add Contact Person</a>';
                                                ?>                                              
                                                </td>
                                            </tr>-->
                                               
                                             <tr>
                                      <td height="25"></td>
                                      
                                             </tr>
                                            <tr>
                                                <td  valign="middle" width="150px">Training Venue Name</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                               <input type="text" tabindex="1" id="traningvenuename" name="traningvenuename" value="<?=$traningvenuename?>" class="txtbox1" style="width:250px;" />
                                                </select><span class="detail_red">*</span>
                                                </td>
                                                 <td width="85px"></td>
                                                <td  valign="middle" width="150px">Venue Ref No</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle">
                                               <input type="text" tabindex="" autocomplete="off" id="trainingvenuerefno" name="trainingvenuerefno" value="<?=$trainervenuerefNo?>" class="txtlabel" readonly="readonly" style="width:250px;font-size: 9pt;">
                                                </td>
                                               
                                            </tr>
                                            
                                                    <tr>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                             </tr>
                                            
                                                <tr>
                                                 <td valign="middle">Owner Name</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><?=$ownerName . " (" . $venuerefNo . ")"?>
                                                </td>
												 <td width="85px"></td>
												<td valign="middle">Submitted Date/Time</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td  valign="middle"><span><?=$subdate == ""?date('d/m/Y h:i:s A'):$subdate ?> </span></td>
                                            
                                                </tr>
                                                
                                                    <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                </tr>
                                            
                                            <tr>
                                            <td valign="middle">Training Venue Category	</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle">
												
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
												
												 <td width="85px"></td><td  valign="middle">Submitted By</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td  valign="middle"><span><?= $subby ==""?$_SESSION['user']: $subby ?> </span></td> 
                                            
                                            </tr>
                                            
                                             <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                            </tr>
                                           
                                            <tr>
                                             <td valign="middle">Venue Type	</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"> <? $str = "SELECT _ID,_VenueTypeName FROM ".$tbname."_venuetype ORDER BY _ID";
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
                                                
                                                 <td width="85px"></td>
                                           		<td  valign="middle">System&nbsp;Status&nbsp;</td>
                                            <td>&nbsp;:&nbsp;</td>
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
                                            <td><input type="radio"   tabindex="" <?php echo $sel_status_y; ?> name="status" value="1" id="RadioGroup1_0" class="radio" />Live
                                            <input type="radio"   tabindex="" <?php echo $sel_status_n; ?> name="status" value="2" id="RadioGroup1_1" class="radio" />Archive</td>
                                           <tr>
                                           
                                            <tr>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                        </tr>
                                 
                                                <tr>
                                                <td valign="middle">Corporate Bank Account</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="" id="cobankaccount" name="cobankaccount" value="<?=$cobankaccount?>" size="60" class="txtbox1 " style="width: 250px;"> <span class="detail_red">*</span></td>
                                             <td width="85px"></td>
                                             <td valign="middle">Amenities Service	</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="12" id="amenitiesservice" name="amenitiesservice" value="<?=$amenitiesservice?>" class="txtbox1" style="width:250px;"></td>
                                          
                                          
                                            </tr>
                                             <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                            </tr>
                                                <tr>
                                                <td  valign="middle">Specialised Programs</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="2" id="specialisedprogram" name="specialisedprogram" value="<?=$specialisedprogram?>" class="txtbox1" style="width:250px;"/><span class="detail_red">*</span></td>
                                            <td width="85px"></td>
                                             <td  valign="middle">Equipment available</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td  valign="middle"><input type="text" tabindex="12" id="equipmentavailable" name="equipmentavailable" value="<?=$equipmentavailable?>" class="txtbox1" style="width:250px;"></td>  
                                            
                                            
                                            </tr>
                                             <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                            </tr>
                                              <!--  <tr>
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
                                           
                                             <td width="85px"></td>
                                                <td  valign="middle">Email Venue Point-of-Contac(POC)	</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="13" id="venuepoc" name="venuepoc" value="<?=$venuepoc?>" class="txtbox1" style="width:250px;" >
                                                </td>
                                           
                                            </tr>
                                            
                                               <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                            </tr>-->
                                                    
                                   
                                            
                                            <tr>
                                             <!--    <td valign="middle">Default Venue </td>
                                                <td valign="middle">&nbsp;&nbsp;</td>
                                                <td valign="middle">
                                                <input type="checkbox"   tabindex="" id="defaultvenue" name="defaultvenue" value="1" <?php if( trim($defaultvenue) == '1') echo 'checked';?>/>                                                                                             
                                                </td>-->

                                                <td  valign="middle" width="150px">Address</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                               <input type="text" tabindex="1" id="venueaddress" name="venueaddress" value="<?=$venueaddress?>" class="txtbox1" style="width:250px;" />
                                                </select>
                                                </td>



                                                 <td width="85px"></td>
                                                <td  valign="middle">HP No Venue Point-of-Contac(POC)	</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="13" id="hpnopoc" name="hpnopoc" value="<?=$hpnopoc?>" class="txtbox1"  onkeypress="return isNumber(event)" style="width:240px;" ><span class="detail_red">*</span>
                                                </td>
                                               
                                              </tr>
                                              
                                               <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                              </tr>
                                            
                                            <tr>
                                            
                                            <td  valign="middle" width="150px">Postal Code</td>
                                            <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                            <td  valign="middle" width="265px">
                                           <input type="text" tabindex="1" id="venuepostalcode" name="venuepostalcode" value="<?=$venuepostalcode?>" class="txtbox1" style="width:250px;" />
                                            </select>
                                            </td>
                                            
                                             <td width="85px"></td>
                                            <td  valign="middle">Specialised Fitness Training</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td  valign="middle"><?php
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
										 ?></td>
                                                
                                             
                                            </tr>
                                            
                                             <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                       </tr>
                                           
                                            <tr>
                                            
                                            <td  valign="middle" width="150px">Capacity</td>
                                            <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                            <td  valign="middle" width="265px">
                                           <input type="text" tabindex="1" id="capacity" name="capacity" value="<?=$capacity?>" class="txtbox1" style="width:250px;" />
                                            </select>
                                            </td>
                                            <td width="85px"></td>
                                            <td  valign="middle">Email Venue Point-of-Contac(POC)	</td>
                                            <td valign="middle">&nbsp;:&nbsp;</td>
                                            <td valign="middle"><input type="text" tabindex="13" id="venuepoc" name="venuepoc" value="<?=$venuepoc?>" class="txtbox1" style="width:250px;" >
                                            </td>
                                               
                                            </tr>
                                            
                                            <tr>
                                            <td valign="middle">Default Venue </td>
                                            <td valign="middle">&nbsp;:&nbsp;</td>
                                            <td valign="middle">
                                            <input type="checkbox"   tabindex="" id="defaultvenue" name="defaultvenue" value="1" <?php if( trim($defaultvenue) == '1') echo 'checked';?>/>                                                                                             
                                            </td>
                                             
                                            <td width="85px"></td>
                                                  <td  valign="middle">Image Name	</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle">
                                                <?php
                                        if($Imagename != "")

                                        
										{ ?> 
											 <a href="<?php echo $AdminTopCMSImagesPath;?><?php echo $Imagename;?>" target="_blank" style="color:#FF0000; font-family:arial; font-size:11px;"><?php echo $Imagename;?></a>&nbsp;
											 <a href="javascript:void(0);" onClick="if(confirm('Are you sure you want to delete this?')) { window.open('venue_action.php?e_action=deletefile&removID=<?php echo $id;?>&Types=I','personalize','toolbar=no,location=no,directories=no,status=no,menubar=no'); return true; }" onMouseOver="write_it('Delete File');return true;" class="link1">[<img src="../images/delfilepic.gif" border="0" alt="Delete File"> Delete File]</a>
										<? }else {?>
									
                                        <input type="file" name="ImageName[]" size="40" class="txtbox1">
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
                                            
                                            <td  valign="middle" width="150px"></td>
                                            <td  valign="middle" width="10px">&nbsp;&nbsp;</td>
                                            <td  valign="middle" width="265px">
                                          
                                          
                                            </td>
                                                <td width="85px"></td>
                                                  <td  valign="middle">Description	</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><textarea  tabindex="" id="venuedescription" name="venuedescription"  class="textarea1" style="height:70px;"><?=$venuedescription?></textarea>
                                                </td>
                                               
                                            </tr>
                                            <tr>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                             </tr>

                                             <tr>
                                                <td colspan="2">&nbsp;</td>
                                                <td colspan="2">
	                                                <input type="button" class="button1" name="btnBack" value="< Back" onclick="history.back();" />&nbsp;
                                                    <input type="submit" name="btnSubmit" id="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
                                                    
                                                   
                                                </td>
                                            </tr>
                                            </table>
                                            </form>
                                           	<? } ?>
                                        </td>
                                    </tr>	
                                </table>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
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