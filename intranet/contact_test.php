<table width="850" cellpadding="0" cellspacing="0" border="0">								
                                            <tr><td height="5"></td></tr>
                                            <tr><td height="5" colspan="3"><b><u>Contact Person</u></b></td>
                                            	<td colspan="3" align="right">
                                              <?  if($_GET['type'] == 'uc'){
												echo '<a href="contractors.php" class="TitleLink">Contractors List</a>&nbsp;|&nbsp;<a href="contractor.php?ctab='.encrypt('1',$Encrypt).'&id='.encrypt($cid,$Encrypt).'&type='.encrypt($_GET['type'],$Encrypt).'" class="TitleLink">Contact Person List</a>';
											}else if($_GET['type'] == 'me'){
												echo '<a href="members.php" class="TitleLink">Members List</a>&nbsp;|&nbsp;<a href="member.php?ctab='.encrypt('1',$Encrypt).'&id='.encrypt($cid,$Encrypt).'&type='.encrypt($_GET['type'],$Encrypt).'" class="TitleLink">Contact Person List</a>';
											}else
												echo '<a href="customers.php" class="TitleLink">Customers List</a>&nbsp;|&nbsp;<a href="customer.php?ctab='.encrypt('1',$Encrypt).'&id='.encrypt($cid,$Encrypt).'&type='.encrypt($_GET['type'],$Encrypt).'" class="TitleLink">Contact Person List</a>';
                                                ?>                                              
                                                </td>
                                            </tr>
                                            <tr><td height="5"></td></tr>
                                            <tr>
                                                <td width="150">Contact Title</td>
                                                <td width="9">&nbsp;:&nbsp;</td>
                                                <td width="345">
                                                <?  $str = "SELECT _id,_salutation FROM ".$tbname."_salutation ORDER BY _id";
                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                <select  tabindex="" name="contacttitle" id="contacttitle" class="dropdown1">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    
                                                    if(mysql_num_rows($rst) > 0)
                                                    {
                                                        while($rs = mysql_fetch_assoc($rst))
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rs["_salutation"]; ?>" <?php if($rs["_salutation"] == $contacttitle) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_salutation"]; ?>&nbsp;</option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select><span class="detail_red">*</span>
                                                </td>
                                                <td width="200">Contact Name</td>
                                                <td width="9">&nbsp;:&nbsp;</td>
                                                <td width="345">
                                                <input type="text" tabindex="" id="contactname" name="contactname" value="<?=$contactname?>" size="60" class="txtbox1"><span class="detail_red">*</span>
                                                </td>
                                            </tr>
                                            <tr><td height="5"></td></tr>
                                            <tr>
                                            <td valign="top">Contact Email</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="top"><input type="text" tabindex="" id="contactemail" name="contactemail" value="<?=$contactemail?>" size="10" class="txtbox1">
                                                </td>
                                                
                                            <td>Contact Tel1</td>
                                                <td width="10">&nbsp;:&nbsp;</td>
                                                <td><input type="text" tabindex="" id="contacttel" name="contacttel" value="<?=$contacttel?>" size="60" class="txtbox1"><span class="detail_red">*</span></td>
                                            </tr>
                                            <tr><td height="5"></td></tr>
                                            <tr>
                                            <td valign="top">Department</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="top"><select  tabindex="" name="contactdepartment" id="contactdepartment"  class="dropdown1  chosen-select">
											<option value="">-- Select One --</option>
											<?php
										 
											$str = "SELECT * FROM ".$tbname."_department WHERE _ID IS NOT NULL ORDER BY _Department";
											 
											$rst = mysql_query($str, $connect) or die(mysql_error());
											if(mysql_num_rows($rst) > 0)
											{
												while($rs = mysql_fetch_assoc($rst))
												{
												?>
												<option value="<?php echo $rs["_ID"]; ?>" <?php if($rs["_ID"] == $contactdepartment) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_Department"]; ?>&nbsp;</option>
												<?php
												}
											}
											?>
										</select>
                                                </td>
                                                
                                            <td>Contact Tel2</td>
                                                <td width="10">&nbsp;:&nbsp;</td>
                                                <td><input type="text" tabindex="" id="contacttel" name="contacttel" value="<?=$contacttel?>" size="60" class="txtbox1"></td>
                                            </tr>
                                             <tr><td height="5"></td></tr>
                                            <tr>
                                            <td valign="top">Billing Company Name</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="top"><input type="text" tabindex="" id="billcompanyname" name="billcompanyname" value="<?=$billcompanyname?>" size="10" class="txtbox1">
                                                </td>
                                            <td valign="top">System Status</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="top">
                                                	 <select  tabindex="" name="systemstatus" id="systemstatus" class="dropdown1 chosen-select" style="width:220px;">
                                                    <option value="">--select--</option>
                                                    <?php
                                                        $sql = "SELECT * FROM ".$tbname."_systemstatus  ORDER BY _StatusName ";
                                                        $res = mysql_query($sql) or die(mysql_error());
                                                        if(mysql_num_rows($res) > 0){
                                                            while($rec = mysql_fetch_array($res)){
                                                                ?><option <?php if($rec['_id'] == $systemstatus){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_id']; ?>"><?php echo $rec['_StatusName']; ?></option><?php
                                                            }
                                                        }
                                                    ?>
                                                  </select>
                                                </td>    
                                            
                                            </tr>
                                            

                                                <tr><td height="5"></td></tr>
                                            <tr>
                                                <td width="120">City</td>
                                                <td width="10">&nbsp;:&nbsp;</td>
                                                <td valign="top">
                                                    <select  tabindex="" name="contactcityid" id="contactcityid" class="dropdown1 chosen-select" style="width:220px;">
                                                    <option value="">--select--</option>
                                                    <?php
                                                        $sql = "SELECT * FROM ".$tbname."_cities  ORDER BY _cityname ";
                                                        $res = mysql_query($sql) or die(mysql_error());
                                                        if(mysql_num_rows($res) > 0){
                                                            while($rec = mysql_fetch_array($res)){
                                                                ?><option <?php if($rec['_id'] == $contactcityid){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_id']; ?>"><?php echo $rec['_cityname']; ?></option><?php
                                                            }
                                                        }
                                                    ?>
                                                  </select>
                                              </td>
                                                <td>Contact Postalcode</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td><input type="text" tabindex="" id="contactPostalcode" name="contactPostalcode" value="<?=$contactPostalcode?>" style="width:150px" class="txtbox1"></td>
                                               
                                            </tr>
                                            <tr><td height="5"></td></tr>
                                            <tr>
                                            <td valign="top">Country</td>
                                                <td valign="middle">&nbsp;:&nbsp;</td>
                                                <td valign="top"><input type="text" tabindex="" id="country" name="country" value="<?=$country?>" size="10" class="txtbox1">
                                                </td>
                                                
                                            <td>State/Province</td>
                                                <td width="10">&nbsp;:&nbsp;</td>
                                                <td>
                                                	<select  tabindex="" name="stateproid" id="stateproid" class="dropdown1 chosen-select" style="width:220px;">
                                                    <option value="">--select--</option>
                                                    <?php
                                                        $sql = "SELECT * FROM ".$tbname."_provinces  ORDER BY _provincename ";
                                                        $res = mysql_query($sql) or die(mysql_error());
                                                        if(mysql_num_rows($res) > 0){
                                                            while($rec = mysql_fetch_array($res)){
                                                                ?><option <?php if($rec['_id'] == $stateproid){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_id']; ?>"><?php echo $rec['_provincename']; ?></option><?php
                                                            }
                                                        }
                                                    ?>
                                                  </select>
                                                </td>
                                            </tr>
                                            <tr><td height="5"></td></tr>
                                            <tr>
                                                <td>Contact Fax</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td><input type="text" tabindex="" id="contactfax" name="contactfax" value="<?=$contactfax?>" size="60" class="txtbox1"></td>
                                                <td>Contact Url</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td><input type="text" tabindex="" id="contacturl" name="contacturl" value="<?=$contacturl?>" size="60" class="txtbox1"></td>
                                            </tr>
                                            <tr><td height="5"></td></tr> 
                                            <tr>
                                              <td valign="top">Contact Address</td>
                                              <td width="10" valign="top">&nbsp;:&nbsp;</td>
                                            <td><textarea name="contactaddress" id="contactaddress" cols="35" rows="4" class="textarea"><?php echo $contactaddress; ?></textarea><span class="detail_red">*</span></td>
                                                <td valign="top">Contact Remarks</td>
                                                <td valign="top">&nbsp;:&nbsp;</td>
                                                <td><textarea name="contactremarks" cols="35" rows="4" class="textarea"><?php echo $contactremarks; ?></textarea>
                                                </td>
                                            </tr>
                                          
                                             
                                              <tr><td height="5"></td></tr>
                                            <tr>
                                            	<td>Submitted By</td>
                                                <td width="10">&nbsp;:&nbsp;</td>
                                                <td><input type="text" tabindex="" id="submittedby" name="submittedby" value="<?=$submittedby?>" size="60" class="txtbox1"></td>
                                                
                                            <td valign="top">Submitted Date/Time</td>
                                                <td width="10">&nbsp;:&nbsp;</td>
                                                <td><input type="text" tabindex="" id="submittedDate" name="submitteddate" value="<?=$submitteddate?>" size="60" class="txtbox1"></td>
                                            </tr>
                                            
                                             <tr><td height="15"></td></tr> 
                                                                                             
                                            <tr>
                                                <td colspan="2">&nbsp;</td>
                                                <td colspan="2">
												
												<input type="button" class="button1" name="btnCancel" value="< Back" onclick="history.back();" />
												
                                                    <input type="submit" name="btnSubmit" id="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
                                                    <input type="button" name="btnClearAll" class="button1" value="Clear All" onclick="ClearAll('FormName0');" />
                                                    
                                                    <? if($e_action == 'edit'){?>
                                                    <input type="button" class="button1" name="btnDuplicate" id="btnDuplicate" value="Duplicate" />
                                                	<? } ?>
                                                </td>
                                            </tr>
                                            
                                            
                                            
                                          
                                            </table>
                                            
                                            
                                             <table width="100%" cellpadding="1" cellspacing="0" border="0">								
                                            	<tr><td height="5"></td></tr>
                                                 <tr><td height="5" colspan="6">
                                                        <div>
                                                            <div class="left">
                                                                <?=$companyName!=""?$companyName." > ":""?><?=$pageStatus?>
                                                            </div>
                                                            <div class="right"> 
                                                            <a href="customer.php?ctab=<?=encrypt('1',$Encrypt)?>&id=<?=encrypt($cid,$Encrypt)?>&type=<?=encrypt($_GET['type'],$Encrypt)?>" class="TitleLink">Contact Person List</a> | <a href="contactperson.php?cid=<?=encrypt($id,$Encrypt)?>&ctab=<?=encrypt('1',$Encrypt)?>" class="TitleLink">Add Contact Person</a>
                                                            </div>
                                                        </div>                                             
                                                        </td>
                                                    </tr>
                                                 
                                                 <tr><td height="5"></td></tr>
                                                 
                                                 <tr>
                                                           <td width="120">Title</td>
                                                                <td width="10">&nbsp;:&nbsp;</td>
                                                                <td valign="top">
                                                                  <?  $str = "SELECT _id,_salutation FROM ".$tbname."_salutation ORDER BY _id";
                                                                    $rst = mysql_query($str, $connect) or die(mysql_error());?>
                                                                    <select  tabindex="" name="contacttitle" id="contacttitle" class="dropdown1">
                                                                        <option value="">-- Select One --</option>
                                                                        <?php
                                                                        
                                                                        if(mysql_num_rows($rst) > 0)
                                                                        {
                                                                            while($rs = mysql_fetch_assoc($rst))
                                                                            {
                                                                            ?>
                                                                            <option value="<?php echo $rs["_salutation"]; ?>" <?php if($rs["_salutation"] == $contacttitle) {?> selected <?php } ?>>&nbsp;<?php echo $rs["_salutation"]; ?>&nbsp;</option>
                                                                            <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select><span class="detail_red">*</span>
                                                            </td>
                                                            <td colspan="3">
                                                        </tr>
                                                        
                                                 		<tr>
                                                           <td>Name</td>
                                                            <td>&nbsp;:&nbsp;</td>
                                                            <td ><input type="text" tabindex="" id="contactname" name="contactname" value="<?=$contactname?>" size="60" class="txtbox1"><span class="detail_red">*</span></td>
                                                            <td>ID</td>
                                                            <td width="9">&nbsp;:&nbsp;</td>
                                                            <td><?=$id?></td>     						
                                                         </tr>
                                                         
                                                 		<tr><td height="5"></td></tr>
                                                          
                                                     	<tr>
                                                                <td>Address</td>
                                                                <td width="10">&nbsp;:&nbsp;</td>
                                                                <td><input type="text" tabindex="" id="contactaddress" name="contactaddress" value="<?=$contactaddress?>" size="60" class="txtbox1"></td>
                                                                <td>Submitted By</td>
                                                                <td width="10">&nbsp;:&nbsp;</td>
                                                                <? $strP = "SELECT _Fullname FROM ".$tbname."_user WHERE _ID = '".$submittedby."' ";
                                                                    $rstP = mysql_query($strP);
                                                                    $rsP = mysql_fetch_assoc($rstP);
                                                                    $submittedperson = $rsP['_Fullname'];
                                                                 ?>
                                                                <td><?=ucwords($submittedperson)?></td>								   
                                                          </tr>
                                            
                                                 		  <tr><td height="5"></td></tr>
                                            
                                                         <tr>
                                                                <td width="120">City</td>
                                                                    <td width="10">&nbsp;:&nbsp;</td>
                                                                    <td valign="top">
                                                                        <select  tabindex="" name="contactcityid" id="contactcityid" class="dropdown1 chosen-select" style="width:220px;">
                                                                        <option value="">--select--</option>
                                                                        <?php
                                                                            $sql = "SELECT * FROM ".$tbname."_cities  ORDER BY _cityname ";
                                                                            $res = mysql_query($sql) or die(mysql_error());
                                                                            if(mysql_num_rows($res) > 0){
                                                                                while($rec = mysql_fetch_array($res)){
                                                                                    ?><option <?php if($rec['_id'] == $contactcityid){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_id']; ?>"><?php echo $rec['_cityname']; ?></option><?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                      </select>
                                                                  </td>
                                                                    <td valign="top">Submitted Date/Time</td>
                                                                    <td width="10">&nbsp;:&nbsp;</td>
                                                                    <td><?=$submitteddate!=""?date(DEFAULT_DATEFORMAT,strtotime($submitteddate)):""?></td>
                                                                      
                                                            </tr>
                                                 			<tr><td height="5"></td></tr>
                            
                                                            <tr>
                                                                <td width="120">State/Province</td>
                                                                <td width="10">&nbsp;:&nbsp;</td>
                                                                <td>
                                                                    <select  tabindex="" name="contactprovinceid" id="contactprovinceid" class="dropdown1 chosen-select" style="width:220px;">
                                                                            <option value="">--select--</option>
                                                                            <?php
                                                                                $sql = "SELECT * FROM ".$tbname."_provinces  ORDER BY _provincename ";
                                                                                $res = mysql_query($sql) or die(mysql_error());
                                                                                if(mysql_num_rows($res) > 0){
                                                                                    while($rec = mysql_fetch_array($res)){
                                                                                        ?><option <?php if($rec['_id'] == $contactprovinceid){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_id']; ?>"><?php echo $rec['_provincename']; ?></option><?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                          </select>
                                                                </td>
                                                                <td nowrap>System&nbsp;Status&nbsp;</td>
                                                                <td>&nbsp;:&nbsp;</td>
                                                                <td>
                                                                     <?php 
                                                                          $sql = "SELECT _id, _statusname FROM ".$tbname."_systemstatus";
                                                                          $res = mysql_query($sql) or die(mysql_error());
                                                                          if(mysql_num_rows($res) > 0){
                                                                              $st = 1;
                                                                              while($rec2 = mysql_fetch_array($res)){
                                                                                  ?>
                                                                      <input type="radio"   tabindex="" <?=$rec2['_id']==$status?'checked':''?> name="status" value="<?=$rec2['_id']?>" id="status_<?=$st?>" class="radio" /><?=$rec2['_statusname']?>
                                                                      <?php
                                                                            $st++;
                                                                              }
                                                                          }
                                                                      ?>
                                                                  </td>
                                                            </tr>
                                            
                                                			<tr><td height="5"></td></tr>
                                                
                                                		<tr>
                                                        <td width="120">Country</td>
                                                        <td width="10">&nbsp;:&nbsp;</td>
                                                        <td>
                                                            <select  tabindex="" name="contactcountryid" id="contactcountryid" class="dropdown1 chosen-select" style="width:220px;">
                                                            <option value="">--select--</option>
                                                            <?php
                                                                $sql = "SELECT * FROM ".$tbname."_countries ORDER BY _countryname";
                                                                $res = mysql_query($sql) or die(mysql_error());
                                                                if(mysql_num_rows($res) > 0){
                                                                    while($rec = mysql_fetch_array($res)){
                                                                        ?><option <?php if($rec['_id'] == $contactcountryid){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_id']; ?>"><?php echo $rec['_countryname']; ?></option><?php
                                                                    }
                                                                }
                                                            ?>
                                                            </select>
                                                      </td>
                                                            </tr>
                                                    
                                                        <tr><td height="5"></td></tr>
                                                        
                                                        <tr>
                                                            <td width="200">Postal Code</td>
                                                            <td width="9">&nbsp;:&nbsp;</td>
                                                            <td width="345"><input type="text" tabindex="" id="contactpostalcode" name="contactpostalcode" value="<?=$contactpostalcode?>" size="60" class="txtbox1"></td>
                                                           <td width="200">Telephone 1</td>
                                                            <td width="9">&nbsp;:&nbsp;</td>
                                                            <td width="345"><input type="text" tabindex="" id="contacttel1" name="contacttel1" value="<?=$contacttel1?>" size="60" class="txtbox1"></td> 
                                                       </tr>
                                                    
                                                        <tr><td height="5"></td></tr>
                                                        
                                                        <tr>
                                                            <td>Email</td>
                                                                <td>&nbsp;:&nbsp;</td>
                                                              <td valign="top"><input type="text" tabindex="" id="contactemail" name="contactemail" value="<?=$contactemail?>" size="10" class="txtbox1"></td>
                                                              <td>Telephone 2</td>
                                                              <td width="10">&nbsp;:&nbsp;</td>
                                                              <td><input type="text" tabindex="" id="contacttel2" name="contacttel2" value="<?=$contacttel2?>" size="60" class="txtbox1"></td>                                          
                                                          </tr>
                                                          
                                                         <tr><td height="5"></td></tr>     
                                                                
                                                        <tr>
                                                          <td>Url</td>
                                                          <td>&nbsp;:&nbsp;</td>
                                                          <td><input type="text" tabindex="" id="contacturl" name="contacturl" value="<?=$contacturl?>" size="60" class="txtbox1"></td>
                                                          <td>Fax</td>
                                                          <td>&nbsp;:&nbsp;</td>
                                                          <td><input type="text" tabindex="" id="contactfax" name="contactfax" value="<?=$contactfax?>" size="60" class="txtbox1"></td>                                  
                                                        </tr>
                                                        
                                                        <tr><td height="5"></td></tr>
                                                        
                                                        <tr>
                                                            <td valign="top">Remarks</td>
                                                            <td valign="top">&nbsp;:&nbsp;</td>
                                                            <td colspan="4"><textarea name="contactremarks" cols="35" rows="4" style="width:95%" class="textarea"><?php echo $contactremarks; ?></textarea>
                                                            </td>
                                                         </tr>
                                                        
                                                        <tr><td height="5"></td></tr>
                                                                                                                                        
                                                        <tr>
                                                                    <td colspan="2">&nbsp;</td>
                                                                    <td>
                                                                        <input type="button" class="button1" name="btnCancel" value="< Back" onclick="window.location='customer.php?ctab=<?=encrypt('1',$Encrypt)?>&id=<?=encrypt($cid,$Encrypt)?>';" />
                                                                        <input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />
                                                                        <input type="button" name="btnClearAll" class="button1" value="Clear All" onclick="ClearAll('FormName0');" />
                                                                        
                                                                    </td>
                                                                </tr>
                                                              
                                  		 </table>