<?php
include('dbconfig.php');
if($_POST['id'])
{
	$id=$_POST['id'];
	
	$stmt = $DB_con->prepare("SELECT * FROM  as_trainingsubsubtype  WHERE _SubTypeID=:id");
	$stmt->execute(array(':id' => $id));
	?><option selected="selected">Select City :</option>
	<?php while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		?>
		<option value="<?php echo $row['_ID']; ?>"><?php echo $row['_SubSubTypeName']; ?></option>
		<?php
	}
}
?>