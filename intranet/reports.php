<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
		exit();
    }
	include('../global.php');	
	include('../include/functions.php');  
	include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");	
	
	$Operations = GetAccessRights(47);
	if(count($Operations)== 0)
	{
	 echo "<script language='javascript'>history.back();</script>";
	}
		
	$btnSubmit = "Submit";
	$id = $_GET['id'];
	$e_action = $_GET['e_action'];
	$currentmenu = "Settings";
	
	if($id != "" && $e_action == 'edit')
	{
		$str = "SELECT * FROM ".$tbname."_categories WHERE _ID = '".$id."' ";
		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			$CategoryName = $rs["_CategoryName"];			
			$btnSubmit = "Update";
		}
	}

	if($_GET['error'] == 1)
	{
		$CategoryName = $_GET["CategoryName"];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $gbtitlename; ?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css" />
<script type="text/javascript" src="js/validate.js"></script>
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
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                  <tr>
                    <td><table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                          <td align="left" class="TitleStyle"><b>Reports</b></td>
                        </tr>
                        <tr><td height="5">&nbsp;</td></tr>
                        <tr>
                          <td style="padding-left:10px;">
                          <ul >
                            <?php
						echo '<h2 style="text-align: center;font-size: x-large;">Under Construction..</h2>'; die;
				
				$mystr = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = 47 AND _UserID = '" . $_SESSION['levelid'] . "' ORDER BY _Order ASC ";
			
		    $myresult1 = mysql_query($mystr, $connect) or die(mysql_error());
			
			if(mysql_num_rows($myresult1) > 0)
			{
				while($myrow1 = mysql_fetch_assoc($myresult1))
				{
				?>
                
                 <li>
                 
                 <b><?=$myrow1["_Title"]?></b>
                 
                 
                 <?php
					$mysubstr = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = ". $myrow1["_ID"]  ." AND _UserID = '" . $_SESSION['levelid'] . "'  And _Operation = '' and _PageName is not null and _PageName <> '' ORDER BY _Order ASC ";
					$mysubresult = mysql_query($mysubstr, $connect) or die(mysql_error());
					if(mysql_num_rows($mysubresult) > 0)
						{
						echo "<ul style='padding-left:10px;'>";
						while($mysubrow = mysql_fetch_assoc($mysubresult))
						{
						echo "<li>";
						?>						
						<a <?if($mysubrow["_PageName"]!="No"){ ?> href="<?=$mysubrow["_PageName"]; ?>" <?}?> >
						<?=$mysubrow["_Title"]; ?>
						</a>
                 <?php
					echo "</li>";
					}
					echo "</ul>";
					}
					?>
                 
                 
                 <br/></li>
                    
                    
                    
                            
				
				<?php
				}
			
			}
				?>
                          </ul>
                          </td>
                        </tr>
                      </table></td>
                  </tr>
                </table>
              </div></td>
          </tr>
        </table>
      </div></td>
  </tr>
</table>
</body>
</html>
<?php		
include('../dbclose.php');
?>