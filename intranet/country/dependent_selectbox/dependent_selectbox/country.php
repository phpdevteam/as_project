
<?php
include('db_config.php');
$sql= "select * from as_trainingtype";

$query = $db->query($sql);
//$data = $query->fetch_assoc();

?>

<label>Country</label>
<select name="counntry" id="country" class="dropdown" onchange="change_country();">
<option value="">Select Country</option>
<?php while($row = $query->fetch_assoc()) { ?>
	<option value="<?php echo $row['_ID']; ?>"><?php echo $row['_TypeName']; ?> </option>
<?php } ?>
</select>

<span class="space"></span>
<label>State</label>
<select name="state" id="state" class="dropdown">
<option value="">Select State</option>

</select>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script>
function change_country()
{
	var country = $("#country").val();
	
	   $.ajax({
		type: "POST",
		url: "state.php",
		data: "country="+country,
		cache: false,
		success: function(response)
			{
					//alert(response);return false;
				$("#state").html(response);
			}
			});
	
}
</script>




