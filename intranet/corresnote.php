<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
    }
	include('../global.php');	
	include('../include/functions.php'); include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");
	
	$Operations = GetAccessRights(61);
				if(count($Operations)== 0)
				{
				 echo "<script language='javascript'>history.back();</script>";
				}
		
	$currentmenu = "Corres Note";
	
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

	$btnSubmit = "Submit";
	$id = $_GET['id'];
	$cid = $_GET['cid'];
	$ctab =2;
	$e_action = $_GET['e_action'];
	if($id != "" && $e_action == 'edit' )
	{
	
		$str = "SELECT corr.*,cust._companyname,cust._customerid,date_format(corr._date,'%d/%m/%Y %H:%i') as _date FROM ".$tbname."_correshistory corr inner join ".$tbname."_customer cust on cust._ID = corr._customerid WHERE corr._ID = '".$id."' ";
		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			
			$notetypeid = $rs["_notetypeid"];
			$notetitle = $rs["_subject"];
			$description = $rs["_description"];
			$date = $rs["_date"];
			$companyname = $rs["_companyname"];
			
			$btnSubmit = "Update";
		}
	}
	
	else
	{
		
			$str = "SELECT *,concat_ws(',',_address1,_address2,_address3) as _contactaddress FROM ".$tbname."_customer  WHERE _ID = '".$cid."' ";
		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect);
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			

			$customerno = $rs["_customerid"];		
			$companyname = replaceSpecialCharBack($rs["_companyname"]);

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
   
<script type="text/javascript" src="../jquery/jquery-ui-timepicker-addon.js"></script>

    <link rel="stylesheet" href="../jquery/datepicker/datepicker.css" type="text/css" />
	

    <script type="text/javascript" src="../jquery/datepicker/eye.js"></script>
    <script type="text/javascript" src="../jquery/datepicker/utils.js"></script>



<script type="text/javascript" language="javascript">
		<!--
		//Info Tab
		
		function validateForm0()
		{
			var errormsg;
			errormsg = "";					
			if (document.FormName0.notetypeid.value == 0)
				errormsg += "Please choose 'Note Type'.\n";
				
			if (document.FormName0.description.value == 0)
				errormsg += "Please fill in 'Description'.\n";	
			
			if ((errormsg == null) || (errormsg == ""))
			{
				if (document.FormName0.e_action.value == "Edit")
				{
					var x = window.confirm("Are you sure you want to edit this record?")
					if (x)
					{
					document.FormName0.btnSubmit.disabled=true;
					return true;
					}
					else
					{
					return false;
					}
	
				}
				else
				{
					document.FormName0.btnSubmit.disabled=true;
					return true;
				}	
			}
			else
			{
				alert(errormsg);
				return false;
			}
		}
		
		function ClearAll()
		{
			for (var i=0;i<document.FormName0.elements.length;i++) {
				if (document.FormName0.elements[i].type == "text" || document.FormName0.elements[i].type == "textarea")
					document.FormName0.elements[i].value = "";  
				else if (document.FormName0.elements[i].type == "select-one")
					document.FormName0.elements[i].selectedIndex = 0;
				else if (document.FormName0.elements[i].type == "checkbox")
					document.FormName0.elements[i].checked = false;
			}
		}
		
		
		$(function() {
		
		$('.datetimepicker').datetimepicker({
							dateFormat: 'dd/mm/yy',
							yearRange: '-10:+10'
						});
		
		
	});
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
						<table width="100%" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td>
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                	 
                                    <tr>
                                      <td align="left" class="TitleStyle"><b>
                                      <?
									  	if($_GET['type'] == 'uc'){
											echo "Clients > Contractors > ";
										}else if($_GET['type'] == 'me'){
											echo "Clients > Members > ";
										}else
											echo "Clients > Customers > ";
												
									  	if($id != "" || $e_action == 'edit')
										{
											echo "Edit Corres Note";
										}
										else
										{
											echo "Add Corres Note";
										}
									  ?>
                                      </b></td><td align="right"><a href="customers.php?SearchBy=AdvSearch1" class="TitleLink" id="SearchByAdv">Advanced Search</a> | <a href="customers.php" class="TitleLink">List/Search Contacts</a>
                                      | <a href="customer.php" class="TitleLink">Add New</a></td>
                                    </tr>
                                    <tr><td height=""></td></tr>
                                </table>	
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td>
                                        <?php include("contact_header.php") ?>
                                        </td>
                                    </tr>	
                                    <tr>
                                        <td>
                                            <?php if($ctab==2){ ?>
                                            <form name="FormName0" action="corresnote_action.php"  method="post" onsubmit="return validateForm0();" enctype="multipart/form-data">
                                            <input type="hidden" id="id" name="id" value="<?=$id?>" />
                                             <input type="hidden" id="cid" name="cid" value="<?=$cid?>" />
                                            <input type="hidden" name="e_action" value="<?=($e_action == "" ? "addnew" : "edit")?>" />
                                            <input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
                                            <input type="hidden" name="ctab" value="<?=$ctab?>" />
                                            <input type="hidden" name="type" value="<?=$_GET['type']?>" />
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">								
                                         
                                            <tr>
                                            <td height="5" colspan="3"><b><?=$companyname. " (" . $customerno . ")"?></b></td>
                                            <td colspan="3" align="right">
                                              <?  if($_GET['type'] == 'uc'){
												echo '<a href="contractors.php" class="TitleLink">Contractors List</a>&nbsp;|&nbsp;<a href="contractor.php?ctab='.encrypt('2',$Encrypt).'&id='.encrypt($cid,$Encrypt).'&type='.encrypt($_GET['type'],$Encrypt).'" class="TitleLink">Corres Note List</a>';
											}else if($_GET['type'] == 'me'){
												echo '<a href="members.php" class="TitleLink">Members List</a>&nbsp;|&nbsp;<a href="member.php?ctab='.encrypt('2',$Encrypt).'&id='.encrypt($cid,$Encrypt).'&type='.encrypt($_GET['type'],$Encrypt).'" class="TitleLink">Corres Note List</a>';
											}else
												echo '<a href="customer.php?ctab='.encrypt('2',$Encrypt).'&id='.encrypt($cid,$Encrypt).'&type='.encrypt($_GET['type'],$Encrypt).'" class="TitleLink">Corres Note List</a>&nbsp;|&nbsp;<a href="corresnote.php?cid=' . encrypt($cid,$Encrypt) . '" class="TitleLink">Add Corres Note</a>';
                                                ?>                                              
                                                </td>
                                            </tr>
                                            
                                              <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                            
                                            <tr>
                                                <td  valign="middle">Note Type</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td  valign="middle"><select  tabindex="" name="notetypeid" class="dropdown1 chosen-select" style="width:350px;">
                                                <option value="">-- Select One --</option>
                                                <?
                                                    $query = "SELECT * FROM ".$tbname."_corrnotetypes ORDER BY _id";
                                                    $row = mysql_query('SET NAMES utf8');
                                                    $row = mysql_query($query,$connect);
                                                    while($data=mysql_fetch_assoc($row)){
                                                ?>
                                                <option value="<?=$data['_id']?>" <? if($data['_id']==$notetypeid) echo " selected"; ?>> <?=$data['_notetype'];?></option>
                                                <?	} ?>
                                              </select><span class="detail_red">*</span></td>
                                                
                                                
                                            </tr>
                                            
                                              <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                            
                                            <tr>
                                            	<td  valign="middle">Date</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="" id="date" name="date" value="<?=$date==""?date("d/m/Y H:i"):$date?>" class="txtbox1 datetimepicker" style="width:245px;"> (DD/MM/YYYY)</td>
                                            </tr>
                                            
                                              <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                            
                                            <tr>
                                                <td  valign="middle">Subject</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td colspan="4"  valign="middle">
                                                <input type="text" tabindex="" id="notetitle" name="notetitle" value="<?=$notetitle?>" class="txtbox1" style="width:245px;">
                                                
                                                </td>
                                            </tr>
                                            
                                              <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                            
                                            <tr>
                                                <td valign="top">Description</td>
                                                <td valign="top">&nbsp;:&nbsp;</td>
                                                <td colspan="4">
                                                
                                                	<?php 													
													$sBasePath = 'fckeditor/';
													$oFCKeditor = new FCKeditor('description');
													$oFCKeditor->Width = "810px";
													$oFCKeditor->Height = "300px";
													$oFCKeditor->BasePath = $sBasePath;
													$oFCKeditor->Value = replaceSpecialCharBack($description);
													$oFCKeditor->Create();
													
												?>
                                             
                                                </td>
                                            </tr>
                                            
                                              <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                                                                                   
                                            <tr>
                                                <td colspan="2">&nbsp;</td>
                                                <td>
                                                <input type="button" class="button1" name="bntBack" value="< Back" onclick="history.back();" />&nbsp;
                                                    <input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
                                                    
                                                    
                                                </td>
                                            </tr>
                                            </table>
                                            </form>
                                            <? } ?>
                                            
                                        </td>
                                    </tr>	
                                </table>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						</table>	
						</div>
						</td>
					</tr>
				</table>
			</div>
			</td>
		</tr>
	</table>
    <? include('jqueryautocomplete.php') ?>
</body>
</html>
<?php		
include('../dbclose.php');
?>