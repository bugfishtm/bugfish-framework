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

	function x_copy_directory($src, $dst) { 
		$dir = opendir($src);  
		@mkdir($dst);  
		while( $file = readdir($dir) ) {  
			if (( $file != '.' ) && ( $file != '..' )) {  
				if ( is_dir($src . '/' . $file) )  
				{  
					x_copy_directory($src . '/' . $file, $dst . '/' . $file);  
				}  
				else {  
					copy($src . '/' . $file, $dst . '/' . $file);  
				}  
			}  
		}  
		closedir($dir); 
	}  
			
	function x_htaccess_secure($path) {
		if(!file_exists($path."/.htaccess")) {
			file_put_contents($path."/.htaccess", "# Deny a Folders Access\r\nDeny from all");
		}}
		
	function x_getRelativeFolderFromURL($url) {
			if(strpos($url, "http://")) { $url = substr($url, 7); }
			elseif(strpos($url, "https://")) { $url = substr($url, 8); }
			if(strpos($url, "/") > 1) { $url = substr($url, strpos($url, "/")); return $url; }
			else { return "/"; }
	}	
	
	function x_firstimagetext($text, $all = false) {
		@preg_match_all('/<img[^>]+>/i', $text, $result11); 
		@preg_match_all('/(src)=("[^"]*")/i', $result11[0][0], $img);
		if($all) { return $img[0]; }
		$x	=	trim($img[0][0] ?? '');
		if (trim($x ?? '') != "") { return $x; } 
		return false;}
		
	function x_connection_check($host, $port, $timeout = 1) {
		$f = @fsockopen($host, $port, $errno, $errstr, $timeout);if ($f !== false) {$res = fread($f, 1024) ;if (strlen($res) > 0 && strpos($res,'220') === 0){@fclose($f);return true;}else{@fclose($f);return false;}} 
		return false;}
		
	function x_inCLI() {
		$sapi_type = php_sapi_name();  
		if ( substr($sapi_type, 0, 3) == 'cli' /*|| substr($sapi_type, 0, 3) == 'cli'*/) { 
			return true;
		} else { return false; }}

	function x_rmdir($dir) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir . "/" . $object) == "dir") {
						x_rmdir($dir . "/" . $object); 
					} else {
						unlink($dir . "/" . $object);
					}
				}
			}
			reset($objects);
			rmdir($dir);
		}}
		
	function x_html_redirect($url, $seconds = 0) { echo '<meta http-equiv="refresh" content="'.$seconds.'; url='.$url.'">';}	

	function x_thumbnail($url, $filename, $width = 600, $height = true) {
		 $image = ImageCreateFromString(file_get_contents($url));
		 $height = $height === true ? (ImageSY($image) * $width / ImageSX($image)) : $height;
		 $output = ImageCreateTrueColor($width, $height);
		 ImageCopyResampled($output, $image, 0, 0, 0, 0, $width, $height, ImageSX($image), ImageSY($image));
		 ImageJPEG($output, $filename, 95); 
		 return $output; }

	function x_thumbnail_save($url,  $save_path = null, $width = 600, $height = true) {
		  $image = imagecreatefrompng($url);
		  $thumbnail = imagecreatetruecolor($width, $height);
		  imagecopyresized($thumbnail, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
		  imagedestroy($image);
		  if ($save_path !== null) {
			imagepng($thumbnail, $save_path);
		  }
		  imagedestroy($thumbnail);
		  return true;}

	function x_isset($val) {if(trim(@$val ?? '') != '' AND strlen(@$val) > 0 ) {return true;} else {return false;}} ## Check if a value is not null and strlen more than 1
	function x_imgValid($url) {if(!isset($url)) {return false;}else {if(is_string(trim($url ?? '')) AND strlen($url) > 3) {return @getimagesize($url);} else {return false;}} }
	function x_hsc($string) { return htmlspecialchars(@$string ?? ''); }
	function x_het($string) { return htmlentities(@$string ?? ''); }
	function x_trim($string) { return trim(@$string ?? ''); }
	function x_contains_cyrillic($val)  ## Check if a String contains cyrillic chars
		{$contains_cyrillic = (bool) preg_match('/[\p{Cyrillic}]/u', $val);if ($contains_cyrillic) { return true; } else {return false;}}
	function x_contains_bad_word($val) { ## Check if String Contains bad Words by Filter
			if(strpos($val, " porn ") !== false){ return false; }
			if(strpos($val, " Porn ") !== false){ return false; }
		  return true;}
	function x_contains_url($val) { ## Check if String Contains URL
			if(strpos($val, "http://") !== false){ return false; }
			if(strpos($val, "https://") !== false){ return false; }
		  return true;}
	function x_getint($val) { if(is_numeric(@$_GET[$val])) { return @$_GET[$val];} else { return false;}} ## Get a GET value if INT
	function x_postint($val) { if(is_numeric(@$_POST[$val])) { return @$_POST[$val];} else { return false;}} ## Get a POST value if INT
	function x_get($val) {if(isset($_GET[$val])) { return @$_GET[$val];} else { return false;}} ## Get a GET value
	function x_post($val) {if(isset($_POST[$val])) { return @$_POST[$val];} else { return false;}} ## Get a POST value
	function x_datediff_before($d1, $d2, $length)  ## x_datediff_before($d1, $d2, $length) Check if d1 is difference as length with d2 
		{if($d1 == false OR $d2 == false) { return false; } {}$interval = date_diff(date_create($d1), date_create($d2));if( $interval->format('%a') > $length ) { return true;} return false;}