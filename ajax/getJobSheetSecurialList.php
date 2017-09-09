<?
	include('../global.php');	
	include('../include/functions.php');
		
	$btnSubmit = "Submit";
	$id = $_REQUEST['id'];
	$e_action = $_REQUEST['e_action'];
	
	  $sql = "SELECT si.*, p._productname as _modelname, st._typename as _routingservicename 
		  FROM ".$tbname."_jobsheetsserialno si LEFT JOIN ".$tbname."_products p ON p._id = si._model 
          LEFT JOIN ".$tbname."_routingservicetype st ON st._id = si._routingservice  
		  WHERE _jobsheetid = '".replaceSpecialChar($id)."' " ;
	
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="grid" id="salesItems">
  <tr>
      <td  width="5%" class="gridheader">No</td>
      <td class="gridheader">Model</td>
      <td class="gridheader" width="15%">Serial No</td>
      <td class="gridheader" width="15%">Maintenance Contract Number</td>
      <td class="gridheader" width="15%">Date Installed</td>
      <td class="gridheader" width="15%">Unit Location</td>
      <td class="gridheader" width="15%">Routing Services</td>
      <td class="gridheader" width="5%">Edit</td>
      <td class="gridheader" width="5%">Delete</td>	
  </tr>
  <?
          $sirst = mysql_query($sql) or die(mysql_error());
          $si=0;
          $grossTotal = 0;
          while($sirow = mysql_fetch_assoc($sirst))
          {
  ?>
  <tr id="trSalesItem_<?=$si?>">
  <td class="gridline1"><?=$si+1?></td>
      <td class="gridline1"><?=$sirow['_modelname']?>&nbsp;</td>
      <td class="gridline1"><?=$sirow['_serialno']?>&nbsp;</td>
      <? $strmc = "SELECT _mcno FROM ".$tbname."_maintenancecontract mc WHERE mc._serialno = '".$sirow['_serialno']."' AND mc._status = 'Live' ORDER BY _id DESC LIMIT 1"; 
		$rstmc = mysql_query($strmc);
		$rsmc = mysql_fetch_assoc($rstmc);
	?>
      <td class="gridline1"><?=$rsmc['_mcno']?>&nbsp;</td>
      <td class="gridline1"><?=$sirow['_dateinstalled']!=""?date(DEFAULT_DATEFORMAT,strtotime($sirow['_dateinstalled'])):""?>&nbsp;</td>
      <td class="gridline1"><?=$sirow['_unitlocation']?>&nbsp;</td>
      <td class="gridline1"><?=$sirow['_routingservicename']?>&nbsp;</td>
      <td class="gridline1"><a class='various TitleLink' style='cursor:pointer' name="<?=$sirow['_id']?>" onclick="addMachineSerial('<?=$sirow['_id']?>','<?=$id?>','edit');">Edit</a></td>
      <td class="gridline1"><a class='deleteJobSheet TitleLink' style='cursor:pointer' name="<?=$sirow['_id']?>" >Delete</a></td>	
  </tr>
  <?		$si++;			
          } ?>
</table>      
<input name="totalItems" id="totalItems"  type="hidden" value="<?=$si?>" />