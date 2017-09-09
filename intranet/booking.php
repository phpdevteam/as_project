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
		
	$currentmenu = "Bookings";

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
		
        $str = "SELECT tp.*,t._FullName,v._VenueName,v._Address,tc._ClientID,tt._TypeName,ag._ProgramDate,ag._StartTime,ag._EndTime,ag._EndTime,ag._TrainingStatus,ag._TotalAmount FROM ".$tbname."_trainingprogram AS tp  INNER JOIN  as_trainingprogramaggregation ag ON tp._ID = ag._ProgramID 
        INNER JOIN  ".$tbname."_trainingprogramclientlist AS tc  ON tc._ProgramaggregationID = ag._ID
        LEFT JOIN  ".$tbname."_trainers AS t  ON tp._TrainerID = t._ID 
        LEFT JOIN  ".$tbname."_venues AS v  ON tp._VenueID = v._ID 
        LEFT JOIN  ".$tbname."_trainingtype AS tt  ON tp._TrainingTypeID = tt._ID
        WHERE tp._ID = '".$id."' ";


        //echo $str;

		$rst = mysql_query("set names 'utf8';");	
		
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			
            $programname = replaceSpecialCharBack($rs["_ProgramName"]);
            $ProgramRefID = replaceSpecialCharBack($rs["_ProgramRefID"]);
            $venuename = replaceSpecialCharBack($rs["_VenueName"]);
            $programstatus = replaceSpecialCharBack($rs["_TrainingStatus"]);
            $venueaddress = replaceSpecialCharBack($rs["_Address"]);
            $createdDate = mysqlToDatepicker($rs["_ProgramDate"]);
            $starttime = replaceSpecialCharBack($rs["_StartTime"]);
            $endtime = replaceSpecialCharBack($rs["_EndTime"]);
            $programtypename = replaceSpecialCharBack($rs["_TypeName"]);
            $clientID = replaceSpecialCharBack($rs["_ClientID"]);
            
     

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
           
          
        }


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
                                          <td align="left" class="TitleStyle"><b>My Bookings</b></td>
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
                                                    echo "View Bookings Details";
                                                }
                                                else
                                                {
                                                    echo "Add Bookings";
                                                }
											  ?>                                              
								  </td>
								<!--  <td align="right" style="padding-right:2px; vertical-align:bottom"> <a href="programs.php" class="TitleLink">List/Search Programs</a>
                                              
                                              <?php
											  if($id != "")
											  {
											  ?>
                                              
                                               | <a href="program.php" class="TitleLink">Add New</a>
                                                  
                                              <?php
											  }
											  ?>
                                              
                                              </td>-->
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
                                                <td valign="middle" width="260px"><?php echo $programname;?> </td>
                                              
                                            </tr>
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>
                                          

                                             <tr>
                                                <td valign="middle" width="150px">Program Ref ID</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><?php echo $ProgramRefID;?> </td>
                                              
                                            </tr>


                                            <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>
                                          

                                             <tr>
                                                <td valign="middle" width="150px">Venue Name</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><?php echo $venuename;?> </td>
                                              
                                            </tr>

                                            <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="5"></td>
											 </tr>
                                          

                                             <tr>
                                                <td valign="middle" width="150px">Status</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><?php echo $programstatus;?> </td>
                                              
                                            </tr>


                                                    </table>
                                                    </div>

                                        
                                          
                                          </td>
                                          
                                          <td width="30px"></td>
                                          
                                          <td valign="top" align="right">
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tbllabel">
                                            <tr>
                                            <td valign="middle" width="150px">Venue Address</td>
                                            <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                            <td valign="middle"><?php echo $venueaddress;?></td>
                                            </tr>
                                              
                                            <tr>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            </tr>
                                              
                                            <tr>
                                                <td valign="middle"> Date</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><span><?php echo $createdDate;?> </span></td>
                                              </tr>


                                              <tr>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            <td height="5"></td>
                                            </tr>
                                              
                                            <tr>
                                                <td valign="middle">Time</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><span><?php echo $starttime;?> to <?php echo $endtime;?></span></td>
                                              </tr>


                                                
                                                 <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                             
                                 <tr>
                                                    <td valign="middle">Type</td>
                                                    <td valign="middle">&nbsp;:&nbsp;</td>
                                                    <td valign="middle"><?php echo $programtypename; ?></td>
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
                                      <td height="35"></td>
                                   
                                 </tr>   

                                 <tr>
                                 <td align="left" class="TitleStyle" colspan="2" style="font-size:14px;"><b><i>Client List For Training</i> </b></td>
                             </tr>
                                         
                             <tr>
                                      <td height="15"></td>
                                   
                                 </tr>       

                                    <table id="demo123" border="0" cellspacing="0"  class="grid" style="text-align:center;width:400px;" >
                                   
                                     
                                        <tr>
                                              
                                                <th width="10%" class="gridheader" style="font-size:12px;">No</th>
                                                <th width="20%" class="gridheader" style="font-size:12px;">Client Ref No </th>
                                                <th width="20%" class="gridheader" style="font-size:12px;">Client Name</th>
                                                <th class="gridheader" width="20%" style="font-size:12px;">Contact Num</th>
                                                <th class="gridheader" width="20%" style="font-size:12px;">Client Picture</th>

                                            </tr>

                                            <tr>

                                            <?php 
                                            if($id!= '')
                                            
                                            {

                                           $str1= "SELECT * FROM ".$tbname."_client WHERE _id = '$clientID' and _status=1";

                                           $rst = mysql_query("set names 'utf8';");
                                           $i=1;
                                            $rst = mysql_query($str1, $connect) or die(mysql_error());
                                            $total1 =mysql_num_rows($rst);                                          
                                            if(mysql_num_rows($rst) > 0)
                                            {                                   
                                            while($rs = mysql_fetch_assoc($rst))
                                            { 
                                              
                                                $clientrefID  = $rs['_customerid'];
                                                $clientname  = $rs['_fullname'];            
                                                $price   = $rs['_Price'];
                                                $price   = $rs['_Price'];
                                                $nsmanprice =$rs['_NsmanPrice'];
                                            ?>
                                               
                                                <td class="gridline2"><?php echo $i;?></td>
                                                <td  class="gridline2"><?php echo $clientrefID;?></td>
                                                <td  class="gridline2"></td>
                                                <td  class="gridline2"></td>
                                                <td  class="gridline2"></td>
                                               
                                                 </tr>	
                                  
                                             <?php
                                    
                                              $i++;
                                                }
                                                 }
                                            ?>
                                            </tr>
                                          
                                             </table>
                                                <?php } ?>

                                                <tr>
                                      <td height="105"></td>
                                   
                                 </tr>    
                                          
                                            <tr>
                                            <td  align="center">  
                                            <input type="button" class="button1" name="btnBack" value="< Back" onclick="window.location='bookings.php?type=<?=encrypt($type,$Encrypt)?>'" />&nbsp;
                                          <!--  <input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />-->
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

