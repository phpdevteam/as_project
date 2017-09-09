<?php
session_start();
	include('../global.php');	
	include('../include/functions.php');
		
	 $comquery = "SELECT _id,_defaultuser,
	 concat_ws(' ',_contacttitle,_contactname) as _contactname FROM ".$tbname."_contactperson WHERE _customerid = '".replaceSpecialChar($_REQUEST['supplierID'])."' ";

	 
	$comrow = mysql_query('SET NAMES utf8');
	$comrow = mysql_query($comquery,$connect);

	
?>  
	<option value="">Select</option>
	<? while($comdata = mysql_fetch_assoc($comrow)){
		
		?>
		<option value="<?=$comdata['_id']?>" <?=$comdata['_defaultuser']==1?"Selected":""?>><?=replaceSpecialCharBack($comdata['_contactname'])?></option>	
	<? }?>

