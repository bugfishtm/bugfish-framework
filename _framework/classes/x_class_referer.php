<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  Referers Control Class */
	class x_class_referer {
		######################################################
		// Class Variables
		######################################################
		private $mysql		=  false;
		private $refurl		=  false;
		private $mysqltable	=  false;
		private $enabled 	=  true; public function enabled($bool = true) {$this->enabled = $bool;} 
		private $urlpath 	=  false;

		######################################################
		// Table Initialization
		######################################################
		private function create_table() {
			return $this->mysql->query("CREATE TABLE IF NOT EXISTS `".$this->mysqltable."` (
											  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Identificator',
											  `full_url` varchar(512) NOT NULL DEFAULT '0' COMMENT 'Related Referer',
											  `hits` int NOT NULL DEFAULT '0' COMMENT 'Counted Hits',
											  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation',
											  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification',
											  PRIMARY KEY (`id`),
											  UNIQUE KEY `UNIQUE` (`full_url`) USING BTREE );");		
		}
		
		######################################################
		// Constructor
		######################################################
		function __construct($mysql, $table, $refurlnowww) {
			$this->mysql 		= $mysql;
			$this->refurl 		= $refurlnowww;
			$this->mysqltable 	= $table;
			if(!$this->mysql->table_exists($table)) { $this->create_table(); $this->mysql->free_all();  }
		}
		
		######################################################
		// Prepare URL for Database
		######################################################
		private function prepareUrl($tmpcode){
			if(strpos($tmpcode, "?") > -1) 			{$tmpcode = @substr($tmpcode, 0, 	strpos($tmpcode, "?"));}
			if(strpos($tmpcode, "&") > -1)			{$tmpcode = @substr($tmpcode, 0, 	strpos($tmpcode, "&"));} 
			if(strpos($tmpcode, "https://") > -1)	{$tmpcode = @substr($tmpcode, 		strpos($tmpcode, "https://"));} 
			if(strpos($tmpcode, "http://") > -1)	{$tmpcode = @substr($tmpcode, 		strpos($tmpcode, "http://"));} 
			if(strpos($tmpcode, "www.") > -1)		{$tmpcode = @substr($tmpcode, 		strpos($tmpcode, "www."));} 
			$return = urldecode(trim($tmpcode));
		}	
		
		######################################################
		// Execute Function
		######################################################
		public function execute(){
			if ( $parts = parse_url( @$_SERVER["HTTP_REFERER"] ) AND $this->enabled) {
				$thecurrentreferer = $this->prepareUrl(@$parts[ "host" ]);
				$b[0]["type"]	=	"s";
				$b[0]["value"]	=	$thecurrentreferer;
				if(@trim(@$parts[ "host" ]) != $this->refurl AND @trim(@$parts[ "host" ]) != "www.".$this->refurl AND @trim(@$parts[ "host" ]) != "") {
					$query = "SELECT * FROM `".$this->mysqltable."` WHERE full_url = ?;";
					$sresult = @mysqli_fetch_array(@$this->mysql->query($query, $b), MYSQLI_BOTH);
					if (!is_array($sresult)) { 
						$query = @$this->mysql->query("INSERT INTO `".$this->mysqltable."` (full_url, hits) VALUES (?, 1)", $b);
					} else {
						$query = @$this->mysql->query("UPDATE ".$this->mysqltable." SET hits = hits + 1 WHERE full_url = ?;", $b);
					}				
				}
			}
		} return true;
	}
?>