<?php
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
	
	function x_eventBoxPrep($text, $type = "x", $precookie = "", $morecss = "", $buttontext = "X", $imgok = false, $imgfail = false, $imgwarn = false, $imgelse = false) {
		if($type == "ok"|| $type == "success") {if($imgok) {$img = "<img src='".$imgok."'>";} else {$img = "";} $morecss = '<div class="x_eventBox" id="x_eventBox_ok_outer"><div id="x_eventBox_ok" class="x_eventBox_inner" style="'.$morecss.'" >'.$img.$text;}
		elseif($type == "warning" || $type == "warn" || $type == "warns") {if($imgwarn) { $img = "<img src='".$imgwarn."'>";}else {$img = "";}$morecss = '<div class="x_eventBox" id="x_eventBox_warning_outer"><div id="x_eventBox_warning" class="x_eventBox_inner" style="'.$morecss.'" >'.$img.$text;}
		elseif($type == "error" || $type == "errors" || $type == "fail") {if($imgfail) {$img = "<img src='".$imgfail."'>";}else {$img = "";}$morecss = '<div class="x_eventBox" id="x_eventBox_error_outer"><div id="x_eventBox_error" class="x_eventBox_inner" style="'.$morecss.'" >'.$img.$text;}
		else {if($imgelse) {$img = "<img src='".$imgelse."'>";}else {$img = "";} $morecss = '<div id="x_eventBox_'.$type.'" class="x_eventBox" style="'.$morecss.'" >'.$img.$text;}				
		$morecss = $morecss."<button class='x_eventBoxButton' onclick='this.parentNode.parentNode.remove()'>".$buttontext."</button></div></div>";
		$_SESSION[$precookie."x_eventbox"] = $morecss;}

	function x_eventBoxShow($precookie = "") { if(@$_SESSION[$precookie."x_eventbox_skip"]) { $_SESSION[$precookie."x_eventbox_skip"] = false; return true; } echo @$_SESSION[$precookie."x_eventbox"]; unset( $_SESSION[$precookie."x_eventbox"] );   }
	function x_eventBoxSet($precookie = "") { if(isset($_SESSION[$precookie."x_eventbox"])) { return true; } else { return false; } }
	function x_eventBoxSkip($precookie = "") { $_SESSION[$precookie."x_eventbox_skip"] = true; }
