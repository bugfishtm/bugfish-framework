<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  MySQL Control Class */
	class x_class_mysql {
		/*	___________     ___.   .__                 
			\__    ___/____ \_ |__ |  |   ____   ______
			  |    |  \__  \ | __ \|  | _/ __ \ /  ___/
			  |    |   / __ \| \_\ \  |_\  ___/ \___ \ 
			  |____|  (____  /___  /____/\___  >____  >
						   \/    \/          \/     \/		*/
		private function create_table() {
			return $this->query("CREATE TABLE IF NOT EXISTS `".$this->logging_table."` (
								  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
								  `url` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Related URL',
								  `errtext` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Error Text',
								  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
								  `section` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Related Section',
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB AUTO_INCREMENT=3905 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");}
		/*	__   ____ _ _ __ ___ 
			\ \ / / _` | '__/ __|
			 \ V / (_| | |  \__ \
			  \_/ \__,_|_|  |___/	*/			 
			public  $mysqlcon			  = false;
			public  $mysqlcon_tmp		  = false;
			private $transaction 		  = false;
			public  $lasterror			  = false;
			public  $insert_id			  = false;
			private $logging			  = false;
			private $stoponexception	  = false; public function stoponexception($bool = false) { $this->stoponexception  = $bool; }
			private $stoponerror	  	  = false; public function stoponerror($bool = false) { $this->stoponerror  = $bool; }
			private $printerror	  	  	  = false; public function printerror($bool = false) { $this->printerror  = $bool; }

		/*	___________.__                      
			\__    ___/|__| _____   ___________ 
			  |    |   |  |/     \_/ __ \_  __ \
			  |    |   |  |  Y Y  \  ___/|  | \/
			  |____|   |__|__|_|  /\___  >__|   
								\/     \/      */
			private $qt	  	  = false; 
			private $qtcookie  = false; 
			private $qtnodestruct  = false; 
			private function qtc_raise($raise = 1) { if(isset($_SESSION["x_class_mysql_qt".$this->qtcookie])) { $_SESSION["x_class_mysql_qt".$this->qtcookie] = $_SESSION["x_class_mysql_qt".$this->qtcookie] + 1; } } 
			public function qtc_get_cur() { return $_SESSION["x_class_mysql_qt".$this->qtcookie];}
			public function qtc_get($url = false) { if(!$url) { $url =  $this->qtroot; } else { $url = trim($this->escape($url)); } $ar = $this->select("SELECT * FROM ".$this->qtt." WHERE section = '".$this->qts."' AND url = \"".$url."\"", false); if(is_array($ar)) { return $ar["counting"];} else {return 0;}}
			public function qtc_update() {if($this->qt AND is_object($this->mysqlcon)) {$this->query("UPDATE ".$this->qtt." SET counting = '".$this->escape($_SESSION["x_class_mysql_qt".$this->qtcookie])."' WHERE section = '".$this->qts."' AND url = \"".trim($this->escape(@$_SERVER["REQUEST_URI"]))."\"");}}			
			public function qt($bool = false, $preecookie = "") {
				 // Set Vars
				 $this->qtcoookie = $preecookie;
				 $this->qt  	= $bool;
				if($bool) {$_SESSION["x_class_mysql_qt".$this->qtcookie] = 0;}
			}			
		/*	.____                        .__                
			|    |    ____   ____   ____ |__| ____    ____  
			|    |   /  _ \ / ___\ / ___\|  |/    \  / ___\ 
			|    |__(  <_> ) /_/  > /_/  >  |   |  \/ /_/  >
			|_______ \____/\___  /\___  /|__|___|  /\___  / 
					\/    /_____//_____/         \//_____/ 		*/
			private $logging_table		  = "";
			private $logging_section	  = "";
			private $logging_all	  = false;
			public function  loggingSetup($bool, $table = "mysqllogging", $section = "", $logall = false) {
				$this->logging = $bool; 
				$this->logging_all = $logall; 
				if($bool) {
					$this->logging_table = $table; $this->logging_section = $section;
					if(!$this->table_exists($this->logging_table)) { $this->create_table();}
				}	  	
			}
			private function logError($string) { if(is_object($this->mysqlcon) AND $this->logging) { $tmpcon = $this->getIntCopy(); $inarray["section"] = $this->logging_section;$inarray["url"] = $tmpcon->escape(@$_SERVER["REQUEST_URI"]); $inarray["errtext"] = $tmpcon->escape(@$string); mysqli_query($tmpcon->mysqlcon, "INSERT INTO ".$this->logging_table."(url, errtext, section) VALUES(\"".$inarray["url"]."\", \"".$inarray["errtext"]."\", \"".$inarray["section"]."\");"); } }
				
		/*			   _          
					  (_)         
			 _ __ ___  _ ___  ___ 
			| '_ ` _ \| / __|/ __|
			| | | | | | \__ \ (__ 
			|_| |_| |_|_|___/\___| */
		/********************** Construct Connection ****/	 
		private $auth_user	= false;
		private $auth_pass	= false;
		private $auth_host	= false;
		private $auth_db	= false;
		private $auth_ovr	= false;
		function __construct($hostname, $username, $password, $database, $ovrcon = false) { if(!$ovrcon) {
			$this->auth_user = $username;
			$this->auth_pass = $password;
			$this->auth_host = $hostname;
			$this->auth_db = $database;
			if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
			try { $this->mysqlcon = @mysqli_connect($hostname, $username, $password, $database); 
				   if(@mysqli_connect_errno()) { $this->lasterror  =  @mysqli_connect_error(); } else { $this->status(); }
			} catch (Exception $e){ $this->status(); }
		} else { $this->auth_ovr = $ovrcon; $this->mysqlcon = $ovrcon; $this->status(); } }
		/********************** Get Ping MySQL Status ****/	
		public function ping() 			{ try { if(is_object($this->mysqlcon)) { return $this->requestHandler(@mysqli_ping($this->mysqlcon), " [ping]"); } else { $this->lasterror = "Error on Class Function: ping() - MySQLi Connection Object is invalid!"; return false; } } catch (Exception $e){ return $this->requestHandler("exception", " [ping#exception] ", $e); }  }					
		/********************** Get Connection Status ****/	
		public function status() 		{ if(is_object($this->mysqlcon)) { $this->lasterror = false; return true; } else { $this->lasterror = "Error on Class Function: status() - MySQLi Connection Object is invalid!"; return false; } }
		/********************** Mysql Filter a Variable ****/	
		public function escape($val) 	{if($this->mysqlcon) {return @mysqli_real_escape_string($this->mysqlcon, $val);} else { return false; } }	
		/********************** Destroy Connection ****/	
		function __destruct() { /* Nothing */ }
		/**************** Internal Function to get Class Copy */
		private function getIntCopy() { return new x_class_mysql($this->auth_host, $this->auth_user, $this->auth_pass, $this->auth_db); }
		/**************** Next Result */
		public function next_result() { try { return mysqli_next_result($this->mysqlcon); } catch(Exception $e) { return false; } }
		/**************** Store Result */
		public function store_result() { return mysqli_store_result($this->mysqlcon); }
		/**************** More Results? */
		public function more_results() { try { return mysqli_more_results($this->mysqlcon); } catch(Exception $e) { return false; } }
		/**************** Store Result Array */
		public function fetch_array($result) { try {  return mysqli_fetch_array($result); } catch(Exception $e) { return false; } }
		/**************** Store Result Object */
		public function fetch_object($result) { try { return mysqli_fetch_object($result); } catch(Exception $e) { return false; } }
		/**************** Free Result */
		public function free_result($result) { try {  return mysqli_free_result($result); } catch(Exception $e) { return false; } }
		/**************** Free All */
		public function free_all($save = false) { 
			$results = array();	
			try {
				
				$x = mysqli_use_result($this->mysqlcon);
				if($save == "object") { $y	= mysqli_fetch_object($x); }
				if($save == "array") { $y = mysqli_fetch_array($x); }
				else { $y = false; }
				array_push($results, $y);
				if(is_object($x)) { mysqli_free_result($x); }
				
			} catch (Exception $e){ }	
			
				while ($this->more_results()) {
					if ($this->next_result()) {
						$x = mysqli_store_result($this->mysqlcon);
						if($save == "object") { $y	= mysqli_fetch_object($x); }
						if($save == "array") { $y = mysqli_fetch_array($x); }
						else { $y = false; }				
						array_push($results, $y); 
						if(is_object($x)) { $this->free_result($x); }
					}
				}	
				
			
			return $results;
		}	
		
		/********************** Log Connection Error in Var ****/	
		private function requestHandler($excecution, $log_string = "", $exception = false) {
			// Set Counting Vars
			$this->insert_id = @$this->mysqlcon->insert_id;
			
			// Request Handling
			if($excecution == "exception") {
				if(is_object($exception)) {
					$this->lasterror = "Additional Information: ".$log_string." | MySQL Error: ".@$exception->getMessage();
					$this->logError($this->lasterror." [log#exception] ");
					if($this->printerror) { echo $this->lasterror; }
					if($this->stoponexception) { exit(); }
					if($this->stoponerror) { exit(); }				
					return false;
				} else { return false; }
			} elseif(!$excecution) {
				try {
					$this->lasterror = "Additional Information: ".$log_string." | MySQL Error: ".@mysqli_error($this->mysqlcon);
					$this->logError($this->lasterror." [log#false] ");
				} catch (Exception $e){ 
					$this->lasterror = "Additional Information: ".$log_string." | Exception Error: ".@$e->getMessage();
					$this->logError($this->lasterror." [log#false#exception] "); 
				}
				if($this->printerror) { echo $this->lasterror; }
				if($this->stoponexception) { exit(); }
				if($this->stoponerror) { exit(); }					
				return $excecution;
			} else {
				if($this->logging_all) {$this->logError("SUCCESS QUERY: ".$log_string." [log#true] "); }
				$this->lasterror = false;
				return $excecution;
			}
		}
		
		/*			  _           _   
					 | |         | |  
			 ___  ___| | ___  ___| |_ 
			/ __|/ _ \ |/ _ \/ __| __|
			\__ \  __/ |  __/ (__| |_ 
			|___/\___|_|\___|\___|\__|  */
		/********************** Select Statement for Multi Purpose ****/	 
		/********************** Multiple = True get Multi Array with different Rows | False get Single Array with Row ****/	 
		/********************** If Bindarray = false -> normal input query | If not deliver Multi Array with Array[X]["value"] = VALUE and Array[X]["type"] ****/	 
		/********************** TYPE //Binding parameters. Types: s = string, i = integer, d = double,  b = blob] ****/	 
		public function select($query, $multiple = false, $bindarray = false, $fetch_type = MYSQLI_ASSOC){ try {
			if(is_array($bindarray)) { $this->qtc_raise(1);
				if ($xxx = $this->requestHandler($stmt = @$this->mysqlcon->prepare($query), $query." [select#prepare]")) { 
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
							@$stmt->free_result();
							if($multiple) {
								$xrow = $this->requestHandler($newres->fetch_all($fetch_type), $query." [select#fetchall]");
								$newres->free_result();
								return $xrow;
							} else {$xrow = $this->requestHandler($newres->fetch_array($fetch_type), $query." [select#fetch]"); $newres->free_result(); return $xrow;}
						} else { return $this->requestHandler($currentoutput, $query." [select#get_result]");}
					} else {return $this->requestHandler($currentoutput, $query." [select#execute]");} } else {return $xxx;}
			} else {
				$this->qtc_raise(1);
				if ($sql_res = $this->requestHandler(@mysqli_query($this->mysqlcon, $query), $query." [select]")) { if (mysqli_num_rows($sql_res) > 0) {
					if(!$multiple) {  $xrow = mysqli_fetch_array($sql_res, $fetch_type); mysqli_free_result($sql_res); return $xrow;}
					$count = mysqli_num_rows($sql_res);$row = array();for ($i=0; $i<$count; $i++){
					$tmpnow = mysqli_fetch_array($sql_res, $fetch_type); $row[$i] = $tmpnow;  } mysqli_free_result($sql_res); return $row;				
				} else {return $sql_res;}} else {return $sql_res;}
			} } catch (Exception $e){ return $this->requestHandler("exception", " [select#exception] ", $e); }}

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
					if ($this->requestHandler($stmt = @$this->mysqlcon->prepare($newquery), $table." [insert#prepare]")) { 
						$before_prepare	=	"";
						$params	=	array(); 
						foreach ($bindarray as $key => $value) {
							$before_prepare .= $value["type"];
							array_push($params, $value["value"]);};
						array_unshift($params, $before_prepare);
						$tmp = array();
						foreach($params as $key => $value) {$tmp[$key] = &$params[$key];}
						@call_user_func_array(array($stmt, 'bind_param'), $tmp);
						return $this->requestHandler(@$stmt->execute(), $table." [insert#execute]"); } else {return false;}
				} else {	
					$this->qtc_raise(1);
					if(!is_array($array)) {return false;}
					$build_first	=	"";$build_second	=	"";$firstrun = true;
					foreach( $array as $key => $value ){if(!$firstrun) {$build_first .= ", ";}
					if(!$firstrun) {$build_second .= ", ";}$build_first .= $key;
					$build_second .= "'".$this->escape($value)."'";
					$firstrun = false;}
					$nnnnquery	=	'INSERT INTO '.$table.'('.$build_first.') VALUES('.$build_second.');';
					return $this->requestHandler(@mysqli_query($this->mysqlcon, $nnnnquery), $table." [insert]");					
				}
			} catch (Exception $e){ return $this->requestHandler("exception", $table." [insert#exception] ", $e); }}
				
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
				if ($xxx = $this->requestHandler($stmt = @$this->mysqlcon->prepare($query), " [query#prepare]")) { 
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
								@$stmt->free_result();
								return $this->requestHandler($newres, $query." [query#bind]");
						} else { return $this->requestHandler($currentoutput, $query." [query#get_result]");}
					} else {  return $this->requestHandler($currentoutput, $query." [query#execute]");}
					} else {return $xxx;}
			} else { $this->qtc_raise(1); return $this->requestHandler(@mysqli_query($this->mysqlcon, $query), $query." [query]");}
			} catch (Exception $e){ return $this->requestHandler("exception", $query." [query#exception] ", $e);  }}

		/*	________          __        ___.                                
			\______ \ _____ _/  |______ \_ |__ _____    ______ ____   ______
			 |    |  \\__  \\   __\__  \ | __ \\__  \  /  ___// __ \ /  ___/
			 |    `   \/ __ \|  |  / __ \| \_\ \/ __ \_\___ \\  ___/ \___ \ 
			/_______  (____  /__| (____  /___  (____  /____  >\___  >____  >
					\/     \/          \/    \/     \/     \/     \/     \/   */
		# Database Operations
		public function database_delete($database){return $this->query('DROP DATABASE `'.$tablename.'`');}
		public function database_create($database){return $this->query('CREATE DATABASE `'.$tablename.'`');}
		public function database_object($database) { if($this->database_exists($database)) {$new = $this->getIntCopy(); if($new->database_use($database)) { return $new; } } return false;}
		public function database_use($database) { $this->qtc_raise(1); return $this->requestHandler(mysqli_select_db($this->mysqlcon, $database), $database." [mysqli_select_db]");}
		public function database_exists($database) { return $this->query("SHOW DATABASES LIKE '".$database."';");}
			
		/*	___________     ___.   .__                 
			\__    ___/____ \_ |__ |  |   ____   ______
			  |    |  \__  \ | __ \|  | _/ __ \ /  ___/
			  |    |   / __ \| \_\ \  |_\  ___/ \___ \ 
			  |____|  (____  /___  /____/\___  >____  >
						   \/    \/          \/     \/ */
		public function auto_increment($table, $value){
			try { $this->qtc_raise(1); $newquery = "ALTER TABLE ".$table." AUTO_INCREMENT = ".$value."";
			return $this->requestHandler(@mysqli_query($this->mysqlcon, $newquery), $table." ".$value." [auto_increment]");
			} catch (Exception $e){ return $this->requestHandler("exception", $table." ".$value." [auto_increment#exception] ", $e); }}

		# Table Operations
		public function table_exists($tablename){ try { $x = $this->query("SELECT 1 FROM '".$tablename."' LIMIT 1;"); } catch(Exception $e) { return false; } if($x) {$x = true;} else {$x = false;}return $x; } 
		public function table_delete($tablename){return $this->query('DROP TABLE `'.$tablename.'`');}
		public function table_create($tablename){return $this->query('CREATE TABLE `'.$tablename.'`');}

		/*	____   ____      .__                        
			\   \ /   /____  |  |  __ __   ____   ______
			 \   Y   /\__  \ |  | |  |  \_/ __ \ /  ___/
			  \     /  / __ \|  |_|  |  /\  ___/ \___ \ 
			   \___/  (____  /____/____/  \___  >____  >
						   \/                 \/     \/ 	*/
		public function increase($table, $nameidfield, $id, $increasefield, $increasevalue = 1){
			try { $this->qtc_raise(1); $newquery = "UPDATE ".$table." SET ".$increasefield." = ".$increasefield." + ".$increasevalue." WHERE ".$nameidfield." = '".$id."'";
			return $this->requestHandler(@mysqli_query($this->mysqlcon, $newquery), $table." ".$nameidfield." ".$id." ".$increasefield." [increase]");
			} catch (Exception $e){ return $this->requestHandler("exception", $table." ".$nameidfield." ".$id." ".$increasefield." [increase#exception] ", $e); }}
				
		public function decrease($table, $nameidfield, $id, $decreasefield, $decreasevalue = 1){
			try{ $this->qtc_raise(1); $newquery = "UPDATE ".$table." SET ".$decreasefield." = ".$decreasefield." + ".$decreasevalue." WHERE ".$nameidfield." = '".$id."'";
			return $this->requestHandler(@mysqli_query($this->mysqlcon, $newquery), $table." ".$nameidfield." ".$id." ".$decreasefield." [decrease]");
			} catch (Exception $e){ return $this->requestHandler("exception", $table." ".$nameidfield." ".$id." ".$decreasefield." [decrease#exception] ", $e); }}		
	
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
		
		/*				  .__   __  .__                                     
			  _____  __ __|  |_/  |_|__|   ________ __   ___________ ___.__.
			 /     \|  |  \  |\   __\  |  / ____/  |  \_/ __ \_  __ <   |  |
			|  Y Y  \  |  /  |_|  | |  | < <_|  |  |  /\  ___/|  | \/\___  |
			|__|_|  /____/|____/__| |__|  \__   |____/  \___  >__|   / ____|
				  \/                         |__|           \/       \/   */
		public function multi_query($query) { 
			try { $this->qtc_raise(1); return $this->requestHandler($this->mysqlcon->multi_query($query), $query." [multi_query]"); 
			} catch (Exception $e){ return $this->requestHandler("exception", $query." [multi_query#exception] ", $e); }
		}
		public function multi_query_file($file) { 
			if(file_exists($file)) {
				try { $this->qtc_raise(1); $sql = file_get_contents($file);
				return $this->requestHandler($this->mysqlcon->multi_query($sql), "File: ".$file." [multi_query_file]"); 
				} catch (Exception $e){ return $this->requestHandler("exception", "File: ".$file." [multi_query_file#exception] ", $e); }
			} return false;
		}
			
		/*   __________                __                 
			\______   \_____    ____ |  | ____ ________  
			 |    |  _/\__  \ _/ ___\|  |/ /  |  \____ \ 
			 |    |   \ / __ \\  \___|    <|  |  /  |_> >
			 |______  /(____  /\___  >__|_ \____/|   __/ 
					\/      \/     \/     \/     |__|   	*/
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

		/*	___________                           
			\_   _____/_____________  ___________ 
			 |    __)_\_  __ \_  __ \/  _ \_  __ \
			 |        \|  | \/|  | \(  <_> )  | \/
			/_______  /|__|   |__|   \____/|__|   
					\/                                */
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
		public function transaction($autocommit = false) {try {$this->qtc_raise(1); if($this->mysqlcon && !$this->transaction) { $this->mysqlcon->autocommit($autocommit);$this->transaction = true; return $this->requestHandler(@mysqli_begin_transaction($this->mysqlcon), " [transaction]");} return false; } catch (Exception $e){ return $this->requestHandler("exception", " [transaction#exception] ", $e); }}
		/********************** Rollback A Transaction if is Running ****/
		public function rollback() {try {$this->qtc_raise(1); if($this->mysqlcon && $this->transaction) { $this->transaction = false; return $this->requestHandler(@mysqli_rollback($this->mysqlcon), " [rollback]");}return false; } catch (Exception $e){ return $this->requestHandler("exception", " [rollback#exception] ", $e); }}
		/********************** Get Transaction Status ****/
		public function transactionStatus() {return $this->transaction;}
		/********************** Commit a Transaction ****/
		public function commit() {try { $this->qtc_raise(1); if($this->mysqlcon && $this->transaction) {  $this->transaction = false; return $this->requestHandler(@mysqli_commit($this->mysqlcon), " [commit]");}return false; } catch (Exception $e){ return $this->requestHandler("exception", " [commit#exception] ", $e); }}
	}
?>