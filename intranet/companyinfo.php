<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']=="")
{
echo "<script language='javascript'>window.location='login.php';</script>";
}
include('../global.php');	
include('../include/functions.php');  include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");

$Operations = GetAccessRights(54);
if(count($Operations)== 0)
{
 echo "<script language='javascript'>history.back();</script>";
}

$currentmenu = "Settings";
$AdminfilePath = "uploadfiles/";

$id = "";
$companyname1 = "";
$companyaddress1 = "";
$companyaddress2 = "";
$companyaddress3 = "";
$postalcode="";
$defaultcurrency="USD";
$companylhead1 = "";

$str = "SELECT * FROM ".$tbname."_companyinfo";
$rst = mysql_query("set names 'utf8';");	
$rst = mysql_query($str, $connect) or die(mysql_error());
if(mysql_num_rows($rst) > 0)
{
$rs = mysql_fetch_assoc($rst);
$id = $rs['_id'];
$companyname1 = $rs['_companyname1'];
$companyaddress1 = $rs['_companyaddress1'];
$companylhead1 = $rs['_letterheadimage1'];
$companyaddress2 = $rs['_companyaddress2'];
$companyaddress3 = $rs['_companyaddress3'];
$telephone = $rs['_companytelephone'];
$fax = $rs['_companyfax'];
$companycountryid = $rs['_countryid'];
$postalcode = $rs['_postalcode'];
$defaultcurrency = $rs['_defaultcurrency'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $gbtitlename; ?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css" />
<script type="text/javascript" src="../js/validate.js"></script>
    <? include('jquerybasiclinks10_3.php'); ?>
    <? include('../jqueryinclude.php'); ?>
    <link rel="stylesheet" href="../jquery/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="../jquery/autocomplete/docsupport/prism.css">
    <link rel="stylesheet" href="../jquery/autocomplete/chosen.css" />
<script type="text/javascript" src="../jquery/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
   <script type="text/javascript" src="../js/functions.js"></script>
<script type="text/javascript" language="javascript">
<!--
function validateForm()
{
var errormsg;
	errormsg = "";	
				
if (document.FormName.companyname1.value == 0)
	errormsg += "Please fill in 'First Company's Name'.\n";

if (document.FormName.companyaddress1.value == 0)
	errormsg += "Please fill in 'First Company's Address'.\n";

if ((errormsg == null) || (errormsg == ""))
{
	document.FormName.btnSubmit.disabled=true;
	return true;
}
else
{
	alert(errormsg);
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
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top"><?php include('topbar.php'); ?></td>
      </tr>
        <tr>
      
        <td class="inner-block" width="970" align="left" valign="top">
      
      <div class="m"> 
        <!-- START TABLE FOR DIVISION - PRASHANT -->
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td align="left" class="TitleStyle"><b>Settings - System - Company Info </b></td>
                </tr>          
              </table>
              <form name="FormName" action="companyinfo_action.php" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?=$id?>" />
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                  <tr>
                    <td style="padding-top:5px;" colspan="3"><b>Company Info</b></td>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                  <tr>
                    <td width="150px" valign="middle">Company's Name</td>
                    <td  width="10px"  valign="middle">&nbsp;:&nbsp;</td>
                    <td  valign="middle"><input type="text" tabindex="" name="companyname1" value="<?=$companyname1?>" class="txtbox1" style="width:220" />
                      <span class="detail_red">*</span></td>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                  <tr>
                    <td width="150px"  valign="middle">Company's Address Line 1</td>
                    <td  width="10px"  valign="middle">&nbsp;:&nbsp;</td>
                    <td  valign="middle"><input type="text" tabindex="" name="companyaddress1" value="<?=$companyaddress1?>" class="txtbox1" style="width:220" />
                      <span class="detail_red">*</span></td>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                   <tr>
                    <td  width="150px"  valign="middle">Company's Address Line2</td>
                    <td  width="10px"  valign="middle">&nbsp;:&nbsp;</td>
                    <td  valign="middle"><input type="text" tabindex="" name="companyaddress2" value="<?=$companyaddress2?>" class="txtbox1" style="width:220" /></td>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                   <tr>
                    <td  width="150px"  valign="middle">Company's Address Line 3</td>
                    <td  width="10px"  valign="middle">&nbsp;:&nbsp;</td>
                    <td  valign="middle"><input type="text" tabindex="" name="companyaddress3" value="<?=$companyaddress3?>" class="txtbox1" style="width:220" /></td>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                   <tr>
                    <td  width="150px"  valign="middle">Telephone</td>
                    <td  width="10px"  valign="middle">&nbsp;:&nbsp;</td>
                    <td  valign="middle"><input type="text" tabindex="" name="telephone" value="<?=$telephone?>" class="txtbox1" style="width:220" /></td>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                   <tr>
                    <td width="150px"  valign="middle">Fax</td>
                    <td width="10px"  valign="middle">&nbsp;:&nbsp;</td>
                    <td  valign="middle"><input type="text" tabindex="" name="fax" value="<?=$fax?>" class="txtbox1" style="width:220" /></td>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                   <tr>
                    <td width="150px"  valign="middle">Country</td>
                    <td width="10px"  valign="middle">&nbsp;:&nbsp;</td>
                    <td  valign="middle">
                    	<select  tabindex="" name="companycountryid" id="companycountryid" class="dropdown1 chosen-select" style="width:220px;">
                            <option value="">--select--</option>
                            <?php
                                $sql = "SELECT * FROM ".$tbname."_countries ORDER BY if(UPPER(_countryname)= 'SINGAPORE',1,_countryname)";
                                $res = mysql_query($sql) or die(mysql_error());
                                if(mysql_num_rows($res) > 0){
                                    while($rec = mysql_fetch_array($res)){
                                        ?><option <?php if($rec['_id'] == $companycountryid){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_id']; ?>"><?php echo $rec['_countryname']; ?></option><?php
                                    }
                                }
                            ?>
                            </select>
                    </td>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                   <tr>
                    <td width="150px"  valign="middle">Postal Code</td>
                    <td width="10px"  valign="middle">&nbsp;:&nbsp;</td>
                    <td  valign="middle"><input type="text" tabindex="" name="postalcode" value="<?=$postalcode?>" class="txtbox3" style="width:220" />
                      </td>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                   <tr>
                    <td  width="150px"  valign="middle">Default Currency</td>
                    <td  width="10px"  valign="middle">&nbsp;:&nbsp;</td>
                    <td  valign="middle">                    
                    <select  tabindex="" name="defaultcurrency" id="defaultcurrency" class="dropdown1 chosen-select" style="width:220px;">
                            <option value="">--select--</option>
                            <?php
                                $sql = "SELECT * FROM ".$tbname."_currencies ORDER BY _currencyshortname";
                                $res = mysql_query($sql) or die(mysql_error());
                                if(mysql_num_rows($res) > 0){
                                    while($rec = mysql_fetch_array($res)){
                                        ?><option <?php if($rec['_ID'] == $defaultcurrency){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_ID']; ?>"><?php echo $rec['_currencyshortname']; ?></option><?php
                                    }
                                }
                            ?>
                            </select>
                    
                      </td>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                  <tr>
                    <td  width="150px"  valign="middle">Company's Letter Head Image</td>
                    <td  width="10px"  valign="middle">&nbsp;:&nbsp;</td>
                    <td  valign="middle"><input type="hidden" name="image1exist" value="<?php echo $companylhead1;?>">
                      <?php 
if(file_exists($AdminfilePath.$companylhead1) && $companylhead1 != "") 
{
?>
                      <a href="<?=$httpaddress?>/intranet/<?php echo $AdminfilePath.$companylhead1;?>" target="_blank" style="color:#FF0000; font-family:Book Antiqua; font-size:11px;">
                      <?=$companylhead1?>
                      </a>&nbsp; <a href="companyinfo_action.php?e_action=objdelete&file=1" onclick="if(confirm('Are you sure you want to delete this file?')) return true; else return false;" onMouseOver="write_it('Delete File');return true;" class="link1">[<img src="images/delfilepic.gif" border="0" alt="Delete File"> Delete File]</a>
                      <?php
}
else
{
?>
                      <input type="file" name="firstfile" value="<?=$companylhead1?>" /></td>
                    <?php
}
?>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                  
                  <tr>
                    <td colspan="2">&nbsp;</td>
                    <td> <input type="button" class="button1" name="btnCancel" value="< Back" onclick="window.location='settings.php'" /> &nbsp;&nbsp;<input type="submit" name="btnUpdate" class="button1" value="Update" />
                     
                     </td>
                  </tr>
                </table>
              </form>
          <tr>
            <td height="5"></td>
          </tr>               
        </table>
        <!-- END TABLE FOR DIVISION - PRASHANT --> 
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