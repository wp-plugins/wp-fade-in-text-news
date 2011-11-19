/*
##########################################################################################################
###### Project   : Fade in text news  																######
###### File Name : content-management.php                   										######
###### Author    : Gopi.R (http://www.gopiplus.com/work/)                        					######
###### Link      : http://www.gopiplus.com/work/2011/04/22/wordpress-plugin-wp-fadein-text-news/    ######
##########################################################################################################
*/


function FadeIn_submit()
{
	if(document.FadeIn_form.FadeIn_text.value=="")
	{
		alert("Please enter the message.")
		document.FadeIn_form.FadeIn_text.focus();
		return false;
	}
	else if(document.FadeIn_form.FadeIn_link.value=="")
	{
		alert("Please enter the link.")
		document.FadeIn_form.FadeIn_link.focus();
		return false;
	}
	else if(document.FadeIn_form.FadeIn_status.value=="")
	{
		alert("Please select the display status.")
		document.FadeIn_form.FadeIn_status.focus();
		return false;
	}
	else if(document.FadeIn_form.FadeIn_group.value=="")
	{
		alert("Please enter the group name. this field is used to group the announcement.")
		document.FadeIn_form.FadeIn_group.focus();
		return false;
	}
	else if(document.FadeIn_form.FadeIn_order.value=="")
	{
		alert("Please enter the display order, only number.")
		document.FadeIn_form.FadeIn_order.focus();
		return false;
	}
	else if(isNaN(document.FadeIn_form.FadeIn_order.value))
	{
		alert("Please enter the display order, only number.")
		document.FadeIn_form.FadeIn_order.focus();
		return false;
	}
	_FadeIn_escapeVal(document.FadeIn_form.FadeIn_text,'<br>');
}

function _FadeIn_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.FadeIn_Display.action="options-general.php?page=wp-fade-in-text-news/content-management.php&AC=DEL&DID="+id;
		document.FadeIn_Display.submit();
	}
}	

function _FadeIn_redirect()
{
	window.location = "options-general.php?page=wp-fade-in-text-news/content-management.php";
}

function _FadeIn_escapeVal(textarea,replaceWith)
{
textarea.value = escape(textarea.value) //encode textarea strings carriage returns
for(i=0; i<textarea.value.length; i++)
{
	//loop through string, replacing carriage return encoding with HTML break tag
	if(textarea.value.indexOf("%0D%0A") > -1)
	{
		//Windows encodes returns as \r\n hex
		textarea.value=textarea.value.replace("%0D%0A",replaceWith)
	}
	else if(textarea.value.indexOf("%0A") > -1)
	{
		//Unix encodes returns as \n hex
		textarea.value=textarea.value.replace("%0A",replaceWith)
	}
	else if(textarea.value.indexOf("%0D") > -1)
	{
		//Macintosh encodes returns as \r hex
		textarea.value=textarea.value.replace("%0D",replaceWith)
	}
}
textarea.value=unescape(textarea.value) //unescape all other encoded characters
}