<?php
	/*
		__________              _____.__       .__     
		\______   \__ __  _____/ ____\__| _____|  |__  
		 |    |  _/  |  \/ ___\   __\|  |/  ___/  |  \ 
		 |    |   \  |  / /_/  >  |  |  |\___ \|   Y  \
		 |______  /____/\___  /|__|  |__/____  >___|  /
				\/     /_____/               \/     \/  Doliabrr Admin File Example */
	// Include the Configuration File out of Dolibarrs Folder Structure
	// Maybe check if Admin File is not in Default Folder!
	require_once("../../../main.inc.php");
	
	// Include to get Constants (for above dolibarr_get_const() )
	require_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';
	
	// If user not Admin show Forbidden Page!
	if ( !$user->admin ) { accessforbidden(); }

	// Change a Dolibarr-Const on Requested
	if($_POST["XMOD_XF_JSLOG_OFF"]) {dolibarr_set_const($db, "XMOD_XF_JSLOG", "off", 'chaine', 0, '', 1); Header("Location: ".DOL_URL_ROOT."/custom/xframework/admin/admin.php"); setEventMessage ("Änderung erfolgreich!", 'mesgs');exit();}
	if($_POST["XMOD_XF_JSLOG_ON"])  {dolibarr_set_const($db, "XMOD_XF_JSLOG", "on", 'chaine', 0, '', 1); Header("Location: ".DOL_URL_ROOT."/custom/xframework/admin/admin.php"); setEventMessage ("Änderung erfolgreich!", 'mesgs');exit();}		
	// Change a Dolibarr-Const on Requested
	if($_POST["XMOD_XF_TRGLOG_OFF"]) {dolibarr_set_const($db, "XMOD_XF_TRGLOG", "off", 'chaine', 0, '', 1); Header("Location: ".DOL_URL_ROOT."/custom/xframework/admin/admin.php"); setEventMessage ("Änderung erfolgreich!", 'mesgs');exit();}
	if($_POST["XMOD_XF_TRGLOG_ON"])  {dolibarr_set_const($db, "XMOD_XF_TRGLOG", "on", 'chaine', 0, '', 1); Header("Location: ".DOL_URL_ROOT."/custom/xframework/admin/admin.php"); setEventMessage ("Änderung erfolgreich!", 'mesgs');exit();}		
	// Change a Dolibarr-Const on Requested
	if($_POST["XMOD_XF_CNGLOG_OFF"]) {dolibarr_set_const($db, "XMOD_XF_CNGLOG", "off", 'chaine', 0, '', 1); Header("Location: ".DOL_URL_ROOT."/custom/xframework/admin/admin.php"); setEventMessage ("Änderung erfolgreich!", 'mesgs');exit();}
	if($_POST["XMOD_XF_CNGLOG_ON"])  {dolibarr_set_const($db, "XMOD_XF_CNGLOG", "on", 'chaine', 0, '', 1); Header("Location: ".DOL_URL_ROOT."/custom/xframework/admin/admin.php"); setEventMessage ("Änderung erfolgreich!", 'mesgs');exit();}		

	// Display Dolibarr Header
	llxHeader("", "Admin - xFramework");

	// Form Elements to Change a Dolibarr Constant for this Module!
	echo "<div style='padding: 10px;'><form method='post'>";	
		if(!dolibarr_get_const($db, "XMOD_XF_JSLOG", 1)) { dolibarr_set_const($db, "XMOD_XF_JSLOG", "off", 'chaine', 0, '', 1); }
		$currentfactures	=	dolibarr_get_const($db, "XMOD_XF_JSLOG", 1);
		if($currentfactures == "on") {
			echo "Javascript-Fehler-Logging<font color='green'><b>aktiviert</b></font>!";
			echo '<input type="submit" name="XMOD_XF_JSLOG_OFF" value="Ändern">';
		} else {
			echo "Javascript-Fehler-Logging<font color='red'><b>deaktiviert</b></font>!";
			echo '<input type="submit" name="XMOD_XF_JSLOG_ON" value="Ändern">';
		} echo "<br /><br />";
		
		if(!dolibarr_get_const($db, "XMOD_XF_TRGLOG", 1)) { dolibarr_set_const($db, "XMOD_XF_TRGLOG", "off", 'chaine', 0, '', 1); }
		$currentfactures	=	dolibarr_get_const($db, "XMOD_XF_TRGLOG", 1);
		if($currentfactures == "on") {
			echo "Trigger-Logging<font color='green'><b>aktiviert</b></font>!";
			echo '<input type="submit" name="XMOD_XF_TRGLOG_OFF" value="Ändern">';
		} else {
			echo "Trigger-Logging<font color='red'><b>deaktiviert</b></font>!";
			echo '<input type="submit" name="XMOD_XF_TRGLOG_ON" value="Ändern">';
		} echo "<br /><br />";
		
		if(!dolibarr_get_const($db, "XMOD_XF_CNGLOG", 1)) { dolibarr_set_const($db, "XMOD_XF_CNGLOG", "off", 'chaine', 0, '', 1); }
		$currentfactures	=	dolibarr_get_const($db, "XMOD_XF_CNGLOG", 1);
		if($currentfactures == "on") {
			echo "Changeslog-Logging<font color='green'><b>aktiviert</b></font>!";
			echo '<input type="submit" name="XMOD_XF_CNGLOG_OFF" value="Ändern">';
		} else {
			echo "Changeslog-Logging<font color='red'><b>deaktiviert</b></font>!";
			echo '<input type="submit" name="XMOD_XF_CNGLOG_ON" value="Ändern">';
		}
	echo "</form></div>";
		
	// Vertical Line
	echo "<hr>";

	// If Init has been Executed, then Do...
	if(@$_GET["op"] != NULL AND @trim($_GET["op"]) != "") {d_c_addInitNow($db, @$_GET["op"]);}
	
	// Show Buttons with Function to Initialize Areas for Changelog
	m_button_link("Neu einlesen: Rechnung[facture]", DOL_URL_ROOT."/custom/xframework/admin/admin.php?op=facture"); echo "<br /><br />";
	m_button_link("Neu einlesen: Bank-Konten[bank_account]", DOL_URL_ROOT."/custom/xframework/admin/admin.php?op=bank_account"); echo "<br /><br />";
	m_button_link("Neu einlesen: Lieferantenrechnung[facture_fourn]", DOL_URL_ROOT."/custom/xframework/admin/admin.php?op=facture_fourn"); echo "<br /><br />";
	m_button_link("Neu einlesen: Auftrag[commande]", DOL_URL_ROOT."/custom/xframework/admin/admin.php?op=commande"); echo "<br /><br />";
	m_button_link("Neu einlesen: Angebot[propal]", DOL_URL_ROOT."/custom/xframework/admin/admin.php?op=propal"); echo "<br /><br />";
	m_button_link("Neu einlesen: Benutzer[user]", DOL_URL_ROOT."/custom/xframework/admin/admin.php?op=user"); echo "<br /><br />";
	m_button_link("Neu einlesen: Kommissionierung[orderpicking]", DOL_URL_ROOT."/custom/xframework/admin/admin.php?op=orderpicking"); echo "<br /><br />";
	m_button_link("Neu einlesen: Lieferschein[expedition]", DOL_URL_ROOT."/custom/xframework/admin/admin.php?op=expedition"); echo "<br /><br />";
	m_button_link("Neu einlesen: Lieferantenvorschläge[supplier_proposal]", DOL_URL_ROOT."/custom/xframework/admin/admin.php?op=supplier_proposal"); echo "<br /><br />";
	m_button_link("Neu einlesen: Lieferantenaufträge[commande_fournisseur]", DOL_URL_ROOT."/custom/xframework/admin/admin.php?op=commande_fournisseur"); echo "<br /><br />";
	m_button_link("Neu einlesen: Serviceaufträge[fichinter]", DOL_URL_ROOT."/custom/xframework/admin/admin.php?op=fichinter"); echo "<br /><br />";
	m_button_link("Neu einlesen: Produkte[product]", DOL_URL_ROOT."/custom/xframework/admin/admin.php?op=product"); echo "<br /><br />";
	m_button_link("Neu einlesen: Societe", DOL_URL_ROOT."/custom/xframework/admin/admin.php?op=societe"); echo "<br /><br />";

	// Dolibarr Footer
	llxFooter();
	
	// Close DB Object
	$db->close();
?>