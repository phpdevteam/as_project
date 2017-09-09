<?php
ini_set('memory_limit', '-1');
session_start();	
include('../global.php');	
include('../include/functions.php');  include('access_rights_function.php'); 
 include("fckeditor/fckeditor.php");

require_once '../include/1.7.6/Classes/PHPExcel.php';

$reportname = $_GET['name'];	
$query = $_SESSION[$reportname];
$query = replaceSpecialCharBack($query);

$TRecord = mysql_query($query);
$allSalesOrder = "";
while($rsSalesOrder = mysql_fetch_array($TRecord))
{
	$allSalesOrder .= $rsSalesOrder['_id'].",";
}

if($allSalesOrder!="")
	$allSalesOrder = substr($allSalesOrder,0,strlen($allSalesOrder)-1);
		
		
if( $reportname == 'salesordermonthly')
{
	$alpha = range('A', 'Z');
	$startAlpha = 9;
	$firstTotalProduct = array();
	
	$query1 = "SELECT p._productname, p._id FROM ".$tbname."_receiptitems reci INNER JOIN ".$tbname."_products p ON reci._productid = p._id WHERE _status = 'Live' AND FIND_IN_SET(reci._orderid,'".$allSalesOrder."') ";								
	$query1 .= " ORDER BY p._productname";									
	$row = mysql_query('SET NAMES utf8');
	$row = mysql_query($query1);
	$p = 0;
	while($data=mysql_fetch_assoc($row)){
		$allProductID .= $data['_id'].",";
		$firstTotalProduct[$p] = $data['_productname'];
		$firstTotalProductID[$p]  = $data['_id'];
		$startAlpha++; $p++;
	 }
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
	
	$startAlpha = 9;
	$countProduct = $startAlpha+count($firstTotalProduct)-1;

	/*$objPHPExcel->setActiveSheetIndex(0)->mergeCells($alpha[$startAlpha].'2:'.$alpha[$countProduct].'2');
	$objPHPExcel->getActiveSheet()->setCellValue('J2', 'TAMI PRODUCTS');*/
	
	$objPHPExcel->getActiveSheet()->setCellValue('A3', 'No');
	$objPHPExcel->getActiveSheet()->setCellValue('B3','Date');
	$objPHPExcel->getActiveSheet()->setCellValue('C3', 'Sales Person');	
	$objPHPExcel->getActiveSheet()->setCellValue('D3', 'Date Paid');
	$objPHPExcel->getActiveSheet()->setCellValue('E3', 'Customer');
	$objPHPExcel->getActiveSheet()->setCellValue('F3', 'Inv No');
	$objPHPExcel->getActiveSheet()->setCellValue('G3', 'Amount S$');
	$objPHPExcel->getActiveSheet()->setCellValue('H3', '7% GST Amount S$');
	$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Total Amount S$');
	
	
	 $startAlpha=9;
	 for($k = 0; $k<count($firstTotalProduct); $k++)
	{
		$objPHPExcel->getActiveSheet()->setCellValue($alpha[$startAlpha].'3', $firstTotalProduct[$k]);
		$startAlpha++;
	}
		 
	$objPHPExcel->getActiveSheet()->setCellValue($alpha[$startAlpha].'3', 'Description');
	
	$objPHPExcel->getActiveSheet()->getStyle('A3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFill()->getStartColor()->setARGB('00004080');
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	
	$objPHPExcel->getActiveSheet()->getStyle('B3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('B3')->getFill()->getStartColor()->setARGB('00004080');
    $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	
	$objPHPExcel->getActiveSheet()->getStyle('C3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('C3')->getFill()->getStartColor()->setARGB('00004080');
    $objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	
	$objPHPExcel->getActiveSheet()->getStyle('D3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('D3')->getFill()->getStartColor()->setARGB('00004080');
    $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	
	$objPHPExcel->getActiveSheet()->getStyle('E3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('E3')->getFill()->getStartColor()->setARGB('00004080');
    $objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	
	$objPHPExcel->getActiveSheet()->getStyle('F3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('F3')->getFill()->getStartColor()->setARGB('00004080');
    $objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	
	$objPHPExcel->getActiveSheet()->getStyle('G3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('G3')->getFill()->getStartColor()->setARGB('00004080');
    $objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	
	$objPHPExcel->getActiveSheet()->getStyle('H3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('H3')->getFill()->getStartColor()->setARGB('00004080');
    $objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	
	$objPHPExcel->getActiveSheet()->getStyle('I3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('I3')->getFill()->getStartColor()->setARGB('00004080');
    $objPHPExcel->getActiveSheet()->getStyle('I3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	
	$startAlpha = 9;
	for($k = 0; $k<count($firstTotalProduct); $k++)
	{
		$objPHPExcel->getActiveSheet()->getStyle($alpha[$startAlpha].'3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle($alpha[$startAlpha].'3')->getFill()->getStartColor()->setARGB('00004080');
		$objPHPExcel->getActiveSheet()->getStyle($alpha[$startAlpha].'3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);	
		$startAlpha++;
	}
	
	$objPHPExcel->getActiveSheet()->getStyle($alpha[$startAlpha].'3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle($alpha[$startAlpha].'3')->getFill()->getStartColor()->setARGB('00004080');
	$objPHPExcel->getActiveSheet()->getStyle($alpha[$startAlpha].'3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

		$itemresult = mysql_query("SET NAMES 'utf8'");
		$itemresult=mysql_query($query) or die(mysql_error());	
		if(mysql_num_rows($itemresult))
		{
			$totalGross = 0;
			$totalTax = 0;
			$totalNetTotal = 0;
			$totalProduct = array();
			$i=1;
			$objPHPExcel->setActiveSheetIndex(0);
			while($rs = mysql_fetch_assoc($itemresult))
			{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i+3, $i);
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i+3, ($rs['_sodate']!=""?date('d/m/Y', strtotime($rs['_sodate'])):""));
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i+3, replaceSpecialChar($rs['_salesperson']));
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i+3, ($rs['_datepaid']!=""?date('d/m/Y', strtotime($rs['_datepaid'])):""));
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i+3, replaceSpecialChar($rs['_customername']));
								
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i+3, replaceSpecialChar($rs['_invoiceno']));
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i+3, $rs['_grosstotal']);
				$objPHPExcel->getActiveSheet()->getStyle('G'.($i+3))->getNumberFormat()->setFormatCode('#,##0.00');
				$totalGross = $totalGross + (float)$rs['_grosstotal'];
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i+3, $rs['_tax']);
				$objPHPExcel->getActiveSheet()->getStyle('H'.($i+3))->getNumberFormat()->setFormatCode('#,##0.00');
				$totalTax = $totalTax + (float)$rs['_tax'];
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i+3, $rs['_nettotal']);
				$objPHPExcel->getActiveSheet()->getStyle('I'.($i+3))->getNumberFormat()->setFormatCode('#,##0.00');
				$totalNetTotal = $totalNetTotal + (float)$rs['_nettotal'];
				
				$startAlpha = 9;
				for($k = 0; $k<count($firstTotalProduct); $k++)
				{
					$query2 = "SELECT SUM(reci._qty) AS _quantity FROM ".$tbname."_receiptitems reci INNER JOIN ".$tbname."_products p ON reci._productid = p._id AND FIND_IN_SET(p._id, '".$firstTotalProductID[$k]."') WHERE _status = 'Live' AND reci._orderid = '".$rs['_id']."' ";								
					$query2 .= " ORDER BY p._productname";																		
					$row2 = mysql_query('SET NAMES utf8');
					$row2 = mysql_query($query2);
					$j = 0;	
					while($data=mysql_fetch_assoc($row2)){
					 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($startAlpha, $i+3, replaceSpecialChar($data['_quantity']));
					 //$totalProduct[$k][$j] = (float)$totalProduct[$j] + (float)$data['_quantity'];
					 $j++;
					}
					 $startAlpha++;
				}
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($startAlpha, $i+3, replaceSpecialChar($rs['_orderremarks']));
				
				$i++;
			}
			
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i+3, $totalGross);
				$objPHPExcel->getActiveSheet()->getStyle('G'.($i+3))->getNumberFormat()->setFormatCode('#,##0.00');
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i+3, $totalTax);
				$objPHPExcel->getActiveSheet()->getStyle('H'.($i+3))->getNumberFormat()->setFormatCode('#,##0.00');
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i+3, $totalNetTotal);
				$objPHPExcel->getActiveSheet()->getStyle('I'.($i+3))->getNumberFormat()->setFormatCode('#,##0.00');
				$startAlpha = 9;
				for($k = 0; $k<count($firstTotalProduct); $k++)
				{
					for($x=0;$x<count($totalProduct);$x++)
					{
						/*$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($startAlpha, $i+3, $totalProduct[$x]);
						$startAlpha++;*/
					}
				}
		}	
		
} elseif( $reportname == 'annualsales')
{
	$alpha = range('A', 'Z');
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$tyear = (int)$_GET['ty']-(int)$_GET['fy'];
	
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:'.$alpha[$tyear+1].'2');
	$objPHPExcel->getActiveSheet()->setCellValue('A2', 'TOTAL ANNUAL SALES VOLUME (BY UNITS) -'.date('M').' '.date('Y'));
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 4, 'Model');
	$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
	$y = 1;
	for($year = $_GET['fy'];$year<=$_GET['ty'];$year++){
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y, 4, $year);
		$objPHPExcel->getActiveSheet()->getStyle($alpha[$y].'4')->getFont()->setBold(true);
		$y++;
	}
	
		$query =  "SELECT _id,_productname FROM ".$tbname."_products prod  WHERE prod._status = 'Live' ORDER BY _productname ";
		$itemresult = mysql_query("SET NAMES 'utf8'");
		$itemresult=mysql_query($query) or die(mysql_error());	
		if(mysql_num_rows($itemresult))
		{
			$i=1;
			$objPHPExcel->setActiveSheetIndex(0);
			while($rs = mysql_fetch_assoc($itemresult))
			{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i+4, replaceSpecialCharBack($rs['_productname']));
				$objPHPExcel->getActiveSheet()->getStyle('A'.($i+4))->getFont()->setBold(true);
				$y=1;
				for($year = $_GET['fy'];$year<=$_GET['ty'];$year++){

				   $str3 = "SELECT SUM(_qty) as tqty FROM ".$tbname."_salesorderitems ordd INNER JOIN ".$tbname."_salesorder orde ON orde._id = ordd._orderid AND orde._status = 'Live' WHERE ordd._productid = '".$rs['_id']."' ";
					$str3 = $str3 . " AND YEAR(orde._orderdate) = '".replaceSpecialChar($year)."' ";
					$str3 = $str3 . "GROUP BY YEAR(orde._orderdate) ";
					$rst3 = mysql_query($str3);
					$rs3 = mysql_fetch_assoc($rst3);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($y, $i+4, $rs3['tqty']);
					$y++;
				}
				$i++;
			}
			
		}	
		
}
		header('Content-Type: application/vnd.ms-excel;',true);
		header('Content-Type: text/html;charset:GB2312');
		header('Content-Disposition: attachment;filename="'.$reportname.'_'.date('Ymd').'.xls"',true);
		header("Pragma: no-cache",true); 
		header("Expires: 0",true); 
		header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>