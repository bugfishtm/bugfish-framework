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
	class x_class_benchmark {
		######################################################
		// Class Variables
		######################################################
		private $mysql			=  false;
		private $debug_obj		=  false;
		private $mysqltable		=  false;
		private $section 		=  "";
		private $urlpath 		=  false;
		private $urlmd5 		=  false;		
		private $only200		=  true; 	public function only200($bool = true) {$this->only200 = $bool;}	
		######################################################
		// Get current saved Referers in Array
		######################################################		
		public function get_array_full() {
			return $this->mysql->select("SELECT * FROM `".$this->mysqltable."`", true);
		}
		public function get_array_section($section) {
			$b[0]["type"]	=	"s";
			$b[0]["value"]	=	$section;
			return $this->mysql->select("SELECT * FROM `".$this->mysqltable."` WHERE section = ?", true, $b);
		}
		######################################################
		// Table Initialization
		######################################################
		private function create_table() {
			return $this->mysql->query("CREATE TABLE IF NOT EXISTS `".$this->mysqltable."` (
												  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID to Identify',
												  `full_url` varchar(512) NOT NULL DEFAULT '0' COMMENT 'Related Domain',
												  `value_time` varchar(64) DEFAULT '0' COMMENT 'Site Loading Time',
												  `value_memory` varchar(64) DEFAULT '0' COMMENT 'Site Loading Time',
												  `value_load` varchar(64) DEFAULT '0' COMMENT 'Site Loading Time',
												  `value_queries` varchar(64) DEFAULT '0' COMMENT 'Query Counter',
												  `section` varchar(128) NULL DEFAULT '' COMMENT 'Related Section',
												  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation',
												  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification',
												  PRIMARY KEY (`id`),
												  UNIQUE KEY `x_class_benchmark` (`full_url`) USING BTREE ) ;	");	}
		######################################################
		// Constructor
		######################################################
		function __construct($thecon, $table, $section = "") {
			$this->mysql = $thecon; $this->mysqltable = $table;  $this->section = $section; 
			$this->urlpath = $this->prepareUrl(@$_SERVER['HTTP_HOST'].@$_SERVER['REQUEST_URI']); 
			$this->urlmd5 = md5(@$this->urlpath);			
			if(!$this->mysql->table_exists($table)) { $this->create_table(); $this->mysql->free_all();  } 
			$this->debug_obj = new x_class_debug(); }

		######################################################
		// Prepare URL for Database
		######################################################
		private function prepareUrl($tmpcode) {
			if(strpos($tmpcode, "https://") > -1){$tmpcode = @substr($tmpcode, strpos($tmpcode, "https://"));} 
			if(strpos($tmpcode, "http://") > -1){$tmpcode = @substr($tmpcode, strpos($tmpcode, "http://"));} 
			if(strpos($tmpcode, "www.") > -1){$tmpcode = @substr($tmpcode, strpos($tmpcode, "www."));} 
			return urldecode(trim(@$tmpcode ?? ''));}	
			
		######################################################
		// Execute Function
		######################################################
		function execute($querie_counter = 0) {
			$b[0]["type"]	=	"s";
			$b[0]["value"]	=	$this->urlpath;
			$b[1]["type"]	=	"s";
			$b[1]["value"]	=	$this->section;	
			if(!$this->only200 OR ($this->only200 AND @http_response_code() == 200)) {
				$ar = $this->mysql->select("SELECT * FROM `".$this->mysqltable."` WHERE full_url = ? AND section = ?;",false, $b);
				$b[2]["type"]	=	"s";
				$b[2]["value"]	=	$this->debug_obj->timer() ;	
				$b[3]["type"]	=	"s";
				$b[3]["value"]	=	$this->debug_obj->memory_usage();
				$b[4]["type"]	=	"s";
				$b[4]["value"]	=	$this->debug_obj->cpu_load();
				$b[5]["type"]	=	"s";
				$b[5]["value"]	=	$querie_counter;				
				if(is_array($ar)) {
					$b[6]["type"]	=	"s";
					$b[6]["value"]	=	$this->urlpath;
					$b[7]["type"]	=	"s";
					$b[7]["value"]	=	$this->section;
					$this->mysql->update("UPDATE `".$this->mysqltable."` SET full_url = ?, section = ?, value_time = ?, value_memory = ?, value_load = ?, value_queries = ? WHERE full_url = ? AND section = ?;", $b);
				} else {
					$this->mysql->query("INSERT IGNORE INTO `".$this->mysqltable."` (full_url, section, value_time, value_memory, value_load, value_queries) VALUES (?, ?, ?, ?, ?, ?)", $b);
					$b[6]["type"]	=	"s";
					$b[6]["value"]	=	$this->urlpath;
					$b[7]["type"]	=	"s";
					$b[7]["value"]	=	$this->section;
					$this->mysql->update("UPDATE `".$this->mysqltable."` SET full_url = ?, section = ?, value_time = ?, value_memory = ?, value_load = ?, value_queries = ? WHERE full_url = ? AND section = ?;", $b);
				}
			}
		}
	}
