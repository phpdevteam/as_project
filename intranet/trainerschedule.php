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
		
	$currentmenu = "Communities";

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
	
	 $id          = $_GET['id'];
	 $trainerID   = $_GET['oid'];
	 $trainername = $_GET['trainername'];
	 $e_action    = $_GET['e_action'];
	 $ctab        = $_GET['ctab'];
	 $type        = $_REQUEST['type'];
	 //$memberid = $_REQUEST["memberid"]; 
	// var_dump($_REQUEST);


  
	if($ctab=="")
	{
		$ctab = 0;
	}

	
	if($id != "" && $e_action == 'edit' && $ctab == '0')
	{
		
        $str1 = "SELECT  ta.*,p._ProgramName,tg._ID,ta._TrainerID,p._ProgramCatID,p._TrainingTypeID,p._MaxTrainerfeeSurcharge FROM ".$tbname."_trainersavailableslot ta  LEFT JOIN  ".$tbname."_trainingprogram p ON ta._ProgramID = p._ID 
        LEFT JOIN  ".$tbname."_trainingprogramaggregation tg ON ta._ID = tg._TrainerSchduleID 
        
              where  ta._ID = '".$id."' ";	

        
		$rst = mysql_query("set names 'utf8';");	
		
		$rst = mysql_query($str1, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			
            $programID          = replaceSpecialCharBack($rs["_ProgramID"]);
            $trainerID          = replaceSpecialCharBack($rs["_TrainerID"]);
			$schedulardate      = mysqlToDatepicker($rs["_Date"]);
			$schedulartimefrom  = replaceSpecialCharBack($rs["_StartTime"]);
			$schedulartimeto    = replaceSpecialCharBack($rs["_EndTime"]);
            $status             = $rs["_Status"];
            $maxtranerfeesurcharge             = $rs["_MaxTrainerfeeSurcharge"];
            $aggreID            = $rs["_ID"];
            $ProgramCatID            = $rs["_ProgramCatID"];
            $programTypeID            = $rs["_TrainingTypeID"];
            
            $btnSubmit = "Update";

		}
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
    <script src="timepicker.js"></script>   
    <script type="text/javascript" src="../js/functions.js"></script>
     <script type="text/javascript" src="../js/qtip.js"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
	
    <script>
    
function change_trainercharges()
{
    var programtype = $("#programID").val();
   

       $.ajax({

        type: "POST",

        url: "trainermaxcharge.php",

        data: "programtype="+programtype,
        cache: false,

        success: function(response)
           {

          
            $("#maxtranerfeesurcharge").html(response);
  
       
            }

            });

}


</script>
    
    
    
    
    
    
    
    
    
    
    
    
    
    <script type="text/javascript" language="javascript">
		<!--
		//Info Tab
      

        $(document).ready(function () {
        $('#schedulartimefrom').timepicker();   
     });

     $(document).ready(function () {
        $('#schedulartimeto').timepicker();   
     });

		function validateForm0()
		{
			var errormsg;
			errormsg = "";		
			
           
                var x1 = document.forms["FormName0"]["communityname"].value;
               
               if (x1 == "") {
                               alert("Please fill in 'Community Name'.\n");
                               return false;
               }

        }

		$(function() {
			$( "#contractor" ).chosen();
		});
		//-->


        function validateForm4()
		{
			
				document.forms.FormName0.action = "trainerschedule_action.php?action12=delete1";
					document.forms.FormName0.submit();
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
                                          <td align="left" class="TitleStyle"><b>Add/Edit Schedules</b></td>
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
                                                    echo "Edit Schedules";
                                                }
                                                else
                                                {
                                                    echo "Add Schedules";
                                                }
											  ?>                                              
								  </td>
								  <td align="right" style="padding-right:2px; vertical-align:bottom"> <!--<a href="communities.php" class="TitleLink">List/Search Communities</a>-->
                                              
                                              <?php
											  if($id != "")
											  {
											  ?>
                                              
                                               | <a href="trainerschedule.php" class="TitleLink">Add New</a>
                                                  
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
                                        <form name="FormName0" action="trainerschedule_action.php"  method="post" onsubmit="return validateForm0();" enctype="multipart/form-data">
                                        <input type="hidden" id="id" name="id" value="<?=$id?>" />
                                        <input type="hidden" id="customerno" name="customerno" value="<?=$customerno?>" />
                                        <input type="hidden" name="e_action" value="<?=($e_action == "" ? "addnew" : "edit")?>" />
                                        <input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
                                        <input type="hidden" name="ctab" value="<?=$ctab?>" />

                                        <input type="hidden" name="trainerID" value="<?=$trainerID?>" />
                                        <input type="hidden" name="trainername" value="<?=$trainername?>" />
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                          <tr>
                                          <td valign="top">
                                              
                                           <table width="100%" cellpadding="0" cellspacing="0" border="0">
										
                                           <tr>
                                                <td  valign="middle" width="150px">Program Cat</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                                <? $str = "SELECT _ID,_ProgramCatName FROM ".$tbname."_trainingprogramcat ORDER BY _ID";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="ProgramCatID" id="ProgramCatID" class="dropdown1  chosen-select">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $ProgramCatID) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_ProgramCatName"]; ?>&nbsp;</option>
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
                                      <td height="10"></td>
                                 </tr>

                                 <tr>
                                                <td  valign="middle" width="150px">Program Type</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                                <? $str = "SELECT _ID,_TypeName FROM ".$tbname."_trainingtype ORDER BY _ID";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="ProgramTypeID" id="ProgramTypeID" class="dropdown1  chosen-select">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $programTypeID) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_TypeName"]; ?>&nbsp;</option>
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
                                            <td height="10"></td>
                                                  </tr>

                                                     <tr>
                                                <td  valign="middle" width="150px">Program Name</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                                <? $str = "SELECT _ID,_ProgramName FROM ".$tbname."_trainingprogram ORDER BY _ID";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="programID" id="programID" class="dropdown1  chosen-select" onchange="change_trainercharges();" >
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $programID) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_ProgramName"]; ?>&nbsp;</option>
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
                                      <td height="10"></td>
                                           </tr>
                                           <tr>
                                            <td valign="middle" style="width:150px">Date </td>
                                            <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                            <td valign="middle"><input type="text" tabindex="" id="schedulardate" name="schedulardate" value="<?=$schedulardate == ""?date('d/m/Y'):$schedulardate?>" size="60" class="txtbox1 datepicker" style="width:164px;">   <b> (DD/MM/YYYY)</b></td>
                                            </tr>
                                            <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="10"></td>
                                           </tr>


                                              <tr>
                                            <td valign="middle" style="width:150px">Time </td>
                                            <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                            <td valign="middle"><input type="text" tabindex="" id="schedulartimefrom" name="schedulartimefrom" value="<?php echo $schedulartimefrom;?>" size="60" class="txtbox1"  style="width:80px;"> To 
                                            <input type="text" tabindex="" id="schedulartimeto" name="schedulartimeto" value="<?php echo $schedulartimeto;?>" size="60" class="txtbox1"  style="width:80px;"></td>
                                          
                                            </tr>


                                            <tr>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            <td height="10"></td>
                                            </tr>

                                            <tr>
                                            <td colspan="2" valign="middle" style="width:150px">Max Trainer Fee Surcharge </td>
                                           
                                            <td valign="middle">    <div id="maxtranerfeesurcharge" name ="maxtranerfeesurcharge"  size="60" class="txtbox1"  readonly="readonly"   style="width:120px;padding: 1px;"><?php echo $maxtranerfeesurcharge;?> </div> </td>
                                            </tr>
                                          
                                           
                                            </table>
                                          
                                              </td>
                                          
                                             <td width="30px"></td>
                                          
                                            <td valign="top" align="right">
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tbllabel">
                                                
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

							
                                                                                     
                                                    </table>
                                                    </td>
                                          
                                                    </tr>
                                                    <tr>
                                                     <td height="15"></td>
                                    
                                                         </tr>


                                                        <tr>
                                                    <td width="40%"></td>
                                                    <td ></td>
                                                    <td>
                                                    <button type="button" id='addmore'  class="button1" style="text-align:left;width:70px;"><b>+ Add New</b></button></td></tr>
                                                    <tr>
                                                    <td height="20"></td></tr>

                                                     <table id="demo123" border="0" cellspacing="0"  class="grid" style="text-align:center;width:392px;" >
                                                    <tr>
                                                <th  width="5%"class="gridheader"><input name="AllCheckbox" id="AllCheckbox" type="checkbox"   tabindex="" class='check_all' value="All"  onclick="select_all()" onclick="CheckUnChecked('FormName','CustCheckboxq',document.FormName.cntCheck1.value,this,'<?=$colCount?>');" /></th>
                                                <th width="10%" class="gridheader" style="font-size:12px;"> No</th>
                                                <th width="50%" class="gridheader" style="font-size:12px;">Surchage Item Name </th>
                                            
                                                <th width="10%" class="gridheader" style="font-size:12px;">Amount</th>
                         
                                                <input type="hidden" name="cntCheck1" value="<?php echo $i-1; ?>" />
                                            </tr>
                                            <tr>

                                    <?php 
                                    if($e_action == 'edit')
                                    
                                    {
                                     

                                        $str1= "SELECT * FROM ".$tbname."_trainingprogramsurcharge WHERE _ProgramaggregationID = '$aggreID' AND _AddedBy ='Trainer' AND _Status=1";

                                 
                                        $rst1 = mysql_query("set names 'utf8';");
                                        $i=1;
                                            $rst1 = mysql_query($str1, $connect) or die(mysql_error());

                                            $totalsurcharge  = mysql_num_rows($rst1);
                                            
                                            
                                            if(mysql_num_rows($rst1) > 0)
                                            {                                   
                                            while($rs1 = mysql_fetch_assoc($rst1))
                                            { 
                                             
                                                $surchageitemID        = $rs1['_SurchargeItemID'];
                                                $itemamount            = $rs1['_Amount'];    
                                              
                                            ?>
                                                <td  class="gridline2">
                                                <input name="CustCheckboxq<?php echo $i; ?>" type="checkbox"  class="case"  tabindex="" value="<?php echo $rs1["_ID"]; ?>" onclick="setActivities(this.form.CustCheckboxq<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>','<?=$colCount?>');" />
                                                
                                                <!--<input type='checkbox' class='case' name="CustCheckbox<?php echo $i; ?>" value="<?php echo $rs["_ID"];?>" onclick="setActivities(this.FormName0.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>','<?=$colCount?>');"/>-->
                                                
                                                </td>
                                                <td class="gridline2"><input type='text' id='srno' name='srno[]' value="<?php echo $i;?>" style="width:15px;border:0px;"></td>
                                                <td  class="gridline2">
                                                
                                                
                                                <? $str = "SELECT _ID,_SurchargeItemName FROM ".$tbname."_surchargeitemlist ORDER BY _ID";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="surchageitem[]" id="surchageitem"style="width:180px;">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $surchageitemID) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_SurchargeItemName"]; ?>&nbsp;</option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            
                                                
                                                </td>
                                                <td  class="gridline2"><input type='text' id='itemamount' name='itemamount[]' class="itemamount1"   value="<?php echo $itemamount;?>"  style="width:120px"/></td>
                                               
                                            </tr>	
                                  
                                             <?php
                                    
                                              $i++;
                                                }
                                                 }
                                            ?>
                                             <input type="hidden" name="cntCheck1" value="<?php echo $i-1; ?>" />        
                                                <?php } else {?>
                                             <tr>
                                               <td class="gridline2"><input type='checkbox' class='case'  name="AllCheckbox1" id="AllCheckbox1"value="All" onclick="CheckUnChecked('FormName0','CustCheckboxq',document.FormName0.cntCheck1.value,this,'<?=$colCount?>');"  /></td>
                                                <td class="gridline2" width="30px;"><input type='text' id='srno' name='srno[]'  style="width:0px;border:0px;">1</td>
                                               
                                                <td class="gridline2">
                                                <? $str = "SELECT _ID,_SurchargeItemName FROM ".$tbname."_surchargeitemlist ORDER BY _ID";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="surchageitem[]" id="surchageitem"style="width:180px;">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $surchageitem) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_SurchargeItemName"]; ?>&nbsp;</option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select></td>
                                              
                                                <td class="gridline2"><input type='text' id='itemamount'  class ="cost" name='itemamount[]'  style="width:120px"/></td>
                                              
                                            
                                             <?php } ?>

                                            
                                          
                                    
                                             </tr>
                                        
                                             </table>
                                            <br/>

                                             <button type="button" id='delete' class="button1"   onclick="return validateForm4();"   style="text-align:center;width:70px;"><b>  Delete</b></button>
                                             <!--<button type="button" class='addmore'>+ Add New Certificate</button>-->
                                
                                              
<br/><br/>

                                  <tr>
                                        <td>
                                        <button type="button" id='addmore4'  class="button1" style="text-align:left;width:121px;margin-left: 348px;"><b>+ Add One More File</b></button></td></tr>
                                        <tr>
                                        <td height="20"></td></tr>

                                    <table id="demo1234" border="0" cellspacing="0"  class="grid" style="text-align:center;" >
                                            
                                            <tr>
                                    <?php 
                                    if($e_action == 'edit')
                                    
                                    {
                                     

                                        $str1= "SELECT * FROM ".$tbname."_trainerrelevantqualification WHERE _TranerID	 = '$trainerID' and _Status=1 AND _RelevSrNo IS NULL" ;
                                        $rst1 = mysql_query("set names 'utf8';");
                                        $i=1;
                                            $rst1 = mysql_query($str1, $connect) or die(mysql_error());

                                            $total=mysql_num_rows($rst1);
                                            
                                            if(mysql_num_rows($rst1) > 0)
                                            {                                   
                                            while($rs1 = mysql_fetch_assoc($rst1))
                                            { 
                                             
                                                $filename1             = $rs1['_Filename1'];
                                                $itemamount1            = $rs1['_Amount'];    
                                              
                                            ?>
                                                
                                                <td>
                                                
                                                
                                                Select From Existing List 	   <? $str = "SELECT _ID,_Filename1 FROM ".$tbname."_trainerrelevantqualification WHERE  _TranerID ='$trainerID'";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="surchargefile[]" id="surchargefile"style="width:150px;">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_Filename1"] == $filename1) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_Filename1"]; ?>&nbsp;</option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            
                                                </td>
                                                <td ><input type='file' id='attFile1' name='attFile1[]'style="width:86px"/><?php echo $filename1;?></td>
                                               
                                            </tr>	
                                  
                                             <?php
                                    
                                              $i++;
                                                }
                                                 }
                                            ?>
                                                     
                                                <?php } else {?>
                                             <tr>
                                              
                                                <td> Select From Existing List
                                                <? $str = "SELECT _ID,_Filename1 FROM ".$tbname."_trainerrelevantqualification WHERE _TranerID ='$trainerID'";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="surchargefile[]" id="surchargefile"style="width:150px;">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $surchageitem) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_Filename1"]; ?>&nbsp;</option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select></td>
                                              
                                                <td><input type="file" name="attFile1[]" size="40" class="txtbox1" style="width:140px;"></td>
                                              
                                             <?php } ?>
                                             </tr>
                                            
                                             </table>
                                          <tr>
                                          
                                          <tr>
                                        <td height="20"></td></tr>    
                                             <td align="center" >
                                            <input type="button" class="button1" name="btnBack" value="< Back"  onclick="history.back();" />&nbsp;
                                            <input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
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
    $a11 =  $totalsurcharge+1;
}else{

    $a11 = 2;
}
?>

<script>

 var k='<?php echo $a11;?>'

$("#addmore").on('click',function(){
    var data="<tr><td class='gridline2'><input type='checkbox' class='case'/></td><td class='gridline2'> <input type='text' id='srno' name='srno[]' value="+k+" style='width:15px;border:0px;'>"+"</td>";
    data +="<td class='gridline2'><select name='surchageitem[]' style='width:180px;'><option>-- Select One --</option><option value='1'>Trainer Fee</option><option value='2'>Shower Charge</option><option value='3'>Premium Gym Charge</option><option value='4'>Loaded MVT Charge</option></select></td> <td class='gridline2'><input type='text' class ='cost'  id='itemamount"+k+"'   name='itemamount[]' style='width:120px'/></td></tr>";
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

<script>

 var k='<?php echo $a11;?>'

$("#addmore4").on('click',function(){
    var data="<tr>";
    data +="<td>Select From Existing List <select name='surchargefile[]' style='width:150px;'><option>-- Select One --</option><option value='1'>trainer_action-11-AUG-2017.php</option><option value='2'>xyz.php</option><option value='3'>Premium Gym Charge</option><option value='4'>Loaded MVT Charge</option></select></td> <td><input type='file' name='attFile1[]' size='40' class='txtbox1' style='width:140px;'></tr>";
	$('#demo1234').append(data);
	k++;
});
</script>




<script>
$(document).ready(function(){
    $(".cost").each(
        function(){
        $(this).keyup(
            function(){
            calculateSum()
                });
            });
        });

        function calculateSum(){
            var sum=0;
            $(".cost").each(
            function(){
                var vl = this.value.replace(',','');
                if(!isNaN(vl) && vl.length!=0){
                    sum+=parseFloat(vl);
                    }
                }); 

            $("#sum").val(sum.toFixed(2));
            }



</script>
