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
	class x_class_lang {		
		// Class Variables
		private $mysql   = false; 
		private $table   = false; 
		private $section = "none"; 	
		private $lang = false; 	
		public $array = array(); 	
		
		// Table Initialization
		private function create_table() {
			return $this->mysql->query("CREATE TABLE IF NOT EXISTS `".$this->table."` (
												  `id` int(9) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID to Identify',
												  `identificator` varchar(512) NOT NULL COMMENT 'Descriptor for Translation',
												  `lang` varchar(16) NOT NULL COMMENT 'Value for Constant',
												  `translation` text COMMENT 'Description for Constant',
												  `section` varchar(128) DEFAULT '' COMMENT 'Section for Constant (For Multi Site)',
												  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date of Entry | Will be Auto-Set',
												  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date of Entry with Auto-Update on Change',
												  PRIMARY KEY (`id`),
												  UNIQUE KEY `x_class_lang` (`identificator`,`lang`,`section`) USING BTREE);");}
												  
		// Construct the Class		
		private $filemode = false;
		function __construct($mysql = false, $table = false, $lang = "none", $section = "none", $file_name = false) {
			if($lang == false AND $section = false AND $file_name = false) {
				if(is_object($mysql)) { if(!$this->mysql->table_exists($table)) { $this->create_table(); $this->mysql->free_all();  } }
				return 0;
			}
			$this->mysql = $mysql;
			$this->table = $table;
			$this->lang = $lang;
			$this->section = $section;
			if(is_object($mysql)) { if(!$this->mysql->table_exists($table)) { $this->create_table(); $this->mysql->free_all();  } 
				$this->init(); } else {
				if($file_name) {
					$this->filemode = true;
					if(file_exists($file_name) AND !is_dir($file_name)) { 
						$file = file($file_name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
						foreach ($file as $array) {
							if(strpos($array, "=") > 1) { 
								if(substr(trim($array ?? ''), 0, 2) == "//" OR substr(trim($array ?? ''), 0, 1) == "#") {  }
								else { 
									$newkey = @substr(trim($array ?? ''), 0, strpos(trim($array ?? ''), "=")); 
									$newvalue = @substr(trim($array ?? ''), strpos(trim($array ?? ''), "=") + 1); 
									$newval[$newkey] = $newvalue; 
									$this->array = array_merge($this->array, $newval);
								}
							}
						}
					}
				} 
			}
		}
		
		// Init the Array to Fetch Translations Without SQL Queries for current Loaded Translation
		private function init() {
			if($this->filemode) { return false; }
			$b[0]["type"]	=	"s";
			$b[0]["value"]	=	$this->lang;		
			$b[1]["type"]	=	"s";
			$b[1]["value"]	=	$this->section;		
			$rres = @$this->mysql->select("SELECT identificator, translation FROM `".$this->table."` WHERE lang = ? AND section = ?;", true, $b);
			if(is_array($rres)) {
				foreach($rres as $key => $value) {
					$newar = array();
					$this->array[$value["identificator"]] = $value["translation"];
				}
			} 
		}

		// Delete a Key from current Language loaded or From Another Language
		public function delete($key, $lang = false) {
			if($this->filemode) { return false; }
			if(!$lang) {
				$b[0]["type"]	=	"s";
				$b[0]["value"]	=	$this->lang;		
				$b[1]["type"]	=	"s";
				$b[1]["value"]	=	$this->section;		
				$b[2]["type"]	=	"s";
				$b[2]["value"]	=	$key;	
				return @$this->mysql->query("DELETE FROM `".$this->table."` WHERE lang = ? AND section = ? AND identificator = ?;", $b);
			} else {
				$b[0]["type"]	=	"s";
				$b[0]["value"]	=	$lang;		
				$b[1]["type"]	=	"s";
				$b[1]["value"]	=	$this->section;		
				$b[2]["type"]	=	"s";
				$b[2]["value"]	=	$key;	
				return @$this->mysql->query("DELETE FROM `".$this->table."` WHERE lang = ? AND section = ? AND identificator = ?;", $b);
			}
		}
		
		// Add a new Translation Key with Text and for loaded Lang // Or another Lang if entered as parameter
		public function add($key, $text, $lang = false) {
			if($this->filemode) { return false; }
			if(!$lang) {
				$b[0]["type"]	=	"s";
				$b[0]["value"]	=	$this->section;		
				$b[1]["type"]	=	"s";
				$b[1]["value"]	=	$this->lang;	
				$b[2]["type"]	=	"s";
				$b[2]["value"]	=	$key;	
				$b[3]["type"]	=	"s";
				$b[3]["value"]	=	$text;					
				return @$this->mysql->query("INSERT INTO `".$this->table."`(section, lang, identificator, translation) VALUES(?, ?, ?, ?);", $b);
			} else {
				$b[0]["type"]	=	"s";
				$b[0]["value"]	=	$this->section;		
				$b[1]["type"]	=	"s";
				$b[1]["value"]	=	$lang;	
				$b[2]["type"]	=	"s";
				$b[2]["value"]	=	$key;	
				$b[3]["type"]	=	"s";
				$b[3]["value"]	=	$text;				
				return @$this->mysql->query("INSERT INTO `".$this->table."`(section, lang, identificator, translation) VALUES(?, ?, ?, ?);", $b);
			}
		}

		// Translate for the current Loaded Language 
		public function translate($key, $substitution = false) {
			$val = "";
			if(isset($this->array[$key])) { $val = $this->array[$key]; } else { $val = $key; }
			if(is_array($substitution)) { 
				foreach($substitution as $key => $value) { 
					$val = preg_replace(" %repsub% ", " ".$value." ", $val, 1);
				}
			}
			return $val;
		}	
		
		// Translate for the current Loaded Language Extension
		public function extend($key, $value, $overwrite = true) {
			if($overwrite) {
				$this->array[$key] = $value;
			} else {
				if(!isset($this->array[$key])) { return $this->array[$key]; }
			}
		}			
	}
