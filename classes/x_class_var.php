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
			return mysqli_query($this->variable_msqlcon, "CREATE TABLE IF NOT EXISTS `".$this->variable_table."` (
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

			$val = false; try {
				$val = mysqli_query($this->variable_msqlcon, 'SELECT 1 FROM `'.$this->variable_table.'`');
			} catch (Exception $e){ 
				 $this->create_table();
			} if($val === FALSE) { $this->create_table();}
		}
			
		######################################################
		// Init as Constant
		######################################################
		public function initAsConstant($strict = true){ 
			if(!$strict) { $rres = @mysqli_query($this->variable_msqlcon, "SELECT * FROM ".$this->variable_table.""); }
			else { $rres = @mysqli_query($this->variable_msqlcon, "SELECT * FROM ".$this->variable_table." WHERE (".$this->db_r_c_section." = '".$this->sections_name."'); "); 
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
			if(!$strict) { $rres = @mysqli_query($this->variable_msqlcon, "SELECT * FROM ".$this->variable_table.""); }
			else { $rres = @mysqli_query($this->variable_msqlcon, "SELECT * FROM ".$this->variable_table." WHERE (".$this->db_r_c_section." = '".$this->sections_name."'); "); 
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
			if(!$strict) { $rres = @mysqli_query($this->variable_msqlcon, "SELECT * FROM ".$this->variable_table.""); }
			else { $rres = @mysqli_query($this->variable_msqlcon, "SELECT * FROM ".$this->variable_table." WHERE (".$this->db_r_c_section." = '".$this->sections_name."'); "); 
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
				return @mysqli_query($this->variable_msqlcon, "INSERT INTO ".$this->variable_table."(".$this->db_r_c_title.", ".$this->db_r_c_value.") VALUES('".$this->filter_db(@$name)."', '".$this->filter_db(@$value)."');");
			} else {
				return @mysqli_query($this->variable_msqlcon, "INSERT INTO ".$this->variable_table."(".$this->db_r_c_title.", ".$this->db_r_c_value.", ".$this->db_r_c_section.") VALUES('".$this->filter_db(@$name)."', '".$this->filter_db(@$value)."', \"".$this->sections_name."\");");			
			}			
		}

		######################################################
		// Data Filter
		######################################################
		private function filter_db($val) {
			return $this->filter_db(@$val);
		}
		
		######################################################
		// Set or Add Variable
		######################################################
		public function setVar($name, $value, $strict = true, $addifnotexist = true) {
			if($this->existVar($name, $strict)) {
				if(!$this->sections || !$strict ) {
					return @mysqli_query($this->variable_msqlcon, "UPDATE ".$this->variable_table." SET ".$this->db_r_c_value." = '".$this->filter_db(@$value)."' WHERE ".$this->db_r_c_title." = \"".$this->filter_db(@$name)."\";"); 
				} else {
					return @mysqli_query($this->variable_msqlcon, "UPDATE ".$this->variable_table." SET ".$this->db_r_c_value." = '".$this->filter_db(@$value)."' WHERE ".$this->db_r_c_title." = \"".$this->filter_db(@$name)."\" AND (".$this->db_r_c_section." = '".$this->sections_name."');"); 			
				}
			} elseif($addifnotexist) {
				if(!$this->sections || !$strict) {
					return @mysqli_query($this->variable_msqlcon, "INSERT INTO ".$this->variable_table."(".$this->db_r_c_title.", ".$this->db_r_c_value.") VALUES('".$this->filter_db(@$name)."', '".$this->filter_db(@$value)."');");
				} else {
					return @mysqli_query($this->variable_msqlcon, "INSERT INTO ".$this->variable_table."(".$this->db_r_c_title.", ".$this->db_r_c_value.", ".$this->db_r_c_section.") VALUES('".$this->filter_db(@$name)."', '".$this->filter_db(@$value)."', \"".$this->sections_name."\");");			
				}
			}
		}
			
		######################################################
		// Get a Variable
		######################################################
		public function getVar($name, $strict = true) { 
			if(!$this->existVar($name, $strict)) { return false; }
			if(!$this->sections || !$strict ) {
				$query = "SELECT * FROM `".$this->variable_table."` WHERE ".$this->db_r_c_title." = \"".$this->filter_db(@$name)."\";"; $sresult = @mysqli_fetch_array(@mysqli_query($this->variable_msqlcon, $query), MYSQLI_BOTH); return @$sresult["".$this->db_r_c_value.""];
			} else {
				$query = "SELECT * FROM `".$this->variable_table."` WHERE (".$this->db_r_c_section." = '".$this->sections_name."' ) AND ".$this->db_r_c_title." = \"".$this->filter_db(@$name)."\";"; $sresult = @mysqli_fetch_array(@mysqli_query($this->variable_msqlcon, $query), MYSQLI_BOTH); return @$sresult["".$this->db_r_c_value.""];
			}	
		}

		######################################################
		// Check if Var Exists
		######################################################
		public function existVar($name, $strict = true) { 
			if(!$this->sections || !$strict ) {
				$query = "SELECT * FROM `".$this->variable_table."` WHERE ".$this->db_r_c_title." = \"".$this->filter_db(@$name)."\";"; if($sresult = @mysqli_fetch_array(@mysqli_query($this->variable_msqlcon, $query), MYSQLI_BOTH)) { return true; } else { return false;}
			} else {
				$query = "SELECT * FROM `".$this->variable_table."` WHERE (".$this->db_r_c_section." = '".$this->sections_name."' ) AND ".$this->db_r_c_title." = \"".$this->filter_db(@$name)."\";"; if($sresult = @mysqli_fetch_array(@mysqli_query($this->variable_msqlcon, $query), MYSQLI_BOTH)) { return true;  } else { return false;}
			}	
		}
		
		######################################################
		// Delete a Constant
		######################################################
		public function delVar($name, $strict = true) {
			if(!$this->existVar($name, $strict)) { return true; }			
			if(!$this->sections || !$strict ) {
				return @mysqli_query($this->variable_msqlcon, "DELETE FROM ".$this->variable_table." WHERE ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->mysqlcon, @$name)."\";");
			} else {
				return @mysqli_query($this->variable_msqlcon, "DELETE FROM ".$this->variable_table." WHERE (".$this->db_r_c_section." = '".$this->sections_name."') AND ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->mysqlcon, @$name)."\";");					
			} 
		}
		
		######################################################
		// Increase a Constant
		######################################################
		public function increaseVar($name, $strict = true){
			if(!$this->existVar($name, $strict)) { return false; }
			if(!$this->sections || !$strict ) {
				return @mysqli_query($this->variable_msqlcon, "UPDATE ".$this->variable_table." SET ".$this->db_r_c_title." = ".$this->db_r_c_title." + 1 WHERE ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->mysqlcon, @$name)."\";");	
			} else {
				return @mysqli_query($this->variable_msqlcon, "UPDATE ".$this->variable_table."SET ".$this->db_r_c_title." = ".$this->db_r_c_title." + 1 WHERE (".$this->db_r_c_section." = '".$this->sections_name."') AND ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->mysqlcon, @$name)."\";");					
			}
		}
			
		######################################################
		// Decrease a Constant
		######################################################
		public function decreaseVar($name, $strict = true){
			if(!$this->existVar($name, $strict)) { return false; }
			if(!$this->sections || !$strict ) {
				return @mysqli_query($this->variable_msqlcon, "UPDATE ".$this->variable_table." SET ".$this->db_r_c_title." = ".$this->db_r_c_title." - 1 WHERE ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->mysqlcon, @$name)."\";");	
			} else {
				return @mysqli_query($this->variable_msqlcon, "UPDATE ".$this->variable_table."SET ".$this->db_r_c_title." = ".$this->db_r_c_title." - 1 WHERE (".$this->db_r_c_section." = '".$this->sections_name."') AND ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->mysqlcon, @$name)."\";");					
			}				
		}
	}
?>