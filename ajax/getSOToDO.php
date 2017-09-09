<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']=="")
{
        echo "<script language='javascript'>window.location='login.php';</script>";
        exit();
}
include('../global.php');	
include('../include/functions.php');
mysql_query("DELETE FROM ".$tbname."_deliveryorderdiscountdraft WHERE _doid = '".replaceSpecialChar($_REQUEST['tempID'])."' ");

mysql_query("DELETE FROM ".$tbname."_deliveryorderitemsdraft WHERE _orderid = '".$_REQUEST['tempID']."'");

$mystr = "Select * FROM ".$tbname."_salesorderitems WHERE _orderid = '".replaceSpecialChar($_REQUEST['soid'])."' ";

$mystrresult = mysql_query($mystr);

while ($mystrrow = mysql_fetch_assoc($mystrresult))
{
	$sql = "INSERT INTO ".$tbname."_deliveryorderitemsdraft 
(_salestype, _contractperiod, _productname, _productwarranty,  _serialno, _model, _warrantyno, _warrantystartdate, _warrantyenddate, _installationdate, _renttalstartdate, _rentalenddate, _servicingmonths, _months, _firstservicingdate, _rentaltnc, _trialstartdate, _trialenddate, _productid, _qty, _uom, _packaging, _description, _unitprice, _discount, _mscamount, _procure, _orderid, _deliveryleadtime, _ipaddress, _createddate, _createdby, _updateddate, _updatedby) ";
    $sql .= "SELECT _salestype, _contractperiod, _productname, _productwarranty,  _serialno, _model, _warrantyno, _warrantystartdate, _warrantyenddate, _installationdate, _rentalstartdate, _rentalenddate, _servicingmonths, _months, _firstservicingdate, _rentaltnc, _trialstartdate, _trialenddate, _productid, _qty, _uom, _packaging, _description, _unitprice, _discount, _mscamount, _procure, '".$_REQUEST['tempID']."', _deliveryleadtime, '" . $_SERVER['REMOTE_ADDR'] . "', '" . date("Y-m-d H:i:s") . "', '" . $_SESSION['userid'] . "', '" . date("Y-m-d H:i:s") . "', '" . $_SESSION['userid'] . "' FROM ".$tbname."_salesorderitems WHERE _id = '".replaceSpecialChar($mystrrow["_id"])."' ";
	
	
	
	
	    $productID = $mystrrow["_productid"];
		$qty = $mystrrow["_qty"];
		$salesType = $mystrrow["_salestype"];
		
		
	    $mymainsql = "SELECT * From ".$tbname."_accessories acc 
		Where _mainid  = '".  $productID ."' ";
		
		$mymainresult = mysql_query($mymainsql);
		
		while($mymainrow = mysql_fetch_assoc($mymainresult))
		{
			$myProductID = $mymainrow["_productid"];
			
			$mysql = "SELECT p.*,invt._qty,invt._serialno
			 FROM ".$tbname."_inventorytransaction invt
			 inner join ".$tbname."_products p 
			 on (invt._productid = p._id)
			 WHERE _qty > 0 and _productid  = '".  $myProductID ."' ";
		
					$requiredqty = $qty;
					
					$myresult = mysql_query($mysql);
					
					while($myrow = mysql_fetch_assoc($myresult))
					{
						
						 $myqty = $myrow["_qty"];
						 
						 if($myqty >= $requiredqty)
						 {
						      $myaccqty = $requiredqty;
							  $requiredqty = 0;
						 }
						 else
						 {
					
							  $requiredqty = $requiredqty - $myqty;
							  $myaccqty = $myqty;
						 }
			
						
					$str = "INSERT INTO ".$tbname."_deliveryorderitemsdraft
							(_salestype, _contractperiod, _productname, _productwarranty, _serialno, _model, _warrantyno, _renttalstartdate, _rentalenddate, _servicingmonths, _months, _firstservicingdate, _rentaltnc, _installationdate, _trialstartdate, _trialenddate, _productid, _qty, _uom, _packaging, _description, _unitprice, _discount, _mscamount, _procure, _orderid, _deliveryleadtime, _ipaddress, _createddate, _createdby, _updateddate, _updatedby)VALUES(";	
					//}
							
					if($salesType != "") $str = $str . "'" . $salesType . "', ";
					else $str = $str . "null, ";
					
					if($contractPeriod != "") $str = $str . "'" . $contractPeriod . "', ";
					else $str = $str . "null, ";
					
					$str = $str . "'" . $myrow["_productname"] . "', ";
						
					if($productWarranty != "") $str = $str . "'" . $productWarranty . "', ";
					else $str = $str . "null, ";
					
					 $str = $str . "'" . $myrow["_serialno"] . "', ";
					
					if($model != "") $str = $str . "'" . $model . "', ";
					else $str = $str . "null, ";
					
					if($warrantyNo != "") $str = $str . "'" . $warrantyNo . "', ";
					else $str = $str . "null, ";
					
					if($renttalStartDate != "") $str = $str . "'" . $renttalStartDate . "', ";
					else $str = $str . "null, ";
					
					if($rentalEndDate != "") $str = $str . "'" . $rentalEndDate . "', ";
					else $str = $str . "null, ";
					
					if($servicingMonths != "") $str = $str . "'" . $servicingMonths . "', ";
					else $str = $str . "null, ";
					
					if($months != "") $str = $str . "'" . $months . "', ";
					else $str = $str . "null, ";
					
					if($firstServicingDate != "") $str = $str . "'" . $firstServicingDate . "', ";
					else $str = $str . "null, ";
					
					if($rentalTNC != "") $str = $str . "'" . $rentalTNC . "', ";
					else $str = $str . "null, ";
					
					if($installationDate != "") $str = $str . "'" . $installationDate . "', ";
					else $str = $str . "null, ";
					
					if($trialStartDate != "") $str = $str . "'" . $trialStartDate . "', ";
					else $str = $str . "null, ";
					
					if($trialEndDate != "") $str = $str . "'" . $trialEndDate . "', ";
					else $str = $str . "null, ";
					
					$str = $str . "'" . $myrow["_id"] . "', ";
					
					if($myaccqty != "") $str = $str . "'" . $myaccqty . "', ";
					else $str = $str . "null, ";
					
					if($uom != "") $str = $str . "'" . $uom . "', ";
					else $str = $str . "null, ";
					
					if($packaging != "") $str = $str . "'" . $packaging . "', ";
					else $str = $str . "null, ";
					
					$str = $str . "'" . $myrow["_description"] . "', ";
					
					$str = $str . "null,null,null,null,";
					
					$str = $str . "'" . $_REQUEST['tempID'] . "', ";
						
					if($deliveryLeadTime != "") $str = $str . "'" . $deliveryLeadTime . "', ";
					else $str = $str . "null, ";
					
					$str = $str . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
					$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
					$str = $str . "'" . $_SESSION['userid'] . "', ";
					$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
					$str = $str . "'" . $_SESSION['userid'] . "' ";
					$str = $str . ") ";
				
					mysql_query('SET NAMES utf8');
					$result = mysql_query($str) or die(mysql_error());
					
						
						if($requiredqty == 0)
						{
						   break;	
						}
						
						
					}
			
			
			
			
		}	
	
	
	
	
}



	

       
	
	
	
	
	
	
	
	
	
	
	
	
	
    $result2 = mysql_query($sql);
    if($result2>=1)
    {
        $doItemID = mysql_insert_id();
        $str3 =  "INSERT INTO ".$tbname."_deliveryorderdiscountdraft(_doid, _itemid, _discountname, _discount, _createddate, _createdby) SELECT  ('".replaceSpecialChar($_REQUEST['tempID'])."', '".replaceSpecialChar($doItemID)."',_discountname, _discount, '" . date("Y-m-d H:i:s") . "', '" . $_SESSION['userid'] . "' FROM ".$tbname."_salesorderdiscountdraft WHERE _soid = '".$_REQUEST['soid']."'";
        mysql_query($str3);					
        
    }
include('../dbclose.php');                                        
?>
