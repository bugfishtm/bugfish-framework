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
		private $mysqlcon		=  false;
		private $refurl			=  false;
		private $mysqltable		=  false;
		private $enabled 		=  true; public function enabled($bool = true) {$this->enabled = $bool;} 
		private $urlpath 		=  false;

		######################################################
		// Table Initialization
		######################################################
		private function create_table() {
			return mysqli_query($this->mysqlcon, "CREATE TABLE IF NOT EXISTS `".$this->mysqltable."` (
											  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
											  `full_url` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0' COMMENT 'Referer Domain',
											  `hits` int NOT NULL DEFAULT '0' COMMENT 'Counter for Referer',
											  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
											  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
											  PRIMARY KEY (`id`),
											  UNIQUE KEY `UNIQUE` (`full_url`) USING BTREE
											) ENGINE=InnoDB AUTO_INCREMENT=353 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;");		
		}
		
		######################################################
		// Constructor
		######################################################
		function __construct($mysqlvar, $table, $refurlnowww) {
			$this->mysqlcon 	= $mysqlvar;
			$this->refurl 		= $refurlnowww;
			$this->mysqltable 	= $table;
			
			$val = false; try {
				$val = mysqli_query($this->mysqlcon, 'SELECT 1 FROM `'.$this->mysqltable.'`');
			} catch (Exception $e){ 
				 $this->create_table();
			} if($val === FALSE) { $this->create_table();}
		}

		######################################################
		// Filter String for Database
		######################################################
		private function filter_db($val) {
			return mysqli_real_escape_string($this->mysqlcon, @$val);
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
		// Destructor and Save Values
		######################################################
		function __destruct() {
			if ( $parts = parse_url( @$_SERVER["HTTP_REFERER"] ) AND $this->enabled) {
				$thecurrentreferer = $this->prepareUrl(@$parts[ "host" ]);
				if(@trim($parts[ "host" ]) != $this->refurl AND @trim($parts[ "host" ]) != "www.".$this->refurl) {
					$query = "SELECT * FROM `".$this->mysqltable."` WHERE full_url = '".$this->filter_db(@$thecurrentreferer)."';";
					$sresult = @mysqli_fetch_array(@mysqli_query($this->mysqlcon, $query), MYSQLI_BOTH);
					if (!is_array($sresult)) { 
						$query = @mysqli_query($this->mysqlcon, "INSERT INTO `".$this->mysqltable."` (full_url, hits) VALUES (\"".$this->filter_db(@$thecurrentreferer)."\", \"1\")");
					} else {
						$query = @mysqli_query($this->mysqlcon, "UPDATE ".$this->mysqltable." SET hits = hits + 1 WHERE full_url = \"".$this->filter_db(@$thecurrentreferer)."\";");
					}				
				}
			}
		}
	}
?>