<?php 
	/*		__________ ____ ___  ___________________.___  _________ ___ ___  
			\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
			 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
			 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
			 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
					\/                 \/     \/                \/       \/  Javascript Operations */	
	header('Content-Type: application/javascript');  
?>

/* Function to get GET Parameters Value */
	function xjs_get(parameterName) {
		var result = null, tmp = [];
		location.search.substr(1).split("&") .forEach(function (item) {
		  tmp = item.split("="); if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]); });
		return result;}

/* Search for A String in URL / True if Found / False if Not */
	function xjs_inUrl(parameterName) {return window.location.href.includes(parameterName);}

/* Hide or Show Object with ID */
	function xjs_hide_id(id) 	{id.css("display", "none");}
	function xjs_show_id(id) 	{id.css("display", "block");}
	function xjs_toggle_id(id) 	{if(id.css("display") != "none") { id.css("display", "none"); } else { id.css("display", "block"); } }

/** Check if a Mail is valid **/
	function xjs_isEmail(email)  { var re = /\S+@\S+\.\S+/; return re.test(email); }

/** Create A Dynamic PopUp with X Button to Close **/
	function xjs_popup(var_text, var_entrie = "Close") { 
		var_output = "<div id='xjs_popup'><div id='xjs_popup_inner'>"+var_text+"<div id='xjs_popup_close' onclick='document.getElementById(\"xjs_popup\").remove();'>"+var_entrie+"</div></div></div>";
		document.body.insertAdjacentHTML('beforeend', var_output);
	}

/** Generate Passwords **/
	function xjs_genkey(length = 12, charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789") { retVal = ""; for (var i = 0, n = charset.length; i < length; ++i) {retVal += charset.charAt(Math.floor(Math.random() * n));} return retVal;}

