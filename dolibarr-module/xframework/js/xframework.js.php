<?php
	if (!defined('NOCSRFCHECK'))    define('NOCSRFCHECK',    1);
	if (!defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', 1);
	if (!defined('NOREQUIREMENU'))  define('NOREQUIREMENU',  1);
	if (!defined('NOREQUIREHTML'))  define('NOREQUIREHTML',  1);
	
	$res=0;
	if (! $res && ! empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) $res=@include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
	$tmp=empty($_SERVER['SCRIPT_FILENAME'])?'':$_SERVER['SCRIPT_FILENAME'];$tmp2=realpath(__FILE__); $i=strlen($tmp)-1; $j=strlen($tmp2)-1;
	while($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i]==$tmp2[$j]) { $i--; $j--; }
	if (! $res && $i > 0 && file_exists(substr($tmp, 0, ($i+1))."/main.inc.php")) $res=@include substr($tmp, 0, ($i+1))."/main.inc.php";
	if (! $res && $i > 0 && file_exists(substr($tmp, 0, ($i+1))."/../main.inc.php")) $res=@include substr($tmp, 0, ($i+1))."/../main.inc.php";
	if (! $res && file_exists("../../main.inc.php")) $res=@include "../../main.inc.php";
	if (! $res && file_exists("../../../main.inc.php")) $res=@include "../../../main.inc.php";
	if (! $res) die("Include of main fails");
	
	require_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';
	
	header('Cache-Control: no-cache');
	header('Content-Type: application/javascript');
	
	if(!dolibarr_get_const($db, "XMOD_XF_JSLOG", 1) OR dolibarr_get_const($db, "XMOD_XF_JSLOG", 1) != "on") { exit(); }
?>

window.onerror = function(error, url, line) {
	$.post("<?php print DOL_URL_ROOT; ?>/custom/xframework/action/action.php", 
	{ action: 'logjserror', urlstring: window.location.href, errortext: 'File: '+url+' Line: '+line+' Error: '+error }, function (data) {});	
}