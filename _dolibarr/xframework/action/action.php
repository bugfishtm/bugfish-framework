<?php
	/*
		__________              _____.__       .__     
		\______   \__ __  _____/ ____\__| _____|  |__  
		 |    |  _/  |  \/ ___\   __\|  |/  ___/  |  \ 
		 |    |   \  |  / /_/  >  |  |  |\___ \|   Y  \
		 |______  /____/\___  /|__|  |__/____  >___|  /
				\/     /_____/               \/     \/  Doliabrr Action File Example */
	// Default Presettings
	if (!defined('NOCSRFCHECK'))    define('NOCSRFCHECK', 1);
	if (!defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', 1);
	if (!defined('NOREQUIREMENU'))  define('NOREQUIREMENU', 1);
	if (!defined('NOREQUIREHTML'))  define('NOREQUIREHTML', 1);
	
	// Include the Configuration File out of Dolibarrs Folder Structure
	// Maybe check if Trigger File is not in Default Folder!
	require_once("../../../main.inc.php");
	
	// Log JS Error if one is appearing
	if(@GETPOST("action", "alpha") == "logjserror") {		
		$into_array = array();
		$into_array["userid"] 		= @m_login_id($db);
		$into_array["errormsg"] 	= $db->escape(@GETPOST("errortext", "alpha"));
		$into_array["urlstring"]	= $db->escape(@GETPOST("urlstring", "alpha"));	
		@m_db_row_insert($db, "dolibarr_xframework_jserrors", @$into_array);		
		exit();
	}
?>