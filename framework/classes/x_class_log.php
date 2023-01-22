<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  Logfile Control Class */	
	class x_class_log {
		######################################################
		// Class Variables
		######################################################
		private $mysqlcon   	= false; 
		private $table     		= false; 
		private $section     	= false; 

		######################################################
		// Table Initialization
		######################################################
		private function create_table() {
			return mysqli_query($this->mysqlcon, "CREATE TABLE IF NOT EXISTS `".$this->table."` (
												  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
												  `type` tinyint(1) DEFAULT '0' COMMENT '0 - Unspecified 1 - Error 2 - Warning - 3 Notification',
												  `message` text COMMENT 'The Logs Content',
												  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
												  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
												  PRIMARY KEY (`id`)
												) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;");
		}
		
		######################################################
		// Constructor
		######################################################
		function __construct($mysql, $tablename, $section = "") { 
			$this->mysqlcon  = $mysql; 
			$this->table     = $tablename; 
			$this->section 	 = $section; 
			
			$val = false; try {
				$val = mysqli_query($this->mysqlcon, 'SELECT 1 FROM `'.$this->table.'`');
			} catch (Exception $e){ 
				 $this->create_table();
			} if($val === FALSE) { $this->create_table();}		
		}

		######################################################
		// Prepare for Database
		######################################################
		private function filter_db($val) {
			return trim(mysqli_real_escape_string($this->mysqlcon,$val));
		}
		
		######################################################
		// Send a Messge / Notification
		######################################################
		public function post($message, $type = 3) { return $this->message($message, $type); } 
		public function send($message, $type = 3) { return $this->message($message, $type); }
		public function write($message, $type = 3) { return $this->message($message, $type); }
		public function message($message, $type = 3) {
			if(is_numeric($type)) { return mysqli_query($this->mysqlcon, "INSERT INTO `".$this->table."` (type, message) VALUES (\"".$type."\", \"".$this->filter_db($message)."\")");}
			else { return false; }			
		}		

		######################################################
		// Send Notification
		######################################################		
		public function info($message) { return $this->notify($message); }
		public function notify($message) {
			return mysqli_query($this->mysqlcon, "INSERT INTO `".$this->table."` (type, message) VALUES (3, \"".$this->filter_db($message)."\")");	
		}

		######################################################
		// Send Warning
		######################################################		
		public function warn($message) { return $this->warning($message); }
		public function warning($message) {
			return mysqli_query($this->mysqlcon, "INSERT INTO `".$this->table."` (type, message) VALUES (2, \"".$this->filter_db($message)."\")");	
		}

		######################################################
		// Send Error
		######################################################
		public function err($message) { return $this->error($message); }
		public function error($message) {
			return mysqli_query($this->mysqlcon, "INSERT INTO `".$this->table."` (type, message) VALUES (1, \"".$this->filter_db($message)."\")");	
		}

		######################################################
		// Clear Entrie/Entries
		######################################################		
		public function clear_entry($id) { if(is_numeric($id)) { return @mysqli_query($this->mysqlcon, "DELETE FROM ".$this->table." WHERE id = '".$id."';"); } else { return false; } }	
		public function clear_table() { return @mysqli_query($this->mysqlcon, "DELETE FROM ".$this->table.";"); }	
	}
?>