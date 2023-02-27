<?php
	/*
		__________              _____.__       .__     
		\______   \__ __  _____/ ____\__| _____|  |__  
		 |    |  _/  |  \/ ___\   __\|  |/  ___/  |  \ 
		 |    |   \  |  / /_/  >  |  |  |\___ \|   Y  \
		 |______  /____/\___  /|__|  |__/____  >___|  /
				\/     /_____/               \/     \/  xFramework Loader File to be included in settings.php! */
	/*******************************/
	/* Set Informations to Const   */
	/*******************************/
	define("_MXINTCLASSX2546754_RANDRAND_",  mt_rand(1000,9999));
	define("_MXINTCLASSX2546754_DB_HOST_"._MXINTCLASSX2546754_RANDRAND_, $dolibarr_main_db_host);
	define("_MXINTCLASSX2546754_DB_USER_"._MXINTCLASSX2546754_RANDRAND_, $dolibarr_main_db_user);
	define("_MXINTCLASSX2546754_DB_PASS_"._MXINTCLASSX2546754_RANDRAND_, $dolibarr_main_db_pass);
	define("_MXINTCLASSX2546754_DB_NAME_"._MXINTCLASSX2546754_RANDRAND_, $dolibarr_main_db_name);	
	define("_MXINTCLASSX2546754_ROOT_"._MXINTCLASSX2546754_RANDRAND_, $dolibarr_main_document_root);	
	define("_MXINTCLASSX2546754_DELIMITER_1_", ":mitec-limiter1:");	
	define("_MXINTCLASSX2546754_DELIMITER_2_", ":mitec-limiter2:");			
	
	/*******************************/
	/* Include Files 			   */
	/*******************************/
	foreach (glob($dolibarr_main_document_root."/custom/xframework/remote/dolibarr/m_*.php") as $filename){ require_once $filename; }	
	foreach (glob($dolibarr_main_document_root."/custom/xframework/remote/classes/x_*.php") as $filename){ require_once $filename; }		
	foreach (glob($dolibarr_main_document_root."/custom/xframework/remote/functions/x_*.php") as $filename){ require_once $filename; }		
	
	/*******************************/
	/* Quick MySQL Object		   */
	/*******************************/	
	function x_c_mysql()  {
		$tmp = new x_class_mysql(constant("_MXINTCLASSX2546754_DB_HOST_"._MXINTCLASSX2546754_RANDRAND_), constant("_MXINTCLASSX2546754_DB_USER_"._MXINTCLASSX2546754_RANDRAND_), constant("_MXINTCLASSX2546754_DB_PASS_"._MXINTCLASSX2546754_RANDRAND_), constant("_MXINTCLASSX2546754_DB_NAME_"._MXINTCLASSX2546754_RANDRAND_));
		if(is_object($tmp->mysqlcon)) { $tmp->loggingSetup(true, "dolibarr_xframework_sqlerrors" , true); return $tmp; } return false;  }	
	
	/*******************************/
	/* Quick Mail Object		   */
	/*******************************/	
	function x_c_mail($host, $port, $auth, $user, $pass, $from_name, $from_mail) {	
		$tmp = new x_class_mail($host, $port, $auth, $user, $pass);
		$tmp->initFrom($from_mail, $from_name);
		$tmp->initReplyTo($from_mail, $from_name);
		$tmp->allow_insecure_ssl_connections(true);
		return $tmp; }	
		
	/*******************************/
	/* Include JS Files 		   */
	/*******************************/	
	function x_l_js() {	foreach (glob($dolibarr_main_document_root."/custom/xframework/remote/javascript/xjs_*.php") as $filename){ require_once $filename; } }
	
	/****************************************************************************************************************/
	/* Default Internal Functions  */
	/****************************************************************************************************************/
	/* Filter from Doli Strings */
	function d_array_filter($arr, $tableelement = false, $inextrafields = false) { $arr["tms"] = "xxx"; if($inextrafields) { $arr["rowid"] = "xxx"; } return $arr;}
	function d_logstring_prepare($string) { $string = preg_replace('/\s+/', ' ', $string);$string = str_replace(array("\r", "\n"), '', $string); return $string;}
	/* Get same String from Object with Table */
	function  d_c_getStringFromDolibarr($db, $tableelement, $id) {
		$outputstring	=	"";
		$tmpar	=	m_db_row($db, "SELECT * FROM " . MAIN_DB_PREFIX . $tableelement." WHERE rowid = " . $id);
		if ($tmpar) {
			$tmpar = d_array_filter($tmpar, $tableelement, false);
			foreach( $tmpar as $key => $value ){
				$newval	=	str_replace(_MXINTCLASSX2546754_DELIMITER_1_, "X", htmlspecialchars($value));
				$newval	=	str_replace(_MXINTCLASSX2546754_DELIMITER_2_, "X", $newval);
				$newval	=	str_replace("\\", "\\\\", $newval);
				$newval	=	str_replace("'", "\\'", $newval);	
				$outputstring .= "mn_".$key._MXINTCLASSX2546754_DELIMITER_2_.$newval._MXINTCLASSX2546754_DELIMITER_1_;}
		} else { return false; }
		$tmpar = m_db_row($db, "SELECT * FROM " . MAIN_DB_PREFIX . $tableelement."_extrafields WHERE fk_object = " . $id);
		if ($tmpar) {
			$tmpar = d_array_filter($tmpar, $tableelement, true);
			foreach( $tmpar as $key => $value ){
				$newval	=	str_replace(_MXINTCLASSX2546754_DELIMITER_1_, "X", htmlspecialchars($value));
				$newval	=	str_replace(_MXINTCLASSX2546754_DELIMITER_2_, "X", $newval);
				$newval	=	str_replace("\\", "\\\\", $newval);
				$newval	=	str_replace("'", "\\'", $newval);
				$outputstring .= "xt_".$key._MXINTCLASSX2546754_DELIMITER_2_.$newval._MXINTCLASSX2546754_DELIMITER_1_;}
			return trim($outputstring);} else { return trim($outputstring); }}	
	/* Simple Get Diff Value From String Array */
	function d_getStringDiffString($objectstring, $tablestring) {
		$stringdiff  = false;
		$first  = explode(_MXINTCLASSX2546754_DELIMITER_1_, $objectstring);
		$second = explode(_MXINTCLASSX2546754_DELIMITER_1_, $tablestring);
		if(count($first) != count($second)) {$stringdiff = "It seems that".sizeof($first)." / ".sizeof($second)." Extrafields have been added since last initializing of module! ";}
		foreach( $first as $key => $value ){
			$firstx  = explode(_MXINTCLASSX2546754_DELIMITER_2_, $value);
			foreach( $second as $key1 => $value1 ){
				$secondx = explode(_MXINTCLASSX2546754_DELIMITER_2_, $value1);
				if($firstx[0] == $secondx[0]) {
					if($firstx[1] != $secondx[1]) {	if(!$stringdiff) {$stringdiff = "";} $stringdiff .= "<b>".$firstx[0]." (old): [</b>".$secondx[1]."<b>]</b> <br /> <b>".$firstx[0]." (new): [</b>".$firstx[1]."<b>]</b><br />"; }
				}}}return $stringdiff;}
	/* Check if Element is Catchable */
	function d_trigger_react($val) { if(@$val != "facture" AND @$val != "bank_account" AND  @$val != "facture_fourn" AND @$val != "commande" AND  @$val != "propal" AND  @$val != "user" AND  @$val != "product" AND  @$val != "orderpicking" AND  @$val != "expedition" AND  @$val != "societe" AND @$val != "supplier_proposal" AND  @$val != "commande_fournisseur" AND  @$val != "fichinter") { return false;} return true;}
	/* Insert Something to the logging Table */
	function d_insertToLogTable($db, $string, $ref, $refid) { $array = array(); $array["ref"] = $db->escape($ref); $array["refid"] = $db->escape($refid); $array["changesstring"] = $db->escape(d_logstring_prepare($string)); $array["username"] = m_login_id($db); return m_db_row_insert($db, "dolibarr_xframework_logging", $array, false);}
	/* Insert Something to the logging Table */
	function d_c_addItem($db, $string, $ref, $refid) { $array = array(); $array["ref"]	= $db->escape($ref); $array["refid"] = $db->escape($refid); $array["string"] = $string; return m_db_row_insert($db, "dolibarr_xframework_bigdata", $array, false); }	
	/* Get the Checkstring from Bigdata Table */
	function d_c_getStringFromDebug($db, $tableelement, $id) { $tmpar =	m_db_row($db, "SELECT * FROM dolibarr_xframework_bigdata WHERE refid = '" . $id . "' AND ref = '".$tableelement."'"); if ($tmpar) {return trim($tmpar["string"]);} else { return false; }}
	/* Catch Triggers if Activated */
	function d_trigger_triggers($db, $triggername, $object){
		$secstring	=	""; $secarray =	@get_object_vars($object); $array = array();
		foreach( @$secarray as $key => $value ){ if(!is_object($value)) {$secstring .= "".$key.":".$value."; ";} }		
		$array["triggername"]		=	"Trigger-Name\r\n ".@$db->escape($triggername)." ;\r\n Objekt-Daten: ".@$db->escape($secstring);
		$array["username"]			=	m_login_id($db);
		m_db_row_insert($db, "dolibarr_xframework_triggers", $array);}
	/* Catch A Change if Constant is Activated */
	function d_trigger_changelog($db, $triggername, $object){
		if(!d_trigger_react($object->table_element)) {return false;} 	
		if($object->id <= 0) {} else { $id = $object->id;} 
		if(!is_numeric($id)) { $id = $object->rowid;}
		if(!is_numeric($id)) {return false;}
		
		$dolistring		=  d_c_getStringFromDolibarr($db, $object->table_element, $id);
		$savestring     =  d_c_getStringFromDebug($db, $object->table_element, $id);
		if(!$dolistring) { return false; }
		if(!$savestring) { d_c_addItem($db, $dolistring, $object->table_element, $id);
		d_insertToLogTable($db, "New Item Added has been added!", $object->table_element, $id);
		} else { $stringdiff = d_getStringDiffString($dolistring, $savestring);
		if(is_string($stringdiff)) { d_insertToLogTable($db, $stringdiff, $object->table_element, $id); 
		$db->query("DELETE FROM dolibarr_xframework_bigdata WHERE ref = '" . $object->table_element ."' AND refid = " . $id);
		d_c_addItem($db, $dolistring, $object->table_element, $id);
		}}}	
	/**INSTALLATION***********/
	function d_c_addInitNow($db, $type) {
		if(!d_trigger_react($type)) {echo "<font color='red'>ERROR ON TYPE!</font>"; return false;}
		$sql_res = $db->query("SELECT * FROM ".MAIN_DB_PREFIX.$type);
		if ($sql_res) { if ($db->num_rows($sql_res) > 0) {
			$count = $db->num_rows($sql_res);
				$db->query("DELETE FROM dolibarr_xframework_bigdata WHERE ref = '".$type."'");
				for ($i=0; $i<$count; $i++) { 
					$tmpnow = $db->fetch_object($sql_res);
					$dolistring		=  d_c_getStringFromDolibarr($db, $type, $tmpnow->rowid);
					d_c_addItem($db, $dolistring, $type, $tmpnow->rowid);} 		
			print "<font color='green'>ALL OK ON FETCHING ".$type."!</font>"; return true;
		} else { print "<font color='red'>ERROR ON FETCHING ".$type."!</font>"; return false; }
		} else { print "<font color='red'>ERROR ON FETCHING ".$type."!</font>"; return false; }}
	/*******************************/
	/* Send Module Message		   */
	/*******************************/
		function d_message($db, $modulename, $message){
			$array = array(); $array["module"] = $db->escape($modulename);
			$array["username"]		=	m_login_id($db);
			$array["notification"]	=	$db->escape($message);
			m_db_row_insert($db, "dolibarr_xframework_messages", $array);} 
	/*******************************/
	/* Changes Now				   */
	/*******************************/
		/* Check if a Value has been Changed dramatically True or False */
		function d_is_change($db, $refid, $ref, $fieldname){	
			if(!d_trigger_react($ref)) {return false;}
			$objectstring		=  d_c_getStringFromDolibarr($db,$ref, $refid);
			$first  = explode(_MXINTCLASSX2546754_DELIMITER_1_, $objectstring);
			$tablestring     =  d_c_getStringFromDebug($db, $ref, $refid);
			$second = explode(_MXINTCLASSX2546754_DELIMITER_1_, $tablestring);
			$isADif	= false;
			foreach( $first as $key => $value ){
			$firstx  = explode(_MXINTCLASSX2546754_DELIMITER_2_, $value);
			foreach( $second as $key1 => $value1 ){
			$secondx = explode(_MXINTCLASSX2546754_DELIMITER_2_, $value1);
			if($firstx[0] == $secondx[0] AND $secondx[0] == $fieldname) {
			if($firstx[1] != $secondx[1]) {$isADif = true;}}}}
			return $isADif;}
		/* Get the Change if There if One otherwhise false, you get array key to and from */
		function d_get_change($db, $refid, $ref, $fieldname){
			if(!d_trigger_react($ref)) {return false;}
			$objectstring		=  d_c_getStringFromDolibarr($db, $ref, $refid);
			$first  = explode(_MXINTCLASSX2546754_DELIMITER_1_, $objectstring);
			$tablestring     = d_c_getStringFromDebug($db, $ref, $refid);
			$second = explode(_MXINTCLASSX2546754_DELIMITER_1_, $tablestring);
			$output = array();
			$isADif	= false;
			foreach( $first as $key => $value ){
			$firstx  = explode(_MXINTCLASSX2546754_DELIMITER_2_, $value);
			foreach( $second as $key1 => $value1 ){
			$secondx = explode(_MXINTCLASSX2546754_DELIMITER_2_, $value1);
			if($firstx[0] == $secondx[0] AND $secondx[0] == $fieldname) {
			$isADif = true;$output["from"] = $secondx[1];$output["to"] = $firstx[1];}}}
			if(!$isADif) {return false;}
			return $output;}
?>