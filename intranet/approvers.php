<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
		exit();
    }
	include('../global.php');	
	include('../include/functions.php'); include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");
	

	
	$btnSubmit = "Update";
	$module = $_GET['module'];
	
		if($module == 1)
		{
			$modulename = "Purchase";
				$Operations = GetAccessRights(250);
				if(count($Operations)== 0)
				{
				 echo "<script language='javascript'>history.back();</script>";
				}
		 }
		else if($module == 2)
		{
			$modulename = "Invoices";
			$Operations = GetAccessRights(265);
				if(count($Operations)== 0)
				{
				 echo "<script language='javascript'>history.back();</script>";
				}
			}
		else if($module == 3)
		{
			$modulename = "SQ";
			$Operations = GetAccessRights(249);
				if(count($Operations)== 0)
				{
				 echo "<script language='javascript'>history.back();</script>";
				}
			}
			
		$str = "SELECT * FROM ".$tbname."_approvers Where _Module = '" . $modulename ."'";
		
		$rst = mysql_query($str, $connect);
		
		
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			
			 $id = $rs['_ID'];
			 $approver1 = $rs['_FirstApprovers'];
			 $approver2 = $rs['_SecApprovers'];
			 $maxAmt1 = $rs['_FirstAmt'];

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
<script type="text/javascript" language="javascript"></script>

</head>

<body>
    <table align="center" width="970" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="align:center;">
      <tr>
        <td valign="top"><div class="maintable">
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top"><?php include('topbar.php'); ?></td>
              </tr>
              <tr>
                <td class="inner-block" width="970" align="left" valign="top"><div class="m">
                	<form name="FormName" action="approvers_action.php" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
                    	<input type="hidden" name="modulename" value="<?=$modulename ?>" />
                        <input type="hidden" name="id" value="<?=$id ?>" />
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                          <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                      <td align="left" class="TitleStyle" colspan="3"><b>Settings > <?php echo $modulename ?> > Approvers</b></td>
                                    </tr>
                                    
                                    <tr><td height="5"></td></tr>	
                                 
                   				  <tr>
                                        <td colspan="6"><b>Approvers</b></td>
                                    </tr>
                                  <tr><td height="5"></td></tr>						
                     
                                    <tr>
                                        <td width="200">Approver 1</td>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td ><select  tabindex="" name="approver1" class="dropdown1 chosen-select" id="approver1">
                                              <option value="">-- Select One --</option>
                                              <?
                                                  $query = "SELECT _ID,_Username FROM ".$tbname."_user WHERE _status = '1' and _Username <> '' ORDER BY _Username";
                                                  $row = mysql_query('SET NAMES utf8');
                                                  $row = mysql_query($query,$connect);
                                                  while($data=mysql_fetch_assoc($row)){
                                              ?>
                                              <option value="<?=$data['_ID']?>" <? if($data['_ID']==$approver1) echo " selected"; ?>><?=$data['_Username'];?></option>
                                              <?	} ?>
                                            </select>
                                         </td>
                                    </tr>								
                                    <tr><td height="5"></td></tr>  
                                    
                                      <tr>
                                        <td>Max Amount Approval By This User</td>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td>No Limit</td>
                                    </tr>								
                                    <tr><td height="5"></td></tr> 
                                                   
                                    <tr>
                                        <td>Approver 2</td>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td><select  tabindex="" name="approver2" class="dropdown1 chosen-select" id="approver2">
                                              <option value="">-- Select One --</option>
                                              <?
                                                  $query = "SELECT _ID,_Username FROM ".$tbname."_user WHERE _status = '1' and _Username <> '' ORDER BY _Username";
                                                  $row = mysql_query('SET NAMES utf8');
                                                  $row = mysql_query($query,$connect);
                                                  while($data=mysql_fetch_assoc($row)){
                                              ?>
                                              <option value="<?=$data['_ID']?>" <? if($data['_ID']==$approver2) echo " selected"; ?>><?=$data['_Username'];?></option>
                                              <?	} ?>
                                            </select></td>
                                	</tr>	
                                    <tr><td height="5"></td></tr>	
                                     <tr>
                                        <td>Max Amount Approval By This User</td>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td>No Limit</td>
                                	</tr>	
                                    <tr><td height="5"></td></tr>																
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                        <td colspan="4">
                                            <input name="btnBack" type="button" class="button1" onClick="window.location='settings.php';" value="&lt; Back">
                                            <input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit ?>">&nbsp;&nbsp;
                                        </td>
                                    </tr>
                                  </table>
                             </td>
                          </tr>
                         </table>
                    </form></div></td>
                      </tr>
                    </table>
           </div>
          </td>
      </tr>
</table>
    <? include('jqueryautocomplete.php') ?>   
</body>
</html>