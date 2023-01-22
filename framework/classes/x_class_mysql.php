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
								  `url` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Related URL',
								  `errtext` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Error Text',
								  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
								  `section` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Related Section',
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB AUTO_INCREMENT=3905 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;");
		}
		
		/*	__   ____ _ _ __ ___ 
			\ \ / / _` | '__/ __|
			 \ V / (_| | |  \__ \
			  \_/ \__,_|_|  |___/*/			 
			public  $mysqlcon			  = false;
			private $transaction 		  = false;
			public  $lasterror			  = false;
			public  $insert_id			  = false;
			private $logging			  = false;
			private $stoponexception	  = false; public function stoponexception($bool = false) { $this->stoponexception  = $bool; }
			private $stoponerror	  	  = false; public function stoponerror($bool = false) { $this->stoponerror  = $bool; }
			private $logging_table		  = "";
			private $logging_section	  = "";
				public function  loggingSetup($bool, $table, $section = "") {
					$this->logging = $bool; $this->logging_table = $table; $this->logging_section = $section;
					$val = false; try {
						$val = mysqli_query($this->mysqlcon, 'SELECT 1 FROM `'.$this->logging_table.'`');
					} catch (Exception $e){ 
						 $this->create_table();
					} if($val === FALSE) { $this->create_table();}			  	
				}
				private function logError($string) { if(is_object($this->mysqlcon) AND $this->logging) { $inarray["section"] = $this->logging_section;$inarray["url"] = $this->escape(@$_SERVER["REQUEST_URI"]); $inarray["errtext"] = $this->escape(@$string); $this->mysqlcon->query("INSERT INTO ".$this->logging_table."(url, errtext, section) VALUES(\"".$inarray["url"]."\", \"".$inarray["errtext"]."\", \"".$inarray["section"]."\");");   } }

		/*									 _   _             
											| | (_)            
			  ___ ___  _ __  _ __   ___  ___| |_ _  ___  _ __  
			 / __/ _ \| '_ \| '_ \ / _ \/ __| __| |/ _ \| '_ \  
			| (_| (_) | | | | | | |  __/ (__| |_| | (_) | | | |   
			 \___\___/|_| |_|_| |_|\___|\___|\__|_|\___/|_| |_|*/ 
		/********************** Construct Connection ****/	 
		function __construct($hostname, $username, $password, $database, $ovrcon = false) { if(!$ovrcon) {
			try { $this->mysqlcon = @mysqli_connect($hostname, $username, $password, $database); 
				   if(@mysqli_connect_errno()) { $this->lasterror  =  @mysqli_connect_error(); } else { $this->status(); }
			} catch (Exception $e){ $this->status(); }
		} else { $this->mysqlcon = $ovrcon; $this->status(); } }
		/********************** Log Connection Error in Var ****/	
		private function logLastError($errorBool, $lq = "") {
			if($errorBool == "exception") {
				$this->lasterror = $lq;
				$this->logError($this->lasterror.$lq);
				if($this->stoponexception) { exit(); }
				return false;
			} elseif(!@$errorBool) {
				try {
					$this->lasterror = @mysqli_error($this->mysqlcon);
					$this->logError($this->lasterror." - At Execution Of - ".$lq);
				} catch (Exception $e){ $this->lasterror = $e->getMessage(); $this->logError($this->lasterror." - Exception At Execution Of - ".$lq); }
				if($this->stoponerror) { exit(); }
			} else {
				$this->lasterror = false;
				if(strpos($lq, "INSERT INTO") > 0) { $this->insert_id = @$this->mysqlcon->insert_id; }
			}
			return $errorBool;
		}
		/********************** Get Ping MySQL Status ****/	
		public function ping() 			{ try { if(is_object($this->mysqlcon)) { return $this->logLastError(@mysqli_ping($this->mysqlcon), " [Ping]"); } else { $this->lasterror = "MySQLi Object is invalid!"; return false; } } catch (Exception $e){ return $this->logLastError("exception", $e->getMessage()." [Ping]"); }  }			
		/********************** Get Connection Status ****/	
		public function status() 		{ if(is_object($this->mysqlcon)) { $this->lasterror = false; return true; } else { $this->lasterror = "MySQLi Object is invalid!"; return false; } }
		/********************** Mysql Filter a Variable ****/	
		public function escape($val) 	{if($this->mysqlcon) {return @mysqli_real_escape_string($this->mysqlcon, $val);} else { return false; } }	
		/********************** Destroy Connection ****/	
		function __destruct() 			{if($this->mysqlcon) {/*@mysqli_close($this->mysqlcon);*/}}			
		/**********************  Some Operational Functions Generic ****/
		public function get_row($table, $id, $row = "id") { return $this->select("SELECT * FROM ".$table." WHERE ".$row." = \"".$id."\"", false); }
		public function exist_row($table, $id, $row = "id") { $tmp =  $this->select("SELECT * FROM ".$table." WHERE ".$row." = \"".$id."\"", false); if(is_array($tmp)) {return true;} else {return false;} }
		public function get_rows($table, $id, $row = "id") { return $this->select("SELECT * FROM ".$table." WHERE ".$row." = \"".$id."\"", true); }
		public function del_row($table, $id, $row = "id") { return $this->query("DELETE FROM ".$table." WHERE ".$row." = \"".$id."\""); }
		
		/*			  _           _   
					 | |         | |  
			 ___  ___| | ___  ___| |_ 
			/ __|/ _ \ |/ _ \/ __| __|
			\__ \  __/ |  __/ (__| |_ 
			|___/\___|_|\___|\___|\__|*/
		/********************** Select Statement for Multi Purpose ****/	 
		/********************** Multiple = True get Multi Array with different Rows | False get Single Array with Row ****/	 
		/********************** If Bindarray = false -> normal input query | If not deliver Multi Array with Array[X]["value"] = VALUE and Array[X]["type"] ****/	 
		/********************** TYPE //Binding parameters. Types: s = string, i = integer, d = double,  b = blob] ****/	 
		public function select($query, $multiple = false, $bindarray = false){ try {
			if(is_array($bindarray)) {
				if ($this->logLastError($stmt = @$this->mysqlcon->prepare($query), $query." [Select Bind Prepare]")) { 
					$before_prepare	=	"";
					$params	=	array(); 
					foreach ($bindarray as $key => $value) {
						$before_prepare .= $value["type"];
						array_push($params, $value["value"]);};
					array_unshift($params, $before_prepare);
					$tmp = array();
					foreach($params as $key => $value) {$tmp[$key] = &$params[$key];}
					@call_user_func_array(array($stmt, 'bind_param'), $tmp);
					//if($this->logLastError(@$stmt->execute(), $query."Select Bind Execute")){
					if(@$stmt->execute()){
						//if($newres = $this->logLastError(@$stmt->get_result(), $query." [Select Bind Get_Result]")){
						if($newres = @$stmt->get_result()){
							if($multiple) {
								$row = array();
								//while($rowx = $newres->fetch_array(MYSQLI_ASSOC)) { array_push($row, $rowx); }
								return $this->logLastError($newres->fetch_all(MYSQLI_ASSOC), $query." [Select Bind Fetch All]");
							} else {return $this->logLastError($newres->fetch_array(MYSQLI_ASSOC), $query." [Select Bind Fetch All]");}
				} else { return false;}} else {return false;}} else {return false;}
			} else {
				if ($sql_res = $this->logLastError(@mysqli_query($this->mysqlcon, $query), $query." [Select Query]")) { if (mysqli_num_rows($sql_res) > 0) {
					if(!$multiple) {return mysqli_fetch_array($sql_res, MYSQLI_ASSOC); }
					$count = mysqli_num_rows($sql_res);$row = array();for ($i=0; $i<$count; $i++){
					$tmpnow = mysqli_fetch_array($sql_res, MYSQLI_ASSOC); $row[$i] = $tmpnow;}return $row;				
				} else {return false;}} else {return false;}
			} } catch (Exception $e){ return $this->logLastError("exception", $e->getMessage()." - Query - ".$query." [Select Main]"); }}

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
				if(is_array($bindarray)) {
					if(!is_array($array)) {return false;}
					$build_first	=	"";$build_second	=	"";$firstrun = true;
					foreach( $array as $key => $value ){if(!$firstrun) {$build_first .= ", ";}
					if(!$firstrun) {$build_second .= ", ";}$build_first .= $key;
					if($value == "?") {$build_second .= $value;} else {$build_second .= "'".$value."'";}$firstrun = false;}
					$newquery = 'INSERT INTO '.$table.'('.$build_first.') VALUES('.$build_second.');';
					if ($this->logLastError($stmt = @$this->mysqlcon->prepare($newquery), $newquery." [Insert Bind Prepare]")) { 
						$before_prepare	=	"";
						$params	=	array(); 
						foreach ($bindarray as $key => $value) {
							$before_prepare .= $value["type"];
							array_push($params, $value["value"]);};
						array_unshift($params, $before_prepare);
						$tmp = array();
						foreach($params as $key => $value) {$tmp[$key] = &$params[$key];}
						@call_user_func_array(array($stmt, 'bind_param'), $tmp);
						return $this->logLastError(@$stmt->execute(), $newquery." [Insert Bind Execute]"); } else {return false;}
				} else {	
					if(!is_array($array)) {return false;}
					$build_first	=	"";$build_second	=	"";$firstrun = true;
					foreach( $array as $key => $value ){if(!$firstrun) {$build_first .= ", ";}
					if(!$firstrun) {$build_second .= ", ";}$build_first .= $key;
					$build_second .= "'".$value."'";
					$firstrun = false;}
					$nnnnquery	=	'INSERT INTO '.$table.'('.$build_first.') VALUES('.$this->escape($build_second).');';
					return $this->logLastError(@mysqli_query($this->mysqlcon, $nnnnquery), $nnnnquery." [Insert Query]");					
				}
			} catch (Exception $e){ return $this->logLastError("exception", $e->getMessage()." [Insert Main]"); }}
				
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
			try { if(is_array($bindarray)) {
				if ($this->logLastError($stmt = @$this->mysqlcon->prepare($query), $query." [Query Bind Prepare]")) { 
					$before_prepare	=	"";
					$params	=	array(); 
					foreach ($bindarray as $key => $value) {
						$before_prepare .= $value["type"];
						array_push($params, $value["value"]);};
					array_unshift($params, $before_prepare);
					$tmp = array();
					foreach($params as $key => $value) {$tmp[$key] = &$params[$key];}
					@call_user_func_array(array($stmt, 'bind_param'), $tmp);
					return $this->logLastError(@$stmt->execute(), $query." [Insert Bind Execute]");
					} else {return false;}
			} else { return $this->logLastError(@mysqli_query($this->mysqlcon, $query), $query." [Insert Query]");}
			} catch (Exception $e){ return $this->logLastError("exception", $e->getMessage()." - Query - ".$query." [Query Main]"); }}
				
		/*			   _          
					  (_)         
			 _ __ ___  _ ___  ___ 
			| '_ ` _ \| / __|/ __|
			| | | | | | \__ \ (__ 
			|_| |_| |_|_|___/\___| */
		public function increase($table, $nameidfield, $id, $increasefield, $increasevalue = 1){
			try { $newquery = "UPDATE ".$table." SET ".$increasefield." = ".$increasefield." + ".$increasevalue." WHERE ".$nameidfield." = '".$id."'";
			return $this->logLastError(@mysqli_query($this->mysqlcon, $newquery), $newquery." [Increase Main]");
			} catch (Exception $e){ return $this->logLastError("exception", $e->getMessage()." [Increase Main]"); }}
		
		public function auto_increment($table, $value){
			try { $newquery = "ALTER TABLE ".$table." AUTO_INCREMENT = ".$value."";
			return $this->logLastError(@mysqli_query($this->mysqlcon, $newquery), $newquery." [Auto_Increment Main]");
			} catch (Exception $e){ return $this->logLastError("exception", $e->getMessage()." [Auto_Increment Main]"); }}
		
		public function decrease($table, $nameidfield, $id, $decreasefield, $decreasevalue = 1){
			try{ $newquery = "UPDATE ".$table." SET ".$decreasefield." = ".$decreasefield." + ".$decreasevalue." WHERE ".$nameidfield." = '".$id."'";
			return $this->logLastError(@mysqli_query($this->mysqlcon, $newquery), $newquery." [Decrease Main]");
			} catch (Exception $e){ return $this->logLastError("exception", $e->getMessage()." [Decrease Main]"); }}									

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
		public function transaction() {try {if($this->mysqlcon && !$this->transaction) { $this->transaction = true; return $this->logLastError(@mysqli_begin_transaction($this->mysqlcon), " [Transaction Start]");} return false; } catch (Exception $e){ return $this->logLastError("exception", $e->getMessage()." [Transaction Start Main]"); }}
		/********************** Rollback A Transaction if is Running ****/
		public function rollback() {try {if($this->mysqlcon && $this->transaction) { $this->transaction = false; return $this->logLastError(@mysqli_rollback($this->mysqlcon), " [Transaction Rollback]");}return false; } catch (Exception $e){ return $this->logLastError("exception", $e->getMessage()." [Transaction Rollback Main]"); }}
		/********************** Get Transaction Status ****/
		public function transactionStatus() {return $this->transaction;}
		/********************** Commit a Transaction ****/
		public function commit() {try { if($this->mysqlcon && $this->transaction) {  $this->transaction = false; return $this->logLastError(@mysqli_commit($this->mysqlcon), " [Transaction Commit]");}return false; } catch (Exception $e){ return $this->logLastError("exception", $e->getMessage()." [Transaction Commit Main]"); }}
	}
?>