<?php
	$res=0;
	if (! $res && ! empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) $res=@include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
	$tmp=empty($_SERVER['SCRIPT_FILENAME'])?'':$_SERVER['SCRIPT_FILENAME'];$tmp2=realpath(__FILE__); $i=strlen($tmp)-1; $j=strlen($tmp2)-1;
	while($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i]==$tmp2[$j]) { $i--; $j--; }
	if (! $res && $i > 0 && file_exists(substr($tmp, 0, ($i+1))."/main.inc.php")) $res=@include substr($tmp, 0, ($i+1))."/main.inc.php";
	if (! $res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i+1)))."/main.inc.php")) $res=@include dirname(substr($tmp, 0, ($i+1)))."/main.inc.php";
	if (! $res && file_exists("../main.inc.php")) $res=@include "../main.inc.php";
	if (! $res && file_exists("../../main.inc.php")) $res=@include "../../main.inc.php";
	if (! $res && file_exists("../../../main.inc.php")) $res=@include "../../../main.inc.php";
	if (! $res) die("Include of main fails");

	require_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';
	if ( $user->admin ) {} else { accessforbidden(); }


		if($_POST["XMOD_XF_JSLOG_OFF"]) {dolibarr_set_const($db, "XMOD_XF_JSLOG", "off", 'chaine', 0, '', 1); Header("Location: ".DOL_URL_ROOT."/custom/xframework/admin/admin.php"); setEventMessage ("Änderung erfolgreich!", 'mesgs');exit();}
		if($_POST["XMOD_XF_JSLOG_ON"])  {dolibarr_set_const($db, "XMOD_XF_JSLOG", "on", 'chaine', 0, '', 1); Header("Location: ".DOL_URL_ROOT."/custom/xframework/admin/admin.php"); setEventMessage ("Änderung erfolgreich!", 'mesgs');exit();}		
		
		if($_POST["XMOD_XF_TRGLOG_OFF"]) {dolibarr_set_const($db, "XMOD_XF_TRGLOG", "off", 'chaine', 0, '', 1); Header("Location: ".DOL_URL_ROOT."/custom/xframework/admin/admin.php"); setEventMessage ("Änderung erfolgreich!", 'mesgs');exit();}
		if($_POST["XMOD_XF_TRGLOG_ON"])  {dolibarr_set_const($db, "XMOD_XF_TRGLOG", "on", 'chaine', 0, '', 1); Header("Location: ".DOL_URL_ROOT."/custom/xframework/admin/admin.php"); setEventMessage ("Änderung erfolgreich!", 'mesgs');exit();}		

		if($_POST["XMOD_XF_CNGLOG_OFF"]) {dolibarr_set_const($db, "XMOD_XF_CNGLOG", "off", 'chaine', 0, '', 1); Header("Location: ".DOL_URL_ROOT."/custom/xframework/admin/admin.php"); setEventMessage ("Änderung erfolgreich!", 'mesgs');exit();}
		if($_POST["XMOD_XF_CNGLOG_ON"])  {dolibarr_set_const($db, "XMOD_XF_CNGLOG", "on", 'chaine', 0, '', 1); Header("Location: ".DOL_URL_ROOT."/custom/xframework/admin/admin.php"); setEventMessage ("Änderung erfolgreich!", 'mesgs');exit();}		

	llxHeader("", "Admin - xFramework");

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

echo "<hr>";

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
	if(@$_GET["op"] != NULL AND @trim($_GET["op"]) != "") {d_c_addInitNow($db, @$_GET["op"]);}
	llxFooter();
	$db->close();
?>