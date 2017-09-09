<?
session_start();
	include('../global.php');	
	include('../include/functions.php');
	
	$e_action = $_REQUEST['e_action'];
	if($e_action == 'getInvoiceNo')
	{
		echo generateInvoiceNo($_REQUEST['com']);
	}
	else if($e_action == 'getSalesQuotationNo')
	{
		echo generateQuotationNo($_REQUEST['com']);
	}
	else if($e_action == 'getPOQty')
	{
		$str = " Select sum(_Qty) as _TotalQty From ". $tbname."_purchaseordersitems Where _PurchaseOrderNo = '". $_REQUEST["poid"]."' and _ProductId = '". $_REQUEST["itemid"] ."'";
		$result1 = mysql_query($str);
		$myrow = mysql_fetch_assoc($result1);
		
		echo $myrow["_TotalQty"];
		
	}
	else if($e_action == 'getState')
	{
		
		$str = " Select * From ". $tbname."_provinces Where _status = 1
		and _countryid = '". $_REQUEST["cid"] ."'";
	
		
		$result1 = mysql_query($str);
		
		?>
		<option value="">--Select--</option>

		<?php							
		while($rs1 = mysql_fetch_assoc($result1))
		{ ?>
                                        
        <option value="<?php echo $rs1["_id"]; ?>" <?=$selected?> ><?php echo $rs1["_provincename"]; ?></option>
                                           
       <?php
        }
		
	}else if($e_action == 'getCity')
	{
		
		$str = " Select * From ". $tbname."_cities Where _status = 1
		and _stateid = '". $_REQUEST["sid"] ."'";
		$result1 = mysql_query($str);
		
		?>
		<option value="">--Select--</option>

		<?php							
		while($rs1 = mysql_fetch_assoc($result1))
		{ ?>
                                        
        <option value="<?php echo $rs1["_id"]; ?>" <?=$selected?> ><?php echo $rs1["_cityname"]; ?></option>
                                           
       <?php
        }
		
	}



	else if($e_action == 'getSubtype')
	{
		
		$str = " Select * From ". $tbname."_trainingsubtype Where _Status = 1
		and _TypeID = '". $_REQUEST["cid1"] ."'";
	
		
		$result1 = mysql_query($str);
		
		?>
		<option value="">--Select--</option>

		<?php							
		while($rs1 = mysql_fetch_assoc($result1))
		{ ?>
                                        
        <option value="<?php echo $rs1["_ID"]; ?>" <?=$selected?> ><?php echo $rs1["_SubTypeName"]; ?></option>
                                           
       <?php
        }
		
	}else if($e_action == 'getSubSubtype')
	{
		
		$str = " Select * From ". $tbname."_trainingsubsubtype Where _Status = 1
		and _SubTypeID = '". $_REQUEST["sid1"] ."'";
		
		$result1 = mysql_query($str);
		
		?>
		<option value="">--Select--</option>

		<?php							
		while($rs1 = mysql_fetch_assoc($result1))
		{ ?>
                                        
        <option value="<?php echo $rs1["_ID"]; ?>" <?=$selected?> ><?php echo $rs1["_SubSubTypeName"]; ?></option>
                                           
       <?php
        }
		
	}




	else if($e_action == 'getlocation')
	{
		
		$str = " Select * From ". $tbname."_warhouses Where _status = 1";
									$result1 = mysql_query($str);
		
		?>
		<option value="">-- Select Location --</option>

		<?php							
		while($rs1 = mysql_fetch_assoc($result1))
		{ ?>
                                        
                                          <optgroup label="<?=$rs1['_warhouseName'];?>"> 
                                          
                                          <?php
										  
										  $str = "Select * From ". $tbname."_locations Where _status = 1 and _warhouseId = '". $rs1['_ID'] ."'";
										  $result2 = mysql_query($str);
										  
										while($rs2 = mysql_fetch_assoc($result2))
											{  
                                    		 ?>
                                        <option value="<?php echo $rs2["_ID"]; ?>" <?=$selected?> ><?php echo $rs2["_LocationName"]; ?></option>
                                        
											 <?php
                                            }
                                            ?>
                                        
                                          </optgroup>
                                        
                                        <?php
                                       
                                    }
		
	}
	else if($e_action == 'getcontractorlink')
	{
		echo rawurlencode('<span class="TitleLink" style="cursor:pointer;" onclick="window.open(\'maincontractor.php?id='.encrypt($_REQUEST['contractor'],$Encrypt).'&e_action='.encrypt('edit',$Encrypt).'\');">View Contractor</span>');	
	}
	else if($e_action == 'getsubcat')
	{
		?>
		<select name="prodsubcat" id="prodsubcat" class="dropdown1   chosen-select" style="width:220">
          <option value="">--select--</option>
          <?php
              $sql = "SELECT * FROM ".$tbname."_subcategories WHERE _CategoryId = '".$_REQUEST['prodcat']."' ORDER BY _SubCategoryName";
              $res = mysql_query($sql) or die(mysql_error());
              if(mysql_num_rows($res) > 0){
                  while($rec = mysql_fetch_array($res)){
                      ?><option <?php if($rec['_ID'] == $prodsubcat){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_ID']; ?>"><?php echo $rec['_SubCategoryName']; ?></option><?php
                  }
              }
          ?>
          </select>	<span class="detail_red">*</span>
          <?
	}
	else if($e_action == 'getSCat')
	{
		?>
		  <option value="">--select--</option>
          <?php
              $sql = "SELECT * FROM ".$tbname."_subcategories WHERE _type='". $_REQUEST['type'] ."' ";
			  
			  if($_REQUEST['catid'] != "")
			  {
				  $sql .= " and _CategoryId = '".$_REQUEST['catid']."'  ";
			  }
			  
			  $sql .= " ORDER BY _SubCategoryName";
			   
			   
              $res = mysql_query($sql) or die(mysql_error());
              if(mysql_num_rows($res) > 0){
                  while($rec = mysql_fetch_array($res)){
                      ?><option <?php if($rec['_ID'] == $prodsubcat){ echo 'selected="selected"'; } ?> value="<?php echo $rec['_ID']; ?>"><?php echo $rec['_SubCategoryName']; ?></option><?php
                  }
              }
          ?>
          
          <?
	}
	else if($e_action=="getCustomer")
	{
		$results = array();
		$str = "SELECT _id,_companyname,Concat(_address,if(isnull(_postalcode),'',Concat(',Singapore ',_postalcode))) as _address FROM ".$tbname."_customer WHERE _memberid LIKE '".replaceSpecialChar($_REQUEST['name_startsWith'])."%' OR _companyname LIKE '".replaceSpecialChar($_REQUEST['name_startsWith'])."%' ";
		$rst = mysql_query('set names utf8');
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0) {
			while($rs = mysql_fetch_assoc($rst))
			{
				$results[] = $rs;
			}						
		}
		
		$main = array("customer"=>$results);
		header('Content-type: application/json');
		echo json_encode($main);
		die;
	}else if($e_action=="getmno")
	{
		$str = "SELECT _memberid FROM ".$tbname."_customer WHERE _id = '".replaceSpecialChar($_REQUEST['customerID'])."' ";
		$rst = mysql_query('set names utf8');
		$rst = mysql_query($str, $connect);
		if(mysql_num_rows($rst) > 0) {
			$rs = mysql_fetch_assoc($rst);
			echo $rs['_memberid'];
		}
		
		die;
	}
	else if($e_action=="getTncText")
	{
		$results = array();
		$str = "SELECT * FROM ".$tbname."_tnctext WHERE _id = '".replaceSpecialChar($_REQUEST['titleID'])."' ";
	
		$rst = mysql_query('set names utf8');
		$rst = mysql_query($str, $connect) or die(mysql_error());
		$results = mysql_fetch_assoc($rst);
		
		$main = array("tnctitle"=>$results);
		header('Content-type: application/json');
		echo json_encode($main);
		die;
	}
	else if($e_action=="getContactPerson")
	{
		$results = array();
		$str = "SELECT _id,_contactname,_contacttitle,Concat(_address1,_address2,_address3,if(isnull(_postalcode),'',Concat(',Singapore ',_postalcode))) as _address1,_address2,_address3,_contactemail FROM ".$tbname."_contactperson WHERE _contactname LIKE '".replaceSpecialChar($_REQUEST['name_startsWith'])."%' ";
		if($_REQUEST['cid']!="")
		 $str .= " AND _customerid = '".replaceSpecialChar($_REQUEST['cid'])."' ";
		$rst = mysql_query('set names utf8');
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0) {
			while($rs = mysql_fetch_assoc($rst))
			{
				$results[] = $rs;
			}						
		}
		
		$main = array("contactperson"=>$results);
		header('Content-type: application/json');
		echo json_encode($main);
		die;
	}
	
	else if($e_action == 'getsodate')
	{
		  $sql = "SELECT _orderdate FROM ".$tbname."_salesorder WHERE _id = '".$_REQUEST['soid']."' ";
		  $res = mysql_query($sql) or die(mysql_error());
		  if(mysql_num_rows($res) > 0){
			  while($rec = mysql_fetch_array($res)){
				  if($rec['_orderdate']!="")
				  {
				   echo date(DEFAULT_DATEFORMAT,strtotime($rec['_orderdate'])); 
				  }
			  }
		  }
	}
		else if($e_action == 'getsqdate')
	{
		  $sql = "SELECT _quotationdate FROM ".$tbname."_salequotations WHERE _ID = '".$_REQUEST['sqid']."' ";
		  $res = mysql_query($sql) or die(mysql_error());
		  if(mysql_num_rows($res) > 0){
			  while($rec = mysql_fetch_array($res)){
				  if($rec['_quotationdate']!="")
				  {
				   echo date(DEFAULT_DATEFORMAT,strtotime($rec['_quotationdate'])); 
				  }
			  }
		  }
	}
        else if($e_action == 'getsoinfo')
	{
		  $sql = "SELECT DATE_FORMAT(_orderdate,'%d/%m/%Y') as _orderdate,_customerid,_contactid,_invoiceaddress,_shippingaddress,_tnc,_orderremarks,_salescode,_pono,DATE_FORMAT(_deliverydate,'%d/%m/%Y') as _deliverydate,_deliverymethod,_deliverynotes FROM ".$tbname."_salesorder WHERE _id = '".$_REQUEST['soid']."' ";
		  $res = mysql_query($sql);
		  
		$rec = mysql_fetch_assoc($res);

		header('Content-type: application/json');
		echo json_encode($rec);
		die;
                
	}
	else if($e_action=="getCustomerInfoBySerialNo")
	{
		/*INNER JOIN ".$tbname."_salesorder so ON so._customerid = cust._id 
		INNER JOIN ".$tbname."_salesorderitems sod ON sod._orderid = so._id 
		*/
		
		$str = "SELECT cust._companyname, sv._id as _serviceid, cust._id as _customerid, mw._warrantyno, mw._model, mw._serialno, mw._invoiceid, mw._unitprice, DATE_FORMAT(mw._datepaid,'%d/%m/%Y') AS _datepaid, mw._salesman, mw._unitlocation, DATE_FORMAT(mw._waterblk,'%d/%m/%Y') AS _waterblk, DATE_FORMAT(mw._pressurereg,'%d/%m/%Y') AS _pressurereg, DATE_FORMAT(mw._dateinstalled,'%d/%m/%Y') AS _dateinstalled, DATE_FORMAT(mw._warrantystart,'%d/%m/%Y') AS _warrantystart, DATE_FORMAT(mw._6mthservicing,'%d/%m/%Y') AS _6mthservicing, DATE_FORMAT(mw._warrantyend,'%d/%m/%Y') AS _warrantyend, mw._freebies, mw._chequeno, mw._typeofpayment  FROM ".$tbname."_customer cust 
		INNER JOIN ".$tbname."_machinewarranty mw ON mw._customerid = cust._id 
		INNER JOIN ".$tbname."_services sv ON sv._warrantyid = mw._id 
		 WHERE mw._serialno LIKE '".replaceSpecialChar($_REQUEST['serialNo'])."' LIMIT 1";
		$rst = mysql_query('set names utf8');
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0) {
			$results = mysql_fetch_assoc($rst);
		}
		
		header('Content-type: application/json');
		echo json_encode($results);
		die;
	}
	else if($e_action=="getServiceNoByMSCType")
	{
		$results = array();
		$str = "SELECT _noofservices  FROM ".$tbname."_msctype msc 
		 WHERE _id = '".replaceSpecialChar($_REQUEST['msctype'])."' AND _status = 'Live' ";
		$rst = mysql_query('set names utf8');
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0) {
			while($rs = mysql_fetch_assoc($rst))
			{
				echo $rs['_noofservices'];
			}						
		}
			
	}else if($e_action == 'checkserialno')
	{
		$comquery = "SELECT SUM(_qty) AS _tqty FROM ".$tbname."_inventorytransaction WHERE _serialno = '".replaceSpecialChar(rawurldecode($_REQUEST['serialno']))."' ";
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
			echo $comrs['_tqty'];
	}
	else if($e_action == 'getSalesCode')
	{
		 $comquery = "SELECT _SalesCode FROM ".$tbname."_user WHERE _ID = '".replaceSpecialChar(rawurldecode($_REQUEST['id']))."' ";
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
			echo rawurlencode($comrs['_SalesCode']);
	}
	
	else if($e_action == 'checkchangedpart')
	{
		if($_REQUEST['chid']=='')
		{
			$comquery = "SELECT SUM(_qty) AS _tqty FROM ".$tbname."_inventorytransaction WHERE _serialno = '".replaceSpecialChar(rawurldecode($_REQUEST['serialno']))."' ";
			$comrow = mysql_query('SET NAMES utf8');
			$comrow = mysql_query($comquery);
			$comrs = mysql_fetch_assoc($comrow);
			echo $comrs['_tqty'];
		}else
		{
			$comquery = "SELECT _serialno FROM ".$tbname."_changedparts WHERE _id = '".replaceSpecialChar(rawurldecode($_REQUEST['chid']))."' ";
			$comrow = mysql_query('SET NAMES utf8');
			$comrow = mysql_query($comquery);	
			$comrs = mysql_fetch_assoc($comrow);
			if(trim(rawurldecode($_REQUEST['serialno']))!=$comrs['_serialno'])
			{
				$comquery2 = "SELECT SUM(_qty) AS _tqty FROM ".$tbname."_inventorytransaction WHERE _serialno = '".replaceSpecialChar(rawurldecode($_REQUEST['serialno']))."' ";
				$comrow2 = mysql_query('SET NAMES utf8');
				$comrow2 = mysql_query($comquery2);
				$comrs2 = mysql_fetch_assoc($comrow2);
				echo $comrs2['_tqty'];
			}
		}
	}
	else if($e_action == 'getInvoiceAddress')
	{
		$invoiceAddress = "";
		$comquery = "SELECT _address1,_address2,_address3,_postalcode FROM ".$tbname."_contactperson WHERE _customerid = '".replaceSpecialChar($_REQUEST['customerID'])."' AND _id = '".replaceSpecialChar($_REQUEST['contactID'])."' ORDER BY _ID DESC LIMIT 1 ";
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
		$invoiceAddress = rawurlencode(replaceSpecialCharBack($comrs['_contactaddress']));
		echo $invoiceAddress;
	}
	
	else if($e_action == 'getPricelevel')
	{
		$pricelevel = "";
		$comquery = "SELECT _pricinglevelid,_gstallorder,
		if(isnull(_defaultcurrency),2,_defaultcurrency) as  _defaultcurrency 
		FROM ".$tbname."_customer WHERE _id = '".replaceSpecialChar($_REQUEST['customerID'])."' 
		LIMIT 1 ";
			
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
		header('Content-type: application/json');
		echo json_encode($comrs);
		die;
	}
	else if($e_action == 'getShippingAddress')
	{
		 //$comquery = "SELECT Concat(_address1,_address2,_address3,if(isnull(_postalcode),'',Concat(',Singapore ',_postalcode))) as _contactaddress FROM ".$tbname."_contactperson WHERE _customerid = '".replaceSpecialChar($_REQUEST['customerID'])."' AND _contacttype IN ('1','3') ORDER BY _contacttype DESC LIMIT 1 ";
		 $comquery = "SELECT Concat(_address1,_address2,_address3,if(isnull(_postalcode),'',Concat(',<br />Singapore ',_postalcode))) as _address1,_address2,_address3,_postalcode FROM ".$tbname."_contactperson WHERE _customerid = '".replaceSpecialChar($_REQUEST['customerID'])."' AND _contacttype IN ('1','3') ORDER BY _contacttype DESC LIMIT 1 ";
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
		echo rawurlencode(replaceSpecialCharBack($comrs['_contactaddress']));
		exit();
		/*
		// I tried to separate in sales order page for post code, but it is not good idea, so I gave up.
		$postalCode = rawurlencode(replaceSpecialCharBack($comrs['_postalcode']));
		$rec = array('sa'=>$shippingAddress, 'pc'=>$postalCode);
		header('Content-type: application/json');
		echo json_encode($rec);
		die;*/
		
	}
	
	else if($e_action == 'getCustomerAddress')
	{
		 $comquery = "SELECT Concat(_address,if(isnull(_postalcode),'',Concat(',Singapore ',_postalcode))) as _address FROM ".$tbname."_customer WHERE _id = '".replaceSpecialChar($_REQUEST['customerID'])."' ";
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
		$shippingAddress = rawurlencode(replaceSpecialCharBack($comrs['_address']));
		echo $shippingAddress;
	}
	else if($e_action == 'getInvoiceContact')
	{
		$comquery = "SELECT _id FROM ".$tbname."_contactperson WHERE _customerid = '".replaceSpecialChar($_REQUEST['customerID'])."' AND _contacttype = '2' ORDER BY _ID DESC LIMIT 1 ";
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
		echo replaceSpecialCharBack($comrs['_id']);
		
	}
	else if($e_action == 'getInvoiceContactInfoForSQ')
	{
		$comquery = "SELECT _id,_address1,_address2,_address3,_contactname,_contacttel,_contactfax,_contactemail,_contacttel2,
		concat_ws(' ',(Select _countryname From ".$tbname."_countries Where _id = ct._contactcountry),_postalcode) as _postalcode,_contactfax 
		
		FROM ".$tbname."_contactperson ct WHERE _id = '".replaceSpecialChar($_REQUEST['contactID'])."'
		
		 LIMIT 1 ";
		
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
			
		$contactinfo = array("contactinfo"=>$comrs);
		header('Content-type: application/json');
		echo json_encode($contactinfo);
		die;
		
		
	}
	else if($e_action == 'getProductData')
	{
		$comquery = "SELECT _BrandID,_SubCategoryID,if(isnull(_uom),'',_uom) as _uom,if(isnull(_Description),'',_Description)  as _Description From ".$tbname."_products WHERE _ID = '".replaceSpecialChar($_REQUEST['pid'])."' LIMIT 1 ";
				
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
			
		$contactinfo = array("productinfo"=>$comrs);
		header('Content-type: application/json');
		echo json_encode($contactinfo);
		die;
		
		
	}
	
	else if($e_action == 'getProductDataBrand')
	{
		$comquery = "SELECT _BrandID,if(isnull(_uom),'',_uom) as _uom,if(isnull(_Description),'',_Description)  as _Description 
		
		From ".$tbname."_products WHERE _ID = '".replaceSpecialChar($_REQUEST['pid'])."'
		 LIMIT 1 ";
				
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
			
		$contactinfo = array("productinfo"=>$comrs);
		header('Content-type: application/json');
		echo json_encode($contactinfo);
		die;
		
		
	}
	else if($e_action == 'getInvoiceContactInfo')
	{
		echo $comquery = "SELECT _id,_contactname,_contacttel,_address1,_address2,_address3,_contactemail,_contacttel2,_postalcode FROM ".$tbname."_suppliercontactperson WHERE _customerid = '".replaceSpecialChar($_REQUEST['customerID'])."' AND _contacttype IN ('1','2') ORDER BY _contacttype DESC LIMIT 1 ";
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
		echo rawurlencode(replaceSpecialCharBack($comrs['_id'])."~".replaceSpecialCharBack($comrs['_contactname'])."~".replaceSpecialCharBack($comrs['_contacttel'])."~".replaceSpecialCharBack($comrs['_contactaddress'])."~".replaceSpecialCharBack($comrs['_contactemail'])."~".replaceSpecialCharBack($comrs['_contacttel2'])."~".replaceSpecialCharBack($comrs['_postalcode']));
		
	}
	else if($e_action == 'getSupplierContactInfo')
	{
		 $comquery = "SELECT _id,_contactname,_contacttel,_address1,_address2,_address3,_contactemail,_contacttel2,_postalcode FROM ".$tbname."_suppliercontactperson WHERE _customerid = '".replaceSpecialChar($_REQUEST['customerID'])."' ORDER BY _contacttype DESC LIMIT 1 ";
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
		echo rawurlencode(replaceSpecialCharBack($comrs['_id'])."~".replaceSpecialCharBack($comrs['_contactname'])."~".replaceSpecialCharBack($comrs['_contacttel'])."~".replaceSpecialCharBack($comrs['_contactaddress'])."~".replaceSpecialCharBack($comrs['_contactemail'])."~".replaceSpecialCharBack($comrs['_contacttel2'])."~".replaceSpecialCharBack($comrs['_postalcode']));
		
	}
	else if($e_action == 'getCompanyinfo')
	{
		$comquery = "SELECT _id,_contactname,_contacttel,_contactfax,_contactemail FROM ".$tbname."_customer WHERE _customerid = '".replaceSpecialChar($_REQUEST['customerID'])."' AND _contacttype IN ('1','2') ORDER BY _contacttype DESC LIMIT 1 ";
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
		echo rawurlencode(replaceSpecialCharBack($comrs['_id'])."~".replaceSpecialCharBack($comrs['_contactname'])."~".replaceSpecialCharBack($comrs['_contacttel'])."~".replaceSpecialCharBack($comrs['_contactfax'])."~".replaceSpecialCharBack($comrs['_contactemail']));
		
	}
	else if($e_action == 'getContactInfo')
	{
		$comquery = "SELECT _id,_contactname,_contacttel,_contactfax,_contactemail FROM ".$tbname."_contactperson WHERE _id = '".replaceSpecialChar($_REQUEST['conid'])."' ORDER BY _ID DESC LIMIT 1 ";
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
		echo rawurlencode(replaceSpecialCharBack($comrs['_id'])."~".replaceSpecialCharBack($comrs['_contactname'])."~".replaceSpecialCharBack($comrs['_contacttel'])."~".replaceSpecialCharBack($comrs['_contactfax'])."~".replaceSpecialCharBack($comrs['_contactemail']));
		
	}
	/*else if($e_action == 'getInvoiceAddress')
	{
		$invoiceAddress = "";
		$comquery = "SELECT Concat(_address1,_address2,_address3,if(isnull(_postalcode),'',Concat(',Singapore ',_postalcode))) as _contactaddress FROM ".$tbname."_contactperson WHERE _customerid = '".replaceSpecialChar($_REQUEST['customerID'])."' AND _contacttype = '2' ORDER BY _ID DESC LIMIT 1 ";
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
		$invoiceAddress = rawurlencode(replaceSpecialCharBack($comrs['_contactaddress']));
		echo $invoiceAddress;
	}*/
	else if($e_action == 'getCustomerByContract')
	{
		$custInfo = "";
		$comquery = "SELECT cust._id,cust._companyname FROM ".$tbname."_customer cust INNER JOIN ".$tbname."_maintenancecontract mc ON mc._customerid = cust._id WHERE mc._id = '".replaceSpecialChar($_REQUEST['mcID'])."' ";
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
		$custInfo = rawurlencode(replaceSpecialCharBack($comrs['_id']))."~".rawurlencode(replaceSpecialCharBack($comrs['_companyname']));
		echo $custInfo;
	}
	else if($e_action == 'getProductDescription')
	{
		$custInfo = "";
		$comquery = "SELECT _description FROM ".$tbname."_products  WHERE _id = '".replaceSpecialChar($_REQUEST['pid'])."' ";
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
		echo rawurlencode(replaceSpecialCharBack($comrs['_description']));
	}
	
	else if($e_action == 'getStProductDescription')
	{
		$custInfo = "";
		$comquery = "SELECT _stdescription FROM ".$tbname."_products  WHERE _id = '".replaceSpecialChar($_REQUEST['pid'])."' ";
		$comrow = mysql_query('SET NAMES utf8');
		$comrow = mysql_query($comquery);
		$comrs = mysql_fetch_assoc($comrow);
		echo rawurlencode(replaceSpecialCharBack($comrs['_stdescription']));
	}
	else if($e_action == 'getMscAmt')
	{
		  $sql = "SELECT _mscprice FROM ".$tbname."_msctype WHERE _id = '".$_REQUEST['id']."' ";
		  $res = mysql_query($sql) or die(mysql_error());
		  if(mysql_num_rows($res) > 0){
			  while($rec = mysql_fetch_array($res)){
				   echo $rec['_mscprice']; 
			  }
		  }
	}
	else if($e_action == 'getInvoiceRemarks')
	{
		
		$str = "SELECT * FROM ".$tbname."_tnctext";
		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			$id = $rs['_id'];
			$normal = $rs['_normal'];
			$normal2 = $rs['_normal2'];
		}
		
		if($_REQUEST["com"]== 1)
		{
			echo $normal2;
		}
		else
		{
			echo $normal;
		}
		
		
	}	
	else if($e_action == 'getContactInfoFull')
	{
		$sql = "SELECT cont._id,cont._contactname,cont._contacttel,cont._contactfax,cont._contactemail,Concat(cont._address1,_address2,_address3,if(isnull(cont._postalcode),'',Concat(',Singapore ',cont._postalcode))) as _address1,_address2,_address3,cct._typename,cust._remarks FROM ".$tbname."_contactperson cont LEFT JOIN ".$tbname."_contacttype cct ON cct._id = cont._contacttype INNER JOIN ".$tbname."_customer cust ON cust._id = cont._customerid AND _isdeleted='0' WHERE cont._id = '".replaceSpecialChar($_REQUEST['conid'])."' ORDER BY cont._id DESC LIMIT 1 ";
		$res = mysql_query($sql) or die(mysql_error());
		$rec = mysql_fetch_assoc($res);
		
		header('Content-type: application/json');
		echo json_encode($rec);
		die;
                
	}
	else if($e_action == 'getSerialNoInfo')
	{
		$sql = "SELECT DATE_FORMAT(_dateinstalled,'%d/%m/%Y') as _dateinstalled,_model,_unitlocation FROM ".$tbname."_machinewarranty cont  WHERE cont._customerid = '".replaceSpecialChar($_REQUEST['cusid'])."' and cont._serialno = '".replaceSpecialChar($_REQUEST['sno'])."' ORDER BY cont._id DESC LIMIT 1 ";
		$res = mysql_query($sql) or die(mysql_error());
		$rec = mysql_fetch_assoc($res);
		
		header('Content-type: application/json');
		echo json_encode($rec);
		die;
                
	}
	else if($e_action == 'getModelID')
	{
		$sql = "SELECT _id FROM ".$tbname."_products cont Where cont._productname = '".replaceSpecialChar($_REQUEST['model'])."' ORDER BY cont._id DESC LIMIT 1 ";
				
		$res = mysql_query($sql) or die(mysql_error());
		$rec = mysql_fetch_assoc($res);
		
		header('Content-type: application/json');
		echo json_encode($rec);
		die;
                
	}
	
	
	include('../dbclose.php');
?>