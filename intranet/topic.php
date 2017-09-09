<?php
	session_start();
	include('include/encrypt_inc.php');
	include('include/functions_script.php');
	include('scripts/common.php');
	include('ConnectDB.php');
	mysql_select_db($database_myonlyclub, $myonlyclub) or die(mysql_error());
	$pagename = "Forum";

	$sql = "SELECT * FROM metatags WHERE _Section = 'Website Info Pages' ";
	$rst = mysql_query($sql, $myonlyclub) or die(mysql_error());
	if(mysql_num_rows($rst) > 0)
	{
		$rs = mysql_fetch_assoc($rst);
		$MetaTitle = $rs['_Title'];
		$MetaDescription = $rs['_Description'];
		$MetaKeywords = $rs['_Keywords'];
	}

	$PAGETYPE = "_ForumPage";
	$PAGEID = decode($_REQUEST['DiscID']);
	
	$substr = "SELECT fg.*, (SELECT fg1._Name FROM forumgroup fg1 WHERE fg1._ID = fg._SubID) as _MName FROM forumgroup fg WHERE fg._ID = '".decode($_GET['DiscID'])."' ";
	$subgrst = mysql_query($substr, $myonlyclub) or die(mysql_error());
	if(mysql_num_rows($subgrst) > 0)
	{
		$subgrs = mysql_fetch_assoc($subgrst);
		$subID = $subgrs['_ID'];
		$SubFormName = $subgrs['_Name'];
		$ForumName = $subgrs['_MName'];
	}
	
	$strSQL1 = "SELECT forums.* FROM forums where forums._thread IS NULL AND forums._ID = '" .decode($_REQUEST['m']). "' OR forums._thread = '" . decode($_REQUEST['m']) . "' AND forums._Status = 'approved'";
	$trecord1 = mysql_query($strSQL1, $myonlyclub) or die(mysql_error());
	$rs_sel = mysql_fetch_assoc($trecord1);
	
	if($rs_sel["_GroupID"] != "")
	{
		$substr = "SELECT fg.*, (SELECT fg1._Name FROM forumgroup fg1 WHERE fg1._ID = fg._SubID) as _MName FROM forumgroup fg WHERE fg._ID = '". $rs_sel['_GroupID']."' ";
		$subgrst = mysql_query($substr, $myonlyclub) or die(mysql_error());
		if(mysql_num_rows($subgrst) > 0)
		{
			$subgrs = mysql_fetch_assoc($subgrst);
			$subID = $subgrs['_ID'];
			$SubFormName = $subgrs['_Name'];
			$ForumName = $subgrs['_MName'];
		}
	}
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> <?php echo $MetaTitle; ?> </TITLE>
<META NAME="Keywords" CONTENT="<?php echo $MetaKeywords; ?>">
<META NAME="Description" CONTENT="<?php echo $MetaDescription; ?>">
<LINK REL=StyleSheet HREF="css/myonlyclub.css" TYPE="text/css" MEDIA=screen>
<script type="text/javascript" src="js/validate.js"></script>
<script type="text/javascript" src="js/frontvalidate.js"></script>
<style>
	.information1{ width:150px; word-wrap: break-word;  }
	.information2{ width:480px; word-wrap: break-word;  }
</style>
<script language="javascript">
<!--
function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}

function validate_form()
{
	var s1 = trim(document.getElementById("Post").value);
	if (s1 == "")
	{
		alert("Please fill in 'Message'.");
		return false;
	}
	var myok = confirm("Are you sure you want to reply");
	if(myok == false)
	{
	   return false;
	}
}
function write_it(status_text)
{
	window.status=status_text;
}

function testKey(e)
{
	chars= "0123456789.";
	e    = window.event;
	if(chars.indexOf(String.fromCharCode(e.keyCode))==-1) 
	window.event.keyCode=0;
}
function hide_popup()
{
	document.getElementById("Addpopup").style.display = "none";
	document.AddAsFriend.frdid.value = "";
}

function show_popup(id, name)
{
	document.AddAsFriend.frdid.value = id;
	document.getElementById("UIMG").src = document.getElementById("MemberImg").src;
	document.getElementById("Uname").innerHTML = name;

	document.getElementById("Addpopup").style.display = "block";		
	AddPopup_positionit(document.getElementById("Addpopup"));
}

function DeleteReply(id)
{
	if(confirm('Are you sure want to delete?'))
		window.location = 'topicaction.php?action=deletemessage&tid='+id;
}

function ReplyThisPost(name, postname)
{
	var strpost = "\n\n<cite>"+name+" said:</cite>\n";
	strpost +=  "<blockquote cite='abc'>";
	strpost +=  document.getElementById(postname).innerHTML.replace(/<BR>/g, "\n");+"\n";
	strpost +=  "</blockquote>";
	document.frmEditor.Post.value = strpost;
	window.location = '#reply';
	document.frmEditor.Post.focus();
}
function OnClick_Search()
{
	if (document.frmSearch.Searchtext.value != "")
		window.location = 'searchtopic.php?q='+document.frmSearch.Searchtext.value;
	else
	{
		alert("Please fill in 'Search box'.");
		return false;
	}
	return true;
}
//-->
</script>
</HEAD>

<BODY>
	<div id="top">
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td><?php include('topbar.php'); ?></td>
			</tr>
		</table>
	</div>
	
	<div id="main">  
		<table width="100%" cellspacing="0" cellpadding="0" border="0"> 
			<tr>
				<td align="center" valign="top" id="left">
					<?php include('leftbar.php'); ?>
				</td>
	  
				<td align="left" valign="top" id="middle" width="69%">
					<table class="breadcrumbs" align="left">
						<tr>
						<td><a href="index.php">Home</a></td>
						<td>>></td>
						<td><a href="forum.php">Forum</a></td>
						<td>>></td>
						<td>Discussion Detail</td>
						</tr>
					</table>
					<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" class="contents">
						<tr>
						  <td valign="top" >
							<div class="contentitem" > 
							<!-- class="contentitem" -->
								<table cellpadding="0" cellspacing="5" border="0" width="100%">
									<tr>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tr>
						    					<td colspan="5" style="color:#434242;background-color:#c2cbde; font-size:12px;font-weight:bold; height:30px; padding:7px 0px 7px 5px;" >
														<a href="forum.php">All</a> > 
                                                        <a href="forum.php#<?=$ForumName?>"><?=$ForumName?></a> > <a href="forum.php?id=<?=encode($subID)?>"><?=$SubFormName?></a> > <?=$rs_sel['_Title'];?>
														</td>
							        	</tr>
							        	<tr><td height="10px"></td></tr>
												<tr>
													<td>
													<a href="forum.php">All Discussions</a>
													<?php if ($_SESSION['memberid'] != "") { ?>
													<span style="padding:0px 5px 0px 5px;">|</span>
													<a href="searchtopic.php?user=<?=encode($_SESSION['memberid'])?>">My Discussions</a>
													<span style="padding:0px 5px 0px 5px;">|</span>
													<a href="newtopic.php">Add a Discussion</a>
													<?php } ?>
													</td>
													<!--<td align="right"><a onClick="window.open('emailthispage.php?id=<?=encode($ID)?>&mode=<?=encode('topic')?>','emailthispage','width=690,height=800,left=250,top=120,toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=no');" href="javascript:void(0);">Email This Page</a>&nbsp;</td>-->
												
												<td align="right"><a onClick="window.open('emailthispage.php?id=<?=$_REQUEST['m']?>&mode=<?=encode('topic')?>','emailthispage','width=690,height=800,left=250,top=120,toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=no');" href="javascript:void(0);">Email This Page</a>&nbsp;</td>
									
												</tr>
											</table>
										</td>
									</tr>
									
																			<tr>
										<td align="center">
											<? GetBanner($pagename, $BannersPath, $myonlyclub, $PAGETYPE, $PAGEID); ?>
										</td>
									</tr>
									
									
									<tr><td height="10"></td></tr>
									<?php
									$PageSize = 10;
									$StartRow = 0;
									$urlq = "";
									//Set the page no
									if(empty($_GET['PageNo']))
									{
										if($StartRow == 0)
											$PageNo = $StartRow + 1;
									}
									else
									{
										$PageNo = $_GET['PageNo'];
										$StartRow = ($PageNo - 1) * $PageSize;
									}

									//Set the counter start
									if($PageNo % $PageSize == 0)
										$CounterStart = $PageNo - ($PageSize - 1);
									else
										$CounterStart = $PageNo - ($PageNo % $PageSize) + 1;

									//Counter End
									$CounterEnd = $CounterStart + ($PageSize - 1);
									
									$ID = decode($_REQUEST['m']);
									$listview = decode($_REQUEST['listview']);
									
									$sql = "SELECT * FROM forums WHERE _ID = '" . $ID . "' ";
									$rst = mysql_query($sql, $myonlyclub) or die(mysql_error());
									if(mysql_num_rows($rst) > 0)
									{
										$rs = mysql_fetch_assoc($rst);
										$Views = $rs['_Views'];
									}
									if($listview != 'view')
									{
									if($Views != "")
										$Views += 1;
									else
										$Views = 1;
									}
									$strview = "UPDATE forums SET _Views = '" . $Views . "' WHERE _ID = '" . $ID . "' ";
									mysql_query($strview);
									
									$urlq = $urlq . "&m=". $_REQUEST['m'] . "&s=" . session_id();
									$strSQL = "SELECT forums.*, members._City, members._RegisterDate, members._ID as MID, members._FullName, (SELECT COUNT(*) FROM forums temp WHERE temp._thread = forums._ID ) as _Replies, membersphotos._ThumbPic FROM forums ";
									$strSQL .= "LEFT JOIN members ON forums._MemberID = members._ID ";
									$strSQL .= "LEFT JOIN membersphotos ON forums._MemberID = membersphotos._MemberID AND membersphotos._PrimaryPhoto = 'Yes' ";
									$strSQL .= "WHERE forums._thread IS NULL AND forums._ID = '" . $ID . "' OR forums._thread = '" . $ID . "' AND forums._Status = 'approved' ORDER BY forums._Date DESC ";

									$trecord = mysql_query($strSQL, $myonlyclub) or die(mysql_error());									
									$strSQL .= "LIMIT $StartRow,$PageSize ";
									$result = mysql_query($strSQL, $myonlyclub) or die(mysql_error());

									$RecordCount = mysql_num_rows($trecord);
									$MaxPage = $RecordCount % $PageSize;
									if($RecordCount % $PageSize == 0)
										$MaxPage = $RecordCount / $PageSize;
									else
										$MaxPage = ceil($RecordCount / $PageSize);

									if (mysql_num_rows($result) > 0)
									{
										$rs = mysql_fetch_assoc($result);
										if($_SESSION['memberid'] == $rs['_MemberID'] ) $IsAdmin = true; else $IsAdmin = false;
										if($rs['_Status'] == 'opened') $IsOpen = true; else $IsOpen = false;
										
										$str = "SELECT * FROM forumsubscribe WHERE _MemberID = '".$_SESSION['memberid']."' AND _ForumID = '".$ID."' ";
										$trst = mysql_query($str, $myonlyclub) or die(mysql_error());
										if(mysql_num_rows($trst) > 0)
											$IsSubscribe = true;
										else
											$IsSubscribe = false;
									?>
									<tr>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
											<form name="frmSearch" method="post" action="searchtopic.php">
												<tr>
													<td>
														<input type="text" tabindex="" name="Searchtext" value="<?=$_GET['q']?>" style="width:100px" class="inputbox">
														<input type="button" name="butSearch" value="Search Forum" class="inputbut" onClick="return OnClick_Search()">
													</td>
												</tr>
											</form>
											</table>
										</td>
									</tr>
									

									
									<tr>
										<td>
											<table cellspacing="0" cellpadding="0" border="0" width="100%">
												<tr>
												<td><h2><?php echo $rs['_Title']; ?></h2><!--img src="images/forum/postreply.png" style="cursor:pointer;" border="0" align="absmiddle" onClick="javascript:window.location='#reply';"--></td>
												<td align="right">
													<table cellpadding="0" cellspacing="0" border="0" style="border:1px solid #c5ccdb;">
													
													
													
														<tr height="22px">
															<td style="width:80px; background-color:#f5f5ff" align="center">Page <?=$PageNo?> of <?=$MaxPage?></td>
																<?php
																	if($PageNo != 1)
																	{
																		$PrevStart = $PageNo - 1;
																		echo "<td style='width:20px; background-color:#f5f5ff;border-left:1px solid #b3bbdd;' align='center'><a href='?PageNo=$PrevStart".$urlq."'><</a></td>";
																	}
				
																	$c = 0;
				
																	if($PageNo < 5 && $MaxPage != 1)
																	{
																		for($c=1;$c<=10;$c++)
																		{
																			if($c > 0)
																			{
																				if($c < $MaxPage)
																				{
																					if($c == $PageNo)
																						if($c % $PageSize == 0) echo "<td style='width:20px; background-color:#e1e4f2;border-left:1px solid #b3bbdd;' align='center'>$c</td>"; else echo "<td style='width:20px; background-color:#e1e4f2;border-left:1px solid #b3bbdd;' align='center'>$c</td>";
																					elseif($c % $PageSize == 0)
																						echo "<td style='width:20px; background-color:#f5f5ff;border-left:1px solid #b3bbdd;' align='center'><a href='?PageNo=$c".$urlq."'>$c</a></td>";
																					else
																						echo "<td style='width:20px; background-color:#f5f5ff;border-left:1px solid #b3bbdd;' align='center'><a href='?PageNo=$c".$urlq."'>$c</a></td>";
																				}
																				else
																				{
																					if($PageNo == $MaxPage)
																					{
																						print "<td style='width:20px; background-color:#e1e4f2;border-left:1px solid #b3bbdd;' align='center'>$c</td>";
																						break;
																					}
																					else
																					{
																						echo "<td style='width:20px; background-color:#f5f5ff;border-left:1px solid #b3bbdd;' align='center'><a href='?PageNo=$c".$urlq."'>$c</a></td>";
																						break;
																					}
																				}
																			}
																		} // for loop
																	}
																	elseif( $PageNo > $MaxPage-5 && $MaxPage != 1 )
																	{
																		for($c=$MaxPage-9;$c<=$MaxPage;$c++)
																		{
																			if($c > 0)
																			{
																				if($c < $MaxPage)
																				{
																					if($c == $PageNo)
																						if($c % $PageSize == 0) echo "<td style='width:20px; background-color:#e1e4f2;border-left:1px solid #e1e4f2;' align='center'>$c</td>"; else echo "<td style='width:20px; background-color:#e1e4f2;border-left:1px solid #e1e4f2;' align='center'>$c</td>";
																					elseif($c % $PageSize == 0)
																						echo "<td style='width:20px; background-color:#f5f5ff;border-left:1px solid #e1e4f2;' align='center'><a href='?PageNo=$c".$urlq."'>$c</a></td>";
																					else
																						echo "<td style='width:20px; background-color:#f5f5ff;border-left:1px solid #e1e4f2;' align='center'><a href='?PageNo=$c".$urlq."'>$c</a></td>";
																				}
																				else
																				{
																					if($PageNo == $MaxPage)	{
																						print "<td style='width:20px; background-color:#e1e4f2;border-left:1px solid #e1e4f2;' align='center'>$c</td>";
																						break;
																					}else{
																						echo "<td style='width:20px; background-color:#f5f5ff;border-left:1px solid #e1e4f2;' align='center'><a href='?PageNo=$c".$urlq."'>$c</a></td>";
																						break;
																					}
																				}
																			}
																		} // for loop
																	}
																	elseif ( $MaxPage != 1 )
																	{
																		for($c=$PageNo-4;$c<=$PageNo+5;$c++)
																		{
																			if($c > 0)
																			{
																				if($c < $MaxPage)
																				{
																					if($c == $PageNo)
																						if($c % $PageSize == 0) echo "<td style='width:20px; background-color:#e1e4f2;border-left:1px solid #e1e4f2;' align='center'>$c</td>"; else print "<td style='width:20px; background-color:#e1e4f2;border-left:1px solid #e1e4f2;' align='center'>$c</td>";
																					elseif($c % $PageSize == 0)
																						echo "<td style='width:20px; background-color:#f5f5ff;border-left:1px solid #e1e4f2;' align='center'><a href='?PageNo=$c".$urlq."'>$c</a></td>";
																					else
																						echo "<td style='width:20px; background-color:#f5f5ff;border-left:1px solid #e1e4f2;' align='center'><a href='?PageNo=$c".$urlq."'>$c</a></td>";
																				}
																				else
																				{
																					if($PageNo == $MaxPage) {
																						print "<td style='width:20px; background-color:#f5f5ff;border-left:1px solid #e1e4f2;' align='center'>$c</td>";
																						break;
																					} else {
																						echo "<td style='width:20px; background-color:#f5f5ff;border-left:1px solid #e1e4f2;' align='center'><a href='?PageNo=$c".$urlq."'>$c</a></td>";
																						break;
																					}
																				}
																			}
																		} // for loop
																	}
																	
																	if($PageNo < $MaxPage)
																	{
																		$NextPage = $PageNo + 1;
																		echo "<td style='width:20px; background-color:#f5f5ff;border-left:1px solid #e1e4f2;' align='center'><a href='?PageNo=$NextPage".$urlq."'>></a></td>";
																	}
																  
																	if($PageNo < $MaxPage && $MaxPage > 5)
																	{
																		$LastRec = $RecordCount % $PageSize;
																		if($LastRec == 0)
																		{
																			$LastStartRecord = $RecordCount - $PageSize;
																		}
																		else
																		{
																			$LastStartRecord = $RecordCount - $LastRec;
																		}
																		if($MaxPage > $c)
																		print "<td style='width:20px; background-color:#f5f5ff;border-left:1px solid #e1e4f2;' align='center'>...</td>";
																		echo "<td style='width:60px; background-color:#f5f5ff;border-left:1px solid #e1e4f2;' align='center'><a href='?PageNo=$MaxPage".$urlq."'>Last >></a></td>";
																	}
																?>
														</tr>
													</table>
												</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border:1px solid #c5ccdb;">
												<!--tr>
													<td align="right" style="height:25px;font-size:12px; color:#FFFFFF;" colspan="2"><a style="color:#FFFFFF" onClick="window.open('emailthispage.php?id=<?=encode($ID)?>&mode=<?=encode('topic')?>','emailthispage','width=690,height=800,left=250,top=120,toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=no');" href="javascript:void(0);">Email This Page</a>&nbsp;</td>
												</tr-->
												<tr>
													<td style="height:25px;font-size:12px; color:#FFFFFF; background-color:#8c9bbb;" colspan="2">
													<table cellpadding="0" cellspacing="0" border="0" width="100%" style="color:#FFFFFF;">
														<tr>
															<td>&nbsp;<!--img src="images/forum/post_old.png" align="absmiddle" border="0"-->&nbsp;<?=date('F jS, Y, g:i A', strtotime($rs['_Date']));?></td>
															<td align="right">
															<?php
																if ($IsAdmin || $_SESSION['memberid'] == $row['_MemberID'] )
																{
																?>
																<img src="images/edit.png" width="11" style="cursor:pointer;" onclick="window.open('editpost.php?DiscID=<?=$_REQUEST['DiscID']?>&id=<?=encode($rs['_ID'])?>','propertyrequest','width=800,height=500,left=350,top=100,toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=no');">
																&nbsp;&nbsp;<img src="images/crossgrey.jpg" width="11" style="cursor:pointer;" onclick="DeleteReply('<?=encode($rs['_ID'])?>');">
																<?php
																}
																//topicaction.php
															?>
															<?php /*
																if($rs['_Tags'] != "")
																{
																	echo "Tags: ";
																	$arr = explode(',', $rs['_Tags']);
																	for($i=0;$i<sizeof($arr);$i++)
																	{
																		if($i != 0) echo ', ';
																		echo '<a style="color:#FFFFFF;" href="searchtopic.php?tag='.encode(trim($arr[$i])).'">'.trim($arr[$i]).'</a>';
																	}
																} */
															?>
															&nbsp;
															</td>
														</tr>
													</table>
													</td>
												</tr>
												<tr>
													<td rowspan="2" style="background-color:#e1e4f2; width:180px;padding:5px 5px 5px 5px;border-right:1px solid #b2b5c5;">
														<a style="font-size:14px" href="profile.php?ID=<?=encode($rs['MID'])?>"><?=$rs['_FullName']?></a><br>
														<br>
														<?php
														if($rs['_ThumbPic'] != "" && file_exists($MemberPhotosPath . $rs['_ThumbPic']) )
														{
															echo '<img src="'.$MemberPhotosPath . $rs['_ThumbPic'] .'" id="MemberImg" width="80" border="0" align="texttop">&nbsp;';
														}
														else
														{
															echo '<img src="images/nopic.jpg" width="80" id="MemberImg" border="0" align="texttop">&nbsp;';
														}
														?>
														<br><br>
														Join Date: <?=date("M Y", strtotime($rs['_RegisterDate']))?><br>
														Location: <div class="information1"><?=$rs['_City']?></div><br>
													   <?php
														$str = "SELECT * FROM friends WHERE ((_UserID = '" . str_replace("'", '&#39;', $_SESSION['memberid']) . "' AND _FriendID = '" . $rs['_MemberID'] . "') OR (_FriendID = '" . str_replace("'", '&#39;', $_SESSION['memberid']) . "' AND _UserID = '" . $rs['_MemberID'] . "')) AND _Added = 'Yes' ";
														$frst = mysql_query($str, $myonlyclub) or die(mysql_error());
														if(mysql_num_rows($frst) <= 0 && $_SESSION['memberid'] !=  $rs['_MemberID'])
															echo "<a onclick=".'"'."show_popup('".encode($rs['_MemberID'])."', '".$rs['_FullName']."')".'"'." href='javascript:void(0);'>Add As Friend</a><br>";

														$strtemp1 = "SELECT COUNT(*) AS t_posts FROM forums WHERE _MemberID = '" . $rs['MID'] . "' ";
														$rsttemp = mysql_query($strtemp1, $myonlyclub) or die(mysql_error());
														if(mysql_num_rows($rsttemp) > 0)
														{
															$rstemp = mysql_fetch_assoc($rsttemp);
															$t_posts = $rstemp['t_posts'];
														}
														?>
														Posts: <?=number_format($t_posts, 0, ".", ",")?>
													</td>
													<td style="background-color:f5f5ff;padding:5px 5px 0px 5px; width:75%" valign="top">
														<div class="information2">
															<div id="postid<?=$rs['_ID']?>"><?=$rs['_Post']?></div>
														</div>
													</td>
												</tr>
												<tr>
													<td style="background-color:f5f5ff;padding:3px 5px 5px 5px;height:30px;" valign="bottom">
														<table cellpadding="0" cellspacing="0" border="0" width="100%">
															<tr>
																<td>
																<?php
																if ( $rs['_File1'] != "" || $rs['_File2'] != "" || $rs['_File3'] != "" )
																{
																	echo '<b>Attachments</b>: ';
																	if ($rs['_File1'] != "") {
																		$temp = explode("/", $rs['_File1']);
																		
																		$ext=explode(".",$rs['_File1']);
																		$ext1=strtolower($ext[1]);
																		if($ext1 == 'gif' || $ext1 == 'jpg' || $ext1 == 'jpeg' || $ext1 == 'png')
																		{
																		echo ' <a href="javascript:void(0)" onClick="javascript:window.open('."'".$rs['_File1']."'".');"><img height="100" width="100" src="'.$rs['_File1'].'"/></a> &nbsp;';
																		}
																		else
																		{							
																		echo ' <a href="javascript:void(0)" onClick="javascript:window.open('."'".$rs['_File1']."'".');">'.urldecode($temp[sizeof($temp)-1]).'</a> &nbsp;';
																		}
																	}
																	if ($rs['_File2'] != "") {
																		$temp = explode("/", $rs['_File2']);
																		$ext=explode(".",$rs['_File2']);
																		$ext1=strtolower($ext[1]);
																		if($ext1 == 'gif' || $ext1 == 'jpg' || $ext1 == 'jpeg' || $ext1 == 'png')
																		{
																		echo ' <a href="javascript:void(0)" onClick="javascript:window.open('."'".$rs['_File1']."'".');"><img height="100" width="100" src="'.$rs['_File2'].'"/></a> &nbsp;';
																		}
																		else
																		{	
																		echo ' <a href="javascript:void(0)" onClick="javascript:window.open('."'".$rs['_File2']."'".');">'.urldecode($temp[sizeof($temp)-1]).'</a> &nbsp;';
																		}
																	}
																	if ($rs['_File3'] != "") {
																		$temp = explode("/", $rs['_File3']);
																		$ext=explode(".",$rs['_File3']);
																		$ext1=strtolower($ext[1]);
																		if($ext1 == 'gif' || $ext1 == 'jpg' || $ext1 == 'jpeg' || $ext1 == 'png')
																		{
																		echo ' <a href="javascript:void(0)" onClick="javascript:window.open('."'".$rs['_File1']."'".');"><img height="100" width="100" src="'.$rs['_File3'].'"/></a> &nbsp;';
																		}
																		else
																		{	
																		echo ' <a href="javascript:void(0)" onClick="javascript:window.open('."'".$rs['_File3']."'".');">'.urldecode($temp[sizeof($temp)-1]).'</a> &nbsp;';
																		}
																	}
																} 
																?>
																</td>
																<td align="right" style="padding:5px 5px 5px 5px;">
																	<?php if($_SESSION['memberid'] != "") { ?>
																	<a style="border:1px solid #c8c9cf; padding:3px 5px 3px 5px;background-color:#FFFFFF;" href="javascript:void(0);" onClick="javascript:ReplyThisPost('<?=$rs['_FullName']?>', 'postid<?=$rs['_ID']?>' );"><b>Quote</b></a>
																	<?php } else { ?>
																	<a style="border:1px solid #c8c9cf; padding:3px 5px 3px 5px;background-color:#FFFFFF;" href="javascript:void(0);" onClick="javascript:alert('Please login the system.')"><b>Quote</b></a>
																	<?php } ?>
																	<!--img onClick="javascript:ReplyThisPost('<?=$rs['_FullName']?>', 'postid<?=$rs['_ID']?>' );" src="images/forum/quote.gif" style="cursor:pointer;" align="absmiddle" border="0"-->
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								
									<?php
										if ( mysql_num_rows($result) > 0 )
										{
											$i = 1;
											while( $row = mysql_fetch_assoc($result) )
											{
											?>
												<tr>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%" style="border:1px solid #c5ccdb;">
															<a id="#EE<?=$rs['_ID']?>D" name="#EE<?=$row['_ID']?>D" ></a>
															<tr>
																<td style="height:25px;font-size:12px; color:#FFFFFF; background-color:#8c9bbb;" colspan="2">
																<table cellpadding="0" cellspacing="0" border="0" width="100%" style="color:#FFFFFF;">
																	<tr>
																		<td>&nbsp;<!--img src="images/forum/post_old.png" align="absmiddle" border="0"-->&nbsp;<?=date('F jS, Y, g:i A', strtotime($row['_Date']));?></td>
																		<td align="right">
																		<?php
																			if ($IsAdmin || $_SESSION['memberid'] == $row['_MemberID']  )
																{
																?>
																<img src="images/edit.png" width="11" style="cursor:pointer;" onclick="window.open('editpost.php?DiscID=<?=$_REQUEST['DiscID']?>&id=<?=encode($row['_ID'])?>','propertyrequest','width=800,height=500,left=350,top=100,toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=no');">
																&nbsp;&nbsp;<img src="images/crossgrey.jpg" width="11" style="cursor:pointer;" onclick="DeleteReply('<?=encode($rs['_ID'])?>');">
																<?php
																			}
																			//topicaction.php
																		?>
																		&nbsp;
																		</td>
																	</tr>
																</table>
																</td>
															</tr>
															<tr>
																<td rowspan="2" style="background-color:#e1e4f2; width:180px;padding:5px 5px 5px 5px;border-right:1px solid #b2b5c5;">
																	<a style="font-size:14px" href="profile.php?ID=<?=encode($row['MID'])?>"><?=$row['_FullName']?></a><br>
																	<br>
																	<?php
																	if($row['_ThumbPic'] != "" && file_exists($MemberPhotosPath . $row['_ThumbPic']) )
																	{
																		echo '<img src="'.$MemberPhotosPath . $row['_ThumbPic'] .'" width="60" border="0">';
																	}
																	else
																	{
																		echo '<img src="images/nopic.jpg" width="60" border="0">';
																	}
																	?>
																	<br><br>
																	Join Date: <?=date("M Y", strtotime($row['_RegisterDate']))?><br>
																	Location:  <div class="information1"><?=$row['_City']?></div><br>
																   <?php
																	$t_posts = 0;
																	$strtemp1 = "SELECT COUNT(*) AS t_posts FROM forums WHERE _MemberID = '" . $row['MID'] . "' ";
																	$rsttemp = mysql_query($strtemp1, $myonlyclub) or die(mysql_error());
																	if(mysql_num_rows($rsttemp) > 0)
																	{
																		$rstemp = mysql_fetch_assoc($rsttemp);
																		$t_posts = $rstemp['t_posts'];
																	}
																	echo 'Posts: ' . number_format($t_posts, 0, ".", ",") . "<br>";

																	$str = "SELECT * FROM friends WHERE ((_UserID = '" . str_replace("'", '&#39;', $_SESSION['memberid']) . "' AND _FriendID = '" . $row['_MemberID'] . "') OR (_FriendID = '" . str_replace("'", '&#39;', $_SESSION['memberid']) . "' AND _UserID = '" . $row['_MemberID'] . "')) AND _Added = 'Yes' ";
																	$frst = mysql_query($str, $myonlyclub) or die(mysql_error());
																	if(mysql_num_rows($frst) <= 0 && $_SESSION['memberid'] !=  $rs['_MemberID'])
																		echo "<a onclick=".'"'."show_popup('".encode($row['_MemberID'])."', '".$row['_FullName']."')".'"'." href='javascript:void(0);'>Add As Friend</a><br>";
																	?>
																</td>
																<td style="background-color:f5f5ff;padding:5px 5px 0px 5px; width:75%" valign="top">
																<div class="information2">
																	<div id="postid<?=$row['_ID']?>"><?=$row['_Post']?></div>
																</div>
																</td>
															</tr>
															<tr>
																<td style="background-color:f5f5ff;padding:3px 5px 5px 5px;height:30px;" valign="bottom">
																	<table cellpadding="0" cellspacing="0" border="0" width="100%">
																		<tr>
																			<td>
																			<?php
																			if ( $row['_File1'] != "" || $row['_File2'] != "" || $row['_File3'] != "" )
																			{
																				echo '<b>Attachments</b>: ';
																				if ($row['_File1'] != "") {
																					$temp = explode("/", $row['_File1']);
																					
																					$ext=explode(".",$row['_File1']);
																					$ext1=strtolower($ext[1]);
																					if($ext1 == 'gif' || $ext1 == 'jpg' || $ext1 == 'jpeg' || $ext1 == 'png')
																					{
																					echo ' <a href="javascript:void(0)" onClick="javascript:window.open('."'".$rs['_File1']."'".');"><img height="100" width="100" src="'.$row['_File1'].'"/></a> &nbsp;';
																					}
																					else
																					{	
																					
																					echo ' <a href="javascript:void(0)" onClick="javascript:window.open('."'".$row['_File1']."'".');">'.urldecode($temp[sizeof($temp)-1]).'</a> &nbsp;';
																					}
																				}
																				if ($row['_File2'] != "") {
																					$temp = explode("/", $row['_File2']);
																					$ext=explode(".",$row['_File2']);
																					$ext1=strtolower($ext[1]);
																					if($ext1 == 'gif' || $ext1 == 'jpg' || $ext1 == 'jpeg' || $ext1 == 'png')
																					{
																					echo ' <a href="javascript:void(0)" onClick="javascript:window.open('."'".$rs['_File1']."'".');"><img height="100" width="100" src="'.$row['_File2'].'"/></a> &nbsp;';
																					}
																					else
																					{	
																					echo ' <a href="javascript:void(0)" onClick="javascript:window.open('."'".$row['_File2']."'".');">'.urldecode($temp[sizeof($temp)-1]).'</a> &nbsp;';
																					}
																				}
																				if ($row['_File3'] != "") {
																					$temp = explode("/", $row['_File3']);
																					$ext=explode(".",$row['_File3']);
																					$ext1=strtolower($ext[1]);
																					if($ext1 == 'gif' || $ext1 == 'jpg' || $ext1 == 'jpeg' || $ext1 == 'png')
																					{
																					echo ' <a href="javascript:void(0)" onClick="javascript:window.open('."'".$rs['_File1']."'".');"><img height="100" width="100" src="'.$row['_File3'].'"/></a> &nbsp;';
																					}
																					else
																					{	
																					echo ' <a href="javascript:void(0)" onClick="javascript:window.open('."'".$row['_File3']."'".');">'.urldecode($temp[sizeof($temp)-1]).'</a> &nbsp;';
																					}
																				}
																			} 
																			?>
																			</td>
																			<td align="right"  style="padding:5px 5px 5px 5px;">
																			<!--span>Reply by <a href="#EE<?=$row['_ID']?>D"><?=$row['_FullName']?></a> <?php if ( date("Y-m-d", strtotime($row['_Date'])) == date("Y-m-d") ) echo ago(strtotime($row['_Date'])); else echo "on " . date('F d, Y \a\t h:ia', strtotime($row['_Date']));?></span-->
																				<!--img onClick="javascript:ReplyThisPost('<?=$row['_FullName']?>', 'postid<?=$row['_ID']?>' );" src="images/forum/quote.gif" align="absmiddle" border="0" style="cursor:pointer;"-->
																				<?php if($_SESSION['memberid'] != "") { ?>
																				<a style="border:1px solid #c8c9cf; padding:3px 5px 3px 5px;background-color:#FFFFFF;" href="javascript:void(0);" onClick="javascript:ReplyThisPost('<?=$row['_FullName']?>', 'postid<?=$row['_ID']?>' );"><b>Quote</b></a>
																				<?php } else { ?>
																				<a style="border:1px solid #c8c9cf; padding:3px 5px 3px 5px;background-color:#FFFFFF;" href="javascript:void(0);" onClick="javascript:alert('Please login the system.')"><b>Quote</b></a>
																				<?php } ?>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<?php
												$i++;
												if($i%2 && $i < mysql_num_rows($result) ) {
													//echo '<tr><td align="center">';
													//echo GetBanner($pagename, $BannersPath, $myonlyclub, $PAGETYPE, $PAGEID);
													//echo '</tr></td>';
												}// end if
											}
										}
									}
									?>
									<tr><td height="10"></td></tr>
									<tr>
										<td>
										<?php
										if($_SESSION['memberid'] != "") { //$IsOpen && 
										?>
											<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border:1px solid #c5ccdb;"> 
												<tr>
													<td style="height:25px;font-size:12px; color:#FFFFFF; background-color:#869bbf;" colspan="2">
													<table cellpadding="0" cellspacing="0" border="0" width="100%" style="color:#FFFFFF;">
														<tr>
															<td>&nbsp;Reply to Thread</td>
															<td align="right">&nbsp;
															
															</td>
														</tr>
													</table>
													</td>
												</tr>
												<tr>
													<td colspan="2" align="center" valign="middle"><a id="reply" href="#"></a><br>
														<!--span id="ReplySH" style="height:25px;cursor:pointer;cursor:hand;color:#0033CC" onClick="javascript:hidshowEditor();">- Reply to This</span-->
														<div id="editor" style="width:70%; text-align:left;">
														Message :
														<form name="frmEditor" method="post" action="newtopicaction.php" enctype="multipart/form-data">
                                                        	<input type="hidden" name="action" value="reply">
                                                        	<input type="hidden" name="myurl" value="m=<?=$_REQUEST['m']?>&s=<?=$_REQUEST['s']?>">
															<input type="hidden" name="thread" value="<?=$ID?>">
															<textarea style="width:100%;height:200px;" name="Post" id="Post"></textarea>
															<br>
															<span id="uploadfile" onClick="hidshowUpload()" style="cursor:pointer;cursor:hand;">Upload Files</span>
															<div id="upload" style="display:none;">
																<table cellpadding="0" cellspacing="5" border="0" width="100%">
																	<tr>
																		<td>Attach File(s):</td>
																	</tr>
																	<tr>
																		<td><input type="file" name="File1" value="" class="inputbox" style="width:250px"></td>
																	</tr>
																	<tr>
																		<td><input type="file" name="File2" value="" class="inputbox" style="width:250px"></td>
																	</tr>
																	<tr>
																		<td><input type="file" name="File3" value="" class="inputbox" style="width:250px"></td>
																	</tr>
																</table>
															</div>
															<table cellpadding="0" cellspacing="0" border="0" width="100%">
																<tr>
																	<td height="7px"></td>
																</tr>
																<tr>
																	<td align="right" style="border-top:1px solid #CCCCCC;">
																		<table cellpadding="0" cellspacing="0" border="0" width="100%">
																			<tr>
																				<td>
																					<input type="checkbox"   tabindex="" name="Subscribe" value="Yes" class="inputbox" checked="checked" > Subscribe to reply
																					<input type="hidden" name="hidSubscribe" value="<?=$IsSubscribe?>">
																				</td>
																				<td align="right"><input type="submit" name="butSubmit" value="Add Reply" class="inputbut" onClick="return validate_form()"></td>
																			</tr>
																		</table>
																		
																	</td>
																</tr>
															</table>
														</form>
														</div><br>
													</td>
												</tr>
												<script language="javascript" type="text/javascript">
												<!--
												function hidshowEditor()
												{
													if (document.getElementById("editor") )
													{
														if ( document.getElementById("editor").style.display == 'none' )
														{
															document.getElementById("editor").style.display = 'block';
															document.getElementById("ReplySH").innerHTML = '- Reply to This';
														}else {
															document.getElementById("editor").style.display = 'none';
															document.getElementById("ReplySH").innerHTML = '+ Reply to This';
														}
													}
												}
												
												function hidshowUpload()
												{
													if (document.getElementById("upload") )
													{
														document.getElementById("upload").style.display = 'block';
														document.getElementById("uploadfile").style.display = 'none';
													}
												}
												-->
												</script>
											</table>
										</td>
									<?php 
									}
									elseif ($_SESSION['memberid'] != "")
									{
										echo '<tr><td colspan="2" height="40px" style="font-size:16px;color:#999999;">';
										echo "Replies are closed for this discussion.";
										echo '</td></tr>';
									}
									?>
									</tr>
									<tr>
										<td align="right">
											<?php 
											if($IsSubscribe)
												echo '<a href="topicaction.php?action=UnSubscribe&tid='.encode($ID).'&DiscID='. $_REQUEST["DiscID"] .'&m='.$_REQUEST['m'].'">Stop Following</a> ?Don\'t email me when people reply';
											else
												echo '<a href="topicaction.php?action=Subscribe&id='.encode($ID).'">Follow</a> - Email me when people reply';
											?>
										</td>
									</tr>
								</table>
								<div id="Addpopup" style="display:none;position: absolute;">
									<div style="border:5px solid #999999; background-color:#CCCCCC; width:400; height:200;">
										<form name="AddAsFriend" method="post" action="addasfriend.php">
											<input type="hidden" name="frdid" value="">
											<table cellpadding="0" cellspacing="0" width="100%" border="0" bgcolor="#FFFFFF">
												<tr>
													<td colspan="2" height="30px" style="background-color:#6d84b4; color:#FFFFFF; font-size:14px;font-weight:bold;">&nbsp;&nbsp;Add as a friend?</td>
												</tr>
												<tr><td colspan="2" height="10"></td></tr>
												<tr>
													<td width="130" align="center" valign="top"><img id="UIMG" src="" width="120" style="border:1px solid #CCCCCC;"></td>
													<td valign="top">
														<label id="Uname"></label>&nbsp;will have to confirm that you are friends.<br><br>
														Add a personal message: <br>
														<textarea name="Message" style="width:240;height:60;" class="inputbox"></textarea>
													</td>
												</tr>
												<tr><td colspan="2" height="10"></td></tr>
												<tr>
													<td colspan="2" align="right" style="background-color:#f2f2f2;height:30;" valign="middle">
														<input type="submit" name="butSubmit" value="Add Friend" class="inputbut">&nbsp;&nbsp;
														<input type="button" name="butcancel" value="Cancel" class="inputbut" onClick="hide_popup()">&nbsp;&nbsp;
													</td>
												</tr>
											</table>
										</form>
									</div>
								</div>
							</div>		
						  </td>
						</tr>
					</table>
				</td>
				
				<td valign="top" id="right">
					<?php include('rightbar.php'); ?>
				</td>
			</tr>
		</table>
	</div>
	
	<div id="footer">
		<?php include('bottombar.php'); ?>
	</div>

</BODY>
</HTML>
<?php		
	include('DBclose.php');
?>
<!--
	<?php
	if ($IsAdmin == true)
	{
	?>
	<td width="140" valign="top">
		<h3>Admin Options</h3><hr>
		<div style="height:20px"><a href="newtopic.php?m=edit&id=<?=encode($rs['_ID'])?>&s=<?=session_id()?>">Edit Discussion</a></div>
		<div style="height:20px">
		<?php
			if($IsOpen)
				echo '<a href="topicaction.php?action=close&id='.encode($rs['_ID']).'&s='.session_id().'">Close Discussion</a>';
			else
				echo '<a href="topicaction.php?action=open&id='.encode($rs['_ID']).'&s='.session_id().'">Re-open Discussion</a>';
		?>
		</div>
		<div style="height:20px"><a href="javascript:void(0);" onClick="javascript:Onclick_EditTags();">Edit Your Tags</a></div>
		<div style="display:none; height:20px;padding:3px 3px 3px 3px;" id="edittags">
			<form name="edittags" method="post">
			<input type="text" tabindex="" name="tags" value="<?=$rs['_Tags']?>" class="inputbox" style="border:1px solid #CCCCCC;">
			<input type="button" name="butSave" value="Save" class="inputbut" onClick="EditTags(<?=encode()?>)">
			</form>
		</div>
		<div style="height:20px"><a onClick="javascript:if(confirm('Are you sure you want to delete \nthis discussion (including all replies)? ')) window.location='topaction.php?action=deletetopic=id=<?=encode($rs['_ID'])?>&s=<?=session_id()?>'; else return;" href="javascript:void(0);">Delete Discusstion</a></div>
	</td>
	<script language="javascript" type="text/javascript">
	<!--
	function Onclick_EditTags()
	{
		if( document.getElementById("edittags") )
		{
			if ( document.getElementById("edittags").style.display == 'block' )
				document.getElementById("edittags").style.display = 'none';
			else
				document.getElementById("edittags").style.display = 'block';
		}
	}
	-->
	</script>
	<?php
	}
	?>
