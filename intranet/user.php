<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
    }
	include('../global.php');	
	include('../include/functions.php');  include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");
	
	$Operations = GetAccessRights(25);
				if(count($Operations)== 0)
				{
				 echo "<script language='javascript'>history.back();</script>";
				}
	
	
	
	$PageStatus = "Add User";	
	$btnSubmit = "Submit";
	$id = $_GET['id'];
	$e_action = $_GET['e_action'];
	
	$currentmenu = "Settings";

	if($id != "" && $e_action == 'edit')
	{
		
		$str = "SELECT * FROM ".$tbname."_user WHERE _ID = '".$id."' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			$BhaveId=$rs['_BhaveId'];
			$Username = $rs['_Username'];
			$FName = $rs['_Fname'];
				
			$Password = $rs['_Password'];
			$Email = $rs['_Email'];	
			$status=$rs['_Status'];
			 $departmentid = $rs['_DepartmentID'];
			$LevelID = $rs['_LevelID'];
			$JobTitle = $rs['_JobTitle'];
			$LevelID = $rs['_LevelID'];
			
			$remarks = $rs['_Remarks'];

			$managerid = $rs['_ManagerID'];
			
			$PageStatus = "Edit User";
			$btnSubmit = "Update";
		}
	}
	else
	{
		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?php echo $gbtitlename; ?></title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
<link rel="stylesheet" href="../jquery/autocomplete/docsupport/prism.css">
<link rel="stylesheet" href="../jquery/autocomplete/chosen.css" />
<script type="text/javascript" src="../js/validate.js"></script>
<? include('jquerybasiclinks.php'); ?>
	<script language="javascript" type="text/javascript">
		<!--		
		function validateForm()
		{
			var errormsg;
            errormsg = "";	
			

			errormsg = "";					
            if (document.User.Username.value == 0)
                errormsg += "Please fill in 'Username'.\n";

			if (document.User.FName.value == 0)
				errormsg += "Please fill in 'Fullname'.\n";


				var strPassword = document.User.Password.value;
					
				
				if(strPassword == ""){ 
					errormsg += "Please fill in 'Password'.\n";
				}		
				else{
					if(parseInt(strPassword.length) < 8){ 
						errormsg += "Please fill minimum 8 char in 'Password'.\n";
					}
					else if(alphanum_validate(strPassword) == false){
						errormsg += "Please fill only alphanumeric value in 'Password'.\n";
					}
					else{
						if (document.User.Password.value != document.User.RetypePassword.value){
							errormsg += "'Password' is not the same as 'Re-type Password'.\n";
						}
					}
				}


			if (document.User.RetypePassword.value == 0)
			errormsg += "Please fill in 'RetypePassword'.\n";

		
        	if (document.User.Email.value == 0)
			errormsg += "Please fill in 'Email'.\n";

			if (document.User.jobtitle.value == 0)
			errormsg += "Please fill in 'Jobtitle'.\n";

			if (document.User.usergroupid.value == 0)
			errormsg += "Please select in 'Usergroup'.\n";

			var strPassword = document.User.Password.value;
					
	

            if ((errormsg == null) || (errormsg == ""))
            {
                document.User.btnSubmit.disabled=true;
                return true;
            }
            else
            {
                alert(errormsg);
                return false;
            }



			
			if (document.User.e_action.value == "AddNew"){
				if (document.User.Username.value == 0) errormsg += "Please fill in 'User Name'.\n";
			}
			
			if (document.User.FName.value == 0) errormsg += "Please fill in 'First Name'.\n";
			
		
			//validate password input
			if (document.User.e_action.value == "Edit"){
				/*if (document.User.CurrentPassword.value != ""){
					if (document.User.NewPassword.value == "") errormsg += "Please fill in 'New Password'.\n";
					if (document.User.RetypePassword.value == "") errormsg += "Please fill in 'Re-type Password'.\n";
				}*/
			
				if (document.User.NewPassword.value != "")
				{
					var strPassword = document.User.NewPassword.value;
				
						if(strPassword == ""){ 
							errormsg += "Please fill in 'New Password'.\n";
						}		
						else{
							if(parseInt(strPassword.length) < 8){ 
								errormsg += "Please fill minimum 8 char in 'New Password'.\n";
							}
							else if(alphanum_validate(strPassword) == false){
								errormsg += "Please fill only alphanumeric value in 'New Password'.\n";
							}
						}
				}
				if (document.User.NewPassword.value != document.User.RetypePassword.value)
					 errormsg += "'New Password' is not the same as 'Re-type Password'.\n";
			}else if (document.User.e_action.value == "AddNew"){ 
			
							
				/* START PASSWORD VALIDATION */
				/* Password restrict to Min 8 char with alpha-numeric. */
				
				
							
				/* END PASSWORD VALIDATION */
				
			}
			//validate password input
			
		
						
		/*	if(document.User.Email.value == ""){ 
				errormsg += "Please fill in 'Email'.\n";
			}
			else {
				if (!isEmail(document.User.Email.value)) errormsg += "Please fill in valid email address in 'Email'.\n";
			}
			
			if (document.User.Department.value == "")
				errormsg += "Please choose 'Department'.\n";
				
			if (document.User.usergroupid.value == "")
				errormsg += "Please choose 'User Group'.\n";
				
			if (document.User.managerid.value == "")
				errormsg += "Please choose 'Manager'.\n";	*/			
			
			if ((errormsg == null) || (errormsg == ""))
            {
			var param="id="+document.getElementById('edituserid').value;
				param+="&Username="+document.getElementById('Username').value;
				$.post("./checkuserexist.php",param, function(data){
						if($.trim(data)=="")
						{
						document.User.btnSubmit.disabled=true;
						document.User.submit();
						return true;
						}
						else
						{
						alert($.trim(data));
						return false;
						}
					});
	
				return false;
                
                //return confirm("proceed with the given infos?");
            }
            else
            {
                alert(errormsg);
                return false;
            }
		}
		
		/* start alphanumeric validation function for password */
		function alphanum_validate(strPassword){
			var alphanum=/^([a-zA-Z_0-9]+)$/; //This contains A to Z , 0 to 9 and A to B
			if(alphanum.test(strPassword)){
				return true;
			}
			else{
				return false;
			}
		}
		/* end alphanumeric validation function for password */
		
		function ClearAll()
		{
			for (var i=0;i<document.User.elements.length;i++) {
				if (document.User.elements[i].type == "text" || document.User.elements[i].type == "textarea" ||document.User.elements[i].type == "password")
					document.User.elements[i].value = "";
				else if (document.User.elements[i].type == "select-one")
					document.User.elements[i].selectedIndex = 0;
				else if (document.User.elements[i].type == "checkbox" || document.User.elements[i].type == "radio")
					document.User.elements[i].checked = false;
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
								  <td align="left" class="TitleStyle"><b><?=$PageStatus?></b></td>
								</tr>
								<tr><td height="10"></td></tr>
							</table>							
							<form name="User" action="useraction.php" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
							<input type="hidden" id="edituserid" name="id" value="<?=$id?>" />
							<input type="hidden" name="e_action" value="<?=($e_action == "" ? "AddNew" : "Edit")?>" />
							<input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								
								<tr><td height="5"></td></tr>
								<tr>
									<td width="150px" valign="middle">&nbsp;User Name (Login Name)&nbsp;</td>
									<td width="10px" valign="middle">&nbsp;:&nbsp;</td>
									<td valign="middle">
									<? if($e_action=="") { ?>
										<input type="text" tabindex="" id="Username" name="Username" value="" size="60" class="txtbox1" /> <span class="detail_red">*</span> 
									<? }else{
									 		echo $Username;									
									   }
									?>
									</td>
								</tr>
								<tr><td height="5"></td></tr>
								<tr>
								   <td  width="150px" valign="middle" >&nbsp;Full Name&nbsp;</td>
								   <td width="10px" valign="middle">&nbsp;:&nbsp;</td>
								   <td valign="middle"><input type="text" tabindex="" id="FName" name="FName" value="<?php echo $FName; ?>" size="60" class="txtbox1" /> <span class="detail_red">*</span> </td>
								</tr>
								<tr><td height="5"></td></tr>
								<?
								if($e_action=="")
								{
								?>
								<tr>
									<td width="150px" valign="middle">&nbsp;Password&nbsp;</td>
									<td width="10px" valign="middle">&nbsp;:&nbsp;</td>
									<td valign="middle"><input type="password" id="Password" name="Password" size="60" class="txtbox1" /> <span class="detail_red">*</span> </td>
								</tr>
               								<?
								}
								else
								{									
								?>
								
								<tr>
									<td width="150px" valign="middle">&nbsp;New Password&nbsp;</td>
									<td width="10px" valign="middle">&nbsp;:&nbsp;</td>
									<td valign="middle"><input type="password" id="NewPassword" name="NewPassword" size="60" class="txtbox1" /><?php if(!($_REQUEST['id'])) { ?> <span class="detail_red">*</span> <?php } ?> </td>
								</tr>
								<?
								}
								?>
								<tr><td height="5"></td></tr>
								<tr>
									<td valign="middle">&nbsp;Re-type Password&nbsp;</td>
									<td valign="middle">&nbsp;:&nbsp;</td>
									<td valign="middle"><input type="password" id="RetypePassword" name="RetypePassword" size="60" class="txtbox1" /><?php if(!($_REQUEST['id'])) { ?> <span class="detail_red">*</span> <?php } ?> </td>
								</tr>
								<tr><td height="5"></td></tr>                                        
								<tr>
									<td valign="middle">&nbsp;Email&nbsp;</td>
									<td valign="middle">&nbsp;:&nbsp;</td>
									<td valign="middle"><input type="text" tabindex="" id="Email" name="Email" value="<?php echo $Email; ?>" size="60" class="txtbox1" /> <span class="detail_red">*</span> </td>
								</tr>
                                <tr><td height="5"></td></tr>                                        
								<tr>
									<td valign="middle">&nbsp;Job Title&nbsp;</td>
									<td valign="middle">&nbsp;:&nbsp;</td>
									<td valign="middle"><input type="text" tabindex="" id="jobtitle" name="jobtitle" value="<?php echo $JobTitle; ?>" size="60" class="txtbox1" /> <span class="detail_red">*</span> </td>
								</tr>
								<tr><td height="5"></td></tr>  
								<!--<tr>
									<td valign="middle">&nbsp;Department&nbsp;</td>
									<td valign="middle">&nbsp;:&nbsp;</td><td>
										 
										<select  tabindex="" name="Department" class="dropdown1  chosen-select">
											<option value="">-- Select One --</option>
											<?php
										 
											$str = "SELECT * FROM ".$tbname."_departments WHERE _id IS NOT NULL ORDER BY _departmentname";
											 
											$rst = mysql_query($str, $connect) or die(mysql_error());
											if(mysql_num_rows($rst) > 0)
											{
												while($rs = mysql_fetch_assoc($rst))
												{
												?>
												<option value="<?php echo $rs["_id"]; ?>" <?php if($rs["_id"] == $departmentid) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_departmentname"]; ?>&nbsp;</option>
												<?php
												}
											}
											?>
										</select><span class="detail_red">*</span> 
									
									</td>
								</tr>-->
                                <tr><td height="5"></td></tr>  
								<tr>
									<td valign="middle">&nbsp;User Group&nbsp;</td>
									<td valign="middle">&nbsp;:&nbsp;</td><td>
										<?
										/*if($_SESSION['levelid']==1 || $_SESSION['levelid']==2)
										{*/
										?>
										<select  tabindex="" name="usergroupid" class="dropdown1  chosen-select">
											<option value="">-- Select One --</option>
											<?php
											/*if($_SESSION['levelid']==1)
											{*/
											$str = "SELECT * FROM ".$tbname."_level WHERE _ID IS NOT NULL ORDER BY _LevelName";
											/*}
											else
											{
											$str = "SELECT * FROM ".$tbname."_level WHERE _ID <> '1'";
											}
											$str = $str . "ORDER BY _ID ";*/
											$rst = mysql_query($str, $connect) or die(mysql_error());
											if(mysql_num_rows($rst) > 0)
											{
												while($rs = mysql_fetch_assoc($rst))
												{
												?>
												<option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $LevelID) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_LevelName"]; ?>&nbsp;</option>
												<?php
												}
											}
											?>
										</select><span class="detail_red">*</span> 
									
									</td>
								</tr>
                                <tr><td height="5"></td></tr>  
							<!--	<tr>
									<td valign="middle">&nbsp;Manager&nbsp;</td>
									<td valign="middle">&nbsp;:&nbsp;</td><td>
										<?
										/*if($_SESSION['levelid']==1 || $_SESSION['levelid']==2)
										{*/
										?>
										<select  tabindex="" name="managerid" class="dropdown1  chosen-select">
											<option value="">-- Select One --</option>
											<option value="1" <?=$managerid=="1"?"selected":"" ?>>Senior Manager</option>
                                            <option value="2" <?=$managerid=="2"?"selected":"" ?>>Junior Manager</option>
										</select><span class="detail_red">*</span> 
									
									</td>
								</tr>-->
                                <tr><td height="5"></td></tr>  
                                <tr>
                                    <td valign="top">&nbsp;Remarks&nbsp;</td>
                                    <td valign="top">&nbsp;:&nbsp;</td>
                                    <td valign="top"><textarea name="remarks" class="remarks" style="width:350px; height:100px;"><?php echo $remarks; ?></textarea></td>
                                 </tr>
								<tr><td height="5"></td></tr>
                                <tr><td width="130" valign="middle">&nbsp;System Status&nbsp;</td>
										<td valign="middle">&nbsp;:&nbsp;</td>
										<td valign="middle">
                                        
                                        
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
                                        
                                        	<input type="radio"   tabindex="" <?php echo $sel_status_y; ?> name="status" value="1" id="RadioGroup1_0" class="radio" />Live
                                                    <input type="radio"   tabindex="" <?php echo $sel_status_n; ?> name="status" value="2" id="RadioGroup1_1" class="radio" />Archive
                                      </td></tr>
                                <tr><td height="5"></td></tr>
								<tr>
									<td colspan="2">&nbsp;</td>
									<td>
                                    	<input type="button" class="button1" name="btnBack" value="< Back" onclick="window.location='settings.php';" />&nbsp;&nbsp;
										<input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
                                        
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

 <? include('jqueryautocomplete.php') ?>

<?php		
include('../dbclose.php');
?>