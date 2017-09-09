<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
		exit();
    }
	include('../global.php');	
	include('../include/functions.php');include('access_rights_function.php'); 
	include("fckeditor/fckeditor.php");

    $Operations = GetAccessRights(61);
	if(count($Operations)== 0)
	{
		echo "<script language='javascript'>history.back();</script>";
	}	
	
	 $SQOperations = GetAccessRights(71);
		
	$currentmenu = "Communities";

	$btnSubmit = "Submit";
	
	foreach($_GET as $k=>$v)
	{
	   $_GET[$k] = decrypt($v,$Encrypt);
	}
 	foreach($_REQUEST as $k=>$v)
	{
	   $_REQUEST[$k] = decrypt($v,$Encrypt);
	}
	foreach($_POST as $k=>$v)
	{
	   $_POST[$k] = decrypt($v,$Encrypt);
	}
	
	 $id = $_GET['id'];
	 $customerno = $_GET['customerno'];
	 $companyname = $_GET['companyname'];
	 $e_action = $_GET['e_action'];
	 $ctab = $_GET['ctab'];
	 $type = $_REQUEST['type'];
	 //$memberid = $_REQUEST["memberid"]; 
	// var_dump($_REQUEST);
	 
	if($ctab=="")
	{
		$ctab = 0;
	}

	
	if($id != "" && $e_action == 'edit' && $ctab == '0')
	{
		
		$str = "SELECT *,date_format(_CreatedDateTime,'%d/%m/%Y %h:%i:%s %p') as _submitteddate FROM ".$tbname."_communities WHERE _ID = '".$id."' ";
		$rst = mysql_query("set names 'utf8';");	
		
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			
			$communityname = replaceSpecialCharBack($rs["_CommunityName"]);
			$createdby = replaceSpecialCharBack($rs["_CreatedBy"]);
			$approvedstatus = replaceSpecialCharBack($rs["_ApprovedStatus"]);
			$fimagename = replaceSpecialCharBack($rs["_ImageName"]);
            $status = $rs["_Status"];
            $comdescription = $rs["_Description"];
            $combelifs = $rs["_OurBelief"];
		
            $btnSubmit = "Update";
            
		}
	}

	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $gbtitlename; ?></title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
	<script type="text/javascript" src="../js/validate.js"></script>
    <link rel="stylesheet" href="../jquery/autocomplete/docsupport/prism.css">
  <link rel="stylesheet" href="../jquery/autocomplete/chosen.css" />
    <? include('jquerybasiclinks10_3.php'); ?>
       
    <script type="text/javascript" src="../js/functions.js"></script>
     <script type="text/javascript" src="../js/qtip.js"></script>
	<script type="text/javascript" language="javascript">
		<!--
		//Info Tab
		
		function validateForm0()
		{
			var errormsg;
			errormsg = "";		
			
           
                var x1 = document.forms["FormName0"]["communityname"].value;
               
               
               
               if (x1 == "") {
                               alert("Please fill in 'Community Name'.\n");
                               return false;
               }

        }

	

		
		$(function() {
			$( "#contractor" ).chosen();
		});
		//-->
	</script>
	</head>
	<body>
    <table align="center" width="970" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="align:center;">
      <tr>
        <td valign="top"><div class="maintable">
            <table width="970" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><?php include('topbar.php'); ?></td>
              </tr>
            	<tr>
                    <td class="inner-block" width="970" align="left" valign="top"><div class="m">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                        <tr>
                            <td>
                            
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tr>
                                          <td align="left" class="TitleStyle"><b>Communities</b></td>
                                        </tr>
                                        <tr><td height=""></td></tr>
                                    </table>
                                   <br/>
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                    <td align="left"><b>
                                      <?
                                                if($id != "" || $e_action == 'edit')
                                                {
                                                    echo "Edit Communities";
                                                }
                                                else
                                                {
                                                    echo "Add Communities";
                                                }
											  ?>                                              
								  </td>
								  <td align="right" style="padding-right:2px; vertical-align:bottom"> <a href="communities.php" class="TitleLink">List/Search Communities</a>
                                              
                                              <?php
											  if($id != "")
											  {
											  ?>
                                              
                                               | <a href="communitie.php" class="TitleLink">Add New</a>
                                                  
                                              <?php
											  }
											  ?>
                                              
                                              </td>
                                  </tr>
								  <tr><td height="5"></td></tr>
								 
                                    <tr><td height=""></td></tr>
                                  </table>
                                  
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                  
                                  <tr><td>
                                    <?php
                                        if ($_GET["done"] == 1)
                                        {
                                            echo "<div align='left'><font color='#FF0000'>Record has been added successfully.<br></font></div>";
                                        }
                                        if ($_GET["done"] == 2)
                                        {
                                            echo "<div align='left'><font color='#FF0000'>Record has been edited successfully.<br></font></div>";
                                        }
                                        if ($_GET["done"] == 3)
                                        {
                                            echo "<div align='left'><font color='#FF0000'>Record has been deleted successfully.<br></font></div>";
                                        }
                                        if ($_GET["error"] == 1)
                                        {
                                            echo "<div align='left'><font color='#FF0000'>MemberID [".$memberid."] is existed in the system. Please enter another MemberID.<br></font></div>";
                                        }
                                    ?></td>
                                    </tr>
                                    
                                      <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                  
                                  
                                    <tr>
                                    <td>
                                        <form name="FormName0" action="communitie_action.php"  method="post" onsubmit="return validateForm0();" enctype="multipart/form-data">
                                        <input type="hidden" id="id" name="id" value="<?=$id?>" />
                                        <input type="hidden" id="customerno" name="customerno" value="<?=$customerno?>" />
                                        <input type="hidden" name="e_action" value="<?=($e_action == "" ? "addnew" : "edit")?>" />
                                        <input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
                                        <input type="hidden" name="ctab" value="<?=$ctab?>" />

                                        <input type="hidden" name="file444" value="<?=$fimagename?>" />
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                          <tr>
                                          <td valign="top">
                                              
                                           <table width="100%" cellpadding="0" cellspacing="0" border="0">
											
											<tr>
                                                <td valign="middle" width="150px">Community Name</td>
                                                <td valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td valign="middle" width="260px"><input type="text" tabindex="1" id="communityname" name="communityname" value="<?=$communityname?>" class="txtbox1" style="width:250px;" />
                                                  <span class="detail_red">*</span></td>
                                            </tr>
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="10"></td>
											 </tr>
                                             <tr>
                                             <td valign="middle">Created By</td>
                                             <td valign="middle">&nbsp;:&nbsp;</td>
                                              <td valign="middle"><input type="radio"   tabindex="7" name="createdby" value="Admin" <?=$createdby=='Admin' || $createdby == ''?'checked="checked"':''?> />
                                              Admin 
                                             <input type="radio"   tabindex="7" name="createdby" value="Trainer" <?=$createdby=='Trainer' ?'checked="checked"':''?> />
                                             Trainer 
                                             <input type="radio"   tabindex="7" name="createdby" value="VO" <?=$createdby=='VO' ?'checked="checked"':''?> />
                                             VO  </td>
                                           </tr>
                                             <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="10"></td>
											 </tr>
											 
                                               <tr>
                                            <td valign="middle">Approved Status</td>
                                            <td valign="middle">&nbsp;:&nbsp;</td>
                                            <td valign="middle" ><select  tabindex="6" name="approvedstatus" id="approvedstatus" class="dropdown1 chosen-select" style="width:250px;">
                                                        <option value="Pending" <?php if( $approvedstatus =='Pending') {?> selected <?php } ?>>&nbsp;<?php echo 'Pending'; ?></option>
                                                        <option value="Approved" <?php if( $approvedstatus =='Approved') {?> selected <?php } ?>>&nbsp;<?php echo 'Approved'; ?></option>
                                                        <option value="Disapproved"<?php if( $approvedstatus =='Disapproved') {?> selected <?php } ?>>&nbsp;<?php echo 'Disapproved'; ?></option>
                                                       
                                                        </select>
                                            </td>
                                            </tr>
                                            <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="10"></td>
											 </tr>

                                            <tr>
                                                  <td  valign="middle">Descriptions </td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><textarea  tabindex="" id="comdescription" name="comdescription"  class="textarea1" style="height:70px;"><?=$comdescription?></textarea>                    
                                                </td>
                                             
                                         </tr>
                                         <tr>
												  <td height="5"></td>
												  <td height="5"></td>
												  <td height="10"></td>
											 </tr>
                                             <tr>
                                                  <td  valign="middle">Our Belifs and store </td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><textarea  tabindex="" id="combelifs" name="combelifs"  class="textarea1" style="height:70px;"><?=$combelifs?></textarea>                    
                                                </td>
                                             
                                         </tr>



















                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="10"></td>
                                 </tr>
                                 <tr >
										<td valign="middle">Image Name</td>
										<td valign="middle">&nbsp;:&nbsp;</td>
										<td>
                                        <?php
                                        if($fimagename != "")
										{ ?> 
											 <a href="<?php echo $AdminTopCMSImagesPath;?><?php echo $fimagename;?>" target="_blank" style="color:#FF0000; font-family:arial; font-size:11px;"><?php echo $fimagename;?></a>&nbsp;
											 <a href="javascript:void(0);" onClick="if(confirm('Are you sure you want to delete this?')) { window.open('communitie_action.php?e_action=deletefile&ID5=<?php echo $rs["_ID"];?>&Types=I','personalize','toolbar=no,location=no,directories=no,status=no,menubar=no'); return true; }" onMouseOver="write_it('Delete File');return true;" class="link1">[<img src="../images/delfilepic.gif" border="0" alt="Delete File"> Delete File]</a>
										<? }else {?>
									
                                        <input type="file" name="ImageName[]" size="40" class="txtbox1">
                                        <?php
										}
										 ?>
										</td>
									</tr>    
                                        
                                           
                                     </table>
                                          
                                          </td>
                                          
                                          <td width="30px"></td>
                                          
                                          <td valign="top" align="right">
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tbllabel">
                                            
                                                <tr>
                                                    <td valign="middle">Submitted By</td>
                                                    <td valign="middle">&nbsp;:&nbsp;</td>
                                                    <td valign="middle"><?= $subby ==""?$_SESSION['user']: $subby ?></td>
                                                </tr>
                                                
                                                 <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                             
                                              <tr>
                                                <td valign="middle">Submitted Date/Time</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><span><?=$subdate == ""?date('d/m/Y h:i:s A'):$subdate ?> </span></td>
                                              </tr>
                                              
                                               <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                              <tr>
                                                    <td valign="middle">System&nbsp;Status&nbsp;</td>
                                                    <td valign="middle">&nbsp;:&nbsp;</td>
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
                                                    <td valign="middle"><input type="radio"   tabindex="9" <?php echo $sel_status_y; ?> name="status" value="1" id="RadioGroup1_0" class="radio" />Live
                                                    <input type="radio"   tabindex="9" <?php echo $sel_status_n; ?> name="status" value="2" id="RadioGroup1_1" class="radio" />Archive</td>   
                                                </tr>  
                                                
                                                 <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>

							
                                                                                     
                                          </table>
                                          </td>
                                          
                                          </tr>
                                          <tr>
                                      <td height="35"></td>
                                    
                                 </tr>
                                          <tr>
                                          
                                                    
                                             <td align="right" >
                                            <input type="button" class="button1" name="btnBack" value="< Back" onclick="window.location='communities.php?type=<?=encrypt($type,$Encrypt)?>'" />&nbsp;
                                            <input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
                                                </td>
                                          </tr>
								
									
								
									
									 
                                          
                                            
                                          </table>
                                      </form>
                                      
                                    </td>
                                  </tr>
                                  
                                  </table>
                              
                            </td>
                          </tr>
                        <tr>
                            <td>&nbsp;</td>
                          </tr>
                      </table>
                      </div></td>
              </tr>
          </table>
          </div></td>
      </tr>
    </table>
    <? include('jqueryautocomplete.php') ?>
</body>
</html>
<?php		
include('../dbclose.php');
?>