<?php
	/* 
		 ______  _     _ _______ _______ _  ______ _     _ 
		(____  \(_)   (_|_______|_______) |/ _____|_)   (_)
		 ____)  )_     _ _   ___ _____  | ( (____  _______ 
		|  __  (| |   | | | (_  |  ___) | |\____ \|  ___  |
		| |__)  ) |___| | |___) | |     | |_____) ) |   | |
		|______/ \_____/ \_____/|_|     |_(______/|_|   |_|
		Copyright (C) 2024 Jan Maurice Dahlmanns [Bugfish]

		This program is free software; you can redistribute it and/or
		modify it under the terms of the GNU Lesser General Public License
		as published by the Free Software Foundation; either version 2.1
		of the License, or (at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU Lesser General Public License for more details.

		You should have received a copy of the GNU Lesser General Public License
		along with this program; if not, see <https://www.gnu.org/licenses/>.
	*/
			
	########################################################################
	// Get Curl Request Return Text
	########################################################################
	function x_curl_gettext($url) 
	{ 
		$ch = curl_init();
		$user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,120);
		curl_setopt($ch,CURLOPT_TIMEOUT,120);
		curl_setopt($ch,CURLOPT_MAXREDIRS,10);
		return  curl_exec ($ch);
	}				
			
	########################################################################
	// Curl Download a File
	########################################################################
	function x_curl_getfile($file, $newFileName) { 
		$err_msg = ''; 
		$out = fopen($newFileName, 'wb'); 
		if ($out == FALSE){ 
		  exit; 
		} 
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_FILE, $out); 
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_URL, $file); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_exec($ch); 
		curl_close($ch); 
		fclose($out); 
	}				
		