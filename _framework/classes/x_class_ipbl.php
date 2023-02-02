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
		private $mysql  	 = false; 
		private $table     	= false; 
		public $ip     		= false; 
		public $max     	= false; 
		public $blocked     = false; 
		
		######################################################
		// Table Initialization
		######################################################
		private function create_table() {
			return $this->mysql->query("CREATE TABLE IF NOT EXISTS `".$this->table."` (
												  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
												  `failures` int(10) DEFAULT '0' COMMENT 'Failures for this IP Address',
												  `ip_adr` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Remote IP Address',
												  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
												  PRIMARY KEY (`id`),
												  UNIQUE KEY `Index 2` (`ip_adr`)
												) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");			
		}
		
		######################################################
		// Construct
		######################################################
		function __construct($mysql, $tablename, $maxvalue = 50000) { 
			$this->mysql  	 = $mysql; 
			$this->table     = $tablename; 
			$this->ip  	  	 = @trim(@$_SERVER["REMOTE_ADDR"]); 
			$this->max  	 = $maxvalue; 
			$val = false; try {
				$val = $this->mysql->query('SELECT 1 FROM `'.$this->table.'`');
				if($val == FALSE) { $this->create_table(); }
			} catch (Exception $e){ $this->create_table();   } 	
			$this->blocked	=	$this->blocked();			
		}

		######################################################
		// Check Current Block Status
		######################################################	
		public function blocked() { $this->isBlocked(); } 
		public function banned() { $this->isBlocked(); } 
		public function isbanned() { $this->isBlocked(); } 
		public function isblocked() {
			$bindar[0]["type"]	=	"s";
			$bindar[0]["value"]	=	$this->ip;
			$rres = @$this->mysql->query("SELECT * FROM ".$this->table." WHERE ip_adr = ? AND failures > ".$this->max.";", $bindar); 
			while ($sresult = @mysqli_fetch_array($rres, MYSQLI_BOTH)){	return true; }
			return false;		
		}

		######################################################
		// Get Counter for IP
		######################################################	
		public function counter($ip = false) {
			$bindar[0]["type"]	=	"s";
			$bindar[0]["value"]	=	$this->ip;
			if(!$ip) { $rres = @$this->mysql->query("SELECT * FROM ".$this->table." WHERE ip_adr = ? AND failures > ".$this->max.";", $bindar); }
			else { $rres = @$this->mysql->query("SELECT * FROM ".$this->table." WHERE ip_adr = ? AND failures > ".$this->max.";", $bindar); }
			while ($sresult = @mysqli_fetch_array($rres, MYSQLI_BOTH)){	return $sresult["failures"]; }
			return 0;		
		}

		######################################################
		// Raise Counter for Current IP
		######################################################		
		public function increase() { $this->raise(); } 
		public function raise() {
			$bindar[0]["type"]	=	"s";
			$bindar[0]["value"]	=	$this->ip;
			$rres = @$this->mysql->query("SELECT * FROM ".$this->table." WHERE ip_adr = ?;", $bindar); 
			while ($sresult = @mysqli_fetch_array($rres, MYSQLI_BOTH)){	return @$this->mysql->query("UPDATE ".$this->table." SET failures = failures + 1 WHERE id = '".$sresult["id"]."';"); }
			@$this->mysql->query("INSERT INTO ".$this->table."(ip_adr, failures) VALUES(?, 1);", $bindar); 				
		}	
	}
?>