<?
	function GetAccessRights($MenuID){
		
		include('../global.php');

		$Operations = array();

		$query = "SELECT * FROM ".$tbname."_accessright
				WHERE _MID = '".$MenuID."'
				AND _UserID = '".$_SESSION["levelid"]."'";

		$row = mysql_query($query,$connect)or die(mysql_error());
		$data = mysql_fetch_assoc($row);

		if(mysql_num_rows($row)>0){	
		
		    $mystr = "Select _Title From ".$tbname."_menu 
			Where _ID = '". $MenuID ."'";
			
			$myrst = mysql_query($mystr);	
			$mydata = mysql_fetch_assoc($myrst);
		    array_push($Operations, $mydata["_Title"]);		
			
			$mystr = "Select _Title From ".$tbname."_menu m INNER JOIN ".$tbname."_accessright a ON a._MID = m._ID  
			Where m._PID = '". $MenuID ."' AND a._UserID = '".$_SESSION["levelid"]."' ";
				
			$myrst = mysql_query($mystr);
			
			while($mydata = mysql_fetch_assoc($myrst)){
				array_push($Operations, $mydata["_Title"]);
			}
		}

		return $Operations;
	}
	
		
?>