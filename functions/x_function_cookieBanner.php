<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  Cookie Banner Functions */

	function x_cookieBanner_Pre($precookie = "", $redirect = true) { 
		if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
		if(@$_SESSION[$precookie ."x_cookieBanner"] == true) { return false; }
		$set = false;
			if(@$_POST["x_cookieBanner"] == "request") { $_SESSION[$precookie ."x_cookieBanner"] = true; $set = true; }
			if(@$_GET["x_cookieBanner"] == "request")  { $_SESSION[$precookie ."x_cookieBanner"] = true; $set = true; }
			if($set AND $redirect) { Header("Location: ".@$_SERVER['REQUEST_URI']); exit(); }
	}

	function x_cookieBanner($precookie = "", $use_post = false, $text = false) { 
		if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
		if(@$_GET["x_cookieBanner"] == "request")  { $_SESSION[$precookie ."x_cookieBanner"] = true; }
		if(@$_SESSION[$precookie ."x_cookieBanner"] == true) { return false; }
		
		if($text == false) { $text =  "This Website is using <a href='/cookies' target='_blank'>Session Cookies</a> for Site Functionality.";}
		
		echo '<div id="x_cookieBanner">';
			echo '<div id="x_cookieBanner_inner">';
				echo $text;
				if(!$use_post) { 
					echo '<form method="get"><input type="submit" value="I Agree" class="x_cookieBanner_close"><input type="hidden" value="submit" name="x_cookieBanner"></form>'; 
				} else { 
					echo '<form method="post"><input type="submit" value="I Agree" class="x_cookieBanner_close"><input type="hidden" value="submit" name="x_cookieBanner"></form>';
				}
			echo '</div>';		
		echo '</div>';
	}
?>