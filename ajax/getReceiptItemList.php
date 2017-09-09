<?
session_start();
	include('../global.php');	
	include('../include/functions.php');
		
	$id = $_GET['id'];
	$session_id = $_GET['tempID'];
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="grid" id="salesItems">
                    <tr>
                        <td  width="5%" class="gridheader">No</td>
                        <td class="gridheader">Service/Description</td>
                        <td class="gridheader" width="15%">Qty</td>
                        <td class="gridheader" width="15%">Total Sum</td>
                        <td class="gridheader" width="5%">Edit</td>
                        <td class="gridheader" width="5%">Delete</td>	
                    </tr>
                    <?
						
							$sql = "SELECT si.*, st._typename as _salestypename, p._productname as _pdescription FROM ".$tbname."_receiptitems si
							 INNER JOIN ".$tbname."_products p ON p._id = si._productid
							LEFT JOIN ".$tbname."_salesitemtype st ON st._id = si._salestype  WHERE _orderid = '".replaceSpecialChar($id)."' " ;
							$sirst = mysql_query($sql);
							$si=0;
							$grossTotal = "";
							while($sirow = mysql_fetch_assoc($sirst))
							{
					?>
                    <tr id="trSalesItem_<?=$si?>">
                        <td  width="5%" class="gridline1"><?=(int)$si+1?></td>
                        <td class="gridline1"><?=$sirow['_salestypename']."/".nl2br($sirow['_description'])?></td>
                        <td class="gridline1"><?=$sirow['_qty']?></td>
                        <td class="gridline1"><?
                        $totalSum = 0;
						if($sirow['_qty']!="" && $sirow['_unitprice']!="")
							$totalSum = $sirow['_qty']*$sirow['_unitprice'];
						 $str2 = "SELECT * FROM ".$tbname."_receiptdiscount WHERE (_itemid = '".$sirow['_id']."') ";
						  $rst2 = mysql_query($str2);
						 while($rs2 = mysql_fetch_assoc($rst2)){ 
							  $totalSum = (float)$totalSum - (float)$rs2['_discount'];						  							
						 }
						echo number_format($totalSum,2);
						$grossTotal = $grossTotal + $totalSum;	
						?><input name='totalsum_<?=$si?>' id='totalsum_<?=$si?>' type='hidden' value='<?=$totalSum?>' /></td>
                        <td class="gridline1"><span class='editSalesItem TitleLink' style='cursor:pointer' name="<?=$sirow['_id']?>" title="<?=$si?>">Edit</span></td>
                        <td class="gridline1"><span class='deleteSalesItem TitleLink' style='cursor:pointer' name="<?=$sirow['_id']?>" title="<?=$si?>">Delete</span></td>	
                    </tr>
                    <?		$si++;			
							}
						
							$sql = "SELECT si.*, st._typename as _salestypename, p._productname as _pdescription FROM ".$tbname."_receiptitemsdraft si
							 INNER JOIN ".$tbname."_products p ON p._id = si._productid
							LEFT JOIN ".$tbname."_salesitemtype st ON st._id = si._salestype 
							 WHERE _orderid = '".session_id()."' " ;
							$sirst = mysql_query($sql);
							
							while($sirow = mysql_fetch_assoc($sirst))
							{
					?>
                    <tr id="trSalesItem_<?=$si?>">
                        <td  width="5%" class="gridline1"><input name='tempid_<?=$si?>' id='tempid_<?=$si?>"' type='hidden' value='<?=$sirow['_id']?>' /><?=(int)$si+1?></td>
                        <td class="gridline1"><?=$sirow['_salestypename']."/".nl2br($sirow['_description'])?></td>
                        <td class="gridline1"><?=$sirow['_qty']?></td>
                        <td class="gridline1"><?
                        $totalSum = 0;
						if($sirow['_qty']!="" && $sirow['_unitprice']!="")
							$totalSum = $sirow['_qty']*$sirow['_unitprice'];
						 $str2 = "SELECT * FROM ".$tbname."_receiptdiscountdraft WHERE (_itemid = '".$sirow['_id']."') ";
						  $rst2 = mysql_query($str2);
						 while($rs2 = mysql_fetch_assoc($rst2)){ 
							  $totalSum = (float)$totalSum - (float)$rs2['_discount'];						  							
						 }

						echo number_format($totalSum,2);
						$grossTotal = $grossTotal + $totalSum;		
						?>
                       <input name='totalsum_<?=$si?>' id='totalsum_<?=$si?>' type='hidden' value='<?=$totalSum?>' />
                        <input name="draft_<?=$rs['_id']?>" id="draft_<?=$rs['_id']?>"  type="hidden" value="1" /></td>
                        <td class="gridline1"><span class='editSalesItem TitleLink' style='cursor:pointer' name="<?=$sirow['_id']?>" title="<?=$si?>">Edit</span></td>
                        <td class="gridline1"><span class='deleteSalesItem TitleLink' style='cursor:pointer' name="<?=$sirow['_id']?>" title="<?=$si?>">Delete</span></td>	
                    </tr>
                    <?		$si++;			
							}	
						
					?>
                    
                  </table>
<input name="totalItems" id="totalItems"  type="hidden" value="<?=$si?>" />