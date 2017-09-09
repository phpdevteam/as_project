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
		$('#dateSearch').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#dateSearch')!=null && $('#dateSearch').val() != '')
		 {
			var all_date =  $('#dateSearch').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#dateSearch').DatePicker({
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
				$('#dateSearch').val(formated.join(' - '));
				 $('#dateSearch').removeClass("defaultTextActive");
			}
		});
		var now = new Date();		
		var now2 = new Date('2013-12-25');			
		$('#leaveDate').DatePicker({
			format:'d/m/Y',
			date: [new_date1, new_date2],
			calendars: 3,
			mode: 'range',
			starts: 1,
			minDays: 3,
			maxDays: 7,
			position: 'bottom',
			/*onRender: function(date) {				
				return {					
					disabled: (date.valueOf() < now.valueOf())					
				}
			},*/			
			onChange: function(formated, dates){
				$('#leaveDate').val(formated.join(' - '));
				 $('#leaveDate').removeClass("defaultTextActive");
			}
		});
		
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#dateSearch2').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#dateSearch2')!=null && $('#dateSearch2').val() != '')
		 {
			var all_date =  $('#dateSearch').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#dateSearch2').DatePicker({
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
				$('#dateSearch2').val(formated.join(' - '));
				 $('#dateSearch2').removeClass("defaultTextActive");
			}
		});
		///// 
		
		/////
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#dateRange').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#dateRange')!=null && $('#dateRange').val() != '')
		 {
			var all_date =  $('#dateRange').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
			
			
			$('#dateRange').DatePicker({
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
				$('#dateRange').val(formated.join(' - '));
				 $('#dateRange').removeClass("defaultTextActive");
			}
		});
		/////
		
		/////
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#submittedDate').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#submittedDate')!=null && $('#submittedDate').val() != '')
		 {
			var all_date =  $('#complaintDate').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#submittedDate').DatePicker({
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
				$('#submittedDate').val(formated.join(' - '));
			}
		});
		//////
		
		///// 
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date();
		$('#startEndDate').attr('readonly','readonly');
		 var new_date1 =new Date(now3);
		 var new_date2 =new Date(now4);
		 if($('#startEndDate')!=null && $('#startEndDate').val() != '')
		 {
			var all_date =  $('#startEndDate').val();
			if(all_date!=null && all_date!="")
			{
				all_date = all_date.split("-");
				new_date1 = all_date[0];
				new_date2 = $.trim(all_date[1]);
			}
 		 }
		 
		$('#startEndDate').DatePicker({
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
				$('#startEndDate').val(formated.join(' - '));
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