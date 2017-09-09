





function setActivities(fromfield,rowid,rowcolor,count) { 
	var total = 0;
	total = parseInt(count);
	if(fromfield.checked == true)
	{				
		for(var i=1;i<=total;i++)
		{
			if(document.getElementById('Row'+i+'ID'+rowid)!=null)
			document.getElementById('Row'+i+'ID'+rowid).className='gridline3'; // Cross-browser
		}
	}
	else
	{
		for(var i=1;i<=total;i++)
		{
			if(document.getElementById('Row'+i+'ID'+rowid)!=null)
			document.getElementById('Row'+i+'ID'+rowid).className=rowcolor; // Cross-browser
		}
	}
}


  function ClearAll(frmName)
	{
	 
		
		for (var i=0;i<eval("document."+frmName+".elements").length;i++) {
			if (eval("document."+frmName+".elements["+i+"]").type == "text" || eval("document."+frmName+".elements["+i+"]").type == "textarea")
				eval("document."+frmName+".elements["+i+"]").value = "";  
			else if (eval("document."+frmName+".elements["+i+"]").type == "select-one")
				eval("document."+frmName+".elements["+i+"]").selectedIndex = 0;
			else if (eval("document."+frmName+".elements["+i+"]").type == "checkbox")
				eval("document."+frmName+".elements["+i+"]").checked = false;
		}
		
		 $( ".dropdown1" ).trigger("chosen:updated");
		
		
		if(frmName == "QuickSearch")
		{
		$(".defaultText").blur(); 
		}
		
		
	}

function checkSelected(formname, msgtype, count)
{
	for(var i=1 ; i<=count; i++)
	{
		if(formname!="")
		{
			if(eval("document." + formname + "." + msgtype + i)!=null)
			{
				if(eval("document." + formname + "." + msgtype + i + ".type") == "checkbox")
				{
					if(eval("document." + formname + "." + msgtype + i + ".checked") == true)
					{
						return true;
					}
				}
			}
		}
	}
	return false;
}

function CheckUnChecked(formName, msgType, count, chkbxName, columncount)
		{
			var colcount = 0;
			colcount = parseInt(columncount);
			
			if (chkbxName.checked==true)
			{
				for (var i = 1; i<=count; i++)
				{
					if(eval("document."+formName)!=null)
					{
						if(eval("document."+formName+"."+msgType+i)!=null)
						{
						 eval("document."+formName+"."+msgType+i+".checked = true");
						}
						 
						 for(var j=1;j<=colcount;j++)
						 {	
							if(document.getElementById('Row'+j+'ID'+i)!=null)	
							{				
								document.getElementById('Row'+j+'ID'+i).className='gridline3'; // Cross-browser
							}
						 }
					}
				}
				
			}
			else
			{
				var rowcolor ='gridline1';
				for (var i = 1; i<=count; i++)
				{
					if(eval("document."+formName)!=null)
					{
						if(eval("document."+formName+"."+msgType+i+"!=null"))
						 eval("document."+formName+"."+msgType+i+".checked = false");
						 if(rowcolor=='gridline2')
						 {
							 rowcolor='gridline1';
						 }
						 else
						 {
							  rowcolor='gridline2';
						 }
						 for(var j=1;j<=colcount;j++)
						 {
							if(document.getElementById('Row'+j+'ID'+i)!=null)	
							document.getElementById('Row'+j+'ID'+i).className=rowcolor; // Cross-browser
						 }
					}
				}
			}
		}
		$(function() {
			
			
		
		$("#programtypeID").change(function(){
			$.post("../ajax/getajax.php",{e_action:'getSubtype',cid1:$(this).val()},function(result){
					$("#programsubtypeID").html(result);				
					$( "#programsubtypeID" ).trigger("chosen:updated");	
			});
		 });
		
		$("#programsubtypeID").change(function(){
			
			$.post("../ajax/getajax.php",{e_action:'getSubSubtype',sid1:$(this).val()},function(result){
					$("#programsubsubtypeID").html(result);
					$("#programsubsubtypeID" ).trigger("chosen:updated");		
			});
		 });
			
		});


  
$(function() {
	
	$(document).on('click','#addFile',function(event){
		
		event.preventDefault();
		
		 var thisRow = $('#tblFiles tr:last');
		 $( thisRow ).clone().insertAfter( thisRow );
		thisRow = $('#tblFiles tr:last');
		$( thisRow ).find('.sno').html($('#tblFiles tr').length - 1);		 
			
		 		
	});
	
$(".clickableRow").click(function(e) {

 if (e.target instanceof HTMLInputElement || e.target instanceof HTMLAnchorElement){
        return;
        }
       window.location.href = $(this).attr("href");

 });
	
	  $( ".dialog" ).dialog({
		  autoOpen: false,
		  minWidth: 850,
		  show: "blind",
		  resizable: false,
		  modal: true,
		  hide: "explode"
	  });
	
	 $( ".datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "dd/mm/yy"
		});
		
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
		
		$( "#salesType" ).on('change',function (){
			if($("#tdProductName").html!=null)
			{
				$.post("../ajax/getProductNameDDL.php",{sType:$( "#salesType" ).val()},function(result){
						$("#tdProductName").html(result);
						$( "#productID" ).chosen();
				});
			}
		});
		
		

	$("#countryid").change(function(){
		$.post("../ajax/getajax.php",{e_action:'getState',cid:$(this).val()},function(result){
				$("#stateproid").html(result);				
				$( "#stateproid" ).trigger("chosen:updated");	
	    });
 	});
	
	$("#stateproid").change(function(){
		
		$.post("../ajax/getajax.php",{e_action:'getCity',sid:$(this).val()},function(result){
				$("#cityid").html(result);
				$("#cityid" ).trigger("chosen:updated");		
	    });
	 });
	 




		
});
		


