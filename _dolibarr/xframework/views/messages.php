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

	
	if (!$user->admin AND !$user->rights->xframework->readmsg) { accessforbidden(); }
	$hookmanager->initHooks(array('debuglist'));
	llxHeader("","Message System - xFramework");
	
	m_button_link("Others", DOL_URL_ROOT."/custom/xframework/views/messages.php?mainmenu=tools&ref=others");
	m_button_link("Wilms", DOL_URL_ROOT."/custom/xframework/views/messages.php?mainmenu=tools&ref=wilms");
	m_button_link("Orderpicking", DOL_URL_ROOT."/custom/xframework/views/messages.php?mainmenu=tools&ref=orderpicking");
	m_button_link("Distributionbases", DOL_URL_ROOT."/custom/xframework/views/messages.php?mainmenu=tools&ref=distributionbases");
	m_button_link("Commissions", DOL_URL_ROOT."/custom/xframework/views/messages.php?mainmenu=tools&ref=commissions");
	m_button_link("Advanceddiscount", DOL_URL_ROOT."/custom/xframework/views/messages.php?mainmenu=tools&ref=advanceddiscount");
	
	// Check if Location if Valid
	if(@$_GET["ref"] != "others" AND @$_GET["ref"] != "wilms" AND @$_GET["ref"] != "orderpicking" AND @$_GET["ref"] != "distributionbases" AND @$_GET["ref"] != "commissions" AND @$_GET["ref"] != "advanceddiscount") {
		echo "<h2>Kein Bereich ausgewählt!</h2>This area is also a demo of the m_mastertable class!";
	} else {
		
	$table	=	new m_class_mastertable($db, "Test".@htmlspecialchars($_GET["ref"]), "");
	
	$table->addColumn("module", "Module", "left", 1, true, true);
	$table->addColumn("notification", "Message", "left;word-break:break-all;", 1, true, true);
	$table->addColumn("username", "User", "left", 1, true, true);
	$table->addColumn("createdate", "Date", "left", 1, true, true);
	
		if(@$_GET["ref"] == "others") { $q = "SELECT module, notification, username, createdate  FROM llx_xframework_messages WHERE module <> 'wilms' AND module <> 'distributionbases' AND module <> 'commissions' AND module <> 'orderpicking' AND module <> 'advanceddiscount'";} 
		else { $q = "SELECT module, notification, username, createdate  FROM llx_xframework_messages WHERE module LIKE '%".htmlspecialchars(@$_GET["ref"])."%' "; }
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
	}	
		

	$table->printTable($array, "generic", $_SERVER["PHP_SELF"]);

	}
	llxFooter();
	$db->close();	
?>