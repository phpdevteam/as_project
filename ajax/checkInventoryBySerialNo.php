<?php
session_start();
	include('../global.php');	
	include('../include/functions.php');
	
	$e_action = $_GET['e_action'];
		
	if($e_action == 'checkserialno')
	{
		$comquery = "SELECT SUM(_qty) AS _tqty FROM ".$tbname."_inventorytransaction WHERE _serialno = '".replaceSpecialChar(rawurldecode($_REQUEST['serialno']))."' ";
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		echo $comrow['_tqty'];
	}
?>