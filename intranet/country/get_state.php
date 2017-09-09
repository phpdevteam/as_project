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
	
	
	
$str1 = "SELECT * FROM ".$tbname."_trainingsubtype WHERE _TypeID = $id ";

$rst1 = mysql_query($str1, $connect) or die(mysql_error());



	?><option selected="selected">Select State :</option><?php
	while($row1=mysql_fetch_assoc($rst1))
	{
		?>
        	<option value="<?php echo $row1['_ID']; ?>"><?php echo $row1['_SubTypeName']; ?></option>
        <?php
	}
}
?>



   