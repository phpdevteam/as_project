<?
	$sql = "SELECT * FROM ".$tbname."_user ORDER BY _ID LIMIT 1";
    $rst = mysql_query($sql, $connect) or die(mysql_error());
    
	if(mysql_num_rows($rst) > 0){
    	$rs = mysql_fetch_assoc($rst);
		$adminEmail = $rs['_Email'];
		$adminName = replaceSpecialCharBack($rs['_Fullname']);
	}
require_once('phpmailer_v5.1/class.phpmailer.php');	
  $mail = new PHPMailer(true);
  $mail->IsSMTP();
  $mail->Host  = "localhost";
  
  $mail->IsHTML(true);		
  $mail->SMTPKeepAlive = true; 
  $mail->SMTPDebug  = false;
  $mail->AddReplyTo($adminEmail, $adminName);
  $mail->From		= $adminEmail;
  $mail->FromName	= $adminName;
?>