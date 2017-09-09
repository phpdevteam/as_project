<?php
session_start();
	include('../global.php');	
	include('../include/functions.php');
	
	$scatid = $_REQUEST["scatID"];	
	$sscatid = $_REQUEST["sscatID"];
	$pid = $_REQUEST["sid"];
		
	 $comquery = "SELECT _ID,_ProductName From
	  ".$tbname."_products p
	  WHERE p._status = 1 and p._type = 2";
	 
	 
	 if($scatid > 0)
	 {
		 $comquery .= " and _SubCategoryID ='". $scatid ."' ";
	 }
	 
	  if($sscatid > 0)
	 {
		 $comquery .= " and _SubSubCategoryID ='". $sscatid ."' ";
	 }

	$comrow = mysql_query('SET NAMES utf8');
	$comrow = mysql_query($comquery,$connect);

	
?>  
	<option value="">-- Select One --</option>
	<? while($comdata = mysql_fetch_assoc($comrow)){
		
		?>
		<option value="<?=$comdata['_ID']?>" <? if($comdata['_ID']==$pid) {echo " selected='selected'"; }?>><?=replaceSpecialCharBack($comdata['_ProductName'])?></option>	
	<? }?>

