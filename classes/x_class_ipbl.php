<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  IP Blacklisting Control Class */	
	class x_class_ipbl {
		######################################################
		// Class Variables
		######################################################
		private $mysqlcon   	= false; 
		private $table     	= false; 
		public $ip     		= false; 
		public $max     	= false; 
		public $blocked  	= false; 
		
		######################################################
		// Table Initialization
		######################################################
		private function create_table() {
			return mysqli_query($this->mysqlcon, "CREATE TABLE IF NOT EXISTS `".$this->table."` (
												  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
												  `failures` int(10) DEFAULT '0' COMMENT 'Failures for this IP Address',
												  `ip_adr` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Remote IP Address',
												  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
												  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
												  PRIMARY KEY (`id`),
												  UNIQUE KEY `Index 2` (`ip_adr`)
												) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;");			
		}
		
		######################################################
		// Construct
		######################################################
		function __construct($mysql, $tablename, $maxvalue = 50000) { 
			$this->mysqlcon  = $mysql; 
			$this->table     = $tablename; 
			$this->ip  	  	 = @trim(@$_SERVER["REMOTE_ADDR"]); 
			$this->max  	 = $maxvalue; 
			
			$val = false; try {
				$val = mysqli_query($this->mysqlcon, 'SELECT 1 FROM `'.$this->table.'`');
			} catch (Exception $e){ 
				 $this->create_table();
				 $this->blocked   = $this->isblocked(); 
			} if($val === FALSE) { $this->create_table();}
							
			$this->blocked   = $this->isblocked(); 
		}

		######################################################
		// Prepare IP Adress for Database
		######################################################		
		private function prepare_ip($val) {
			return trim(mysqli_real_escape_string($this->mysqlcon,$val));
		}

		######################################################
		// Check Current Block Status
		######################################################	 $this->prepare_ip($this->ip)	
		public function isblocked() {
			$rres = @mysqli_query($this->mysqlcon, "SELECT * FROM ".$this->table." WHERE ip_adr = '".$this->prepare_ip($this->ip)."' AND failures > ".$this->max.";"); 
			while ($sresult = @mysqli_fetch_array($rres, MYSQLI_BOTH)){	return true; }
			return false;		
		}

		######################################################
		// Get Counter for IP
		######################################################	
		public function counter($ip = false) {
			if(!$ip) { $rres = @mysqli_query($this->mysqlcon, "SELECT * FROM ".$this->table." WHERE ip_adr = '".$this->prepare_ip($this->ip)."' AND failures > ".$this->max.";"); }
			else { $rres = @mysqli_query($this->mysqlcon, "SELECT * FROM ".$this->table." WHERE ip_adr = '".$this->prepare_ip($this->ip)."' AND failures > ".$this->max.";"); }
			while ($sresult = @mysqli_fetch_array($rres, MYSQLI_BOTH)){	return $sresult["failures"]; }
			return 0;		
		}

		######################################################
		// Raise Counter for Current IP
		######################################################		
		public function raise() {
			$rres = @mysqli_query($this->mysqlcon, "SELECT * FROM ".$this->table." WHERE ip_adr = '".$this->prepare_ip($this->ip)."';"); 
			while ($sresult = @mysqli_fetch_array($rres, MYSQLI_BOTH)){	return @mysqli_query($this->mysqlcon, "UPDATE ".$this->table." SET failures = failures + 1 WHERE id = '".$sresult["id"]."';"); }
			@mysqli_query($this->mysqlcon, "INSERT INTO ".$this->table."(ip_adr, failures) VALUES('".$this->prepare_ip($this->ip)."', 1);"); 				
		}	
	}
?>