<?php

  $str = "SELECT * FROM ".$tbname."_companyinfo cust
  left join ".$tbname."_countries ctry
			on (cust._countryid = ctry._id)";
$rst = mysql_query("set names 'utf8';");	
$rst = mysql_query($str, $connect) or die(mysql_error());
 
if(mysql_num_rows($rst) > 0)
{
		$myrs = mysql_fetch_assoc($rst);
		$companyname1 = $myrs['_companyname1'];
		
		$companyaddress = $myrs['_companyaddress1'];
		$companyaddress1 = $myrs['_companyaddress1'];
		
		if($myrs['_companyaddress2'] != "")
		{
			$companyaddress .=", " . $myrs['_companyaddress2'];
			$companyaddress2 = $myrs['_companyaddress2'];
		}
		
		if($myrs['_companyaddress3'] != "")
		{
			$companyaddress .=", " . $myrs['_companyaddress3'];
			$companyaddress3 = $myrs['_companyaddress3'];
		}
		
		if($myrs['_postalcode'] != "")
		{
			$companyaddress .=", " . $myrs['_countryname'] . " " . $myrs['_postalcode'] . ".";
			$companypostalcode = "" . $myrs['_countryname'] . " " . $myrs['_postalcode'] . "";
		}
		
		//$companylhead1 = $myrs['_letterheadimage1'];
		$companytel = $myrs['_companytelephone'];
		$companyfax = $myrs['_companyfax'];
		
		 
			
			  $str = "SELECT * FROM ".$tbname."_printoutdefault Where 
		_Module = 'SQ' ";
		
		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect) ;
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			$signaturetxt = replaceSpecialCharBack($rs['_signtext']);
			$signatureimage = replaceSpecialCharBack($rs['_signimage']);
			 $companylhead1 = $rs['_letterheadimage'];
			
		}
		
	
		
}


?>