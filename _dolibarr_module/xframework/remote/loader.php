<?php
	//////////////////////////////////////////////////////////////////////
	// Informations for easy Functions Building
	//////////////////////////////////////////////////////////////////////
	define("_MXINTCLASSX2546754_RANDRAND_",  mt_rand(1000,9999));
	define("_MXINTCLASSX2546754_DB_HOST_"._MXINTCLASSX2546754_RANDRAND_, $dolibarr_main_db_host);
	define("_MXINTCLASSX2546754_DB_USER_"._MXINTCLASSX2546754_RANDRAND_, $dolibarr_main_db_user);
	define("_MXINTCLASSX2546754_DB_PASS_"._MXINTCLASSX2546754_RANDRAND_, $dolibarr_main_db_pass);
	define("_MXINTCLASSX2546754_DB_NAME_"._MXINTCLASSX2546754_RANDRAND_, $dolibarr_main_db_name);	
	define("_MXINTCLASSX2546754_ROOT_"._MXINTCLASSX2546754_RANDRAND_, $dolibarr_main_document_root);	
	define("_MXINTCLASSX2546754_DELIMITER_1_", ":mitec-limiter1:");	
	define("_MXINTCLASSX2546754_DELIMITER_2_", ":mitec-limiter2:");			
	
	//////////////////////////////////////////////////////////////////////
	// External Vendors
	//////////////////////////////////////////////////////////////////////
	foreach (glob($dolibarr_main_document_root."/custom/xframework/remote/module/d_*.php") as $filename){ require_once $filename; }
	foreach (glob($dolibarr_main_document_root."/custom/xframework/remote/framework/dolibarr/m_*.php") as $filename){ require_once $filename; }	
	foreach (glob($dolibarr_main_document_root."/custom/xframework/remote/framework/classes/x_*.php") as $filename){ require_once $filename; }		
	foreach (glob($dolibarr_main_document_root."/custom/xframework/remote/framework/functions/x_*.php") as $filename){ require_once $filename; }		

	//////////////////////////////////////////////////////////////////////
	// Error Reporting
	//////////////////////////////////////////////////////////////////////
	if(@$xframework["no_handler"] != true OR !isset($xframework["no_handler"])) {
		function xframework_error_handler($errno, $errstr, $errfile, $errline) {
			error_log("File: "$errfile." | Num: ".$errno." | Line: ".$errline." | Error: ".$errstr, 3, constant("_MXINTCLASSX2546754_ROOT_"._MXINTCLASSX2546754_RANDRAND_)."/custom/xframework/log/php.log");
			return;
		}		
		if(!isset($xframework["set_handler"])) { ini_set('error_reporting', E_ALL); } else { ini_set('error_reporting', $xframework["set_handler"]); }
		$old_error_handler = set_error_handler("xframework_error_handler");		
	}
	
	//////////////////////////////////////////////////////////////////////
	// Simple Functions
	//////////////////////////////////////////////////////////////////////		
	// Create a Quick Mysql Object without Credentials
	function x_c_mysql()  {
		$tmp = new x_class_mysql(constant("_MXINTCLASSX2546754_DB_HOST_"._MXINTCLASSX2546754_RANDRAND_), constant("_MXINTCLASSX2546754_DB_USER_"._MXINTCLASSX2546754_RANDRAND_), constant("_MXINTCLASSX2546754_DB_PASS_"._MXINTCLASSX2546754_RANDRAND_), constant("_MXINTCLASSX2546754_DB_NAME_"._MXINTCLASSX2546754_RANDRAND_));
		if(is_object($tmp->mysqlcon)) { $tmp->loggingSetup(true, "llx_xframework_sqlerrors" , true); return $tmp; } return false;  }	
	// Create a Quick Mailer Object with Credentials
	function x_c_mail($host, $port, $auth, $user, $pass, $from_name, $from_mail) {	
		$tmp = new x_class_mail($host, $port, $auth, $user, $pass);
		$tmp->initFrom($from_mail, $from_name);
		$tmp->initReplyTo($from_mail, $from_name);
		$tmp->allow_insecure_ssl_connections(true);
		return $tmp; }	
	// Load the PreDefined Javascript Functions
	function x_l_js() {	foreach (glob($dolibarr_main_document_root."/custom/xframework/remote/framework/javascript/xjs_*.php") as $filename){ require_once $filename; } }
?>