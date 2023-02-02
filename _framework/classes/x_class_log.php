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
		private $mysql   		= false; 
		private $table     		= false; 
		private $section     	= false; 

		######################################################
		// Table Initialization
		######################################################
		private function create_table() {
			return $this->mysql->query("CREATE TABLE IF NOT EXISTS `".$this->table."` (
												  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
												  `type` tinyint(1) DEFAULT '0' COMMENT '0 - Unspecified 1 - Error 2 - Warning - 3 Notification',
												  `message` text COMMENT 'The Logs Content',
												  `section` VARCHAR(128) NULL COMMENT 'Related Section',
												  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
												  PRIMARY KEY (`id`)
												) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
		}
		
		######################################################
		// Constructor
		######################################################
		function __construct($mysql, $tablename, $section = "") { 
			$this->mysql  	= $mysql; 
			$this->table     = $tablename; 
			$this->section 	 = $section; 
			
			try {
				$val = $this->mysql->query('SELECT 1 FROM `'.$this->table.'`');
				if($val == FALSE) { $this->create_table();}		
			} catch (Exception $e){ $this->create_table(); } 
		}
		
		######################################################
		// Send a Messge / Notification
		######################################################
		public function post($message, $type = 3) { return $this->message($message, $type); } 
		public function send($message, $type = 3) { return $this->message($message, $type); }
		public function write($message, $type = 3) { return $this->message($message, $type); }
		public function message($message, $type = 3) {
			if(is_numeric($type)) { 
				$bindar[0]["type"]	=	"s";
				$bindar[0]["value"]	=	$message;
				return $this->mysql->query("INSERT INTO `".$this->table."` (type, message, section) VALUES (\"".$type."\", ?, '".$this->section."')", $bindar);}
			else { return false; }			
		}		

		######################################################
		// Send Notification
		######################################################		
		public function info($message) { return $this->notify($message); }
		public function notify($message) {
			$bindar[0]["type"]	=	"s";
			$bindar[0]["value"]	=	$message;
			return $this->mysql->query("INSERT INTO `".$this->table."` (type, message, section) VALUES (3, ?, '".$this->section."')", $bindar);
		}

		######################################################
		// Send Warning
		######################################################		
		public function warn($message) { return $this->warning($message); }
		public function warning($message) {
			$bindar[0]["type"]	=	"s";
			$bindar[0]["value"]	=	$message;
			return $this->mysql->query("INSERT INTO `".$this->table."` (type, message, section) VALUES (2, ?, '".$this->section."')", $bindar);
		}

		######################################################
		// Send Error
		######################################################
		public function err($message) { return $this->error($message); }
		public function failure($message) { return $this->error($message); }
		public function error($message) {
			$bindar[0]["type"]	=	"s";
			$bindar[0]["value"]	=	$message;
			return $this->mysql->query("INSERT INTO `".$this->table."` (type, message, section) VALUES (1, ?,'".$this->section."')", $bindar);
		}

		######################################################
		// Send Error
		######################################################	
		public function reset($onlysection = false, $section_ovr = false) { 
			if(!$onlysection) { 
				return @$this->mysql->query("DELETE FROM ".$this->table.";"); 
			} else {
				if(!$section_ovr) {
					return @$this->mysql->query("DELETE FROM ".$this->table." WHERE section = '".$this->section."';"); 
				} else {
					return @$this->mysql->query("DELETE FROM ".$this->table." WHERE section = '".$section_ovr."';"); 
				}
			}
		}	
	}
?>