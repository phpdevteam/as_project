<?php

session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']=="")
{
    echo "<script language='javascript'>window.location='login.php';</script>";
    exit();
}
include('../global.php');	
include('../include/functions.php');include('access_rights_function.php'); 
include("fckeditor/fckeditor.php");


if($_POST['id'])
{
	$id=$_POST['id'];

	
	$str = "SELECT * FROM ".$tbname."_trainingsubsubtype WHERE _SubTypeID = $id  AND _Status=1";
	
	$rst = mysql_query($str, $connect) or die(mysql_error());


	?><option selected="selected">Select One :</option>
	<?php while($row=mysql_fetch_assoc($rst))
	{
		?>
		<option value="<?php echo $row['_ID']; ?>"><?php echo $row['_SubSubTypeName']; ?></option>
		<?php
	}
}
?>