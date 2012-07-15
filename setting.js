/**
 *     WP fade in text news
 *     Copyright (C) 2012  www.gopipulse.com
 *     http://www.gopipulse.com/work/2011/04/22/wordpress-plugin-wp-fadein-text-news/
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
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

function _FadeIn_help()
{
	window.open("http://www.gopipulse.com/work/2011/04/22/wordpress-plugin-wp-fadein-text-news/");
}