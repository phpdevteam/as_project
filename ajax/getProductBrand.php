<?php
session_start();
	include('../global.php');	
	include('../include/functions.php');
	
	$scatid = $_REQUEST["scatID"];	
	$sscatid = $_REQUEST["sscatID"];
	$bid = $_REQUEST["bid"];
		
	 $comquery = "SELECT _ID,_BrandName 
	 FROM ".$tbname."_brand b 
	 Where _ID In ( Select _BrandID From
	  ".$tbname."_products p
	  WHERE p._status = 1 and p._type = 1";
	 
	 
	 if($scatid > 0)
	 {
		 $comquery .= " and _SubCategoryID ='". $scatid ."' ";
	 }
	 
	  if($sscatid > 0)
	 {
		 $comquery .= " and _SubSubCategoryID ='". $sscatid ."' ";
	 }
	 
	 
	 $comquery .=" )";
	
	$comrow = mysql_query('SET NAMES utf8');
	$comrow = mysql_query($comquery,$connect);

	
?>  
	<option value="">-- Select One --</option>
	<? while($comdata = mysql_fetch_assoc($comrow)){
		
		?>
		<option value="<?=$comdata['_ID']?>" <? if($comdata['_ID']==$bid) {echo " selected='selected'"; }?>><?=replaceSpecialCharBack($comdata['_BrandName'])?></option>	
	<? }?>

