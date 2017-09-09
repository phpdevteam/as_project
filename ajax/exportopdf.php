<?
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	include('../global.php');
	require('html2pdf/html2fpdf.php');	
	include('../include/functions.php');  
	
	$TitleName = "";
	$Body = "";
	$reportname = $_REQUEST['name'];
		
	$query = $_SESSION[$reportname];
		
	$result = mysql_query($query, $connect);
	
	if ($reportname == "memberslist")
	{
		$theader .= '<tr>';
		$theader .= '	<td width=35 bgcolor="#D7E0F4"><b>No.</b></td>';		
		$theader .= '	<td width=90 bgcolor="#D7E0F4"><b>Fullname</b></td>';
		$theader .= '	<td width=90 bgcolor="#D7E0F4"><b>Username</b></td>';
		$theader .= '	<td width=120 bgcolor="#D7E0F4"><b>Email</b></td>';
		$theader .= '	<td width=100 bgcolor="#D7E0F4"><b>Address</b></td>';
		$theader .= '	<td width=100 bgcolor="#D7E0F4"><b>Country</b></td>';
		$theader .= '	<td width=70 bgcolor="#D7E0F4"><b>State</b></td>';		
		$theader .= '	<td width=70 bgcolor="#D7E0F4"><b>City</b></td>';		
		$theader .= '	<td width=100 bgcolor="#D7E0F4"><b>Postal Code</b></td>';
		$theader .= '	<td width=70 bgcolor="#D7E0F4"><b>HomeTel</b></td>';
		$theader .= '	<td width=70 bgcolor="#D7E0F4"><b>Mobile</b></td>';
		$theader .= '	<td width=70 bgcolor="#D7E0F4"><b>Fax</b></td>';
		$theader .= '	<td width=110 bgcolor="#D7E0F4"><b>Register Date</b></td>';
		$theader .= '</tr>';
		$TitleName = "Members List ";
	}
	else if ($reportname == "orderslist")
	{
		$theader .= '<tr>';
		$theader .= '	<td width=35 bgcolor="#D7E0F4"><b>No.</b></td>';
		$theader .= '	<td width=100 bgcolor="#D7E0F4"><b>Order No</b></td>';
		$theader .= '	<td width=130 bgcolor="#D7E0F4"><b>Order Date</b></td>';
		$theader .= '	<td width=130 bgcolor="#D7E0F4"><b>Total Amount</b></td>';
		$theader .= '	<td width=150 bgcolor="#D7E0F4"><b>Shipping Address</b></td>';
		$theader .= '	<td width=100 bgcolor="#D7E0F4"><b>Order By</b></td>';
		$theader .= '	<td width=130 bgcolor="#D7E0F4"><b>Delivery Date</b></td>';
		$theader .= '	<td width=130 bgcolor="#D7E0F4"><b>Order Status</b></td>';	
		$theader .= '</tr>';
		$TitleName = "Orders List ";
		
	}	
	
	//Body
	$Rheader = '<table width="1050" cellpadding="0" cellspacing="0" border="0">';
	$Rheader .= '<tr>';
	$Rheader .= '<td align="center"><b>PawGlam</b></td>';
	$Rheader .= '</tr>';
	$Rheader .= '<tr><td height="10"></td></tr>';
	$Rheader .= '<tr>';
	$Rheader .= '<td align="center"><b>' . $TitleName . ' Report</b></td>';
	$Rheader .= '</tr>';
	$Rheader .= '</table>';

	if(mysql_num_rows($result) > 0)
	{
		$i = 1;		
		
		if ($reportname == "memberslist")
		{
			$Body .= '<table width="1050" border="1" cellspacing="0" cellpadding="2">';
			$Body .= $theader;
			$Rowcolor = "FFFFFF";
			$i=1;
			while($rs = mysql_fetch_assoc($result) )
			{
				if  ($Rowcolor == "F8F8F8")
					$Rowcolor = "FFFFFF";
				elseif ($Rowcolor == "FFFFFF")
					$Rowcolor = "F8F8F8";	
				$Body .= '<tr>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">'.$i.'</td>';			
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_Fullname'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_Username'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_Email'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_Address'] . '&nbsp;</td>';
				$str2 = "SELECT * FROM ".$tbname."_country WHERE _ID = '".$rs['_CountryID']."' ";
				$rst2 = mysql_query($str2, $connect) or die(mysql_error());
				if(mysql_num_rows($rst2) > 0)
				{
					$rs2 = mysql_fetch_assoc($rst2);
					$CountryName = $rs2["_CountryName"];
				}
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $CountryName . '&nbsp;</td>';			
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_State'] . '&nbsp;</td>';				
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_City'] . '&nbsp;</td>';				
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_PostalCode'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_HomeTel'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_Mobile'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_Fax'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . date('d/m/Y', strtotime($rs['_RegisterDate'])) . '&nbsp;</td>';								
				$Body .= '</tr>';	
				$i++;		
			}
			$Body .= '</table>';
		}
		else if ($reportname == "orderslist")
		{
			$Body .= '<table width="1050" border="1" cellspacing="0" cellpadding="2">';
			$Body .= $theader;
			$Rowcolor = "FFFFFF";
			$i=1;			
			while($rs = mysql_fetch_assoc($result) )
			{
				if  ($Rowcolor == "F8F8F8")
					$Rowcolor = "FFFFFF";
				elseif ($Rowcolor == "FFFFFF")
					$Rowcolor = "F8F8F8";	
				$Body .= '<tr>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">'.$i.'</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_OrderID'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . date('d/m/Y', strtotime($rs['_OrderDate'])) . '&nbsp;</td>';		
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_TotalAmt'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_ShippingAddress'] . '&nbsp;</td>';
				$str2 = "SELECT * FROM ".$tbname."_member WHERE _ID = '".$rs['_MemID']."' ";
				$rst2 = mysql_query($str2, $connect) or die(mysql_error());
				if(mysql_num_rows($rst2) > 0)
				{
					$rs2 = mysql_fetch_assoc($rst2);
					$Fullname = $rs2["_Fullname"];
				}
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $Fullname . '&nbsp;</td>';	
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . date('d/m/Y', strtotime($rs['_DeliveryDate'])) . '&nbsp;</td>';			
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_OrdersStatus'] . '&nbsp;</td>';																	
				$Body .= '</tr>';	
				$i++;
			}
			$Body .= '</table>';
			
		}					
	}
	
	$pdf_filename = str_replace("/", "_",  date("Y-m-d") . "_" . $reportname  ) . ".pdf";
	$pdf_filepath = $pdf_filename;
	$module = $ModuleDesc . " (" . $ModuleName . ")";

	class PDF extends HTML2FPDF
	{
		function Footer()
		{
			global  $module;
			global  $TitleName;
			$this->SetY(-13);
			//Arial italic 8
			$this->SetFont('Arial','I',10);
			//Text color in gray
			$this->SetTextColor(128);
			//Page number  $CourseName  $ModuleName
			$this->Cell(0, 0, "PawGlam (".$TitleName."Report) - ".date("d-M-Y")." ", 0, 0, 'L');
			$this->Cell(0,0,'Page '. round($this->PageNo()),0,0,'R');
		}

		/*function PrintChapter($num,$title,$file)
		{
			$this->AddPage();
			$this->ChapterBody($file);
		}*/
	}

	$pdf=new PDF();
	$pdf->SetMargins(5,10,10);	
		
	//$pdf->SetFont('times','',8);	
	$pdf->AddPage('L');	
	$pdf->WriteHTML($Rheader);	
	$pdf->WriteHTML($Body);			
	$pdf->output($pdf_filepath,'D');		
	include('../dbclose.php');
?>