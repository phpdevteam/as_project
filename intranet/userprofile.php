<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']=="")
{
echo "<script language='javascript'>window.location='login.php';</script>";
}
else
{
include('../global.php');
include('../include/functions.php');   include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");       
$sql = "SELECT * FROM ".$tbname."_user WHERE _ID = '" . $_SESSION['userid'] . "' ";
$rst = mysql_query($sql, $connect) or die(mysql_error());
if(mysql_num_rows($rst) > 0)
{
$rs = mysql_fetch_assoc($rst);
$Fullname = $rs['_Fullname'];
$Fname = $rs['_Fname'];
$Lname = $rs['_Lname'];
$Username = $rs['_Username'];
$Decrypt = "mysecretkey";
$Password = decrypt($rs['_Password'],$Decrypt);
$DOBDay = date("j", strtotime($rs['_DOB']));
$DOBMth = date("m", strtotime($rs['_DOB']));
$DOBYr = date("Y", strtotime($rs['_DOB']));
$Gender = $rs['_Gender'];
$Email = $rs['_Email'];
$Location = $rs['_Location'];
$CountryID = $rs['_CountryID'];	
$PostalCode = $rs['_PostalCode'];	
$Signature = $rs['_Remarks'];
$UserLevel=$rs['_LevelID'];
	if(trim($UserLevel)!="")
	{
		$SelectLevel="Select _LevelName from ".$tbname."_level where lcase(_ID)='".strtolower($UserLevel)."' ";
		$LevelResult=mysql_query($SelectLevel);
    if(mysql_num_rows($LevelResult)>0)
    {
        $arr=mysql_fetch_row($LevelResult);
        $UserLevel=trim($arr[0]);
    }
    else
    {
    $UserLevel="";
    }
	}

}
$currentmenu = "Edit Profile";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$gbtitlename?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css" />
<style type="text/css">
<!--
.style1 {font-size: 11px}
-->
</style>
<script type="text/javascript" src="../js/validate.js"></script>
<script type="text/javascript" src="../js/calendar.js"></script>
<script type="text/javascript" language="javascript">
<!--


	function alphanum_validate(strPassword){
			var alphanum=/^([a-zA-Z_0-9]+)$/; //This contains A to Z , 0 to 9 and A to B
			if(alphanum.test(strPassword)){
				return true;
			}
			else{
				return false;
			}
		}

function write_it(status_text)
{
window.status=status_text;
}
function testKey(e)
{
chars= "0123456789+ ";
e    = window.event;
if(chars.indexOf(String.fromCharCode(e.keyCode))==-1) 
window.event.keyCode=0;
}
function validateForm()
{
 
	var errormsg;
	errormsg = "";
	
	if (document.EditUserProfile.Fname.value == "")
	{
		errormsg += "Please fill in 'First Name'.\n";
	}
	if (document.EditUserProfile.Lname.value == "")
	{
		errormsg += "Please fill in 'Last Name'.\n";
	}
	
		
	/*if (document.EditUserProfile.CurrentPassword.value !="")
	{
		if (document.EditUserProfile.NewPassword.value == "")
			 errormsg += "Please fill in 'New Password'.\n";
	
		if (document.EditUserProfile.RetypePassword.value == "")
			 errormsg += "Please fill in 'Re-type Password'.\n";
	}*/
	
	var new_pass=document.EditUserProfile.NewPassword.value;
	var re_pass=document.EditUserProfile.RetypePassword.value;
	
	if (document.EditUserProfile.NewPassword.value != "" || document.EditUserProfile.RetypePassword.value != "")
	{
		
		if(parseInt(new_pass.length) < 8){ 
						errormsg += "Please fill minimum 8 char in 'New Password'.\n";
		}
		 if(alphanum_validate(new_pass) == false){
				errormsg += "Please fill only alphanumeric value in 'New Password'.\n";
		}
		if (document.EditUserProfile.NewPassword.value != document.EditUserProfile.RetypePassword.value)
			 errormsg += "'New Password' is not the same as 'Re-type Password'.\n";
	}
	
	if (document.EditUserProfile.Email.value == "")
	errormsg += "Please fill in 'Email'.\n";
	else
	{
	if (!isEmail(document.EditUserProfile.Email.value))
		errormsg += "Please fill in valid email address in 'Email'.\n";
	}	
	
   if ((errormsg == null) || (errormsg == ""))
    {
        //document.EditUserProfile.btnSubmit.disabled=true;
        //return true;
		//return confirm("Update your profile?");
    }
    else
    {
        alert(errormsg);
        return false;
    }
}
function ClearAll()
{				
    for (var i=0;i<document.EditUserProfile.elements.length;i++) {
         if (document.EditUserProfile.elements[i].type == "text" || document.EditUserProfile.elements[i].type == "password" || document.EditUserProfile.elements[i].type == "textarea")
              document.EditUserProfile.elements[i].value = "";
         else if (document.EditUserProfile.elements[i].type == "select-one")
              document.EditUserProfile.elements[i].selectedIndex = 0;
         else if (document.EditUserProfile.elements[i].type == "checkbox")
              document.EditUserProfile.elements[i].checked = false;
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
					
							<table cellpadding="0" cellspacing="0" border="0" width="840">
								<tr><td align="left" class="TitleStyle"><b>Edit User Profile</b></td></tr>
                                <tr><td height="5"></td></tr>
                                <?php
                                if ($_GET["done"] == 1)
                                {
                                echo "<tr><td height='5'></td></tr><tr><td colspan='3' align='left'><font color='#FF0000'>User Profile has been edited successfully.</font></td></tr><tr><td height='5'></td></tr>";
                                }
                                if ($_GET["error"] == 1)
                                {
                                echo "<tr><td height='5'></td></tr><tr><td colspan='3' align='left'><font color='#FF0000'>Invalid Current Password. Please try again.</font></td></tr><tr><td height='5'></td></tr>";
                                }
                                ?>
                                <tr>
                                <td>
                                    <form action="userprofileaction.php" method="post" name="EditUserProfile" onsubmit="return validateForm();">
                                    <table width="838" border="0" cellspacing="0" cellpadding="2">
                                        <tr>
                                            <td>Username</td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td><?php echo $Username; ?></td>
                                        </tr>
                                        <tr><td height="5"></td></tr>
                                        <tr>
                                           <td>First Name&nbsp;</td>
                                           <td>&nbsp;:&nbsp;</td>
                                           <td width="700">
										   <input type="text" tabindex="" id="Fname" name="Fname" value="<?php echo $Fname; ?>" size="60" class="txtbox1" /><span class="detail_red">*</span> </td>
                                        </tr>
                                       
                                        <tr><td height="5"></td></tr>
										<tr>
                                           <td>Last Name&nbsp;</td>
                                           <td>&nbsp;:&nbsp;</td>
                                           <td width="700">
										   <input type="text" tabindex="" id="Lname" name="Lname" value="<?php echo $Lname; ?>" size="60" class="txtbox1" /><span class="detail_red">*</span> </td>
                                        </tr>
                                       
                                        <tr><td height="5"></td></tr>
                                        <tr>
                                            <td>New Password&nbsp;</td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td><input type="password" id="NewPassword" name="NewPassword" size="60" class="txtbox1" /></td>
                                        </tr>
                                        <tr><td height="5"></td></tr>
                                        <tr>
                                            <td>Re-type Password&nbsp;</td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td><input type="password" id="RetypePassword" name="RetypePassword" size="60" class="txtbox1" /></td>
                                        </tr>
                                        <tr><td height="5"></td></tr>                                        
                                        <tr>
                                            <td>Email&nbsp;</td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td><input type="text" tabindex="" id="Email" name="Email" value="<?php echo $Email; ?>" size="60" class="txtbox1" /><span class="detail_red">*</span> </td>
                                        </tr>  
										 <tr><td height="5"></td></tr>   
                                         <tr>
                                            <td>User Level</td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td><?php echo $UserLevel; ?></td>
                                        </tr>                       
                                        
                                        <tr><td height="5"></td></tr>
                                        <tr>
                                            <td valign="top">Signature&nbsp;</td>
                                            <td valign="top">&nbsp;:&nbsp;</td>
                                            <td><textarea name="Remarks" cols="35" rows="4" class="textarea"><?php echo $Signature; ?></textarea></td>
                                        </tr>
                                        <tr><td height="5"></td></tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td align="left"><input type="submit" class="button1" name="btnSubmit" value="Update" />
                                            
                                            &nbsp;&nbsp;
                                            <input type="reset" class="button1" name="btnRevert" value="Revert" />
                                            &nbsp;&nbsp;
                                            <input type="button" class="button1" name="btnClearAll" value="Clear All" onclick="ClearAll();" /></td>
                                        </tr>
										<tr><td>&nbsp;</td></tr>
                                    </table>
                                    </form>
                                </td>
                                </tr>
                             </table>
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
}
?>