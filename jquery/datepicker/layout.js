(function($){
	var initLayout = function() {
	
		var hash = window.location.hash.replace('#', '');
		var currentTab = $('ul.navigationTabs a')
							.bind('click', showTab)
							.filter('a[rel=' + hash + ']');
		if (currentTab.size() == 0) {
			currentTab = $('ul.navigationTabs a:first');
		}
		//showTab.apply(currentTab.get(0));
		$('#date').DatePicker({});
		var now = new Date();
		now.addDays(-10);
		var now2 = new Date();
		now2.addDays(-5);
		now2.setHours(0,0,0,0);
		$('#date2').DatePicker({
			flat: true,
			date: ['2008-07-31', '2008-07-28'],
			current: '2008-07-31',
			format: 'Y-m-d',
			calendars: 1,
			mode: 'multiple',
			onRender: function(date) {
				return {
					disabled: (date.valueOf() < now.valueOf()),
					className: date.valueOf() == now2.valueOf() ? 'datepickerSpecial' : false
				}
			},
			onChange: function(formated, dates) {
			},
			starts: 0
		});
		$('#clearSelection').bind('click', function(){
			$('#date3').DatePickerClear();
			return false;
		});
		$('#date3').DatePicker({
			flat: true,
			date: ['2009-12-28','2010-01-23'],
			current: '2010-01-01',
			calendars: 3,
			mode: 'range',
			starts: 1
		});
		
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#dateOfJobIssue').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#dateOfJobIssue')!=null && $('#dateOfJobIssue').val() != '')
		 {
			var all_date =  $('#dateOfJobIssue').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#dateOfJobIssue').DatePicker({
			format:'d/m/Y',
			date: [new_date1, new_date2],
 			calendars: 3,
			mode: 'range',
 			starts: 1,
			position: 'bottom',
			onBeforeShow: function(){
			    //	$('#inputDate').DatePickerSetDate($('#inputDate').val(), true);
			},
			onChange: function(formated, dates){
				$('#dateOfJobIssue').val(formated.join(' - '));
			}
		});
		///// 
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#complaintDate').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#complaintDate')!=null && $('#complaintDate').val() != '')
		 {
			var all_date =  $('#complaintDate').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#complaintDate').DatePicker({
			format:'d/m/Y',
			date: [new_date1, new_date2],
 			calendars: 3,
			mode: 'range',
 			starts: 1,
			position: 'bottom',
			onBeforeShow: function(){
			    //	$('#inputDate').DatePickerSetDate($('#inputDate').val(), true);
			},
			onChange: function(formated, dates){
				$('#complaintDate').val(formated.join(' - '));
			}
		});
		//////
		
		///// 
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#jdatePaid').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#jdatePaid')!=null && $('#jdatePaid').val() != '')
		 {
			var all_date =  $('#jdatePaid').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#jdatePaid').DatePicker({
			format:'d/m/Y',
			date: [new_date1, new_date2],
 			calendars: 3,
			mode: 'range',
 			starts: 1,
			position: 'bottom',
			onBeforeShow: function(){
			    //	$('#inputDate').DatePickerSetDate($('#inputDate').val(), true);
			},
			onChange: function(formated, dates){
				$('#jdatePaid').val(formated.join(' - '));
			}
		});
		//////
		
		///// 
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#dateOfServicing').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#dateOfServicing')!=null && $('#dateOfServicing').val() != '')
		 {
			var all_date =  $('#dateOfServicing').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#dateOfServicing').DatePicker({
			format:'d/m/Y',
			date: [new_date1, new_date2],
 			calendars: 3,
			mode: 'range',
 			starts: 1,
			position: 'bottom',
			onBeforeShow: function(){
			    //	$('#inputDate').DatePickerSetDate($('#inputDate').val(), true);
			},
			onChange: function(formated, dates){
				$('#dateOfServicing').val(formated.join(' - '));
			}
		});
		//////
		
		///// 
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#updatedDate').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#updatedDate')!=null && $('#updatedDate').val() != '')
		 {
			var all_date =  $('#updatedDate').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#updatedDate').DatePicker({
			format:'d/m/Y',
			date: [new_date1, new_date2],
 			calendars: 3,
			mode: 'range',
 			starts: 1,
			position: 'bottom',
			onBeforeShow: function(){
			    //	$('#inputDate').DatePickerSetDate($('#inputDate').val(), true);
			},
			onChange: function(formated, dates){
				$('#updatedDate').val(formated.join(' - '));
			}
		});
		//////
		
		///// 
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#dateOfServicing').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#dateOfServicing')!=null && $('#dateOfServicing').val() != '')
		 {
			var all_date =  $('#dateOfServicing').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#dateOfServicing').DatePicker({
			format:'d/m/Y',
			date: [new_date1, new_date2],
 			calendars: 3,
			mode: 'range',
 			starts: 1,
			position: 'bottom',
			onBeforeShow: function(){
			    //	$('#inputDate').DatePickerSetDate($('#inputDate').val(), true);
			},
			onChange: function(formated, dates){
				$('#dateOfServicing').val(formated.join(' - '));
			}
		});
		//////
		
			///// 
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#firstServicingDate').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#firstServicingDate')!=null && $('#firstServicingDate').val() != '')
		 {
			var all_date =  $('#firstServicingDate').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#firstServicingDate').DatePicker({
			format:'d/m/Y',
			date: [new_date1, new_date2],
 			calendars: 3,
			mode: 'range',
 			starts: 1,
			position: 'bottom',
			onBeforeShow: function(){
			    //	$('#inputDate').DatePickerSetDate($('#inputDate').val(), true);
			},
			onChange: function(formated, dates){
				$('#firstServicingDate').val(formated.join(' - '));
			}
		});
		//////
		
			///// 
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#secondServicingDate').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#secondServicingDate')!=null && $('#secondServicingDate').val() != '')
		 {
			var all_date =  $('#secondServicingDate').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#secondServicingDate').DatePicker({
			format:'d/m/Y',
			date: [new_date1, new_date2],
 			calendars: 3,
			mode: 'range',
 			starts: 1,
			position: 'bottom',
			onBeforeShow: function(){
			    //	$('#inputDate').DatePickerSetDate($('#inputDate').val(), true);
			},
			onChange: function(formated, dates){
				$('#secondServicingDate').val(formated.join(' - '));
			}
		});
		//////
		
			///// 
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#thirdServicingDate').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#thirdServicingDate')!=null && $('#thirdServicingDate').val() != '')
		 {
			var all_date =  $('#thirdServicingDate').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#thirdServicingDate').DatePicker({
			format:'d/m/Y',
			date: [new_date1, new_date2],
 			calendars: 3,
			mode: 'range',
 			starts: 1,
			position: 'bottom',
			onBeforeShow: function(){
			    //	$('#inputDate').DatePickerSetDate($('#inputDate').val(), true);
			},
			onChange: function(formated, dates){
				$('#thirdServicingDate').val(formated.join(' - '));
			}
		});
		//////
		
			///// 
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#fourthServicingDate').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#fourthServicingDate')!=null && $('#fourthServicingDate').val() != '')
		 {
			var all_date =  $('#fourthServicingDate').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#fourthServicingDate').DatePicker({
			format:'d/m/Y',
			date: [new_date1, new_date2],
 			calendars: 3,
			mode: 'range',
 			starts: 1,
			position: 'bottom',
			onBeforeShow: function(){
			    //	$('#inputDate').DatePickerSetDate($('#inputDate').val(), true);
			},
			onChange: function(formated, dates){
				$('#fourthServicingDate').val(formated.join(' - '));
			}
		});
		//////
		
		///// 
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#fifthServicingDate').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#fifthServicingDate')!=null && $('#fifthServicingDate').val() != '')
		 {
			var all_date =  $('#fifthServicingDate').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#fifthServicingDate').DatePicker({
			format:'d/m/Y',
			date: [new_date1, new_date2],
 			calendars: 3,
			mode: 'range',
 			starts: 1,
			position: 'bottom',
			onBeforeShow: function(){
			    //	$('#inputDate').DatePickerSetDate($('#inputDate').val(), true);
			},
			onChange: function(formated, dates){
				$('#fifthServicingDate').val(formated.join(' - '));
			}
		});
		//////
		
		///// 
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#sixthServicingDate').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#sixthServicingDate')!=null && $('#sixthServicingDate').val() != '')
		 {
			var all_date =  $('#sixthServicingDate').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#sixthServicingDate').DatePicker({
			format:'d/m/Y',
			date: [new_date1, new_date2],
 			calendars: 3,
			mode: 'range',
 			starts: 1,
			position: 'bottom',
			onBeforeShow: function(){
			    //	$('#inputDate').DatePickerSetDate($('#inputDate').val(), true);
			},
			onChange: function(formated, dates){
				$('#sixthServicingDate').val(formated.join(' - '));
			}
		});
		//////
		
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date()
		$('#widgetCalendar').DatePicker({
			flat: true,
			format: 'd B, Y',
			date: [new Date(now3), new Date(now4)],
			calendars: 3,
			mode: 'range',
			starts: 1,
			onChange: function(formated) {
				$('#widgetField span').get(0).innerHTML = formated.join(' &divide; ');
			}
		});
		var state = false;
		$('#widgetField>a').bind('click', function(){
			$('#widgetCalendar').stop().animate({height: state ? 0 : $('#widgetCalendar div.datepicker').get(0).offsetHeight}, 500);
			state = !state;
			return false;
		});
		$('#widgetCalendar div.datepicker').css('position', 'absolute');
	};
	
	var showTab = function(e) {
		var tabIndex = $('ul.navigationTabs a')
							.removeClass('active')
							.index(this);
		$(this)
			.addClass('active')
			.blur();
		$('div.tab')
			.hide()
				.eq(tabIndex)
				.show();
	};
	
	EYE.register(initLayout, 'init');
})(jQuery)