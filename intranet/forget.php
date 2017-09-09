<? include('../global.php'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $gbtitlename; ?></title>
<link href="../css/admin.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/validate.js"></script>
<script language="javascript" type="text/javascript">
<!--
function Page_Load()
{
    document.Forget.TxtEmail.focus();
}
function validateForm()
{
    var errormsg;
    errormsg = "";
    if (document.Forget.TxtEmail.value == "")
    errormsg += "Please enter Email.\n"
    else
    {
    if (!isEmail(document.Forget.TxtEmail.value))
    errormsg += "Please fill in a valid Email address.\n";
    }
    if ((errormsg == null) || (errormsg == ""))
    {
    return true;
    }
    else
    {
    alert(errormsg);
    document.Forget.TxtEmail.focus();
    return false;
    }
}
//-->
</script>
</head>
<body onLoad="Page_Load();">
<?php
$V_ID = $_GET["ID"];
if ($V_ID == 1)
{
$Msg = "Your password had been sent to your email successfully.";
}
elseif ($V_ID == 2)
{
$Msg = "Sorry, we cant find any matching account.";
}
elseif (strlen($V_ID) == 0)
{
$Msg = "";
}
?>
<form name="Forget" method="post" action="retrieve.php" onSubmit="return validateForm();" enctype="application/x-www-form-urlencoded">
<table width="300" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#C1DEFE">
        <td height="25" colspan="2" class="Tline_D_LGrey"><font class="Eleven_Bluefont">To retrieve your password, type your e-mail address</font></td>
    </tr>
    <tr>
        <td height="16" colspan="2" class="Ten_Redfont"><font color='#FF0000'><?php echo $Msg; ?></font></td>
    </tr>
    <tr>
        <td width="87" height="22" align="right"><font class="Eleven_Blackfont">Email Address :</font>&nbsp;</td>
        <td width="213"><input type="text" tabindex="" name="TxtEmail" class="txtbox1" style="width: 170px;"/></td>
    </tr>
    <tr>
        <td colspan="2" align="right" height="5"></td>
    </tr>
    <tr>
        <td colspan="2" align="right" height="10"></td>
    </tr>
    <tr>
        <td height="27" colspan="2" align="right">
        <input type="submit" name="Submit" value="Retrieve" class="button1">&nbsp;&nbsp;
        </td>
    </tr>
    <tr bgcolor="#C1DEFE">
        <td height="25" colspan="2" align="right" class="Tline_T_LGrey">&nbsp;</td>
    </tr>
</table>
</form>
</body>
</html>