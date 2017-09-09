<?
$gbtitlename="Intranet System";
$appname ="Coda Intranet System"; 
global $AdminId;
$AdminId="1";

$httpaddress = "http://cloud1.networkz.com.sg/coda_dev";
$temppage = explode("/",substr($_SERVER['PHP_SELF'],1));
if($temppage[1]=="")
	$pagename = $temppage[0];
else
	$pagename = $temppage[1];


$Encrypt = "mysecretekey";

$AdminFilePath = "uploadfiles/";
$AdminTopCMSImagesPath = "uploadfiles/";
//set Time zone
date_default_timezone_set('Singapore');

include('dbopen.php');
mysql_select_db($database, $connect);

define('DEFAULT_DATEFORMAT', "d/m/Y"); 
$datePickerFormat = '"dd/mm/yy"';

$defaultWarrantyPeriod = 0;



  $strG = "SELECT _rate FROM ".$tbname."_gstmaster WHERE _StartDate <= '".date("Y-m-d")."' AND _EndDate >= '".date("Y-m-d")."' ";
	$rstG = mysql_query("set names 'utf8';");	
	$rstG = mysql_query($strG, $connect);
	if(mysql_num_rows($rstG) > 0)
	{
		$rsG = mysql_fetch_assoc($rstG);
		 $gstRate = $rsG['_rate'];
	}
   
   $strW = "SELECT _alertperiod FROM ".$tbname."_machinewarrantyperiod WHERE _id = '1' ";
	$rstW = mysql_query("set names 'utf8';");	
	$rstW = mysql_query($strW, $connect);
	if(mysql_num_rows($rstW) > 0)
	{
		$rsW = mysql_fetch_assoc($rstW);
		 $defaultWarrantyPeriod = $rsW['_alertperiod'];
	}


	
$PageSize = 30;
?>