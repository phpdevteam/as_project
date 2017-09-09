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
          $preparations = replaceSpecialCharBack($rs["_PreparationRequired"]);   











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
  </script>






cost 1 :<input type="text" class="cost" name="cost1" /><br />
cost 2 :<input type="text" class="cost" name="cost2" /><br />
cost 3 :<input type="text" class="cost" name="cost3" /><br />
cost 4 :<input type="text" class="cost" name="cost4" /><br /><br />
sum : <input type="text" id="sum" readonly />



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







<div id="maxtranerfeesurcharge" name ="maxtranerfeesurcharge"  size="60" class="txtbox1"  readonly="readonly"   style="width:120px;padding: 1px;">100 </div>



<script>

function valid(){
	var x=document.getElementById("sum1").value;
	var y=100;
	if(x==y)
	{alert("ok");
	return false;
	}
	else
	{alert("nok");
	return false;
	}
    }
    </script>