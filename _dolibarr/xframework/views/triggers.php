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
	if (!$user->admin AND !$user->rights->xframework->readtriggers) { accessforbidden(); }
	
	// Show the Dolibarr Header
	llxHeader("","Triggers - xFramework");
	
	// Show Button to Clear Table
	m_button_sql($db, "Tabelle Leeren", DOL_URL_ROOT."/custom/xframework/views/triggers.php?mainmenu=tools", "DELETE FROM dolibarr_xframework_triggers", "delop");

	// Prepare and show Complex Table
	$titlelist	=	array("User", "Datum", "Inhalt");
	$alignlist	=	array("left", "center", "left");
	$array = m_db_rows($db, "SELECT username, createdate, triggername FROM dolibarr_xframework_triggers ORDER BY rowid DESC LIMIT 20");
	echo "<h2>Demo of m_table_complex!</h2>";
	if(!empty($array)) {
		for($i = 0; $i < count($array); $i++) {
			foreach($array[$i] as $key => $value) {
				if($key == "username") {$array[$i]["username"] = m_login_name_from_id($db, $array[$i]["username"]);}
				if($key == "triggername") {$array[$i]["triggername"] = htmlspecialchars($array[$i]["triggername"]);}
			}
		}
	} echo "<h2>Demo of m_table_complex!</h2>";
	m_table_complex("Letzte verzeichnete Trigger Aktionen", $array, $titlelist, "table", $alignlist);
	
	// Close the Dolibarr Footer
	llxFooter();
	
	// Close the Database Connection
	$db->close();
?>