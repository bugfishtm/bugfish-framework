<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  MySQL Control Class */
	class x_class_mysql {
		// Table Construction
		private function create_table() {
			return $this->query("CREATE TABLE IF NOT EXISTS `".$this->logging_table."` (
								  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
								  `url` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Related URL',
								  `errtext` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Error Text',
								  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
								  `section` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Related Section',
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB AUTO_INCREMENT=3905 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");}
		private function create_table_qtt() {
			return $this->query("CREATE TABLE IF NOT EXISTS `".$this->qtt."` (
								  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
								  `url` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Related URL',
								  `counting` INT(10) NULL DEFAULT '0' COMMENT 'Error Text',
								  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
								  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
								  `section` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Related Section',
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB AUTO_INCREMENT=3905 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");}
		/*	__   ____ _ _ __ ___ 
			\ \ / / _` | '__/ __|
			 \ V / (_| | |  \__ \
			  \_/ \__,_|_|  |___/*/			 
			public  $mysqlcon			  = false;
			public  $mysqlcon_tmp		  = false;
			private $transaction 		  = false;
			public  $lasterror			  = false;
			public  $insert_id			  = false;
			private $logging			  = false;
			private $stoponexception	  = false; public function stoponexception($bool = false) { $this->stoponexception  = $bool; }
			private $stoponerror	  	  = false; public function stoponerror($bool = false) { $this->stoponerror  = $bool; }
			private $printerror	  	  = false; public function printerror($bool = false) { $this->printerror  = $bool; }
			private $qt	  	  = false; 
			private $qtt	  = false; 
			private $qts	  = false; 
			private $qtroot	  = false; 
			private $qtcookie  = false; 
			private $qtnodestruct  = false; 
				public function qt($bool = false, $tablename = "querytimer", $section = "", $preecookie = "", $nodestruct = false) {
					 // Set Vars
					 $this->qtt  = $tablename; 
					 $this->qts  = $section; 
					 $this->qtcoookie = $preecookie;
					 $this->qt  = $bool;
					 $this->qtroot  = @trim($this->escape(@$_SERVER["REQUEST_URI"])); 
					 
					 
					if($bool) {
						// Reset Counter
						$_SESSION["x_class_mysql_qt".$this->qtcookie] = 0;
						
						// Create Table
						try {$val = mysqli_query($this->mysqlcon, 'SELECT 1 FROM `'.$this->qtt.'`');
							 if($val == FALSE) { $this->create_table_qtt();}	
						} catch (Exception $e){$this->create_table_qtt();} 
					
						// Insert Into Table if Not Exists
						$ar = $this->select("SELECT * FROM ".$this->qtt." WHERE section = '".$this->qts."' AND url = \"".$this->qtroot."\"", false);
						if(!is_array($ar)) {$this->query("INSERT INTO ".$this->qtt."(url, section) VALUES(\"".$this->qtroot."\", '".$this->qts."')");}
					}
				}
				private function qtc_raise($raise = 1) { if(isset($_SESSION["x_class_mysql_qt".$this->qtcookie])) { $_SESSION["x_class_mysql_qt".$this->qtcookie] = $_SESSION["x_class_mysql_qt".$this->qtcookie] + 1; }	} 
				public function qtc_get_cur() { return $_SESSION["x_class_mysql_qt".$this->qtcookie];} 
				public function qtc_get($url = false) { if(!$url) { $url =  $this->qtroot; } else { $url = trim($this->escape($url)); } $ar = $this->select("SELECT * FROM ".$this->qtt." WHERE section = '".$this->qts."' AND url = \"".$url."\"", false); if(is_array($ar)) { return $ar["counting"];} else {return 0;}}
				
			private $logging_table		  = "";
			private $logging_section	  = "";
			private $logging_all	  = false;
				public function  loggingSetup($bool, $table = "mysqllogging", $section = "", $logall = false) {
					$this->logging = $bool; 
					$this->logging_all = $logall; 
					if($bool) {$this->logging_table = $table; $this->logging_section = $section;
					try {$val = $this->query('SELECT 1 FROM `'.$this->logging_table.'`');
						if($val == FALSE) { $this->create_table();}	
					} catch (Exception $e){$this->create_table();} }	  	
				}
			private function getIntCopy() { $tmpcon = $this; $tmpcon->qt(false, false, false, $this->qtcookie , true); return $tmpcon;}
			private function logError($string) { if(is_object($this->mysqlcon) AND $this->logging) { $tmpcon = $this->getIntCopy(); $inarray["section"] = $tmpcon->logging_section;$inarray["url"] = $tmpcon->escape(@$_SERVER["REQUEST_URI"]); $inarray["errtext"] = $tmpcon->escape(@$string); mysqli_query($tmpcon->mysqlcon, "INSERT INTO ".$tmpcon->logging_table."(url, errtext, section) VALUES(\"".$inarray["url"]."\", \"".$inarray["errtext"]."\", \"".$inarray["section"]."\");");   } }

		/*									 _   _             
											| | (_)            
			  ___ ___  _ __  _ __   ___  ___| |_ _  ___  _ __  
			 / __/ _ \| '_ \| '_ \ / _ \/ __| __| |/ _ \| '_ \  
			| (_| (_) | | | | | | |  __/ (__| |_| | (_) | | | |   
			 \___\___/|_| |_|_| |_|\___|\___|\__|_|\___/|_| |_|*/ 
		/********************** Construct Connection ****/	 
		function __construct($hostname, $username, $password, $database, $ovrcon = false) { if(!$ovrcon) {
			if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
			try { $this->mysqlcon = @mysqli_connect($hostname, $username, $password, $database); 
				   if(@mysqli_connect_errno()) { $this->lasterror  =  @mysqli_connect_error(); } else { $this->status(); }
			} catch (Exception $e){ $this->status(); }
		} else { $this->mysqlcon = $ovrcon; $this->status(); } }
		/********************** Log Connection Error in Var ****/	
		//private $mysql_last_preserve = false;
		private $laststatebeforeexception = false;
		private function logLastError($errorBool, $lq = "") {
			if($errorBool == "exception") {
				$this->lasterror = "Additional Information: ".$lq." | MySQL Error: ".@mysqli_error($this->mysqlcon);
				$this->logError($this->lasterror." [log#exception] ");
				if($this->printerror) { echo $this->lasterror; }
				if($this->stoponexception) { exit(); }
				return false;
			} elseif(!@$errorBool) {
				try {
					$this->lasterror = "Additional Information: ".$lq." | MySQL Error: ".@mysqli_error($this->mysqlcon);
					$this->logError($this->lasterror." [log#false] ");
					if($this->printerror) { echo $this->lasterror; }
				} catch (Exception $e){ $this->lasterror = $lq.$e->getMessage(); $this->logError($this->lasterror." [log#false#exception] "); }
				if($this->stoponerror) { exit(); }
				return $errorBool;
			} else {
				if($this->logging_all) {$this->logError("SUCCESS QUERY: ".$lq." [log#false] "); }
				$this->lasterror = false;
				$this->insert_id = @$this->mysqlcon->insert_id;
				return $errorBool;
			}
		}
		/********************** Get Ping MySQL Status ****/	
		public function ping() 			{ try { if(is_object($this->mysqlcon)) { return $this->logLastError(@mysqli_ping($this->mysqlcon), " [ping]"); } else { $this->lasterror = "Error on Class Function: ping() - MySQLi Connection Object is invalid!"; return false; } } catch (Exception $e){ return $this->logLastError("exception", " [ping#exception] ".$e->getMessage()); }  }					
		/********************** Get Connection Status ****/	
		public function status() 		{ if(is_object($this->mysqlcon)) { $this->lasterror = false; return true; } else { $this->lasterror = "Error on Class Function: status() - MySQLi Connection Object is invalid!"; return false; } }
		/********************** Mysql Filter a Variable ****/	
		public function escape($val) 	{if($this->mysqlcon) {return @mysqli_real_escape_string($this->mysqlcon, $val);} else { return false; } }	
		/********************** Destroy Connection ****/	
		function __destruct() {if($this->qt AND is_object($this->mysqlcon) AND !$this->qtnodestruct) {$this->query("UPDATE ".$this->qtt." SET counting = '".$this->escape($_SESSION["x_class_mysql_qt".$this->qtcookie])."' WHERE section = '".$this->qts."' AND url = \"".trim($this->escape(@$_SERVER["REQUEST_URI"]))."\"");}}
		
		/**********************  Some Operational Functions Generic ****/
		public function get_row($table, $id, $row = "id") { 
			$bindar[0]["value"] = $id;
			$bindar[0]["type"]  = "s";
			return $this->select("SELECT * FROM ".$table." WHERE ".$row." = ?", false, $bindar); 
		}
		public function get_row_element($table, $id, $row = "id", $elementrow = "x", $fallback = false) { 
			$bindar[0]["value"] = $id;
			$bindar[0]["type"]  = "s";
			$ar =  $this->select("SELECT * FROM ".$table." WHERE ".$row." = ?", false, $bindar); 
			if(is_array($ar)) {
				if(isset($ar[$elementrow])) {
					return $ar[$elementrow];
				} return $fallback;
			} else { return $fallback; }	
		}
		public function change_row_element($table, $id, $row = "id", $element = "x", $elementrow = "x") { 
			$bindar[0]["value"] = $element;
			$bindar[0]["type"]  = "s";
			$bindar[1]["value"] = $id;
			$bindar[1]["type"]  = "s";
			return $this->select("UPDATE ".$table." SET ".$elementrow." = ? WHERE ".$row." = ?", false, $bindar); 
		}		
		public function exist_row($table, $id, $row = "id") {  
			$bindar[0]["value"] = $id;
			$bindar[0]["type"]  = "s";		
			$tmp =  $this->select("SELECT * FROM ".$table." WHERE ".$row." = ?", false, $bindar); if(is_array($tmp)) {return true;} else {return false;}
		}
		public function get_rows($table, $id, $row = "id") { 
			$bindar[0]["value"] = $id;
			$bindar[0]["type"]  = "s";
			return $this->select("SELECT * FROM ".$table." WHERE ".$row." = ?", true, $bindar); 		
		}
		public function del_row($table, $id, $row = "id") { 
			$bindar[0]["value"] = $id;
			$bindar[0]["type"]  = "s";		
			return $this->query("DELETE FROM ".$table." WHERE ".$row." = ?", $bindar); 
		}
		# Table Operations
		public function table_exists($tablename){return $this->query('SELECT 1 FROM `'.$tablename.'`');}
		public function table_delete($tablename){return $this->query('DROP TABLE `'.$tablename.'`');}
		public function table_create($tablename){return $this->query('CREATE TABLE `'.$tablename.'`');}
		# Database Operations
		public function database_delete($database){return $this->query('DROP DATABASE `'.$tablename.'`');}
		public function database_create($database){return $this->query('CREATE DATABASE `'.$tablename.'`');}
		public function database_object($database) { if($this->database_exists($database)) {$new = $this->getIntCopy(); if($new->database_use($database)) { return $new; } } return false;}
		public function database_use($database) { $this->qtc_raise(1); return $this->logLastError(mysqli_select_db($this->mysqlcon, $database), $database." [mysqli_select_db]");}
		public function database_exists($database) { return $this->query("SHOW DATABASES LIKE '".$database."';");}
		
		/*			  _           _   @mysqli_query($this->mysqlcon, $nnnnquery), " [insert]");
					 | |         | |  
			 ___  ___| | ___  ___| |_ 
			/ __|/ _ \ |/ _ \/ __| __|
			\__ \  __/ |  __/ (__| |_ 
			|___/\___|_|\___|\___|\__|*/
		/********************** Select Statement for Multi Purpose ****/	 
		/********************** Multiple = True get Multi Array with different Rows | False get Single Array with Row ****/	 
		/********************** If Bindarray = false -> normal input query | If not deliver Multi Array with Array[X]["value"] = VALUE and Array[X]["type"] ****/	 
		/********************** TYPE //Binding parameters. Types: s = string, i = integer, d = double,  b = blob] ****/	 
		public function select($query, $multiple = false, $bindarray = false, $fetch_type = MYSQLI_ASSOC){ try {
			if(is_array($bindarray)) { $this->qtc_raise(1);
				if ($xxx = $this->logLastError($stmt = @$this->mysqlcon->prepare($query), $query." [select#prepare]")) { 
					$before_prepare	=	"";
					$params	=	array(); 
					foreach ($bindarray as $key => $value) {
						$before_prepare .= $value["type"];
						array_push($params, $value["value"]);};
					array_unshift($params, $before_prepare);
					$tmp = array();
					foreach($params as $key => $value) {$tmp[$key] = &$params[$key];}
					@call_user_func_array(array($stmt, 'bind_param'), $tmp);
					if($currentoutput = @$stmt->execute()){
						if($newres = @$stmt->get_result()){
							if($multiple) {
								return $this->logLastError($newres->fetch_all($fetch_type), $query." [select#fetchall]");
							} else {return $this->logLastError($newres->fetch_array($fetch_type), $query." [select#fetch]");}
						} else { return $this->logLastError($currentoutput, $query." [select#get_result]");}
					} else {return $this->logLastError($currentoutput, $query." [select#execute]");} } else {return $xxx;}
			} else {
				$this->qtc_raise(1);
				if ($sql_res = $this->logLastError(@mysqli_query($this->mysqlcon, $query), $query." [select]")) { if (mysqli_num_rows($sql_res) > 0) {
					if(!$multiple) {return mysqli_fetch_array($sql_res, $fetch_type); }
					$count = mysqli_num_rows($sql_res);$row = array();for ($i=0; $i<$count; $i++){
					$tmpnow = mysqli_fetch_array($sql_res, $fetch_type); $row[$i] = $tmpnow;}return $row;				
				} else {return $sql_res;}} else {return $sql_res;}
			} } catch (Exception $e){ return $this->logLastError("exception", " [select#exception] ".$e->getMessage()); }}

		/*	 _                     _   
			(_)                   | |  
			 _ _ __  ___  ___ _ __| |_ 
			| | '_ \/ __|/ _ \ '__| __|
			| | | | \__ \  __/ |  | |_ 
			|_|_| |_|___/\___|_|   \__|*/
		/********************** Select Statement for Multi Purpose ****/	 
		/********************** Table = Table Name to Insert ****/	 
		/********************** Array = Array to be Inserted Array[fieldname] = value ****/	 
		/********************** If Bindarray = false -> normal input query | If not deliver Multi Array with Array[X]["value"] = VALUE and Array[X]["type"] ****/	 
		/********************** TYPE //Binding parameters. Types: s = string, i = integer, d = double,  b = blob] ****/	 
		public function insert($table, $array, $bindarray = false){
			try {  
				if(is_array($bindarray)) { $this->qtc_raise(1);
					if(!is_array($array)) {return false;}
					$build_first	=	"";$build_second	=	"";$firstrun = true;
					foreach( $array as $key => $value ){if(!$firstrun) {$build_first .= ", ";}
					if(!$firstrun) {$build_second .= ", ";}$build_first .= $key;
					if($value == "?") {$build_second .= $value;} else {$build_second .= "'".$value."'";}$firstrun = false;}
					$newquery = 'INSERT INTO '.$table.'('.$build_first.') VALUES('.$build_second.');';
					if ($this->logLastError($stmt = @$this->mysqlcon->prepare($newquery), $table." [insert#prepare]")) { 
						$before_prepare	=	"";
						$params	=	array(); 
						foreach ($bindarray as $key => $value) {
							$before_prepare .= $value["type"];
							array_push($params, $value["value"]);};
						array_unshift($params, $before_prepare);
						$tmp = array();
						foreach($params as $key => $value) {$tmp[$key] = &$params[$key];}
						@call_user_func_array(array($stmt, 'bind_param'), $tmp);
						return $this->logLastError(@$stmt->execute(), $table." [insert#execute]"); } else {return false;}
				} else {	
					$this->qtc_raise(1);
					if(!is_array($array)) {return false;}
					$build_first	=	"";$build_second	=	"";$firstrun = true;
					foreach( $array as $key => $value ){if(!$firstrun) {$build_first .= ", ";}
					if(!$firstrun) {$build_second .= ", ";}$build_first .= $key;
					$build_second .= "'".$value."'";
					$firstrun = false;}
					$nnnnquery	=	'INSERT INTO '.$table.'('.$build_first.') VALUES('.$this->escape($build_second).');';
					return $this->logLastError(@mysqli_query($this->mysqlcon, $nnnnquery), $table." [insert]");					
				}
			} catch (Exception $e){ return $this->logLastError("exception", $table." [insert#exception] ".$e->getMessage()); }}
				
		/*	  __ _ _   _  ___ _ __ _   _ 
			 / _` | | | |/ _ \ '__| | | |
			| (_| | |_| |  __/ |  | |_| |
			 \__, |\__,_|\___|_|   \__, |
				| |                 __/ |
				|_|                |___/ */
		/********************** Select Statement for Multi Purpose ****/	 
		/********************** Query = The Query ****/	 
		/********************** If Bindarray = false -> normal input query | If not deliver Multi Array with Array[X]["value"] = VALUE and Array[X]["type"] ****/	 
		/********************** TYPE //Binding parameters. Types: s = string, i = integer, d = double,  b = blob] ****/	 
		public function query($query, $bindarray = false){
			try {  if(is_array($bindarray)) { $this->qtc_raise(1);
				if ($xxx = $this->logLastError($stmt = @$this->mysqlcon->prepare($query), " [query#prepare]")) { 
					$before_prepare	=	"";
					$params	=	array(); 
					foreach ($bindarray as $key => $value) {
						$before_prepare .= $value["type"];
						array_push($params, $value["value"]);};
					array_unshift($params, $before_prepare);
					$tmp = array();
					foreach($params as $key => $value) {$tmp[$key] = &$params[$key];}
					@call_user_func_array(array($stmt, 'bind_param'), $tmp);
					if($currentoutput = $stmt->execute()) { 
						if($newres = @$stmt->get_result()){
								return $this->logLastError($newres, $query." [query#bind]");
						} else { return $this->logLastError($currentoutput, $query." [query#get_result]");}
					} else {  return $this->logLastError($currentoutput, $query." [query#execute]");}
					} else {return $xxx;}
			} else { $this->qtc_raise(1); return $this->logLastError(@mysqli_query($this->mysqlcon, $query), $query." [query]");}
			} catch (Exception $e){ return $this->logLastError("exception", $query." [query#exception] ".$e->getMessage()); }}
				
		/*			   _          
					  (_)         
			 _ __ ___  _ ___  ___ 
			| '_ ` _ \| / __|/ __|
			| | | | | | \__ \ (__ 
			|_| |_| |_|_|___/\___| */
		public function backup_table($tablex, $filepath, $withdata = true, $dropstate = false){
		  $data = "";
	      $tables = array($tablex);
		  foreach($tables as $table){          
			if($dropstate) { $data.= "DROP TABLE IF EXISTS `{$table}`;\n"; }
			$res = $this->query("SHOW CREATE TABLE `{$table}`");
			$row = mysqli_fetch_row($res);
			$data.= $row[1].";\n";
			$result = $this->query("SELECT * FROM `{$table}`");
			$num_rows = mysqli_num_rows($result);    
			if($withdata) {
				if($num_rows>0){
				  $vals = Array(); $z=0;
				  for($i=0; $i<$num_rows; $i++){
					$items = mysqli_fetch_row($result);
					$vals[$z]="(";
					for($j=0; $j<count($items); $j++){
					  if (isset($items[$j])) { $vals[$z].= "'".$this->escape( $items[$j] )."'"; } else { $vals[$z].= "NULL"; }
					  if ($j<(count($items)-1)){ $vals[$z].= ","; }
					}
					$vals[$z].= ")"; $z++;
				  }
				  $data.= "INSERT INTO `{$table}` VALUES ";      
				  $data .= "  ".implode(";\nINSERT INTO `{$table}` VALUES ", $vals).";\n";
				}
			  }
		  }
			$handle = fopen($filepath,'w+');
			fwrite($handle,$data);
			fclose($handle);
			return true;
		}			
		public function multi_query($query) { 
			try { $this->qtc_raise(1); return $this->logLastError($this->mysqlcon->multi_query($query), $query." [multi_query]"); 
			} catch (Exception $e){ return $this->logLastError("exception", $query." [multi_query#exception] ".$e->getMessage()); }
		}
		public function multi_query_file($file) { 
			if(file_exists($file)) {
				try { $this->qtc_raise(1); $sql = file_get_contents($file);
				return $this->logLastError($this->mysqlcon->multi_query($sql), "File: ".$file." [multi_query_file]"); 
				} catch (Exception $e){ return $this->logLastError("exception", "File: ".$file." [multi_query_file#exception] ".$e->getMessage()); }
			} return false;
		}
		public function increase($table, $nameidfield, $id, $increasefield, $increasevalue = 1){
			try { $this->qtc_raise(1); $newquery = "UPDATE ".$table." SET ".$increasefield." = ".$increasefield." + ".$increasevalue." WHERE ".$nameidfield." = '".$id."'";
			return $this->logLastError(@mysqli_query($this->mysqlcon, $newquery), $table." ".$nameidfield." ".$id." ".$increasefield." [increase]");
			} catch (Exception $e){ return $this->logLastError("exception", $table." ".$nameidfield." ".$id." ".$increasefield." [increase#exception] ".$e->getMessage()); }}
		
		public function auto_increment($table, $value){
			try { $this->qtc_raise(1); $newquery = "ALTER TABLE ".$table." AUTO_INCREMENT = ".$value."";
			return $this->logLastError(@mysqli_query($this->mysqlcon, $newquery), $table." ".$value." [auto_increment]");
			} catch (Exception $e){ return $this->logLastError("exception", $table." ".$value." [auto_increment#exception] ".$e->getMessage()); }}
		
		public function decrease($table, $nameidfield, $id, $decreasefield, $decreasevalue = 1){
			try{ $this->qtc_raise(1); $newquery = "UPDATE ".$table." SET ".$decreasefield." = ".$decreasefield." + ".$decreasevalue." WHERE ".$nameidfield." = '".$id."'";
			return $this->logLastError(@mysqli_query($this->mysqlcon, $newquery), $table." ".$nameidfield." ".$id." ".$decreasefield." [decrease]");
			} catch (Exception $e){ return $this->logLastError("exception", $table." ".$nameidfield." ".$id." ".$decreasefield." [decrease#exception] ".$e->getMessage()); }}									

		public function displayError($exit = false) {
			http_response_code(503);
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
			"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
			<html version="-//W3C//DTD XHTML 1.1//EN"
				  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"
				  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
				  xsi:schemaLocation="http://www.w3.org/1999/xhtml
									  http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd">
				<head>
					<title>Database Error</title>
					<meta http-equiv="content-Type" content="text/html; utf-8" />
					<meta name="robots" content="noindex, nofollow" />
					<meta http-equiv="Pragma" content="no-cache" />
					<meta http-equiv="content-Language" content="en" />
					<meta name="viewport" content="width=device-width, initial-scale=1">
					<style>
					html, body { background: blue; color: white; font-family: Arial; text-align: center; margin: 0 0 0 0; padding: 0 0 0 0; position: absolute; width: 100%; top: 0px; left: 0px; height: 100vh; }
					a { color: black; text-decoration: none; font-weight: bold; background: green; border-radius: 10px; font-size: 16px; padding: 15px; word-break: keep-all; white-space: nowrap; }		
					a:hover { color: black; text-decoration: none; font-weight: bold; background: white; border-radius: 10px; font-size: 16px; padding: 15px; }
					#dberrorwrapper { text-align: center; color: lightblue; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
					</style>
					<meta name="expires" content="0" />	
				</head>
				<body>
					<div id="dberrorwrapper"><font size="+5">Error 503</font><br/><font size="+3">Site under Maintenance...</font><br />Please check in later! x)</div>
				</body></html>';if($exit){exit();}}

		/*	 _                                  _   _                 
			| |                                | | (_)                
			| |_ _ __ __ _ _ __  ___  __ _  ___| |_ _  ___  _ __  ___ 
			| __| '__/ _` | '_ \/ __|/ _` |/ __| __| |/ _ \| '_ \/ __|
			| |_| | | (_| | | | \__ \ (_| | (__| |_| | (_) | | | \__ \
			 \__|_|  \__,_|_| |_|___/\__,_|\___|\__|_|\___/|_| |_|___/*/
		/********************** Start A Transaction if none is Running ****/
		public function transaction() {try {$this->qtc_raise(1); if($this->mysqlcon && !$this->transaction) { $this->mysqlcon->autocommit(FALSE);$this->transaction = true; return $this->logLastError(@mysqli_begin_transaction($this->mysqlcon), " [transaction]");} return false; } catch (Exception $e){ return $this->logLastError("exception", " [transaction#exception] ".$e->getMessage()); }}
		/********************** Rollback A Transaction if is Running ****/
		public function rollback() {try {$this->qtc_raise(1); if($this->mysqlcon && $this->transaction) { $this->transaction = false; return $this->logLastError(@mysqli_rollback($this->mysqlcon), " [rollback]");}return false; } catch (Exception $e){ return $this->logLastError("exception", " [rollback#exception] ".$e->getMessage()); }}
		/********************** Get Transaction Status ****/
		public function transactionStatus() {return $this->transaction;}
		/********************** Commit a Transaction ****/
		public function commit() {try { $this->qtc_raise(1); if($this->mysqlcon && $this->transaction) {  $this->transaction = false; return $this->logLastError(@mysqli_commit($this->mysqlcon), " [commit]");}return false; } catch (Exception $e){ return $this->logLastError("exception", " [commit#exception] ".$e->getMessage()); }}
	}
?>