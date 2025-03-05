	/* 
		 ____  __  __  ___  ____  ____  ___  _   _ 
		(  _ \(  )(  )/ __)( ___)(_  _)/ __)( )_( )
		 ) _ < )(__)(( (_-. )__)  _)(_ \__ \ ) _ ( 
		(____/(______)\___/(__)  (____)(___/(_) (_) www.bugfish.eu
			  ___                                         _     
			 / __)                                       | |    
			| |__ ____ ____ ____   ____ _ _ _  ___   ____| |  _ 
			|  __) ___) _  |    \ / _  ) | | |/ _ \ / ___) | / )
			| | | |  ( ( | | | | ( (/ /| | | | |_| | |   | |< ( 
			|_| |_|   \_||_|_|_|_|\____)\____|\___/|_|   |_| \_)
		Copyright (C) 2024 Jan Maurice Dahlmanns [Bugfish]

		This program is free software: you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation, either version 3 of the License, or
		(at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program.  If not, see <https://www.gnu.org/licenses/>.
	*/
	/* ################################################################## */
	/* Function to get GET Parameters Value */
	/* ################################################################## */
	function xjs_get(parameterName) {
		var result = null, tmp = [];
		location.search.substr(1).split("&") .forEach(function (item) {
		  tmp = item.split("="); if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]); });
		return result;}	
	/* ################################################################## */
	/* Search for A String in URL / True if Found / False if Not */
	/* ################################################################## */
	function xjs_in_url(parameterName) {return window.location.href.includes(parameterName);}
	/* ################################################################## */
	/* Hide or Show Object with ID */
	/* ################################################################## */
	function xjs_hide_id(id) 	{id.css("display", "none");}
	function xjs_show_id(id) 	{id.css("display", "block");}
	function xjs_toggle_id(id) 	{if(id.css("display") != "none") { id.css("display", "none"); } else { id.css("display", "block"); } }
	/* ################################################################## */
	/** Check if a Mail is valid **/
	/* ################################################################## */
	function xjs_is_email(email)  { var re = /\S+@\S+\.\S+/; return re.test(email); }
	/* ################################################################## */
	/** Create A Dynamic PopUp with X Button to Close **/
	/* ################################################################## */
	function xjs_popup(var_text, var_entrie = "Close") { 
		var_output = "<div id='xjs_popup'><div id='xjs_popup_inner'>"+var_text;
		if(var_entrie) { var_output = var_output+"<div id='xjs_popup_close' onclick='document.getElementById(\"xjs_popup\").remove();'>"+var_entrie+"</div>"; }
		var_output = var_output+"</div></div>";
		document.body.insertAdjacentHTML('beforeend', var_output);}
	/* ################################################################## */
	/** Generate Passwords **/
	/* ################################################################## */
	function xjs_genkey(length = 12, charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789") { retVal = ""; for (var i = 0, n = charset.length; i < length; ++i) {retVal += charset.charAt(Math.floor(Math.random() * n));} return retVal;}
	/* ################################################################## */
	/** Sort a Dropdown Menu alphabetically **/
	/* ################################################################## */
	function xjs_dropdown_sort_abc(idname) {
		// Select the dropdown by its ID
		var dropdown = document.getElementById(idname);
		// Get the options and convert to array for sorting
		var options = Array.from(dropdown.options);
		// Sort the options based on their text content
		options.sort(function(a, b) { return a.text.localeCompare(b.text); });
		// Remove existing options
		while (dropdown.options.length > 0) { dropdown.remove(0); }
		// Add sorted options back to the dropdown
		options.forEach(function(option) {
			dropdown.add(option);
		});
	}
	/* End of Bugfish Framework Javascript Library...
	/* ################################################################## */