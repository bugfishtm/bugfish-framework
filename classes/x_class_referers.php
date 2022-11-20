<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  Referers Control Class */

	class x_class_referers {
		
		// Classes Variables Private
		private $mysqlcon		=  false;
		private $refurl			=  false;
		private $mysqltable		=  false;
		private $enabled 		=  true; public function enabled($bool = true) {$this->enabled = $bool;} 
		private $urlpath 		=  false;
		
		// Constructor
		function __construct($mysqlvar, $table, $refurlnowww) {
			$this->mysqlcon 	= $mysqlvar;
			$this->refurl 		= $refurlnowww;
			$this->mysqltable 	= $table;
		}
		
		// Remove Get Vars From URL		
		private function prepareUrl($tmpcode){
			if(strpos($tmpcode, "?") > -1) 			{$tmpcode = @substr($tmpcode, 0, 	strpos($tmpcode, "?"));}
			if(strpos($tmpcode, "&") > -1)			{$tmpcode = @substr($tmpcode, 0, 	strpos($tmpcode, "&"));} 
			if(strpos($tmpcode, "https://") > -1)	{$tmpcode = @substr($tmpcode, 		strpos($tmpcode, "https://"));} 
			if(strpos($tmpcode, "http://") > -1)	{$tmpcode = @substr($tmpcode, 		strpos($tmpcode, "http://"));} 
			if(strpos($tmpcode, "www.") > -1)		{$tmpcode = @substr($tmpcode, 		strpos($tmpcode, "www."));} 
			$return = urldecode(trim($tmpcode));
		}	
		
		// Destruct and Write Referer to DB if not Disabled
		function __destruct() {
			if ( $parts = parse_url( @$_SERVER["HTTP_REFERER"] ) AND $this->enabled) {
				$thecurrentreferer = $this->prepareUrl(@$parts[ "host" ]);
				if(@trim($parts[ "host" ]) != $this->refurl AND @trim($parts[ "host" ]) != "www.".$this->refurl) {
					$query = "SELECT * FROM `".$this->mysqltable."` WHERE full_url = '".mysqli_real_escape_string($this->mysqlcon, @$thecurrentreferer)."';";
					$sresult = @mysqli_fetch_array(@mysqli_query($this->mysqlcon, $query), MYSQLI_BOTH);
					if (!is_array($sresult)) { 
						$query = @mysqli_query($this->mysqlcon, "INSERT INTO `".$this->mysqltable."` (full_url, hits) VALUES (\"".mysqli_real_escape_string($this->mysqlcon, @$thecurrentreferer)."\", \"1\")");
					} else {
						$query = @mysqli_query($this->mysqlcon, "UPDATE ".$this->mysqltable." SET hits = hits + 1 WHERE full_url = \"".mysqli_real_escape_string($this->mysqlcon, @$thecurrentreferer)."\";");
					}				
				}
			}
		}
	}
?>