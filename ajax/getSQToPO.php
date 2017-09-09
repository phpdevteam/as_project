<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']=="")
{
        echo "<script language='javascript'>window.location='login.php';</script>";
        exit();
}
include('../global.php');	
include('../include/functions.php');

	
	$mpurchaseorderno = $_REQUEST['MtempID'];
	$purchaseorderno = $_REQUEST['tempID'];

	$sql = "INSERT INTO ".$tbname."_purchaseordersitems 
	(_CatId,_SubCatId,_SubSubCatId,_BrandId,_Model,_ProductId, _ProductDescription,_purchaseorderno, _Qty,_UOM,_UnitPrice,_Remarks,_subdate,_subby) ";
     $sql .= "SELECT _CatId, _SubCatId,_SubSubCatId,_BrandId,_Model,_ProductID,_Description,'". $purchaseorderno ."',_Qty,_UOM,_UnitPrice,_ItemRemarks,'" . date("Y-m-d H:i:s") . "', '" . $_SESSION['userid'] . "' FROM ".$tbname."_salequotationitems WHERE _QutotationId = '".replaceSpecialChar($_REQUEST['sqid'])."' ";
	
	   mysql_query('SET NAMES utf8');
	   mysql_query($sql);

	echo "purchaseorder.php?id=".encrypt($mpurchaseorderno,$Encrypt)."&e_action=".encrypt('edit',$Encrypt) ."";		
	
		
include('../dbclose.php');
	exit();


	

       
	
	
	
	
	
	
	
	
	
	
	
	
	
    $result2 = mysql_query($sql);
    if($result2>=1)
    {
        $doItemID = mysql_insert_id();
        $str3 =  "INSERT INTO ".$tbname."_deliveryorderdiscountdraft(_doid, _itemid, _discountname, _discount, _createddate, _createdby) SELECT  ('".replaceSpecialChar($_REQUEST['tempID'])."', '".replaceSpecialChar($doItemID)."',_discountname, _discount, '" . date("Y-m-d H:i:s") . "', '" . $_SESSION['userid'] . "' FROM ".$tbname."_salesorderdiscountdraft WHERE _soid = '".$_REQUEST['soid']."'";
        mysql_query($str3);					
        
    }
include('../dbclose.php');                                        
?>
