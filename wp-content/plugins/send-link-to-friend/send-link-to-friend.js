var http_request = false;
function makePOSTRequest(url, parameters) {
  http_request = false;
  if (window.XMLHttpRequest) { // Mozilla, Safari,...
	 http_request = new XMLHttpRequest();
	 if (http_request.overrideMimeType) {
		// set type accordingly to anticipated content type
		//http_request.overrideMimeType('text/xml');
		http_request.overrideMimeType('text/html');
	 }
  } else if (window.ActiveXObject) { // IE
	 try {
		http_request = new ActiveXObject("Msxml2.XMLHTTP");
	 } catch (e) {
		try {
		   http_request = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e) {}
	 }
  }
  if (!http_request) {
	 alert('Cannot create XMLHTTP instance');
	 return false;
  }
  //alert(parameters);
  http_request.onreadystatechange = alertContents;
  http_request.open('POST', url, true);
  http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http_request.setRequestHeader("Content-length", parameters.length);
  http_request.setRequestHeader("Connection", "close");
  http_request.send(parameters);
}

String.prototype.trim = function () 
{
    return this.replace(/^\s*/, "").replace(/\s*$/, "");
}


function alertContents() 
{
	//alert(http_request.responseText);
  if (http_request.readyState == 4) 
  {
	 if (http_request.status == 200) 
	 {
		result = http_request.responseText;
		result = result.trim();
		if(result == "Invalid security code.")
		{
			alert(http_request.responseText);
			result = http_request.responseText;
			document.getElementById('send-link-to-friend-result').innerHTML = result;   
		}
		else
		{
			alert(http_request.responseText);
			result = http_request.responseText;
			document.getElementById('send-link-to-friend-result').innerHTML = result;   
			document.getElementById("txt_friendemail").value = "";
			document.getElementById("txt_friendmessage").value = "";	
			document.getElementById("txt_captcha").value = "";
		}
	 } 
	 else 
	 {
		alert('There was a problem with the request.');
	 }
  }
}

function get(obj,url) 
{
	_e=document.getElementById("txt_friendemail");
	_c=document.getElementById("txt_captcha");
	
	var get_friends_email=_e.value;
	var friends_email_array=get_friends_email.split(",");
	var part_num=0;
	
	if(_e.value=="")
	{
		alert("Please enter the email address.");
		_e.focus();
		return false;    
	}
	if(_e.value!="" && (_e.value.indexOf("@",0)==-1 || _e.value.indexOf(".",0)==-1))
	{
		alert("Please enter valid email.");
		_e.focus();
		_e.select();
		return false;
	} 
	while (part_num < friends_email_array.length)
	{
	   if(part_num > 0)
	   {
			alert("Maximum 1 email address only.");
			return false;
	   }
	   part_num+=1;
	}
	if(_c.value=="")
	{
		alert("Please enter the security code.");
		_c.focus();
		return false;    
	}
	
	document.getElementById('send-link-to-friend-result').innerHTML = "Sending...";   
	var poststr = "txt_friendemail=" + encodeURI( document.getElementById("txt_friendemail").value ) +
					"&txt_friendmessage=" + encodeURI( document.getElementById("txt_friendmessage").value ) +
					"&txt_captcha=" + encodeURI( document.getElementById("txt_captcha").value ) +
					 "&sendlink=" + encodeURI( document.getElementById("sendlink").value );
		
	makePOSTRequest(url+'send-mail.php', poststr);
}
