<?php
session_start();
include('../global.php');	 
include('../include/functions.php');
include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");

 
	// $Encrypt = "mysecretkey";
	// echo  decrypt('2tHm3NObqp0=',$Encrypt); 
	
	// die;
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
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>OAS</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css "/>
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" href="../css/Pe-icon-7-stroke.css">
<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
<link rel="icon" href="favicon.ico">
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

<body>
<div class="background">
		<div class="content" >
        <div class="main_box">
        <div class="login_box">
        
        <div class="logo"><img src="../images/logo.png" style="width: 71%;" alt="OAS" /></div>
        <h4>Cloud Login</h4>
        
        <form name="Login" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onsubmit="return validateForm();">
			<input type="hidden" name="SubmitLogin" value="SubmitLogin" />
			
			<input type="text" placeholder="Username" name="username" id="username" value="<?php echo $_REQUEST['username'];?>" class="input_box" />
			<input type="password" placeholder="Password" name="password" id="password" value=""  class="input_box" />
			
			<input type="submit" class="login_btn" name="btnSubmit"  value="Login" />
			<input type="button" class="clear_btn" name="btnReset" onclick="clearpass();" value="Clear" />
        </form>
      
      <div class="rpass">
     
  <input id="box1" type="checkbox"   tabindex="" name="checker" onclick="delMem(this)" />
  <label for="box1">Remember me</label>
 

      </div>
      
        <div class="fogp">
        <a href="javascript:void(0);" onclick="window.open('forget.php','ForgetPassword','width=300,height=130,left=350,top=250,toolbar=no,menubar=no,location=no,scrollbars=no,resizable=yes');" >Forgot password?</a>
        </div>
        
        <div></div>
          <div class="clr"></div>
        
        
        </div>
        
        
        <div class="imp_note">
        Important Note: For maximum compatibility, We recommends the use of web browser "Internet Explorer ver 9", from this page onwards. 
        </div>
        <div class="line_space"></div>
       
 </div>
        </div> </div>

</body>
</html>
