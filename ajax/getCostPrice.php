<?php
session_start();
	include('../global.php');	
	include('../include/functions.php');
	
	$pID = $_REQUEST["pID"];
	$currencyID = $_REQUEST["currencyID"];
		
	 // $comquery = "SELECT _UnitPrice FROM ".$tbname."_productsprices	 WHERE _status = 1 and _ProductId ='". $pID ."' and _PriceLevelId ='6' ";	
	
	$comquery = "SELECT _UnitPrice FROM ".$tbname."_productsprices	 WHERE _status = 1 
				 and _ProductId ='". $pID ."' and _PriceLevelId ='6' AND CURDATE() >= _AppStartDate AND CURDATE() <= _AppEndDate
				 Order By _subdate DESC limit 1";
	
	$comrow = mysql_query('SET NAMES utf8');
	$comrow = mysql_query($comquery,$connect);

	//If there is no price for today then took the minimum price end date from today.
	if(mysql_num_rows($comrow) == 0)
	{
		$comquery = " Select * From ".$tbname."_productsprices Where  
						_status = 1 and _ProductId ='". $pID ."' and 
						_PriceLevelId ='6' AND CURDATE() >= _AppEndDate 
						Order by _AppEndDate DESC, _subdate DESC LIMIT 1";
	
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery,$connect);
	}
	
$comdata = mysql_fetch_assoc($comrow);
echo $comdata["_UnitPrice"];

?>

