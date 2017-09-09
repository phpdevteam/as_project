$(function() {
	
	

$("#programtypeID").change(function(){
	$.post("../ajax/demo1.php",{e_action:'getSubtype',cid1:$(this).val()},function(result){
			$("#programsubtypeID").html(result);				
			$( "#programsubtypeID" ).trigger("chosen:updated");	
	});
 });

$("#programsubtypeID").change(function(){
	
	$.post("../ajax/demo1.php",{e_action:'getSubSubtype',sid1:$(this).val()},function(result){
			$("#programsubsubtypeID").html(result);
			$("#programsubsubtypeID" ).trigger("chosen:updated");		
	});
 });
	
});


var xmlhttp;
function showUser(str,age,getSubSubtype12) {

	
    if (str == "" && age == "") {
        document.getElementById("programtypeID").innerHTML = "";
        document.getElementById("programsubtypeID").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
              
            }
		};

		xmlhttp.open("GET","../ajax/demo1.php?e_action12="+getSubSubtype12+"&q="+str+"&a="+age,true);
	
        xmlhttp.send();
    }
}





	
	