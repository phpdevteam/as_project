<?php
session_start();
	include('../global.php');	
	include('../include/functions.php');
		
	 $comquery = "SELECT _id,CASE WHEN _contacttitle <> '' THEN concat(_contacttitle,' ',_contactname) ELSE _contactname END as _contactname,_contacttype FROM ".$tbname."_contactperson WHERE _customerid = '".replaceSpecialChar($_REQUEST['customerID'])."' ";
	$comrow = mysql_query('SET NAMES utf8');
	$comrow = mysql_query($comquery,$connect);
	$contactPersonID = "";
	
	$comquery2 = "SELECT _id FROM ".$tbname."_contactperson WHERE _customerid = '".replaceSpecialChar($_REQUEST['customerID'])."' AND _contacttype IN ('1','2') ORDER BY _contacttype desc LIMIT 1 ";
	$comrow2 = mysql_query('SET NAMES utf8');
	$comrow2 = mysql_query($comquery2);
	$comrs2 = mysql_fetch_assoc($comrow2);
	$contactPersonID = $comrs2['_id'];
	
	
?>
  <select name="contactID" id="contactID" class="dropdown1 chosen-select">
	<option value="">Select</option>
	<? while($comdata = mysql_fetch_assoc($comrow)){
		$isSelected = "";
		if($contactPersonID!="" && $contactPersonID==$comdata['_id'])
		{
			$isSelected = 'selected="selected"';
		}
		?>
		<option value="<?=$comdata['_id']?>" <?=$isSelected?>><?=replaceSpecialCharBack($comdata['_contactname'])?></option>	
	<? }?>
  </select>
