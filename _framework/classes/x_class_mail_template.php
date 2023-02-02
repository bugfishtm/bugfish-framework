<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  Mail Templates Class */	
	class x_class_mail_template {
		######################################################
		// Class Variables
		######################################################
		private $mysql = false; // MySQL for Templates
		private $table = false; // Table for Templates
		private $section = false; // Section for Templates

		######################################################
		// Table Init
		######################################################
		private function create_table() {
			$this->mysql->query("CREATE TABLE IF NOT EXISTS `".$this->table."` (
								  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
								  `name` varchar(256) NOT NULL COMMENT 'Template Identifier',
								  `content` text DEFAULT NULL COMMENT 'Template Content',
								  `section` VARCHAR(128) DEFAULT NULL COMMENT 'Related Section',
								  PRIMARY KEY (`id`),
								  UNIQUE KEY `Unique` (`name`)
								) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
		}
		
		######################################################
		// Construct
		######################################################
		function __construct($mysql, $table, $section = "") {
			$this->mysql = $mysql;
			$this->table = $table;
			$this->section = $section;
			try {
				$val = $this->mysql->query('SELECT 1 FROM `'.$this->table.'`');
				if($val == FALSE) { $this->create_table();}		
			} catch (Exception $e){ $this->create_table();} 
		} 
		
		function get($name, $substitute = false, $noheaders = false) {
			$output = "";
			if(!$noheaders) { $output .= $this->header; }
			if(is_array($substitute)) {
				$ar = $this->mysql->select("SELECT * FROM ".$this->table." WHERE name = '".$this->mysql->escape($name)."' AND section = '".$this->section."'", false);
				if(is_array($ar)) {  
					foreach($substitute as $key => $value) {
						$ar["content"] = str_replace($value["key"], $value["replace"], $ar["content"]);
					}				
					$output .= $ar["content"];
				} else { $output .= "Error - Template Not Found (x_class_mail_template)"; }				
			} else { 
				$ar = $this->mysql->select("SELECT * FROM ".$this->table." WHERE name = '".$this->mysql->escape($name)."' AND section = '".$this->section."'", false);
				if(is_array($ar)) { $output .= $ar["content"]; } else { $output .= "Error - Template Not Found (x_class_mail_template)"; }
			}
			if(!$noheaders) { $output .= $this->footer; }
			return $output;
		}

		function set_free_substitute($substitute, $text) {
			if(is_array($substitute)) {
				foreach($substitute as $key => $value) {
					$text = str_replace($value["key"], $value["replace"], $text);
				}
				return $text;
			}			
		}		
		
		public $header	=	false;
		function set_header($header) { $this->header = $header; }
		function set_header_substitute($substitute) {
			if(is_array($substitute)) {
				foreach($substitute as $key => $value) {
					$this->header = str_replace($value["key"], $value["replace"], $this->header);
				}
			}			
		}
		public $footer	=	false;
		function set_footer($footer) { $this->footer = $footer; }
		function set_footer_substitute($substitute) {
			if(is_array($substitute)) {
				foreach($substitute as $key => $value) {
					$this->footer = str_replace($value["key"], $value["replace"], $this->footer);
				}
			}
		}
	} 
	
?>