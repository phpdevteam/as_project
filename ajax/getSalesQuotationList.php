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
    <td class="gridheader">Description</td>
    <td class="gridheader" width="15%">Qty</td>
    <td class="gridheader" width="15%">UOM</td>
    <td class="gridheader" width="15%">Unit Price</td>
    <td class="gridheader" width="15%">Amount</td>
    <td class="gridheader" width="5%">Edit</td>
    <td class="gridheader" width="5%">Delete</td>	
 </tr>
  <?
      
         $sql = " select b._ID,b._ItemType,b._Qty,b._Description,b._UOM, a._UnitPrice from cd_productsprices a right join cd_salequotationitems b on a._ID =  b._UnitPrice Where b._QutotationId= '".replaceSpecialChar($session_id)."'";
		 $sirst = mysql_query($sql);
		 $si=0;
		 $grossTotal = 0;
		 $totalDiscount = 0;
		  while($sirow = mysql_fetch_assoc($sirst))
	{
  ?>
  <tr id="trSalesItem_<?=$si?>">
                        <td  width="5%" class="gridline1"><?=(int)$si+1?></td>
                        <td class="gridline1"><?=$sirow['_ItemType']?><?=$sirow['_Description']!=""?" / ":""?><?=nl2br($sirow['_Description'])?></td>
                        <td class="gridline1"><?=$sirow['_Qty']?></td>
                        <td class="gridline1"><?=$sirow['_UOM']?></td>
                        <td class="gridline1"><?=$sirow['_UnitPrice']?></td>
                        <td class="gridline1"><?
                        $totalSum = 0;
						if($sirow['_Qty']!="" && $sirow['_UnitPrice']!="")
							$totalSum = $sirow['_Qty']*$sirow['_UnitPrice'];
				
                        
						echo number_format($totalSum,2);
						$grossTotal = $grossTotal + $totalSum;	
						?><input name='totalsum_<?=$si?>' id='totalsum_<?=$si?>' type='hidden' value='<?=$totalSum?>' /></td>
                        <td class="gridline1"><span class='editSalesItem TitleLink' style='cursor:pointer' name="<?=$sirow['_ID']?>" title="<?=$si?>">Edit</span></td>
                        <td class="gridline1"><span class='deleteSalesItem TitleLink' style='cursor:pointer' name="<?=$sirow['_ID']?>" title="<?=$si?>">Delete</span></td>	
                    </tr>
                    
                    <?		$si++;			
							}	
						
					?>
                    
                  </table>
                   
                  <input name="totalItems" id="totalItems"  type="hidden" value="<?=$si?>" />