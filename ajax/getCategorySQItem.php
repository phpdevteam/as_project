<?php
session_start();
	include('../global.php');	
	include('../include/functions.php');
	
	$mytype = $_REQUEST["mytype"];
	$subcategoryID = $_REQUEST["sid"];
	$subsubcategoryID = $_REQUEST["ssid"];
	$bid = $_REQUEST["bid"];
	
	?>
    
    <option value="">-- Select One --</option>
	
	<?php	

  $query = "SELECT _ID,_CategoryName FROM ".$tbname."_categories WHERE _status = '1' and _type='". $mytype ."' ";


  if($bid > 0)
  {
  //	$query .= " and _ID In ( Select _CategoryID From ".$tbname."_products Where _status = 1 and _BrandID = '". $bid."') ";
  }
  
   $query .= " ORDER BY _CategoryName";
  $row = mysql_query('SET NAMES utf8');
  $row = mysql_query($query,$connect);
  while($data=mysql_fetch_assoc($row)){
                            ?>
                   
                              
                              
                              <optgroup label="<?=$data['_CategoryName'];?>">          
                              
                            <!--sub cateogry-->  
                                <?
                                  $query1 = "SELECT _ID,_SubCategoryName FROM ".$tbname."_subcategories WHERE _status = '1' and _CategoryId = '". $data['_ID'] ."'  and _type='". $mytype ."' ";
                               
							     if($bid > 0)
								  {
									$query .= " and _ID In ( Select _SubCategoryID From ".$tbname."_products Where _status = 1 and _BrandID = '". $bid."') ";
								  }

							   
                                  $query1 .= " ORDER BY _SubCategoryName";
                                  $row1 = mysql_query('SET NAMES utf8');
                                  $row1 = mysql_query($query1,$connect);
                                  while($data1=mysql_fetch_assoc($row1)){
                              ?>
                              <option title="s" value="<?=$data1['_ID']?>" <? if($data1['_ID']==$subcategoryID) {echo " selected='selected'"; }?>><?=$data1['_SubCategoryName'];?></option>
                              <?	} ?>
                              
                             <!--sub sub cateogry-->  
                               <?
                                  $query2 = "SELECT _ID,_SubSubCategoryName FROM ".$tbname."_subsubcategories WHERE _status = '1' and _CategoryId = '". $data['_ID'] ."' and _SubCategoryId = '". $data1['_ID'] ."'  and _type='". $mytype ."'  ";
                               
                                  $query2 .= " ORDER BY _SubSubCategoryName";
                                  $row2 = mysql_query('SET NAMES utf8');
                                  $row2 = mysql_query($query2,$connect);
                                  while($data2=mysql_fetch_assoc($row2)){
                              ?>
                              <option title="ss"  value="<?=$data2['_ID']?>" <? if($data2['_ID']==$subsubcategoryID) {echo " selected='selected'"; }?>><?=$data2['_SubSubCategoryName'];?></option>
                              <?	} ?>
                              
                                 </optgroup>
                              
                              <?	} ?>


                              
                           