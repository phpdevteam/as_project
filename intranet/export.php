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
	<title><?=$appname?></title>
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<script type="text/javascript" src="js/validate.js"></script>
	
	<?php include('jq_include.php'); ?>
   
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
    <table cellpadding="0" cellspacing="0" width="980px" bgcolor="#fff" style="margin:0 auto; border-left:solid 1px #999999; border-right:solid 1px #999999;">
    <tr><td colspan="2" bgcolor="#4db748">
        <!------------ HEADER ------------>
       	<?php include('header.php'); ?>
       	<!------------ END HEADER ------------>
    </td></tr>
    <tr><td bgcolor="#8bc3df" valign="top" class="leftcol" width="130px">
        <!------------ LEFTCOLUMN ------------>
        <?php include('left.php'); ?>
        <!------------ END LEFTCOLUMN ------------>
    </td><td bgcolor="#ffffff" valign="top" width="850px">
        <!------------ RIGHTCOLUMN ------------>
        <table cellpadding="0" cellspacing="0" width="820px" class="wrapper" style="margin:15px;">
        <tr><td height="500" valign="top">
            <h2>Export DB File</h2>
            <hr /><br />
			
			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="AllCheckbox" id="AllCheckbox" type="checkbox"   tabindex="" value="All" onclick="CheckUnChecked('CustCheckbox',this);" />All   |  
			<input class="button1" name="export" id="export" value="Export Selected Items" type="button" onclick="doexport();" />
			
			<hr />
				
			<form id="myform" action="exporttocsv.php" method="POST">			
				<table width="820px">
            	<tr>
                	<td>
                    	<!-- START MENU CODE -->
						<b>Systems</b>
                        <ul class="smenu">
                        <?php
                        $total = 0;
						
                        $str1 = " _PID ='0' AND ".$tb_name."_menu._ID='13'  AND _UserID = '" . $_SESSION['groupid'] . "' ";
						$db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str1,NULL,'_Order ASC');
						$rst1 = $db->getResult();
                            if(count($rst1) > 0)
                            {		
                                foreach($rst1 as $rs1)
                                {			
                        ?>
                            <li>
                               <ul>
                                <?php
                                  $str2 = "".$tb_name."_menu._ID IN (14,16,17,85,87,91,95,76,105) AND _PID = '" . $rs1["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' ";
				         			$db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str2,NULL,'_Order ASC');
								$rst2 = $db->getResult();
								
								
                                 if(count($rst2) > 0)
                                        {
                                            foreach($rst2 as $rs2)
                                            {	

                                            $total++;											
                                ?>
                                            
                                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                           
                                        <input id="CustCheckbox<?php echo $total; ?>" name="CustCheckbox[]" type="checkbox"   tabindex="" value="<?php echo urlencode(strtolower($rs2["_Title"])); ?>"  /><a  class="TitleLink" <?php if($rs2["_PageName"]!="No"){ ?> href="exporttocsv.php?action=<?php echo urlencode(strtolower($rs2["_Title"])); ?>" <?php } ?> ><?php echo $rs2["_Title"]; ?><br/></a>								
                                        <?php if($rs2["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                        <?php
                                       $str3 = "_PID = '" . $rs2["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No' ";	
                                    $db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str3,NULL,' _Order ASC');
                                                $rst3 = $db->getResult();
                                                if(count($rst3) > 0)
                                                {
                                                    foreach($rst3 as $rs3)
                                                    {							
                                        ?>
                                                    
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                <a class="shortcut" <?php if($rs3["_PageName"]!="No"){ ?> href="<?php echo $rs3["_PageName"]; ?>" <?php } ?>><?php echo $rs3["_Title"]; ?></a>				
                                                    <?php if($rs3["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                                    <?php
                                                     $str4 = " _PID = '" . $rs3["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No'";
                                                    $db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID ',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str4,NULL,'_ID ASC');
                                                            $rst4 = $db->getResult();
                                                            if(count($rst4) > 0)
                                                            {
                                                                foreach($rst4 as $rs4)
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
                        
                        $str1 = "_PID ='0' AND ".$tb_name."_menu._ID='13'  AND _UserID = '" . $_SESSION['groupid'] . "'";
                         $db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str1,NULL,'_Order ASC ');
						    $rst1 = $db->getResult();
                            if(count($rst1) > 0)
                            {		
                                foreach($rst1 as $rs1)
                                {			
                        ?>
                            <li>		
                                
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> <ul> <?php } ?>
                                <?php
                    $str2 = "".$tb_name."_menu._ID IN (36,37) AND _PID = '" . $rs1["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "'";
                    $db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str2,NULL,'_Order ASC');
                                        $rst2 = $db->getResult();									
								
                                        if(count($rst2) > 0)
                                        {
                                            foreach($rst2 as $rs2)
                                            {	

											$total++;
                                ?>      
                                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                           
                                        <input id="CustCheckbox<?php echo $total; ?>" name="CustCheckbox[]" type="checkbox"   tabindex="" value="<?php echo urlencode(strtolower($rs2["_Title"])); ?>"  /><a  class="TitleLink" <?php if($rs2["_PageName"]!="No"){ ?> href="exporttocsv.php?action=<?php echo urlencode(strtolower($rs2["_Title"])); ?>" <?php } ?> ><?php echo $rs2["_Title"]; ?><br/></a>								
                                        <?php if($rs2["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                        <?php
                                        $str3 = "_PID = '" . $rs2["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No' ";	
                                    	$db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str3,NULL,'_Order ASC');
                                                $rst3 = $db->getResult();
                                                if(count($rst3) > 0)
                                                {
                                                    foreach($rst3 as $rs3)
                                                    {							
                                        ?>
                                                    
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                <a class="shortcut" <?php if($rs3["_PageName"]!="No"){ ?> href="<?php echo $rs3["_PageName"]; ?>" <?php } ?>><?php echo $rs3["_Title"]; ?></a>				
                                                    <?php if($rs3["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                                    <?php
                                                    $str4 = "_PID = '" . $rs3["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No'";
                                                    $db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str4,NULL,' _ID ASC');
                                                            $rst4 = $db->getResult();
                                                            if(count($rst4) > 0)
                                                            {
                                                                foreach($rst4 as $rs4)
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
                        
                        $str1 = "_PID ='0' AND ".$tb_name."_menu._ID='13'  AND _UserID = '" . $_SESSION['groupid'] . "' ";
						$db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str1,NULL,'_Order ASC');
                            $rst1 = $db->getResult();
                            if(count($rst1) > 0)
                            {		
                                foreach($rst1 as $rs1)
                                {			
                        ?>
                            <li>		
                                
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> <ul> <?php } ?>
                                <?php
                                $str2 = "".$tb_name."_menu._ID IN (73,74,109,113,117,121,137,141) AND _PID = '" . $rs1["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "'";
                    $db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str2,NULL,'_Order ASC ');
                                        $rst2 = $db->getResult();
										
                                        if(count($rst2) > 0)
                                        {
                                            foreach($rst2 as $rs2)
                                            {	

                                               $total++;											
                                ?>
                                            
                                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                           
                                        <input id="CustCheckbox<?php echo $total; ?>" name="CustCheckbox[]" type="checkbox"   tabindex="" value="<?php echo urlencode(strtolower($rs2["_Title"])); ?>"  /><a  class="TitleLink" <?php if($rs2["_PageName"]!="No"){ ?> href="exporttocsv.php?action=<?php echo urlencode(strtolower($rs2["_Title"])); ?>" <?php } ?> ><?php echo $rs2["_Title"]; ?><br/></a>								
                                        <?php if($rs2["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                        <?php
                                        $str3 = "_PID = '" . $rs2["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No' ";	
                                    $db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str3,NULL,'_Order ASC');
                                                $rst3 = $db->getResult();
                                                if(count($rst3) > 0)
                                                {
                                                    foreach($rst3 as $rs3)
                                                    {							
                                        ?>
                                                    
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                <a class="shortcut" <?php if($rs3["_PageName"]!="No"){ ?> href="<?php echo $rs3["_PageName"]; ?>" <?php } ?>><?php echo $rs3["_Title"]; ?></a>				
                                                    <?php if($rs3["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                                    <?php
                                                    $str4 = "_PID = '" . $rs3["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No' ";
                                                    $db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID ',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str4,NULL,'_Order ASC');
                                                $rst4 = $db->getResult();
                                                            if(count($rst4) > 0)
                                                            {
                                                                foreach($rst4 as $rs4)
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
                        
                        $str1 = " _PID ='0' AND ".$tb_name."_menu._ID='13'  AND _UserID = '" . $_SESSION['groupid'] . "' ";
						$db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID ',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str1,NULL,'_Order ASC');
                         $rst1 = $db->getResult();
                            if(count($rst1) > 0)
                            {		
                                foreach($rst1 as $rs1)
                                {			
                        ?>
                            <li>		
                                
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> <ul> <?php } ?>
                                <?php
                                $str2 = "".$tb_name."_menu._ID IN (38,39,40,41,42) AND _PID = '" . $rs1["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' ";
                    $db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID ',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str2,NULL,'_Order ASC');
                         $rst2 = $db->getResult();
                                    	
                                        if(count($rst2) > 0)
                                        {
                                            foreach($rst2 as $rs2)
                                            {		

                                           $total++;											
                                ?>
                                            
                                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                           
                                         <input id="CustCheckbox<?php echo $total; ?>" name="CustCheckbox[]" type="checkbox"   tabindex="" value="<?php echo urlencode(strtolower($rs2["_Title"])); ?>"  /><a  class="TitleLink" <?php if($rs2["_PageName"]!="No"){ ?> href="exporttocsv.php?action=<?php echo urlencode(strtolower($rs2["_Title"])); ?>" <?php } ?> ><?php echo $rs2["_Title"]; ?><br/></a>								
                                        <?php if($rs2["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                        <?php
                                        $str3 = "_PID = '" . $rs2["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No' ";	
                                    	$db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID ',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str3,NULL,'_Order ASC');
                         				$rst3 = $db->getResult();
                                                if(count($rst3) > 0)
                                                {
                                                    foreach($rst3 as $rs3)
                                                    {							
                                        ?>
                                                    
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                <a class="shortcut" <?php if($rs3["_PageName"]!="No"){ ?> href="<?php echo $rs3["_PageName"]; ?>" <?php } ?>><?php echo $rs3["_Title"]; ?></a>				
                                                    <?php if($rs3["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                                    <?php
                                                    $str4 = "_PID = '" . $rs3["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No'";
                                                    $db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID ',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str4,NULL,'_ID ASC');
                         							$rst4 = $db->getResult();
                                                            if(count($rst4) > 0)
                                                            {
                                                                foreach($rst4 as $rs4)
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
                        
                        $str1 = "_PID ='0' AND ".$tb_name."_menu._ID='13' AND _UserID = '" . $_SESSION['groupid'] . "' ";
						$db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID ',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str1,NULL,'_Order ASC');
                         	$rst1 = $db->getResult();
                            if(count($rst1) > 0)
                            {		
                                foreach($rst1 as $rs1)
                                {			
                        ?>
                            <li>		
                                
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> <ul> <?php } ?>
                                <?php
                                $str2 = "".$tb_name."_menu._ID = 133 AND _PID = '" . $rs1["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "'  ";
                    			$db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID ',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str2,NULL,'_Order ASC');
                         		$rst2 = $db->getResult();
					
                                        if(count($rst2) > 0)
                                        {
                                            foreach($rst2 as $rs2)
                                            {					
                                ?>
                                            
                                       <?php if($rs2["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                        <?php
                                    $str3 = "".$tb_name."_menu._ID <> 133 And _PID = '" . $rs2["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No' ";	
                                    $db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID ',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str3,NULL,'_Order ASC');
                         			$rst3 = $db->getResult();
                                         										
                                                if(count($rst3) > 0)
                                                {
                                                    foreach($rst3 as $rs3)
                                                    {	

                                              $total++;													
                                        ?>
                                                    
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                 <input id="CustCheckbox<?php echo $total; ?>" name="CustCheckbox[]" type="checkbox"   tabindex="" value="<?php echo urlencode(strtolower($rs3["_Title"])); ?>"  />
												 <a class="TitleLink" <?php if($rs3["_PageName"]!="No"){ ?> href="<?php echo $rs3["_PageName"]; ?>" <?php } ?>><?php echo $rs3["_Title"]; ?></a>				
                                                    <?php if($rs3["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                                    <?php
                                                    $str4 = "".$tb_name."_menu._ID <> 133 And _PID = '" . $rs3["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No'";
                                                    $db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID ',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str4,NULL,'_ID ASC');
                         									$rst4 = $db->getResult();
                                                            if(count($rst4) > 0)
                                                            {
                                                                foreach($rst4 as $rs4)
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
                        
                        $str1 = "_PID ='0' AND ".$tb_name."_menu._ID='13'  AND _UserID = '" . $_SESSION['groupid'] . "'";
						$db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID ',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str1,NULL,'_Order ASC');
                         	$rst1 = $db->getResult();
                            if(count($rst1) > 0)
                            {		
                                foreach($rst1 as $rs1)
                                {			
                        ?>
                            <li>		
                                
                                <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="settings.php"){ ?> <ul> <?php } ?>
                                <?php
                                $str2 = "".$tb_name."_menu._ID IN (77,81,125,129) AND _PID = '" . $rs1["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "'  ";
                    			$db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID ',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str2,NULL,'_Order ASC');
                         		$rst2 = $db->getResult();
                                      
                                        if(count($rst2) > 0)
                                        {
                                            foreach($rst2 as $rs2)
                                            {		

                                            $total++;											
                                ?>
                                            
                                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                           
                                        <input id="CustCheckbox<?php echo $total; ?>" name="CustCheckbox[]" type="checkbox"   tabindex="" value="<?php echo urlencode(strtolower($rs2["_Title"])); ?>"  /><a  class="TitleLink" <?php if($rs2["_PageName"]!="No"){ ?> href="exporttocsv.php?action=<?php echo urlencode(strtolower($rs2["_Title"])); ?>" <?php } ?> ><?php echo $rs2["_Title"]; ?><br/></a>								
                                        <?php if($rs2["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                        <?php
                                        $str3 = "".$tb_name."_menu._ID NOT IN (134,135,136) AND _PID = '" . $rs2["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No' ";	
										$db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID ',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str3,NULL,'_Order ASC');
										$rst3 = $db->getResult();
                                              	
                                                if(count($rst3) > 0)
                                                {
                                                    while($rs3 = mysql_fetch_assoc($rst3))
                                                    {							
                                        ?>
                                                    
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                <a class="shortcut" <?php if($rs3["_PageName"]!="No"){ ?> href="<?php echo $rs3["_PageName"]; ?>" <?php } ?>><?php echo $rs3["_Title"]; ?></a>				
                                                    <?php if($rs3["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                                    <?php
                                                    $str4 = "".$tb_name."_menu._ID NOT IN (134,135,136) AND _PID = '" . $rs3["_ID"] . "' AND _UserID = '" . $_SESSION['groupid'] . "' AND _PageName <> 'No' ";
                                                    $db->select(''.$tb_name.'_accessright',''.$tb_name.'_menu._ID , '.$tb_name.'_menu._PID, '.$tb_name.'_menu._Title, '.$tb_name.'_menu._PageName, '.$tb_name.'_accessright._UserID ',NULL,''.$tb_name.'_menu on(('.$tb_name.'_accessright._MID = '.$tb_name.'_menu._ID))',$str4,NULL,'_ID ASC');
													$rst4 = $db->getResult();

                                                            if(count($rst4) > 0)
                                                            {
                                                                foreach($rst4 as $rs4)
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
        </table> <!-- end wrapper right column -->
        <!------------ END RIGHTCOLUMN ------------>
    </td></tr>
    <tr><td colspan="2">
        <!------------ HEADER ------------>
       	<?php include('footer.php'); ?>
       	<!------------ END HEADER ------------>
	</td></tr>
    </table>
</body>
</html>
