<?


session_start();
	include('../global.php');	
	include('../include/functions.php');
	
	$e_action = $_REQUEST['e_action'];

	$q12 = $_GET['e_action12'];
	echo $q12;


	if($e_action == 'getSubtype')
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

















	
	include('../dbclose.php');
?>