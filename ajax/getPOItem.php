<?php
session_start();
	include('../global.php');	
	include('../include/functions.php');

	$id = $_REQUEST["id"];
	
	?>
    
    <div>
                  <b>PO Items List</b>
                  </div>
                  
                   <br/>
                        
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="grid" id="salesItems">
                    <tr>
                   
                        <td  width="5%" class="gridheader">No</td>
                        <td class="gridheader">Description</td>
                         <td class="gridheader" width="15%">Qty</td>
                        <td class="gridheader" width="15%">Unit Price</td>
                        <td class="gridheader" width="15%">Item Price</td>
                     
                        	
                    </tr>
                    <?
						 $sql = "SELECT si.*,curr._sign,_Qty as _myQty 
							FROM ".$tbname."_purchaseordersitems si
							left join ".$tbname."_currencies curr
							on (si._CurrencyID = curr._ID)
							WHERE si._PurchaseOrderNo = '".replaceSpecialChar($id)."' 
							Order By _order " ;
					
							$sirst = mysql_query($sql);
							$si=1;
							$grossTotal = 0;
							$totalDiscount = 0;
							while($sirow = mysql_fetch_assoc($sirst))
							{
								
										  
									  if  ($Rowcolor == "gridline2")
													$Rowcolor = "gridline1";
												else
													$Rowcolor = "gridline2";
					?>
                    <tr id="trSalesItem_<?=$si?>">
                    
                                        
                        <td  id="Row2ID<?=$si?>" width="5%" class="<?php echo $Rowcolor; ?>"><?=$si?></td>
                        <td id="Row3ID<?=$si?>" class="<?php echo $Rowcolor; ?>"><?=nl2br(replaceSpecialCharBack($sirow['_ProductDescription']))?></td>
                         <td class="<?php echo $Rowcolor; ?>" id="Row4ID<?=$si?>" ><?=$sirow['_myQty'] >0?$sirow['_myQty']:$sirow['_Qty']?></td>
                        <td class="<?php echo $Rowcolor; ?>" id="Row5ID<?=$si?>" ><?=$sirow["_sign"]?> <?=$sirow['_UnitPrice']?></td>
                        <td class="<?php echo $Rowcolor; ?>" id="Row6ID<?=$si?>" ><?
						
							$totalSum = 0;
							//$grossTotal = 0;
							if($sirow['_Qty']!="" && $sirow['_UnitPrice']!="")
								$totalSum = $sirow['_Qty']*$sirow['_UnitPrice'];
							echo $sirow["_sign"] . " " .  number_format($totalSum,2);
							 $grossTotal = $grossTotal + $totalSum;	
							
						?></td>
                      
                    </tr>
                    
                    <?		$si++;			
							}	
						
					?>
                    
                   
                    
                  </table> 


                              
                           