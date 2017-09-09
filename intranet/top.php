<script src="../js/adminmenubar.js" type="text/javascript"></script>
<?php	
include('../global.php');
$flag=0;

?>
<!--<div class="h_blue" id="border-top">
		<div class="h_blue" style="height: 58px; width: 970px;" id="border-top">-->
		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
    	<!--<tr>
		<td align="left"><img style="width: 46%;margin-left: 3%;"src="uploadfiles/logo.jpg"></td>
      	<td align="right" style="padding-right:12px;" valign="bottom" class="Twelve_Blackfont_bold"><span style="padding-bottom:5px; float:right;">&nbsp;<b><?php echo $greet; ?>&nbsp;<i><?php echo $_SESSION['tname']; ?></i>, Welcome to <?=$projectname?> Intranet Admin Site.</b></span></td>
		</tr>
      <tr>
			<td align="left"></td>
        <td align="right" valign="bottom" class="Twelve_Blackfont_bold"><span style="padding-bottom:5px; float:right;">&nbsp;
        &nbsp;<b><?php echo date("j M Y g:i:s A"); ?></b>&nbsp;&nbsp;&nbsp;&nbsp;</span>
        </td>
       </tr>
      <tr>
        <td align="right" style="padding-right:12px;" colspan="2"><span style="padding-bottom:10px;">&nbsp;
			  	<a class="Twelve_Blackfont_bold" href="userprofile.php">My Profile</a>
			  	&nbsp;|&nbsp;
			  	<a class="Twelve_Blackfont_bold" href="logout.php">Logout</a>
			  	</span>
				</td>
      </tr>-->
	  <tr>
			<td align="left" rowspan="6"> 
				<span style="display: inline-block;min-height: 60px;">
					<img style="margin-top: 2px;margin-left: 2px;width: 173px;" src="uploadfiles/logo.png"/>
				</span>
			</td>
		</tr>
		<tr>
			<td align="right" style="height:2px;" valign="bottom" class="Twelve_Blackfont_bold"></td>
		</tr>
		<tr>
			<td align="right" style="height:2px;" valign="bottom" class="Twelve_Blackfont_bold"></td>
		</tr>
		<tr>
			<td align="right"  valign="bottom" class="Twelve_Blackfont_bold"><span style="">&nbsp;<b><?php echo $greet; ?>&nbsp;<i><?php echo $_SESSION['tname']; ?></i>, Welcome to <?=$projectname?> Admin Site.</b></span></td>
		</tr>
		<tr>
			<td align="right" valign="bottom" class="Twelve_Blackfont_bold">
			<span ><b><?php echo date("j M Y g:i:s A"); ?></b></span>
			</td>
       </tr>
		<tr>
			<td align="right" valign="bottom" colspan="2"><span >&nbsp;
			  	<a class="Twelve_Blackfont_bold" href="userprofile.php">My Profile</a>
			  	&nbsp;|&nbsp;
			  	<a class="Twelve_Blackfont_bold" href="logout.php">Logout</a>
			  	</span>
			</td>
		</tr>
		</table>
		
<!--</div>-->
<div class="clr"></div>
<div id="header-box">
	<div id="module-status">
		<div id="module-status">
			
		</div>
	</div>
    <div class="clr"></div>
	<div id="module-menu">
		
		<div>
			<ul id="menu">
				<?php
		
				$mystr = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = 0 AND _Title <> 'Log Out' AND _Title <> 'My Profile'  AND _UserID = '" . $_SESSION['levelid'] . "'  And _Operation = '' ORDER BY _Order ASC ";
				
				$myresult = mysql_query($mystr, $connect) or die(mysql_error());
				
				$i = 1;
				$mycount = mysql_num_rows($myresult);
				
				if($mycount > 0)
				{
					while($myrow = mysql_fetch_assoc($myresult))
					{
					?>
					<li>
						<a <?if($myrow["_PageName"]!="No"){ ?> href="<?=$myrow["_PageName"]; ?>" <?}?> >
						<?=$myrow["_Title"]; ?>
						</a>
					<?php
						$mysubstr = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = ". $myrow["_ID"]  ." AND _UserID = '" . $_SESSION['levelid'] . "'  And _Operation = '' and _PageName is not null and _PageName <> '' ORDER BY _Order ASC ";
						$mysubresult = mysql_query($mysubstr, $connect) or die(mysql_error());
						if(mysql_num_rows($mysubresult) > 0)
							{
							echo "<ul>";
							while($mysubrow = mysql_fetch_assoc($mysubresult))
							{
							echo "<li>";
							?>						
							<a <?if($mysubrow["_PageName"]!="No"){ ?> href="<?=$mysubrow["_PageName"]; ?>" <?}?> >
							<?=$mysubrow["_Title"]; ?>
							</a>
							
							<?php
						 $mysubsubstr = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = ". $mysubrow["_ID"]  ." And _PageName <> '' AND _UserID = '" . $_SESSION['levelid'] . "' And _Operation = '' ORDER BY _Order ASC ";
						
						$mysubsubresult = mysql_query($mysubsubstr, $connect) or die(mysql_error());
						if(mysql_num_rows($mysubsubresult) > 0)
							{
							echo "<ul>";
							while($mysubsubrow = mysql_fetch_assoc($mysubsubresult))
							{
							echo "<li>";
							?>						
							<a <?if($mysubsubrow["_PageName"]!="No"){ ?> href="<?=$mysubsubrow["_PageName"]; ?>" <?}?> >
							<?=$mysubsubrow["_Title"]; ?>
							</a>
							<?php
							echo "</li>";
							}
							echo "</ul>";
							}
							?>
						<?php
						echo "</li>";
						}
						echo "</ul>";
						}
						?>
					</li>
					
					<?php
					if($i < $mycount)
					{
					?>
					<li class="separator"><span></span></li>
					<?php
					}
					$i++;
					
					}
				?> 
				<?php
				}
				?>		
			</ul>		
		</div>
	</div>
	<div class="clr"></div>
</div>

<script type="text/javascript">
<!--
    /*var MenuBar2 = new Spry.Widget.MenuBar("MenuBar2", {imgRight:"Menu/tri-right1.gif"});*/
//-->
</script>