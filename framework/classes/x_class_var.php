<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  Variables Control Class */
	
	class x_class_var {
		######################################################
		// Class Variables
		######################################################
		private $variable_msqlcon   = false; 
		private $variable_table     = false; 
		
		private $db_r_c_title   	= "descriptor"; 
		private $db_r_c_value   	= "value";
		private $db_r_c_section 	= "";
		
		private $sections   		= false; public function sections($field, $section_name) { $this->sections = true; $this->sections_name = $section_name; $this->db_r_c_section = $field; }
		private $sections_name  	= "";
		
		public $const 	=	 array();

		######################################################
		// Table Initialization
		######################################################
		private function create_table() {
			return $this->variable_msqlcon->query("CREATE TABLE IF NOT EXISTS `".$this->variable_table."` (
												  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
												  `descriptor` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Descriptor for Constant',
												  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'Value for Constant',
												  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'Description for Constant',
												  `section` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '' COMMENT 'Section for Constant',
												  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
												  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
												  PRIMARY KEY (`id`),
												  UNIQUE KEY `Unique` (`section`,`descriptor`) USING BTREE
												) ENGINE=InnoDB AUTO_INCREMENT=453 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;");	
		}
		
		######################################################
		// Construct
		######################################################
		function __construct($mysql, $tablename, $descriptor = "descriptor", $value = "value") { 
			$this->variable_msqlcon = $mysql; 
			$this->db_r_c_title     = $descriptor; 
			$this->db_r_c_value     = $value; 
			$this->variable_table   = $tablename; 

			try {
				$val = $this->variable_msqlcon->query('SELECT 1 FROM `'.$this->variable_table.'`');
				if($val == FALSE) { $this->create_table();}
			} catch (Exception $e){ $this->create_table();} 
		}
			
		######################################################
		// Init as Constant
		######################################################
		public function initAsConstant($strict = true){ 
			if(!$strict) { $rres = @$this->variable_msqlcon->query("SELECT * FROM ".$this->variable_table.""); }
			else { $rres = @$this->variable_msqlcon->query("SELECT * FROM ".$this->variable_table." WHERE (".$this->db_r_c_section." = '".$this->sections_name."'); "); 
				}
			while ($sresult = @mysqli_fetch_array($rres, MYSQLI_BOTH)){	
				if(!defined($sresult[$this->db_r_c_title])) {
					define($sresult[$this->db_r_c_title], $sresult["".$this->db_r_c_value.""]);
				}	
			}
			return true;
		}

		######################################################
		// Return as Array
		######################################################
		public function initAsArray($strict = true){ 
			$tmparray = array();
			if(!$strict) { $rres = @$this->variable_msqlcon->query("SELECT * FROM ".$this->variable_table.""); }
			else { $rres = @$this->variable_msqlcon->query("SELECT * FROM ".$this->variable_table." WHERE (".$this->db_r_c_section." = '".$this->sections_name."'); "); 
				}
			while ($sresult = @mysqli_fetch_array($rres, MYSQLI_BOTH)){	
				if(!defined($sresult[$this->db_r_c_title])) {
					$tmparray_two = array();
					$tmparray_two[$this->db_r_c_title] = $this->db_r_c_value;
					array_push($tmparray, $tmparray_two);
				}	
			}
			return $tmparray;
		}
		
		######################################################
		// Init as Array
		######################################################
		public function init($strict = true){ 
			$tmparray = array();
			if(!$strict) { $rres = @$this->variable_msqlcon->query("SELECT * FROM ".$this->variable_table.""); }
			else { $rres = @$this->variable_msqlcon->query("SELECT * FROM ".$this->variable_table." WHERE (".$this->db_r_c_section." = '".$this->sections_name."'); "); 
				}
			while ($sresult = @mysqli_fetch_array($rres, MYSQLI_BOTH)){	
				if(!defined($sresult[$this->db_r_c_title])) {
					$tmparray_two = array();
					$tmparray_two[$this->db_r_c_title] = $this->db_r_c_value;
					array_push($tmparray, $tmparray_two);
				}	
			}
			$this->const = $tmparray;
			return $tmparray;
		}
		
		######################################################
		// Add Variable
		######################################################
		public function addVar($name, $value, $null_section = false)  {
			if($this->existVar($name, $strict)) { return false; }
			if(!$this->sections || $null_section) {
				return @$this->variable_msqlcon->query("INSERT INTO ".$this->variable_table."(".$this->db_r_c_title.", ".$this->db_r_c_value.") VALUES('".$this->variable_msqlcon->escape(@$name)."', '".$this->variable_msqlcon->escape(@$value)."');");
			} else {
				return @$this->variable_msqlcon->query("INSERT INTO ".$this->variable_table."(".$this->db_r_c_title.", ".$this->db_r_c_value.", ".$this->db_r_c_section.") VALUES('".$this->variable_msqlcon->escape(@$name)."', '".$this->variable_msqlcon->escape(@$value)."', \"".$this->sections_name."\");");			
			}			
		}
		
		######################################################
		// Set or Add Variable
		######################################################
		public function setVar($name, $value, $strict = true, $addifnotexist = true) {
			if($this->existVar($name, $strict)) {
				if(!$this->sections || !$strict ) {
					return @$this->variable_msqlcon->query("UPDATE ".$this->variable_table." SET ".$this->db_r_c_value." = '".$this->variable_msqlcon->escape(@$value)."' WHERE ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";"); 
				} else {
					return @$this->variable_msqlcon->query("UPDATE ".$this->variable_table." SET ".$this->db_r_c_value." = '".$this->variable_msqlcon->escape(@$value)."' WHERE ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\" AND (".$this->db_r_c_section." = '".$this->sections_name."');"); 			
				}
			} elseif($addifnotexist) {
				if(!$this->sections || !$strict) {
					return @$this->variable_msqlcon->query("INSERT INTO ".$this->variable_table."(".$this->db_r_c_title.", ".$this->db_r_c_value.") VALUES('".$this->variable_msqlcon->escape(@$name)."', '".$this->variable_msqlcon->escape(@$value)."');");
				} else {
					return @$this->variable_msqlcon->query("INSERT INTO ".$this->variable_table."(".$this->db_r_c_title.", ".$this->db_r_c_value.", ".$this->db_r_c_section.") VALUES('".$this->variable_msqlcon->escape(@$name)."', '".$this->variable_msqlcon->escape(@$value)."', \"".$this->sections_name."\");");			
				}
			}
		}
		
		######################################################
		// Setup Variable
		######################################################
		public function setupVar($name, $value, $descr, $section = false) {
			if($this->existVar($name, true)) { return false; }
			if($this->existVar($name, false) AND $section != false) { return false; }
			
			if(!$section) {
					return @$this->variable_msqlcon->query("INSERT INTO ".$this->variable_table."(".$this->db_r_c_title.", ".$this->db_r_c_value.", description) VALUES('".$this->variable_msqlcon->escape(@$name)."', '".$this->variable_msqlcon->escape(@$value)."', '".$this->variable_msqlcon->escape($descr)."');");
			} else {
					return @$this->variable_msqlcon->query("INSERT INTO ".$this->variable_table."(".$this->db_r_c_title.", ".$this->db_r_c_value.", ".$this->db_r_c_section.", description) VALUES('".$this->variable_msqlcon->escape(@$name)."', '".$this->variable_msqlcon->escape(@$value)."', \"".$this->sections_name."\", '".$this->variable_msqlcon->escape($descr)."');");			
			}
		}
			
		######################################################
		// Get a Variable
		######################################################
		public function getVar($name, $strict = true) { 
			if(!$this->existVar($name, $strict)) { return false; }
			if(!$this->sections || !$strict ) {
				$query = "SELECT * FROM `".$this->variable_table."` WHERE ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";"; $sresult = @mysqli_fetch_array(@mysqli_query($this->variable_msqlcon, $query), MYSQLI_BOTH); return @$sresult["".$this->db_r_c_value.""];
			} else {
				$query = "SELECT * FROM `".$this->variable_table."` WHERE (".$this->db_r_c_section." = '".$this->sections_name."' ) AND ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";"; $sresult = @mysqli_fetch_array(@mysqli_query($this->variable_msqlcon, $query), MYSQLI_BOTH); return @$sresult["".$this->db_r_c_value.""];
			}	
		}

		######################################################
		// Check if Var Exists
		######################################################
		public function existVar($name, $strict = true) { 
			if(!$this->sections || !$strict ) {
				$query = "SELECT * FROM `".$this->variable_table."` WHERE ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";"; if($sresult = @mysqli_fetch_array(@mysqli_query($this->variable_msqlcon, $query), MYSQLI_BOTH)) { return true; } else { return false;}
			} else {
				$query = "SELECT * FROM `".$this->variable_table."` WHERE (".$this->db_r_c_section." = '".$this->sections_name."' ) AND ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";"; if($sresult = @mysqli_fetch_array(@mysqli_query($this->variable_msqlcon, $query), MYSQLI_BOTH)) { return true;  } else { return false;}
			}	
		}
		
		######################################################
		// Delete a Constant
		######################################################
		public function delVar($name, $strict = true) {
			if(!$this->existVar($name, $strict)) { return true; }			
			if(!$this->sections || !$strict ) {
				return @$this->variable_msqlcon->query("DELETE FROM ".$this->variable_table." WHERE ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";");
			} else {
				return @$this->variable_msqlcon->query("DELETE FROM ".$this->variable_table." WHERE (".$this->db_r_c_section." = '".$this->sections_name."') AND ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";");					
			} 
		}
		
		######################################################
		// Increase a Constant
		######################################################
		public function increaseVar($name, $strict = true){
			if(!$this->existVar($name, $strict)) { return false; }
			if(!$this->sections || !$strict ) {
				return @$this->variable_msqlcon->query("UPDATE ".$this->variable_table." SET ".$this->db_r_c_title." = ".$this->db_r_c_title." + 1 WHERE ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";");	
			} else {
				return @$this->variable_msqlcon->query("UPDATE ".$this->variable_table."SET ".$this->db_r_c_title." = ".$this->db_r_c_title." + 1 WHERE (".$this->db_r_c_section." = '".$this->sections_name."') AND ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";");					
			}
		}
			
		######################################################
		// Decrease a Constant
		######################################################
		public function decreaseVar($name, $strict = true){
			if(!$this->existVar($name, $strict)) { return false; }
			if(!$this->sections || !$strict ) {
				return @$this->variable_msqlcon->query("UPDATE ".$this->variable_table." SET ".$this->db_r_c_title." = ".$this->db_r_c_title." - 1 WHERE ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";");	
			} else {
				return @$this->variable_msqlcon->query("UPDATE ".$this->variable_table."SET ".$this->db_r_c_title." = ".$this->db_r_c_title." - 1 WHERE (".$this->db_r_c_section." = '".$this->sections_name."') AND ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";");					
			}				
		}
	}
?>