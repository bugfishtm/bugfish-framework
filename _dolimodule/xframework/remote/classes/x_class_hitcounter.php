<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  Hitcounter Control Class */
	class x_class_hitcounter {
		######################################################
		// Class Variables
		######################################################
		private $mysql		=  false;
		private $mysqltable		=  false;
		private $enabled 		=  true; 	public function enabled($bool = true) {$this->enabled = $bool;}	
		private $onlyarrivals 	=  false; 	public function onlyarrivals($bool = false) {$this->enabled = $bool;}	
		private $clearget 		=  true; 	public function clearget($bool = true) {$this->enabled = $bool;}	
		private $no404 			=  true; 	public function no404($bool = true) {$this->no404 = $bool;}	
		private $only200 		=  true; 	public function only200($bool = true) {$this->only200 = $bool;}	
		private $mode 			=  1;
		private $urlpath 		=  false;
		private $urlmd5 		=  false;
		private $precookie 		=  "";

		######################################################
		// Public Class Variables
		######################################################		
		public $current_switch	=	0;
		public $current_arrive	=	0;
		public $current_hits	=	0;

		######################################################
		// Table Initialization
		######################################################
		private function create_table() {
			return $this->mysql->query("CREATE TABLE IF NOT EXISTS `".$this->mysqltable."` (
												  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
												  `full_url` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0' COMMENT 'Full Domain of Hit',
												  `switches` int(10) DEFAULT '0' COMMENT 'Changes to this Site',
												  `arrivals` int(10) NOT NULL DEFAULT '0' COMMENT 'Arrivals at this Site',
												  `summarized` int(10) NOT NULL DEFAULT '0' COMMENT 'All Hits for this URL',
												  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
												  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
												  PRIMARY KEY (`id`),
												  UNIQUE KEY `UNIQUE` (`full_url`) USING BTREE
												) ENGINE=InnoDB AUTO_INCREMENT=9965 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;	");	
		}
		
		######################################################
		// Constructor
		######################################################
		function __construct($thecon, $table, $precookie = "") {
			if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
			$this->mysql = $thecon; $this->precookie = $precookie; 
			$this->mysqltable = $table; 
			$this->urlpath = $this->prepareUrl(@$_SERVER['HTTP_HOST'].@$_SERVER['REQUEST_URI']); 
			$this->urlmd5 = md5(@$this->urlpath);

			$bindar[0]["type"]	=	"s";
			$bindar[0]["value"]	=	$this->urlpath;
			$res = $this->mysql->query("SELECT * FROM `".$this->mysqltable."` WHERE full_url = ?;", $bindar);
			if($res) { $sresult = mysqli_fetch_array($res, MYSQLI_BOTH);
				if (is_numeric(@$sresult["switches"])) { $this->current_switch = $sresult["switches"];}
				if (is_numeric(@$sresult["arrivals"])) { $this->current_arrive = $sresult["arrivals"];}
				if (is_numeric(@$sresult["arrivals"])) { $this->current_hits = $sresult["arrivals"];}
				if (is_numeric(@$sresult["switches"])) { $this->current_hits = $sresult["switches"];}
				if (is_numeric(@$sresult["switches"]) AND is_numeric(@$sresult["arrivals"])) { $this->current_hits = $sresult["arrivals"] + $sresult["switches"]; }
			}
				
			try {
				$val = $this->mysql->query('SELECT 1 FROM `'.$this->mysqltable.'`');
				if($val == FALSE) { $this->create_table();}
			} catch (Exception $e){ $this->create_table();} 
				

		}

		######################################################
		// Prepare URL for Database
		######################################################
		private function prepareUrl($tmpcode) { 
			if(strpos($tmpcode, "?") > -1  AND $this->clearget) {$tmpcode = @substr($tmpcode, 0, strpos($tmpcode, "?"));}
			if(strpos($tmpcode, "&") > -1 AND $this->clearget){$tmpcode = @substr($tmpcode, 0, strpos($tmpcode, "&"));} 
			if(strpos($tmpcode, "https://") > -1){$tmpcode = @substr($tmpcode, strpos($tmpcode, "https://"));} 
			if(strpos($tmpcode, "http://") > -1){$tmpcode = @substr($tmpcode, strpos($tmpcode, "http://"));} 
			if(strpos($tmpcode, "www.") > -1){$tmpcode = @substr($tmpcode, strpos($tmpcode, "www."));} 
			return urldecode(trim(@$tmpcode));}	
		
		######################################################
		// Show the Counters
		###################################################### 
		public function show() {
			$bindar[0]["type"]	=	"s";
			$bindar[0]["value"]	=	$this->urlpath;
			if($this->enabled) {
				$r = mysqli_fetch_array($this->mysql->query("SELECT * FROM `". $this->mysqltable ."` WHERE full_url = ?;", $bindar), MYSQLI_BOTH);
				return "Switch: ".@$this->formatNumber($r["switches"])." | Arrive: ".@$this->formatNumber($r["arrivals"])."";	
			} else {return "No Counters";}
		}		
		
		######################################################
		// Format Number for Display
		######################################################
		private function formatNumber($num) {
			if(!is_numeric(@$num)) 		{return "NONE";}
			if(@$num < 1000000) 		{return @$num;}
			if(@$num >= 1000000) 		{@$num = substr(@$num, 0, -3);} else {return @$num;}
			if(@$num >= 1000000) 		{@$num = substr(@$num, 0, -3);} else {return @$num." K";}
			$ext = " B";
			if(@$num >= 1000000) 		{@$num = substr(@$num, 0, -3);} else {return @$num." M";}
			return @$num." B"; 
		}
		
		######################################################
		// Destruct and Raise Values
		######################################################
		function __destruct() {
			$bindar[0]["type"]	=	"s";
			$bindar[0]["value"]	=	$this->urlpath;
			if($this->enabled) {
				if(!$this->no404 OR ($this->no404 AND http_response_code() != 404)) {
					if(!$this->only200 OR ($this->only200 AND http_response_code() == 200)) {
						// Count Arrivals
						$isarrival = false;
						if(@$_SESSION["x_class_hitcounter".$this->precookie] != "ok") { 
							$isarrival = true;
							$sresult = mysqli_fetch_array($this->mysql->query("SELECT * FROM `".$this->mysqltable."` WHERE full_url = ?;", $bindar), MYSQLI_BOTH);
								if (@$sresult["full_url"] == NULL) {
									$this->mysql->query("INSERT INTO `".$this->mysqltable."` (full_url, switches, arrivals) VALUES (?, \"0\", \"1\")", $bindar);
								} else { $this->mysql->query("UPDATE ".$this->mysqltable." SET arrivals = arrivals + 1, summarized = switches + arrivals WHERE full_url = ?;", $bindar);}
							$_SESSION["x_class_hitcounter".$this->precookie] = "ok";}
							
						$ishittedarray = false;
						if(!is_array($_SESSION["x_class_hitcounter_s".$this->precookie])) { $_SESSION["x_class_hitcounter_s".$this->precookie] = array(); }
						if(is_array($_SESSION["x_class_hitcounter_s".$this->precookie])) {
							foreach($_SESSION["x_class_hitcounter_s".$this->precookie] as $key => $value) {
								if($value == $this->urlmd5) { $ishittedarray = true; }
							}
						}
						// Count Switches
						if(!$ishittedarray AND !$isarrival AND !$this->onlyarrivals) { 
							$sresult = mysqli_fetch_array($this->mysql->query("SELECT * FROM `".$this->mysqltable."` WHERE full_url = ?;", $bindar), MYSQLI_BOTH);
							if (@$sresult["full_url"] == NULL) {
								$this->mysql->query("INSERT INTO `".$this->mysqltable."` (full_url, switches, arrivals) VALUES (?, \"1\", \"0\")", $bindar);}
							else {$this->mysql->query("UPDATE ".$this->mysqltable." SET switches = switches + 1, summarized = switches + arrivals WHERE full_url = ?;", $bindar);}
							array_push($_SESSION["x_class_hitcounter_s".$this->precookie], $this->urlmd5);
						}				
					}
				}
			}
		}
	}
?>