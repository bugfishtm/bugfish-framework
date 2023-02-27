<?php  
	/*
		__________              _____.__       .__     
		\______   \__ __  _____/ ____\__| _____|  |__  
		 |    |  _/  |  \/ ___\   __\|  |/  ___/  |  \ 
		 |    |   \  |  / /_/  >  |  |  |\___ \|   Y  \
		 |______  /____/\___  /|__|  |__/____  >___|  /
				\/     /_____/               \/     \/  Captcha Generation File */
	require_once("../settings.php");
	x_captcha(_XFP_COOKIES_."captcha_comment", "200", "70", mt_rand(6, 12), mt_rand(6, 12), false, _BTM_MAIN_FOLDER_."_theme/global/font/font_captcha.ttf", mt_rand(1000, 9999)));
?>  