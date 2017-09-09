var xmlHttp

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
  	{
		xmlHttp=new XMLHttpRequest();
  	}
	catch (e)
	{
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}

function isDate (year, month, day) {
   month = month - 1;
   var tempDate = new Date(year,month,day);
   if ( (tempDate.getFullYear() == year) &&
        (month == tempDate.getMonth()) &&
        (day == tempDate.getDate()) ){
       return true;
   }else{
      return false;
   }
}

function isNotFuture (year,month,day ){
   month = month - 1;
   var today = new Date;
   var tempDate = new Date(year,month,day);
   if ( tempDate < today ){
       return true;
   }else{
      return false;
   }
}

function isValidDate(dateStr, resultDate) {
  var datePat = /^(\d{1,2})(\/|-)(\d{1,2})\2(\d{2}|\d{4})$/;
  var matchArray = dateStr.match(datePat);
  if (matchArray == null) {
    alert("Date is not in a valid format.")
    return false;
  }
  
  day = matchArray[1];
  month = matchArray[3];
  year = matchArray[4];
  
  if (day < 1 || day > 31) {
    alert("Day must be between 1 and 31.");
    return false;
  }

  if (month < 1 || month > 12) {
    alert("Month must be between 1 and 12.");
    return false;
  }
  
  if ((month==4 || month==6 || month==9 || month==11) && day==31) {
    alert("Month "+month+" doesn't have 31 days!")
    return false
  }
  if (month == 2) {
    var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
    if (day>29 || (day==29 && !isleap)) {
      alert("February " + year + " doesn't have " + day + " days!");
      return false;
     }
  }
  resultDate.value = month + "/" + day + "/" + year
  return true;
}

function isEmpty(strdata)
{
  var i;
  if(strdata!=null)
  {
	  for (i=0; i < strdata.length; i++) {
		if (strdata.charAt(i) != ' ') {
		  return false;
		}
	  }
  }
  return true;
}

function isAlphaNumeric(data, specialStr)
{
  var numStr = "0123456789"
  var alphaStr = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ "
  var currChar
  var i

  if (isEmpty(data)) {
    return false;
  }

  for (i=0; i < data.length; i++) {
    currChar = data.charAt(i)
    if ((numStr.indexOf(currChar) == -1) &&
        (alphaStr.indexOf(currChar) == -1) && 
        (specialStr.indexOf(currChar) == -1)) {
      return false;
    }
  }
  return true;
}

function isAlphabet(data)
{
  var numStr = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ "
  var currChar
  var i

  if (isEmpty(data)) {
    return false;
  }

  for (i=0; i < data.length; i++) {
    currChar = data.charAt(i)
    if (numStr.indexOf(currChar) == -1) {
      return false;
    }
  }
  return true;
}
function isAlphabetNew(data)
{
  var numStr = ".abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ "
  var currChar
  var i

  if (isEmpty(data)) {
    return false;
  }

  for (i=0; i < data.length; i++) {
    currChar = data.charAt(i)
    if (numStr.indexOf(currChar) == -1) {
      return false;
    }
  }
  return true;
}
function isDigit(data)
{
  var numStr = "0123456789"
  var currChar
  var i

  if (isEmpty(data)) {
    return false;
  }

  for (i=0; i < data.length; i++) {
    currChar = data.charAt(i)
    if (numStr.indexOf(currChar) == -1) {
      return false;
    }
  }
  return true;
}
function isInteger(data)
{
  var numStr = "0123456789"
  var currChar
  var i

  if (isEmpty(data)) {
    return false;
  }

  for (i=0; i < data.length; i++) {
    currChar = data.charAt(i)
    if (numStr.indexOf(currChar) == -1) {
      return false;
    }
  }
  return true;
}

function isFloat(data)
{
  var numStr = "0123456789"
  var currChar
  var decpt = 0
  var i

  if (isEmpty(data)) {
    return false;
  }

  for (i=0; i < data.length; i++) {
    currChar = data.charAt(i)
    if (numStr.indexOf(currChar) == -1) {
      if ((currChar == '.' ) && (decpt == 0)) {
        decpt++
      } else {
        return false;
      }
    }
  }
  return true;
}

function isEmail(email)
{
  var posOfAt = email.indexOf("@")
  var lastPosOfAt = email.lastIndexOf("@")
  var lastPosOfDot = email.lastIndexOf(".")
  var currChar

  if (isEmpty(email) || email.length < 5 || posOfAt != lastPosOfAt ||
      (posOfAt < 1) || (email.indexOf(" ") != -1) || 
      (lastPosOfDot <= posOfAt) || (lastPosOfDot == email.length - 1))  {
    return false;
  }
  return true;
}

function isValidNRIC(strData)
{
  var intLen = strData.length
  var intWeights = new Array(2, 7, 6, 5, 4, 3, 2)
  var strChkAlpha = new Array("A", "B", "C", "D", "E", "F", "G", "H", "I", "Z", "J")
	
  var strDigits
  var strValidAlpha
  var strCardType
  var strCardAlpha
  var i
  var strCurrDigit
  var j = 0

  if ((intLen < 8) || (intLen > 9)) {
    return false;
  }
  
  strCardAlpha = strData.charAt(intLen - 1).toUpperCase()
  
  
  strCardType = strData.charAt(0).toUpperCase()
  if ((strCardType != "S") && strCardType != "T") {
    return false;
  }
  
  strDigits = strData.substring(intLen - 8, intLen - 1)
  if (!isInteger(strDigits)) {
    return false;
  }

	for (i=0; i < strDigits.length; i++) {
	  strCurrDigit = parseInt(strDigits.charAt(i))
	  j = j + (strCurrDigit * intWeights[i]) 
	}
	
	if (strCardType == "T") {
		j = j + 4
	}
	
	j = j % 11

	j = 11 - j
	
	if (strCardAlpha == strChkAlpha[j - 1]) {
	   return true;
	} else {
	   return false;
	}	
}

function isValidFIN(strData)
{
  var intLen = strData.length
  var intWeights = new Array(2, 7, 6, 5, 4, 3, 2)
  var strChkAlpha = new Array("K", "L", "M", "N", "P", "Q", "R", "T", "U", "W", "X")
	
  var strDigits
  var strValidAlpha
  var strCardType
  var strCardAlpha
  var i
  var strCurrDigit
  var j = 0

  if ((intLen < 8) || (intLen > 9)) {
    return false;
  }
  
  strCardAlpha = strData.charAt(intLen - 1).toUpperCase()
  
  
  strCardType = strData.charAt(0).toUpperCase()
  if ((strCardType != "F") && strCardType != "G") {
    return false;
  }
  
  strDigits = strData.substring(intLen - 8, intLen - 1)
  if (!isInteger(strDigits)) {
    return false;
  }

	for (i=0; i < strDigits.length; i++) {
	  strCurrDigit = parseInt(strDigits.charAt(i))
	  j = j + (strCurrDigit * intWeights[i]) 
	}
	
	if (strCardType == "G") {
		j = j + 4
	}
	
	j = j % 11

	j = 11 - j
	
	if (strCardAlpha == strChkAlpha[j - 1]) {
	   return true;
	} else {
	   return false;
	}	
}

function Right(String, Length)
{
	if (String == null)
		return (false);

	var dest = '';
	for (var i = (String.length - 1); i >= 0; i--)
		dest = dest + String.charAt(i);

	String = dest;
	String = String.substr(0, Length);
	dest = '';

	for (var i = (String.length - 1); i >= 0; i--)
		dest = dest + String.charAt(i);

	return dest;
}

function ImageExtOk(fieldvalue) 
{
	var extension = new Array();
	extension[0] = ".png";
	extension[1] = ".gif";
	extension[2] = ".jpg";
	extension[3] = ".jpeg";
	var thisext = fieldvalue.substr(fieldvalue.lastIndexOf('.'));
	for(var i = 0; i < extension.length; i++) 
	{
		if(thisext == extension[i]) { return true; }
	}
	return false;
}

function VideoExtOk(fieldvalue) 
{
	var extension = new Array();
	extension[0] = ".mpg";
	extension[1] = ".avi";
	extension[2] = ".wmv";	
	var thisext = fieldvalue.substr(fieldvalue.lastIndexOf('.'));
	for(var i = 0; i < extension.length; i++) 
	{
		if(thisext == extension[i]) { return true; }
	}
	return false;
}

function limitText(limitField, limitCount, limitNum)
{
	if (limitField.value.length > limitNum)
	{
		limitField.value = limitField.value.substring(0, limitNum);
	}
	else
	{
		limitCount.value = limitNum - limitField.value.length;
	}
}

function numbersonly(e){
	var unicode=e.keyCode? e.keyCode : e.charCode
	if (unicode!=8 && unicode!=9 && unicode!=43 && unicode!=46)
	{ //if the key isn't the backspace key (which we should allow)
		if((unicode>=48 && unicode<=57) || (unicode>=96 && unicode<=105)) //if not a number
		 return true;
		else
		 return false;
			
	}
}

function currenciesonly(e){
	
	var unicode=e.keyCode? e.keyCode : e.charCode;

	if (unicode!=8 && unicode!=9 && unicode!=43 && unicode!=46 && unicode!=190 && unicode!=110 && unicode!=173 && unicode!=189 && unicode!=109)
	{ 

	if((unicode>=48 && unicode<=57) || (unicode>=96 && unicode<=105)) //if not a number
		 return true;
		else
		 return false;
	}
}

function testKey(e)
{
	chars= "0123456789.";
	e    = window.event;
	if(chars.indexOf(String.fromCharCode(e.keyCode))==-1) 
	window.event.keyCode=0;
}

function testKey2(e)
{
	chars= "0123456789";
	e    = window.event;
	if(chars.indexOf(String.fromCharCode(e.keyCode))==-1) 
	window.event.keyCode=0;
}

function testKey3(e)
{
	chars= "0123456789+ ";
	e    = window.event;
	if(chars.indexOf(String.fromCharCode(e.keyCode))==-1) 
	window.event.keyCode=0;
}

function write_it(status_text)
{
	window.status=status_text;
}

function CheckAvailability(UserName)
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url="checkavailability.php?userid="+UserName+"";
	xmlHttp.onreadystatechange=CheckAvailStateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function CheckAvailStateChanged()
{
	if (xmlHttp.readyState==4)
	{
		var userstatus = document.getElementById("userstatus");
		document.getElementById('ajax_load').style.display = 'none';
		userstatus.innerHTML = xmlHttp.responseText;
	}
}

function validateQuickSearch()
{
	var errormsg;
	errormsg = "";
	
	if (document.QuickSearch.txtQuickSearch.value == "")
		errormsg += "Please fill in 'Quick Search'.\n";

	if ((errormsg == null) || (errormsg == ""))
	{
		return true;
	}
	else
	{
		alert(errormsg);
		return false;
	}
}

function daysBetween(first, second) {

    // Copy date parts of the timestamps, discarding the time parts.
    var one = new Date(first.getFullYear(), first.getMonth(), first.getDate());
    var two = new Date(second.getFullYear(), second.getMonth(), second.getDate());

    // Do the math.
    var millisecondsPerDay = 1000 * 60 * 60 * 24;
    var millisBetween = two.getTime() - one.getTime();
    var days = millisBetween / millisecondsPerDay;

    // Round down.
    return Math.floor(days);
}

		
	function get_html_translation_table(table, quote_style) {
    // Returns the internal translation table used by htmlspecialchars and htmlentities  
    // 
    // version: 902.2516
    // discuss at: http://phpjs.org/functions/get_html_translation_table
    // +   original by: Philip Peterson
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: noname
    // +   bugfixed by: Alex
    // +   bugfixed by: Marco
    // %          note: It has been decided that we're not going to add global
    // %          note: dependencies to php.js. Meaning the constants are not
    // %          note: real constants, but strings instead. integers are also supported if someone
    // %          note: chooses to create the constants themselves.
    // %          note: Table from http://www.the-art-of-web.com/html/character-codes/
    // *     example 1: get_html_translation_table('HTML_SPECIALCHARS');
    // *     returns 1: {'"': '&quot;', '&': '&amp;', '<': '&lt;', '>': '&gt;'}
    
    var entities = {}, histogram = {}, decimal = 0, symbol = '';
    var constMappingTable = {}, constMappingQuoteStyle = {};
    var useTable = {}, useQuoteStyle = {};
    
    useTable      = (table ? table.toUpperCase() : 'HTML_SPECIALCHARS');
    useQuoteStyle = (quote_style ? quote_style.toUpperCase() : 'ENT_COMPAT');
    
    // Translate arguments
    constMappingTable[0]      = 'HTML_SPECIALCHARS';
    constMappingTable[1]      = 'HTML_ENTITIES';
    constMappingQuoteStyle[0] = 'ENT_NOQUOTES';
    constMappingQuoteStyle[2] = 'ENT_COMPAT';
    constMappingQuoteStyle[3] = 'ENT_QUOTES';
    
    // Map numbers to strings for compatibilty with PHP constants
    if (!isNaN(useTable)) {
        useTable = constMappingTable[useTable];
    }
    if (!isNaN(useQuoteStyle)) {
        useQuoteStyle = constMappingQuoteStyle[useQuoteStyle];
    }
    
    if (useQuoteStyle != 'ENT_NOQUOTES') {
        entities['34'] = '&quot;';
    }

    if (useQuoteStyle == 'ENT_QUOTES') {
        entities['39'] = '&#039;';
    }

    if (useTable == 'HTML_SPECIALCHARS') {
        // ascii decimals for better compatibility
        entities['38'] = '&amp;';
        entities['60'] = '&lt;';
        entities['62'] = '&gt;';
    } else if (useTable == 'HTML_ENTITIES') {
        // ascii decimals for better compatibility
	    entities['38']  = '&amp;';
	    entities['60']  = '&lt;';
	    entities['62']  = '&gt;';
	    entities['160'] = '&nbsp;';
	    entities['161'] = '&iexcl;';
	    entities['162'] = '&cent;';
	    entities['163'] = '&pound;';
	    entities['164'] = '&curren;';
	    entities['165'] = '&yen;';
	    entities['166'] = '&brvbar;';
	    entities['167'] = '&sect;';
	    entities['168'] = '&uml;';
	    entities['169'] = '&copy;';
	    entities['170'] = '&ordf;';
	    entities['171'] = '&laquo;';
	    entities['172'] = '&not;';
	    entities['173'] = '&shy;';
	    entities['174'] = '&reg;';
	    entities['175'] = '&macr;';
	    entities['176'] = '&deg;';
	    entities['177'] = '&plusmn;';
	    entities['178'] = '&sup2;';
	    entities['179'] = '&sup3;';
	    entities['180'] = '&acute;';
	    entities['181'] = '&micro;';
	    entities['182'] = '&para;';
	    entities['183'] = '&middot;';
	    entities['184'] = '&cedil;';
	    entities['185'] = '&sup1;';
	    entities['186'] = '&ordm;';
	    entities['187'] = '&raquo;';
	    entities['188'] = '&frac14;';
	    entities['189'] = '&frac12;';
	    entities['190'] = '&frac34;';
	    entities['191'] = '&iquest;';
	    entities['192'] = '&Agrave;';
	    entities['193'] = '&Aacute;';
	    entities['194'] = '&Acirc;';
	    entities['195'] = '&Atilde;';
	    entities['196'] = '&Auml;';
	    entities['197'] = '&Aring;';
	    entities['198'] = '&AElig;';
	    entities['199'] = '&Ccedil;';
	    entities['200'] = '&Egrave;';
	    entities['201'] = '&Eacute;';
	    entities['202'] = '&Ecirc;';
	    entities['203'] = '&Euml;';
	    entities['204'] = '&Igrave;';
	    entities['205'] = '&Iacute;';
	    entities['206'] = '&Icirc;';
	    entities['207'] = '&Iuml;';
	    entities['208'] = '&ETH;';
	    entities['209'] = '&Ntilde;';
	    entities['210'] = '&Ograve;';
	    entities['211'] = '&Oacute;';
	    entities['212'] = '&Ocirc;';
	    entities['213'] = '&Otilde;';
	    entities['214'] = '&Ouml;';
	    entities['215'] = '&times;';
	    entities['216'] = '&Oslash;';
	    entities['217'] = '&Ugrave;';
	    entities['218'] = '&Uacute;';
	    entities['219'] = '&Ucirc;';
	    entities['220'] = '&Uuml;';
	    entities['221'] = '&Yacute;';
	    entities['222'] = '&THORN;';
	    entities['223'] = '&szlig;';
	    entities['224'] = '&agrave;';
	    entities['225'] = '&aacute;';
	    entities['226'] = '&acirc;';
	    entities['227'] = '&atilde;';
	    entities['228'] = '&auml;';
	    entities['229'] = '&aring;';
	    entities['230'] = '&aelig;';
	    entities['231'] = '&ccedil;';
	    entities['232'] = '&egrave;';
	    entities['233'] = '&eacute;';
	    entities['234'] = '&ecirc;';
	    entities['235'] = '&euml;';
	    entities['236'] = '&igrave;';
	    entities['237'] = '&iacute;';
	    entities['238'] = '&icirc;';
	    entities['239'] = '&iuml;';
	    entities['240'] = '&eth;';
	    entities['241'] = '&ntilde;';
	    entities['242'] = '&ograve;';
	    entities['243'] = '&oacute;';
	    entities['244'] = '&ocirc;';
	    entities['245'] = '&otilde;';
	    entities['246'] = '&ouml;';
	    entities['247'] = '&divide;';
	    entities['248'] = '&oslash;';
	    entities['249'] = '&ugrave;';
	    entities['250'] = '&uacute;';
	    entities['251'] = '&ucirc;';
	    entities['252'] = '&uuml;';
	    entities['253'] = '&yacute;';
	    entities['254'] = '&thorn;';
	    entities['255'] = '&yuml;';
    } else {
        throw Error("Table: "+useTable+' not supported');
        return false;
    }
    
    // ascii decimals to real symbols
    for (decimal in entities) {
        symbol = String.fromCharCode(decimal);
        histogram[symbol] = entities[decimal];
    }
    
    return histogram;
}
function html_entity_decode( string, quote_style ) {
    // Convert all HTML entities to their applicable characters  
    // 
    // version: 901.714
    // discuss at: http://phpjs.org/functions/html_entity_decode
    // +   original by: john (http://www.jd-tech.net)
    // +      input by: ger
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // +   improved by: marc andreu
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // -    depends on: get_html_translation_table
    // *     example 1: html_entity_decode('Kevin &amp; van Zonneveld');
    // *     returns 1: 'Kevin & van Zonneveld'
    // *     example 2: html_entity_decode('&amp;lt;');
    // *     returns 2: '&lt;'
    var histogram = {}, symbol = '', tmp_str = '', entity = '';
    tmp_str = string.toString();
    
    if (false === (histogram = get_html_translation_table('HTML_ENTITIES', quote_style))) {
        return false;
    }

    // &amp; must be the last character when decoding!
    delete(histogram['&']);
    histogram['&'] = '&amp;';

    for (symbol in histogram) {
        entity = histogram[symbol];
        tmp_str = tmp_str.split(entity).join(symbol);
    }
    
    return tmp_str;
}

function addOrdinalNumberSuffix($num) {
    if ($num!=11 && $num!=12 && $num!=13){
      switch ($num % 10) {
        // Handle 1st, 2nd, 3rd
        case 1:  return $num+'st';
        case 2:  return $num+'nd';
        case 3:  return $num+'rd';
      }
    }
    return $num+'th';
  }