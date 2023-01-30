<?php
	/*
		__________              _____.__       .__     
		\______   \__ __  _____/ ____\__| _____|  |__  
		 |    |  _/  |  \/ ___\   __\|  |/  ___/  |  \ 
		 |    |   \  |  / /_/  >  |  |  |\___ \|   Y  \
		 |______  /____/\___  /|__|  |__/____  >___|  /
				\/     /_____/               \/     \/  Configuration File */
		#####################################################################
		##### Site Setup       ##############################################				
		define("_SITE_PATH_",			"/var/www/html/x/"); # SET DOCUMENT ROOT
		define("_SITE_COOKIE_PREFIX_",	"x_"); # Dont need to be changed
		
		#####################################################################
		##### MySQL Setup      ##############################################				
		define("_SQL_HOST_", 			"127.0.0.1"); #Mysql Host
		define("_SQL_USER_", 			"x"); # Mysql USer
		define("_SQL_PASS_", 			"x"); # Mysql Pass
		define("_SQL_DB_", 				"x"); # Mysql-DB
		define("_SQL_PREFIX_", 			"x_"); #Mysql -DB Prefix (optional to change)

		#####################################################################
		##### Include Init DO NOT CHANGE ####################################	
		# Include Framework Files
		foreach (glob(_SITE_PATH_."/_framework/classes/x_*.php") as $filename){require_once $filename;}
		foreach (glob(_SITE_PATH_."/_framework/functions/x_*.php") as $filename){require_once $filename;}
		foreach (glob(_SITE_PATH_."/_framework/functions/xfp_*.php") as $filename){require_once $filename;}
		# Include Exlcusive Files
		require_once(_SITE_PATH_."functions.php");
		require_once(_SITE_PATH_."/init.php"); 
		# Get Object Variable
		$object = xfpi_internal_init();
?>