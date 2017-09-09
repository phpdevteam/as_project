<?
session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
		exit();
	}
	include('../global.php');	
	include('../include/functions.php');
	include('access_rights_function.php'); 
	include("fckeditor/fckeditor.php");
	$e_action   = $_REQUEST['e_action'];
	$id         = trim($_REQUEST['id']);
    $PageNo     = $_REQUEST['PageNo'];
    $action12 = $_REQUEST['action12'];
    $venueID  = $_REQUEST['venueID'];

    $DateTime    = date("Y-m-d H:i:s");
    $ProgramCatID = $_REQUEST['ProgramCatID'];
    $ProgramTypeID = $_REQUEST['ProgramTypeID'];
    $programID = $_REQUEST['programID'];
    $schedulardate = datepickerToMySQLDate($_REQUEST['schedulardate']);
    $schedulartimefrom1 = $_REQUEST['schedulartimefrom'];
    $schedulartimeto1 = $_REQUEST['schedulartimeto'];
    $schedulartimefrom = date("h:i", strtotime($schedulartimefrom1));
    $schedulartimeto = date("h:i", strtotime($schedulartimeto1));
    $status = $_REQUEST['status'];
  //  $schedulardate = date("Y-m-d", strtotime($schedulardate1));




  if($action12 == 'delete1')
  {
    $emailString1 = "";
	
	       $cntCheck1 = $_POST["cntCheck1"];
		  for ($i=1; $i<=$cntCheck1; $i++)
		{
			if ($_POST["CustCheckboxq".$i] != "")
			{
				$emailString1 = $emailString1 . "_ID = '" . $_POST["CustCheckboxq".$i] . "' OR ";
			}
        }
        
		$emailString1 = substr($emailString1, 0, strlen($emailString1)-4);
        $str = "UPDATE ".$tbname."_trainingprogramsurcharge SET _Status = 2 WHERE (" . $emailString1 . ") AND _AddedBy ='VO' ";
     
      
		mysql_query($str);

		include('../dbclose.php');
        echo "<script language='JavaScript'>window.location = 'venueschedule.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('2',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($id,$Encrypt)."'</script>";
        exit();
        

  }







  if($e_action == 'addnew')
  {

//Match data validation
      $str4 = "SELECT * FROM ".$tbname."_venueavailableslot WHERE _VenueID = '". replaceSpecialChar($venueID) ."' AND  _Date = '". replaceSpecialChar($schedulardate) ."' AND _StartTime = '". replaceSpecialChar($schedulartimefrom) ."' AND _EndTime = '". replaceSpecialChar($schedulartimeto) ."'";

      $rst4 = mysql_query($str4, $connect) or die(mysql_error());
      if(mysql_num_rows($rst4) > 0)
      {
          include('../dbclose.php');
          echo "<script language='JavaScript'>window.location = 'trainingspace.php?ctab=".encrypt(3,$Encrypt)."&done=".encrypt(4,$Encrypt)."&id=".encrypt($venueID,$Encrypt)."'</script>";
          exit();
      }

//inser data in as_trainersavailableslot  table
          $str = "INSERT INTO ".$tbname."_venueavailableslot 
                  (_VenueID	,_ProgramID,_Date,_StartTime,_EndTime,_Status,_CreatedDateTime,_UpdatedDateTime)
                  VALUES(";
          
          if($venueID != "") $str = $str . "'" . $venueID . "', ";
          else $str = $str . "null, ";
          
          if($programID != "") $str = $str . "'" . $programID . "', ";
          else $str = $str . "null, ";
          
          if($schedulardate != "") $str = $str . "'" . $schedulardate . "', ";
          else $str = $str . "null, ";
          
          if($schedulartimefrom != "") $str = $str . "'" . $schedulartimefrom . "', ";
          else $str = $str . "null, ";
  
          if($schedulartimeto != "") $str = $str . "'" . $schedulartimeto . "', ";
          else $str = $str . "null, ";
  
          if($status != "") $str = $str . "'" . $status . "', ";
          else $str = $str . "null, ";
  
          $str = $str . "'" . date("Y-m-d H:i:s") . "', ";
        
          $str = $str . "'" . date("Y-m-d H:i:s") . "' ";
          
          $str = $str . ") ";
      
          mysql_query('SET NAMES utf8');
  
          
          $result = mysql_query($str) or die(mysql_error().$str);
          if($result==1)
          {
              $venueavailableslotID = mysql_insert_id();
          }


  //check data available or not in as_trainingprogramaggregation table

  $str2 = "SELECT _ID FROM ".$tbname."_trainingprogramaggregation WHERE _ProgramID ='$programID' AND _ProgramDate = '$schedulardate' AND _StartTime = '$schedulartimefrom' AND 
  _EndTime ='$schedulartimeto' AND _VenueID ='0' AND _VenueSchduleID = '0'" ;



$rst2 = mysql_query($str2, $connect) or die(mysql_error());

if(mysql_num_rows($rst2) > 0)
{
        $rs2 = mysql_fetch_assoc($rst2);

        $venueprogramaggID = $rs2['_ID'];

//update table data as_trainingprogramaggregation in _VenueID and _VenueSchduleID

        $str = "UPDATE ".$tbname."_trainingprogramaggregation SET ";

        if($venueID != "") $str = $str . "_VenueID = '" . $venueID . "', ";
        else $str = $str . "_VenueID = null, ";

        if($venueavailableslotID != "") $str = $str . "_VenueSchduleID = '" . $venueavailableslotID . "' ";
        else $str = $str . "_VenueSchduleID = null, ";

        $str = $str . " WHERE _ID = '".$venueprogramaggID."' ";
        
      
        mysql_query('SET NAMES utf8');
        mysql_query($str) or die(mysql_error());        


}else {
    $str = "INSERT INTO ".$tbname."_trainingprogramaggregation 
    (_ProgramID,_VenueID,_VenueSchduleID,_ProgramDate,_StartTime,_EndTime,_TrainingStatus,_Status,_IPAddress,_CreatedDateTime,_UpdatedDateTime)
    VALUES(";

     if($programID != "") $str = $str . "'" . $programID . "', ";
     else $str = $str . "null, ";

     if($venueID != "") $str = $str . "'" . $venueID . "', ";
     else $str = $str . "null, ";

    
     if($venueavailableslotID != "") $str = $str . "'" . $venueavailableslotID . "', ";
     else $str = $str . "null, ";

            
     if($schedulardate != "") $str = $str . "'" . $schedulardate . "', ";
     else $str = $str . "null, ";

                    
     if($schedulartimefrom != "") $str = $str . "'" . $schedulartimefrom . "', ";
     else $str = $str . "null, ";

                   
     if($schedulartimeto != "") $str = $str . "'" . $schedulartimeto . "', ";
     else $str = $str . "null, ";

                         
     $str = $str . "'NotCompleted', ";

     if($status != "") $str = $str . "'" . $status . "', ";
     else $str = $str . "null, ";

     $str = $str . "'" . $_SERVER['REMOTE_ADDR'] . "', ";

     $str = $str . "'" . date("Y-m-d H:i:s") . "', ";
    
      $str = $str . "'" . date("Y-m-d H:i:s") . "' ";
      
      $str = $str . ") ";
  
      mysql_query('SET NAMES utf8');

      
      $result2 = mysql_query($str) or die(mysql_error().$str);

      if($result2==1)
      {
          $venueprogramaggID = mysql_insert_id();
      }

  }
  $surchageitem_array = $_REQUEST['surchageitem'];
  $itemamount_array = $_REQUEST['itemamount'];

//add value in as_trainingprogramsurcharge table

 for ($i = 0; $i < count($_REQUEST['surchageitem']); $i++) {
    
 $str = "INSERT INTO ".$tbname."_trainingprogramsurcharge(_ProgramaggregationID,_AddedBy,_SurchargeItemID,_Amount,_IPAddress,_Status,_CreatedDateTime,_UpdatedDateTime) VALUES (";

        if($venueprogramaggID != "") $str = $str . "'" . $venueprogramaggID . "', ";
        else $str = $str . "null, ";

        $str = $str . "'VO', ";

        if($_REQUEST['surchageitem'][$i] != "") $str = $str . "'" . $_REQUEST['surchageitem'][$i] . "', ";
        else $str = $str . "null, ";

        if($_REQUEST['itemamount'][$i] != "") $str = $str . "'" . $_REQUEST['itemamount'][$i] . "', ";
        else $str = $str . "null, ";
    
        $str = $str . "'" . $_SERVER['REMOTE_ADDR'] . "', ";

        if($status != "") $str = $str . "'" . $status . "', ";
        else $str = $str . "null, ";

        $str = $str . "'" . date("Y-m-d H:i:s") . "', ";
    
        $str = $str . "'" . date("Y-m-d H:i:s") . "' ";
        
        $str = $str . ") ";
    
        mysql_query('SET NAMES utf8');

        $result3 = mysql_query($str) or die(mysql_error().$str);

  }

  if($result3==1)
  {
      $venueprogramsurchargeID = mysql_insert_id();
  }



// select amount in program table
$str3 = "SELECT _TotalAmount FROM ".$tbname."_trainingprogram WHERE _ID = '$programID'";
$rst3 = mysql_query($str3, $connect) or die(mysql_error());
if(mysql_num_rows($rst3) > 0)
{
    $rs3 = mysql_fetch_assoc($rst3);
    $programamounttotal = $rs3['_TotalAmount'];
    
    }

    $str3 = "SELECT SUM(_Amount) as totalamount FROM ".$tbname."_trainingprogramsurcharge WHERE _ProgramaggregationID = '$venueprogramaggID' AND _Status='1'";
    $rst3 = mysql_query($str3, $connect) or die(mysql_error());
    if(mysql_num_rows($rst3) > 0)
    {
        $rs3 = mysql_fetch_assoc($rst3);
        $trainingprogramsurcharge = $rs3['totalamount'];
        
        }



//$itemamount_array  = $_REQUEST['itemamount'];


//$trainingprogramsurcharge =  array_sum($itemamount_array);

$proaggrandtotal = $trainingprogramsurcharge + $programamounttotal;

//update total value in as_trainingprogramaggregation table
$str = "UPDATE ".$tbname."_trainingprogramaggregation SET ";

if($proaggrandtotal != "") $str = $str . "_TotalAmount = '" . $proaggrandtotal . "' ";
else $str = $str . "_TotalAmount = null ";

$str = $str . " WHERE _ID = '".$venueprogramaggID."' ";

mysql_query('SET NAMES utf8');
mysql_query($str) or die(mysql_error());   



 include('../dbclose.php');
 echo "<script language='JavaScript'>window.location = 'venueschedule.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('1',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($venueavailableslotID,$Encrypt)."'</script>";
 exit();
 
 }else if($e_action == 'edit')
 {
 
      //Match data validation
      $str = "SELECT * FROM ".$tbname."_venueavailableslot WHERE _VenueID = '". replaceSpecialChar($venueID) ."' AND  _Date = '". replaceSpecialChar($schedulardate) ."' AND _StartTime = '". replaceSpecialChar($schedulartimefrom) ."' AND _EndTime = '". replaceSpecialChar($schedulartimeto) ." ' AND  _ID <> '". $id ."' ";
 
         $rst = mysql_query($str, $connect) or die(mysql_error());
         if(mysql_num_rows($rst) > 0)
         {
             include('../dbclose.php');
             echo "<script language='JavaScript'>window.location = 'trainingspace.php?ctab=".encrypt(3,$Encrypt)."&done=".encrypt(4,$Encrypt)."&id=".encrypt($venueID,$Encrypt)."'</script>";
             exit();
         }
 //update table as_trainersavailableslot
 
     $str = "UPDATE ".$tbname."_venueavailableslot SET ";
 
         if($programID != "") $str = $str . "_ProgramID = '" . $programID . "' ,";
         else $str = $str . "_ProgramID = null ,";
         
         if($schedulardate != "") $str = $str . "_Date = '" . $schedulardate . "' ,";
         else $str = $str . "_Date = null ,";
 
         if($schedulartimefrom != "") $str = $str . "_StartTime = '" . $schedulartimefrom . "' ,";
         else $str = $str . "_StartTime = null ,";
 
         if($schedulartimeto != "") $str = $str . "_EndTime = '" . $schedulartimeto . "' ,";
         else $str = $str . "_EndTime = null ,";
 
         if($status != "") $str = $str . "_Status = '" . $status . "' ,";
         else $str = $str . "_Status = null ,";
 
         $str = $str . "_UpdatedDateTime = '" . date("Y-m-d H:i:s") . "' ";
         
         $str = $str . " WHERE _ID = '".$id."' ";
         
             mysql_query('SET NAMES utf8');
             mysql_query($str) or die(mysql_error());    
 


  //check data available or not in as_trainingprogramaggregation table

  $str2 = "SELECT _ID FROM ".$tbname."_trainingprogramaggregation WHERE _ProgramID ='$programID' AND _ProgramDate = '$schedulardate' AND _StartTime = '$schedulartimefrom' AND 
  _EndTime ='$schedulartimeto' AND _VenueID ='0' AND _VenueSchduleID = '0'" ;



$rst2 = mysql_query($str2, $connect) or die(mysql_error());

if(mysql_num_rows($rst2) > 0)
{
        $rs2 = mysql_fetch_assoc($rst2);

        $venueprogramaggID = $rs2['_ID'];


//update table data as_trainingprogramaggregation in _VenueID and _VenueSchduleID

$str = "UPDATE ".$tbname."_trainingprogramaggregation SET ";

        if($venueID != "") $str = $str . "_VenueID = '" . $venueID . "', ";
        else $str = $str . "_VenueID = null, ";

        if($id != "") $str = $str . "_VenueSchduleID = '" . $id . "' ";
        else $str = $str . "_VenueSchduleID = null, ";

        $str = $str . " WHERE _ID = '".$venueprogramaggID."' ";
        
      
        mysql_query('SET NAMES utf8');
        mysql_query($str) or die(mysql_error()); 
           

        $sql = "DELETE  FROM ".$tbname."_trainingprogramsurcharge WHERE _ProgramaggregationID = '".$venueprogramaggID."' AND _AddedBy = 'VO'";
        
                   
           mysql_query('SET NAMES utf8');
           mysql_query($sql) or die(mysql_error());  
           
           
           $surchageitem_array = $_REQUEST['surchageitem'];
           $itemamount_array = $_REQUEST['itemamount'];
     
           //add value in as_trainingprogramsurcharge table
           
               for ($i = 0; $i < count($_REQUEST['surchageitem']); $i++) {
         
                 $str = "INSERT INTO ".$tbname."_trainingprogramsurcharge(_ProgramaggregationID,_AddedBy,_SurchargeItemID,_Amount,_IPAddress,_Status,_CreatedDateTime,_UpdatedDateTime) VALUES (";
         
                 if($venueprogramaggID != "") $str = $str . "'" . $venueprogramaggID . "', ";
                 else $str = $str . "null, ";
     
                 $str = $str . "'VO', ";
     
                 if($_REQUEST['surchageitem'][$i] != "") $str = $str . "'" . $_REQUEST['surchageitem'][$i] . "', ";
                 else $str = $str . "null, ";
     
                 if($_REQUEST['itemamount'][$i] != "") $str = $str . "'" . $_REQUEST['itemamount'][$i] . "', ";
                 else $str = $str . "null, ";
             
                 $str = $str . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
     
         
                 if($status != "") $str = $str . "'" . $status . "', ";
                 else $str = $str . "null, ";
     
                 $str = $str . "'" . date("Y-m-d H:i:s") . "', ";
             
                 $str = $str . "'" . date("Y-m-d H:i:s") . "' ";
                 
                 $str = $str . ") ";
            

              
                 mysql_query('SET NAMES utf8');
     
                 $result3 = mysql_query($str) or die(mysql_error().$str);
   
                }    

}else {
    
    //fetch id value old schedular 
                $str3 = "SELECT _ID,_TrainerID FROM ".$tbname."_trainingprogramaggregation WHERE _VenueID	 ='$venueID' AND _VenueSchduleID ='$id'";
                $rst3 = mysql_query($str3, $connect) or die(mysql_error());
                if(mysql_num_rows($rst3) > 0)
                {
                    while($rs3 = mysql_fetch_assoc($rst3))
                    {
                        $aggremovID1 = $rs3['_ID'];
                        $TrainerID11 = $rs3['_TrainerID'];
    
                    }
                }
    
                if($TrainerID11=='0')
                {
    
                    $sql = "DELETE  FROM ".$tbname."_trainingprogramaggregation WHERE _ID = '".$aggremovID1."' ";
                    mysql_query('SET NAMES utf8');
                    mysql_query($sql) or die(mysql_error());  
        
                }
                else{
    
                
    //update trainer id and trainerschduleID null
                $str = "UPDATE ".$tbname."_trainingprogramaggregation SET ";
                
                $str = $str . "_VenueID = 'null ' ,";
                $str = $str . "_VenueSchduleID = 'null', ";
             
    
                $str = $str . " WHERE _ID = '".$aggremovID1."' ";
    
    
                mysql_query('SET NAMES utf8');
                mysql_query($str) or die(mysql_error());  
    
                }
    
    //delete old record and add new record
                $sql = "DELETE  FROM ".$tbname."_trainingprogramsurcharge WHERE _ProgramaggregationID = '".$aggremovID1."' AND _AddedBy = 'VO'";
    
                
                mysql_query('SET NAMES utf8');
                mysql_query($sql) or die(mysql_error());  
    
    //insert data in as_trainingprogramaggregation
    
                $str = "INSERT INTO ".$tbname."_trainingprogramaggregation 
                (_ProgramID,_VenueID,_VenueSchduleID,_ProgramDate,_StartTime,_EndTime,_TrainingStatus,_Status,_IPAddress,_CreatedDateTime,_UpdatedDateTime)
                VALUES(";
    
                if($programID != "") $str = $str . "'" . $programID . "', ";
                else $str = $str . "null, ";
    
                if($venueID != "") $str = $str . "'" . $venueID . "', ";
                else $str = $str . "null, ";
                
                if($id != "") $str = $str . "'" . $id . "', ";
                else $str = $str . "null, ";
                    
                if($schedulardate != "") $str = $str . "'" . $schedulardate . "', ";
                else $str = $str . "null, ";
                            
                if($schedulartimefrom != "") $str = $str . "'" . $schedulartimefrom . "', ";
                else $str = $str . "null, ";
                            
                if($schedulartimeto != "") $str = $str . "'" . $schedulartimeto . "', ";
                else $str = $str . "null, ";
                                
                $str = $str . "'NotCompleted', ";
    
                if($status != "") $str = $str . "'" . $status . "', ";
                else $str = $str . "null, ";
    
                $str = $str . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
    
                $str = $str . "'" . date("Y-m-d H:i:s") . "', ";
                
                $str = $str . "'" . date("Y-m-d H:i:s") . "' ";
                
                $str = $str . ") ";
            
                mysql_query('SET NAMES utf8');
    
                
                $result3 = mysql_query($str) or die(mysql_error().$str);
    
                if($result3==1)
                {
                    $venueprogramaggID = mysql_insert_id();
                }
    
    
                $surchageitem_array = $_REQUEST['surchageitem'];
                $itemamount_array = $_REQUEST['itemamount'];
    
                //add value in as_trainingprogramsurcharge table
    
                for ($i = 0; $i < count($_REQUEST['surchageitem']); $i++) {
    
                $str = "INSERT INTO ".$tbname."_trainingprogramsurcharge(_ProgramaggregationID,_AddedBy,_SurchargeItemID,_Amount,_IPAddress,_Status,_CreatedDateTime,_UpdatedDateTime) VALUES (";
    
                if($venueprogramaggID != "") $str = $str . "'" . $venueprogramaggID . "', ";
                else $str = $str . "null, ";
    
                $str = $str . "'VO', ";
    
                if($_REQUEST['surchageitem'][$i] != "") $str = $str . "'" . $_REQUEST['surchageitem'][$i] . "', ";
                else $str = $str . "null, ";
    
                if($_REQUEST['itemamount'][$i] != "") $str = $str . "'" . $_REQUEST['itemamount'][$i] . "', ";
                else $str = $str . "null, ";
            
                $str = $str . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
    
    
                if($status != "") $str = $str . "'" . $status . "', ";
                else $str = $str . "null, ";
    
                $str = $str . "'" . date("Y-m-d H:i:s") . "', ";
            
                $str = $str . "'" . date("Y-m-d H:i:s") . "' ";
                
                $str = $str . ") ";
        
                mysql_query('SET NAMES utf8');
    
                $result3 = mysql_query($str) or die(mysql_error().$str);
    
                }   
    
    
    }
// select amount in program table
$str3 = "SELECT _TotalAmount FROM ".$tbname."_trainingprogram WHERE _ID = '$programID'";
$rst3 = mysql_query($str3, $connect) or die(mysql_error());
if(mysql_num_rows($rst3) > 0)
{
    $rs3 = mysql_fetch_assoc($rst3);
    $programamounttotal = $rs3['_TotalAmount'];
    
    }

    $str3 = "SELECT SUM(_Amount) as totalamount FROM ".$tbname."_trainingprogramsurcharge WHERE _ProgramaggregationID = '$venueprogramaggID'  AND _Status='1'";
    $rst3 = mysql_query($str3, $connect) or die(mysql_error());
    if(mysql_num_rows($rst3) > 0)
    {
        $rs3 = mysql_fetch_assoc($rst3);
        $trainingprogramsurcharge = $rs3['totalamount'];
        
        }



//$itemamount_array  = $_REQUEST['itemamount'];


//$trainingprogramsurcharge =  array_sum($itemamount_array);

$proaggrandtotal = $trainingprogramsurcharge + $programamounttotal;

//update total value in as_trainingprogramaggregation table
$str = "UPDATE ".$tbname."_trainingprogramaggregation SET ";

if($proaggrandtotal != "") $str = $str . "_TotalAmount = '" . $proaggrandtotal . "' ";
else $str = $str . "_TotalAmount = null ";

$str = $str . " WHERE _ID = '".$venueprogramaggID."' ";

mysql_query('SET NAMES utf8');
mysql_query($str) or die(mysql_error());   


include('../dbclose.php');
echo "<script language='JavaScript'>window.location = 'venueschedule.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('1',$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&id=".encrypt($id,$Encrypt)."'</script>";
exit();

 }else if($e_action == 'delete')
        {	
        
            $id3         = trim($_GET['id']);
            $emailString1 = "";
        
            $cntCheck = $_POST["cntCheck"];
            
            for ($i=1; $i<=$cntCheck; $i++)
            {
                if ($_POST["CustCheckbox".$i] != "")
                {
                    $emailString1 = $emailString1 . "_ID = '" . $_POST["CustCheckbox".$i] . "' OR ";
               
                }
            }
        
            $emailString1 = substr($emailString1, 0, strlen($emailString1)-4);
           
            $str = "UPDATE ".$tbname."_venueavailableslot SET _Status = 2 WHERE (" . $emailString1 . ") ";

        
            mysql_query($str);
            
            //capture action into audit log database
            $strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
            $strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
            $strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
            $strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
            $strSQL = $strSQL . "'Delete Venue Schedule', ";
            
            if ($emailString != "") $strSQL = $strSQL . "'" . replaceSpecialChar($emailString) . "' ";
            else $strSQL = $strSQL . "null ";
        
            $strSQL = $strSQL . ")";
            mysql_query('SET NAMES utf8');
            mysql_query($strSQL);
            //capture action into audit log database
            
            include('../dbclose.php');
            echo "<script language='JavaScript'>window.location = 'trainingspace.php?ctab=".encrypt(3,$Encrypt)."&done=".encrypt('3',$Encrypt)."&id=".encrypt($venueID,$Encrypt)."'</script>";
            exit();
        }
        
        























    
 ?>