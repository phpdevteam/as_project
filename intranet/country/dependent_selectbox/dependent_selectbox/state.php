<?php
include('db_config.php');
$country = $_POST['country'];
$sql= "select * from as_trainingsubtype where _TypeID='$country'";

$query = $db->query($sql);
echo '<option value="">Select State</option>';
while($res = $query->fetch_assoc()){
echo '<option value="'.$res['_SubTypeName'].'">'.$res['_SubTypeName'].'</option>';
	
}
?>