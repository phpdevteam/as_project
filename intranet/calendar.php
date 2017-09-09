<?php 
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

$Operations = GetAccessRights(62);
	if(count($Operations)== 0)
	{
	 echo "<script language='javascript'>history.back();</script>";
	}

	$pagename = "Calendar";
	$RequestAll = $_REQUEST;
	
	$appDate = $RequestAll['appDate'];
	
	$Keywords = $RequestAll['Keywords'];
	
	$m = $RequestAll['m'];
	$staff = $RequestAll['staff'];
	
	
	if(trim($Keywords) != "")
	$appDate = "";
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?=$appname?></title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
<link rel="stylesheet" href="../jquery/autocomplete/docsupport/prism.css">
<link rel="stylesheet" href="../jquery/autocomplete/chosen.css" />


 <script type='text/javascript' src='../jquery/jquery-1.7.1.min.js'></script>
<link rel="stylesheet" href="../jquery/css/pepper/jquery-ui-1.10.0.custom.css">
 <script src="../jquery/js/jquery-ui-1.10.0.custom.js"></script>
    <script type='text/javascript' src='../jquery/jquery-ui-1.8.17.custom.min.js'></script>
    
      <script type='text/javascript'>
	
	$(function () {
        
		
		$("#appDate").datepicker({
    changeMonth: true,
			changeYear: true,
			dateFormat: "dd/mm/yy"
  });
  
  
	});
	
	</script>
    
    
     <script type='text/javascript' src='../jquery/jquery.session.js'></script>
   
  
<link rel='stylesheet' type='text/css' href='../jquery/calendar/theme.css' />	
<link rel='stylesheet' type='text/css' href='../jquery/calendar/fullcalendar.css' />  <link rel='stylesheet' type='text/css' href='../jquery/calendar/fullcalendar.print.css' media='print' />
<script type='text/javascript' src='../jquery/calendar/fullcalendar.js'></script>

<script src="../jquery/calendar/external/jquery.bgiframe-2.1.2.js"></script>
	<script src="../jquery/calendar/ui/jquery.ui.core.js"></script>
	<script src="../jquery/calendar/ui/jquery.ui.widget.js"></script>
	<script src="../jquery/calendar/ui/jquery.ui.mouse.js"></script>
	<script src="../jquery/calendar/ui/jquery.ui.draggable.js"></script>
	<script src="../jquery/calendar/ui/jquery.ui.position.js"></script>
	<script src="../jquery/calendar/ui/jquery.ui.resizable.js"></script>
	<script src="../jquery/calendar/ui/jquery.ui.dialog.js"></script>
    
 
    <script type='text/javascript'>
	
			
		$(document).ready(function() {
			
			$(".defaultText").focus(function(srcc)
	  {
		  if ($(this).val() == $(this)[0].title)
		  {
			  $(this).removeClass("defaultTextActive");
			  $(this).val("");
		  }
	  });

	  $(".defaultText").blur(function()
	  {
		  if ($(this).val() == "")
		  {
			  $(this).addClass("defaultTextActive");
			  $(this).val($(this)[0].title);
		  }
	  });

	  $(".defaultText").blur(); 
		
			 $(".fc-event").mouseover(function() {
                 $(this).children(".fc-event-title").show();
			}).mouseout(function() {
				 $(this).children(".fc-event-title").hide();
			});
		
						
			if($.session("defaultview")=="")
			{	
				$.session("defaultview","agendaWeek");				
			}
			
			var res = $.ajax({
                type: "POST",
                url: "json-events.php?action=getres",
                data: "{}",
                dataType: "json",
                async: false,
                success: function (data) {
                }
            }).responseText; 
			
			var resources = JSON.parse(res);
			
				
			$('#calendar').fullCalendar({
				
				<?php			
				if($appDate != "")
				 {
				 ?>
				 defaultView: "resourceDay",
				 <?php
				 }
				 else
				 {
				 ?>	
				 defaultView: "agendaWeek",
				 <?php
				 }
				 ?>	
				
           		axisFormat: 'HH:mm',
				theme: true,
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,resourceDay'
				},
				editable: true,
				
				resources: resources,
						
				<?php			
				if($appDate != "")
				 {
				 ?>
				
				 year: <?=date("Y",strtotime(datepickerToMySQLDate($appDate)));?>,
				 month: <?=date("m",strtotime(datepickerToMySQLDate($appDate))) - 1;?>,
				 date: <?=date("d",strtotime(datepickerToMySQLDate($appDate)));?>,
				 
				 <?php
				 }
				 ?>
				
				//resources: "json-events.php?action=getres",
				
				disableResizing:false,
				
				events: "json-events.php?action=get&keywords=<?=$Keywords?>&m=<?=$m?>&staff=<?=$staff?>",
				
				eventDrop: function(event, delta) {
				alert(event.title + ' was moved to another Date/Time' +
					' and sucessfully updated!');
					
				
				if($.session("defaultview")!="month" && $.session("defaultview")!="agendaWeek")
				{
	            	AssignCourse(event.id, event.start, event.end, $.session("changeid"));	
				}
				else
				{	
					AssignCourse(event.id, event.start, event.end, "");	
				}
				
				location.reload();	
				
				},
				
				
				eventResize: function(event,dayDelta,minuteDelta,revertFunc) {

					AssignCourse(event.id, event.start, event.end, "");	
					location.reload();
				
				},
				
					loading: function(bool) {
					if (bool) $('#loading').show();
					else $('#loading').hide();
				},
				droppable: true, // this allows things to be dropped onto the calendar !!!
				
				drop: function(date,ev, ui, res) { // this function is called when something is dropped
				
				    if($.session("defaultview")!="month" && $.session("defaultview")!="agendaWeek")
					{
						AssignCourse($.trim($(this).attr("id")), date, date, res.id);	
						location.reload();
					}
					else
					{
						var sdate = formatDate(date);
						var stime = formatTime(date);
						var edate = formatDate(date);
						var etime = formatTime(date);
						document.getElementById('id').value = $.trim($(this).attr("id"));
						document.getElementById('sdate').value = sdate;
						document.getElementById('stime').value = stime;
						document.getElementById('edate').value = edate;
						document.getElementById('etime').value = etime;
						
						$( "#popup" ).dialog({
						autoOpen: true,
						modal: true,
						resizable: false,
						closeOnEscape: false,
						buttons: { " Submit ":   function() {$('#frm_popup').submit();  $(this).dialog("close"); 
						/*location.reload();*/ }, 
										 "Cancel": function() { $(this).dialog("close"); location.reload();
						 }},
						 open: function(event, ui) { 
							// Get the dialog 
							var dialog = $(event.target).parents(".ui-dialog.ui-widget");
		
							// Get the buttons 
							var buttons = dialog.find(".ui-dialog-buttonpane").find("button");
		
							var okButton = buttons[0];
							var cancelButton = buttons[1];
		
							// Add class to the buttons 
							// Add class to the buttons 
							$(okButton).addClass("button1"); 
							
							$(cancelButton).addClass("button1"); 
						} 
						 });
						 $(".ui-dialog-titlebar").hide();
					}
					
					$(this).remove();
					
				},
				
				
				 eventClick: function(event, jsEvent, view) {
					
								var eventid = event.id;						
								
								window.open("appointment.php?f=cal&calendar=1&e_action=edit&id=" + eventid ,"_blank");
								
								
							//$.get('json-events.php?action=getDetail&eventid='+ eventid,
//									  function(output) {
//										$('#detailinfo').html(output);        
//									});
//									
//						$( "#popupdetail" ).dialog({
//						autoOpen: true,
//						width: 500,
//  						height: 250,
//						modal: true,
//						resizable: false,
//						closeOnEscape: false,
//						buttons: { " Submit ":   function() {$('#frm_popup').submit();  $(this).dialog("close"); 
//						/*location.reload();*/ }, 
//					    "Cancel": function() { $(this).dialog("close"); },
//										 
//										  "Remove": function() {
//											  
//				var ok = confirm("Are you sure you want to remove this appointment?");
//				
//				if(ok)
//				{
//				     $.get('json-events.php?action=delete&id='+ eventid,
//									  function(output) {
//										$('#detailinfo').html(output);        
//									});
//									$(this).dialog("close"); 
//									//location.reload();
//				}
//				else
//				{
//									
//				    $(this).dialog("close"); 
//					
//				}
//				
//										  }},
//						 open: function(event, ui) { 
//							// Get the dialog 
//							var dialog = $(event.target).parents(".ui-dialog.ui-widget");
//		
//							// Get the buttons 
//							var buttons = dialog.find(".ui-dialog-buttonpane").find("button");
//		
//							var okButton = buttons[0];
//							var cancelButton = buttons[1];
//		
//							// Add class to the buttons 
//							// Add class to the buttons 
//							$(okButton).addClass("button1"); 
//							
//							$(cancelButton).addClass("button1"); 
//						} 
//						 });
//								
////								}
                        },
		});
			
			
			
			
			
		});
		
		
		function AssignCourse(id, start, end, res) {

			var sdate = formatDate(start);
			var stime = formatTime(start);
			var edate = formatDate(end);
			var etime = formatTime(end);
			
			
			$.ajax({
				url:'json-events.php?action=add&id='+id+'&sdate='+sdate+'&stime='+stime+'&edate='+edate+'&etime='+etime+'&res='+res,
				dataType: 'json',
				async: false,
				error: function(xhr, ajaxOptions, thrownError)
				{
					console.log(xhr.status);
					console.log(thrownError);
				},
				success: function()
				{
					
				}
			});
		}
		
		function formatDate(datetime) {
			
			var dateObj = new Date(datetime);
			var dateStr = (dateObj.getMonth()+1) + "/" + dateObj.getDate() + "/" + dateObj.getFullYear();
			return dateStr; // will return mm/dd/yyyy
		}
		
		function formatTime(datetime) {
			
			var dateObj = new Date(datetime);
			var dateStr = dateObj.getHours() + ":" + dateObj.getMinutes() + ":" + dateObj.getSeconds();
			return dateStr; // will return mm/dd/yyyy
		}
		
		
		function clearDefault()
		{
		 var keyword = $("#Keywords").val();	 
		 if(keyword == "Enter Any Keywords")
			 {
				 $("#Keywords").val("");	
			 } 
			 
			 
			  var appDate = $("#appDate").val();	 
		 if(appDate == "Select Event Date")
			 {
				 $("#appDate").val("");	
			 } 
		
		 }

		
		
		
	</script>
    <style type='text/css'>	
	
	.ui-datepicker{
	
	         z-index:9999 !important;	
	}
		
		#wrap {
			width: 100%;
			}
			
		#external-events {
			float: right;
			width: 150px;
			padding: 0 10px;
			border: 1px solid #ccc;
			background: #eee;
			text-align: left;
			min-height: 50px;
			}
			
		#external-events h4 {
			font-size: 16px;
			margin-top: 0;
			padding-top: 1em;
			}
			
		.external-event { /* try to mimick the look of a real event */
			margin: 10px 0;
			padding: 2px 4px;
			background: #3366CC;
			color: #fff;
			font-size: .85em;
			cursor: pointer;
			}
		
		#external-events-selected {
			float: right;
			width: 150px;
			padding: 0 10px;
			border: 1px solid #ccc;
			background: #eee;
			text-align: left;
			min-height: 50px;
			}
			
		#external-events-selected h4 {
			font-size: 16px;
			margin-top: 0;
			padding-top: 1em;
			}
			
		.external-event-selected { /* try to mimick the look of a real event */
			margin: 10px 0;
			padding: 2px 4px;
			background: #3366CC;
			color: #fff;
			font-size: .85em;
			cursor: pointer;
			}	
	
		#calendar {
			float: left;
			width: 100%;
			}
			
		#loading {
		position: absolute;
		top: 5px;
		right: 5px;
		}	
		
		#popup, #popupdetail , #popupStaff{display:none;}
	
		
	</style>
</head>




<body>
  <table align="center" width="970" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="align:center;">
    <tr>
  
    <td valign="top">
  
  <div class="maintable">
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top"><?php include('topbar.php'); ?></td>
      </tr>
        <tr>      
        <td class="inner-block" width="100%" align="left" valign="top">
      
      <div class="m">   
        <!------------ RIGHTCOLUMN ------------>
        <table cellpadding="0" cellspacing="0" width="100%" class="wrapper" >
        <tr><td height="500" valign="top">
            <h2>Calendar</h2>
            <hr /><br />
            
            <div>
            
            <form action="calendar.php" method="post" name="frmSearch" onsubmit="clearDefault()">
            <input name="Keywords" type="text" tabindex="" title="Enter Any Keywords" class="defaultText" id="Keywords" value="<?=$Keywords?>" />
            &nbsp;&nbsp;<input type="text" tabindex="" id="appDate" name="appDate" class="datepicker defaultText"  title="Select Event Date" value="<?=$appDate==""?date("d/m/Y"):$appDate?>" >
            &nbsp;&nbsp;<input type="submit" name="btnSearch2" class="button1" value="Search" />
            </form> 
            
            <br />	<br />	
        
            <div>	
            Filtered By: 
            
              <?php 
			  if($m=="" && $staff =="")
			  {
			  ?>
            
              	<a href="calendar.php"  class="currentfilter">All</a>
              
              <?php
			  }
			  else
			  {
			  ?>
              
              <a href="calendar.php" class="TitleLink" id="SearchByAdv">All</a>
              
              <?php
			  }
			  ?>
              
              |
              
                <?php 
			  if($m!="m")
			  {
			  ?>
            
            <a href="calendar.php?m=m&staff=<?=encrypt($_SESSION["userid"],$Encrypt)?>" class="TitleLink">My</a>
              
              <?php
			  }
			  else
			  {
			  ?>
              
              	<a href="calendar.php?m=m&staff=<?=encrypt($_SESSION["userid"],$Encrypt)?>" class="currentfilter">My</a>
              
              <?php
			  }
			  ?>
              
              |
              
               <?php 
			  if($m!="o")
			  {
			  ?>
            
             <a href="calendar.php?m=o&staff=<?=encrypt($_SESSION["userid"],$Encrypt)?>" class="TitleLink">Others</a>
              <?php
			  }
			  else
			  {
			  ?>
              
              	<a href="calendar.php?m=o&staff=<?=encrypt($_SESSION["userid"],$Encrypt)?>" class="currentfilter">Others</a>
              
              <?php
			  }
			  ?>
        
           <br />	
           </div>
          
            
            </div>
            <div align="right"><a href="appointment.php" class="TitleLink">Add New Appointment</a></div>
            <br/>
                    
		  	
            
            
         <div style="clear:both; padding-bottom:5px;"></div>
            <div id='wrap'>
				<div id='calendar'></div>
                  <div style='clear:both'></div>
        </td></tr>
        </table> <!-- end wrapper right column -->
        <!------------ END RIGHTCOLUMN ------------>
    </td></tr>
    <tr><td colspan="2">
    
    <div id="popupdetail"><h3>Detail Description</h3>
           
   <form id="frm_popup" name="frm_popup" action="json-events.php" method="get">
     <input id="action" name="action" type="hidden" value="changeStaff" /> 
       <input id="id" name="id" type="hidden" value="" />
            <input id="sdate" name="sdate" type="hidden" value="" />
            <input id="stime" name="stime" type="hidden" value="" />
            <input id="edate" name="edate" type="hidden" value="" />
            <input id="etime" name="etime" type="hidden" value="" />
             
        <div id="detailinfo">
            
        </div>
     </form>   
        
        <br />
	</div>
   	
	
	
	
	
 
	</td></tr>
    
    <tr>
    <td height="10"></td>
    </tr>
    
    
    </table>
   
</body>
</html>
