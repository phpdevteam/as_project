<?php
session_start();
	include('../global.php');	
	include('../include/functions.php');
		
	$comquery = "SELECT doi._serialno FROM ".$tbname."_deliveryorderitems doi INNER JOIN ".$tbname."_delivery do ON do._id = doi._orderid AND do._status = 'Live' WHERE do._customerid = '".replaceSpecialChar($_REQUEST['customerID'])."' AND doi._serialno IS NOT NULL AND _serialno <> '' ";
	$comrow = mysql_query('SET NAMES utf8');
	$comrow = mysql_query($comquery,$connect);

	
?>
  <select name="serialNo" id="serialNo" class="dropdown1 chosen-select">
	<option value="">Select</option>
	<? while($comdata = mysql_fetch_assoc($comrow)){
		
		?>
		<option value="<?=$comdata['_serialno']?>" <?=$isSelected?>><?=replaceSpecialCharBack($comdata['_serialno'])?></option>	
	<? }?>
  </select>
