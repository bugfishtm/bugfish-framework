<?php
	/*
		__________              _____.__       .__     
		\______   \__ __  _____/ ____\__| _____|  |__  
		 |    |  _/  |  \/ ___\   __\|  |/  ___/  |  \ 
		 |    |   \  |  / /_/  >  |  |  |\___ \|   Y  \
		 |______  /____/\___  /|__|  |__/____  >___|  /
				\/     /_____/               \/     \/  Doliabrr Javascript File Example */
	// Default Top Settings for JS File
	if (!defined('NOCSRFCHECK'))    define('NOCSRFCHECK',    1);
	if (!defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', 1);
	if (!defined('NOREQUIREMENU'))  define('NOREQUIREMENU',  1);
	if (!defined('NOREQUIREHTML'))  define('NOREQUIREHTML',  1);
	
	// Include the Configuration File out of Dolibarrs Folder Structure
	// Maybe check if JS File is not in Default Folder!
	require_once("../../../main.inc.php");
	
	// Include to get Constants (for above dolibarr_get_const() )
	require_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';
	
	// No Caching on this File for faster Changes
	header('Cache-Control: no-cache');
	header('Content-Type: application/javascript');
	
	// Check if errors should be fetched, otherwhise exit
	if(!dolibarr_get_const($db, "XMOD_XF_JSLOG", 1) OR dolibarr_get_const($db, "XMOD_XF_JSLOG", 1) != "on") { exit(); }
?>

	// Fetch Errors and Write to Database, if activated.
	window.onerror = function(error, url, line) {
		$.post("<?php print DOL_URL_ROOT; ?>/custom/xframework/action/action.php", 
		{ action: 'logjserror', urlstring: window.location.href, errortext: 'File: '+url+' Line: '+line+' Error: '+error }, function (data) {});	
	}