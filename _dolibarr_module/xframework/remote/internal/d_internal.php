<?php
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
	function d_insertToLogTable($db, $string, $ref, $refid) { $array = array(); $array["ref"] = $db->escape($ref); $array["refid"] = $db->escape($refid); $array["changesstring"] = $db->escape(d_logstring_prepare($string)); $array["username"] = m_login_id($db); return m_db_row_insert($db, "llx_xframework_logging", $array, false);}
	/* Insert Something to the logging Table */
	function d_c_addItem($db, $string, $ref, $refid) { $array = array(); $array["ref"]	= $db->escape($ref); $array["refid"] = $db->escape($refid); $array["string"] = $string; return m_db_row_insert($db, "llx_xframework_bigdata", $array, false); }	
	/* Get the Checkstring from Bigdata Table */
	function d_c_getStringFromDebug($db, $tableelement, $id) { $tmpar =	m_db_row($db, "SELECT * FROM " . MAIN_DB_PREFIX . "xframework_bigdata WHERE refid = '" . $id . "' AND ref = '".$tableelement."'"); if ($tmpar) {return trim($tmpar["string"]);} else { return false; }}
	/* Catch Triggers if Activated */
	function d_trigger_triggers($db, $triggername, $object){
		$secstring	=	""; $secarray =	@get_object_vars($object); $array = array();
		foreach( @$secarray as $key => $value ){ if(!is_object($value)) {$secstring .= "".$key.":".$value."; ";} }		
		$array["triggername"]		=	"Trigger-Name\r\n ".@$db->escape($triggername)." ;\r\n Objekt-Daten: ".@$db->escape($secstring);
		$array["username"]			=	m_login_id($db);
		m_db_row_insert($db, "llx_xframework_triggers", $array);}
	/* Catch A Change if Constant is Activated */
	function d_trigger_changelog($db, $triggername, $object){
		if(!d_trigger_react($object->table_element)) {return false;}
		if($object->id <= 0) {return false;}					
		$dolistring		=  d_c_getStringFromDolibarr($db, $object->table_element, $object->id);
		$savestring     =  d_c_getStringFromDebug($db, $object->table_element, $object->id);
		if(!$dolistring) { return false; }
		if(!$savestring) { d_c_addItem($db, $dolistring, $object->table_element, $object->id);
		d_insertToLogTable($db, "New Item Added has been added!", $object->table_element, $object->id);
		} else { $stringdiff = d_getStringDiffString($dolistring, $savestring);
		if(is_string($stringdiff)) { d_insertToLogTable($db, $stringdiff, $object->table_element, $object->id); 
		$db->query("DELETE FROM " . MAIN_DB_PREFIX . "xframework_bigdata WHERE ref = '" . $object->table_element ."' AND refid = " . $object->id);
		d_c_addItem($db, $dolistring, $object->table_element, $object->id);
		}}}	
	/**INSTALLATION***********/
	function d_c_addInitNow($db, $type) {
		if(!d_trigger_react($type)) {echo "<font color='red'>ERROR ON TYPE!</font>"; return false;}
		$sql_res = $db->query("SELECT * FROM ".MAIN_DB_PREFIX.$type);
		if ($sql_res) { if ($db->num_rows($sql_res) > 0) {
			$count = $db->num_rows($sql_res);
				$db->query("DELETE FROM ".MAIN_DB_PREFIX."xframework_bigdata WHERE ref = '".$type."'");
				for ($i=0; $i<$count; $i++) { 
					$tmpnow = $db->fetch_object($sql_res);
					$dolistring		=  d_c_getStringFromDolibarr($db, $type, $tmpnow->rowid);
					d_c_addItem($db, $dolistring, $type, $tmpnow->rowid);} 		
			print "<font color='green'>ALL OK ON FETCHING ".$type."!</font>"; return true;
		} else { print "<font color='red'>ERROR ON FETCHING ".$type."!</font>"; return false; }
		} else { print "<font color='red'>ERROR ON FETCHING ".$type."!</font>"; return false; }}
?>