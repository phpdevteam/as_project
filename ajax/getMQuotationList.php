<?
session_start();
	include('../global.php');	
	include('../include/functions.php');
		
	$id = $_GET['id'];
	$session_id = $_GET['tempID'];
	$custid = $_GET['custid'];
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="grid" id="salesItems">
    <tr>
        <td  width="5%" class="gridheader">No</td>
        <td class="gridheader">Equipment / Serial No</td>
        <!--<td class="gridheader" width="5%">Edit</td>-->
        <td class="gridheader" width="5%">Delete</td>	
    </tr>
    <?
        
            $sql = "SELECT si._serialno, prod._productname FROM ".$tbname."_maintainquotationitems si LEFT JOIN ".$tbname."_products prod ON prod._id = si._productid 
              WHERE _orderid = '".replaceSpecialChar($id)."' " ;
            $sirst = mysql_query($sql);
            $si=0;
           
            while($sirow = mysql_fetch_assoc($sirst))
            {
    ?>
    <tr id="trSalesItem_<?=$si?>">
        <td  width="5%" class="gridline1"><?=(int)$si+1?></td>
        <td class="gridline1"><?=$sirow['_productname']." / ".$sirow['_serialno']?></td>
        <!--<td class="gridline1"><span class='editSalesItem TitleLink' style='cursor:pointer' name="<?=$sirow['_id']?>" title="<?=$si?>">Edit</span></td>-->
        <td class="gridline1"><span class='deleteSalesItem TitleLink' style='cursor:pointer' name="<?=$sirow['_id']?>" title="<?=$si?>">Delete</span></td>	
    </tr>
    <?		$si++;			
            }
        
            $sql = "SELECT si._serialno, prod._productname, si._id FROM ".$tbname."_maintainquotationitemsdraft si LEFT JOIN ".$tbname."_products prod ON prod._id = si._productid 
             WHERE _orderid = '".session_id()."' " ;
            $sirst = mysql_query($sql);
            while($sirow = mysql_fetch_assoc($sirst))
            {
    ?>
    <tr id="trSalesItem_<?=$si?>">
        <td  width="5%" class="gridline1"><input name='tempid_<?=$si?>' id='tempid_<?=$si?>"' type='hidden' value='<?=$sirow['_id']?>' /><?=(int)$si+1?></td>
        <td class="gridline1"><?=$sirow['_productname']."/".$sirow['_serialno']?>
        <input name="draft_<?=$sirow['_id']?>" id="draft_<?=$sirow['_id']?>"  type="hidden" value="1" />
        </td>
        <!--<td class="gridline1"><span class='editSalesItem TitleLink' style='cursor:pointer' name="<?=$sirow['_id']?>" title="<?=$si?>">Edit</span></td>-->
        <td class="gridline1"><span class='deleteSalesItem TitleLink' style='cursor:pointer' name="<?=$sirow['_id']?>" title="<?=$si?>">Delete</span></td>	
    </tr>
    <?		$si++;			
            }	
        
    ?>
    
  </table>
<input name="totalItems" id="totalItems"  type="hidden" value="<?=$si?>" />