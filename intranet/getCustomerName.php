<?php
	session_start();
	include('../global.php');	
	include('../include/functions.php');
	include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");
	
$customerID = $_REQUEST["myVal"];

 $comquery = "SELECT _id,_companyname,_customerid FROM ".$tbname."_customer WHERE _status = 1 and ( find_in_set('1',_customertype) <> 0 or find_in_set('2',_customertype) <> 0 or find_in_set('4',_customertype) <> 0) ORDER BY _companyname ";
											$comrow = mysql_query('SET NAMES utf8');
											$comrow = mysql_query($comquery,$connect)or die(mysql_error());?>
                                    
                                      <option value="">Select</option>
                                      <?
											if(mysql_num_rows($comrow)>0)
											{	while($comdata=mysql_fetch_assoc($comrow))
												{ ?>
												<option value="<?=$comdata['_id']?>" <?=$comdata['_id']==$customerID?"selected":""?> customerid="<?=$comdata['_customerid']?>" ><?=replaceSpecialCharBack($comdata['_companyname'])." - ".$comdata['_customerid']?></option>	
                                                <?
												}
											}


?>