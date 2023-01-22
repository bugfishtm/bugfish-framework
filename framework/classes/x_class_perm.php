<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  Simple Perms Control Class */	

	class x_class_perm {
		######################################################
		// Class Variables
		######################################################
		private $mysql = false;
		private $tablename = false;
		private $section = "";
		public $perm = array();

		######################################################
		// Table Initialization
		######################################################
		private function create_table() {
			return mysqli_query($this->mysql, "CREATE TABLE IF NOT EXISTS `".$this->tablename."` (
										  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
										  `ref` int(10) NOT NULL COMMENT 'Related Ref',
										  `content` text NOT NULL COMMENT 'Given Perms',
										  `section` varchar(64) DEFAULT NULL COMMENT 'Load with Section',
										  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
										  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
										  PRIMARY KEY (`id`),
										  UNIQUE KEY `Index 2` (`ref`,`section`)
										) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
		}

		######################################################
		// Constructor
		######################################################		
		function __construct($mysql, $tablename, $section = "") {
			$this->mysql	= $mysql;
			$this->tablename = $tablename;
			$this->section = $section;
			
			$val = false; try {
				$val = mysqli_query($this->mysql, 'SELECT 1 FROM `'.$this->tablename.'`');
			} catch (Exception $e){ 
				 $this->create_table();
			} if($val === FALSE) { $this->create_table();}		
		}

		######################################################
		// Database Escape
		######################################################
		private function filter_db($val) {
			return trim(mysqli_real_escape_string($this->mysql, $val));
		}

		######################################################
		// Get Permissions to Local Array
		######################################################
		public function initPerm($ref) {
			if(is_numeric($ref)) { 
				$query = mysqli_query($this->mysql, "SELECT * FROM ".$this->tablename." WHERE ref = \"".$this->filter_db($ref)."\" AND section = '".$this->section."'");
				if ($result	=	mysqli_fetch_array($query) ) {
					$newar	= unserialize($result["content"]);					
					if(is_array($newar)) { $this->perm = $newar; return $newar; } else {$this->perm = array(); return array();}
				} 
				$this->perm = array(); return array();
			} $this->perm = array(); return array();		
		}
		
		######################################################
		// Get Permissions to Array
		######################################################
		public function getPerm($ref) {
			if(is_numeric($ref)) { 
				$query = mysqli_query($this->mysql, "SELECT * FROM ".$this->tablename." WHERE ref = \"".$this->filter_db($ref)."\" AND section = '".$this->section."'");
				if ($result	=	mysqli_fetch_array($query) ) {
					$newar	= unserialize($result["content"]);					
					if(is_array($newar)) { return $newar; } else {return array();}
				} 
				return array();
			} return array();		
		}

		######################################################
		// Add Permission to Ref
		######################################################		
		public function addPerm($ref, $permname) {
			$current_perm	=	$this->getPerm($ref);
			$hasperm = false;
			if(is_array($current_perm)) {
				foreach($current_perm AS $key => $value) {
					if($value == $permname) { $hasperm = true; }
				}
			} else { $current_perm = array(); }

			if(!$hasperm) {array_push($current_perm, $permname);}		
			$this->setPerm($ref, $current_perm);		
			return true;			
		}

		######################################################
		// Check if Ref has Perm
		######################################################		
		public function hasPerm($ref, $permname) {
			$current_perm	=	$this->getPerm($ref);
			if(is_array($current_perm)) {
				foreach($current_perm AS $key => $value) {
					if($value == $permname) { return true; }
				}
			}	
			return false;			
		}

		######################################################
		// Set Ref Permissions
		######################################################			
		private function setPerm($ref, $array) {	
			if(is_numeric($ref)) { 
				$query = mysqli_query($this->mysql, "SELECT * FROM ".$this->tablename." WHERE ref = \"".$this->filter_db($ref)."\" AND section = '".$this->section."'");
				if ($result	=	mysqli_fetch_array($query) ) { 
					mysqli_query($this->mysql, "UPDATE ".$this->tablename." SET content = '".$this->filter_db(serialize($array))."' WHERE ref = '".$this->filter_db($ref)."' AND section = '".$this->section."'  ");
				} else { 
					mysqli_query($this->mysql, "INSERT INTO ".$this->tablename." (ref, content, section) VALUES('".$this->filter_db($ref)."', '".$this->filter_db(serialize($array))."', '".$this->section."')"); 
				}
				return true;
			} return false; 		
		}

		######################################################
		// Remove Ref Permissions
		######################################################	
		public function removePerm($ref, $permname) {
			$current_perm	=	$this->getPerm($ref);
			$newperm	=	array();
			if(is_array($current_perm)) {
				foreach($current_perm AS $key => $value) {
					if($value != $permname) { array_push($newperm, $value); }
				}
			}
			$this->setPerm($ref, $newperm);
			return true;
		}

		######################################################
		// Flush a REF From the Perms Table
		######################################################			
		public function flush($ref) {
			return mysqli_query($this->mysql, "DELETE FROM ".$this->tablename." WHERE ref = \"".$this->filter_db($ref)."\" AND section = '".$this->section."'");
		}
	}
?>