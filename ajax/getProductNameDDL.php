<?php
session_start();
	include('../global.php');	
	include('../include/functions.php');
		
	$productType = '1';
	if($_REQUEST['sType']=='5')
			$productType = '2';
			
	if($_REQUEST['pType']!="")
		$productType = $_REQUEST['pType'];
	$comquery = "SELECT _id,_productname FROM ".$tbname."_products WHERE _status = 'Live' AND _prodtype = '".$productType."' ORDER BY _productname ";
	$comrow = mysql_query('SET NAMES utf8');
	$comrow = mysql_query($comquery,$connect);
	$contactPersonID = "";
	
?>
  <select name="productID" id="productID" class="dropdown1 chosen-select">
	<option value="">Select</option>
	<? while($comdata = mysql_fetch_assoc($comrow)){
	?>
		<option value="<?=$comdata['_id']?>" ><?=replaceSpecialCharBack($comdata['_productname'])?></option>	
	<? }?>
  </select>
