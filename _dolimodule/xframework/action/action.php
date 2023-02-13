<?php
	if (!defined('NOCSRFCHECK'))    define('NOCSRFCHECK', 1);
	if (!defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', 1);
	if (!defined('NOREQUIREMENU'))  define('NOREQUIREMENU', 1);
	if (!defined('NOREQUIREHTML'))  define('NOREQUIREHTML', 1);
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
	
	// Log JS Error if one is appearing
	if(@GETPOST("action", "alpha") == "logjserror") {		
		$into_array = array();
		$into_array["userid"] 		= @m_login_id($db);
		$into_array["errormsg"] 	= $db->escape(@GETPOST("errortext", "alpha"));
		$into_array["urlstring"]	= $db->escape(@GETPOST("urlstring", "alpha"));	
		@m_db_row_insert($db, "llx_xframework_jserrors", @$into_array);		
		exit();
	}
?>