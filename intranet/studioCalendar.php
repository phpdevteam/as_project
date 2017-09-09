<?php 
	session_start();
	if(!isset($_SESSION['userid']) || $_SESSION['userid']==""){
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	include('config.php');
	include('../include/functions.php');
	// include('calendar.php');
	$pagename = "Calendar";
	$RequestAll = $_REQUEST;
	
	if($RequestAll['branchID']!="All")
	{
	   $branchID = $RequestAll['branchID'];
	}
	
	
	$teacherID = $RequestAll['teacherID'];
	$stype = $RequestAll['stype'];
	$myDate = $RequestAll['myDate'];
	
	if($myDate == "")
	{
		 
		$myDate = date("d/m/Y");
		$start = time();
	}
	else
	{
		$myD = datepickerToMySQLDate($myDate);
		$start = strtotime($myD);
	}
	
	// echo ($start > time()) ? 'ok' : 'no';
	
	list($dd, $mm, $yyyy) = explode('/',$myDate);
	
	
	//Change the CSO with quiting date today or below today as Completed.
	updateCsoForQuitingDate();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?=$appname?></title>
	<script type="text/javascript" src="js/validate.js"></script>
  <link rel="stylesheet" href="libraries/jquery/chosen/docsupport/prism.css">
  <link rel="stylesheet" href="libraries/jquery/chosen/chosen.css" /> 
	<link rel="stylesheet" type="text/css" href="css/default.css" /> 
	<link rel="stylesheet" type="text/css" href="css/default1.css" /> 
    
	<script type='text/javascript' src='libraries/jquery/jquery-1.7.1.min.js'></script>
	<!--<script type='text/javascript' src='libraries/jquery/jquery-ui-1.10.4/js/jquery-ui-1.8.17.custom.min.js'></script>
	<link rel="stylesheet" type="text/css" href="libraries/jquery/jquery-ui-1.10.4/css/ui-lightness/jquery-ui-1.10.4.css"/>-->
  <script type='text/javascript' src='libraries/jquery/jquery.session.js'></script>
  
	<link rel='stylesheet' type='text/css' href='libraries/jquery/calendar/theme.css' />	
	<link rel='stylesheet' type='text/css' href='libraries/jquery/calendar/fullcalendar.css' />
	<link rel='stylesheet' type='text/css' href='libraries/jquery/calendar/fullcalendar.print.css' media='print' />
	<script type='text/javascript' src='libraries/jquery/calendar/fullcalendar.js'></script>

	<script src="libraries/jquery/calendar/external/jquery.bgiframe-2.1.2.js"></script>
	<script src="libraries/jquery/calendar/ui/jquery.ui.core.js"></script>
	<script src="libraries/jquery/calendar/ui/jquery.ui.widget.js"></script>
	<script src="libraries/jquery/calendar/ui/jquery.ui.mouse.js"></script>
	<script src="libraries/jquery/calendar/ui/jquery.ui.draggable.js"></script>
	<script src="libraries/jquery/calendar/ui/jquery.ui.position.js"></script>
	<script src="libraries/jquery/calendar/ui/jquery.ui.resizable.js"></script>
	<script src="libraries/jquery/calendar/ui/jquery.ui.dialog.js"></script>
	
	<script src="libraries/pikaday/moment.js"></script>
	<script src="libraries/pikaday/pikaday.js"></script>
	<link rel="stylesheet" type="text/css" href="libraries/pikaday/pikaday.css" />

	<script type="text/javascript" src="libraries/jquery/fancybox/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" type="text/css" href="libraries/jquery/fancybox/jquery.fancybox.css" media="screen" />
  <script type='text/javascript'>

	function AssignCourse(id, start, end, res) {		
			
			var sdate = formatDate(start);
			var stime = formatTime(start);
			var edate = formatDate(end);
			var etime = formatTime(end);
			
			// events: "tjson-events.php?action=get&mystart=<?=$start?>&teacherID=<?=$teacherID?>&stype=<?=$stype?>&branchID="+$("#branchID").val() ,
			$.ajax({
				// url:'tjson-events.php?action=add&id='+id+'&sdate='+sdate+'&stime='+stime+'&edate='+edate+'&etime='+etime+'&res='+res+'&branchID='+$("#branchID").val(),
				url:'json-events.php?action=add&id='+id+'&sdate='+sdate+'&stime='+stime+'&edate='+edate+'&etime='+etime+'&res='+res+'&branchID='+$("#branchID").val(),
				dataType: 'json',
				async: false,
				error: function(xhr, ajaxOptions, thrownError)
				{
					
				},
				success: function()
				{
					
				}
			});
		}
		
	function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
		function z(n){
			return (n<10? '0':'') + n;
		}
		var bits = time.split(':');
		var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

		return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
	}
	
	function validCheckCsoTime()
	{
		var sTime = $.trim($("#fromTime").val() + ":00");
		var eTime = $.trim($("#toTime").val()  + ":00");
		
		if(sTime.length < 8 || eTime.length < 8)
		{
			alert("Please choose the time range!");
			return false;
		}
		else
		{
			if(Date.parse('01/01/2011 '+eTime) <= Date.parse('01/01/2011 '+sTime))
			{
			   alert("Invalid time range!");
			   return false;
			}
			
			//Check user select within the time range.
			var arrTime = $.trim($("#availableTime").val()).split(' ');
			var check = 0;
			for (var mj = 0; mj < arrTime.length; mj++) {
				var arrTimeIndi = arrTime[mj].split('to');
				
				if(((Date.parse('01/01/2011 '+arrTimeIndi[0])) <= (Date.parse('01/01/2011 '+sTime))) && 
				   ((Date.parse('01/01/2011 '+arrTimeIndi[1])) >= (Date.parse('01/01/2011 '+eTime))))
				   {
					   check = 1;
					   break;
				   }
			}
			
			if(check == 0)
			{
				alert("Invalid time range! \nPlease check FROM and TO time are within teacher available time.");
			   return false;
			}
		}
		
		var checkCsoOption = $.trim($("input[name=changeall]:checked").val());
		if(checkCsoOption == '')
		{
			alert("Please select the radio button change CSO either for this class or following classes");
			return false;
		}		
		
		var ok = confirm('Are you sure want to change this CSO timings?');
		if(ok)
		{
			//Send request for change time.
			$.post("change_cso_timing.php",{
				checkCsoOption: checkCsoOption,
				sTime: sTime,
				eTime: eTime,
				sdate: $.trim($("#myDate").val()),
				roombookingID: $.trim($("#roombookID").val()),
			},function(data) {
				// console.log(data);
				if(data == 'success'){
					alert('Changed Successfully.');
				}
				else{
					return false;
				}
			});
		}
		else{
			return false;
		}
		return;
	}
	
	jQuery(function($) {
		
		var picker = new Pikaday(
		{
			field: document.getElementById('myDate'),
			format : "DD/MM/YYYY",
			firstDay: 1,
			minDate: new Date('2000-01-01'),
			maxDate: new Date('2020-01-01'),
			yearRange: [2000,2020]      
		});


	/*	$(".tname").mouseover(function() {
		alert('hiii');
				$(this).find(".DisplayCourse").fadeIn("slow");
				
			});*/
			
			
		/* $("#myDate").datepicker({
			showOn: 'button',
			buttonText: 'Show Date',
			buttonImageOnly: true,
			buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
			dateFormat: 'dd/mm/yy',
			constrainInput: true
		}); */
		
		$(".ui-datepicker-trigger").mouseover(function() {
				$(this).css('cursor', 'pointer');
			});

			 $(".fc-event").mouseover(function() {
                 $(this).children(".fc-event-title").show();
			}).mouseout(function() {
				 $(this).children(".fc-event-title").hide();
			});		
			
			if($.session("defaultview")=="")
			{	
				$.session("defaultview","resourceDay");
			}
		 
			var res = $.ajax({
                type: "POST",
                url: "tjson-events.php?action=getresteacherstudio&mystart=<?=$start?>&teacherID=<?=$teacherID?>&branchID="+$("#branchID").val(),
                data: "{}",
                dataType: "json",
                async: false,
                success: function (data) {
					// console.log(data);
                }
            }).responseText; 
				
			var resources = JSON.parse(res);
			
			//ExternalCourse();
			$('#external-events div.external-event').each(function() {
			
				var eventObject = {
					
  					id : $.trim($(this).attr("id")),
					title: $.trim($(this).text()),// use the element's text as the event title
				};
				
				
			
				// store the Event Object in the DOM element so we can get to it later
				$(this).data('eventObject', eventObject);
				
				// make the event draggable using jQuery UI
				$(this).draggable({
					zIndex: 999,
					revert: true,      // will cause the event to go back to its
					revertDuration: 0  //  original position after the drag
				});
				
			});
			
			
			/* initialize the calendar
			-----------------------------------------------------------------*/
			

		$('#calendar').fullCalendar({
			
			dayClick: function(event, delta, view) 
			{
				var strin = event + '';
				var strin_array = strin.split(" ");
				var selectedTime = strin_array[4];
				var selectedendTime = addMinutes(selectedTime, '15')+':00'; 
				
				var Months = {Jan:"01", Feb:"02", Mar:"03", Apr:"04", May:"05", Jun:"06",Jul:"07", Aug:"08", Sep:"09", Oct:"10", Nov:"11", Dec:"12"};
				var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
				
				//Date from search text box.
				var dd 		= <?php echo $dd ?>;
				var mm 		= <?php echo $mm ?>; //January is 0!
				var yyyy 	= <?php echo $yyyy ?>;
				
				if(dd<10) {
					dd='0'+dd
				}
				if(mm<10) {
					mm='0'+mm
				}
				
				var firstDate 	= new Date(yyyy,mm,dd);
				var secondDate 	= new Date(strin_array[3],Months[strin_array[1]],strin_array[2]);
				//Find difference between two days.
				var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
				
				//List of teachers array.
				var array_var = resources;
				
				//Using the diffDays value we can find, on which column user clicks, 
				//using this number we can find the teacher details from array_var array value.
				//for this reason we find the differene between two days.
				var mydate 	= $.trim($("#myDate").val());
				var tid		= array_var[diffDays].id;				
				var bid		= $("#branchID").val();
				
				var params 	= "teacherID="+tid+"&date="+mydate+"&branchID="+bid+
								"&selectedTime="+selectedTime+"&selectedendTime="+selectedendTime;
				var url 	= 'selectforcso2.php?'+params;
		
				$.fancybox({
					'width'				: 1000,
					'height'			: 500,
					'href'				: url,
					'autoScale'			: false,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'type'				: 'iframe',
					'closeClick': true,
					'afterClose':function () {
					  location.reload();
					}						
				});
			},
			defaultView: 'resourceDay',
			minTime: "09:00:00",
			maxTime: "21:00:00",
			axisFormat: 'HH:mm',
			theme: true,
			header: {
				left: '',//'prev,next today',
				center: 'title',
				right: ''
			},
			slotMinutes: 15,
			editable: false,
			resources:resources,				
				
			disableResizing:false,
			
			events: "tjson-events.php?action=getteacher&test=2&mystart=<?=$start?>&teacherID=<?=$teacherID?>&stype=<?=$stype?>&branchID="+$("#branchID").val() ,
			// console.log();
			loading: function(bool) {
				if (bool) $('#loading').show();
				else $('#loading').hide();
			},
				
			eventClick: function(event, jsEvent, view) {
								
				var eventid = event.id;
				var etype = event.eType;
				console.log(event);						
				// alert(etype);
				if(etype=="IND")
				{
					$.get('tjson-events.php?action=getDetailIND&eventid='+ eventid,
					function(output) {
						$('#detailinfo').html(output);        
					});
				}
				if(etype=="RB")
				{
					$.get('tjson-events.php?action=getDetailRB&eventid='+ eventid,
					function(output) {
						$('#detailinfo').html(output);        
					});
				}
				if(etype=="CSO")
				{
					var myJsonString = JSON.stringify(event);
					$.get('tjson-events.php?action=getDetailCSO&eventid='+ eventid+'&mydate='+$.trim($("#myDate").val()),
					function(output) {
						console.log(output);
						$('#popupdetail').html(output); 						
						// $( "#popupdetail" ).dialog({	autoOpen: true,	width: 500, height: 350, modal: true, resizable: false,	closeOnEscape: false});
						  
					});						
				}
				if(etype=="Lunch")
				{
				   $.get('tjson-events.php?action=getDetailLunch&mystart=<?=$start?>&eventid='+ eventid,
					function(output) {
						$('#detailinfo').html(output); 
						
						$( "#detailinfo" ).dialog({	autoOpen: true,	width: 500, height: 350, modal: true, resizable: false,	closeOnEscape: false});
					  
					});
				}
				if(etype=="unavailableTime")
				{
					$.get('tjson-events.php?action=getUnavailableTime&mystart=<?=$start?>&eventid='+ eventid+'&startun='+event.startun+'&endun='+event.endun,
					function(output) {
						$('#detailinfo').html(output); 
					
						$( "#detailinfo" ).dialog({	autoOpen: true,	width: 500, height: 350, modal: true, resizable: false,	closeOnEscape: false});
						  
					});
					
				}
				if(etype=="Dinner")
				{
					$.get('tjson-events.php?action=getDinnerTime&mystart=<?=$start?>&eventid='+ eventid,
					function(output) {
						$('#detailinfo').html(output); 
						
						$( "#detailinfo" ).dialog({	autoOpen: true,	width: 500, height: 350, modal: true, resizable: false,	closeOnEscape: false});
					});
					
				}
				if(etype!="Lunch" && etype!="unavailableTime" && etype!="Dinner")
				{
					$( "#popupdetail" ).dialog({
						autoOpen: true,
						width: 500,
						height: 500,
						modal: true,
						resizable: false,
						closeOnEscape: false,
						buttons: { " Submit ":   function() {
							if(etype == "CSO")
							{
								$('#changeCSOTime').submit();
							}
							else{
								$('#frm_popup').submit();  $(this).dialog("close"); 
							}
						}, 
						"Cancel": function() {
							$(this).dialog("close");
							location.reload();
						},
						"Remove": function() {
							var ok = confirm("Are you sure you want to remove this booking?");
							if(ok)
							{
								 $.get('tjson-events.php?action=delete&id='+ eventid,
												  function(output) {
													$('#detailinfo').html(output);        
												});
												$(this).dialog("close"); 
							}
							else
							{
								$(this).dialog("close"); 
							}
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
				}
            },
		});
			
			$('#calendar').fullCalendar( 'gotoDate', <?php echo $yyyy ;?> , <?php echo $mm-1 ;?>,  <?php echo $dd ;?>  );
			
			//$('#calendar').fullCalendar( 'gotoDate',2016 , 01,  28  );
		
	});
		

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
	
	function printdiv(printpage) {
		document.getElementById('iframediv').style.display = 'block';
		var oIframe = document.getElementById('ifrmPrint');
		var oContent = "";
		
		if(oContent == "")
		{
		 oContent = document.getElementById(printpage).innerHTML;	
		
		}
		
		var oDoc = (oIframe.contentWindow || oIframe.contentDocument);
		if (oDoc.document) oDoc = oDoc.document;
		  
		return false;
	}
	
	
	 

	
	
	
	</script>
    <style type='text/css'>	
		
		#wrap {
			width: 100%;
			margin: 0 auto;
			overflow:auto;
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
	
		
			
		#loading {
		position: absolute;
		top: 5px;
		right: 5px;
		}	
		
		#popup, #popupdetail , #popupRoom{display:none;}		


	#calendar table {
		table-layout: fixed !important;
	}

	#ui-datepicker-div
	{
		z-index:999 !important;
	}



	.myheader
	{
		width:100px !important;
	}

	.fc-view
	{
		overflow-x:auto;
	}
	
	.shClass {
		width : 50px !important; 
	}
	
	.ui-dialog-titlebar {
		display:none;
	}

	.ui-dialog-buttonset {
		margin: 5px 0 3px 5px;
	}
	
	</style>


    
</head>
<body>


 <table cellpadding="0" cellspacing="0" width="980px" bgcolor="#fff" style="margin:0 auto; border-left:solid 1px #999999; border-right:solid 1px #999999;">
    <tr><td colspan="2" bgcolor="#4db748">
        <!------------ HEADER ------------>
       	<?php 
				$align = 'right';
				include('header.php'); ?>
       	<!------------ END HEADER ------------>
    </td></tr>
    
    
		<tr>
		<td>
    
    <table width="100%" style="margin-left:1%">
    
    <tr><td bgcolor="#8bc3df" valign="bottom" class="leftcol" width="130px" >
        <!------------ LEFTCOLUMN ------------>
        <?php include('left.php'); ?>
        <!------------ END LEFTCOLUMN ------------>
    </td><td bgcolor="#ffffff" valign="top" >
        <!------------ RIGHTCOLUMN ------------>
        <table cellpadding="0" cellspacing="0"  class="wrapper" style="margin:15px;">
        <tr><td height="500" valign="top">
            <h2>MASTER FILE</h2>
            <hr />
            
            <!--<div align="right"><a href="rbcalendar.php" class="TitleLink">Course Schedule Calendar</a> | <a href="tcalendar.php" class="TitleLink">Teacher Calendar</a> | <a href="roombooking.php" class="TitleLink">Add New Booking</a> | <a href="calendar.php" class="TitleLink">Main Calendar</a></div>-->
			<div align="right"><a href="tcalendar.php" class="TitleLink" style="display:none;">Teacher Calendar</a></div>
           
            <br/>
            <? if ($_SESSION["groupid"] == 1)
			  { 
				  $db->select(''.$tb_name.'_branch','_ID,_Branch',NULL,NULL,'_StatusID="1"',NULL,'_Branch'); // Table name, Column Names, FIRST JOIN TYPE, JOIN, WHERE conditions, GROUPBY, ORDER BY conditions
			  }
			  else
			  { 
				  $db->select(''.$tb_name.'_branch','_ID,_Branch',NULL,NULL,'_StatusID="1" AND _CompanyID = "'.$_SESSION["companyid"].'"',NULL,'_Branch'); // Table name, Column Names, FIRST JOIN TYPE, JOIN, WHERE conditions, GROUPBY, ORDER BY conditions	
			  }
			  $result1 = $db->getResult();											
			 
			  foreach($result1 as $rs1){		                                       	
				  ?>
				  <a href="studioCalendar.php?branchID=<?php echo $rs1["_ID"]; ?>" class="TitleStyle">&nbsp;<?php if($rs1["_ID"] == $RequestAll['branchID']) {echo "[ <u>".$rs1["_Branch"]."</u> ]";}else if($RequestAll['branchID']=="" &&  $rs1['_ID']==$_SESSION['branchid']){echo "[ <u>".$rs1["_Branch"]."</u> ]";}else{ echo $rs1["_Branch"];} ?>&nbsp;</a>
				  <?php
				  }
				  
				  
				   if($branchID=="")
			          $branchID = $_SESSION["branchid"];
			  ?>
              
              <br/>
              <br/>
     
              
		  	<form action="studioCalendar.php" method="GET" name="frmSearch">
            <input name="branchID" id="branchID" type="hidden" value="<?=$branchID?>" />
             <input type="text" readonly="readonly" name="myDate" id="myDate" class="datepicker" value="<?=$myDate?>" >
          
            
            <input type="submit" value="Submit" name="btnSubmit" />
             <input type="button" value="Print" name="btnPrint" onclick="printdiv('wrap')" />
            </form>
            
            <div id="iframediv" align="right" style="display:none;"><iframe id='ifrmPrint' src='#' style="width:0px; height:0px;"></iframe></div>
       
             
         <div style="clear:both; padding-bottom:5px;"></div>
            <div id='wrap'>
            
            
                <div align="center"><h2><?=date("l, d F Y",$start);?></h2>
                </div>
                
				<div id='calendar'></div>
              
              <div style='clear:both'></div>
            </div>
            
              
              <style>
			  .fc-header {
				 /* display:none !important; */
			  }
			  </style>
            
        </td></tr>
        </table> <!-- end wrapper right column -->
        <!------------ END RIGHTCOLUMN ------------>
    </td></tr>
    <tr><td colspan="2">
    
     <div id="popup"><h3>Add a Room</h3>
    	<br />
        <form id="frm_popup" name="frm_popup" action="tjson-events.php" method="get">
        	<input id="action" name="action" type="hidden" value="addroom" />
            <input id="id" name="id" type="hidden" value="" />
            <input id="sdate" name="sdate" type="hidden" value="" />
            <input id="stime" name="stime" type="hidden" value="" />
            <input id="edate" name="edate" type="hidden" value="" />
            <input id="etime" name="etime" type="hidden" value="" />
            <input id="branchID" name="branchID" type="hidden" value="" />
        	<table>
            	<tr>
                	<td>
                    	Room:	
                    </td>
                    <td>
                    	<select id="res" name="res" class="dropdown1 chosen-select" >
							<?php
							
							$db->select(''.$tb_name.'_room','*',NULL,NULL,'_BranchID = "'.$branchID.'"',NULL,'_Room'); // Table name, Column Names, FIRST JOIN TYPE, JOIN, WHERE conditions, GROUPBY, ORDER BY conditions
		$result = $db->getResult();
		
		$RecordCount = count($result);
				
		 if ($RecordCount > 0) {
				$i = 1;											
				foreach($result as $rs)
				{
                                ?>
                                <option value="<?php echo $rs["_ID"]; ?>">&nbsp;<?php echo $rs["_Room"]; ?>&nbsp;</option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
        	
        </form>
	</div>
    
    <div id="popupRoom"><h3>Add a Room</h3>
    	<br />
        <form id="frm_popup" name="frm_popup" action="tjson-events.php" method="get">
        	<input id="action" name="action" type="hidden" value="addroomOnly" />
            <input id="eventid" name="eventid" type="hidden" value="" />
           
        	<table>
            	<tr>
                	<td>
                    	Room:	
                    </td>
                    <td>
                    	<select id="res" name="res" class="dropdown1 chosen-select" >
                        
                        <option value="">---Select Room---</option>
                        
							<?php
							
							$db->select(''.$tb_name.'_room','*',NULL,NULL,'_BranchID = "'.$branchID.'"',NULL,'_Room'); // Table name, Column Names, FIRST JOIN TYPE, JOIN, WHERE conditions, GROUPBY, ORDER BY conditions
		$result = $db->getResult();
		
		$RecordCount = count($result);
				
		 if ($RecordCount > 0) {
				$i = 1;											
				foreach($result as $rs)
				{
                                ?>
                                <option value="<?php echo $rs["_ID"]; ?>">&nbsp;<?php echo $rs["_Room"]; ?>&nbsp;</option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
        	
        </form>
	</div>
    
    <div id="popupdetail"><h3>Detail Description</h3>
           
        <div id="detailinfo" style="padding:10px;">
            
        </div>		
		
        <br />
	</div>
	 </td></tr>
    <tr><td colspan="2">
        <!------------ HEADER ------------>
       	<?php include('footer.php'); ?>
       	<!------------ END HEADER ------------>
	</td></tr>
    </table>
		</td>
		</tr>
	   </table>
</body>
</html>
