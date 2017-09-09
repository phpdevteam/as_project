<?


$fields = array();
$attfile = array();
$str = "Show columns From ".$tbname."_files  Where Field <> '_id' ";

$result = mysql_query($str) or die(mysql_error() . $str);

while($row = mysql_fetch_assoc($result)) {
   $fields[] = $row['Field'];
}

$attFiles = $_FILES["attFile"];
// echo count($attFiles["name"]);

for($i=0;$i<count($attFiles["name"]);$i++)
{
	$attfile['_pageid'] = $_pageid;
	$attfile['_type'] = $_type;
	$FileName = "";
	
	if ($attFiles["size"][$i] > 0)
	{
		
		if ($attFiles["error"][$i] > 0)
		{
			
			echo "Return Code: " . $attFiles["error"][$i] . "<br />";
		}
		else
		{
			
			$OriginalFileName = $attFiles["name"][$i];
			$splitfilename = strtolower($attFiles["name"][$i]) ; 
			$exts = explode(".", $splitfilename) ; 
			$n = count($exts)-1; 
			$exts = $exts[$n]; 
			$datetime = date("YmdHis") . generateNumStr(4);

			$FileName = "";
			$FileName = $datetime . "." . $exts;

			if (file_exists($AdminTopCMSImagesPath . $FileName))
			{
				echo $FileName . " already exists. ";
			}
			else
			{

				  $attFiles['tmp_name'][$i];

			
				  move_uploaded_file( $attFiles['tmp_name'][$i] , $AdminTopCMSImagesPath . $FileName );
				  chmod($AdminTopCMSImagesPath . $FileName, 0777);
				
			}
		}
	}
	 
	  
	$attfile['_file'] = $FileName;
	
	if($FileName != "")
	{
		$values = array();
		foreach ($fields as $field) {
			$value = $attfile[$field];
			$values[] = $value===null ? 'null' : "'".replaceSpecialChar($value)."'";
		}
	
		$str = "INSERT INTO ".$tbname."_files(".implode(',', $fields).") VALUES (".implode(',', $values).")";
 
		mysql_query($str) or die(mysql_error() . $str);

	}
}


/*$OriginalFileName = $ImageName["name"][0];
$splitfilename = strtolower($ImageName["name"][0]) ; 
$exts = explode(".", $splitfilename) ; 
$n = count($exts)-1; 
$exts = $exts[$n]; 
$datetime = date("YmdHis") . generateNumStr(4);





		$FileName = "";
		$FileName = $datetime . "." . $exts;

		$attFiles['tmp_name'][$i];
		move_uploaded_file( $ImageName['tmp_name'][0] , $AdminTopCMSImagesPath . $FileName );
		chmod($AdminTopCMSImagesPath . $FileName, 0777);*/




?>