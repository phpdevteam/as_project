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

$Operations = GetAccessRights(61);
if(count($Operations)== 0)
{
    echo "<script language='javascript'>history.back();</script>";
}	

 $SQOperations = GetAccessRights(71);
    
$currentmenu = "Program";

$btnSubmit = "Submit";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dynamic Dropdown in PHP, MySql, Ajax & jQuery</title>
<script type="text/javascript" src="jquery-1.4.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$("#loding1").hide();
	$("#loding2").hide();
	$(".country").change(function()
	{
		$("#loding1").show();
		var id=$(this).val();
		var dataString = 'id='+ id;
		$(".state").find('option').remove();
		$(".city").find('option').remove();
		$.ajax
		({
			type: "POST",
			url: "get_state.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$("#loding1").hide();
				$(".state").html(html);
			} 
		});
	});
	
	
	$(".state").change(function()
	{
		$("#loding2").show();
		var id=$(this).val();
		var dataString = 'id='+ id;
	
		$.ajax
		({
			type: "POST",
			url: "get_city.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$("#loding2").hide();
				$(".city").html(html);
			} 
		});
	});
	
});
</script>
<style>
*{margin:0;padding:0;}
#main-container
{
	margin:50px auto;
	padding:15px;
	border:solid #cdcdcd 1px;
	width:500px;
	background:#f9f9f9;
}
table,td
{
	font-family:Verdana, Geneva, sans-serif;
	width:100%;
	border-collapse:collapse;
	padding:10px;
}
input
{
	width:100%;
	height:35px;
	text-align:left;
	padding-left:10px;
	border:solid #cddcdc 2px;
	font-family:Verdana, Geneva, sans-serif;
	border-radius:3px;
}
button
{
	text-align:center;
	width:48%;
	height:35px;
	border:0;
	font-family:Verdana, Geneva, sans-serif;
	border-radius:3px;
	background:#364956;
	color:#fff;
	font-weight:bolder;
	font-size:18px;
	border-radius:10px;
}
hr
{
	border:solid #cecece 1px;
}
#header
{
	width:100%;
	height:50px;
	background:#364956;
	text-align:center;
}
#header h1
{
	font-family:Verdana, Geneva, sans-serif;
	font-size:18px;
	color:#f9f9f9;
	padding-top:10px;
}
a{
	font-family:Verdana, Geneva, sans-serif;
	color:#364956;
	text-decoration:none;
}

label
{
	font-weight:bold;
	padding:10px;
}
select
{
	width:200px;
	height:35px;
	border:2px solid #456879;
	border-radius:10px;
}

.color {
	color:green;
}

.link {
	color:red;
}
</style>
</head>

<body>
<div id="header">
	<h1>StepBlogging.com - Dynamic Dropdown in PHP, MySql ,Ajax & jQuery</h1>
</div>
<br /><br />
<center><a href="http://www.stepblogging.com/country-state-city-dropdown-using-php-mysql-ajax" target='_blank' title='Country State City Dropdown Using PHP, MySQL & Ajax'>Tutorial Link</a></center>

<div id="main-container">
<label>Country :</label> 
<select name="country" class="country">
<option selected="selected">--Select Country--</option>
<?php

$str = "SELECT _ID,_ProgramCatName FROM ".$tbname."_trainingprogramcat";
$rst = mysql_query($str, $connect) or die(mysql_error());

//Count total number of rows
$rowCount = mysql_num_rows($rst) ;


	while($row= mysql_fetch_assoc($rst))
	{
		?>
        <option value="<?php echo $row['_ID']; ?>"><?php echo $row['_ProgramCatName']; ?></option>
        <?php
	} 
?>
</select>
<br><br><br>
<label>State :</label> <select name="state" class="state">
<option selected="selected">--Select State--</option>
</select>
<img src="ajax-loader.gif" id="loding1"></img>
<br><br><br>
<label>City :</label> <select name="city" class="city">
<option selected="selected">--Select City--</option>
</select>
<img src="ajax-loader.gif" id="loding2"></img>
<br><br><br>
</div>
</body>
</html>
