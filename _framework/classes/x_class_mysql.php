<?php
	/* 
		 ____  __  __  ___  ____  ____  ___  _   _ 
		(  _ \(  )(  )/ __)( ___)(_  _)/ __)( )_( )
		 ) _ < )(__)(( (_-. )__)  _)(_ \__ \ ) _ ( 
		(____/(______)\___/(__)  (____)(___/(_) (_) www.bugfish.eu
			  ___                                         _     
			 / __)                                       | |    
			| |__ ____ ____ ____   ____ _ _ _  ___   ____| |  _ 
			|  __) ___) _  |    \ / _  ) | | |/ _ \ / ___) | / )
			| | | |  ( ( | | | | ( (/ /| | | | |_| | |   | |< ( 
			|_| |_|   \_||_|_|_|_|\____)\____|\___/|_|   |_| \_)
		Copyright (C) 2024 Jan Maurice Dahlmanns [Bugfish]

		This program is free software: you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation, either version 3 of the License, or
		(at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program.  If not, see <https://www.gnu.org/licenses/>.
	*/
	class x_class_mysql {
		/*	___________     ___.   .__                 
			\__    ___/____ \_ |__ |  |   ____   ______
			  |    |  \__  \ | __ \|  | _/ __ \ /  ___/
			  |    |   / __ \| \_\ \  |_\  ___/ \___ \ 
			  |____|  (____  /___  /____/\___  >____  >
						   \/    \/          \/     \/		Create Table for Logging*/
		private function create_table() {
			return $this->query("CREATE TABLE IF NOT EXISTS `".$this->logging_table."` (
								  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Indentificator',
								  `url` varchar(256) DEFAULT NULL COMMENT 'Related URL',
								  `init` text NULL COMMENT 'Init Data if There is some',
								  `exception` text NULL COMMENT 'Error Exception Text',
								  `sqlerror` text NULL COMMENT 'Error MySQL Text',
								  `output` text NULL COMMENT 'Error MySQL Output',
								  `success` int(1) NULL COMMENT '1 - Query OK | 2 - Query Error',
								  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
								  `section` varchar(128) DEFAULT NULL COMMENT 'Related Section',
								  PRIMARY KEY (`id`));");}
		/*	  ____  ____   ____   _______/  |________ __ __   _____/  |_ 
			_/ ___\/  _ \ /    \ /  ___/\   __\_  __ \  |  \_/ ___\   __\
			\  \__(  <_> )   |  \\___ \  |  |  |  | \/  |  /\  \___|  |  
			 \___  >____/|___|  /____  > |__|  |__|  |____/  \___  >__|  
				 \/           \/     \/                          \/       Constructor and Status Functions */
		/********************** Public but Readonly Parameters ****/	 
			public $mysqlcon    = false; // MySQLI Object
			public $lasterror	= false; // Error out of Last Request		
			public $fullerror   = false; // Error Full out of Last Request
			public $insert_id	= false; // Last Insert ID			
			public $transaction = false; // Is a Transaction Running?
			public $auth_user	= false; 
			public $auth_pass	= false; 
			public $auth_host	= false; 
			public $auth_db = false;
			public $auth_port = 3306;
		/********************** Construct Connection ****/	
		function __construct($hostname, $username, $password, $database, $port = 3306) {
			$this->auth_user = $username;
			$this->auth_pass = $password;
			$this->auth_host = $hostname;
			$this->auth_db = $database;
			$this->auth_port = $port;
			try { $this->mysqlcon = @mysqli_connect($hostname, $username, $password, $database, $port); 
				   if(@mysqli_connect_errno()) { $this->lasterror  =  @mysqli_connect_error(); } else { $this->lasterror = false; }
			} catch (Exception $e){ $this->lasterror = $e; } }			
		/**************** Internal Function to get Class Copy */
		public function construct() { return new x_class_mysql($this->auth_host, $this->auth_user, $this->auth_pass, $this->auth_db, $this->auth_port); }			
		/**************** Internal Function to get Class Copy */
		public function construct_copy() { return $this; }			
		/********************** Get Connection Status (ping alias) ****/	
		public function status() { return $this->ping(); }
		/********************** Get Connection ****/	
		public function con() { return $this->mysqlcon; }			
		/********************** Last Error ****/	
		public function lastError() { return $this->lasterror; }			
		public function last_error() { return $this->lasterror; }			
		/********************** Get Ping MySQL Status ****/	
		public function ping() { try { return $this->handler(mysqli_ping($this->mysqlcon), false, "ping", false); 
			} catch (Exception $e){ return $this->handler(false, $e, "ping", false); }  }	
		/********************** Full Error ****/	
		public function fullError() { return $this->fullerror; }			
		public function full_error() { return $this->fullerror; }
		/********************** Full Error ****/	
		public function last_insert() { return $this->insert_id; }			
		public function lastinsert() { return $this->insert_id; }
		public function insert_id() { return $this->insert_id; }			
		public function insertid() { return $this->insert_id; }
		/********************** Inject ****/
		public function inject($mysqli) { if(is_object($mysqli)) { $this->mysqlcon = $mysqli; return true; } return false; }
		/*	___.                        .__                          __    
			\_ |__   ____   ____   ____ |  |__   _____ _____ _______|  | __
			 | __ \_/ __ \ /    \_/ ___\|  |  \ /     \\__  \\_  __ \  |/ /
			 | \_\ \  ___/|   |  \  \___|   Y  \  Y Y  \/ __ \|  | \/    < 
			 |___  /\___  >___|  /\___  >___|  /__|_|  (____  /__|  |__|_ \
				 \/     \/     \/     \/     \/      \/     \/           \/ */		
		private $bm	  	  = false;	private $bmcookie  = false; 
		public function benchmark_get() { 
			if( $this->bm) { return $_SESSION[$this->bmcookie."x_class_mysql"]; } 
			return false;}		
		private function benchmark_raise($raise = 1) {if( $this->bm) {  
			$_SESSION[$this->bmcookie."x_class_mysql"] = @$_SESSION[$this->bmcookie."x_class_mysql"] + 1; 
		} } 
		public function benchmark_config($bool = false, $preecookie = "") {
			if (session_status() !== PHP_SESSION_ACTIVE) {@session_start();}
			$this->bmcookie = $preecookie;
			$this->bm  	= $bool;
			$_SESSION[$this->bmcookie."x_class_mysql"] = 0; }
		/*	.____                        .__                
			|    |    ____   ____   ____ |__| ____    ____  
			|    |   /  _ \ / ___\ / ___\|  |/    \  / ___\ 
			|    |__(  <_> ) /_/  > /_/  >  |   |  \/ /_/  >
			|_______ \____/\___  /\___  /|__|___|  /\___  / 
					\/    /_____//_____/         \//_____/ 	Setup	*/						  
			private $logfile_messages = false; 
			public function logfile_messages($bool = false) { $this->logfile_messages = $bool; }				
			public function log_disable() { $this->logging_active = false; }
			public function log_status() { return $this->logging_active; } 
			public function log_enable() { if($this->logging_table) { $this->logging_active = true; } }
			private function log_con() { return new x_class_mysql($this->auth_host, $this->auth_user, $this->auth_pass, $this->auth_db, $this->auth_port); }	
				private $logging_active = false;
				private $logging_table = false;
				private $logging_section = "";
				private $logging_all = false;
			private $stop_on_error	  = false; public function stop_on_error($bool = false) { $this->stop_on_error  = $bool; } // Stop if Error?
			private $display_on_error = false; public function display_on_error($bool = false) { $this->display_on_error  = $bool; } // Display 
			public function log_config($table = "mysqllogging", $section = "", $logall = false) {
				$this->logging_all = $logall; 
				$this->logging_table = $table;
				$this->logging_section = $section;
				if($this->logging_table) { $this->logging_active = true; }				
				if(!$this->table_exists($this->logging_table)) { $this->create_table(); $this->free_all(); } }
			private function log($output, $sqlerror, $exception, $init, $boolsuccess, $nolog = false) { 
				if($this->logging_active AND !$nolog) {
					if(!$this->logging_all AND $boolsuccess != 0) { return false; }
					if(!$this->logging_all AND (!@$exception OR (trim($sqlerror) == "" OR !$sqlerror))) { return false; }
					if( $this->logfile_messages) {
						error_log("X_CLASS_MYSQL[ERR]: [Initial Query] ".@serialize(@$init)." [Exception Result] ".@serialize(@$exception)." [SQL Error Result] ".@serialize(@$sqlerror)." [Additional Output] ".@serialize(@$output)." [URL] ".@trim(@$_SERVER["REQUEST_URI"])." ");}
				$mysql = $this->log_con();	 
				$inarray["section"] = $this->logging_section;
				$inarray["url"] = @trim(@$_SERVER["REQUEST_URI"]);
				$inarray["sqlerror"] = @$sqlerror;
				$inarray["exception"] = @serialize(@$exception);
				if($exception) {$inarray["exception"] = "is_exception".$inarray["exception"];}
				$inarray["output"] = @serialize(@$output);
				$inarray["init"] = @$init;
				try {   $b[0]["type"] = "s";
						$b[0]["value"] = $inarray["url"];
						$b[1]["type"] = "s";
						$b[1]["value"] = $inarray["sqlerror"];
						$b[2]["type"] = "s";
						$b[2]["value"] = $inarray["exception"];
						$b[3]["type"] = "s";
						$b[3]["value"] = $inarray["init"];
						$b[4]["type"] = "s";
						$b[4]["value"] = $inarray["output"];	
						return $mysql->query("INSERT INTO `".$this->logging_table."`(url, sqlerror, exception, init, output, section, success) VALUES(?, ?,?,?,?, \"".$inarray["section"]."\", ".$boolsuccess.");", $b);
				} catch (Exception $e){ return false; } } return false; }
		/*	  ___ ___                    .___.__                
			 /   |   \_____    ____    __| _/|  |   ___________ 
			/    ~    \__  \  /    \  / __ | |  | _/ __ \_  __ \
			\    Y    // __ \|   |  \/ /_/ | |  |_\  ___/|  | \/
			 \___|_  /(____  /___|  /\____ | |____/\___  >__|   
				   \/      \/     \/      \/           \/        */	
		private function handler($excecution, $exception, $init, $nolog = false) {			
			$this->benchmark_raise();
			$this->fullerror = array();				
			$this->lasterror = false;		
			$this->fullerror["mysql"] = @mysqli_error($this->mysqlcon);
			$this->fullerror["output"] = @serialize(@$excecution);
			$this->fullerror["init"] = $init;
			if(is_object($exception)) { $this->fullerror["exception"] = @serialize(@$e); }
				else { $this->fullerror["exception"] = false; }
			if(is_object($exception)) { $this->lasterror = 1;	} 
				else {  if(!$excecution) {$curer = 1;} else {$curer = 0;} $this->lasterror = $curer;  }
			if(!is_object($exception)) { @$this->insert_id = $this->mysqlcon->insert_id; }
			if(is_object($exception)) {	
				$this->log($excecution, $this->fullerror["mysql"], $exception, $init, 0, $nolog);
			} else { if($this->lasterror) {$curer = 0;} else {$curer = 1;}   
				$this->log($excecution, $this->fullerror["mysql"], false, $init, $curer, $nolog); }
			if($this->display_on_error AND $this->lasterror) { echo print_r($this->fullerror); }
			if($this->stop_on_error AND $this->lasterror) { exit(); }
			if(is_object($exception)) {	
				return false;
			} return $excecution; }
		/*	___________                           
			\_   _____/_____________  ___________ 
			 |    __)_\_  __ \_  __ \/  _ \_  __ \
			 |        \|  | \/|  | \(  <_> )  | \/
			/_______  /|__|   |__|   \____/|__|   
					\/                                */			
		public function displayError($exit = true, $response_code = 503) {			
			@http_response_code($response_code);
			echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Database Error</title><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><style>* { margin: 0; padding: 0; box-sizing: border-box; }body {font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;background-color: #f9f9f9;color: #121212;display: flex;align-items: center;justify-content: center;height: 100vh;flex-direction: column;text-align: center;} .artwork { height: auto; max-height: 50vh; max-width: 80vw; margin-bottom: 4rem; } h1 { font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; color: #242424; } p {line-height: 1.6; font-size: 1.4rem; } @media only screen and (max-width: 500px) { html { font-size: 75%; } } @media (prefers-color-scheme: dark) {  body{ background-color: #121212; color: #cddcdd; }   h1 { color: #f9f9f9;} }a {	color: #ff5707; text-decoration: none;} </style></head><body cz-shortcut-listen="true"><svg class="artwork" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1120 700" width="1120" height="700"><circle cx="292.61" cy="213" r="213" fill="#f2f2f2"></circle><path fill="#242424" d="M0 51.14c0 77.5 48.62 140.21 108.7 140.21"></path><path fill="#ff5707" d="M108.7 191.35c0-78.37 54.26-141.78 121.3-141.78M39.38 58.17c0 73.61 31 133.18 69.32 133.18"></path><path fill="#242424" d="M108.7 191.35c0-100.14 62.71-181.17 140.2-181.17"></path><path fill="#a8a8a8" d="M85.83 192.34s15.42-.48 20.06-3.78 23.72-7.26 24.87-1.96 23.17 26.4 5.76 26.53-40.44-2.7-45.07-5.53-5.62-15.26-5.62-15.26z"></path><path d="M136.83 211.28c-17.4.15-40.44-2.7-45.07-5.53-3.53-2.15-4.94-9.87-5.41-13.43l-.52.02s.98 12.43 5.62 15.26 27.67 5.67 45.07 5.53c5.03-.04 6.76-1.83 6.67-4.47-.7 1.6-2.62 2.6-6.36 2.62z" opacity=".2"></path><ellipse cx="198.61" cy="424.5" fill="#181818" rx="187" ry="25.44"></ellipse><ellipse cx="198.61" cy="424.5" opacity=".1" rx="157" ry="21.36"></ellipse><ellipse cx="836.61" cy="660.5" fill="#181818" rx="283" ry="38.5"></ellipse><ellipse cx="310.61" cy="645.5" fill="#181818" rx="170" ry="23.13"></ellipse><path fill="none" stroke="#242424" stroke-miterlimit="10" stroke-width="2" d="M462.6 626c90 23 263-30 282-90M309.6 259s130-36 138 80-107 149-17 172M184.01 537.28s39.07-10.82 41.48 24.05-32.16 44.78-5.11 51.7"></path><path fill="#242424" d="M778.7 563.24l-7.87 50.3s-38.78 20.6-11.52 21.2 155.74 0 155.74 0 24.84 0-14.55-21.81l-7.87-52.72z"></path><path d="M753.83 634.2c6.2-5.51 17-11.25 17-11.25l7.87-50.3 113.93.1 7.87 49.59c9.19 5.09 14.88 8.99 18.2 11.98 5.07-1.16 10.6-5.45-18.2-21.4l-7.87-52.71-113.93 3.03-7.87 50.3s-32.6 17.31-17 20.66z" opacity=".1"></path><rect width="513.25" height="357.52" x="578.43" y="212.69" fill="#242424" rx="18.05"></rect><path fill="#181818" d="M595.7 231.78h478.71v267.84H595.7z"></path><circle cx="835.06" cy="223.29" r="3.03" fill="#f2f2f2"></circle><path fill="#242424" d="M1091.69 520.82v31.34a18.04 18.04 0 01-18.05 18.05H596.48a18.04 18.04 0 01-18.05-18.05v-31.34zM968.98 667.47v6.06H642.97v-4.85l.45-1.21 8.03-21.82h310.86l6.67 21.82zM1094.44 661.53c-.6 2.54-2.84 5.22-7.9 7.75-18.18 9.1-55.15-2.42-55.15-2.42s-28.48-4.85-28.48-17.57a22.72 22.72 0 012.5-1.49c7.64-4.04 32.98-14.02 77.92.42a18.74 18.74 0 018.54 5.6c1.82 2.13 3.25 4.84 2.57 7.71z"></path><path d="M1094.44 661.53c-22.25 8.53-42.09 9.17-62.44-4.97-10.27-7.13-19.6-8.9-26.6-8.76 7.65-4.04 33-14.02 77.93.42a18.74 18.74 0 018.54 5.6c1.82 2.13 3.25 4.84 2.57 7.71z" opacity=".1"></path><ellipse cx="1066.54" cy="654.13" fill="#f2f2f2" rx="7.88" ry="2.42"></ellipse><circle cx="835.06" cy="545.67" r="11.51" fill="#f2f2f2"></circle><path d="M968.98 667.47v6.06H642.97v-4.85l.45-1.21h325.56z" opacity=".1"></path><path fill="#242424" d="M108.61 159h208v242h-208z"></path><path fill="#181818" d="M87.61 135h250v86h-250zM87.61 237h250v86h-250zM87.61 339h250v86h-250z"></path><path fill="#ff5707" d="M271.61 150h16v16h-16z" opacity=".4"></path><path fill="#ff5707" d="M294.61 150h16v16h-16z" opacity=".8"></path><path fill="#ff5707" d="M317.61 150h16v16h-16z"></path><path fill="#ff5707" d="M271.61 251h16v16h-16z" opacity=".4"></path><path fill="#ff5707" d="M294.61 251h16v16h-16z" opacity=".8"></path><path fill="#ff5707" d="M317.61 251h16v16h-16z"></path><path fill="#ff5707" d="M271.61 352h16v16h-16z" opacity=".4"></path><path fill="#ff5707" d="M294.61 352h16v16h-16z" opacity=".8"></path><path fill="#ff5707" d="M317.61 352h16v16h-16z"></path><circle cx="316.61" cy="538" r="79" fill="#242424"></circle><path fill="#242424" d="M280.61 600h24v43h-24zM328.61 600h24v43h-24z"></path><ellipse cx="300.61" cy="643.5" fill="#242424" rx="20" ry="7.5"></ellipse><ellipse cx="348.61" cy="642.5" fill="#242424" rx="20" ry="7.5"></ellipse><circle cx="318.61" cy="518" r="27" fill="#fff"></circle><circle cx="318.61" cy="518" r="9" fill="#181818"></circle><path fill="#ff5707" d="M239.98 464.53c-6.38-28.57 14-57.43 45.54-64.47s62.27 10.4 68.64 38.98-14.51 39.1-46.05 46.14-61.75 7.92-68.13-20.65z"></path><ellipse cx="417.22" cy="611.34" fill="#242424" rx="39.5" ry="12.4" transform="rotate(-23.17 156.4 637.65)"></ellipse><ellipse cx="269.22" cy="664.34" fill="#242424" rx="39.5" ry="12.4" transform="rotate(-23.17 8.4 690.65)"></ellipse><path fill="#fff" d="M362.6 561c0 7.73-19.9 23-42 23s-43-14.27-43-22 20.92-6 43-6 42-2.73 42 5z"></path></svg><h1 id="title">Database Error</h1><p>Error while connecting to database services!</p><p><small>Error by: <b>x_class_mysql</b> [<a href="https://bugfishtm.github.io/" rel="noopener" target="_blank">Bugfish-Framework</a>]</small></p></body></html>';  if($exit){exit();}}		
		/*	___________     ___.   .__                 
			\__    ___/____ \_ |__ |  |   ____   ______
			  |    |  \__  \ | __ \|  | _/ __ \ /  ___/
			  |    |   / __ \| \_\ \  |_\  ___/ \___ \ 
			  |____|  (____  /___  /____/\___  >____  >
						   \/    \/          \/     \/  */
		public function table_exists($tablename){$x = $this->log_status(); $this->log_disable();  $bind[0]["value"] = $tablename; $bind[0]["type"] = "s";
										$y =  $this->query("SELECT 1 FROM `".$tablename."` LIMIT 1;"); if($x) {$this->log_enable();} return $y;} 
		public function table_delete($tablename){ $bind[0]["value"] = $tablename; $bind[0]["type"] = "s"; 
										return $this->query('DROP TABLE `'.$tablename.'`'); }										
		public function table_create($tablename){ $bind[0]["value"] = $tablename; $bind[0]["type"] = "s";
										return $this->update('CREATE TABLE `".$tablename."`'); }										
		public function auto_increment($table, $value){ $bind[0]["value"] = $table; $bind[0]["type"] = "s"; 
														$bind[1]["value"] = $value; $bind[1]["type"] = "i";
										return $this->query('ALTER TABLE ?'. " AUTO_INCREMENT = ?"); }
		public function table_backup($table, $filepath = false, $withdata = true, $dropstate = false){
			$this->lasterror = false;
			$this->fullerror = array();
			$data = "";
			if($dropstate) { $data.= "DROP TABLE IF EXISTS `{$table}`;\n"; }
			$res = $this->query("SHOW CREATE TABLE `{$table}`");
			$row = mysqli_fetch_row($res);
			$data.= $row[1].";\n";
			$result = $this->query("SELECT * FROM `{$table}`");
			$num_rows = @mysqli_num_rows($result);    
			if($withdata) {
				if($num_rows>0){
				  $vals = Array(); $z=0;
				  for($i=0; $i<$num_rows; $i++){
					$items = mysqli_fetch_row($result);
					$vals[$z]="(";
					for($j=0; $j<count($items); $j++){
					  if (isset($items[$j])) { $vals[$z].= "'".$this->escape( $items[$j] )."'"; } else { $vals[$z].= "NULL"; }
					  if ($j<(count($items)-1)){ $vals[$z].= ","; }
					}$vals[$z].= ")"; $z++; }
				  $data.= "INSERT INTO `{$table}` VALUES ";      
				  $data .= "  ".implode(";\nINSERT INTO `{$table}` VALUES ", $vals).";\n";
				}}
			if($filepath) { $handle = fopen($filepath,'w+');fwrite($handle,$data);fclose($handle); } return $data;}				
		/*	________          __        ___.                                
			\______ \ _____ _/  |______ \_ |__ _____    ______ ____   ______
			 |    |  \\__  \\   __\__  \ | __ \\__  \  /  ___// __ \ /  ___/
			 |    `   \/ __ \|  |  / __ \| \_\ \/ __ \_\___ \\  ___/ \___ \ 
			/_______  (____  /__| (____  /___  (____  /____  >\___  >____  >
					\/     \/          \/    \/     \/     \/     \/     \/   */	
		public function database_delete($database){ $bind[0]["value"] = $database; $bind[0]["type"] = "s";
												return $this->query('DROP DATABASE ?');}
		public function database_create($database){ $bind[0]["value"] = $database; $bind[0]["type"] = "s";
												return $this->query('CREATE DATABASE ?');}
		public function database_select($database){ try {
				return $this->handler(mysqli_select_db($this->mysqlcon, $database), false, "database_select: ".$database, false); 
				} catch (Exception $e){ return $this->handler(false, $e, "database_select: ".$database, false); }}		
		/*	 _                                  _   _                 
			| |                                | | (_)                
			| |_ _ __ __ _ _ __  ___  __ _  ___| |_ _  ___  _ __  ___ 
			| __| '__/ _` | '_ \/ __|/ _` |/ __| __| |/ _ \| '_ \/ __|
			| |_| | | (_| | | | \__ \ (_| | (__| |_| | (_) | | | \__ \
			 \__|_|  \__,_|_| |_|___/\__,_|\___|\__|_|\___/|_| |_|___/*/
		/********************** Start A Transaction if none is Running ****/
		public function transaction($autocommit = false) {try { if(!$this->transaction) { $this->mysqlcon->autocommit($autocommit); $this->transaction = true; return $this->handler(mysqli_begin_transaction($this->mysqlcon), false, "transaction: ".$autocommit, false);} return false; } catch (Exception $e){ return $this->handler(false, $e, "transaction: ".$autocommit, false); }}
		/********************** Rollback A Transaction if is Running ****/
		public function rollback() {try {if($this->transaction) { $this->transaction = false; return $this->handler(mysqli_rollback($this->mysqlcon), false, "rollback", false);}return false; } catch (Exception $e){ return $this->handler(false, $e, "rollback", false); }}
		/********************** Get Transaction Status ****/
		public function transactionStatus() { return $this->transaction; }
		/********************** Commit a Transaction ****/
		public function commit() {try { if($this->transaction) {  $this->transaction = false; return $this->handler(mysqli_commit($this->mysqlcon), false, "commit", false); } return false; } catch (Exception $e){ return $this->handler(false, $e, "commit", false); }}		
		/*		________                              __  .__                      
				\_____  \ ______   ________________ _/  |_|__| ____   ____   ______
				 /   |   \\____ \_/ __ \_  __ \__  \\   __\  |/  _ \ /    \ /  ___/
				/    |    \  |_> >  ___/|  | \// __ \|  | |  (  <_> )   |  \\___ \ 
				\_______  /   __/ \___  >__|  (____  /__| |__|\____/|___|  /____  >
						\/|__|        \/           \/                    \/     \/    */
		/********************** Destroy Connection ****/	
		function __destruct() { /* Nothing */ }
		/********************** Mysql Filter a Variable ****/	
		public function escape($val) 	{ if(!is_object($val) AND !is_array($val)) { return @mysqli_real_escape_string($this->mysqlcon, $val); } else { $val = serialize($val); return @mysqli_real_escape_string($this->mysqlcon, $val);} }			
		/**************** Next Result */
		public function next_result() { try {  return mysqli_next_result($this->mysqlcon); } catch(Exception $e) { return $this->handler(false, $e, "next_result", false); } }
		/**************** Store Result */
		public function store_result() { try {  return mysqli_store_result($this->mysqlcon); } catch(Exception $e) { return $this->handler(false, $e, "store_result", false); }  }
		/**************** More Results? */
		public function more_results() { try {  return mysqli_more_results($this->mysqlcon); } catch(Exception $e) { return $this->handler(false, $e, "more_results", false); } }
		/**************** Store Result Array */
		public function fetch_array($result) { try { return mysqli_fetch_array($result); } catch(Exception $e) { return $this->handler(false, $e, "fetch_array", false); } }
		/**************** Store Result Object */
		public function fetch_object($result) { try { return mysqli_fetch_object($result); } catch(Exception $e) { return $this->handler(false, $e, "fetch_object", false); } }
		/**************** Free Result */
		public function free_result($result) { try { return mysqli_free_result($result); } catch(Exception $e) { return $this->handler(false, $e, "free_result", false); } }			
		/**************** Free Result */
		public function use_result() { try { return mysqli_use_result($this->mysqlcon); } catch(Exception $e) { return $this->handler(false, $e, "use_result", false); } }			
		/**************** Free All */
		public function free_all() { 
			$results = array();	
			try {$x = false;
				try { $x = mysqli_use_result($this->mysqlcon); } catch (Exception $e){  }
				if(is_object($x)) { $y = mysqli_fetch_object($x); array_push($results, $y); mysqli_free_result($x); }
				while ($this->more_results()) {
					if ($this->next_result()) {
						$x = $this->store_result($this->mysqlcon);
						if(is_object($x)) { $y = mysqli_fetch_object($x); array_push($results, $y); mysqli_free_result($x); }
					}}	
			} catch (Exception $e){ return $this->handler(false, $e, "free_all", false); }
			return $results;}				
		/*				  .__   __  .__                                     
			  _____  __ __|  |_/  |_|__|   ________ __   ___________ ___.__.
			 /     \|  |  \  |\   __\  |  / ____/  |  \_/ __ \_  __ <   |  |
			|  Y Y  \  |  /  |_|  | |  | < <_|  |  |  /\  ___/|  | \/\___  |
			|__|_|  /____/|____/__| |__|  \__   |____/  \___  >__|   / ____|
				  \/                         |__|           \/       \/        */			
		public function multi_query($query) { 
			try { return $this->handler($this->mysqlcon->multi_query($query), false, "multi_query: ".$query, false);
			} catch (Exception $e){ return $this->handler(false, $e, "multi_query: ".$query, false); }}
		public function multi_query_file($file) { 
			if(file_exists($file)) {
				try { $sql = file_get_contents($file);
					return $this->handler($this->mysqlcon->multi_query($sql), false, "multi_query_file: ".$file, false);
				} catch (Exception $e){ return $this->handler(false, $e, "multi_query_file: ".$file, false); }
			} return false;}				
		/*	____   ____      .__                        
			\   \ /   /____  |  |  __ __   ____   ______
			 \   Y   /\__  \ |  | |  |  \_/ __ \ /  ___/
			  \     /  / __ \|  |_|  |  /\  ___/ \___ \ 
			   \___/  (____  /____/____/  \___  >____  >
						   \/                 \/     \/ 	Decrease / Increase Values Dynamically and SQL Injection Safe! (shall be)*/				
		public function row_element_increase($table, $nameidfield, $id, $increasefield, $increasevalue = 1){
			if(!is_numeric($id) OR !is_numeric($increasevalue)) { return false; }
			return $this->update("UPDATE ".$table." SET ".$increasefield." = ".$increasefield." + ".$increasevalue." WHERE ".$nameidfield." = '".$id."'");}
		public function row_element_decrease($table, $nameidfield, $id, $decreasefield, $decreasevalue = 1){
			if(!is_numeric($id) OR !is_numeric($decreasevalue)) { return false; }
			return $this->update("UPDATE ".$table." SET ".$increasefield." = ".$decreasefield." + ".$decreasevalue." WHERE ".$nameidfield." = '".$id."'"); }
		public function row_get($table, $id, $row = "id") { 
			$bindar[0]["value"] = $id;
			$bindar[0]["type"]  = "s";
			return $this->select("SELECT * FROM `".$table."` WHERE ".$row." = ?", false, $bindar); }
		public function row_element_get($table, $id, $elementrow, $fallback = false, $row = "id") { 
			$bindar[0]["value"] = $id;
			$bindar[0]["type"]  = "s";
			$ar =  $this->select("SELECT * FROM `".$table."` WHERE ".$row." = ?", false, $bindar); 
			if(is_array($ar)) {
				if(isset($ar[$elementrow])) {
					return $ar[$elementrow];
				} return $fallback;
			} else { return $fallback; }	}
		public function row_element_change($table, $id, $element, $elementrow, $row = "id") { 
			$bindar[0]["value"] = $element;
			$bindar[0]["type"]  = "s";
			$bindar[1]["value"] = $id;
			$bindar[1]["type"]  = "s";
			return $this->update("UPDATE `".$table."` SET ".$elementrow." = ? WHERE ".$row." = ?", false, $bindar); }		
		public function row_exist($table, $id, $row = "id") {  
			$bindar[0]["value"] = $id;
			$bindar[0]["type"]  = "s";		
			$tmp =  $this->select("SELECT * FROM `".$table."` WHERE ".$row." = ?", false, $bindar); if(is_array($tmp)) {return true;} else {return false;}}
		public function rows_get($table, $id, $row = "id") { 
			$bindar[0]["value"] = $id;
			$bindar[0]["type"]  = "s";
			return $this->select("SELECT * FROM `".$table."` WHERE ".$row." = ?", true, $bindar); 		}
		public function row_del($table, $id, $row = "id") { 
			$bindar[0]["value"] = $id;
			$bindar[0]["type"]  = "s";		
			return $this->query("DELETE FROM `".$table."` WHERE ".$row." = ?", $bindar); }		
		/*			  _           _   
					 | |         | |  
			 ___  ___| | ___  ___| |_ 
			/ __|/ _ \ |/ _ \/ __| __|
			\__ \  __/ |  __/ (__| |_ 
			|___/\___|_|\___|\___|\__|  Select Statement for Multi Purpose */
		/********************** Multiple = True get Multi Array with different Rows | False get Single Array with Row ****/	 
		/********************** If Bindarray = false -> normal input query | If not deliver Multi Array with Array[X]["value"] = VALUE and Array[X]["type"] = (s/i)****/	 
		/********************** TYPE //Binding parameters. Types: s = string, i = integer, d = double,  b = blob] ****/	 				
		public function select($query, $multiple = false, $bindarray = false, $fetch_type = MYSQLI_ASSOC){
			if(is_array($bindarray)) {
				// Binded Input
				$handler = false;
				try { $handler =  $this->handler($this->mysqlcon->prepare($query), false, "select#prepare: ".$query, false); } catch (Exception $e) { return $this->handler(false, $e, "select#prepare: ".$query, false); }
				if($handler) {
					$before_prepare	=	"";
					$params	=	array(); 
					foreach ($bindarray as $key => $value) {
						if(!@$value["type"]) { $value["type"] = "s"; }
						$before_prepare .= $value["type"];
						array_push($params, $value["value"]);
					};		
					array_unshift($params, $before_prepare);
					$tmp = array();
					foreach($params as $key => $value) {$tmp[$key] = &$params[$key];}
					try { $this->handler(call_user_func_array(array($handler, 'bind_param'), $tmp), false, "select#bind: ".$query, false); } catch (Exception $e) { return $this->handler(false, $e, "select#bind: ".$query, false); }
					try { $execution =  $this->handler($handler->execute(), false, "select#execute: ".$query, false); } catch (Exception $e) { return $this->handler(false, $e, "select#execute: ".$query, false); }
					if($execution){
						try { $exec_res =  $this->handler($handler->get_result(), false, "select#get_result: ".$query, false); } catch (Exception $e) { return $this->handler(false, $e, "select#get_result: ".$query, false); }
						if($exec_res){
							if(!$multiple) {
								$row = $exec_res->fetch_array($fetch_type);
							} else {
								$row = $exec_res->fetch_all($fetch_type);  
							}
							$exec_res->free_result();
							$handler->free_result();
							return $row;
						} else { $handler->free_result(); return false;}
					} else {return false;} 
				} else {return false;}
			} else {
				// Default Query
				$result = false;
				try { $result = $this->handler(mysqli_query($this->mysqlcon, $query), false, "select#query: ".$query, false); } catch (Exception $e) { return $this->handler(false, $e, "select#query: ".$query, false); }
				if(is_object($result)) {
					$rows = 0;
					try { $rows = @mysqli_num_rows($result); } catch (Exception $e) { $rows = 0; }
					if ($rows > 0) {
						if(!$multiple) { 
							// Single Return
							$row = array();
							$row = mysqli_fetch_array($result, $fetch_type);
							// Free and Return
							mysqli_free_result($result);
							return $row;
						} else {
							// Multiple Return
							$row = array();
							for ($i=0; $i<$rows; $i++){ $restmp = mysqli_fetch_array($result, $fetch_type); $row[$i] = $restmp; }							
							// Free and Return
							mysqli_free_result($result);
							return $row;
						}
					} else {return false;}
				} else {return false;} 
			}
		}
			
		/*	  __ _ _   _  ___ _ __ _   _ 
			 / _` | | | |/ _ \ '__| | | |
			| (_| | |_| |  __/ |  | |_| |
			 \__, |\__,_|\___|_|   \__, |
				| |                 __/ |
				|_|                |___/  Select Statement for Multi Purpose  */			
		/********************** Query = The Query ****/	 
		/********************** If Bindarray = false -> normal input query | If not deliver Multi Array with Array[X]["value"] = VALUE and Array[X]["type"] ****/	 
		/********************** TYPE //Binding parameters. Types: s = string, i = integer, d = double,  b = blob] ****/	 	
		public function query($query, $bindarray = false){
			if(is_array($bindarray)) {
				// Binded Input
				$handler = false;		
				$execution = false;
				$exec_res = false;
				
				try { $this->handler($handler = $this->mysqlcon->prepare($query), false, "query#prepare: ".$query, false); } catch (Exception $e) { return $this->handler(false, $e, "query#prepare: ".$query, false); }
				if($handler) {			
					$before_prepare	=	"";
					$params	=	array(); 
					foreach ($bindarray as $key => $value) {
						if(!@$value["type"]) { $value["type"] = "s"; }
						$before_prepare .= $value["type"];
						array_push($params, $value["value"]);
					};		
					array_unshift($params, $before_prepare);
					$tmp = array();			
					foreach($params as $key => $value) {$tmp[$key] = &$params[$key];}
					try { $this->handler(call_user_func_array(array($handler, 'bind_param'), $tmp), false, "query#bind: ".$query, false); } catch (Exception $e) { return $this->handler(false, $e, "query#bind: ".$query, false); }			
					try { $execution =  $this->handler($handler->execute(), false, "query#execute: ".$query, false); } catch (Exception $e) { return $this->handler(false, $e, "query#execute: ".$query, false); }
					if($execution){
						try { $exec_res =  $this->handler($handler->get_result(), false, "query#get_result: ".$query, false); } catch (Exception $e) { return $this->handler(false, $e, "query#get_result: ".$query, false); }
						if($exec_res){
							$handler->free_result();
							//$exec_res->free_result();
							return $exec_res;
						} else { $handler->free_result(); return $exec_res;}
					} else {return false;} 
				} else {return false;}
			} else {
				// Default Query
				try { return $this->handler(mysqli_query($this->mysqlcon, $query), false, "query#query: ".$query, false); } catch (Exception $e) { return $this->handler(false, $e, "query#query: ".$query, false); }
			}
		}
		
		/*					 .___       __          
			 __ ________   __| _/____ _/  |_  ____  
			|  |  \____ \ / __ |\__  \\   __\/ __ \ 
			|  |  /  |_> > /_/ | / __ \|  | \  ___/ 
			|____/|   __/\____ |(____  /__|  \___  >
				  |__|        \/     \/          \/  Update Statement for Multi Purpose Returns Affected Rows */			
		/********************** Query = The Query ****/	 
		/********************** If Bindarray = false -> normal input query | If not deliver Multi Array with Array[X]["value"] = VALUE and Array[X]["type"] ****/	 
		/********************** TYPE //Binding parameters. Types: s = string, i = integer, d = double,  b = blob] ****/	 	
		public function update($query, $bindarray = false){
			if(is_array($bindarray)) {
				// Binded Input
				$handler = false;
				$execution = false;
				$exec_res = false;
				
				try { $this->handler($handler = $this->mysqlcon->prepare($query), false, "update#prepare: ".$query, false); } catch (Exception $e) { return $this->handler(false, $e, "update#prepare: ".$query, false); }
				if($handler) {			
					$before_prepare	=	"";
					$params	=	array(); 
					foreach ($bindarray as $key => $value) {
						if(!@$value["type"]) { $value["type"] = "s"; }
						$before_prepare .= $value["type"];
						array_push($params, $value["value"]);
					};		
					array_unshift($params, $before_prepare);
					$tmp = array();			
					foreach($params as $key => $value) {$tmp[$key] = &$params[$key];}
					try { $this->handler(call_user_func_array(array($handler, 'bind_param'), $tmp), false, "update#bind: ".$query, false); } catch (Exception $e) { return $this->handler(false, $e, "update#bind: ".$query, false); }			
					try { $execution =  $this->handler($handler->execute(), false, "update#execute: ".$query, false); } catch (Exception $e) { return $this->handler(false, $e, "update#execute: ".$query, false); }
					if($execution){
						try { $exec_res =  $this->handler($handler->get_result(), false, "update#get_result: ".$query, false); } catch (Exception $e) { return $this->handler(false, $e, "update#get_result: ".$query, false); }
						if($exec_res){
							$exec_res->free_result();
							try { $x = $exec_res->affected_rows(); } catch (Exception $e) { $handler->free_result(); return false; }
							$handler->free_result(); return $x;
						} else { $handler->free_result(); return $handler->affected_rows;}
					} else {return false;} 
				} else {return false;}
			} else {
				// Default Query
				try { $result = $this->handler(mysqli_query($this->mysqlcon, $query), false, "update#query: ".$query, false); } catch (Exception $e) { return $this->handler(false, $e, "update#query: ".$query, false); }
				try { return mysqli_affected_rows($this->mysqlcon); } catch (Exception $e) { return false; }
			}
		}

		/*	 _                     _   
			(_)                   | |  
			 _ _ __  ___  ___ _ __| |_ 
			| | '_ \/ __|/ _ \ '__| __|
			| | | | \__ \  __/ |  | |_ 
			|_|_| |_|___/\___|_|   \__| Insert Statement for Multi Purpose / Returns Inserted ID */
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
					$newquery = 'INSERT INTO `'.$table.'`('.$build_first.') VALUES('.$build_second.');';
					error_log($newquery);
					if ($stmt =  $this->handler(@$this->mysqlcon->prepare($newquery), false, "insert#prepare: ".$table, false)) { 
						$before_prepare	=	"";
						$params	=	array(); 
						foreach ($bindarray as $key => $value) {
							if(!@$value["type"]) { $value["type"] = "s"; }
							$before_prepare .= $value["type"];
							array_push($params, $value["value"]);};
						array_unshift($params, $before_prepare);
						$tmp = array();
						foreach($params as $key => $value) {$tmp[$key] = &$params[$key];}
						@call_user_func_array(array($stmt, 'bind_param'), $tmp);
						$x =  $this->handler(@$stmt->execute(), false, "insert#execute: ".$table, false,); } else {return false;}
						if($x) { try { return $this->mysqlcon->insert_id; } catch (Exception $e) { return false; } } else {return false;}
				} else {	
					if(!is_array($array)) {return false;}
					$build_first	=	"";$build_second	=	"";$firstrun = true;
					foreach( $array as $key => $value ){if(!$firstrun) {$build_first .= ", ";}
					if(!$firstrun) {$build_second .= ", ";}$build_first .= $key;
					$build_second .= "'".$this->escape($value)."'";
					$firstrun = false;}
					$nnnnquery	=	'INSERT INTO '.$table.'('.$build_first.') VALUES('.$build_second.');';
					try { $result = $this->handler(mysqli_query($this->mysqlcon, $nnnnquery), false, "insert#query: ".$nnnnquery, false); } catch (Exception $e) { return $this->handler(false, $e, "insert#query: ".$nnnnquery, false); }
					try { return $this->mysqlcon->insert_id; } catch (Exception $e) { return false; }				
				}
			} catch (Exception $e){ return $this->handler(false, $e, "insert#all: ".$table, false); }}
	}
