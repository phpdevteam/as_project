<?php
session_start();
	include('../global.php');	
	include('../include/functions.php');
	
	$scatid = $_REQUEST["scatID"];	
	$sscatid = $_REQUEST["sscatID"];
	$mid = $_REQUEST["mid"];
	$bid = $_REQUEST["bid"];
		
	 $comquery = "SELECT _ID,_Model FROM ".$tbname."_products WHERE _status = 1  and _type = 1";
	 
	 
		 
	  if($bid > 0)
	 {
		 $comquery .= " and _BrandID ='". $bid ."' ";
	 }
	 
	 $comquery;

	
	$comrow = mysql_query('SET NAMES utf8');
	$comrow = mysql_query($comquery,$connect);

	
?>  
	<option value="">-- Select One --</option>
	<? while($comdata = mysql_fetch_assoc($comrow)){
		
		?>
		<option value="<?=$comdata['_ID']?>" <? if($comdata['_ID']==$mid) {echo " selected='selected'"; }?>><?=replaceSpecialCharBack($comdata['_Model'])?></option>	
	<? }?>

