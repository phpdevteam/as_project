<?php
session_start();
include('../global.php');	 
include('../include/functions.php');
include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");

// $Encrypt = "mysecretkey";
//echo $Password = decrypt("7NDc35aVpQ==",$Encrypt);


//$str = "Beijing";
//$txt = sprintf("There are million bicycles in %s.",$str);

	
if(isset($_POST['SubmitLogin']) && $_POST['SubmitLogin']=="SubmitLogin"){	
    $Encrypt = "mysecretkey";
	 
	
	
    $Password = rawurldecode(encrypt($_POST['password'],$Encrypt));

	
	$sql = "SELECT * FROM ".$tbname."_user WHERE _Username='".replaceSpecialChar($_POST['username'])."' AND _Password='".$Password."' AND _Status= '1' and _Deleted='0'";
    $rst = mysql_query($sql, $connect) or die(mysql_error());


	if(mysql_num_rows($rst) > 0){
		
    	$rs = mysql_fetch_assoc($rst);
		
    	if(strcmp($rs['_Password'],$Password)==0){
						
			$_SESSION['userid'] = $rs['_ID'];
			$_SESSION['departmentid'] = $rs['_DepartmentID'];
			$_SESSION['levelid'] = $rs['_LevelID'];
			 $_SESSION['tname'] = $rs['_Fullname'];
			$_SESSION['user'] = $rs['_Username'];
			$_SESSION['pwd'] =  decrypt($rs['_Password'],$Encrypt);
			$_SESSION['temail'] = $rs['_Email'];
			$_SESSION['levelid'] = $rs['_LevelID'];
			$_SESSION['loginTime'] = date("Y-m-d H:i:s");
			$UserID = $_SESSION['userid'];
			$SessionInfo = session_id() . $_SESSION['user'] . $_SESSION['loginTime'];
			$IPAddress = $_SERVER['REMOTE_ADDR'];
			$DateTimeIn = date("Y-m-d H:i:s");
			
			mysql_query("INSERT INTO ".$tbname."_logginglog (_UserID, _SessionInfo, _IPAddress, _DateTimeIn) 
						VALUES ('$UserID','$SessionInfo','$IPAddress','$DateTimeIn')");	
			
			for($i=16;$i<=46;$i++)
			{								
				$str1 = "SELECT * 
				FROM (".$tbname."_accessright inner join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) 
				WHERE _UserID = '" . $_SESSION['levelid'] . "' AND _MID = '".$i."' ";
				$rst1 = mysql_query($str1, $connect) or die(mysql_error());
	
				if(mysql_num_rows($rst1) > 0)
				{		
					$GetAccess[$i] = "Y"; 
				}
				else
				{
					$GetAccess[$i] = "N"; 
				}
			}	
				
			
			include('../dbclose.php');
			
			echo "<script language='JavaScript'>window.location = 'main.php'; </script>";
    	}else{
        	echo "<script language='JavaScript'>alert('Invalid username or password.'); </script>";
    	}
    }else{
    	echo "<script language='JavaScript'>alert('Invalid username or password.'); </script>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>
<?=$gbtitlename?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="en-us" />
<link rel="stylesheet" type="text/css" href="../css/admin.css "/>
<script type="text/javascript" src="../js/validate.js"></script>
<script language="JavaScript" type="text/javascript">
function validateForm()
{
    var errormsg;
    errormsg = "";
    if (document.Login.username.value == "")
    {
    errormsg += "Please enter Username.\n";
  }
	else
		{
		var flagchk = isAlphabetNew(document.Login.username.value);
		if(flagchk == false){
			alert("Enter Valid User");
			document.Login.username.focus();
			return false;
		}
		}
    if (document.Login.password.value == "")
    errormsg += "Please enter Password.\n"
    if ((errormsg == null) || (errormsg == ""))
    {
    if (document.Login.checker.checked){ toMem(this);}
    return true;
    }
    else
    {
    alert(errormsg);
    return false;
    }
}
	

</script>
<script language="JavaScript" type="text/javascript">
<!-- Cookie script - Scott Andrew -->
<!-- Popup script, Copyright 2005, Sandeep Gangadharan --> 
<!-- For more free scripts go to http://www.sivamdesign.com/scripts/ -->
<!--
function newCookie(name,value,days) {
    var days = 1;  // the number at the left reflects the number of days for the cookie to last
            // modify it according to your needs
    if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString(); }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/"; }
function readCookie(name) {
    var nameSG = name + "=";
    var nuller = '';
    if (document.cookie.indexOf(nameSG) == -1)
    return nuller;

    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameSG) == 0) return c.substring(nameSG.length,c.length); }
    return null; }
function eraseCookie(name) {
    newCookie(name,"",1); }
function toMem(a) {	
    newCookie('username', document.Login.username.value); // add a new cookie as shown at left for every
    newCookie('password', document.Login.password.value); // field you wish to have the script remember
}
function Checker(a) {
    if(document.Login.username.value !='' && document.Login.password.value !='')
    {
     document.Login.checker.checked=true;
    }
}
function delMem(a) {		
    if(document.Login.checker.checked==false)
    {
       eraseCookie('username');// make sure to add the eraseCookie function for every field
       eraseCookie('password');
    }
}

function screenresolution()
{
	var h;
	if(typeof window.innerHeight != 'undefined'){
		/*added bello code by ketan on 19-10-2011 for scrolling problem in IE*/
		if(navigator.appCodeName=='Mozilla')
		{ h = window.innerHeight-7; }
		else
		{ h = document.body.clientHeight; alert(h);}
	}
	else{
		//h = parseInt(document.body.offsetHeight) + 180;
		/*added bello code by ketan on 19-10-2011 for scrolling problem in IE*/
		//h = h - 80;
		h = document.documentElement.clientHeight;
		
	}
	document.getElementById('MainDivision').style.height = h + "px"; 
}

function clearpass()
{
document.getElementById('username').value="";
document.getElementById('password').value="";
return false;
}

//-->
</script>
</head>

<body onload="screenresolution(); document.Login.username.focus(); Checker(this);">
<table height="100%" width="970" cellspacing="0" cellpadding="0" border="0" align="center" style="align:center;">
  <tbody>
    <tr>
      <td valign="top"><div class="maintable">
          <table width="970" cellspacing="0" cellpadding="0" border="0">
            <tbody>
              <tr>
                <td width="970" valign="top" align="left" style="border:0px;"  class="inner-block"><div class="m"  style="margin:0px;">
                    <table width="924" border="0" align="center" cellpadding="0" cellspacing="0" >
                      <tr>
                        <td><div style="background:#EAEAEA; border:1px solid #EAEAEA;min-height:480px;" id="MainDivision">
                            <table width="400" border="0" cellpadding="0" cellspacing="0" align="center">
                              <tr>
                                <td height="100"></td>
                              </tr>
                              <tr>
                                <td align="center">
                                <img src="images/companylogo.jpg" width="250" height="80" /><br>
                                  <span style="font-size:20px; color:#000000; font-weight:bold">
                                  <br>
                                  ERP Control Panel</span></td>
                              </tr>
                              <tr>
                                <td align="left"><form name="Login" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onsubmit="return validateForm();">
                                    <input type="hidden" name="SubmitLogin" value="SubmitLogin" />
                                    <table width="260" border="0" cellpadding="0" cellspacing="0" align="center">
                                      <tr>
                                        <td height="10"></td>
                                      </tr>
                                      <tr>
                                        <td width="20%" align="right">&nbsp;Username&nbsp;</td>
                                        <td width="5%">&nbsp;:&nbsp;</td>
                                        <td width="75%">&nbsp;
                                          <input type="text" tabindex="" name="username" id="username" value="<?php echo $_REQUEST['username'];?>" style="width:170px;" class="txtbox1" />
                                          &nbsp; </td>
                                      </tr>
                                      <tr>
                                        <td height="5"></td>
                                      </tr>
                                      <tr>
                                        <td align="right">&nbsp;Password&nbsp;</td>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td>&nbsp;
                                          <input type="password" name="password" id="password" value="" style="width:170px;" class="txtbox1" />
                                          &nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="10"></td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;
                                          <input type="submit" name="btnSubmit" value="Login" class="button1" />
                                          &nbsp;
                                          <input type="button" name="btnReset" value="Clear" class="button1" onclick="clearpass();" />
                                          &nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="10"></td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;
                                          <input type="checkbox"   tabindex="" name="checker" onclick="delMem(this)" />
                                          Remember me</td>
                                      </tr>
                                      <tr>
                                        <td height="10"></td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;<a href="javascript:void(0);" onclick="window.open('forget.php','ForgetPassword','width=300,height=130,left=350,top=250,toolbar=no,menubar=no,location=no,scrollbars=no,resizable=yes');" style="color:#000000;">Forget Password</a></td>
                                      </tr>
                                      <tr>
                                        <td height="10"></td>
                                      </tr>
                                      <tr>
                                        <td colspan="3" align="center">&nbsp;Important Note: For maximum compatibility, We recommends the use of web 
                                          browser "Internet Explorer ver 9", from this page onwards.&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="10"></td>
                                      </tr>
                                    </table>
                                  </form>
                                  <script language="JavaScript" type="text/javascript">
                                                    <!--
                                                    if(readCookie("username") != "")
                                                    document.Login.username.value = readCookie("username");  // Change the names of the fields at right to match the ones in your form.
                                                    document.Login.password.value = readCookie("password");
                                                    //-->
                                                    </script></td>
                              </tr>
                            </table>
                          </div></td>
                      </tr>
                    </table>
                  </div></td>
              </tr>
            </tbody>
          </table>
        </div></td>
    </tr>
  </tbody>
</table>
</body>
</html>