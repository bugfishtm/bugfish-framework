<?php
	// Get the current rowID of logged in User, if error than false
	function m_login_id($db){ $result = m_db_row($db, 'SELECT * FROM ' . MAIN_DB_PREFIX . 'user WHERE login = "' . @$_SESSION["dol_login"] . '"'); if(!$result) {return false;}return $result["rowid"];}	
	// Get the current name of User by UserID, if error than false
	function m_login_name_from_id($db, $userid){ $result = m_db_row($db, 'SELECT * FROM ' . MAIN_DB_PREFIX . 'user WHERE rowid = "' . $userid . '"'); if(!$result) {return false;} return $result["login"];}	
?>