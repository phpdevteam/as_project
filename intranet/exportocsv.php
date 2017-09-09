<?
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
		exit();
	}
	include('../global.php');	
	include('../include/functions.php');  
	include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");
	
	$reportname = $_REQUEST['name'];
	
	$query = $_SESSION[$reportname];	
	
	//echo $query;
	//exit();
	
	
	$csv = NULL;
	
		
	if ($reportname == "customerlist")
	{
		$csv .= "No.,Customer No,Company Name,Contact Name,Subby,Telephone,Mobile,Fax,Email,City,Country,State,Address1,Address2,Address3,GST,Postalcode,_PriceLevelName,Remarks,InternalRemarks,SubDate,Status\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{				
				$csv .= $i.',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_customerid'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_companyname'])) .',';								
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_contactname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_Fullname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_telephone1'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_telephone2'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_fax'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_email'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_cityname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_countryname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_provincename'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_address1'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_address2'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_address3'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_gstallorder'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_postalcode'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_PriceLevelName'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_remarks'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_internalremarks'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_subdate'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_status'])) .',';
				
				$csv .= "\n";
				$i++;
			}
					
		}
	}
	else if ($reportname == "supplierlist")
	{
		$csv .= "No.,Supplier No,Supplier Name,Default Currency,Address,Postalcode,Telephone,Mobile,Fax,Url,Email,City,Country,State,Remarks,Subby,SubyDate,Status\n";

		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_supplierno'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_companyname'])) .',';		
    			$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_currencyshortname'])) .',';								
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_address1'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_postalcode'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_telephone'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_moblie'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_fax'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_url'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_email'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_cityname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_countryname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_provincename'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_remarks'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_updatedperson'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_submitteddate'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['Status'])).',';
				
				$csv .= "\n";
				$i++;
			}
		}
	}
	else if ($reportname == "servicelist")
	{
		$csv .= "No.,Service No,Service Name,Remarks,Description,Warrenty Period,Subby,SubyDate,Status\n";

		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_ProductCode'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_ProductName'])) .',';		
    			$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_remarks'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_Description'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_WarrtyPeriod'])) .',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_Fullname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_subdate'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_status'])).',';
				
				$csv .= "\n";
				$i++;
			}
		}
	}
	else if ($reportname == "proudctlist")
	{
		$csv .= "No.,Product No,Product Name,Model,Brand,Remarks,Description,Warrenty Period,Subby,SubyDate,Status\n";

		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_ProductCode'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_ProductName'])) .',';	
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_Model'])) .',';	
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_BrandName '])) .',';		
    			$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_remarks'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_Description'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_WarrtyPeriod'])) .',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_Fullname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_subdate'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_status'])).',';
				
				$csv .= "\n";
				$i++;
			}
		}
	}
	else if ($reportname == "servicinglist")
	{
		$csv .= "No.,Customer ID,Customer / Company Name,Contact Person,Machine Serial No ,Unit Model,Unit Location,Warranty No,Warranty Start Date,Warranty End Date\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_customerid'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_companyname'])) .',';								
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_contactname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_serialno'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_unitmodel'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_unitlocation'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_warrantyno'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_warrantystart'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_warrantyend'])) .',';
				
				$csv .= "\n";
				$i++;
			}
		}
	}
	
	else if ($reportname == "sqlist")
	{
		$csv .= "No.,Quotation Date,Quotation No,Company Name,Company ID,Concat Person Name,Address,Postal Code,Mobile,Fax,Quotation Remarks,Internal Remarks,Total Amount,Description,Qty,UOM,Unit Price,Total\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$sql = " select b._ID,b._ItemType,
							_ItemPrice,_CurrencyId,_ProductID,
							case b._ItemType
							when 2 then _Title
							when 3 then concat_ws('\n',p._Model,br._BrandName,b._Description,_ItemRemarks) 
							else concat_ws('\n',p._ProductName,b._Description,_ItemRemarks) 
							end as _Description,							
							b._UnitPrice,_Order,b._Qty,b._UOM, b._UnitPrice from ".$tbname."_salequotationitems b
							left join ".$tbname."_brand br
							on (b._BrandId = br._ID)
							left join ".$tbname."_products p
							on (b._ProductID = p._ID)
							
							Where b._QutotationId= '".replaceSpecialChar($rs["_ID"])."' Order By _Order ";
							
					
		$sirst = mysql_query($sql);
		$myrowcount = mysql_num_rows($sirst);
		
		if($myrowcount > 0)
		{
			while($sirow = mysql_fetch_assoc($sirst))
			{
					$csv .= $i.',';				
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_quotationdate'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_quotationno'])) .',';								
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_companyname'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_customerno'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_contactname'])) .',';
						$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_address'])) .',';
							$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_postalcode'])) .',';
								$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_mobile'])) .',';
									$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_fax'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_quotationremarks'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_internalremarks'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_currencyshortname'] . ' ' . $rs['_nettotal'])) .',';
					
					$csv .= escapeExcelValue(replaceSpecialCharBack($sirow['_Description'])) .',';				
					$csv .= escapeExcelValue(replaceSpecialCharBack($sirow['_Qty'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($sirow['_UOM'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($sirow['_UnitPrice'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($sirow['_ItemPrice'])) .',';
											
					$csv .= "\n";
					$i++;
					
			}
				
		}
		else
		{
			$csv .= $i.',';				
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_quotationdate'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_quotationno'])) .',';								
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_companyname'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_customerno'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_contactname'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_address'])) .',';
							$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_postalcode'])) .',';
								$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_mobile'])) .',';
									$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_fax'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_quotationremarks'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_internalremarks'])) .',';
					$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_currencyshortname'] . ' ' .$rs['_nettotal'])) .',';
					
					$csv .= "\n";
					$i++;
					
		}
		
		
		
			}
		}
	}
	else if ($reportname == "solist")
	{
		$csv .= "No.,Order Date,Customer Name,Concat Person Name,Total Amount,Shipping Address,Order By,Order Status\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_orderdate'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_companyname'])) .',';								
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_contactname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_nettotal'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_shippingaddress'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_quotedperson'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_status'])) .',';
			
				$csv .= "\n";
				$i++;
			}
		}
	}
	
	else if ($reportname == "dolist")
	{
		$csv .= "No.,Customer,Customer ID,Delivery Order No,Total Amount,Remarks,Submitted By\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_companyname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_customerid'])) .',';								
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_orderno'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_nettotal'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_remarks'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_quotedperson'])) .',';
				
				$csv .= "\n";
				$i++;
			}
		}
	}
	else if ($reportname == "applist")
	{
		$csv .= "No.,Date/Time,Event Title,Staff Ref,Submitted By,Submitted Date\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_AppDate'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_Title'])) .',';								
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_StaffRef'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_Fullname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_SubmittedDate'])) .',';
				
				
				$csv .= "\n";
				$i++;
			}
		}
	}
	else if ($reportname == "invoicelist")
	{
		$csv .= "No.,PO No.,Invoice No,Customer ID,Customer Name,Contact Person Name,Total Amount,Date Of Invoice,Discount Amount,Submitted By\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_poid'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_invoiceno'])) .',';								
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_customerid'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_companyname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_contactname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_nettotal'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_invoicedate'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_discount'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_quotedperson'])) .',';
				
				$csv .= "\n";
				$i++;
			}
		}
	}
	else if ($reportname == "receiptlist")
	{
		$csv .= "No.,Customer,Invoice No,Total Amount,Remarks,Submitted By\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_companyname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_invoiceno'])) .',';								
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_nettotal'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_orderremarks'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_quotedperson'])) .',';
				
				$csv .= "\n";
				$i++;
			}
		}
	}
	else if ($reportname == "mcontractlist")
	{
		$csv .= "No.,Maintenance Contract Number,Maintenance Quotation Number,Company Name,Start Date,End Date,Submitted By,Status\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_mcno'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_mqno'])) .',';								
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_companyname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_contractstartdate'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_contractenddate'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_submittedby'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_status'])) .',';
				
				
				$csv .= "\n";
				$i++;
			}
		}
	}
	else if ($reportname == "mqlist")
	{
		$csv .= "No.,Order No,Order Date,Total Amount,Shipping Address,Order By,Delivery Date,Order Status\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_orderno'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_orderdate'])) .',';								
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_nettotal'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_shippingaddress'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_quotedperson'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_unitlocation'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_deliverydate'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_status'])) .',';
					
				$csv .= "\n";
				$i++;
			}
		}
	}
		else if ($reportname == "jobsheetlist")
	{
		$csv .= "No.,Job No,Date Of Job Issue,Company Name,Complaint,Submitted By\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_jobno'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_dateofjobissue'])) .',';								
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_companyname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_complaintperson'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_createdperson'])) .',';

				
				$csv .= "\n";
				$i++;
			}
		}
	}
	
		else if ($reportname == "mwlist")
	{
		$csv .= "No.,Job No,Company Name,Serial No.,Model,Created By,Updated Date\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_jobno'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_companyname'])) .',';								
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_serialno'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_model'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_createdperson'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_updateddate'])) .',';
								
				$csv .= "\n";
				$i++;
			}
		}
	}
	
		else if ($reportname == "polist")
	{
		$csv .= "No.,Customer Name,Contact Name,Purchase Order No,Purchase Date,PO Status,SQ No,SQ Date,Address1,Address2,Address3,Email,Telephone,Gross Total Amount,Tax,Net Total Amount,Remark,Terms and Conditions\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';				
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_companyname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_contactname'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_purchaseorderno'])) .',';	
    			$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_purchaseorderdate'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['postatus'])) .',';		
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_sqno'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['sqDate'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_address1'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_address2'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_address3'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_email'])) .',';	
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_tel'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_grosstotal'])) .',';	
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_tax'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_nettotal'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_remarks'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_tnc'])) .',';
				
				$csv .= "\n";
				$i++;
			}
		}
	}
	
	
	else if ($reportname == "maintenancemonthly")
	{
		$csv .= "No.,Date,Date Paid,Customer,Invoice No,Amount,Description\n";
		$totalMaintenance = 0;
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';
				$csv .= date('d/m/Y', strtotime($rs['_createddate'])).',';
				$csv .= ($rs['_datepaid']!=""?date('d/m/Y', strtotime($rs['_datepaid'])):"").',';	
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_customername'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_invoiceno'])) .',';
				$csv .= $rs['_nettotal'].',';							
				$csv .= str_replace(',','',replaceSpecialChar($rs['_remarks'])).',';			
  				$csv .= "\n";
				$totalMaintenance = $totalMaintenance + (float)$rs['_nettotal'];
				$i++;
			}
			$csv .= "\n";
			$csv .= ",,,,,".$totalMaintenance."\n";
		}
	}else if ($reportname == "outstandinginvoicemonthly")
	{
		$result = mysql_query($query);
		
		$csv .= "No.,Date,Sales Order,Date Paid,Customer,Invoice No,Amount S$,7% GST Amount S$,Total Amount S$,Description\n";
	
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';
				$csv .= ($rs['_sodate']!=""?date('d/m/Y', strtotime($rs['_sodate'])):"").',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_salesperson'])) .',';
				$csv .= ($rs['_datepaid']!=""?date('d/m/Y', strtotime($rs['_datepaid'])):"").',';					
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_customername'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_invoiceno'])) .',';
				$csv .= $rs['_grosstotal'].',';
				$csv .= $rs['_tax'].',';
				$csv .= $rs['_nettotal'].',';									
				$csv .= str_replace(',','',replaceSpecialChar($rs['_orderremarks'])).',';			
  				$csv .= "\n";
				$i++;
			}
		}
	}else if ($reportname == "serviceplan")
	{
		$csv .= "No.,Date,Date Paid,Customer,Invoice No,Amount,Description,Bank\n";
		$totalMaintenance = 0;
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';
				$csv .= date('d/m/Y', strtotime($rs['_createddate'])).',';
				$csv .= ($rs['_datepaid']!=""?date('d/m/Y', strtotime($rs['_datepaid'])):"").',';	
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_customername'])) .',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_invoiceno'])) .',';
				$csv .= $rs['_nettotal'].',';							
				$csv .= str_replace(',','',replaceSpecialChar($rs['_remarks'])).',';
				$csv .= escapeExcelValue(replaceSpecialCharBack($rs['_typename'])) .',';			
  				$csv .= "\n";
				$totalMaintenance = $totalMaintenance + (float)$rs['_nettotal'];
				$i++;
			}
			$csv .= "\n";
			$csv .= ",,,,,".$totalMaintenance."\n";
		}
	}
		
	
	include('../dbclose.php');
   
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=" . date("Y-m-d") . "_" . $reportname . ".csv;");
	header("Pragma: no-cache"); 
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0");  
	print "$csv";
	exit;

?>