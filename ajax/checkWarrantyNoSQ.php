<?php
session_start();
include('../global.php');	
include('../include/functions.php');

$warrantyNo = $_REQUEST["wno"];
	$id = $_REQUEST["id"];
		$isTemp = $_REQUEST["isTemp"];
		

	
	
	if($id == "")
	{
		
				$str = "SELECT * FROM ".$tbname."_salesquotationitemsdraft WHERE _warrantyno = '". replaceSpecialChar($warrantyNo) ."' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
	if(mysql_num_rows($rst) > 0)
	{
		echo "Exist";
		exit();
	}
		
		
			$str = "SELECT * FROM ".$tbname."_salesquotationitems WHERE _warrantyno = '". replaceSpecialChar($warrantyNo) ."' ";
				$rst = mysql_query($str, $connect) or die(mysql_error());
			if(mysql_num_rows($rst) > 0)
			{
				echo "Exist";
				exit();
			}
	
	}
	
	
	else
	{
		
		
		
		if($isTemp == "1")
				{					
						$str = "SELECT * FROM ".$tbname."_salesquotationitemsdraft WHERE _warrantyno = '". replaceSpecialChar($warrantyNo) ."' and _id <> '". $id ."' ";
							
								$rst = mysql_query($str, $connect) or die(mysql_error());
							if(mysql_num_rows($rst) > 0)
							{
								echo "Exist";
								exit();
							}							
							
							$str = "SELECT * FROM ".$tbname."_salesquotationitems WHERE _warrantyno = '". replaceSpecialChar($warrantyNo) ."' ";
							$rst = mysql_query($str, $connect) or die(mysql_error());
						if(mysql_num_rows($rst) > 0)
						{
							echo "Exist";
							exit();
						}
				}
				else
				{
	
			$str = "SELECT * FROM ".$tbname."_salesquotationitems WHERE _warrantyno = '". replaceSpecialChar($warrantyNo) ."' and _id <> '". $id ."' ";
				$rst = mysql_query($str, $connect) or die(mysql_error());
			if(mysql_num_rows($rst) > 0)
			{
				echo "Exist";
				exit();
			}
			
			
					$str = "SELECT * FROM ".$tbname."_salesquotationitemsdraft WHERE _warrantyno = '". replaceSpecialChar($warrantyNo) ."' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
					if(mysql_num_rows($rst) > 0)
					{
						echo "Exist";
						exit();
					}
	
			}
	
	}
	
	

?>