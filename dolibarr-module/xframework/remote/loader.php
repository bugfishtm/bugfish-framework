<?php
	//////////////////////////////////////////////////////////////////////
	// Informations for easy Functions Building
	//////////////////////////////////////////////////////////////////////
	define("_MXINTCLASSX2546754_DB_HOST_", $dolibarr_main_db_host);
	define("_MXINTCLASSX2546754_DB_USER_", $dolibarr_main_db_user);
	define("_MXINTCLASSX2546754_DB_PASS_", $dolibarr_main_db_pass);
	define("_MXINTCLASSX2546754_DB_NAME_", $dolibarr_main_db_name);	
	define("_MXINTCLASSX2546754_DELIMITER_1_", ":mitec-limiter1:");	
	define("_MXINTCLASSX2546754_DELIMITER_2_", ":mitec-limiter2:");			
	
	//////////////////////////////////////////////////////////////////////
	// External Vendors
	//////////////////////////////////////////////////////////////////////
	// Debug Functions
	foreach (glob($dolibarr_main_document_root."/custom/xframework/remote/module/d_*.php") as $filename){ require_once $filename; }
	// Load M Functions
	foreach (glob($dolibarr_main_document_root."/custom/xframework/remote/bugfish-framework/dolibarr/m_*.php") as $filename){ require_once $filename; }	
	// Load X Classes
	foreach (glob($dolibarr_main_document_root."/custom/xframework/remote/bugfish-framework/classes/x_*.php") as $filename){ require_once $filename; }		
	// Load X Functions
	foreach (glob($dolibarr_main_document_root."/custom/xframework/remote/bugfish-framework/functions/x_*.php") as $filename){ require_once $filename; }		

	//////////////////////////////////////////////////////////////////////
	// Simple Functions
	//////////////////////////////////////////////////////////////////////		
	// Create a Quick Mysql Object without Credentials
	function x_c_mysql()  {
		$tmp = new x_class_mysql(_MXINTCLASSX2546754_DB_HOST_, _MXINTCLASSX2546754_DB_USER_, _MXINTCLASSX2546754_DB_PASS_, _MXINTCLASSX2546754_DB_NAME_);
		if(is_object($tmp->mysqlcon)) {$tmp->loggingSetup(true, "llx_xframework_sqlerrors" , true);} return $tmp; }	
	// Create a Quick Mailer Object with Credentials
	function x_c_mail($host, $port, $auth, $user, $pass, $from_name, $from_mail) {	
		$tmp = new x_class_mail($host, $port, $auth, $user, $pass);
		$tmp->initFrom($from_mail, $from_name);
		return $tmp; }	
	// Load the PreDefined Javascript Functions
	function x_l_js() {	foreach (glob($dolibarr_main_document_root."/custom/xframework/remote/bugfish-framework/javascript/xjs_*.php") as $filename){ require_once $filename; } }
?>