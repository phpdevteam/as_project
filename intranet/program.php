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
		
	$currentmenu = "Program";

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
	
	 $id           = $_GET['id'];
	 $programno    = $_GET['programno'];
	 $programname  = $_GET['programname'];
	 $e_action     = $_GET['e_action'];
	 $ctab         = $_GET['ctab'];
	 $type         = $_REQUEST['type'];
	 //$memberid = $_REQUEST["memberid"]; 
    // var_dump($_REQUEST);
    

 
	if($ctab=="")
	{
		$ctab = 0;
	}
	
	$customertype = array();
	
	if($id != "" && $e_action == 'edit' && $ctab == '0')
	{
		
        $str = "SELECT p.*,date_format(p._CreatedDateTime,'%d/%m/%Y %h:%i:%s %p') as _submitteddate,pd.* FROM ".$tbname."_trainingprogram  p 
      
        LEFT JOIN  ".$tbname."_trainingprogramdetails pd ON p._ID = pd._TrainingProgramID  WHERE p._ID = '".$id."' ";

      
		$rst = mysql_query("set names 'utf8';");	
		
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			
			$programname = replaceSpecialCharBack($rs["_ProgramName"]);
            $ProCatID = replaceSpecialCharBack($rs["_ProgramCatID"]);
            $chkFitType1 = replaceSpecialCharBack($rs["_IsFitnessExperience"]);
            $programtypeID = replaceSpecialCharBack($rs["_TrainingTypeID"]);
            $programsubtypeID = replaceSpecialCharBack($rs["_TrainingSubTypeID"]);
            $programsubsubtypeID = replaceSpecialCharBack($rs["_TrainingSubSubTypeID"]);
            $maxperson = replaceSpecialCharBack($rs["_MaxPerson"]);
			$trainerID = replaceSpecialCharBack($rs["_TrainerID"]);
            $amount = replaceSpecialCharBack($rs["_TotalAmount"]);
            $maxtrinerfeesurcharge = replaceSpecialCharBack($rs["_MaxTrainerfeeSurcharge"]);
            $maxvenuefeesurcharge = replaceSpecialCharBack($rs["_MaxVenuefeeSurcharge"]);
            $programduration = replaceSpecialCharBack($rs["_ProgramDuration"]);
			$description = $rs["_ProgramDescr"];
			$programno = replaceSpecialCharBack($rs["_ProgramRefID"]);
            $status = replaceSpecialCharBack($rs["_Status"]);
            $progstatus = replaceSpecialCharBack($rs["_TrainingProgramStats"]);
            $startdate = replaceSpecialCharBack($rs["_StartTime"]);
            $enddate = replaceSpecialCharBack($rs["_EndTime"]);
            $programdate = mysqlToDatepicker($rs["_ProgramDate"]);
          //  $shower = replaceSpecialCharBack($rs["_ShowerCharge"]);
        //    $towel = replaceSpecialCharBack($rs["_TowelCharge"]);
          //  $premiumgym = replaceSpecialCharBack($rs["_PremiumGymCharge"]);
          //  $loadedmvtcharge = replaceSpecialCharBack($rs["_LoadedMVTCharge"]);

          $uniqueexperience = replaceSpecialCharBack($rs["_UniqueExperience"]);
          $fitnessoutcome = replaceSpecialCharBack($rs["_FitnessOutcome"]);
          $trainingduration = replaceSpecialCharBack($rs["_TrainingDuration"]);
          $background = replaceSpecialCharBack($rs["_TrainerBackground"]);
          $specialcharateristic = replaceSpecialCharBack($rs["_TrainerSpecificCharacteristic"]);   
          $programsynopsis = replaceSpecialCharBack($rs["_ProgramSynopsis"]);
          $equipmentused = replaceSpecialCharBack($rs["_EquipmentUsed"]);
          $address = replaceSpecialCharBack($rs["_Address"]);
          $landmark = replaceSpecialCharBack($rs["_Landmark"]);
          $publictransport = replaceSpecialCharBack($rs["_PublicTransport"]);
          $carpark = replaceSpecialCharBack($rs["_Carpark"]);   
          $amenitiesoftrainingvenue = replaceSpecialCharBack($rs["_Amenities"]);
          $needcertificate = replaceSpecialCharBack($rs["_NeedCertificates"]);   
          $certificateremark = replaceSpecialCharBack($rs["_CertificateRemarks"]);   











			$btnSubmit = "Update";
		 }
	}else
	  {
	
		$customertype = array($_REQUEST['type']);
		
	   }

        if($programno == "")
        {
            $programno = generateProgramNo();
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
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
    <script type="text/javascript" src="jquery-1.4.1.min.js"></script>
     <script type="text/javascript" src="../js/qtip.js"></script>      
     <script type="text/javascript" src="../js/functions.js"></script>
            
<script>

function change_programcharges()
{
    var programtype = $("#programtypeID").val();
    var programsubtype = $("#programsubtypeID").val();
    var programsubsubtype = $("#programsubsubtypeID").val();


       $.ajax({

        type: "POST",

        url: "programfetchdata.php",

        data: "programtype="+programtype+"&programsubtype="+programsubtype+"&programsubsubtype="+programsubsubtype,
        cache: false,

        success: function(response)
           {

            $("#demo123").html(response);
  
       
            }

            });

}


</script>

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
             var x1 = document.forms["FormName0"]["programname"].value;
            var x2 = document.forms["FormName0"]["ProCatID"].value;
            var x3 = document.forms["FormName0"]["programtypeID"].value;
            var x4 = document.forms["FormName0"]["programsubtypeID"].value;
            var x5 = document.forms["FormName0"]["programsubsubtypeID"].value;
            var x6 = document.forms["FormName0"]["amount"].value;
            var x7 = document.forms["FormName0"]["maxperson"].value;
     
           

            if (x1 == "") {
                alert("Please fill in 'Program Name'.\n");
                return false;
            }
            if (x2 == "") {
                alert("Please select in 'Program Category'.\n");
                return false;
            }
            if (x3 == "") {
                alert("Please select in 'Program Type'.\n");
                return false;
            }
            if (x4 == "") {
                alert("Please select in 'Program Sub Type'.\n");
                return false;
            }

            if (x5 == "") {
                alert("Please select in 'Program Sub Sub Type'.\n");
                return false;
            }

            if (x6 == "") {
                alert("Please fill in 'Amount'.\n");
                return false;
            }

            if (x7 == "") {
                alert("Please fill in 'Maximum Person'.\n");
                return false;
            }
          
        }
        

    /* $(document).ready(function () {
        $('#example1').timepicker();   
     });

     $(document).ready(function () {
        $('#example2').timepicker();   
     });*/


     function validateForm3()
		{
			
				document.forms.FormName0.action = "program_action.php?action12=delete1";
				document.forms.FormName0.submit();
		}


</script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
   $(function () {
    $("input[name='chkPassPort1']").click(function () {
        if ($("#chkYes1").is(":checked")) {
            $("#dvPassport1").hide();
        } else {
            $("#dvPassport1").show();
        }
    });
});

</script>

<script type="text/javascript">
   $(function () {
    $("input[name='chkPassPort1']").click(function () {
        if ($("#chkYes1").is(":checked")) {
            $("#dvPassport2").hide();
        } else {
            $("#dvPassport2").show();
        }
    });
});

</script>

<script type="text/javascript">
function valueChanged()
{
    if($('.needcertificate').is(":checked"))   
        $(".answer").show();
    else
        $(".answer").hide();
}

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
                                          <td align="left" class="TitleStyle"><b>Programs</b></td>
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
                                                    echo "Edit Programs";
                                                }
                                                else
                                                {
                                                    echo "Add Programs";
                                                }
											  ?>                                              
								  </td>
								  <td align="right" style="padding-right:2px; vertical-align:bottom"> <a href="programs.php" class="TitleLink">List/Search Programs</a>
                                              
                                              <?php
											  if($id != "")
											  {
											  ?>
                                              
                                               | <a href="program.php" class="TitleLink">Add New</a>
                                                  
                                              <?php
											  }
											  ?>
                                              
                                              </td>
                                  </tr>
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
                                            echo "<div align='left'><font color='#FF0000'>Programname [".$programname."] is existed in the system. Please enter another MemberID.<br></font></div>";
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
                                        <form name="FormName0" action="program_action.php"  method="post" onsubmit="return validateForm0();" enctype="multipart/form-data">
                                        <input type="hidden" id="id" name="id" value="<?=$id?>" />
                                        <input type="hidden" id="programno" name="programno" value="<?=$programno?>" />
                                        <input type="hidden" name="e_action" value="<?=($e_action == "" ? "addnew" : "edit")?>" />
                                        <input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
                                        <input type="hidden" name="ctab" value="<?=$ctab?>" />

                                        <input type="hidden" name="name" value="<?=$programsubtypeID?>" />
                                        <div  name="total12345"  id= "total12345" value="<?=$total12345?>" />

                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                          <tr>
                                          <td valign="top">
                                              
                                           <table width="100%" cellpadding="0" cellspacing="0" border="0">
											
										
											<tr>
                                                <td valign="middle" width="150px">Program Name</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="programname" name="programname" value="<?=$programname?>" class="txtbox1" style="width:250px;" />
                                                  <span class="detail_red">*</span></td>
                                            </tr>
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>



                                        <tr>
                                                <td  valign="middle" width="150px">Program Cat </td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                                <? $str = "SELECT _ID,_ProgramCatName FROM ".$tbname."_trainingprogramcat ORDER BY _ID";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="ProCatID" id="ProCatID" class="dropdown1  chosen-select">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $ProCatID) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_ProgramCatName"]; ?>&nbsp;</option>
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
                                            <td  valign="middle" width="150px">Type</td>
                                            <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td>
                                                <?php    
    
                                                       $sel_status_y = "";
                                                       $sel_status_n = "";
                                                       if($chkFitType1 == 'N'){
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
   
                
                                            <input type="radio"   tabindex="9" <?php echo $sel_status_y; ?> name="chkPassPort1" value="N" id="chkYes1"  />Program
                                            <input type="radio"   tabindex="9" <?php echo $sel_status_n; ?> name="chkPassPort1" value="Y" id="chkNo1"  />Fitness Experience.
                                                                </td></tr>




                                                    </table>                                                                
                                                                                                    
                                                <div id="dvPassport1"  <?php if($chkFitType1 == 'Y') { ?>  style="display:block";   <?php } else  { ?>   style="display:none";  <?php } ?>>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">                                             
                                                <tr>
                                                        <td height="5"></td>
                                                        <td height="5"></td>
                                                        <td height="5"></td>
                                                    </tr>


                                                    <tr>
                                                    <td  valign="middle" width="150px">Trainer Name</td>
                                                    <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                    <td  valign="middle" width="265px">


                                                    <? $str = "SELECT _ID,_FullName FROM ".$tbname."_trainers ORDER BY _ID";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                    <select  tabindex="" name="trainerID" id="trainerID" class="dropdown1  chosen-select">
                                                   <option value="">-- Select One --</option>
                                                   <?php
                                              
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                    while($rs = mysql_fetch_assoc($rst))
                                                    {
                                                  ?>
                                                  <option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $trainerID) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_FullName"]; ?>&nbsp;</option>
                                                  <?php
                                                  }
                                              }
                                              ?>
                                                    </td>
                                                    </tr></table>
                                                    </div>

                                              <table width="100%" cellpadding="0" cellspacing="0" border="0">



                                            <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
                                             </tr>
                                             
                                             <tr>
                                            <td valign="middle">Program Type</td>
                                            <td valign="middle">&nbsp;:&nbsp;</td>
                                            <td valign="middle" ><select  tabindex="6" name="programtypeID" id="programtypeID" class="dropdown1 chosen-select" style="width:250px;">
                                                <option value="">--select--</option>
                                                <?php
                                                    $sql = "SELECT _ID,_TypeName FROM ".$tbname."_trainingtype where _Status=1";
                                                    $res = mysql_query($sql) or die(mysql_error());
                                                    if(mysql_num_rows($res) > 0){
                                                        while($rec = mysql_fetch_array($res)){
                                                            ?><option <?php if($rec['_ID'] == $programtypeID ){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_ID']; ?>"><?php echo $rec['_TypeName']; ?></option><?php
                                                        }
                                                    }
                                                ?>
                                                </select>
                                                <span class="detail_red">*</span>   </td>
                                            </tr>
                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                         
                                          <tr>
                                            <td  valign="middle">Program Sub Type</td>
                                            <td  valign="middle">&nbsp;:&nbsp;</td>
                                             <td valign="middle">
                                                <select  tabindex="8" name="programsubtypeID" id="programsubtypeID" class="dropdown1 chosen-select" style="width:250px;">
                                                <option value="">--select--</option>
                                                <?php
												
												if($programtypeID != "")
												{
												
                                                    $sql = "SELECT * FROM ".$tbname."_trainingsubtype 
													Where _TypeID = '". $programtypeID ."' ORDER BY _SubTypeName ";
                                                    $res = mysql_query($sql) or die(mysql_error());
                                                    if(mysql_num_rows($res) > 0){
                                                        while($rec = mysql_fetch_array($res)){
                                                            ?><option <?php if($rec['_ID'] == $programsubtypeID){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_ID']; ?>"><?php echo $rec['_SubTypeName']; ?></option><?php
                                                        }
                                                    }
													
												}
												else
												{
													
													 $sql = "SELECT * FROM ".$tbname."_trainingsubtype 
													Where _Status = '1' ";
                                                    $res = mysql_query($sql) or die(mysql_error());
                                                    if(mysql_num_rows($res) > 0){
                                                        while($rec = mysql_fetch_array($res)){
                                                            ?><option <?php if($rec['_ID'] == $programsubtypeID ){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_ID']; ?>"><?php echo $rec['_SubTypeName']; ?></option><?php
                                                        }
                                                    }
												}
                                                ?>
                                              </select>
                                              <span class="detail_red">*</span>   </td>
                                            </tr>
                                             <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                    </tr>
                                                <tr>
                                                <td  valign="middle">Programs Sub Sub Type </td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                 <td valign="middle" >
                                                <select  tabindex="10" name="programsubsubtypeID" id="programsubsubtypeID" onchange="change_programcharges();"  class="dropdown1 chosen-select" style="width:250px;">
                                                <option value="">--select--</option>
                                                <?php
                                                
                                                 if($programsubtypeID != "")
                                                {
                                    
                                                    $sql = "SELECT * FROM ".$tbname."_trainingsubsubtype  Where _SubTypeID = '". $programsubtypeID."' ";
                                                    $res = mysql_query($sql) or die(mysql_error());
                                                    if(mysql_num_rows($res) > 0){
                                                        while($rec = mysql_fetch_array($res)){
                                                            ?><option <?php if($rec['_ID'] == $programsubsubtypeID  ){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_ID']; ?>"><?php echo $rec['_SubSubTypeName']; ?></option><?php
                                                        }
                                                    }
																
												}else
												{
													
													 $sql = "SELECT * FROM ".$tbname."_trainingsubsubtype Where _Status = '1'";
                                                    $res = mysql_query($sql) or die(mysql_error());
                                                    if(mysql_num_rows($res) > 0){
                                                        while($rec = mysql_fetch_array($res)){
                                                                ?><option <?php if($rec['_ID'] == $programsubsubtypeID){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_ID']; ?>"><?php echo $rec['_SubSubTypeName']; ?></option><?php
                                                                    }
                                                                }
												}
                                                            ?>
                                                          </select>
                                                    
                                                          <span class="detail_red">*</span>    </td>
                                              </tr>


                                            <tr>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            <td height="10"></td>
                                            </tr>
											 <tr>
                                                <td valign="middle" width="150px">Amount</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="amount" name="amount" value="<?=$amount?>" class="txtbox1" style="width:250px;" />
                                                  <span class="detail_red">*</span></td>
                                            </tr>
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>
											
                                           
                                             <tr>
                                                <td valign="middle">Description</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"> <textarea  tabindex="" id="description" name="description"  class="textarea1" style="height: 60px;"><?=$description?></textarea>
                                                </td>
                                            </tr>
                                             
                                               <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                </tr>


                                                <tr>
                                                <td valign="middle">Maximum person</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="maxperson" name="maxperson" value="<?=$maxperson?>" class="txtbox1"  onkeypress="return isNumber(event)" style="width:250px;" />
                                                <span class="detail_red">*</span>   </td>
                                            </tr>

                                            <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                </tr>


                                                <tr>
                                                <td valign="middle">Max Trainer Fee Surcharge</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="maxtrinerfeesurcharge" name="maxtrinerfeesurcharge" value="<?=$maxtrinerfeesurcharge?>" class="txtbox1"  onkeypress="return isNumber(event)" style="width:250px;" />
                                                <span class="detail_red">*</span>   </td>
                                            </tr>
                                            <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                </tr>


                                                <tr>
                                                <td valign="middle">Max Venue Fee Surcharge</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="maxvenuefeesurcharge" name="maxvenuefeesurcharge" value="<?=$maxvenuefeesurcharge?>" class="txtbox1"  onkeypress="return isNumber(event)" style="width:250px;" />
                                                <span class="detail_red">*</span>   </td>
                                            </tr>


                                            <tr>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                <td height="5"></td>
                                                </tr>


                                                <tr>
                                                <td valign="middle">Need Certificate</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px">
                                                
                                                <?php    
    
                                                       $sel_status_y1 = "";
                                                       $sel_status_n1 = "";
                                                       if($needcertificate == '1'){
                                                           $sel_status_y1 = "checked='checked'";
                                                           $sel_status_n1="";
                                                       }
                                                       else
                                                       {
                                                           
                                                           if($e_action!='edit')
                                                           {
                                                               $sel_status_y1="checked='checked'";
                                                               $sel_status_n1 ="" ;
                                                               
                                                           }
                                                           else
                                                           {
                                                               $sel_status_y1="";
                                                               $sel_status_n1 ="checked='checked'";
                                                           }
                                                       } 
                                                        ?> 
                                            
                                                
                                                 <input class="needcertificate" type="checkbox" <?php echo $sel_status_y1; ?> name="needcertificate" value="1"  onchange="valueChanged()"/></td>
                                           </tr></table>

                                           <div id="answer" class="answer" <?php if($needcertificate == '1') { ?>  style="display:block";   <?php } else  { ?>   style="display:none";  <?php } ?>>
                                           <table width="100%" cellpadding="0" cellspacing="0" border="0" >
                                          
                                           <tr>
                                                <td valign="middle" style="width:164px;">Certificate Remark  </td>
                                               
                                                <td valign="middle" width="260px"> <textarea  tabindex="" id="certificateremark" name="certificateremark"  class="textarea1" style="height:60px;width:247px;"><?=$certificateremark?></textarea>
                                                  </td>
                                            </tr>
                                          
                                          
                                          </table></div>










              
                                          </table>
                                          
                                          </td>
                                          
                                          <td width="30px"></td>
                                          
                                          <td valign="top" align="right">
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tbllabel">
                                            <tr>
                                            <td valign="middle" width="150px">Program Ref No</td>
                                            <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                            <td valign="middle"><input type="text" tabindex="" autocomplete="off" id="programno" name="programno" value="<?=$programno?>" class="txtlabel" readonly="readonly" style="width:250px;font-size: 9pt;"></td>
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
                                                <td valign="middle">Program Status</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="radio"   tabindex="7" name="progstatus" value="CancelRequest" <?=$progstatus=='CancelRequest' || $progstatus == ''?'checked="checked"':''?> />
                                                CancelRequest 
                                                <input type="radio"   tabindex="7" name="progstatus" value="Cancelled" <?=$progstatus=='Cancelled' ?'checked="checked"':''?> />
                                                Cancelled 
                                                <input type="radio"   tabindex="7" name="progstatus" value="Current" <?=$progstatus=='Current' ?'checked="checked"':''?> />
                                                Current  </td>
                                            </tr>
									
                                            <tr>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            <td height="10"></td>
                                        </tr>   
                                        
                                <tr>
                                                <td valign="middle">Program Duration</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="number" tabindex="1" id="programduration" name="programduration" value="<?=$programduration?>" class="txtbox1"  step="0.01"  style="width:150px;" /> Hrs
                                                </td>
                                            </tr>


                                                <!--    <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>   


                                 <tr>
                                                <td valign="middle">Towel</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="towel" name="towel" value="<?=$towel?>" class="txtbox1" onkeypress="return isNumber(event)"  style="width:250px;" />
                                                </td>
                                            </tr>
                                            <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>   


                                 <tr>
                                                <td valign="middle">Premium Gym</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="premiumgym" name="premiumgym" value="<?=$premiumgym?>" class="txtbox1" onkeypress="return isNumber(event)"   style="width:250px;" />
                                                </td>
                                            </tr>

                                            <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>   


                                 <tr>
                                                <td valign="middle">Loaded MVT charge</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="loadedmvtcharge" name="loadedmvtcharge" value="<?=$loadedmvtcharge?>" class="txtbox1" onkeypress="return isNumber(event)"  style="width:250px;" />
                                                </td>
                                            </tr>-->

                                          </table>
                                          </td>
                                          
                                          </tr>
                                          <tr>
                                      <td height="35"></td>
                                   
                                 </tr>   
                                          <tr>
                                          <td>
                                          <table width="100%" cellpadding="0" cellspacing="0" border="0" >
                                    

                                   <tr>
                              
                                    <td>
                                        <button type="button" id='addmore'  class="button1" style="text-align:left;width:70px;margin-left: 363px;"><b>+ Add New</b></button></td></tr>
                                        <tr>
                                        <td height="20"></td></tr></table></td></tr>

                                    <table id="demo123" border="0" cellspacing="0"  class="grid" style="text-align:center;width:400px;" >
                                     
                                     
                                        <tr>
                                                <th  width="5%"class="gridheader"><input name="AllCheckbox" id="AllCheckbox" type="checkbox"   tabindex="" class='check_all' value="All"  onclick="select_all()" onclick="CheckUnChecked('FormName','CustCheckboxq',document.FormName.cntCheck1.value,this,'<?=$colCount?>');" /></th>
                                                <th width="10%" class="gridheader" style="font-size:12px;">S/No</th>
                                                <th width="20%" class="gridheader" style="font-size:12px;">Minimum </th>
                                                <th width="20%" class="gridheader" style="font-size:12px;">Maximum</th>
                                                <th class="gridheader" width="20%" style="font-size:12px;">Price</th>
                                                <th class="gridheader" width="20%" style="font-size:12px;">NSMAN Price</th>
                                               
                                                <input type="hidden" name="cntCheck1" value="<?php echo $i-1; ?>" />
                                            </tr>
                                            <tr>

                                            <?php 
                                            if($e_action == 'edit')
                                            
                                            {

                                           $str1= "SELECT * FROM ".$tbname."_programpricing WHERE _ProgramID = '$id' and _Status=1";

                                           $rst = mysql_query("set names 'utf8';");
                                           $i=1;
                                            $rst = mysql_query($str1, $connect) or die(mysql_error());
                                            $total1 =mysql_num_rows($rst);                                          
                                            if(mysql_num_rows($rst) > 0)
                                            {                                   
                                            while($rs = mysql_fetch_assoc($rst))
                                            { 
                                              
                                                $minimum  = $rs['_Min'];
                                                $maximum  = $rs['_Max'];            
                                                $price   = $rs['_Price'];
                                                $price   = $rs['_Price'];
                                                $nsmanprice =$rs['_NsmanPrice'];
                                            ?>
                                                <td  class="gridline2">
                                                <input name="CustCheckboxq<?php echo $i; ?>" type="checkbox"  class="case"  tabindex="" value="<?php echo $rs["_ID"]; ?>" onclick="setActivities(this.form.CustCheckboxq<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>','<?=$colCount?>');" /> 
                                                </td>
                                                <td class="gridline2"><?php echo $i;?></td>
                                                <td  class="gridline2"><input type='text' id='minimum' name='minimum[]' value="<?php echo $minimum;?>"  onkeypress="return isNumber(event)" style="width:90px"/></td>
                                                <td  class="gridline2"><input type='text' id='maximum' name='maximum[]'   value="<?php echo $maximum;?>" onkeypress="return isNumber(event)" style="width:90px"/></td>
                                                <td  class="gridline2"><input type='text' id='price' name='price[]'  onkeypress="return isNumber(event)"  value="<?php echo $price;?>" style="width:90px"/></td>
                                                <td  class="gridline2"><input type='text' id='nsmanprice' name='nsmanprice[]'   onkeypress="return isNumber(event)"  value="<?php echo $nsmanprice;?>" style="width:90px"/></td>
                                               
                                                 </tr>	
                                  
                                             <?php
                                    
                                              $i++;
                                                }
                                                 }
                                            ?>
                                                
                                             <?php } else {?>
                                               <tr>
                                               <td class="gridline2"><input type='checkbox' class='case'  name="AllCheckbox1" id="AllCheckbox1"value="All" onclick="CheckUnChecked('FormName0','CustCheckboxq',document.FormName0.cntCheck1.value,this,'<?=$colCount?>');"  /></td>
                                                <td class="gridline2" width="30px;"><input type='text' id='srno' name='srno[]'  style="width:0px;border:0px;">1</td>
                                                <td class="gridline2"><input type='text' id='minimum' name='minimum[]' onkeypress="return isNumber(event)" style="width:120px"/></td>
                                                <td class="gridline2"><input type='text' id='maximum' name='maximum[]' onkeypress="return isNumber(event)" style="width:120px"/></td>
                                                <td class="gridline2"><input type='text' id='price' name='price[]' onkeypress="return isNumber(event)"  style="width:90px"/></td>
                                                 <td class="gridline2"><input type='text' id='nsmanprice' name='nsmanprice[]' onkeypress="return isNumber(event)"  style="width:90px"/></td>
                                                
                                              <?php } ?>

                                             </tr>
                                             </table>

                                              <br/>
                                             <button type="button" id='delete' class="button1"   onclick="return validateForm3();"   style="text-align:center;width:70px;"><b>  Delete</b></button>
                                             <!--<button type="button" class='addmore'>+ Add New Certificate</button>-->
                                      
                                               <br/><br/>
                                            
                                           </table>

                                              
                                              <div id="dvPassport2"  <?php if($chkFitType1 == 'Y') { ?>  style="display:block";   <?php } else  { ?>   style="display:none";  <?php } ?>>
                                             <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                              
                                             <tr>
                                             <td colspan="3" align="left" class="TitleStyle" ><b><i>PROGRAM DETAILS </i> </b></td>
                                              </tr>
                                                <tr>
                                                <td height="35"></td>
                                                  </tr>  

                                        
                                              <tr>
                                                <td width="120px;" valign="middle">Unique Experience Of Training</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"> <textarea  tabindex="" id="uniqueexperience" name="uniqueexperience"  class="textarea1" style="height: 60px;width:550px;"><?=$uniqueexperience?></textarea>
                                                </td>
                                            </tr>
                                             
                                            <tr>
                                                <td height="15"></td>
                                                  </tr>   
                                        
                                              <tr>
                                                <td width="120px;" valign="middle">Fitness Outcome</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"> <textarea  tabindex="" id="fitnessoutcome" name="fitnessoutcome"  class="textarea1" style="height: 60px;width:550px;"><?=$fitnessoutcome?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="15"></td>
                                                  </tr>   
                                        
                                              <tr>
                                                <td width="120px;" valign="middle">Training Duration</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"> <textarea  tabindex="" id="trainingduration" name="trainingduration"  class="textarea1" style="height: 60px;width:550px;"><?=$trainingduration?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="15"></td>
                                                  </tr>   
                                        
                                              <tr>
                                                <td width="120px;" valign="middle">Background</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"> <textarea  tabindex="" id="background" name="background"  class="textarea1" style="height: 60px;width:550px;"><?=$background?></textarea>
                                                </td>
                                            </tr>
                                        
                                            <tr>
                                                <td height="15"></td>
                                                  </tr>   
                                        
                                              <tr>
                                                <td width="120px;" valign="middle">Special Characteristic</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"> <textarea  tabindex="" id="specialcharateristic" name="specialcharateristic"  class="textarea1" style="height: 60px;width:550px;"><?=$specialcharateristic?></textarea>
                                                </td>
                                            </tr>
                                        
                                            <tr>
                                                <td height="15"></td>
                                                  </tr>   
                                        
                                              <tr>
                                                <td width="120px;" valign="middle">Program Synopsis</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"> <textarea  tabindex="" id="programsynopsis" name="programsynopsis"  class="textarea1" style="height: 60px;width:550px;"><?=$programsynopsis?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="15"></td>
                                                  </tr>   
                                        
                                              <tr>
                                                <td width="120px;" valign="middle">Equipment Used</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"> <textarea  tabindex="" id="equipmentused" name="equipmentused"  class="textarea1" style="height: 60px;width:550px;"><?=$equipmentused?></textarea>
                                                </td>
                                            </tr>
                                        
                                            <tr>
                                                <td height="15"></td>
                                                  </tr>   
                                        
                                              <tr>
                                                <td width="120px;" valign="middle">Address</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"> <textarea  tabindex="" id="address" name="address"  class="textarea1" style="height: 60px;width:550px;"><?=$address?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="15"></td>
                                                  </tr>   
                                        
                                              <tr>
                                                <td width="120px;" valign="middle">Landmark</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"> <textarea  tabindex="" id="landmark" name="landmark"  class="textarea1" style="height: 60px;width:550px;"><?=$landmark?></textarea>
                                                </td>
                                            </tr>
                                        
                                            <tr>
                                                <td height="15"></td>
                                                  </tr>   
                                        
                                              <tr>
                                                <td width="120px;" valign="middle">Public Transport</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"> <textarea  tabindex="" id="publictransport" name="publictransport"  class="textarea1" style="height: 60px;width:550px;"><?=$publictransport?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="15"></td>
                                                  </tr>   
                                        
                                              <tr>
                                                <td width="120px;" valign="middle">Carpark</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"> <textarea  tabindex="" id="carpark" name="carpark"  class="textarea1" style="height: 60px;width:550px;"><?=$carpark?></textarea>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="15"></td>
                                                  </tr>   
                                        
                                              <tr>
                                                <td width="120px;" valign="middle">Amenities Of Training Venue</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"> <textarea  tabindex="" id="amenitiesoftrainingvenue" name="amenitiesoftrainingvenue"  class="textarea1" style="height: 60px;width:550px;"><?=$amenitiesoftrainingvenue?></textarea>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="15"></td>
                                                  </tr>   
                                        
                                              <tr>
                                                <td width="120px;" valign="middle">Preparations Required</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"> <textarea  tabindex="" id="preparations" name="preparations"  class="textarea1" style="height: 60px;width:550px;"><?=$preparations?></textarea>
                                                </td>
                                            </tr>
                                        
                                        </table></div>

                                        <tr>
                                      <td height="35"></td>
                                   
                                 </tr>   

                                            <tr>
                                            <td  align="center">  
                                            <input type="button" class="button1" name="btnBack" value="< Back" onclick="window.location='programs.php?type=<?=encrypt($type,$Encrypt)?>'" />&nbsp;
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




<?php  


if($e_action == 'edit'){
    $total =  $total1+1;
}else{

    $total =2;
}
?>

<script>






 var k='<?php echo $total;?>'

$("#addmore").on('click',function(){
    var data="<tr><td class='gridline2'><input type='checkbox' class='case'/></td><td class='gridline2'> "+k+"</td>";
    data +="<td class='gridline2'><input type='text' id='minimum"+k+"' name='minimum[]'  onkeypress='return isNumber(event)' style='width:90px'/></td> <td class='gridline2'><input type='text' id='maximum"+k+"' name='maximum[]' onkeypress='return isNumber(event)' style='width:90px'/></td><td class='gridline2'><input type='text' id='price"+k+"' name='price[]' onkeypress='return isNumber(event)' style='width:90px'/></td><td class='gridline2'><input type='text' id='nsmanprice"+k+"' name='nsmanprice[]' onkeypress='return isNumber(event)' style='width:90px'/></td></tr>";
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