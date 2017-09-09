<?php
session_start();
	include('../global.php');	
	include('../include/functions.php');
	
	$pID = $_REQUEST["pID"];	
	$pLevel = $_REQUEST["pLevel"];
	$currencyID = $_REQUEST["currencyID"];
		
	// $comquery = "SELECT _UnitPrice FROM ".$tbname."_productsprices	 WHERE _status = 1 and _ProductId ='". $pID ."' and _PriceLevelId ='". $pLevel ."' and _CurrencyID ='". $currencyID ."' Order By _ID DESC limit 1";	
	
	//Below query is for pick the price if current date is in between the price start and end date.
	$comquery = "SELECT _UnitPrice FROM ".$tbname."_productsprices	 
				 WHERE _status = 1 and _ProductId ='". $pID ."' and 
				 _PriceLevelId ='". $pLevel ."' and _CurrencyID ='". $currencyID ."' 
				 AND CURDATE() >= _AppStartDate AND CURDATE() <= _AppEndDate
				  Order By _subdate DESC limit 1";	
	
	$comrow = mysql_query('SET NAMES utf8');
	$comrow = mysql_query($comquery,$connect);

	
	//If there is no price for today then took the minimum price end date from today.
	if(mysql_num_rows($comrow) == 0)
	{
		$comquery = " Select * From ".$tbname."_productsprices Where  
						_status = 1 and _ProductId ='". $pID ."' and 
						_PriceLevelId ='". $pLevel ."' and _CurrencyID ='". $currencyID ."'
						AND CURDATE() >= _AppEndDate 
						Order by _AppEndDate DESC, _subdate DESC LIMIT 1";
	
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery,$connect);
	}
	
	
	
$comdata = mysql_fetch_assoc($comrow);
echo $comdata["_UnitPrice"];

?>