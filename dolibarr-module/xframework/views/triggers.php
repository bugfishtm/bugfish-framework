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
	if (!$user->admin AND !$user->rights->xframework->readtriggers) { accessforbidden(); }
	
	$hookmanager->initHooks(array('debuglist'));
	llxHeader("","Triggers - Debug - Mitec");

	m_button_sql($db, "Tabelle Leeren", DOL_URL_ROOT."/custom/xframework/views/triggers.php?mainmenu=tools", "DELETE FROM llx_xframework_triggers", "delop");	
	$titlelist	=	array("User", "Datum", "Inhalt");
	$alignlist	=	array("left", "center", "left");
	$array = m_db_rows($db, "SELECT username, createdate, triggername FROM " . MAIN_DB_PREFIX . "xframework_triggers ORDER BY rowid DESC LIMIT 20");
	
	if(!empty($array)) {
		for($i = 0; $i < count($array); $i++) {
			foreach($array[$i] as $key => $value) {
				if($key == "username") {$array[$i]["username"] = m_login_name_from_id($db, $array[$i]["username"]);}
				if($key == "triggername") {$array[$i]["triggername"] = htmlspecialchars($array[$i]["triggername"]);}
			}
		}
	}	
	
	m_table_complex("Letzte verzeichnete Trigger Aktionen", $array, $titlelist, "table", $alignlist);
	llxFooter();
	$db->close();
?>