<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  Hitcounter Control Class */
	
	class x_class_hits {
		// Classes Variables Private
		private $mysqlcon		=  false;
		private $mysqltable		=  false;
		private $enabled 		=  true; public function enabled($bool = true) {$this->enabled = $bool;}	
		private $onlyarrivals 	=  false; public function onlyarrivals($bool = true) {$this->enabled = $bool;}	
		private $mode 			=  1;
		private $urlpath 		=  false;
		private $urlmd5 		=  false;
		private $precookie 		=  "";
		
		public $current_switch	=	0;
		public $current_arrive	=	0;
		public $current_hits	=	0;
		
		// Constructor
		function __construct($thecon, $table, $precookie = "") {
			if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
			$this->mysqlcon = $thecon; $this->precookie = $precookie; 
			$this->mysqltable = $table; 
			$this->urlpath = $this->prepareUrl(@$_SERVER['HTTP_HOST'].@$_SERVER['REQUEST_URI']); 
			$this->urlmd5 = md5(@$this->urlpath);
			
			$sresult = mysqli_fetch_array(mysqli_query($this->mysqlcon, "SELECT * FROM `".$this->mysqltable."` WHERE full_url = \"".mysqli_real_escape_string($this->mysqlcon,$this->urlpath)."\";"), MYSQLI_BOTH);
				if (is_numeric(@$sresult["switches"])) { $this->current_switch = $sresult["switches"];}
				if (is_numeric(@$sresult["arrivals"])) { $this->current_arrive = $sresult["arrivals"];}
				
				if (is_numeric(@$sresult["arrivals"])) { $this->current_hits = $sresult["arrivals"];}
				if (is_numeric(@$sresult["switches"])) { $this->current_hits = $sresult["switches"];}
				if (is_numeric(@$sresult["switches"]) AND is_numeric(@$sresult["arrivals"])) { $this->current_hits = $sresult["arrivals"] + $sresult["switches"]; }
		}

		// Remove Get Vars From URL
		private function prepareUrl($tmpcode) { 
			if(strpos($tmpcode, "?") > -1) {$tmpcode = @substr($tmpcode, 0, strpos($tmpcode, "?"));}
			if(strpos($tmpcode, "&") > -1){$tmpcode = @substr($tmpcode, 0, strpos($tmpcode, "&"));} 
			if(strpos($tmpcode, "https://") > -1){$tmpcode = @substr($tmpcode, strpos($tmpcode, "https://"));} 
			if(strpos($tmpcode, "http://") > -1){$tmpcode = @substr($tmpcode, strpos($tmpcode, "http://"));} 
			if(strpos($tmpcode, "www.") > -1){$tmpcode = @substr($tmpcode, strpos($tmpcode, "www."));} 
			return urldecode(trim(@$tmpcode));}	
		
		// Show/Echo the Counters
		public function show() {
			if($this->enabled) {
				$r = mysqli_fetch_array(mysqli_query($this->mysqlcon, "SELECT * FROM `". $this->mysqltable ."` WHERE full_url = \"".mysqli_real_escape_string($this->mysqlcon,$this->urlpath)."\";"), MYSQLI_BOTH);
				return "Switch: ".@$this->formatNumber($r["switches"])." | Arrive: ".@$this->formatNumber($r["arrivals"])."";	
			} else {return "No Counters";}
		}		
		
		// Format the Number for Display
		private function formatNumber($num) {
			if(!is_numeric(@$num)) 		{return "NONE";}
			if(@$num < 1000000) 		{return @$num;}
			if(@$num >= 1000000) 		{@$num = substr(@$num, 0, -3);} else {return @$num;}
			if(@$num >= 1000000) 		{@$num = substr(@$num, 0, -3);} else {return @$num." K";}
			$ext = " B";
			if(@$num >= 1000000) 		{@$num = substr(@$num, 0, -3);} else {return @$num." M";}
			return @$num." B"; 
		}
		
		// Destruct and Increase Counter
		function __destruct() {
			if($this->enabled) {
				// Count Arrivals
				$isarrival = false;
				if(@$_SESSION[$this->precookie."x_hits"] != "ok") { 
					$isarrival = true;
					$sresult = mysqli_fetch_array(mysqli_query($this->mysqlcon, "SELECT * FROM `".$this->mysqltable."` WHERE full_url = \"".mysqli_real_escape_string($this->mysqlcon,$this->urlpath)."\";"), MYSQLI_BOTH);
						if (@$sresult["full_url"] == NULL) {
							mysqli_query($this->mysqlcon, "INSERT INTO `".$this->mysqltable."` (full_url, switches, arrivals) VALUES (\"".mysqli_real_escape_string($this->mysqlcon,$this->urlpath)."\", \"0\", \"1\")");
						} else { mysqli_query($this->mysqlcon, "UPDATE ".$this->mysqltable." SET arrivals = arrivals + 1 WHERE full_url = \"".mysqli_real_escape_string($this->mysqlcon,$this->urlpath)."\";");}
					$_SESSION[$this->precookie."x_hits"] = "ok";}
					
				$ishittedarray = false;
				if(!is_array($_SESSION[$this->precookie."x_hits_switch"])) { $_SESSION[$this->precookie."x_hits_switch"] = array(); }
				if(is_array($_SESSION[$this->precookie."x_hits_switch"])) {
					foreach($_SESSION[$this->precookie."x_hits_switch"] as $key => $value) {
						if($value == $this->urlmd5) { $ishittedarray = true; }
					}
				}
				// Count Switches
				if(!$ishittedarray AND !$isarrival AND !$this->onlyarrivals) { 
						$sresult = mysqli_fetch_array(mysqli_query($this->mysqlcon, "SELECT * FROM `".$this->mysqltable."` WHERE full_url = \"".mysqli_real_escape_string($this->mysqlcon,$this->urlpath)."\";"), MYSQLI_BOTH);
						if (@$sresult["full_url"] == NULL) {
							mysqli_query($this->mysqlcon, "INSERT INTO `".$this->mysqltable."` (full_url, switches, arrivals) VALUES (\"".mysqli_real_escape_string($this->mysqlcon,$this->urlpath)."\", \"1\", \"0\")");}
						else {mysqli_query($this->mysqlcon, "UPDATE ".$this->mysqltable." SET switches = switches + 1 WHERE full_url = \"".mysqli_real_escape_string($this->mysqlcon,$this->urlpath)."\";");}
					array_push($_SESSION[$this->precookie."x_hits_switch"], $this->urlmd5);}				
			}		
		}
	}
?>