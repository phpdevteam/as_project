<?php	
if (date("H") < 12)
{
$greet = "Good Morning";
}
elseif (date("H") >= 12 && date("H")  < 18)
{
$greet = "Good Afternoon";
}
else
{
$greet = "Good Evening";
} 
?>

<table width="970" border="0" cellpadding="0" cellspacing="0" >
<tr>    
    <td valign="middle">
        <table width="970" border="0" cellspacing="0" cellpadding="0" align="center" >
            <tr>
			<td>		
				<div style="width:970px">
					<?php include('top.php'); ?>
				</div>
			</td>
		<?php 
		$tempTitleName="Networkz";
		if(isset($_SESSION['tname'])&& trim(($_SESSION['tname'])))
		{
		$tempTitleName=$greet." ".$_SESSION['name'].", Welcome to Networkz Singapore";
		}
		
		?>
			</tr>
			
		</table>
    </td>
</tr>	
</table>
<script type="text/javascript">
window.document.title="<?php echo $tempTitleName?>";
window.status="<?php echo $tempTitleName?>";
</script>

