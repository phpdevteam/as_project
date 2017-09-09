
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


$programtype = $_POST['programtype'];

$programsubtype = $_POST['programsubtype'];

$programsubsubtype = $_POST['programsubsubtype'];


$sql= "select * from as_trainingcharges where _TrainingTypeID='$programtype' AND _TrainingSubTypeID='$programsubtype' AND _TrainingSubSubTypeID='$programsubsubtype' ";


$res = mysql_query($sql) or die(mysql_error());

while($res1 = mysql_fetch_array($res)){


    $id = $res1['_ID'];
   
}

$sql="SELECT * FROM  as_trainingchargesdetails  WHERE _TrainingChargesID = '".$id."'  and _Status=1";

$result = mysql_query($sql);

 $total= mysql_num_rows($result);


echo "<table class='grid' style='text-align:center;width:420px;'>
<input type='hidden' name='total12' id ='total12' value='$total'>
   
<tr>
<th class='gridheader'style='width:20px;'><input name='AllCheckbox' id='AllCheckbox' type='checkbox'  tabindex=''class='check_all' value='All'  onclick='select_all()' onclick='CheckUnChecked('FormName','CustCheckboxq',document.FormName.cntCheck1.value,this,'$colCount');' /></th>
<th class='gridheader' style='text-align:center;width:20px;'>S/No</th>
<th class='gridheader' style='width:20px;'>Minimum</th>
<th class='gridheader' style='width:20px;'>Maximum</th>
<th class='gridheader' style='width:20px;'>Price</th>
<th class='gridheader' style='width:20px;'>NSMAN price</th>
</tr>";
$i=1;
while($row = mysql_fetch_array($result))
  {
     $minimum = $row['_MinPerson'] ;
     $maximum = $row['_MaxPerson'] ;
     $price = $row['_TotalCost'] ;
     $nsmanprice = $row['_NSManTotal'] ;

  echo "<tr>";
  echo "<td class='gridline2'><input type='checkbox' class='case'  name='AllCheckbox1' id='AllCheckbox1' value='All' onclick='CheckUnChecked('FormName0','CustCheckboxq',document.FormName0.cntCheck1.value,this,'$colCount');'  /></td>";
  echo "<td class='gridline2' style='width:30px;'>" . $i. "</td>";
  echo "<td  class='gridline2'><input type='text' id='minimum' name='minimum[]' value=$minimum  onkeypress='return isNumber(event)' style='width:90px'/>". "</td>";
  echo "<td  class='gridline2'><input type='text' id='maximum' name='maximum[]' value=$maximum  onkeypress='return isNumber(event)' style='width:90px'/>". "</td>";
  echo "<td  class='gridline2'><input type='text' id='price' name='price[]' value=$price  onkeypress='return isNumber(event)' style='width:90px'/>". "</td>";
  echo "<td  class='gridline2'><input type='text' id='nsmanprice' name='nsmanprice[]' value=$nsmanprice  onkeypress='return isNumber(event)' style='width:90px'/>". "</td>";

  echo "</tr>";
  $i++;}
echo "</table>";


?>
</form>