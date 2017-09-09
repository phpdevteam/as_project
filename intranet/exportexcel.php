<?PHP
  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.
  
  include('../global.php');	
include('../include/functions.php');  include('access_rights_function.php'); 
require_once '../include/1.7.6/Classes/PHPExcel.php';  

  // filename for download
  $filename = $_REQUEST["name"] . "_" . date('Ymd') . ".xls";

  $flag = false;
  $name = $_REQUEST["name"];
  
  
  
  $emailString = "";
	
		$cntCheck = $_POST["cntCheck"];
		for ($i=1; $i<=$cntCheck; $i++)
		{
			if ($_POST["CustCheckbox".$i] != "")
			{
				$emailString .=  $_POST["CustCheckbox".$i] . ",";	
			}
		}
		
  if($emailString == "")
  {
  	  $searchIds = implode(",",$_REQUEST["searchID"]);
  }
  else
  {
	  $searchIds =rtrim($emailString, ",");
  }
 
 
   function htmlData(&$str)
  {
        $str = replaceSpecialCharBack($str);   
  }
  
  
   $str = "";
  
  if($name== "applist")
  {
	  $str = "SELECT app._ID,_Title as `Event Title`,date_format(app._Date,'%d/%m/%Y') as `Date`,Concat(_From,' To ',_To) as `Time`,stff._Fullname as `Staff Ref`,usr._Fullname as `Submitted By`
	  ,date_format(app._SubmittedDate,'%d/%m/%Y') as `Submitted Date`,IF(app._status = 1, 'Live', 'Archived') as `System Status` 
	  FROM ".$tbname."_appointments app
							left join ".$tbname."_user stff on app._StaffRef=stff._ID
							left Join ".$tbname."_user AS usr ON app._SubmittedBy = usr._ID
							";
  
      $str .= " Where app._ID In (". $searchIds.")";
  
  }
  else if($name== "customerlist")
  {
	/*  $str = "Select _companyname as `Company Name`,_address1 
 as `Address1`
, _address2
 as `Address2`,
_address3
 as `Address3`,
_countryname
 as `Country`,
_provincename
 as `State/Province`,
_cityname
 as `City`,
cust._postalcode
 as `Postal Code`
, _customerid
 as `Contact Ref No`,
usr._Fullname
 as `Submitted By`,
date_format(cust._submitteddate,'%d/%m/%Y')
 as `Submitted Date`,

IF(cust._status = 1, 'Live', 'Archived') as `Contact Type`,
 
IF(cust._status = 1, 'Live', 'Archived')as `Contacts Status`,
 
IF(cust._status = 1, 'Live', 'Archived') as `System Status `,
 
cust._telephone1 as `Main Tel 1`,
 
cust._telephone2 as `Main Tel 2`,
 
cust._fax as `Fax`,
 
cust._url as `Url`,
 
cust._email as `Email`,
 
 
_PriceLevelName as `Price Level`,
 
cust._gstallorder  as `GST For All order`,
 
cust._remarks as `Remarks (Client)`,
 
cust._internalremarks as `Internal Remarks (CODA)`
FROM ".$tbname."_customer AS cust
                                                  left Join ".$tbname."_user AS usr ON cust._updatedby = usr._ID
													left JOIN ".$tbname."_cities ci on ci._id = cust._cityid
							 						left JOIN ".$tbname."_countries cu on cu._id = cust._countryid 
													left JOIN ".$tbname."_provinces p on p._id = cust._stateprovinceid 
													left JOIN ".$tbname."_pricelevel pr on pr._Id = cust._pricinglevelid 
													 ";
													 
													 $str .= " Where cust._ID In (". $searchIds.")";*/
  
  
  
  $str = "SELECT cust._fullname,_customerid
 as `Contact Ref No`,
 cust._email as `Email`,
cust._nricfin,
 _address1 
 as `Address1`
, _address2
 as `Address2`,
_address3
 as `Address3`,
_countryname
 as `Country`,

_cityname
 as `City`,
cust._postalcode
 as `Postal Code`
, 
usr._Fullname
 as `Submitted By`,
date_format(cust._createddate,'%d/%m/%Y')
 as `Submitted Date`,
 cust._nsmen,
 cust._hp,
 cust._hp2,
 cust._dob,
 cust._height,
 cust._weight,
 cust._medhistory,
 cust._creditava,

IF(cust._status = 1, 'Live', 'Archived') as `Contact Type`,
 
IF(cust._status = 1, 'Live', 'Archived')as `Contacts Status`,
 
IF(cust._status = 1, 'Live', 'Archived') as `System Status `,



cust._remarks as `Remarks (Client)`,
 
cust._internalremarks as `Internal Remarks (CODA)`
FROM ".$tbname."_client AS cust
                                                  left Join ".$tbname."_user AS usr ON cust._updatedby = usr._ID
													left JOIN ".$tbname."_cities ci on ci._id = cust._cityid
							 						left JOIN ".$tbname."_countries cu on cu._id = cust._countryid 
													
												
													 ";
													 
													 $str .= " Where cust._ID In (". $searchIds.")";

  
  
  
  
  
  
  
  }else if($name== "trainerlist")
  {
$str = "SELECT tr._TrainerRefNo
 as `Trainer Ref No`,
 tr._FullName as `TrainerName`,
 tr._FullNameChines as 'ChinesName',
tcat._TrainerCatName as 'TranerCategory',
_Occupation as `Occupatio`,
_Email,
_Address,
 _Nationality as `Nationality`,
_Dob as `Date Of Birth`,
_CountryDob as `CountryBirth`,
_Sex as `Sex`,
_MaritalStatus as `Marital Status`, 
_FinNo as `Fin No`,
date_format(_ExpiryDate,'%d/%m/%Y')
 as `Expiry Date`,
 _Race as Race,
_TypePass as 'Type of Pass',
_Postalcode,
 _HomeNo,
 _Handphone,
_Bankname,
_Accountname,
_Accountnumber,
_EmployerName,
_EmployerAddress,
_EmployerPostalcode,
_EmployerTelno,
_EmployerFaxno,
_Nric,
IF(tr._Status = 1, 'Live', 'Archived') as `System Status `,
_CreatedBy,
_CreatedDateTime,
_UpdatedBy,
_UpdatedDateTime
 
FROM ".$tbname."_trainers AS tr
             left Join ".$tbname."_trainerscat AS tcat ON tr._TrainerCatID = tcat._ID";

 $str .= " Where tr._ID In (". $searchIds.")";

  
  
  }
  
  
  
  
  else if($name== "tranervenulist")
  {
$str = "SELECT o._VenueRefNo
 as `Traning Venue Ref No`,
   o._Ownertitle as `Owner Title`,
  o._FullName as `Owner FullName`,
 v._VenueName as `TraingVenue Name`,
 vc._VenueCatName as 'VenueCategory',
vt._VenueTypeName as 'TraningVenue Type',
v._CorporateBankAc as `CorporateBankAc`,
_SpecialisedProgram,
_MembershipCommenceDate,
 _AmenitiesService as `AmenitiesService`,
_EquipmentAvailable as `EquipmentAvailable`,
_EmailvenuePoc as `EmailvenuePoc`,
v._HP as `HP`,
m._MembershipType as `MembershipType`, 
IF(o._Status = 1, 'Live', 'Archived') as `System Status `,
o._CreatedBy,
o._CreatedDateTime,
o._UpdatedBy,
o._UpdatedDateTime
 
FROM ".$tbname."_venueowners AS o
               left Join ".$tbname."_venues AS v ON o._ID = v._OwnerID and v._DefaultVenue = 1
             left Join ".$tbname."_venuecat AS vc ON v._VenueCat = vc._ID
			 left Join ".$tbname."_venuetype AS vt ON v._VenueType = vt._ID
			  left Join ".$tbname."_membershipstatus AS m ON v._membershipStatus = m._ID";

 $str .= " Where o._ID In (". $searchIds.")";
	$str .= " GROUP BY o._ID ";


  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  else if($name== "sqlist")
  {
	  $str = "SELECT cust._companyname as `Customer / Company Name`,
	  concat_ws(' ',contact._contacttitle,contact._contactname) as `Contact Person`,
	  _quotationno as `SQ No`,
	  date_format(sq._quotationdate,'%d/%m/%Y') as `SQ Date`,
	  sqs._StatusName as `SQ Status`,
	  cust._customerid as `Contact Ref No.`,
	  date_format(sq._subdate,'%d/%m/%Y') as `Submitted Date`,
	   usr._Fullname as `Submitted By`,
	  IF(sq._status = 1, 'Live', 'Archived') as  `System Status`,
	  sq._tel as  `Telephone`,
	  sq._mobile as  `Mobile`,
	  sq._fax as  `Fax`,
	  sq._address1 as `Address`,  
	  sq._postalcode as `Postal Code`, 
	  _currencyshortname as `Currency`,
	  plevel._PriceLevelName as `Price Level`,
	  FORMAT(_GrossTotal,2) as `Sub Total`, 
	  _Misc1Text as `Discount 1`,
	  FORMAT(_Misc1Value,2) as `Amount`, 
	  _Misc2Text as `Discount 2`, 
	  FORMAT(_Misc2Value,2) as `Amount`, 
	  _Misc3Text  as `Discount 3`,
	  FORMAT(_Misc3Value,2) as `Amount`,
	  FORMAT(_Tax,2) as `GST`,
	  FORMAT(_nettotal,2) as `Total Amount`,
	  FORMAT(sq._invoiceamt,2) as `Invoice Total Amount`,
	  FORMAT(sq._rcvamt,2) as `Receipt Paid Amount`,
	  
	  del._companyname as `Delivery Customer / Company Name`,
	  concat_ws(' ',delcontact._contacttitle,delcontact._contactname) as `Delivery Contact Person`,
	  _deliveryaddress1 as `Delivery Address`, 
	  _deliverytel as  `Delivery Telephone`,
	  _deliverymobile as  `Delivery Mobile`,
	  _deliveryemail as  `Delivery Email`,
	  _deliveryremarks as  `Delivery Remarks`, 
	  
	  
	 bil._companyname as `Billing Customer / Company Name`,
	  concat_ws(' ',bilcontact._contacttitle,bilcontact._contactname) as `Billing Contact Person`,
	  _billingaddress1 as `Billing Address`, 
	  _billingtel as  `Billing Telephone`,
	  _billingmobile as  `Billing Mobile`,
	  _billingfax as  `Billing Fax`,
	  _billingemail as  `Billing Email`,
	  _billingremarks as  `Billing Remarks`, 
	  
	  
	  sq._quotationremarks as `Quotation Remarks`,
	  sq._internalremarks as `Internal Remarks (CODA)`,
	   tnctxt._title as `T&C Title`,
	  sq._tncremarks as `Quotation T&C`
	 
	    FROM ".$tbname."_salequotations  sq
		LEFT JOIN ".$tbname."_sqstatus sqs ON sq._sqstatus  = sqs._ID  
		LEFT JOIN ".$tbname."_tnctext tnctxt ON sq._tnctitle  = tnctxt._ID
		LEFT JOIN ".$tbname."_pricelevel plevel ON sq._pricelevelid = plevel._ID 
		LEFT JOIN ".$tbname."_customer cust ON sq._customerid = cust._ID 
		LEFT JOIN ".$tbname."_customer del ON sq._deliverycustomerid = del._ID 		
		LEFT JOIN ".$tbname."_customer bil ON sq._billingcustomerid = bil._ID 
		LEFT JOIN ".$tbname."_contactperson contact ON sq._contactid = contact._ID 
		LEFT JOIN ".$tbname."_contactperson delcontact ON sq._deliverycontactid = delcontact._ID 
		LEFT JOIN ".$tbname."_contactperson bilcontact ON sq._billingcontactid = bilcontact._ID 
		LEFT JOIN ".$tbname."_currencies curr ON sq._currencyid = curr._ID 
		LEFT JOIN ".$tbname."_user usr ON sq._subby = usr._ID";
		
		$str .= " Where sq._ID In (". $searchIds.")";
	  
  }
  else if($name== "polist")
  {
	   $str = "SELECT 
	   cust._companyname as `Supplier Name`,
	   concat_ws(' ',contact._contacttitle,contact._contactname) as `Contact Person`,
	   po._purchaseorderno as `PO No`,
	   date_format(po._purchaseorderdate,'%d/%m/%Y') as `PO Date` ,
	   pos._StatusName as `PO Status`,
	   date_format(po._createddate,'%d/%m/%Y') as `Submitted Date`,
	   usr._Fullname as `Submitted By`,
	   IF(po._status = 1, 'Live', 'Archived') as  `System Status`,
				
		po._address1 as `Address`,
		po._postalcode as `Postal Code`,
		po._tel as `Telephone`,
		po._mobile as `Mobile`,
		po._fax as `Fax`,
	
		FORMAT(po._grosstotal,2) as `Sub Total`, 
		FORMAT(po._tax,2) as `GST`,  
		FORMAT(po._nettotal,2) as `Total Amount`,
		  
		po._remarks as `Remarks (Client)`,
		po._internalremarks as `Internal Remarks (CODA)`,
		tnctxt._title as `T&C Title`,
		po._tnc as `PO T&C`
		
		FROM ".$tbname."_purchaseorders po 
		LEFT JOIN ".$tbname."_tnctext tnctxt ON po._tnctitle = tnctxt._ID 
		LEFT JOIN ".$tbname."_user usr ON po._createdby = usr._ID 
		LEFT JOIN ".$tbname."_customer cust ON po._supplierid  = cust._id
		LEFT Join ".$tbname."_contactperson AS contact ON  po._contactid= contact._id
		LEFT JOIN ".$tbname."_postatus pos ON po._postatus = pos._ID  ";
		
		$str .= " Where po._ID In (". $searchIds.")";
		
		 
}
  else if($name== "dolist")
  {
	  $str = "SELECT 
	  cust._companyname as `Customer Name`,
	   concat_ws(' ',contact._contacttitle,contact._contactname) as `Contact Person`,
	   po._deliveryorderno as `DO No`,
	   date_format(po._deliveryorderdate,'%d/%m/%Y') as `DO Date` ,
	   so._quotationno as `SQ No` ,
	   so._quotationdate as `SQ Date`, 
	   date_format(po._createddate,'%d/%m/%Y') as `Submitted Date`,
	   usr._Fullname as `Submitted By`,
	   IF(po._status = 1, 'Live', 'Archived') as  `System Status`,
				
		po._address1 as `Delivery Address`,
		po._postalcode as `Postal Code`,
		po._email as `Email`,
		po._tel as `Telephone`,
		po._fax as `Fax`,
	
	  
		po._remarks as `Remarks (Client)`,
		po._internalremarks as `Internal Remarks (CODA)`,
		tnctxt._title as `T&C Title`,
		po._tnc as `DO T&C`
	  
	   FROM ".$tbname."_deliveryorders po 
	   LEFT JOIN ".$tbname."_tnctext tnctxt ON po._tnctitle = tnctxt._ID
		LEFT JOIN ".$tbname."_user usr ON po._createdby = usr._ID 
		LEFT JOIN ".$tbname."_customer cust ON  po._customerid  = cust._id
		LEFT Join ".$tbname."_contactperson AS contact ON po._contactid = contact._id
		LEFT JOIN ".$tbname."_salequotations so ON po._sqid = so._id  ";
		
		$str .= " Where po._ID In (". $searchIds.")";
  }
  else if($name== "invlist")
  {
	   $str = "SELECT 
	  cust._companyname as `Customer / Company Name`,
	  concat_ws(' ',contact._contacttitle,contact._contactname) as `Contact Person`,
	  _invoiceno as `Invoice No`,
	  date_format(inv._invoicedate,'%d/%m/%Y') as `Invoice Date`,
	  date_format(inv._createddate,'%d/%m/%Y') as `Submitted Date`,
	   usr._Fullname as `Submitted By`,
	  IF(inv._status = 1, 'Live', 'Archived') as  `System Status`,
	  inv._address1 as `Address1`,  
	  inv._address2 as `Address2`, 
	  inv._address3 as `Address3`, 
	  inv._postalcode as `Postal Code`,
	   inv._email as  `Email`,
	  inv._tel as  `Telephone`,	 
	  inv._fax as  `Fax`,	  
	
	  FORMAT(inv._grosstotal,2) as `Sub Total`, 
	  FORMAT(_GrossTotal,2) as `Sub Total`, 
	  _Misc1Text as `Discount 1`,
	  FORMAT(_Misc1Value,2) as `Amount`, 
	  _Misc2Text as `Discount 2`, 
	  FORMAT(_Misc2Value,2) as `Amount`, 
	  _Misc3Text  as `Discount 3`,
	  FORMAT(_Misc3Value,2) as `Amount`,
	  FORMAT(inv._tax,2) as `GST`,
	  FORMAT(inv._nettotal,2) as `Total Amount`,
 
	  
	  inv._orderremarks as `Remarks (Client)`,
	  inv._internalremarks as `Internal Remarks (CODA)`,
	   tnctxt._title as `T&C Title`,
	  inv._tnc as `Quotation T&C`
	  
	  
	   FROM ".$tbname."_invoices inv 
	   LEFT JOIN ".$tbname."_tnctext tnctxt ON inv._tnctitle = tnctxt._ID  
		LEFT JOIN ".$tbname."_user usr ON  inv._createdby = usr._ID
		LEFT JOIN ".$tbname."_customer cust ON inv._customerid  = cust._id
		LEFT Join ".$tbname."_contactperson AS contact ON inv._contactid = contact._id  ";
		 
		 $str .= " Where inv._ID In (". $searchIds.")";
		 
  }else if($name== "receiptlist")
  {
	 
	   $str = "SELECT 
	  cust._companyname as `Customer / Company Name`,
	  concat_ws(' ',contact._contacttitle,contact._contactname) as `Contact Person`,
	  _orderno as `Invoice No`,
	  date_format(rec._orderdate,'%d/%m/%Y') as `Invoice Date`,
	  date_format(rec._createddate,'%d/%m/%Y') as `Submitted Date`,
	   usr._Fullname as `Submitted By`,
	  IF(rec._status = 1, 'Live', 'Archived') as  `System Status`,
	   rec._address1 as `Address1`,  
	   rec._address2 as `Address2`, 
	   rec._address3 as `Address3`, 
	 rec. _postalcode as `Postal Code`,
	  rec._email as  `Email`,
	 rec._tel as  `Telephone`,	 
	 rec._fax as  `Fax`,	  
	
	  FORMAT(rec._grosstotal,2) as `Sub Total`, 
	 	  rec._Misc1Text as `Discount 1`,
	  FORMAT(rec._Misc1Value,2) as `Amount`, 
	  rec._Misc2Text as `Discount 2`, 
	  FORMAT(rec._Misc2Value,2) as `Amount`, 
	  rec._Misc3Text  as `Discount 3`,
	  FORMAT(rec._Misc3Value,2) as `Amount`,
	  FORMAT(rec._tax,2) as `GST`,
	  FORMAT(rec._nettotal,2) as `Total Amount`,
 
	  
	  rec._orderremarks as `Remarks (Client)`,
	  rec._internalremarks as `Internal Remarks (CODA)`,
	   tnctxt._title as `T&C Title`,
	  rec._tnc as `Quotation T&C`
	  
	  FROM ".$tbname."_receipts rec 
	   LEFT JOIN ".$tbname."_tnctext tnctxt ON rec._tnctitle = tnctxt._ID 
		left join ".$tbname."_invoices inv on rec._invoiceid = inv._id
		LEFT JOIN ".$tbname."_user usr ON rec._createdby = usr._ID
		LEFT JOIN ".$tbname."_customer cust ON rec._customerid  = cust._id 
		LEFT Join ".$tbname."_contactperson AS contact ON rec._contactid = contact._id  ";
		
		$str .= " Where rec._ID In (". $searchIds.")";
		
  }else if($name== "productlist")
  {
	  $str = "SELECT 
	  pr._ProductCode as `Product No.`,
	  b._BrandName as `Brand`, 
	  pr._Model as `Model`,
	  cat._CategoryName as `Category`,
	  subcat._SubCategoryName as `Sub Category`,
	  pr._ProductName as `Product Name`,
	  pr._WarrtyPeriod  as `Default Warranty Period`,
	  date_format(pr._subdate,'%d/%m/%Y') as `Submitted Date`,
	  usr._Fullname as `Submitted By`,
	  IF(pr._status = 1, 'Live', 'Archived') as  `System Status`,
	  pr._Description as `Description`,
	  pr._Remarks  as `Remarks`
	  
	  FROM ".$tbname."_products pr
		left join ".$tbname."_brand b on pr._BrandID=b._ID
		left join ".$tbname."_categories cat on pr._CategoryID= cat._ID
		left join ".$tbname."_subcategories subcat on pr._SubCategoryID = subcat._ID
		left Join ".$tbname."_user AS usr ON pr._subby = usr._ID
		WHERE pr._type='1'";
		
		$str .= " and pr._ID In (". $searchIds.")";
		
  }else if($name== "servicelist")
  {
	  $str = "SELECT 
	  pr._ProductCode as `Service No.`,	
	  pr._ProductName as `Service Name`,
	  pr._WarrtyPeriod  as `Default Warranty Period`,
	  date_format(pr._subdate,'%d/%m/%Y') as `Submitted Date`,
	  usr._Fullname as `Submitted By`,
	  IF(pr._status = 1, 'Live', 'Archived') as  `System Status`,
	  pr._Description as `Description`,
	  pr._Remarks  as `Remarks`
	  
	  
	   FROM ".$tbname."_products pr
		left join ".$tbname."_brand b on pr._BrandID=b._ID
		left join ".$tbname."_categories cat on pr._CategoryID= cat._ID
		left join ".$tbname."_subcategories subcat on pr._SubCategoryID = subcat._ID
		left Join ".$tbname."_user AS usr ON pr._subby = usr._ID
		WHERE pr._type='2'";
		
		$str .= " and pr._ID In (". $searchIds.")";
  }
  
  else if($name== "srlist")
  {
	   $str = "SELECT 
	     cust._companyname as `Customer Name`,
		 po._contactname as `Contact Person`,
		 po._srno as `SR No`,
		 date_format(po._srdate,'%d/%m/%Y') as `SR Date` , 
		 pos._StatusName as `SR Status`,
		 
		 FORMAT(po._sramount,0) as `Amount`,
		 po._warrantyperiod as `Warranty Period`,
	     date_format(po._warrantyenddate,'%d/%m/%Y') as `Warranty Exp Date` , 
		 
		 wstatus._StatusName as `Warranty Status`,
		 po._address1 as `Address`,
		 po._postalcode as `Postalcode`,
		 po._tel as `Telephone`,		 
		 po._mobile as `Mobile`, 
		 po._fax as `Fax`, 
		 
		  qt._Fullname AS `Submitted By`,
		 date_format(po._createddate,'%d/%m/%Y') as `Submitted Date` , 
		 
		 po._remarks as `Remarks (Client)`,		 
		 po._internalremarks as `Remarks (CODA)`
		 
		FROM ".$tbname."_servicereports po 
		LEFT JOIN ".$tbname."_user qt ON po._createdby = qt._ID 
		LEFT JOIN ".$tbname."_customer cust ON po._customerid  = cust._id
		LEFT Join ".$tbname."_contactperson AS ctperson ON po._contactid = ctperson._id
		LEFT JOIN ".$tbname."_srstatus pos ON po._srstatus  = pos._ID 
		LEFT JOIN ".$tbname."_warrantystatus wstatus ON po._wstatus = pos._ID   ";
		
		$str .= " Where po._ID In (". $searchIds.")";
  }
  
  
  $result = mysql_query($str) or die('Query failed!');
  

  
  $objPHPExcel = new PHPExcel();
  $objPHPExcel->setActiveSheetIndex(0);
  
  $row = 1; // 1-based index
while($row_data = mysql_fetch_assoc($result)) {
    
	
	//column for first row
	$col = 0;
	if($row==1)
	{
		 foreach(array_keys($row_data) as $key=>$value) {
			 
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);	
		    $col++;
		 }
		 $row++;
	}
	
	
	//for other rows
	$col = 0;
    foreach($row_data as $key=>$value) {
		
	//	echo $value . "<br/>";
		
		if($value != "")
		{
			//array_walk($value, 'htmlData');
			replaceSpecialCharBack($value);
		}
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);		
        $col++;
    }
    $row++;
}


header('Content-Type: application/vnd.ms-excel;',true);
header('Content-Type: text/html;charset:GB2312');
header('Content-Disposition: attachment;filename="'.$name.'_'.date('Ymd').'.xls"',true);
header("Pragma: no-cache",true); 
header("Expires: 0",true); 
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

?>