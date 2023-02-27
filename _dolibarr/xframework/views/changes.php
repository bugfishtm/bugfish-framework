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
	if (!$user->admin AND !$user->rights->xframework->readchangelogs) { accessforbidden(); }
	
	// Show the Dolibarr Header
	llxHeader("","Changelogs - xFramework");
	
	// Buttons to change Area
	m_button_link("Rechnungen", DOL_URL_ROOT."/custom/xframework/views/changes.php?mainmenu=tools&ref=facture");
	m_button_link("Bank Accounts", DOL_URL_ROOT."/custom/xframework/views/changes.php?mainmenu=tools&ref=bank_account");
	m_button_link("Lieferantenrechnung", DOL_URL_ROOT."/custom/xframework/views/changes.php?mainmenu=tools&ref=facture_fourn");
	m_button_link("Auftrag", DOL_URL_ROOT."/custom/xframework/views/changes.php?mainmenu=tools&ref=commande");
	m_button_link("Angebot", DOL_URL_ROOT."/custom/xframework/views/changes.php?mainmenu=tools&ref=propal");
	m_button_link("Benutzer", DOL_URL_ROOT."/custom/xframework/views/changes.php?mainmenu=tools&ref=user");
	m_button_link("Kommissionierung", DOL_URL_ROOT."/custom/xframework/views/changes.php?mainmenu=tools&ref=orderpicking");
	m_button_link("Lieferscheine", DOL_URL_ROOT."/custom/xframework/views/changes.php?mainmenu=tools&ref=expedition");
	m_button_link("Lieferantenvorschlag", DOL_URL_ROOT."/custom/xframework/views/changes.php?mainmenu=tools&ref=supplier_proposal");
	m_button_link("Lieferantenauftrag", DOL_URL_ROOT."/custom/xframework/views/changes.php?mainmenu=tools&ref=commande_fournisseur");
	m_button_link("Serviceaufträge", DOL_URL_ROOT."/custom/xframework/views/changes.php?mainmenu=tools&ref=fichinter");
	m_button_link("Produkte", DOL_URL_ROOT."/custom/xframework/views/changes.php?mainmenu=tools&ref=product");	
	m_button_link("Societe", DOL_URL_ROOT."/custom/xframework/views/changes.php?mainmenu=tools&ref=societe");	
	
	// Check if Location if Valid
	if(!d_trigger_react(@$_GET["ref"])) {
		echo "<h2>Kein Bereich ausgewählt!</h2>This area is also a demo of the m_mastertable class!";
	} else {	
		// Craete Table Object
		$table	=	new m_class_mastertable($db, "Test".@htmlspecialchars($_GET["ref"]), "");
		
		// Craete Table Column
		$table->addColumn("refid", "Reference", "left", 1, true, true);
		$table->addColumn("createdate", "Date", "left", 1, true, true);
		$table->addColumn("username", "User", "left", 1, true, true);
		$table->addColumn("changesstring", "Changes", "left", 1, true, true);
		
		// Init the Table
		$table->init("SELECT ref, refid, createdate, username, changesstring FROM dolibarr_xframework_logging WHERE ref LIKE '%".htmlspecialchars(@$_GET["ref"])."%' ", 10, "desc", "createdate");
		
		// Get needed Array
		$array = $table->prepareArray();
		
		// Prepare Values
		if(!empty($array)) {
			for($i = 0; $i < count($array); $i++) {
				foreach($array[$i] as $key => $value) {
					if($key == "username") {$array[$i]["username"] = m_login_name_from_id($db, $value);}
					if($key == "changesstring") {$array[$i]["changesstring"] = str_replace("&amp;", "&", $value) ;}
					if($key == "changesstring") {$array[$i]["changesstring"] = str_replace("&amp;", "&", $array[$i]["changesstring"]) ;}
					if($key == "changesstring") {$array[$i]["changesstring"] = str_replace("&amp;", "&", $array[$i]["changesstring"]) ;}
					if($key == "changesstring") {$array[$i]["changesstring"] =  str_replace("&lt;br /&gt;", "<br />", $array[$i]["changesstring"]);}
					if($key == "changesstring") {$array[$i]["changesstring"] =  str_replace("&lt;b&gt;", "<b>", $array[$i]["changesstring"]);}
					if($key == "changesstring") {$array[$i]["changesstring"] =  str_replace("&lt;/b&gt;", "</b>", $array[$i]["changesstring"]);}
					if($key == "changesstring") {$array[$i]["changesstring"] =  str_replace("&lt;", "<", $array[$i]["changesstring"]);}
					if($key == "changesstring") {$array[$i]["changesstring"] =  str_replace("&gt;", ">", $array[$i]["changesstring"]);}
				}
			}
		}	
			
		// Print the Master Table
		$table->printTable($array, "generic", $_SERVER["PHP_SELF"]);
	}
	
	// Close the Dolibarr Footer
	llxFooter();
	
	// Close the Database Connection
	$db->close();	
?>