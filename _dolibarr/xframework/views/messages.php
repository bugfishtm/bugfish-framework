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
	if (!$user->admin AND !$user->rights->xframework->readmsg) { accessforbidden(); }
	
	// Show the Dolibarr Header
	llxHeader("","Message System - xFramework");
	
	// Show buttons to switch areas
	m_button_link("others", DOL_URL_ROOT."/custom/xframework/views/messages.php?mainmenu=tools&ref=others");
	m_button_link("wilms", DOL_URL_ROOT."/custom/xframework/views/messages.php?mainmenu=tools&ref=wilms");
	m_button_link("orderpicking", DOL_URL_ROOT."/custom/xframework/views/messages.php?mainmenu=tools&ref=orderpicking");
	m_button_link("distributionbases", DOL_URL_ROOT."/custom/xframework/views/messages.php?mainmenu=tools&ref=distributionbases");
	m_button_link("commissions", DOL_URL_ROOT."/custom/xframework/views/messages.php?mainmenu=tools&ref=commissions");
	m_button_link("advanceddiscount", DOL_URL_ROOT."/custom/xframework/views/messages.php?mainmenu=tools&ref=advanceddiscount");	
	
	// Check if Location if Valid
	if(@$_GET["ref"] != "others" AND @$_GET["ref"] != "wilms" AND @$_GET["ref"] != "orderpicking" AND @$_GET["ref"] != "distributionbases" AND @$_GET["ref"] != "commissions" AND @$_GET["ref"] != "advanceddiscount") {
		// No Area Selected!
		echo "<h2>Kein Bereich ausgewählt!</h2>!";
	} else {
		// Load Area
		
		/*$table	=	new m_class_mastertable($db, "Test".@htmlspecialchars($_GET["ref"]), "");
		$table->addColumn("module", "Module", "left", 1, true, true);
		$table->addColumn("notification", "Message", "left;word-break:break-all;", 1, true, true);
		$table->addColumn("username", "User", "left", 1, true, true);
		$table->addColumn("createdate", "Date", "left", 1, true, true);
			if(@$_GET["ref"] == "others") { $q = "SELECT module, notification, username, createdate  FROM dolibarr_xframework_messages WHERE module <> 'wilms' AND module <> 'distributionbases' AND module <> 'commissions' AND module <> 'orderpicking' AND module <> 'advanceddiscount'";} 
			else { $q = "SELECT module, notification, username, createdate  FROM dolibarr_xframework_messages WHERE module LIKE '%".htmlspecialchars(@$_GET["ref"])."%' "; }
		$table->init($q, 10, "desc", "createdate");
		$array = $table->prepareArray();
		if(!empty($array)) {
			for($i = 0; $i < count($array); $i++) {
				foreach($array[$i] as $key => $value) {
					if($key == "username") {$array[$i]["username"] = m_login_name_from_id($db, $value);}
					if($key == "notification") {$array[$i]["notification"] = htmlspecialchars_decode($array[$i]["notification"]);}
					if(!is_string($array[$i]["username"])) {$array[$i]["username"] = "Not Found";}
					//if($key == "changesstring") {$array[$i]["changesstring"] = str_replace("&amp;", "&", $value) ;}
				}
			}
		} $table->printTable($array, "generic", $_SERVER["PHP_SELF"]);*/

		// Prepare Complex Table Title
		if(@$_GET["ref"] != "others"){
			$titlelist	=	array("Datum", "Nutzer", "Nachricht");
			$alignlist	=	array("left", "left", "left");
			$query = "SELECT createdate , username, notification FROM dolibarr_xframework_messages ORDER BY createdate DESC LIMIT 100";
		} else {
			$titlelist	=	array("Modul","Datum", "Nutzer", "Nachricht");
			$alignlist	=	array("left", "left", "left", "left");		
			$query = "SELECT module, createdate , username, notification FROM dolibarr_xframework_messages ORDER BY createdate DESC LIMIT 100";
		}
		
		// Prepare Actual Table
		$array = m_db_rows($db, $query);
		if(!empty($array)) {
			for($i = 0; $i < count($array); $i++) {
				foreach($array[$i] as $key => $value) {
					if($key == "username") {$array[$i]["username"] = m_login_name_from_id($db, $value);}
					if($key == "notification") {$array[$i]["notification"] = htmlspecialchars_decode($array[$i]["notification"]);}
					if(!is_string($array[$i]["username"])) {$array[$i]["username"] = "Not Found";}
					//if($key == "changesstring") {$array[$i]["changesstring"] = str_replace("&amp;", "&", $value) ;}
				}
			}
		} echo "<h2>Demo of m_table_complex!</h2>";
		m_table_complex("Modul-Nachrichten", $array, $titlelist, "table", $alignlist);
	}
	
	// Close the Dolibarr Footer
	llxFooter();
	
	// Close the Database Connection
	$db->close();	
?>