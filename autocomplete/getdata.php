<?php
require_once "../global.php";
$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "select DISTINCT _ID as id, _ItemName as itemname from ".$tbname."_product where _ItemName LIKE '%$q%' ORDER by _ItemName";
$rsd = mysql_query($sql);
while($rs = mysql_fetch_array($rsd)) {
	$cid = $rs['id'];
	$cname = $rs['itemname'];
	echo "$cname|$cid\n";
}
?>
