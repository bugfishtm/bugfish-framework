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
	
	if (!$user->admin AND !$user->rights->xframework->readmysql) { accessforbidden(); }
	$hookmanager->initHooks(array('debuglist'));
	
	llxHeader("","xMySQL Errors - xFramework");
	
	m_button_sql($db, "Tabelle Leeren", DOL_URL_ROOT."/custom/xframework/views/mysql.php?mainmenu=tools", "DELETE FROM llx_xframework_sqlerrors", "delop");	
	$titlelist	=	array("Datum", "Link", "Fehlercodes");
	$alignlist	=	array("left", "center", "left", "left");
	$array = m_db_rows($db, "SELECT creation, url, errtext FROM llx_xframework_sqlerrors ORDER BY rowid DESC LIMIT 300");
	if(!empty($array)) {
		for($i = 0; $i < count($array); $i++) {
			foreach($array[$i] as $key => $value) {
				if($key == "url") {$array[$i]["url"] = mitec_f($value);}
				if($key == "errtext") {$array[$i]["errtext"] = mitec_f($value);}
			}
		}
	} echo "<h2>Demo of m_table_complex!</h2>";
	m_table_complex("Letzte verzeichnete MySQL Fehler", $array, $titlelist, "table", $alignlist);
	llxFooter();
	$db->close();
?>