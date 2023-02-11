<?php
	/* SEND A MESSAGE WITH DEBUGGING INFO TO THE LOG TABLE IN TOOLS   **/
		function d_message($db, $modulename, $message){
			$array = array(); $array["module"] = $db->escape($modulename);
			$array["username"]		=	m_login_id($db);
			$array["notification"]	=	$db->escape($message);
			m_db_row_insert($db, "llx_xframework_messages", $array);} 
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