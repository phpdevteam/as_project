<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']=="")
{
echo "<script language='javascript'>window.location='login.php';</script>";
}
else
{
include('../global.php');
include('../include/functions.php');  
$currentmenu = "Audit Logs";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$gbtitlename?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css" />
<link rel="stylesheet" href="../jquery/autocomplete/docsupport/prism.css">
<link rel="stylesheet" href="../jquery/autocomplete/chosen.css" />
<script type="text/javascript" src="../js/validate.js"></script>

<? include('jquerybasiclinks.php'); ?>
<script type="text/javascript" src="../js/functions.js"></script>
<script type="text/javascript" language="javascript">	

function clearDefault()
{
	 var fromDate = $("#fromDate").val();	 
	 if(fromDate == "From Date")
	 {
	     $("#fromDate").val("");	
	 }
	 
	 
	  var toDate = $("#toDate").val();	 
	 if(toDate == "To Date")
	 {
	     $("#toDate").val("");	
	 }
	 

}

/* $(function(){
$( ".datepicker" ).datepicker({
                	showOn: "button",
                    buttonImage: "../images/calender.jpg",
                    buttonImageOnly: true,
            		changeDate: true,
            		changeMonth: true,
            		changeYear: true,
              		dateFormat: 'dd/mm/yy'
});

var date = new Date();
var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
$("#fromDate").datepicker('setDate', firstDay);
$("#toDate").datepicker('setDate', new Date());
			
			
				
		}); */


<!--
function validateForm()
{
var errormsg;
errormsg = "";
if(document.AuditLog.FromDay.value=="" || document.AuditLog.FromMth.value=="" || document.AuditLog.FromYr.value=="") 
{
errormsg += "Please select valid 'From Date'.\n";
}
else
{
if (!isDate(document.AuditLog.FromYr.value, document.AuditLog.FromMth.value, document.AuditLog.FromDay.value))
errormsg += "Please select valid From Date.\n";
}
if(document.AuditLog.ToDay.value=="" || document.AuditLog.ToMth.value=="" || document.AuditLog.ToYr.value=="")
{
errormsg += "Please select valid 'To Date'.\n";
}
else
{
if (!isDate(document.AuditLog.ToYr.value, document.AuditLog.ToMth.value, document.AuditLog.ToDay.value))
errormsg += "Please select valid To Date.\n";
}
if(document.AuditLog.FromDay.value!="" && document.AuditLog.FromMth.value!="" && document.AuditLog.FromYr.value!="" && document.AuditLog.ToDay.value!="" && document.AuditLog.ToMth.value!="" && document.AuditLog.ToYr.value!="")
{
var tempFromDate = new Date(document.AuditLog.FromYr.value, document.AuditLog.FromMth.value, document.AuditLog.FromDay.value);
var tempToDate = new Date(document.AuditLog.ToYr.value, document.AuditLog.ToMth.value, document.AuditLog.ToDay.value);
    if ( tempToDate < tempFromDate )
    {
    errormsg += "Please select To Date later than From Date.\n";
    }
}
if (document.AuditLog.LogType.value == "")
    errormsg += "Please select Log Type.\n";

    if ((errormsg == null) || (errormsg == ""))
    {
    return true;
    }
    else
    {
    alert(errormsg);
    return false;
    }
}
//-->
</script>
</head>
<body>
	<table align="center" width="970" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="align:center;">
		<tr>
			<td valign="top">
			<div class="maintable">
				<table width="970" border="0" cellspacing="0" cellpadding="0">			
						<tr>
							<td valign="top">
								<?php include('topbar.php'); ?>
							</td>
							</tr>
							
						<tr>
							
						<td class="inner-block" width="970" align="left" valign="top">	
						<div class="m">															
						<!--
						Start Contact
						-->
						
						<?php
						if ($_GET["LogType"] != "")
						{
							$username =  trim($_REQUEST['username']);
							$LogType =  trim($_GET["LogType"]);
						}
							$StartDate = "";
							$EndDate =  "";
							if(trim($_REQUEST['fromDate']) != '')
							{
								$StartDate =  trim($_REQUEST['fromDate']);
								$StartDatequery =  datepickerToMySQLDate($_REQUEST['fromDate']);
							}
							else{
								$StartDate =  date('01/m/Y');
								$StartDatequery =  datepickerToMySQLDate($StartDate);
							}
							if(trim($_REQUEST['toDate']) != '')
							{
								$EndDate =  trim($_REQUEST['toDate']);
								$EndDatequery =  datepickerToMySQLDate($EndDate);
							}
							else{
								$EndDate =   date('t/m/Y');
								$EndDatequery =  datepickerToMySQLDate($EndDate);
							}
							?>
											
											
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
								  <td align="left" class="TitleStyle"><b>Reports > Audit Logs</b></td></tr>
                            <tr><td height="10"></td></tr>
                            <tr>
                                <td>
                                    <table width="922" border="0" cellspacing="0" cellpadding="0">
                                        <tr><td height="5"></td></tr>
                                        <tr>
                                        <td>
                                        <form action="auditlogs.php" name="AuditLog" method="get" onsubmit="return clearDefault();">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
										<td>
										<table width="50%" style="margin:left" border="0" cellspacing="0" cellpadding="0">
										<tr>
                               
										    <td> <input  name="fromDate" type="text" class="defaultText datepicker" id="fromDate" value="<?=$StartDate?>" style="width:150px"></td>
                                      <td><input  name="toDate" type="text" class="txtbox1 datepicker"  id="toDate" value="<?=$EndDate?>" style="width:150px"/></td>
                                      
																			<td width="40"  align="right">	
																				<select name="username" id="username">
																			 <option value=""<?php echo (($username == '')) ?  'selected' : ''; ?>>Select Username</option>
																			 <?php 
																				$str1 = mysql_query("select U.*, L._LevelName
																								from ".$tbname."_user U left join ".$tbname."_level L on U._LevelID = L._ID  where U._ID!='$AdminId' ");
																				while($row_user = mysql_fetch_assoc($str1))
																				{
																					?>
																					<option value="<?php echo $row_user['_ID'];?>"<?php echo (($username == $row_user['_ID'])) ? 'selected' : '' ?>><?php echo $row_user['_Username'] ?></option> 
																					<?php
																				} ?>
																			
																		</select>
																				</td>
																				
                                          <td width="40"  align="right">
										  <input type="hidden" name="LogType" value="Login Log" />
										  <input type="submit" name="Submit" value="Search" class="button1" />
											</td>
                                          <td align="left"></td>
										  </tr>
										  <tr><td height="10" colspan="11"></td></tr>
							
										 										  </table>
										</td>  
                                        </tr>
                                        </table>
                                        </form>
                                        </td>
                                        </tr>
                                        <?php
                                        if ($_GET["LogType"] != "")
                                        {
										
												/* if($StartDate!= "")
											{
											   $StartDateArr = explode("/",$StartDate);
											   $StartDate = $StartDateArr[2] . $StartDateArr[1] . $StartDateArr[0];
											}
											
											if($EndDate!= "")
											{
											   $EndDateArr = explode("/",$EndDate);
											   $EndDate = $EndDateArr[2] . $EndDateArr[1] . $EndDateArr[0];
											} */

										$sortBy 		= trim($_GET["sortBy"]);
										$sortArrange	= trim($_GET["sortArrange"]);
                                        //Set the page size
                                        $PageSize = 20;
                                        $StartRow = 0;
                                        //Set the page no
                                        if(empty($_GET['PageNo']))
                                        {
                                            if($StartRow == 0)
                                            {
                                            $PageNo = $StartRow + 1;
                                            }
                                        }
                                        else
                                        {
                                        $PageNo = $_GET['PageNo'];
                                        $StartRow = ($PageNo - 1) * $PageSize;
                                        }
                                        //Set the counter start
                                        if($PageNo % $PageSize == 0)
                                        {
                                        $CounterStart = $PageNo - ($PageSize - 1);
                                        }
                                        else
                                        {
                                        $CounterStart = $PageNo - ($PageNo % $PageSize) + 1;
                                        }
                                        //Counter End
                                        $CounterEnd = $CounterStart + ($PageSize - 1);
                                        if($LogType=="Login Log")
                                        {
                                        $str1 = "SELECT * FROM ".$tbname."_logginglog 
																								WHERE _ID IS NOT NULL ";
										
                                        /* if ($StartDate != "")
                                        {
                                        $str1 = $str1 . "AND Date(_DateTimeIn) >= Date('".replaceSpecialChar($StartDatequery)."') ";
                                        }
                                        if ($EndDate != "")
                                        {
                                        $str1 = $str1 . "AND Date(_DateTimeIn) <= Date('".replaceSpecialChar($EndDatequery)."') ";
                                        } */
																				if ($StartDatequery != "" && $EndDatequery == "")
                                        {
																					$str1 = $str1 ." AND _DateTimeIn = Date('".replaceSpecialChar($StartDatequery)."') ";
																				}
																				
																				if ($StartDatequery != "" && $EndDatequery != "")
                                        {
																					$str1 = $str1 ." AND _DateTimeIn between
																						Date('".replaceSpecialChar($StartDatequery)."') and Date('".replaceSpecialChar($EndDatequery)."')  ";
																				}
																				if($username != '')
																				{
																					$str1 = $str1." AND _UserID=".$username;
																				}
																				
                                        //
                                        $str2 = "SELECT * FROM ".$tbname."_logginglog WHERE _ID IS NOT NULL ";
																				if($username != '')
																				{
																					$str2 = $str2." AND _UserID=".$username;
																				}
                                       /*  if ($StartDate != "")
                                        {
                                        $str2 = $str2 . " AND Date(_DateTimeIn) >= Date('".replaceSpecialChar($StartDatequery)."') ";
                                        }
                                        if ($EndDate != "")
                                        {
                                        $str2 = $str2 . " AND Date(_DateTimeIn) <= Date('".replaceSpecialChar($EndDatequery)."') ";
                                        } */
																				if ($StartDatequery != "" && $EndDatequery == "")
                                        {
																					$str2 = $str2 ." AND _DateTimeIn = Date('".replaceSpecialChar($StartDatequery)."') ";
																				}
																				
																				if ($StartDatequery != "" && $EndDatequery != "")
                                        {
																					$str2 = $str2 ." AND _DateTimeIn between
																						Date('".replaceSpecialChar($StartDatequery)."') and Date('".replaceSpecialChar($EndDatequery)."')  ";
																				}														
																			 
									    if($_GET['sortBy'] != "")
									    $str2 = $str2 . "ORDER BY ".$_GET['sortBy']. " " .$_GET['sortArrange']; 
										$str2 = $str2 . " LIMIT $StartRow,$PageSize ";
										// echo '--'.$str2;die;
                                        }
                                        else if($LogType="History Log")
                                        {
																					$str1 = "SELECT * FROM ".$tbname."_auditlog WHERE _ID IS NOT NULL ";
																					/* if ($StartDate != "")
																					{
																					$str1 = $str1 . "AND _LogDate >= '".replaceSpecialChar($StartDatequery)."' ";
																					}
																					if ($EndDate != "")
																					{
																					$str1 = $str1 . "AND _LogDate <= '".replaceSpecialChar($EndDatequery)."' ";
																					} */
																					if ($StartDatequery != "" && $EndDatequery == "")
																					{
																						$str1 = $str1 ." AND _LogDate = Date('".replaceSpecialChar($StartDatequery)."') ";
																					}
																					
																					if ($StartDatequery != "" && $EndDatequery != "")
																					{
																						$str1 = $str1 ." AND _LogDate between
																							Date('".replaceSpecialChar($StartDatequery)."') and Date('".replaceSpecialChar($EndDatequery)."')  ";
																					}
																					if($username != '')
																					{
																						$str1 = $str1." AND _UserID=".$username;
																					}
																					
																					//
																					$str2 = "SELECT * FROM ".$tbname."_auditlog WHERE _ID IS NOT NULL ";

																					/* if ($StartDate != "")
																					{
																					$str2 = $str2 . "AND _LogDate >= '".replaceSpecialChar($StartDatequery)."' ";
																					}
																					if ($EndDate != "")
																					{
																					$str2 = $str2 . "AND _LogDate <= '".replaceSpecialChar($EndDatequery)."' ";
																					} */
																					if ($StartDatequery != "" && $EndDatequery == "")
																					{
																						$str2 = $str2 ." AND _LogDate = Date('".replaceSpecialChar($StartDatequery)."') ";
																					}
																					
																					if ($StartDatequery != "" && $EndDatequery != "")
																					{
																						$str2 = $str2 ." AND _LogDate between
																							Date('".replaceSpecialChar($StartDatequery)."') and Date('".replaceSpecialChar($EndDatequery)."')  ";
																					}																					
																					if($username != '')
																					{
																						$str2 = $str2." AND _UserID=".$username;
																					}
																					 if($_GET['sortBy'] != "")
																					 {
																						$str2 = $str2 . " ORDER BY ".$_GET['sortBy']. " " .$_GET['sortArrange']; 
																					 }
																					 else{
																						 $str2 = $str2 . " ORDER BY _LogDate DESC"; 
																					 }
																					$str2 = $str2 . " LIMIT $StartRow,$PageSize ";
                                        }
																			// echo $str2;
																				$TRecord = mysql_query($str1, $connect);
                                        $result = mysql_query($str2, $connect);
                                        //Total of record
                                        $RecordCount = mysql_num_rows($TRecord);
                                        //Set Maximum Page
                                        $MaxPage = $RecordCount % $PageSize;
                                        if($RecordCount % $PageSize == 0)
                                        {
                                        $MaxPage = $RecordCount / $PageSize;
                                        }
                                        else
                                        {
                                        $MaxPage = ceil($RecordCount / $PageSize);
                                        }
                                        if($RecordCount > 0)
                                        {
                                        ?>
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                    <tr>
                                                        <td><div align="right"><?php print "$RecordCount record(s) founds - You are at page $PageNo  of $MaxPage"; ?></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pageno">
                                                            <?php
															$pageshowlimit = 20;
															
															$QureyUrl = "&fromDate=". $StartDate."&toDate=". $EndDate."&LogType=" . $LogType."&username=".$username;
															
                        $pageshowpoint = $_GET['pageshowpoint'];
                        if ($pageshowpoint != "" && is_numeric($pageshowpoint)) {
                          $pageshowpoint = (int) $pageshowpoint;
                        } else {
                          $pageshowpoint = 0;
                        }
                        $pageshowstart = (int) $pageshowpoint + 1;
                        $pageshowend = (int) $pageshowpoint + (int) $pageshowlimit;

                        if ((int) $pageshowpoint == 0) {
                          $sProjectPrev = "";
                        } elseif ((int) $pageshowpoint > 0) {
                          $sProjectPrev = "<a href='?PageNo=" . ((int) $pageshowpoint - (int) $pageshowlimit + 1) . "&amp;pageshowpoint=" . ((int) $pageshowpoint - (int) $pageshowlimit) . $QureyUrl . "' class='menulink'>Previous " . $pageshowlimit . "</a> ";
                        }

                        if ((int) $MaxPage <= (int) $pageshowend) {
                          $sProjectNext = "";
                        } elseif ((int) $MaxPage > (int) $pageshowend) {
                          $sProjectNext = "<a href='?PageNo=" . ((int) $pageshowpoint + (int) $pageshowlimit + 1) . "&amp;pageshowpoint=" . ((int) $pageshowpoint + (int) $pageshowlimit) . $QureyUrl . "' class='menulink'>Next " . $pageshowlimit . "</a> ";
                        }               

                        
                        if ($sProjectPrev != ""){
                            print $sProjectPrev . "&nbsp;&nbsp;";
                        }
                          
                        if ((int) $MaxPage < (int) $pageshowend) {
                            $untilpage = (int) $MaxPage;
                        } else {
                            $untilpage = (int) $pageshowend;
                        }

                        if ((int) $untilpage == 0) {
                          $untilpage = 1;
                        }
                      
                        if($MaxPage > 0) echo "Page: ";

                        for ($i = (int) $pageshowstart; $i <= (int) $untilpage; $i++) 
                        {
                            if ($i == $PageNo)
                            {
                                print "<a class=\"selected\" href='?PageNo=". $i. "&amp;pageshowpoint=" . $_GET['pageshowpoint'] . $QureyUrl ."' class='menulink'>".$i."</a> ";
                            }
                            else
                            {
                                print "<a class=\"unselect\" href='?PageNo=" . $i. "&amp;pageshowpoint=" . $_GET['pageshowpoint'] . $QureyUrl ."' class='menulink'>".$i."</a> ";
                            }
                        }
                
                        if ($sProjectNext != "") {
                          print "&nbsp;&nbsp;" . $sProjectNext;
                        }
                        
                        if (trim($sortArrange) == "DESC")
                            $sortArrange = "ASC";
                        elseif (trim($sortArrange) == "ASC")
                            $sortArrange = "DESC";
                        else
                            $sortArrange = "DESC";
															
															?>
                                                        </td>
                                                    </tr>
                                                    <tr><td height="5"></td></tr>
                                                    <tr>
                                                        <td>
                                                        <?php
                                                        if($LogType=="Login Log")
                                                        {
                                                        ?>
                                                            <table width="100%" class="grid" cellspacing="0" cellpadding="2">
                                                                <tr>
                                                                    <td class="gridheader" align="center" width="40">&nbsp;<b>No.</b>&nbsp;</td>
                                                                    <td class="gridheader" align="center" width="160"><a href="?PageNo=<?=$PageNo?>&sortBy=_UserID&sortArrange=<?=$sortArrange?>&FromDay=<?=$_GET['FromDay']?>&FromMth=<?=$_GET['FromMth']?>&FromYr=<?=$_GET['FromYr']?>&ToDay=<?=$_GET['ToDay']?>&ToMth=<?=$_GET['ToMth']?>&ToYr=<?=$_GET['ToYr']?>&LogType=<?=$_GET['LogType']?>" class="link1">Username </a></td>
																	<td class="gridheader" align="center" width="201"><a href="?PageNo=<?=$PageNo?>&sortBy=_IPAddress&sortArrange=<?=$sortArrange?>&FromDay=<?=$_GET['FromDay']?>&FromMth=<?=$_GET['FromMth']?>&FromYr=<?=$_GET['FromYr']?>&ToDay=<?=$_GET['ToDay']?>&ToMth=<?=$_GET['ToMth']?>&ToYr=<?=$_GET['ToYr']?>&LogType=<?=$_GET['LogType']?>" class="link1">IP Address</a></td>
																	<td class="gridheader" align="center" width="212"><a href="?PageNo=<?=$PageNo?>&sortBy=_DateTimeIn&sortArrange=<?=$sortArrange?>&FromDay=<?=$_GET['FromDay']?>&FromMth=<?=$_GET['FromMth']?>&FromYr=<?=$_GET['FromYr']?>&ToDay=<?=$_GET['ToDay']?>&ToMth=<?=$_GET['ToMth']?>&ToYr=<?=$_GET['ToYr']?>&LogType=<?=$_GET['LogType']?>" class="link1">Date / Time In</a></td>
																	<td class="gridheader" align="center" width="212"><a href="?PageNo=<?=$PageNo?>&sortBy=_DateTimeOut&sortArrange=<?=$sortArrange?>&FromDay=<?=$_GET['FromDay']?>&FromMth=<?=$_GET['FromMth']?>&FromYr=<?=$_GET['FromYr']?>&ToDay=<?=$_GET['ToDay']?>&ToMth=<?=$_GET['ToMth']?>&ToYr=<?=$_GET['ToYr']?>&LogType=<?=$_GET['LogType']?>" class="link1">Date / Time Out</a></td>
                                                                </tr>
                                                                <?php
                                                                $i = 1;
                                                                $Rowcolor = "gridline1";
                                                                while ($row = mysql_fetch_array($result))
                                                                {
                                                                $bil = $i + ($PageNo-1)*$PageSize;
                                                                if  ($Rowcolor == "gridline2")
                                                                $Rowcolor = "gridline1";
                                                                elseif ($Rowcolor == "gridline1")
                                                                $Rowcolor = "gridline2";
                                                                ?>
                                                                <tr>
                                                                    <td class="<?php echo $Rowcolor; ?>" align="center" width="40">&nbsp;<?php echo $bil; ?>.&nbsp;</td>
                                                                    <td class="<?php echo $Rowcolor; ?>" align="center" width="160">&nbsp;<?php
                                                                    $str = "SELECT * FROM ".$tbname."_user ";
                                                                    $str = $str . " WHERE _ID = '" .  $row['_UserID'] . "' ";
                                                                    $rst = mysql_query($str, $connect) or die(mysql_error());
                                                                    if(mysql_num_rows($rst) > 0)
                                                                    {
                                                                        while($rs = mysql_fetch_assoc($rst))
                                                                        {
                                                                        echo $rs["_Username"];
                                                                        }
                                                                    }
                                                                    ?>&nbsp;</td>
                                                                    <td class="<?php echo $Rowcolor; ?>" align="center" width="201">&nbsp;<?php echo $row['_IPAddress']; ?>&nbsp;</td>
                                                                    <td class="<?php echo $Rowcolor; ?>" align="center" width="212">&nbsp;<?php if($row['_DateTimeIn'] != "") { echo date("j M Y g:i:s A", strtotime($row['_DateTimeIn'])); } ?>&nbsp;</td>
                                                                    <td class="<?php echo $Rowcolor; ?>" align="center" width="212">&nbsp;<?php if($row['_DateTimeOut'] != "") { echo date("j M Y g:i:s A", strtotime($row['_DateTimeOut'])); } ?>&nbsp;</td>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                                }
                                                                ?>
                                                            </table>
                                                        <?php
                                                        }
                                                        else if($LogType=="History Log")
                                                        {
                                                        ?>
                                                            <table width="100%" class="grid" cellspacing="0" cellpadding="2">
                                                                <tr>
                                                                    <td class="gridheader" align="center" width="40">&nbsp;<b>No.</b>&nbsp;</td>
                                                                    <td class="gridheader" align="center" width="160"><a href="?PageNo=<?=$PageNo?>&sortBy=_UserID&sortArrange=<?=$sortArrange?>&FromDay=<?=$_GET['FromDay']?>&FromMth=<?=$_GET['FromMth']?>&FromYr=<?=$_GET['FromYr']?>&ToDay=<?=$_GET['ToDay']?>&ToMth=<?=$_GET['ToMth']?>&ToYr=<?=$_GET['ToYr']?>&LogType=<?=$_GET['LogType']?>" class="link1">Username </a></td>
                                                                    <td class="gridheader" align="center" width="201"><a href="?PageNo=<?=$PageNo?>&sortBy=_IPAddress&sortArrange=<?=$sortArrange?>&FromDay=<?=$_GET['FromDay']?>&FromMth=<?=$_GET['FromMth']?>&FromYr=<?=$_GET['FromYr']?>&ToDay=<?=$_GET['ToDay']?>&ToMth=<?=$_GET['ToMth']?>&ToYr=<?=$_GET['ToYr']?>&LogType=<?=$_GET['LogType']?>" class="link1">IP Address</a></td>
																	<td class="gridheader" align="center" width="212"><a href="?PageNo=<?=$PageNo?>&sortBy=_LogDate&sortArrange=<?=$sortArrange?>&FromDay=<?=$_GET['FromDay']?>&FromMth=<?=$_GET['FromMth']?>&FromYr=<?=$_GET['FromYr']?>&ToDay=<?=$_GET['ToDay']?>&ToMth=<?=$_GET['ToMth']?>&ToYr=<?=$_GET['ToYr']?>&LogType=<?=$_GET['LogType']?>" class="link1">Log Date / Time</a></td>
																	<td class="gridheader" align="center" width="201"><a href="?PageNo=<?=$PageNo?>&sortBy=_Event&sortArrange=<?=$sortArrange?>&FromDay=<?=$_GET['FromDay']?>&FromMth=<?=$_GET['FromMth']?>&FromYr=<?=$_GET['FromYr']?>&ToDay=<?=$_GET['ToDay']?>&ToMth=<?=$_GET['ToMth']?>&ToYr=<?=$_GET['ToYr']?>&LogType=<?=$_GET['LogType']?>" class="link1">Event</a></td>
																	<td class="gridheader" align="center" width="201"><a href="?PageNo=<?=$PageNo?>&sortBy=_EventItem&sortArrange=<?=$sortArrange?>&FromDay=<?=$_GET['FromDay']?>&FromMth=<?=$_GET['FromMth']?>&FromYr=<?=$_GET['FromYr']?>&ToDay=<?=$_GET['ToDay']?>&ToMth=<?=$_GET['ToMth']?>&ToYr=<?=$_GET['ToYr']?>&LogType=<?=$_GET['LogType']?>" class="link1">Event Item</a></td>
																</tr>                                                           
                                                        <?php
                                                        $i = 1;
                                                        $Rowcolor = "gridline1";
                                                        while ($row = mysql_fetch_array($result))
                                                        {
                                                        $bil = $i + ($PageNo-1)*$PageSize;
                                                        if  ($Rowcolor == "gridline2")
                                                        $Rowcolor = "gridline1";
                                                        elseif ($Rowcolor == "gridline1")
                                                        $Rowcolor = "gridline2";
                                                        ?>
                                                                <tr>
                                                                    <td class="<?php echo $Rowcolor; ?>" align="center" width="40">&nbsp;<?php echo $bil; ?>.&nbsp;</td>
                                                                    <td class="<?php echo $Rowcolor; ?>" align="center" width="160">&nbsp;
                                                                    <?php
                                                                    $str = "SELECT * FROM ".$tbname."_user ";
                                                                    $str = $str . " WHERE _ID = '" .  $row['_UserID'] . "' ";

                                                                    $rst = mysql_query($str, $connect) or die(mysql_error());
                                                                    if(mysql_num_rows($rst) > 0)
                                                                    {
                                                                        while($rs = mysql_fetch_assoc($rst))
                                                                        {
                                                                        echo $rs["_Username"];
                                                                        }
                                                                    }
                                                                    ?>&nbsp;</td>
                                                                    <td class="<?php echo $Rowcolor; ?>" align="center" width="201">&nbsp;<?php echo $row['_IPAddress']; ?>&nbsp;</td>
                                                                    <td class="<?php echo $Rowcolor; ?>" align="center" width="212">&nbsp;<?php if($row['_LogDate'] != "") { echo date("j M Y g:i:s A", strtotime($row['_LogDate'])); } ?>&nbsp;</td>
                                                                    <td class="<?php echo $Rowcolor; ?>" align="center" width="201">&nbsp;<?php echo $row['_Event']; ?>&nbsp;</td>
                                                                    <td class="<?php echo $Rowcolor; ?>" align="center" width="201">&nbsp;<?php echo $row['_EventItem']; ?>&nbsp;</td>
                                                                </tr>
                                                        <?php
                                                        $i++;
                                                        }
                                                        ?>
                                                            </table>
                                                        <?php
                                                        }
                                                        ?>
                                                        </td>
                                                        </tr>
                                                        <tr><td height="5"></td></tr>
                                                        <tr>
                                                            <td class="pageno">
                                                                <?php
									if ($sProjectPrev != ""){
                            print $sProjectPrev . "&nbsp;&nbsp;";
                        }
                          
                        if ((int) $MaxPage < (int) $pageshowend) {
                            $untilpage = (int) $MaxPage;
                        } else {
                            $untilpage = (int) $pageshowend;
                        }

                        if ((int) $untilpage == 0) {
                          $untilpage = 1;
                        }
                      
                        if($MaxPage > 0) echo "Page: ";

                        for ($i = (int) $pageshowstart; $i <= (int) $untilpage; $i++) 
                        {
                            if ($i == $PageNo)
                            {
                                print "<a class=\"selected\" href='?PageNo=". $i. "&amp;pageshowpoint=" . $_GET['pageshowpoint'] . $QureyUrl ."' class='menulink'>".$i."</a> ";
                            }
                            else
                            {
                                print "<a class=\"unselect\" href='?PageNo=" . $i. "&amp;pageshowpoint=" . $_GET['pageshowpoint'] . $QureyUrl ."' class='menulink'>".$i."</a> ";
                            }
                        }
                
                        if ($sProjectNext != "") {
                          print "&nbsp;&nbsp;" . $sProjectNext;
                        }
									?>
                                                            </td>
                                                        </tr>
                                                        <tr><td height="5"></td></tr>
                                                  </table>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            else
                                            { ?>
											<table width="100%" class="grid" cellspacing="0" cellpadding="2">
											<tr>
												<td class="gridheader" align="center" width="40">&nbsp;<b>No.</b>&nbsp;</td>
												<td class="gridheader" align="center" width="160">&nbsp;<b>Username</b>&nbsp;</td>
												<td class="gridheader" align="center" width="201">&nbsp;<b>IP Address</b>&nbsp;</td>
												<td class="gridheader" align="center" width="212">&nbsp;<b>Date / Time In</b>&nbsp;</td>
												<td class="gridheader" align="center" width="212">&nbsp;<b>Date / Time Out</b>&nbsp;</td>
											</tr>
                                            <tr>
												<td align='center' colspan='5'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td>
											</tr>
											</table>
                                         <?php   }
                                            mysql_free_result($result);
                                            mysql_free_result($TRecord);
                                            }
                                            ?>
                                    </table>
                                </td>
                            </tr>
							<tr><td>&nbsp;</td></tr>
                        </table>
						</div>
                    </td>
                </tr>
            </table>
			</div>
        </td>
    </tr>
</table>
</body>
</html>
<?php		
include('../dbclose.php');
}
?>