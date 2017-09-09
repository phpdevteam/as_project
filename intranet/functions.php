<?
   function escapeExcelValue($specialString)
	{
		$remove_character = array("\n", "\r\n", "\r");
		$special_str = "";
		if($specialString != "")
		{
			$special_str = "\"". str_replace("\"","'",str_replace($remove_character , ' ',$specialString)) ."\"";
		}
		
		return ($special_str);
	}
	
	function mysqlToDatepicker($mysqlDateTime)
	{
		$datepicker = "";
		if(trim($mysqlDateTime)!="")
		{
			 $datepicker = date("d/m/Y", strtotime($mysqlDateTime));
		}	
		return $datepicker;
	}


	function alrex_csv_file_upload()
	{
		$strFileExtestion= substr($_FILES["file1_1"]["name"], strripos($_FILES["file1_1"]["name"], '.'));
		if(isset($_FILES["file1_1"]["name"]) && $_FILES["file1_1"]["name"] != "")
		{
			if ((strtolower($strFileExtestion) == ".csv"))
			{
				if ($_FILES["file1_1"]["error"] > 0)
				{
					echo "Return Code: " . $_FILES["file1_1"]["error"] . "<br />";
				}
				else
				{				
					if (file_exists("upload/" . $_FILES["file1_1"]["name"]))
					{
						//unlink("upload/" . $_FILES["file1_1"]["name"]);
						$InititalName = strstr($_FILES["file1_1"]["name"], '.', true);
						$extens = strstr($_FILES["file1_1"]["name"], '.');
						$stockDateChunk = $InititalName . date('YmdHis').$extens;
						move_uploaded_file($_FILES["file1_1"]["tmp_name"], "upload/" . $stockDateChunk);
						return $stockDateChunk;			
					}
					else
					{
						//move_uploaded_file($_FILES["file1_1"]["tmp_name"], "upload/" . $_FILES["file1_1"]["name"]);
						/* Start Bellow code Added by ketan on 19-10-2011 because new file does not imported in first time. */
						$InititalName = strstr($_FILES["file1_1"]["name"], '.', true);
						$extens = strstr($_FILES["file1_1"]["name"], '.');
						$stockDateChunk = $InititalName . date('YmdHis').$extens;
											
						move_uploaded_file($_FILES["file1_1"]["tmp_name"], "upload/" . $stockDateChunk);
						
						/*End*/
						return $stockDateChunk;	
						
					
					}
				}
			}
			else
			{
				return false;
			}
		}
	}
	function GetPageURL() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") 
		{$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	//
	function generateCode($characters) {
		$possible = '23456789bcdfghjkmnpqrstvwxyz'; 
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
	}	
		
	//
	function generaterand ($gSize=24)
	{
		mt_srand ((double) microtime() * 1000000);
		for ($i=1; $i<=$gSize; $i++)
		{
			$gRandom = mt_rand(1,30);
			if ($gRandom <= 10)
			{
				$capsString .= chr(mt_rand(65,90));
			}
			elseif ($gRandom <= 20)
			{
				$capsString .= mt_rand(0,9);
			}
			else 
			{
				$capsString .= chr(mt_rand(97,122));
			}
		}		
		return $capsString;
	}
	//
	function getLastDayOfMonth($month, $year)
	{
		return idate('d', mktime(0, 0, 0, ($month + 1), 0, $year));
	}
	
	function getMonth($day, $month, $year, $str)
	{
		$date = mktime(0, 0, 0, ($month+$str), $day,   $year);
		return $date;
	}
	//
	function replaceSpecialChar($specialString)
	{
		if($specialString != "")
		{
			$special_str = $specialString;
			$special_str = trim($special_str);
			$special_str = str_replace('"', '&quot;', $special_str);
			$special_str = str_replace("'", '&#39;', $special_str);
			
			$special_str = str_replace("\'", '&#39;', $special_str);
			$special_str = str_replace('\"', '&quot;', $special_str);
			//$special_str = str_replace("\\", '&#92;', $special_str);
			//$special_str = mysql_real_escape_string($special_str);
			$special_str = htmlentities($special_str, ENT_QUOTES,"UTF-8");
			
			
			$special_str = mysql_real_escape_string($special_str);
			
			
			
			
		}
		else
		{
			$special_str = "";
		}
		return ($special_str);
	}
	//
	function replaceSpecialCharBack($specialString)
	{
		if($specialString != "")
		{
			$special_str = $specialString;
			
			$special_str = trim($special_str);
			$special_str = str_replace('&#92;&quot;', '"', $special_str);
			$special_str = str_replace('&quot;', '"', $special_str);
			$special_str = str_replace('&#39;', "'", $special_str);
			//$special_str = str_replace('&#92;', "\\", $special_str);
			$special_str = html_entity_decode($special_str,ENT_QUOTES,"UTF-8");
			
			/*
			
			*/
		}
		else
		{
			$special_str = "";
		}
		return ($special_str);
	}
	//
	function FormatDBColumnName($str)
	{
		if($str == "" || is_null($str))
		{
			$temp = "";
		}
		else
		{
			$str = str_replace('_', '', $str);
			$str = str_replace('OldNew', 'Status', $str);
			$temp = array();
			for ($i=0; $i<strlen($str); $i++)
			{
				if(ctype_lower($str[$i-1]) && ctype_upper($str[$i]))
					$temp[$i] = ' '.$str[$i];
				else
					$temp[$i] = $str[$i];
			}
			$temp = implode('', $temp);
			$temp = str_replace(' ', '&nbsp;', $temp);
		}
		return $temp;
	}
	//
	function FormatDigitString($strText, $strLength)
	{
		if(trim($strText) != "")
		{
			$strText = trim($strText);
			$zeroStr = "";
			for($i=1;$i<=(int)$strLength-strlen($strText);$i++)
			{
				$zeroStr = $zeroStr . "0";
			}
			$special_str = $zeroStr . $strText;
		}
		else
		{
			$special_str = "";
		}
		return ($special_str);
	}
	//
	function ExtractInitialLetters($strText, $caseOption)
	{
		if(trim($strText) != "")
		{
			$ConCatStr = "";
			$elements = explode(" ", $strText);
			for ($i = 0; $i < count($elements); $i++)
			{
				if(trim($elements[$i]) != "")
				{
					$ConCatStr = $ConCatStr . substr(trim($elements[$i]), 0, 1);
				}
			}
			if($caseOption == 1)
				$special_str = strtoupper($ConCatStr);
			elseif($caseOption == 2)
				$special_str = strtolower($ConCatStr);
			elseif($caseOption == 3)
				$special_str = $ConCatStr;
		}
		else
		{
			$special_str = "";
		}
		return ($special_str);
	}
	//
	function FormatTimeSpent($difference)
	{
		$num_times = 7;
		$times = array(31536000 => 'year', 2592000 => 'month',  86400 => 'day', 3600 => 'hour', 60 => 'minute', 1 => 'second'); 
		
		$secs = $difference;
		if ($secs == 0) { $secs = 1; } 
	
		$count = 0; 
		$time = ''; 
	
		foreach ($times AS $key => $value) 
		{ 
			if ($secs >= $key) 
			{ 
				$s = ''; 
				$time .= floor($secs / $key); 
	
				if ((floor($secs / $key) != 1)) 
					$s = 's'; 
	
				$time .= ' ' . $value . $s; 
				$count++; 
				$secs = $secs % $key; 
				
				if ($count > $num_times - 1 || $secs == 0) 
					break; 
				else 
					$time .= ', '; 
			} 
		} 
	
		return $time;
	}
	//
	function DateAdd($interval, $number, $date)
	{
		$date_time_array = getdate($date);
		$hours = $date_time_array["hours"];
		$minutes = $date_time_array["minutes"];
		$seconds = $date_time_array["seconds"];
		$month = $date_time_array["mon"];
		$day = $date_time_array["mday"];
		$year = $date_time_array["year"];
		
		switch ($interval) 
		{
			case "yyyy":
				$year+=$number;
				break;
			case "q":
				$year+=($number*3);
				break;
			case "m":
				$month+=$number;
				break;
			case "y":
			case "d":
				$day+=$number;
				break;
			case "w":
				$day+=$number;
				break;
			case "ww":
				$day+=($number*7);
				break;
			case "h":
				$hours+=$number;
				break;
			case "n":
				$minutes+=$number;
				break;
			case "s":
				$seconds+=$number; 
				break;            
		}
	   	$timestamp= mktime($hours,$minutes,$seconds,$month,$day,$year);
		return $timestamp;
	}
	//
	function encode($strcode)
	{
		if (!$strcode && $strcode != "0")
		{
			return false;
			exit;
		}

		$kr = keyresult("30djsk");
		$strenc = "";
		
    	for ($i=0; $i<strlen($strcode); $i++) 
		{
			$n = ord(substr($strcode, $i, 1));
			$n = $n + $kr[1];
			$n = $n + $kr[2];
			(double)microtime()*1000000;
			$nstr = chr(rand(65, 90));
			$strenc .= "$nstr$n";
		}

		return $strenc;
	}
	//
	function decode($strcode)
	{
		if (!$strcode && $strcode != "0")
		{
			return false;
			exit;
		}

		$kr = keyresult("30djsk");
		$strenc = "";
		$strtemp = "";

		for ($i=0; $i<strlen($strcode); $i++) 
		{
			if ( ord(substr($strcode, $i, 1)) > 64 && ord(substr($strcode, $i, 1)) < 91 ) 
			{
				if ($strtemp != "") 
				{
					$strtemp = $strtemp - $kr[2];
					$strtemp = $strtemp - $kr[1];
					$strenc .= chr($strtemp);
					$strtemp = "";
				}
			} 
			else 
			{
				$strtemp .= substr($strcode, $i, 1);
			}
		}

		$strtemp = $strtemp - $kr[2];
		$strtemp = $strtemp - $kr[1];
		$strenc .= chr($strtemp);

		return $strenc;
	}
	//
	function keyresult($key)
	{
		$keyresult = "";
		$keyresult[1] = "0";
		$keyresult[2] = "0";
		for ($i=1; $i<strlen($key); $i++) 
		{
			$strchar = ord(substr($key, $i, 1));
			$keyresult[1] = $keyresult[1] + $strchar;
			$keyresult[2] = strlen($key);
		}
		return $keyresult;
	}
	//
	function encrypt($string, $key) 
	{ 
		$result = ''; 
		for($i=0; $i<strlen($string); $i++) { 
		$char = substr($string, $i, 1); 
		$keychar = substr($key, ($i % strlen($key))-1, 1); 
		$char = chr(ord($char)+ord($keychar)); 
		$result.=$char; 
		} 

		return rawurlencode(base64_encode($result)); 
	} 
	//
	function decrypt($string, $key) 
	{ 
		$result = ''; 
		if($string != "")
		{
			$string = base64_decode($string); 
			for($i=0; $i<strlen($string); $i++) { 
			$char = substr($string, $i, 1); 
			$keychar = substr($key, ($i % strlen($key))-1, 1); 
			$char = chr(ord($char)-ord($keychar)); 
			$result.=$char; 
			} 
		}
		return $result; 
	}
	//
	function truncateString($str, $maxChars=40, $holder="...") {
	// check string length
	// truncate if necessary
		if (strlen($str) > $maxChars) {
		return trim(substr($str, 0, $maxChars)) . $holder;
		} else {
		return $str;
		}
	}	
	//
	function generateNumStr($length)
	{
		$random_str = "";
		for ($i = 0; $i < $length; $i++)
		{ 
			srand( (double)microtime() * 1000000 );
			$random_chr = floor(rand(48, 57));
			$random_str .= chr($random_chr);
		} 
		$random_str = htmlentities($random_str);
		return ($random_str);
	}
	//
	function getWeekdayName($i)
	{
		if($i==1)
		{
			$Name = "Mon";
		}
		else if($i==2)
		{
			$Name = "Tue";	
		}
		else if($i==3)
		{
			$Name = "Wed";	
		}
		else if($i==4)
		{
			$Name = "Thu";	
		}
		else if($i==5)
		{
			$Name = "Fri";	
		}
		else if($i==6)
		{
			$Name = "Sat";	
		}
		else if($i==7)
		{
			$Name = "Sun";	
		}				
		return ($Name);
	}
	//
	function createDateRangeArray($strDateFrom,$strDateTo) {
	  // takes two dates formatted as DD-MM-YYYY/YYYY-MM-DD and creates an
	  // inclusive array of the dates between the from and to dates.
	
	  // could test validity of dates here but I'm already doing
	  // that in the main script
	
	  $aryRange=array();			
	  
	  $iDateFrom=mktime(1,0,0,substr($strDateFrom,3,2),substr($strDateFrom,0,2),substr($strDateFrom,6,4));
	  $iDateTo=mktime(1,0,0,substr($strDateTo,3,2),substr($strDateTo,0,2),substr($strDateTo,6,4));
	
	  if ($iDateTo>=$iDateFrom) {
		array_push($aryRange,date('d-m-Y',$iDateFrom)); // first entry
	
		while ($iDateFrom<$iDateTo) {
		  $iDateFrom+=86400; // add 24 hours
		  array_push($aryRange,date('d-m-Y',$iDateFrom));
		}
	  }
	  return $aryRange;
	}	
	//	   
	function js2PhpTime($jsdate){
  if(preg_match('@(\d+)/(\d+)/(\d+)\s+(\d+):(\d+)@', $jsdate, $matches)==1){
    $ret = mktime($matches[4], $matches[5], 0, $matches[1], $matches[2], $matches[3]);
    //echo $matches[4] ."-". $matches[5] ."-". 0  ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
  }else if(preg_match('@(\d+)/(\d+)/(\d+)@', $jsdate, $matches)==1){
    $ret = mktime(0, 0, 0, $matches[1], $matches[2], $matches[3]);
    //echo 0 ."-". 0 ."-". 0 ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
  }
  return $ret;
}

function php2JsTime($phpDate){
    return date("m/d/Y H:i", $phpDate);
}

function php2MySqlTime($phpDate){
    return date("Y-m-d H:i:s", $phpDate);
}

function mySql2PhpTime($sqlDate){
    $arr = date_parse($sqlDate);
    return mktime($arr["hour"],$arr["minute"],$arr["second"],$arr["month"],$arr["day"],$arr["year"]);
}

function generateMemberID()
{
	global $tbname;
	 $mstr1 = "SELECT _memberid as MCount FROM ".$tbname."_customer cus WHERE _customertype = 3 ORDER BY _createddate DESC LIMIT 1 ";	
	$mrst = mysql_query($mstr1);
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
		$mcount = $mrow['MCount'];
		$mlength = strlen($mcount);
		$mcount = substr($mcount,($mlength-5));
	}
	if($mcount<=0)
	{
		$mcount = 1;
	}else
	{
		$mcount++;	
	}
	$mcount = str_pad($mcount, 5, "0", STR_PAD_LEFT);
	return "TM".date('Y').generateCode(3).$mcount;
}

function generateProductCode()
{
	global $tbname;
	 $mstr1 = "SELECT max(REPLACE(_ProductCode,'P - ','')) as PCount FROM ".$tbname."_products WHERE _type = 1 ORDER BY _subdate DESC LIMIT 1 ";	
	$mrst = mysql_query($mstr1);
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
		$mcount = $mrow['PCount'];
		$mlength = strlen($mcount);
		$mcount = substr($mcount,($mlength-5));
	}
	if($mcount<=0)
	{
		$mcount = 1;
	}else
	{
		$mcount++;	
	}
	$mcount = str_pad($mcount, 8, "0", STR_PAD_LEFT);
	return "P-".$mcount;
}
function generateServiceCode()
{
	global $tbname;
	$mstr1 = "SELECT max(REPLACE(_ProductCode,'S-','')) as PCount FROM ".$tbname."_products WHERE _type = 2 ORDER BY _subdate DESC LIMIT 1 ";	
	$mrst = mysql_query($mstr1);
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
		$mcount = $mrow['PCount'];
		$mlength = strlen($mcount);
		$mcount = substr($mcount,($mlength-5));
	}
	if($mcount<=0)
	{
		$mcount = 1;
	}else
	{
		$mcount++;	
	}
	$mcount = str_pad($mcount, 8, "0", STR_PAD_LEFT);
	return "S-".$mcount;
}

function generateCustomerNo()
{
	global $tbname;
	$mstr1 = "SELECT max(_customerid) as MCount FROM ".$tbname."_customer ORDER BY _submitteddate DESC LIMIT 1";	
	$mrst = mysql_query($mstr1);
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
		$mcount = $mrow['MCount'];
		$mlength = strlen($mcount);
		$mcount = substr($mcount,($mlength-5));
	}
	if($mcount<=0)
	{
		$mcount = 1;
	}else
	{
		$mcount++;	
	}
	$mcount = str_pad($mcount, 8, "0", STR_PAD_LEFT);
	return "C".$mcount;
}

function datepickerToMySQLDate($date)
{
	if(trim($date)!="" )
	{ 
		$date = DateTime::createFromFormat(DEFAULT_DATEFORMAT, trim($date));		
	 	$date = date_format($date, 'Y-m-d');
	}
	return $date;
}

function generateQuotationNo()
{ 
	global $tbname;
	//Q/2013/0043
	 $mstr1 = "SELECT max(REPLACE(_quotationno,'CGQ-','')) as MCount FROM ".$tbname."_salequotations sq Where _quotationno not like '%R%' ";
	$mrst = mysql_query($mstr1);
	$mcount = 0;
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
		$mcount = (int) $mrow['MCount'];
		
	}
	
	$mcount++;	
	
	$mcount = str_pad($mcount, 8, "0", STR_PAD_LEFT);

	//if($company=='1')
		return "CGQ-".$mcount;
	//else
		//return "QTSYS/".date('Y')."/".$mcount;
}
function generateQuotationRNo($rno)
{ 
	global $tbname;
	//Q/2013/0043
	 $mstr1 = "SELECT count(_id) as MCount FROM ".$tbname."_salequotations sq Where _quotationno like '". $rno ."%' ";
	 	
	$mrst = mysql_query($mstr1);
	$mcount = 0;
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
		$mcount = (int) $mrow['MCount'];
		
	}
	
	//$mcount++;	
	
	//$mcount = str_pad($mcount, 8, "0", STR_PAD_LEFT);

	//if($company=='1')
		return $rno . "R" .$mcount;
	//else
		//return "QTSYS/".date('Y')."/".$mcount;
}

function generatePurchaseRNo($rno)
{ 
	global $tbname;
	//Q/2013/0043
	 $mstr1 = "SELECT count(_id) as MCount FROM ".$tbname."_purchaseorders sq Where _purchaseorderno like '". $rno ."%' ";
	 	
	$mrst = mysql_query($mstr1);
	$mcount = 0;
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
		$mcount = (int) $mrow['MCount'];
		
	}
	
	//$mcount++;	
	
	//$mcount = str_pad($mcount, 8, "0", STR_PAD_LEFT);

	//if($company=='1')
		return $rno . "R" .$mcount;
	//else
		//return "QTSYS/".date('Y')."/".$mcount;
}


function getMaxOrder($sqid,$tblname,$fieldname,$searchfield)
{
	global $tbname;
	//Q/2013/0043
	 echo $mstr1 = "SELECT max(". $fieldname.") as MCount FROM ".$tbname. $tblname ." sq 
	 Where ". $searchfield ." = '". $sqid ."' and _status = 1 ";	
	 
	$mrst = mysql_query($mstr1);
	$mcount = 0;
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
		$mcount = $mrow['MCount'];
		
	}
	
	$mcount++;	

    return $mcount;
}


function generateOrderNo()
{
	global $tbname;
	 $mstr1 = "SELECT _orderno as MCount FROM ".$tbname."_salesorder sq ORDER BY _createddate DESC LIMIT 1 ";	
	$mrst = mysql_query($mstr1);
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
		$mcount = $mrow['MCount'];
		$mlength = strlen($mcount);
		$mcount = substr($mcount,($mlength-5));
	}
	if($mcount<=0)
	{
		$mcount = 1;
	}else
	{
		$mcount++;	
	}
	$mcount = str_pad($mcount, 5, "0", STR_PAD_LEFT);
	return "SO".date('Y').generateCode(3).$mcount;
}
function generateTechnicianNo()
{
	global $tbname;
	 $mstr1 = "SELECT _technicianno as MCount FROM ".$tbname."_technicians sq ORDER BY _createddate DESC LIMIT 1 ";	
	$mrst = mysql_query($mstr1);
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
		$mcount = $mrow['MCount'];
		$mlength = strlen($mcount);
		$mcount = substr($mcount,($mlength-5));
	}
	if($mcount<=0)
	{
		$mcount = 1;
	}else
	{
		$mcount++;	
	}
	$mcount = str_pad($mcount, 5, "0", STR_PAD_LEFT);
	return "TC".date('Y').generateCode(3).$mcount;
}
function generateJobNo($jNo)
{
	global $tbname;
	 
	if($jNo!="")
	{
		$mstr12 = "SELECT _jobno as MCount FROM ".$tbname."_jobsheets jsh ";
		 $mstr12 .= "WHERE _jobno = '".replaceSpecialChar($jNo)."' ";	

	}else
	{
		$mstr12 = "SELECT max(_jobno) as MCount FROM ".$tbname."_jobsheets jsh ";		
	}

	$mrst2 = mysql_query($mstr12);
	
	if(mysql_num_rows($mrst2)>0)
	{
		$mrow = mysql_fetch_assoc($mrst2);
		
		  $mcount = $mrow['MCount'];
		$mlength = strlen($mcount);
		$mcount = substr($mcount,($mlength-5));
		if($mcount=="" && $jNo=="")
		{
			$mcount = 1;	
			$mcount = str_pad($mcount, 5, "0", STR_PAD_LEFT);
			$jobNo = "T".date('Y'). $mcount;
				
			return ($jobNo);
		}else
		{
			$mcount = (int)$mcount;
			$mcount++;
			 $mcount = str_pad($mcount, 5, "0", STR_PAD_LEFT);
			 $jobNo = "T".date('Y'). $mcount;
			
			return generateJobNo($jobNo);	

		}
	}else
	{
		if($mcount<=0)
		{
			$mcount = 1;
		}else
		{
			$mcount++;	
		}
		$mcount = str_pad($mcount, 5, "0", STR_PAD_LEFT);
		$jobNo = "T".date('Y'). $mcount;
		if($jNo=="")
		{
			return $jobNo;
		}else
		{
			return $jNo;	
		}
	}
}

function generateMQuotationNo()
{
	global $tbname;
	 $mstr1 = "SELECT _orderno as MCount FROM ".$tbname."_maintainquotation sq ORDER BY _createddate DESC LIMIT 1 ";	
	$mrst = mysql_query($mstr1);
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
		$mcount = $mrow['MCount'];
		$mlength = strlen($mcount);
		$mcount = substr($mcount,($mlength-5));
	}
	if($mcount<=0)
	{
		$mcount = 1;
	}else
	{
		$mcount++;	
	}
	$mcount = str_pad($mcount, 5, "0", STR_PAD_LEFT);
	return "MQ".date('Y').generateCode(3).$mcount;
}

function checkDuplicateInvoiceNo($invNo,$cid)
{
	global $tbname;
	 $mstr1 = "SELECT _invoiceno as MCount FROM ".$tbname."_invoices sq WHERE _createdbycompany = '".$invNo."' ";
	 if($cid!="")
	 	$mstr1 .= " AND _id NOT IN('".$id."') ";
	 $mstr1 .= " ORDER BY _createddate DESC LIMIT 1 ";	
	$mrst = mysql_query($mstr1);
	$mcount = 0;
	if(mysql_num_rows($mrst)>0)
	{
		return '0';
	}else
		return '1';
}

function generateIssueNo()
{
	global $tbname;
	 $mstr1 = "SELECT _issueno as MCount FROM ".$tbname."_issues sq ORDER BY _createddate DESC LIMIT 1 ";	
	$mrst = mysql_query($mstr1);
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
		$mcount = $mrow['MCount'];
		$mlength = strlen($mcount);
		$mcount = substr($mcount,($mlength-5));
	}
	if($mcount<=0)
	{
		$mcount = 1;
	}else
	{
		$mcount++;	
	}
	$mcount = str_pad($mcount, 5, "0", STR_PAD_LEFT);
	return "IS".date('Y').generateCode(3).$mcount;
}
function generatePurchaseOrderNo()
{
	global $tbname;
	 $mstr1 = "SELECT max(REPLACE(_purchaseorderno,'CGP -','')) as MCount FROM ".$tbname."_purchaseorders sq ORDER BY _createddate DESC LIMIT 1 ";	
	$mrst = mysql_query($mstr1);
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
	$mcount = (int) $mrow['MCount'];
		
	}
	if($mcount<=0)
	{
		$mcount = 1;
	}else
	{
		$mcount++;	
	}
	$mcount = str_pad($mcount, 8, "0", STR_PAD_LEFT);
	return "CGP - ".$mcount;
}
function generateDeliveryOrderNo()
{
	global $tbname;
	 $mstr1 = "SELECT max(REPLACE(_deliveryorderno,'CGDO -','')) as MCount FROM ".$tbname."_deliveryorders sq ORDER BY _createddate DESC LIMIT 1 ";	
	$mrst = mysql_query($mstr1);
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
	$mcount = (int) $mrow['MCount'];
		
	}
	if($mcount<=0)
	{
		$mcount = 1;
	}else
	{
		$mcount++;	
	}
	$mcount = str_pad($mcount, 8, "0", STR_PAD_LEFT);
	return "CGDO - ".$mcount;
}
function generateInvoiceNo()
{
	global $tbname;
	 $mstr1 = "SELECT max(REPLACE(_invoiceno,'CGI -','')) as MCount FROM ".$tbname."_invoices sq ORDER BY _createddate DESC LIMIT 1 ";	
	$mrst = mysql_query($mstr1);
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
	$mcount = (int) $mrow['MCount'];
		
	}
	if($mcount<=0)
	{
		$mcount = 1;
	}else
	{
		$mcount++;	
	}
	$mcount = str_pad($mcount, 8, "0", STR_PAD_LEFT);
	return "CGI - ".$mcount;
}
function generateReceiptNo()
{
	global $tbname;
	 $mstr1 = "SELECT max(REPLACE(_orderno,'CGR -','')) as MCount FROM ".$tbname."_receipts sq ORDER BY _createddate DESC LIMIT 1 ";	
	$mrst = mysql_query($mstr1);
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
	$mcount = (int) $mrow['MCount'];
		
	}
	if($mcount<=0)
	{
		$mcount = 1;
	}else
	{
		$mcount++;	
	}
	$mcount = str_pad($mcount, 8, "0", STR_PAD_LEFT);
	return "CGR - ".$mcount;
}
function generateMaintenanceNo()
{
	global $tbname;
	 $mstr1 = "SELECT _mcno as MCount FROM ".$tbname."_maintenancecontract sq ORDER BY _createddate DESC LIMIT 1 ";	
	$mrst = mysql_query($mstr1);
	if(mysql_num_rows($mrst)>0)
	{
		
		$mrow = mysql_fetch_assoc($mrst);
		$mcount = $mrow['MCount'];
		$mlength = strlen($mcount);
		$mcount = substr($mcount,($mlength-5));
	
	}
	if($mcount<=0)
	{
		$mcount = 1;
	}else
	{
		$mcount++;	
	}
	$mcount = str_pad($mcount, 5, "0", STR_PAD_LEFT);
	return "MC".date('Y').generateCode(3).$mcount;
}
function getTotalProduct($productID)
{
	global $tbname;
	 $mstr1 = "SELECT SUM(_qty) as TotalQty FROM ".$tbname."_inventorytransaction WHERE _status = 'Live' AND _productid = '".$productID."' GROUP BY _productid ";	
	$mrst = mysql_query($mstr1);
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
		$mcount = $mrow['TotalQty'];/*
		$mlength = strlen($mcount);
		$mcount = substr($mcount,($mlength-5));*/
	}
	
	return $mcount;
}

function getPresoldTotalProduct($productID)
{
	global $tbname;
	 $mstr1 = "SELECT SUM(_qty) as TotalQty FROM ".$tbname."_salesorderitems
	  WHERE _productid = '".$productID."'
	  and _orderid Not In ( Select _soid From ".$tbname."_deliveryorder Where _soid is not null)
	   GROUP BY _productid ";	
	   
	$mrst = mysql_query($mstr1);
	if(mysql_num_rows($mrst)>0)
	{
		$mrow = mysql_fetch_assoc($mrst);
		$mcount = $mrow['TotalQty'];/*
		$mlength = strlen($mcount);
		$mcount = substr($mcount,($mlength-5));*/
	}
	
	return $mcount;
}
function addOrdinalNumberSuffix($num) {
    if (!in_array(($num % 100),array(11,12,13))){
      switch ($num % 10) {
        // Handle 1st, 2nd, 3rd
        case 1:  return $num.'st';
        case 2:  return $num.'nd';
        case 3:  return $num.'rd';
      }
    }
    return $num.'th';
  }
function datetimepickerToMySQLDate($datetimepicker)
	{
		$mysqlDateTime = "";
		if(trim($datetimepicker)!="")
		{
			if(count($datetimepicker) < 16)
			{
				$datepicker .= " 00:00";
			}
			$datepicker = explode(" ",$datetimepicker);
			$TmpFollowupDate = explode("/",$datepicker[0]);
	
			$mysqlDateTime = $TmpFollowupDate[2] . "-" . $TmpFollowupDate[1] . "-" . $TmpFollowupDate[0] . " " . $datepicker[1];
			
		}	
	
		return $mysqlDateTime;
		
	}

function getColumnNames($query){
  /*$colrst = mysql_query('SHOW COLUMNS FROM '.$table);  
  $columns = array();
	  while ($row = mysql_fetch_array($colrst)) {	
	  $columns[$row['Field']] = ucwords(substr($row['Field'],1));
		}*/
	$columns = array();
	if($query!="")
	{
		$result=mysql_query($query);
		$numfields = mysql_num_fields($result);
		
		for ($i=0; $i < $numfields; $i++) // Header
		{ 
			array_push($columns, mysql_field_name($result, $i));
		}
	}
	return $columns;
}

function exportToCSV($header, $exportstr, $reportname)
{
	$csv = NULL;
	if($header !=null && $header!="")
	{
		$hcount = count($header);
		$h = 1;
		foreach($header as $k => $v) 
		{
			$csv .= $v.",";
			if($h==$hcount)
			{
				$csv .= "\n";	
			}
			$h++;
		}
		if($exportstr !="")
		{
			$result = mysql_query($exportstr);
			if(mysql_num_rows($result) > 0)
			{
				$i = 1;
				while( $rs = mysql_fetch_assoc($result) )
				{
					$h2 = 1;
					foreach($header as $k => $v) 
					{
						$csv .= escapeExcelValue(replaceSpecialCharBack($rs[$v])) .',';
						if($h2==$hcount)
						{
							$csv .= "\n";	
						}
						$h2++;
					}
				}
			}
		}
	}
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=" . date("Y-m-d") . "_" . $reportname . ".csv;");
	header("Pragma: no-cache"); 
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0");  
	print "$csv";
	exit;
}
function allID($query,$colName){
        $results=array();
        if($query=="") return "";
		$arst = mysql_query($query);
		while($ars = mysql_fetch_assoc($arst)){   
                $results[] = $child[$colName];            
        }
        return implode(",",$results);
    }
?>