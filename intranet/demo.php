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
		
	$currentmenu = "Program Charges";

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
	 $programno = $_GET['programno'];
	 $programname = $_GET['programname'];
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
		
        $str = "SELECT tc.*,date_format(tc._CreatedDateTime,'%d/%m/%Y %h:%i:%s %p') as _submitteddate FROM ".$tbname."_trainingcharges  tc
        WHERE tc._ID = '".$id."' ";

		$rst = mysql_query("set names 'utf8';");	
		
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			
			$programname = replaceSpecialCharBack($rs["_ProgramName"]);
            $ProCatID = replaceSpecialCharBack($rs["_ProgramCatID"]);
            
  
            $programtypeID = replaceSpecialCharBack($rs["_TrainingTypeID"]);
            $programsubtypeID = replaceSpecialCharBack($rs["_TrainingSubTypeID"]);
            $programsubsubtypeID = replaceSpecialCharBack($rs["_TrainingSubSubTypeID"]);
       
		
            $status = replaceSpecialCharBack($rs["_Status"]);
        



			$btnSubmit = "Update";
		}
	}else
	{
	
		$customertype = array($_REQUEST['type']);
		
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

    
<script type="text/javascript" src="../js/funct.js"></script>



    <script>

function change_programcharges()

{

    var programtype = $("#programtypeID").val();
    var programsubtype = $("#programsubtypeID").val();
    var programsubsubtype = $("#programsubsubtypeID").val();

     
       $.ajax({

        type: "POST",

        url: "test1.php",

        data: "programtype="+programtype+"&programsubtype="+programsubtype+"&programsubsubtype="+programsubsubtype,

        cache: false,

        success: function(response)

            {

          //alert(response);return false;

       // $("#demo123").html(response);
        $("#demo123").html(response);
            }

            });

           

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
                                          <td align="left" class="TitleStyle"><b>Program Charges</b></td>
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
                                                    echo "Edit Program Charges";
                                                  
                                                }
                                                else
                                                {
                                                    echo "Add Program Charges";
                                                }
											  ?>                                              
								  </td>
								  <td align="right" style="padding-right:2px; vertical-align:bottom"> <a href="programcharges.php" class="TitleLink">List/Search Program Charges</a>
                                              
                                              <?php
											  if($id != "")
											  {
											  ?>
                                              
                                               | <a href="programcharge.php" class="TitleLink">Add New</a>
                                                  
                                              <?php
											  }
											  ?>
                                              
                                              </td>
                                  </tr>
								 
								
                                  
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
                                        <form name="FormName0" action="test1_action.php"  method="post" onsubmit="return validateForm0();" enctype="multipart/form-data">
                                        <input type="hidden" id="id" name="id" value="<?=$id?>" />
                                        <input type="hidden" id="programno" name="programno" value="<?=$programno?>" />
                                        <input type="hidden" name="e_action" value="<?=($e_action == "" ? "addnew" : "edit")?>" />
                                        <input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
                                        <input type="hidden" name="ctab" value="<?=$ctab?>" />

                                        <input type="hidden" name="name" value="<?=$programsubtypeID?>" />

                                        <input type="hidden" name="storevalue" id="storevalue" value="<?=$storevalue?>" />

                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                          <tr>
                                          <td valign="top">
                                              
                                                                                                   
                                                                                                    
                                               
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">


                                             <tr>
                                            <td width="150px" valign="middle">Program Type</td>
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
                                                            <select  tabindex="10" name="programsubsubtypeID" id="programsubsubtypeID" onchange="change_programcharges();" class="dropdown1 chosen-select"  style="width:250px;">
                                                            <option value="">--select--</option>
                                                            <?php
															
															if($programsubtypeID != "")
												{
												
                                                                $sql = "SELECT * FROM ".$tbname."_trainingsubsubtype  
															
																Where _SubTypeID = '". $programsubtypeID."'
																";
                                                                $res = mysql_query($sql) or die(mysql_error());
                                                                if(mysql_num_rows($res) > 0){
                                                                    while($rec = mysql_fetch_array($res)){
                                                                        ?><option <?php if($rec['_ID'] == $programsubsubtypeID  ){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_ID']; ?>"><?php echo $rec['_SubSubTypeName']; ?></option><?php
                                                                    }
                                                                }
																
												}else
												{
													
													 $sql = "SELECT * FROM ".$tbname."_trainingsubsubtype 
                                                     Where _Status = '1'";
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
                                                

                                                </table>
                                          </td>
                                          
                                          </tr>


                                     
                                          
                                          <tr>
                                      <td height="35"></td></tr>
                                         <tr>
                              <td width="50%"></td>
                                         <td>
                                        <button type="button" id='addmore'  class="button1" style="text-align:left;width:70px;"><b>+ Add New</b></button></td></tr>
                                        <tr>
                                        <td height="20"></td></tr>

                                    <table id="demo123" border="0" cellspacing="0"  class="grid" style="text-align:center;width:550px;" >
                                           <!-- <tr>
                                                <th  width="5%"class="gridheader"><input name="AllCheckbox" id="AllCheckbox" type="checkbox"   tabindex="" class='check_all' value="All"  onclick="select_all()" onclick="CheckUnChecked('FormName','CustCheckboxq',document.FormName.cntCheck1.value,this,'<?=$colCount?>');" /></th>
                                                <th width="10%" class="gridheader" style="font-size:12px;">S / No</th>
                                                <th width="20%" class="gridheader" style="font-size:12px;">Minimum </th>
                                                <th width="20%" class="gridheader" style="font-size:12px;">Maximum</th>
                                                <th class="gridheader" width="10px" style="font-size:12px;">Price</th>
                                                <th class="gridheader" width="10px" style="font-size:12px;">NSMAN price</th>
                                               
                                                <input type="hidden" name="cntCheck1" value="<?php echo $i-1; ?>" />
                                            </tr>
                                            <tr>

                                            

                                    <?php 
                                    if($e_action == 'edit')
                                    
                                    {

                                        $str1= "SELECT * FROM ".$tbname."_trainingchargesdetails WHERE _TrainingChargesID = '$id' and _Status=1";


                                  
                                        $rst = mysql_query("set names 'utf8';");
                                        $i=1;
                                            $rst = mysql_query($str1, $connect) or die(mysql_error());

                                            $total=mysql_num_rows($rst);
                                            
                                            if(mysql_num_rows($rst) > 0)
                                            {                                   
                                            while($rs = mysql_fetch_assoc($rst))
                                            { 
                                             
                                                $minimum        = $rs['_MinPerson'];
                                                $maximum        = $rs['_MaxPerson'];            
                                                $totalcost      = $rs['_TotalCost'];
                                                $nsmantotal    = $rs['_NSManTotal'];
                                                
                                            ?>
                                                <td  class="gridline2">
                                                 <input name="CustCheckboxq<?php echo $i; ?>" type="checkbox"  class="case"  tabindex="" value="<?php echo $rs["_ID"]; ?>" onclick="setActivities(this.form.CustCheckboxq<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>','<?=$colCount?>');" />
                                                
                                                <!--<input type='checkbox' class='case' name="CustCheckbox<?php echo $i; ?>" value="<?php echo $rs["_ID"];?>" onclick="setActivities(this.FormName0.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>','<?=$colCount?>');"/>-->
                                                
                                              <!--  </td>
                                                <td class="gridline2"><input type='text' id='srno' name='srno[]' value="<?php echo $i;?>" style="width:15px;border:0px;"></td>
                                                <td  class="gridline2"><input type='text' id='minimum' name='minimum[]' value="<?php echo $minimum;?>"  onkeypress="return isNumber(event)" style="width:120px"/></td>
                                                <td  class="gridline2"><input type='text' id='maximum' name='maximum[]'   value="<?php echo $maximum;?>" onkeypress="return isNumber(event)" style="width:120px"/></td>
                                                <td  class="gridline2"><input type='text' id='price' name='price[]'  onkeypress="return isNumber(event)" onkeypress="return isNumber(event)"  value="<?php echo $totalcost;?>" style="width:90px"/></td>
                                                <td  class="gridline2"><input type='text' id='nsmanprice' name='nsmanprice[]'  onkeypress="return isNumber(event)" onkeypress="return isNumber(event)"  value="<?php echo $nsmantotal;?>" style="width:90px"/></td>
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
                                                <td class="gridline2"><input type='text' id='minimum' name='minimum[]' onkeypress="return isNumber(event)" style="width:120px"/></td>
                                                <td class="gridline2"><input type='text' id='maximum' name='maximum[]' onkeypress="return isNumber(event)" style="width:120px"/></td>
                                                <td class="gridline2"><input type='text' id='price' name='price[]' onkeypress="return isNumber(event)"  style="width:90px"/></td>
                                                <td class="gridline2"><input type='text' id='nsmanprice' name='nsmanprice[]' onkeypress="return isNumber(event)"  style="width:90px"/></td>
                                                
                                             
                                             <?php } ?>

                                          
                                             </tr>-->
                                             </table>

                                              <br/>

                                             <button type="button" id='delete' class="button1"   onclick="return validateForm3();"   style="text-align:center;width:70px;"><b>  Delete</b></button>
                                             <!--<button type="button" class='addmore'>+ Add New Certificate</button>-->
                                
                                              
<br/><br/>
                                          
                                       <tr>
                                       <td  align="center">  
                                            <input type="button" class="button1" name="btnBack" value="< Back" onclick="window.location='programcharges.php?type=<?=encrypt($type,$Encrypt)?>'" />&nbsp;
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
    $a11 =  $total+1;
}else{

    $a11 = 2;
}
?>

<script>

 var k='<?php echo $a11;?>'

$("#addmore").on('click',function(){
    var data="<tr><td class='gridline2'><input type='checkbox' class='case'/></td><td class='gridline2'> <input type='text' id='srno' name='srno[]' value="+k+" style='width:15px;border:0px;'>"+"</td>";
    data +="<td class='gridline2'><input type='text' id='minimum"+k+"' name='minimum[]'  onkeypress='return isNumber(event)' style='width:120px'/></td> <td class='gridline2'><input type='text' id='maximum"+k+"' name='maximum[]' onkeypress='return isNumber(event)' style='width:120px'/></td><td class='gridline2'><input type='text' id='price"+k+"' name='price[]' onkeypress='return isNumber(event)' style='width:90px'/></td><td class='gridline2'><input type='text' id='nsmanprice"+k+"' name='nsmanprice[]' onkeypress='return isNumber(event)' style='width:90px'/></td></tr>";
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