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
		
	$currentmenu = "Contact Person";

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
	
	//var_dump($_GET);
	//exit();
	$btnSubmit = "Submit";
	$id = $_GET['id'];
	$cid = $_GET['cid'];
	$customerno = $_GET["custno"];
	$ctab =1;
	$e_action = $_GET['e_action'];
	
	
	if($id != "" && $e_action == 'edit' )
	{
		$str = "SELECT ct.*,cust._customerid as Customerid,cust._companyname,
		date_format(ct._submitteddate,'%d/%m/%Y %h:%i:%s %p') as _subdate  FROM ".$tbname."_customer cust inner join ".$tbname."_contactperson ct on cust._ID = ct._customerid WHERE ct._ID = '".$id."' ";
		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect);
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			
			$contacttitle = $rs["_contacttitle"];
			$customerno = $rs["Customerid"];
			$contactname = replaceSpecialCharBack($rs["_contactname"]);
			$address1 = replaceSpecialCharBack($rs["_address1"]);
			$address2 = replaceSpecialCharBack($rs["_address2"]);
			$address3 = replaceSpecialCharBack($rs["_address3"]);
			$contacttel = replaceSpecialCharBack($rs["_contacttel"]);
			$contacttel2 = replaceSpecialCharBack($rs["_contacttel2"]);
			$main2 = replaceSpecialCharBack($rs["_main2"]);
			$direct = replaceSpecialCharBack($rs["_direct"]);
			$subdate = $rs["_subdate"];
			$contactfax = replaceSpecialCharBack($rs["_contactfax"]);
			$contactPostalcode = replaceSpecialCharBack($rs["_postalcode"]);
			$contacturl = replaceSpecialCharBack($rs["_contacturl"]);
			$contactemail = replaceSpecialCharBack($rs["_contactemail"]);
			$contactremarks = replaceSpecialCharBack($rs["_contactremarks"]);
			$internalremarks = replaceSpecialCharBack($rs["_internalremarks"]);
		
			$contactdepartment = replaceSpecialCharBack($rs['_contactdepartment']);
			$billcompanyname = replaceSpecialCharBack($rs['_billingcompany']);
			$status= $rs['_status'];
			
			$contactcityid = replaceSpecialCharBack($rs["_contactcity"]);
			$contactcountryid = replaceSpecialCharBack($rs["_contactcountry"]);
			$stateproid = replaceSpecialCharBack($rs["_contactstate"]);
			$defaultuser = $rs["_defaultuser"];
			$companyname = replaceSpecialCharBack($rs["_companyname"]);
			
			$btnSubmit = "Update";
		}
	}
	
	else
	{
		
			$str = "SELECT * FROM ".$tbname."_customer  WHERE _ID = '".$cid."' ";
		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect);
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			

			$customerno = $rs["_customerid"];
			$address1 = $rs["_address1"];
			$address2 = $rs["_address2"];
			$address3 = $rs["_address3"];
			$contacttel = $rs["_telephone1"];
			$contacttel2 = $rs["_telephone2"];
			$contactfax = $rs["_fax"];
			$contactPostalcode = $rs["_postalcode"];
			$contacturl = $rs["_url"];
			$contactemail = $rs["_email"];
			
			$contactremarks = $rs["_remarks"];
			
			$contactcityid = $rs["_cityid"];
			$contactcountryid = $rs["_countryid"];
			$stateproid = $rs["_stateprovinceid"];
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
<script type="text/javascript" src="../js/functions.js"></script>
    <script type="text/javascript" language="javascript">
		<!--
		//Info Tab
		$(function(){
		$("#btnSubmit, #btnDuplicate").click(function()
		{
			
			var errormsg;
			errormsg = "";	
			if($(this).attr("name") == "btnDuplicate")
			{
				$("#e_action").val('duplicate');
			}else{
				if($("#id").val()=="")
					$("#e_action").val('addnew');
				else	
					$("#e_action").val('edit');
			}
			
			if (document.FormName0.contacttitle.value == "")
				errormsg += "Please fill in 'Contact Title'.\n";
							
			if (document.FormName0.contactname.value == "")
				errormsg += "Please fill in 'Contact Name'.\n";
				
			
			//if (document.FormName0.contacttel.value == "" && document.FormName0.contactemail.value == "")
				//errormsg += "Please fill in 'Contact Tel' or 'Contact Email'.\n";		
				
			//alert("here");
			var x=document.FormName0.contactemail.value;
			
			if(x != "")
			{
				//alert(x);
				var atpos=x.indexOf("@");
				//alert(atpos);
				var dotpos=x.lastIndexOf(".");
				//alert(dotpos);
				if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length )
				{
					//alert("should be here");
				   errormsg += "Invalid Email.\n";
				 }
		    }
				
					
						
			if ((errormsg == null) || (errormsg == ""))
			{
				if (document.FormName0.e_action.value == "Edit")
				{
					var x = window.confirm("Are you sure you want to edit this record?")
					if (x)
					{
					document.FormName0.btnSubmit.disabled=true;
					$("#FormName0").submit();
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
					$("#FormName0").submit();
					return true;
				}	
			}
			else
			{
				alert(errormsg);
				return false;
			}
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
                                          <td align="left" class="TitleStyle"><b>Contacts</b></td>
                                        </tr>
                                        <tr><td height=""></td></tr>
                                    </table>
                            
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                      <td align="left"><b>
                                      <?
											if($_GET['type'] == 'uc'){
												echo "Customers > Under Contractors > ";
											}else if($_GET['type'] == 'me'){
												echo "Customers > Members > ";
											}else if($_GET['type'] == 'c'){
												echo "Customers > Contractors > ";
											}else
												echo " Customers > ";
										
									  	if($id != "" || $e_action == 'edit')
										{
											echo "Edit Contact Person";
										}
										else
										{
											echo "Add Contact Person";
										}
									  ?>
                                      </b></td> <td align="right" style="padding-right:25px; vertical-align:bottom"><a href="customers.php?SearchBy=AdvSearch1" class="TitleLink" id="SearchByAdv">Advanced Search</a> | <a href="customers.php" class="TitleLink">List/Search Contacts</a>

                                              
                                               | <a href="customer.php" class="TitleLink">Add New</a>
                                        
                                      </td>
                                    </tr>
                                    
                                </table>	
                                
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td>
                                        <?php include("contact_header.php"); ?>
                                        </td>
                                    </tr>	
                                    <tr>
                                        <td>
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
								echo "<div align='left'><font color='#FF0000'>Record has been duplicated successfully.<br></font></div>";
							}
							
							?>
                                            <?php if($ctab==1){ ?>
                                            <form name="FormName0" id="FormName0" action="contactperson_action.php"  method="post" enctype="multipart/form-data">
                                            <input type="hidden" id="id" name="id" value="<?=$id?>" />
                                            <input type="hidden" id="cid" name="cid" value="<?=$cid?>" />
                                            <input type="hidden" name="e_action" id="e_action" value="<?=($e_action == "" ? "addnew" : "edit")?>" />
                                            <input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
                                            <input type="hidden" name="type" value="<?=$_GET['type']?>" />
                                            <input type="hidden" name="ctab" value="<?=$ctab?>" />
                                           
                                            
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">								
                                            
                                            <tr>
                                            	<td colspan="7" align="right" style="padding-right:25px">
                                                
                                                 <?  
												echo '<a href="customer.php?ctab='.encrypt('1',$Encrypt).'&id='.encrypt($cid,$Encrypt).'&type='.encrypt($_GET['type'],$Encrypt).'&custno='.encrypt($customerno,$Encrypt).'" class="TitleLink">List Contact Persons</a>';
                                                ?>
                                                
                                                | 
                                                
                                              <?  
												echo '<a href="contactperson.php?cid='.encrypt($cid,$Encrypt).'&custno='.encrypt($customerno,$Encrypt).'" class="TitleLink">Add Contact Person</a>';
                                                ?>                                              
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td  valign="middle" width="150px">Contact Title</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle" width="265px">
                                                <? $str = "SELECT _id,_salutation FROM ".$tbname."_salutation ORDER BY _id";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="contacttitle" id="contacttitle" class="dropdown1  chosen-select">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_salutation"]; ?>" <?php if($rs["_salutation"] == $contacttitle) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_salutation"]; ?>&nbsp;</option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select><span class="detail_red">*</span>
                                                </td>
                                                 <td width="85px"></td>
                                                <td  valign="middle" width="150px">Contact Ref No</td>
                                                <td  valign="middle" width="10px">&nbsp;:&nbsp;</td>
                                                <td  valign="middle">
                                                <input type="text" tabindex="" id="customerno" name="customerno" value="<?=$customerno?>" class="txtlabel" autocomplete="off" readonly="readonly" style="width:250px;"/>
                                                </td>
                                               
                                            </tr>
                                            
                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                            
                                            <tr>
                                            <td valign="middle">Contact Name</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="" id="contactname" name="contactname" value="<?=$contactname?>" class="txtbox1" style="width:250px;"><span class="detail_red">*</span>
                                                </td>
												 <td width="85px"></td>
												<td valign="middle">Submitted Date/Time</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td  valign="middle"><span><?=$subdate == ""?date('d/m/Y h:i:s A'):$subdate ?> </span></td>
                                               
                                            
                                            </tr>
                                            
                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                            
                                            <tr>
                                            <td valign="middle">Department</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle">
												
												<select  tabindex="" name="contactdepartment" id="contactdepartment"  class="dropdown1  chosen-select">
											<option value="">-- Select One --</option>
											<?php
										 
											$str = "SELECT * FROM ".$tbname."_departments WHERE _ID IS NOT NULL ORDER BY _departmentname";
											 
											$rst = mysql_query($str, $connect) or die(mysql_error());
											if(mysql_num_rows($rst) > 0)
											{
												while($rs = mysql_fetch_assoc($rst))
												{
												?>
												<option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $contactdepartment) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_departmentname"]; ?>&nbsp;</option>
												<?php
												}
											}
											?>
										</select>
												
											
                                                </td>
												
												 <td width="85px"></td><td  valign="middle">Submitted By</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td  valign="middle"><span><?= $subby ==""?$_SESSION['user']: $subby ?> </span></td> 
                                            
                                              
                                                  
                                           
                                            </tr>
                                            
                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                           
                                            <tr>
                                             <td valign="middle">Company Name</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><?=$companyname . " (" . $customerno . ")"?>
                                                </td>
                                                
                                                 <td width="85px"></td>
                                           		<td  valign="middle">System&nbsp;Status&nbsp;</td>
                                            <td>&nbsp;:&nbsp;</td>
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
                                            <td><input type="radio"   tabindex="" <?php echo $sel_status_y; ?> name="systemstatus" value="1" id="RadioGroup1_0" class="radio" />Live
                                            <input type="radio"   tabindex="" <?php echo $sel_status_n; ?> name="systemstatus" value="2" id="RadioGroup1_1" class="radio" />Archive</td>
                                           <tr>
                                           
                                            <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                 
                                 
                                  <tr>
                                                <td valign="middle">Address1</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="2" id="address1" name="address1" value="<?=$address1?>" class="txtbox1" style="width:250px;"/></td>
                                             <td width="85px"></td>
                                             <td valign="middle">Main Tel 1</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="" id="contacttel" name="contacttel" value="<?=$contacttel?>" class="txtbox1" style="width:250px;"></td>
                                          
                                          
                                            </tr>
                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                                <tr>
                                                <td  valign="middle">Address2</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="3" id="address2" name="address2" value="<?=$address2?>" class="txtbox1" style="width:250px;"/></td>
                                            <td width="85px"></td>
                                             <td  valign="middle">Main Tel 2</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td  valign="middle"><input type="text" tabindex="" id="main2" name="main2" value="<?=$main2?>" class="txtbox1" style="width:250px;"></td>  
                                            
                                            
                                            </tr>
                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                                <tr>
                                                <td  valign="middle">Address3</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td  valign="middle"><input type="text" tabindex="4" id="address3" name="address3" value="<?=$address3?>" class="txtbox1" style="width:250px;"/></td>
                                           
                                             <td width="85px"></td>
                                                <td  valign="middle">Direct</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="" id="direct" name="direct" value="<?=$direct?>" class="txtbox1" style="width:250px;">
                                                </td>
                                           
                                            </tr>
                                            
                                               <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                           
                                   
                                            
                                            <tr>
                                                 <td valign="middle">Country</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><select  tabindex="" name="contactcountryid" id="countryid" class="dropdown1 chosen-select" style="width:350px;">
                                                            <option value="">--select--</option>
                                                            <?php
                                                                $sql = "SELECT * FROM ".$tbname."_countries ORDER BY if(UPPER(_countryname)= 'SINGAPORE',1,_countryname)";
                                                                $res = mysql_query($sql) or die(mysql_error());
                                                                if(mysql_num_rows($res) > 0){
                                                                    while($rec = mysql_fetch_array($res)){
                                                                        ?><option <?php if($rec['_id'] == $contactcountryid){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_id']; ?>"><?php echo $rec['_countryname']; ?></option><?php
                                                                    }
                                                                }
                                                            ?>
                                                            </select>
                                                </td>
                                                 <td width="85px"></td>
                                                <td  valign="middle">Direct</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="" id="direct" name="direct" value="<?=$direct?>" class="txtbox1" style="width:250px;">
                                                </td>
                                               
                                              </tr>
                                              
                                               <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                            
                                            <tr>
                                            
                                            <td  valign="middle">State/Province</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle">
                                                	<select  tabindex="" name="stateproid" id="stateproid" class="dropdown1 chosen-select" style="width:350px;">
                                                    <option value="">--select--</option>
                                                  <?php  if($contactcountryid != "")
												{
												
                                                    $sql = "SELECT * FROM ".$tbname."_provinces 
													Where _countryid = '". $contactcountryid ."' ORDER BY _provincename ";
                                                        $res = mysql_query($sql) or die(mysql_error());
                                                        if(mysql_num_rows($res) > 0){
                                                            while($rec = mysql_fetch_array($res)){
                                                                ?><option <?php if($rec['_id'] == $stateproid){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_id']; ?>"><?php echo $rec['_provincename']; ?></option><?php
                                                            }
                                                        }
														
												}
                                                    ?>
                                                  </select>
                                                </td>
                                            
                                             <td width="85px"></td>
                                            <td  valign="middle">Mobile</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td  valign="middle"><input type="text" tabindex="" id="contacttel2" name="contacttel2" value="<?=$contacttel2?>" class="txtbox1" style="width:250px;"></td>
                                                
                                             
                                            </tr>
                                            
                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                           
                                            <tr>
                                            
                                            <td  valign="middle">City</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle">
                                                    <select  tabindex="" name="contactcityid" id="cityid" class="dropdown1 chosen-select" style="width:350px;">
                                                    <option value="">--select--</option>
                                                    <?php
                                                       if($stateproid != "")
												{
												
                                                                $sql = "SELECT * FROM ".$tbname."_cities  
															
																Where _stateid = '". $stateproid."'
																ORDER BY  if(UPPER(_cityname)= 'SINGAPORE',1,_cityname) ";
                                                        $res = mysql_query($sql) or die(mysql_error());
                                                        if(mysql_num_rows($res) > 0){
                                                            while($rec = mysql_fetch_array($res)){
                                                                ?><option <?php if($rec['_id'] == $contactcityid){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_id']; ?>"><?php echo $rec['_cityname']; ?></option><?php
                                                            }
                                                        }
														
												}
                                                    ?>
                                                  </select>
                                              </td>
                                                <td width="85px"></td>
                                                  <td  valign="middle">Email</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="" id="contactemail" name="contactemail" value="<?=$contactemail?>" class="txtbox1" style="width:250px;">
                                                </td>
                                               
                                            </tr>
                                            
                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                            
                                            
                                            <tr>
                                            	<td valign="middle">Postal Code</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle"><input type="text" tabindex="" id="contactPostalcode" name="contactPostalcode" value="<?=$contactPostalcode?>" style="width:250px;" class="txtbox1"></td>
                                                  <td width="85px"></td>
                                                  <td  valign="middle">Url</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td  valign="middle"><input type="text" tabindex="" id="contacturl" name="contacturl" value="<?=$contacturl?>" class="txtbox1" style="width:250px;"></td>
                                                
                                              
                                                
                                             </tr>
                                             
                                              <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                             
                                            <tr>
                                              	<td valign="middle">Default Contact Person</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="middle" align="left"><input type="checkbox"   tabindex="" id="defaultuser" name="defaultuser" value="1" <?php if( trim($defaultuser) == '1') echo 'checked';?>/></td>
                                                <td width="85px"></td>
                                               <td  valign="middle">Fax</td>
                                                <td  valign="middle">&nbsp;:&nbsp;</td>
                                                <td  valign="middle"><input type="text" tabindex="" id="contactfax" name="contactfax" value="<?=$contactfax?>" class="txtbox1" style="width:250px;"></td>
                                            </tr>
                                            
                                            
                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                            
                                       
                                            
                                          <tr>
                                          		<td valign="top">Remarks (Client)</td>
                                                <td valign="top">&nbsp;:&nbsp;</td>
                                                <td colspan="5"  valign="top">
												
												<?php 													
													$sBasePath = 'fckeditor/';
													$oFCKeditor = new FCKeditor('contactremarks');
													$oFCKeditor->Width = "100%";
													$oFCKeditor->Height = "400px";
													$oFCKeditor->BasePath = $sBasePath;
													$oFCKeditor->Value = replaceSpecialCharBack($contactremarks);
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
                                          		<td valign="top">Internal Remarks (CODA)</td>
                                                <td valign="top">&nbsp;:&nbsp;</td>
                                                <td colspan="5"  valign="top"><?php 													
													$sBasePath = 'fckeditor/';
													$oFCKeditor = new FCKeditor('internalRemarks');
													$oFCKeditor->Width = "760px";
													$oFCKeditor->Height = "400px";
													$oFCKeditor->BasePath = $sBasePath;
													$oFCKeditor->Value = replaceSpecialCharBack($internalRemarks);
													$oFCKeditor->Create();
													
												?></td>
                                          </tr>
                                          
                                             <tr>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                      <td height="5"></td>
                                 </tr>
                                          
                                             <tr>
                                                <td colspan="2">&nbsp;</td>
                                                <td colspan="2">
	                                                <input type="button" class="button1" name="btnBack" value="< Back" onclick="history.back();" />&nbsp;
                                                    <input type="submit" name="btnSubmit" id="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
                                                    
                                                   
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