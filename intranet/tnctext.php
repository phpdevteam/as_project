<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
    }
	include('../global.php');	
	include('../include/functions.php');  include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");

	$Operations = GetAccessRights(244);
				if(count($Operations)== 0)
				{
				 echo "<script language='javascript'>history.back();</script>";
				}
	
	
	$PageStatus = "Add T&amp;C";	
	$btnSubmit = "Submit";
	$id = $_GET['id'];
	$e_action = $_GET['e_action'];
	
	$currentmenu = "Settings";

	if($id != "" && $e_action == 'edit')
	{
		
		$str = "select * from ".$tbname."_tnctext where _id= '".$id."' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			
			$id= $rs['_id'];
			$title = $rs['_title'];
			$tncRemarks = replaceSpecialCharBack($rs['_tnc']); 
			$status = $rs['_status'];
			
			$PageStatus = "Edit T&amp;C";
			$btnSubmit = "Update";
		}
	}
	else
	{
		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?php echo $gbtitlename; ?></title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />			
	<script type="text/javascript" src="../js/validate.js"></script>
	<script src="../js/drag_drop/jquery-1.6.2.js"></script> 
	<script language="javascript" type="text/javascript">
		<!--		
		function validateForm()
		{
			var errormsg;
            errormsg = "";					          
			
			if (document.tnctext.e_action.value == "AddNew"){
				if (document.tnctext.title.value == 0) errormsg += "Please fill in 'Brand Name'.\n";
			}
			
			if ((errormsg == null) || (errormsg == ""))
            { }
            else
            {
                alert(errormsg);
                return false;
            }
		}
		function ClearAll()
		{
			for (var i=0;i<document.tnctext.elements.length;i++) {
				if (document.tnctext.elements[i].type == "text" || document.tnctext.elements[i].type == "textarea" ||document.tnctext.elements[i].type == "password")
					document.tnctext.elements[i].value = "";
				else if (document.tnctext.elements[i].type == "select-one")
					document.tnctext.elements[i].selectedIndex = 0;
				else if (document.tnctext.elements[i].type == "checkbox" || document.tnctext.elements[i].type == "radio")
					document.tnctext.elements[i].checked = false;
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
						<!-- START TABLE FOR DIVISION - PRASHANT -->
						<table width="100%" cellspacing="0" cellpadding="0" border="0">
						<tr>
						<!-- <td width="20%" valign="top" align="left"> -->
							<!-- START CODE FOR LEFT MENU - PRASHANT -->
							<?php
								//$CurrPage = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); /* Getting File Name */
								//include "setting_leftmenu.php";
							?>
							<!-- END CODE FOR LEFT MENU - PRASHANT -->
							<!-- </td> -->
							
							<td>
							
							<!-- START CODE FOR MAIN CONTENT - PRASHANT -->
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
								  <td align="left" class="TitleStyle"><b>Settings > Manage T&amp;C List > <?=$PageStatus?></b></td>
								</tr>
								<tr><td height="10"></td></tr>
							</table>							
							<form name="tnctext" action="tnctext_action.php" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
							<input type="hidden"  name="id" value="<?=$id?>" />
							<input type="hidden" name="e_action" value="<?=($e_action == "" ? "AddNew" : "Edit")?>" />
							<input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								
								<tr><td height="5"></td></tr>
								<tr>
									<td nowrap>&nbsp;Title&nbsp;</td>
									<td>&nbsp;:&nbsp;</td>
									<td>
									
										<input type="text" tabindex="" id="title" name="title" value="<?=$title?>" size="60" class="txtbox1" /> <span class="detail_red">*</span> 
								
									</td>
								</tr>
								
                                <tr><td height="5"></td></tr>  
                                
                                  <tr>
                                                <td>T&amp;C</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td width="700">
                                                
                                                
                                                   <?php 													
													$sBasePath = 'fckeditor/';
													$oFCKeditor = new FCKeditor('tnc');
													$oFCKeditor->Width = "760px";
													$oFCKeditor->Height = "400px";
													$oFCKeditor->BasePath = $sBasePath;
													$oFCKeditor->Value = replaceSpecialCharBack($tncRemarks);
													$oFCKeditor->Create();
													
												?>
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                </td>
                                            </tr>								
                                            <tr><td height="5"></td></tr>     
                                
                                <tr><td width="130">&nbsp;System Status&nbsp;</td>
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
									<input type="radio"   tabindex="" <?php echo $sel_status_n; ?> name="status" value="2" id="RadioGroup1_1" class="radio" />Archive</td></tr>
                                <tr><td height="5"></td></tr>
								<tr>
									<td colspan="2">&nbsp;</td>
									<td>
									<input type="button" class="button1" name="btnCancel" value="< Back" onclick="history.back();" />
										<input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
                                        <input type="button" name="btnClearAll" class="button1" value="Clear All" onclick="ClearAll();" />&nbsp;
										
									</td>
								</tr>
							</table>
							</form>
						
						<!-- END CODE FOR MAIN CONTENT - PRASHANT -->
							
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
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
</body>
</html>
<?php		
include('../dbclose.php');
?>