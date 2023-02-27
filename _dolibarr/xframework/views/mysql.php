<?php
	/*
		__________              _____.__       .__     
		\______   \__ __  _____/ ____\__| _____|  |__  
		 |    |  _/  |  \/ ___\   __\|  |/  ___/  |  \ 
		 |    |   \  |  / /_/  >  |  |  |\___ \|   Y  \
		 |______  /____/\___  /|__|  |__/____  >___|  /
				\/     /_____/               \/     \/  Doliabrr View File Example */
	// Include the Configuration File out of Dolibarrs Folder Structure
	// Maybe check if JS File is not in Default Folder!
	require_once("../../../main.inc.php");				
	
	// Include to get Constants (for above dolibarr_get_const() )
	require_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';	
	
	// Check for Permissions
	if (!$user->admin AND !$user->rights->xframework->readmysql) { accessforbidden(); }
	
	// Show the Dolibarr Header
	llxHeader("","xMySQL Errors - xFramework");
	
	// Show Button to Clear Table
	m_button_sql($db, "Tabelle Leeren", DOL_URL_ROOT."/custom/xframework/views/mysql.php?mainmenu=tools", "DELETE FROM dolibarr_xframework_sqlerrors", "delop");	
	
	// Prepare and show Complex Table
	$titlelist	=	array("Datum", "Link", "Fehlercodes");
	$alignlist	=	array("left", "center", "left", "left");
	$array = m_db_rows($db, "SELECT creation, url, errtext FROM dolibarr_xframework_sqlerrors ORDER BY rowid DESC LIMIT 300");
	if(!empty($array)) {
		for($i = 0; $i < count($array); $i++) {
			foreach($array[$i] as $key => $value) {
				if($key == "url") {$array[$i]["url"] = mitec_f($value);}
				if($key == "errtext") {$array[$i]["errtext"] = mitec_f($value);}
			}
		}
	} echo "<h2>Demo of m_table_complex!</h2>";
	m_table_complex("Letzte verzeichnete MySQL Fehler", $array, $titlelist, "table", $alignlist);
	
	// Close the Dolibarr Footer
	llxFooter();
	
	// Close the Database Connection
	$db->close();
?>