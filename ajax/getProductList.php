<?php
session_start();
	include('../global.php');	
	include('../include/functions.php');
?>
  <select name="productID" class="dropdown1" id="productID">
  <option value="">-- Select One --</option>
  <?
      $query = "SELECT _id,_productname FROM ".$tbname."_products WHERE _status = 'Live' ORDER BY _productname";
      $row = mysql_query('SET NAMES utf8');
      $row = mysql_query($query,$connect);
      while($data=mysql_fetch_assoc($row)){
  ?>
  <option value="<?=$data['_id']?>" <? if($data['_id']==$productID) echo " selected"; ?>><?=$data['_productname'];?></option>
  <?	} ?>
</select>
