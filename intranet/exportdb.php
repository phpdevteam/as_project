<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']=="")
{
echo "<script language='javascript'>window.location='login.php';</script>";
}
include('../global.php');	
include('../include/functions.php');  include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo $gbtitlename; ?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css" />
<script type="text/javascript" src="js/validate.js"></script>
<script type="text/javascript" language="javascript">
   
   function CheckUnChecked(msgType, chkbxName)
		{
		   	count = $('#cntCheck').val();
			
		    if (chkbxName.checked==true)
			{

				for (var i = 1; i<=count; i++)
				{
				    $('#CustCheckbox' + i).prop('checked',true);					 
				}
				
			}
			else
			{
			    for (var i = 1; i<=count; i++)
				{
				$('#CustCheckbox' + i).prop('checked',false);
				}
			}
			
		}
		
	function doexport()
		{
		   	var $b = $('input[type=checkbox]');
			$mylen = $b.filter(':checked').length;
            if ($mylen == 0)
			{
			   alert('Please choose at least one to export');
			}
			else
			{
			  $('#myform').submit();
			}
		}
		
		
	</script>
	
	
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
               <table cellpadding="0" cellspacing="0" width="820px" class="wrapper" style="margin:15px;">
        <tr><td height="500" valign="top">
            <h2>Export DB File</h2>
            <hr /><br />
			
			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="AllCheckbox" id="AllCheckbox" type="checkbox"   tabindex="" value="All" onclick="CheckUnChecked('CustCheckbox',this);" />All   |  
			<input class="button2"  name="export" id="export" value="Export Selected Items" type="button" onclick="doexport();" />
			
			<hr />
				
			<form id="myform" action="exporttocsv.php" method="POST">			
				<table width="820px">
            	<tr>
                	<td>
                    
                        <b>PO</b>
                        <ul class="smenu">
                        <?php
                        $total = 0;
						
                        $str1 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where ".$tbname."_menu._PID ='104'  AND _UserID = '" . $_SESSION['groupid'] . "' Order By _Order ASC";
									
						
						$rst1 = mysql_query("set names 'utf8';");	
						$rst1 = mysql_query($str1, $connect) or die(mysql_error());
						
                            if(count($rst1) > 0)
                            {		
                                while($rs1 = mysql_fetch_assoc($rst1))
                                {			
                        ?>
                            <li>
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                           
                                        <input id="CustCheckbox<?php echo $total; ?>" name="CustCheckbox[]" type="checkbox"   tabindex="" value="<?php echo urlencode(strtolower($rs1["_Title"])); ?>"  /><a  class="TitleLink" <?php if($rs1["_PageName"]!="No"){ ?> href="exporttocsv.php?action=<?php echo urlencode(strtolower($rs1["_Title"])); ?>" <?php } ?> ><?php echo $rs1["_Title"]; ?><br/></a>								
                                        
                            </li>
                        <?php							
                                }
                            } 
                        ?>	
                        </ul>
                        
                    
                    
                    
                    	<!-- START MENU CODE -->
						<b>Systems</b>
                        <ul class="smenu">
                        <?php
                        $total = 0;
						
                        $str1 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where ".$tbname."_menu._ID='59'  AND _UserID = '" . $_SESSION['groupid'] . "' Order By _Order ASC";
									
						
						$rst1 = mysql_query("set names 'utf8';");	
						$rst1 = mysql_query($str1, $connect) or die(mysql_error());
						
                            if(count($rst1) > 0)
                            {		
                                while($rs1 = mysql_fetch_assoc($rst1))
                                {			
                        ?>
                            <li>
                               <ul>
                                <?php
								
								$str2 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where ".$tbname."_menu._ID IN (14,16,17,85,87,91,95,76,105) AND _PID = '" . $rs1["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "'  Order By _Order ASC";
									
						
						$rst2 = mysql_query("set names 'utf8';");	
						$rst2 = mysql_query($str2, $connect) or die(mysql_error());
						
						if(count($rst2) > 0)
                                        {
                                            while($rs2 = mysql_fetch_assoc($rst2))
                                            {	

                                            $total++;											
                                ?>
                                            
                                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                           
                                        <input id="CustCheckbox<?php echo $total; ?>" name="CustCheckbox[]" type="checkbox"   tabindex="" value="<?php echo urlencode(strtolower($rs2["_Title"])); ?>"  /><a  class="TitleLink" <?php if($rs2["_PageName"]!="No"){ ?> href="exporttocsv.php?action=<?php echo urlencode(strtolower($rs2["_Title"])); ?>" <?php } ?> ><?php echo $rs2["_Title"]; ?><br/></a>								
                                        <?php if($rs2["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                        <?php
                                      
									   $str2 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where _PID = '" . $rs2["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No'   Order By _Order ASC";
								
                                                $rst3 = mysql_query("set names 'utf8';");	
$rst3 = mysql_query($str3, $connect) or die(mysql_error());
                                                if(count($rst3) > 0)
                                                {
                                                    while($rs3 = mysql_fetch_assoc($rst3))
                                                    {							
                                        ?>
                                                    
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                <a class="shortcut" <?php if($rs3["_PageName"]!="No"){ ?> href="<?php echo $rs3["_PageName"]; ?>" <?php } ?>><?php echo $rs3["_Title"]; ?></a>				
                                                    <?php if($rs3["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                                    <?php
                                                     $str4 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where  _PID = '" . $rs3["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No'  Order By _Order ASC";
							
                                                            $rst4 = mysql_query("set names 'utf8';");	
$rst4 = mysql_query($str4, $connect) or die(mysql_error());
                                                            if(count($rst4) > 0)
                                                            {
                                                          while($rs4 = mysql_fetch_assoc($rst4))
                                                                {							
                                                    ?>
                                                                
                                                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                            <a class="shortcut" <?php if($rs4["_PageName"]!="No"){ ?> href="<?php echo $rs4["_PageName"]; ?>" <?php } ?>><?php echo $rs4["_Title"]; ?></a>				
                                                        </li>		
                                                    <?php
                                                                }
                                                            }
                                                    ?>
                                                    <?php if($rs3["_PageName"]=="No"){ ?> </ul> <?php } ?>
                                            </li>		
                                        <?php
                                                    }
                                                }
                                        ?>
                                        <?php if($rs2["_PageName"]=="No"){ ?> </ul> <?php } ?>
                                    </li>		
                                <?php
                                            }
                                        }			
                                ?>
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> </ul> <?php } ?>
                            </li>
                        <?php							
                                }
                            } 
                        ?>	
                        </ul>
                   	 	<!-- END MENU CODE -->	
						
						<b>Branch</b>
                        <ul class="smenu">
                        <?php
                        
						$str1 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where _PID ='0' AND ".$tbname."_menu._ID='13'  AND _UserID = '" . $_SESSION['groupid'] . "'  Order By _Order ASC";
				
						 $rst1 = mysql_query("set names 'utf8';");	
						$rst1 = mysql_query($str1, $connect) or die(mysql_error());
                            if(count($rst1) > 0)
                            {		
                                while($rs1 = mysql_fetch_assoc($rst1))
                                {			
                        ?>
                            <li>		
                                
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> <ul> <?php } ?>
                                <?php
								
								
								$str2 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where ".$tbname."_menu._ID IN (36,37) AND _PID = '" . $rs1["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "'  Order By _Order ASC";
							$rst2 = mysql_query("set names 'utf8';");	
							$rst2 = mysql_query($str2, $connect) or die(mysql_error());									
								
                                        if(count($rst2) > 0)
                                        {
                                            while($rs2 = mysql_fetch_assoc($rst2))
                                            {	

											$total++;
                                ?>      
                                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                           
                                        <input id="CustCheckbox<?php echo $total; ?>" name="CustCheckbox[]" type="checkbox"   tabindex="" value="<?php echo urlencode(strtolower($rs2["_Title"])); ?>"  /><a  class="TitleLink" <?php if($rs2["_PageName"]!="No"){ ?> href="exporttocsv.php?action=<?php echo urlencode(strtolower($rs2["_Title"])); ?>" <?php } ?> ><?php echo $rs2["_Title"]; ?><br/></a>								
                                        <?php if($rs2["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                        <?php
										
                                        $str3 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where _PID = '" . $rs2["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No'   Order By _Order ASC";
					       $rst3 = mysql_query("set names 'utf8';");	
						   $rst3 = mysql_query($str3, $connect) or die(mysql_error());
						   
                                                if(count($rst3) > 0)
                                                {
                                                    while($rs3 = mysql_fetch_assoc($rst3))
                                                    {							
                                        ?>
                                                    
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                <a class="shortcut" <?php if($rs3["_PageName"]!="No"){ ?> href="<?php echo $rs3["_PageName"]; ?>" <?php } ?>><?php echo $rs3["_Title"]; ?></a>				
                                                    <?php if($rs3["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                                    <?php
                                                    $str4 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where _PID = '" . $rs3["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No'  Order By _Order ASC";
				 $rst4 = mysql_query("set names 'utf8';");	
$rst4 = mysql_query($str4, $connect) or die(mysql_error());
                                                            if(count($rst4) > 0)
                                                            {
                                                                while($rs4 = mysql_fetch_assoc($rst4))
                                                                {							
                                                    ?>
                                                                
                                                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                            <a class="shortcut" <?php if($rs4["_PageName"]!="No"){ ?> href="<?php echo $rs4["_PageName"]; ?>" <?php } ?>><?php echo $rs4["_Title"]; ?></a>				
                                                        </li>		
                                                    <?php
                                                                }
                                                            }
                                                    ?>
                                                    <?php if($rs3["_PageName"]=="No"){ ?> </ul> <?php } ?>
                                            </li>		
                                        <?php
                                                    }
                                                }
                                        ?>
                                        <?php if($rs2["_PageName"]=="No"){ ?> </ul> <?php } ?>
                                    </li>		
                                <?php
                                            }
                                        }			
                                ?>
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> </ul> <?php } ?>
                            </li>
                        <?php							
                                }
                            } 
                        ?>	
                        </ul>
                        <!-- END MENU CODE -->
                        <!-- START MENU CODE -->
                        <b>Students</b>
                        <ul class="smenu">
                        <?php
                        
						 $str1 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where _PID ='0' AND ".$tbname."_menu._ID='13'  AND _UserID = '" . $_SESSION['groupid'] . "'   Order By _Order ASC";
						
               
                            $rst1 = mysql_query("set names 'utf8';");	
$rst1 = mysql_query($str1, $connect) or die(mysql_error());
                            if(count($rst1) > 0)
                            {		
                                while($rs1 = mysql_fetch_assoc($rst1))
                                {			
                        ?>
                            <li>		
                                
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> <ul> <?php } ?>
                                <?php
								
								 $str2 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where ".$tbname."_menu._ID IN (73,74,109,113,117,121,137,141) AND _PID = '" . $rs1["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' Order By _Order ASC";
            
                    $rst2 = mysql_query("set names 'utf8';");	
					$rst2 = mysql_query($str2, $connect) or die(mysql_error());
										
                                        if(count($rst2) > 0)
                                        {
                                            while($rs2 = mysql_fetch_assoc($rst2))
                                            {	

                                               $total++;											
                                ?>
                                            
                                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                           
                                        <input id="CustCheckbox<?php echo $total; ?>" name="CustCheckbox[]" type="checkbox"   tabindex="" value="<?php echo urlencode(strtolower($rs2["_Title"])); ?>"  /><a  class="TitleLink" <?php if($rs2["_PageName"]!="No"){ ?> href="exporttocsv.php?action=<?php echo urlencode(strtolower($rs2["_Title"])); ?>" <?php } ?> ><?php echo $rs2["_Title"]; ?><br/></a>								
                                        <?php if($rs2["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                        <?php
										
                                        $str3 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where _PID = '" . $rs2["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No'  Order By _Order ASC";
							
                 $rst3 = mysql_query("set names 'utf8';");	
				$rst3 = mysql_query($str3, $connect) or die(mysql_error());
                                                if(count($rst3) > 0)
                                                {
                                                    while($rs3 = mysql_fetch_assoc($rst3))
                                                    {							
                                        ?>
                                                    
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                <a class="shortcut" <?php if($rs3["_PageName"]!="No"){ ?> href="<?php echo $rs3["_PageName"]; ?>" <?php } ?>><?php echo $rs3["_Title"]; ?></a>				
                                                    <?php if($rs3["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                                    <?php
                                                    $str4 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where _PID = '" . $rs3["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No' Order By _Order ASC";
			
            $rst4 = mysql_query("set names 'utf8';");	
			$rst4 = mysql_query($str4, $connect) or die(mysql_error());
                                                            if(count($rst4) > 0)
                                                            {
                                         while($rs4 = mysql_fetch_assoc($rst4))
                                                                {							
                                                    ?>
                                                                
                                                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                            <a class="shortcut" <?php if($rs4["_PageName"]!="No"){ ?> href="<?php echo $rs4["_PageName"]; ?>" <?php } ?>><?php echo $rs4["_Title"]; ?></a>				
                                                        </li>		
                                                    <?php
                                                                }
                                                            }
                                                    ?>
                                                    <?php if($rs3["_PageName"]=="No"){ ?> </ul> <?php } ?>
                                            </li>		
                                        <?php
                                                    }
                                                }
                                        ?>
                                        <?php if($rs2["_PageName"]=="No"){ ?> </ul> <?php } ?>
                                    </li>		
                                <?php
                                            }
                                        }			
                                ?>
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> </ul> <?php } ?>
                            </li>
                        <?php							
                                }
                            } 
                        ?>	
                        </ul>
                   	 	<!-- END MENU CODE -->
                        <!-- START MENU CODE -->
                        <b>Course</b>
                        <ul class="smenu">
                        <?php
						
						 $str1 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where  _PID ='0' AND ".$tbname."_menu._ID='13'  AND _UserID = '" . $_SESSION['groupid'] . "' Order By _Order ASC";
                        
                  
                         $rst1 = mysql_query("set names 'utf8';");	
$rst1 = mysql_query($str1, $connect) or die(mysql_error());
                            if(count($rst1) > 0)
                            {		
                                while($rs1 = mysql_fetch_assoc($rst1))
                                {			
                        ?>
                            <li>		
                                
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> <ul> <?php } ?>
                                <?php
								
								 $str2 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where  ".$tbname."_menu._ID IN (38,39,40,41,42) AND _PID = '" . $rs1["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "'  Order By _Order ASC";
								
                   
                         $rst2 = mysql_query("set names 'utf8';");	
$rst2 = mysql_query($str2, $connect) or die(mysql_error());
                                    	
                                        if(count($rst2) > 0)
                                        {
                                            while($rs2 = mysql_fetch_assoc($rst2))
                                            {		

                                           $total++;											
                                ?>
                                            
                                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                           
                                         <input id="CustCheckbox<?php echo $total; ?>" name="CustCheckbox[]" type="checkbox"   tabindex="" value="<?php echo urlencode(strtolower($rs2["_Title"])); ?>"  /><a  class="TitleLink" <?php if($rs2["_PageName"]!="No"){ ?> href="exporttocsv.php?action=<?php echo urlencode(strtolower($rs2["_Title"])); ?>" <?php } ?> ><?php echo $rs2["_Title"]; ?><br/></a>								
                                        <?php if($rs2["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                        <?php
                                        $str3 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where _PID = '" . $rs2["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No'   Order By _Order ASC";
								
                         				$rst3 = mysql_query("set names 'utf8';");	
$rst3 = mysql_query($str3, $connect) or die(mysql_error());
                                                if(count($rst3) > 0)
                                                {
                                                    while($rs3 = mysql_fetch_assoc($rst3))
                                                    {							
                                        ?>
                                                    
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                <a class="shortcut" <?php if($rs3["_PageName"]!="No"){ ?> href="<?php echo $rs3["_PageName"]; ?>" <?php } ?>><?php echo $rs3["_Title"]; ?></a>				
                                                    <?php if($rs3["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                                    <?php
                                                    $str4 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where _PID = '" . $rs3["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No' Order By _Order ASC";
								
                         							$rst4 = mysql_query("set names 'utf8';");	
$rst4 = mysql_query($str4, $connect) or die(mysql_error());
                                                            if(count($rst4) > 0)
                                                            {
                                                                while($rs4 = mysql_fetch_assoc($rst4))
                                                                {							
                                                    ?>
                                                                
                                                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                            <a class="shortcut" <?php if($rs4["_PageName"]!="No"){ ?> href="<?php echo $rs4["_PageName"]; ?>" <?php } ?>><?php echo $rs4["_Title"]; ?></a>				
                                                        </li>		
                                                    <?php
                                                                }
                                                            }
                                                    ?>
                                                    <?php if($rs3["_PageName"]=="No"){ ?> </ul> <?php } ?>
                                            </li>		
                                        <?php
                                                    }
                                                }
                                        ?>
                                        <?php if($rs2["_PageName"]=="No"){ ?> </ul> <?php } ?>
                                    </li>		
                                <?php
                                            }
                                        }			
                                ?>
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> </ul> <?php } ?>
                            </li>
                        <?php							
                                }
                            } 
                        ?>	
                        </ul>
						
						
						
						 <b>Data</b>
                        <ul class="smenu">
                        <?php
                        
						  $str1 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where _PID ='0' AND ".$tbname."_menu._ID='13' AND _UserID = '" . $_SESSION['groupid'] . "' Order By _Order ASC";
			
                         	$rst1 = mysql_query("set names 'utf8';");	
$rst1 = mysql_query($str1, $connect) or die(mysql_error());
                            if(count($rst1) > 0)
                            {		
                                while($rs1 = mysql_fetch_assoc($rst1))
                                {			
                        ?>
                            <li>		
                                
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> <ul> <?php } ?>
                                <?php
                                 $str1 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where".$tbname."_menu._ID = 133 AND _PID = '" . $rs1["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "'  Order By _Order ASC";

                    		
                         		$rst2 = mysql_query("set names 'utf8';");	
$rst2 = mysql_query($str2, $connect) or die(mysql_error());
					
                                        if(count($rst2) > 0)
                                        {
                                            while($rs2 = mysql_fetch_assoc($rst2))
                                            {					
                                ?>
                                            
                                       <?php if($rs2["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                        <?php
										
                                    $str3 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where ".$tbname."_menu._ID <> 133 And _PID = '" . $rs2["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No'  Order By _Order ASC";
								
                         			$rst3 = mysql_query("set names 'utf8';");	
$rst3 = mysql_query($str3, $connect) or die(mysql_error());
                                         										
                                                if(count($rst3) > 0)
                                                {
                                                    while($rs3 = mysql_fetch_assoc($rst3))
                                                    {	

                                              $total++;													
                                        ?>
                                                    
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                 <input id="CustCheckbox<?php echo $total; ?>" name="CustCheckbox[]" type="checkbox"   tabindex="" value="<?php echo urlencode(strtolower($rs3["_Title"])); ?>"  />
												 <a class="TitleLink" <?php if($rs3["_PageName"]!="No"){ ?> href="<?php echo $rs3["_PageName"]; ?>" <?php } ?>><?php echo $rs3["_Title"]; ?></a>				
                                                    <?php if($rs3["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                                    <?php
                                                    $str4 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where ".$tbname."_menu._ID <> 133 And _PID = '" . $rs3["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No' Order By _Order ASC";
							
                         									$rst4 = mysql_query("set names 'utf8';");	
$rst4 = mysql_query($str4, $connect) or die(mysql_error());
                                                            if(count($rst4) > 0)
                                                            {
                                                                while($rs4 = mysql_fetch_assoc($rst4))
                                                                {							
                                                    ?>
                                                                
                                                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                            <a class="TitleLink" <?php if($rs4["_PageName"]!="No"){ ?> href="<?php echo $rs4["_PageName"]; ?>" <?php } ?>><?php echo $rs4["_Title"]; ?></a>				
                                                        </li>		
                                                    <?php
                                                                }
                                                            }
                                                    ?>
                                                    <?php if($rs3["_PageName"]=="No"){ ?> </ul> <?php } ?>
                                            </li>		
                                        <?php
                                                    }
                                                }
                                        ?>
                                        <?php if($rs2["_PageName"]=="No"){ ?> </ul> <?php } ?>
                                    </li>		
                                <?php
                                            }
                                        }			
                                ?>
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> </ul> <?php } ?>
                            </li>
                        <?php							
                                }
                            } 
                        ?>	
                        </ul>
						
						
                   	 	<!-- END MENU CODE -->
                        <!-- START MENU CODE -->
                        <b>Others</b>
                        <ul class="smenu">
                        <?php
                        
                        $str1 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where _PID ='0' AND ".$tbname."_menu._ID='13'  AND _UserID = '" . $_SESSION['groupid'] . "' Order By _Order ASC";
						
                         	$rst1 = mysql_query("set names 'utf8';");	
$rst1 = mysql_query($str1, $connect) or die(mysql_error());
                            if(count($rst1) > 0)
                            {		
                                while($rs1 = mysql_fetch_assoc($rst1))
                                {			
                        ?>
                            <li>		
                                
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> <ul> <?php } ?>
                                <?php
								
								 $str2 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where ".$tbname."_menu._ID IN (77,81,125,129) AND _PID = '" . $rs1["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "'   Order By _Order ASC";								
                              
                         		$rst2 = mysql_query("set names 'utf8';");	
$rst2 = mysql_query($str2, $connect) or die(mysql_error());
                                      
                                        if(count($rst2) > 0)
                                        {
                                            while($rs2 = mysql_fetch_assoc($rst2))
                                            {		

                                            $total++;											
                                ?>
                                            
                                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                           
                                        <input id="CustCheckbox<?php echo $total; ?>" name="CustCheckbox[]" type="checkbox"   tabindex="" value="<?php echo urlencode(strtolower($rs2["_Title"])); ?>"  /><a  class="TitleLink" <?php if($rs2["_PageName"]!="No"){ ?> href="exporttocsv.php?action=<?php echo urlencode(strtolower($rs2["_Title"])); ?>" <?php } ?> ><?php echo $rs2["_Title"]; ?><br/></a>								
                                        <?php if($rs2["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                        <?php
                                        $str2 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where ".$tbname."_menu._ID NOT IN (134,135,136) AND _PID = '" . $rs2["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No'  Order By _Order ASC";
						
										$rst3 = mysql_query("set names 'utf8';");	
$rst3 = mysql_query($str3, $connect) or die(mysql_error());
                                              	
                                                if(count($rst3) > 0)
                                                {
                                                    while($rs3 = mysql_fetch_assoc($rst3))
                                                    {							
                                        ?>
                                                    
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                <a class="shortcut" <?php if($rs3["_PageName"]!="No"){ ?> href="<?php echo $rs3["_PageName"]; ?>" <?php } ?>><?php echo $rs3["_Title"]; ?></a>				
                                                    <?php if($rs3["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                                    <?php
                                                    $str4 = " Select ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID From ".$tbname."_accessright join ".$tbname."_menu on (".$tbname."_accessright._MID = ".$tbname."_menu._ID)
						Where ".$tbname."_menu._ID NOT IN (134,135,136) AND _PID = '" . $rs3["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No'  Order By _Order ASC";
						
			$rst4 = mysql_query("set names 'utf8';");	
			$rst4 = mysql_query($str4, $connect) or die(mysql_error());

                                                            if(count($rst4) > 0)
                                                            {
                                                                while($rs4 = mysql_fetch_assoc($rst4))
                                                                {							
                                                    ?>
                                                                
                                                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                            <a class="shortcut" <?php if($rs4["_PageName"]!="No"){ ?> href="<?php echo $rs4["_PageName"]; ?>" <?php } ?>><?php echo $rs4["_Title"]; ?></a>				
                                                        </li>		
                                                    <?php
                                                                }
                                                            }
                                                    ?>
                                                    <?php if($rs3["_PageName"]=="No"){ ?> </ul> <?php } ?>
                                            </li>		
                                        <?php
                                                    }
                                                }
                                        ?>
                                        <?php if($rs2["_PageName"]=="No"){ ?> </ul> <?php } ?>
                                    </li>		
                                <?php
                                            }
                                        }			
                                ?>
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> </ul> <?php } ?>
                            </li>
                        <?php							
                                }
                            } 
                        ?>	
                        </ul>
						
						
						
				<input type="hidden" name="cntCheck" id="cntCheck" value="<?php echo $total; ?>" />		
						
						
						
                    </td>
                </tr>
            </table>
			</form>
        </td></tr>
        </table> 
      </div></td>
  </tr>
</table>
</body>
</html>
<?php		
include('../dbclose.php');
?>
