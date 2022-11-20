<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  Variables Control Class */
	
	class x_class_vars {
		// Class Variables
		private $variable_msqlcon   = false; 
		private $variable_table     = false; 
		
		private $db_r_c_title   	= "descriptor"; 
		private $db_r_c_value   	= "value";
		private $db_r_c_section 	= "section";
		
		private $sections   		= false; public function sections($field, $section_name) { $this->sections = true; $this->sections_name = $section_name; $this->db_r_c_section = $field; }
		private $sections_name  	= false;
		
		// Construct
		function __construct($mysql, $tablename, $descriptor = "descriptor", $value = "value") { 
			$this->variable_msqlcon = $mysql; 
			$this->db_r_c_title     = $descriptor; 
			$this->db_r_c_value     = $value; 
			$this->variable_table   = $tablename; }
			
		// Init all as Constant
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
		
		// Add a Variable
		public function addVar($name, $value, $null_section = false)  {
			if(!$this->sections || $null_section) {
				return @mysqli_query($this->variable_msqlcon, "INSERT INTO ".$this->variable_table."(".$this->db_r_c_title.", ".$this->db_r_c_value.") VALUES('".mysqli_real_escape_string($this->variable_msqlcon, @$name)."', '".mysqli_real_escape_string($this->variable_msqlcon, @$value)."');");
			} else {
				return @mysqli_query($this->variable_msqlcon, "INSERT INTO ".$this->variable_table."(".$this->db_r_c_title.", ".$this->db_r_c_value.", ".$this->db_r_c_section.") VALUES('".mysqli_real_escape_string($this->variable_msqlcon, @$name)."', '".mysqli_real_escape_string($this->variable_msqlcon, @$value)."', \"".$this->sections_name."\");");			
			}			
		}
		
		// Set the Value of a Var
		public function setVar($name, $value, $strict = true) {
			if(!$this->sections || !$strict ) {
				return @mysqli_query($this->variable_msqlcon, "UPDATE ".$this->variable_table." SET ".$this->db_r_c_value." = '".mysqli_real_escape_string($this->variable_msqlcon, @$value)."' WHERE ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->variable_msqlcon, @$name)."\";"); 
			} else {
				return @mysqli_query($this->variable_msqlcon, "UPDATE ".$this->variable_table." SET ".$this->db_r_c_value." = '".mysqli_real_escape_string($this->variable_msqlcon, @$value)."' WHERE ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->variable_msqlcon, @$name)."\" AND (".$this->db_r_c_section." = '".$this->sections_name."');"); 			
			}
		}
			
		// Get a Var
		public function getVar($name, $strict = true) { 
			if(!$this->sections || !$strict ) {
				$query = "SELECT * FROM `".$this->variable_table."` WHERE ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->variable_msqlcon, @$name)."\";"; $sresult = @mysqli_fetch_array(@mysqli_query($this->variable_msqlcon, $query), MYSQLI_BOTH); return @$sresult["".$this->db_r_c_value.""];
			} else {
				$query = "SELECT * FROM `".$this->variable_table."` WHERE (".$this->db_r_c_section." = '".$this->sections_name."' ) AND ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->variable_msqlcon, @$name)."\";"; $sresult = @mysqli_fetch_array(@mysqli_query($this->variable_msqlcon, $query), MYSQLI_BOTH); return @$sresult["".$this->db_r_c_value.""];
			}	
		}
		
		// Delete a Constant
		public function delVar($name, $strict = true) { 
			if(!$this->sections || !$strict ) {
				return @mysqli_query($this->variable_msqlcon, "DELETE FROM ".$this->variable_table." WHERE ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->mysqlcon, @$name)."\";");
			} else {
				return @mysqli_query($this->variable_msqlcon, "DELETE FROM ".$this->variable_table." WHERE (".$this->db_r_c_section." = '".$this->sections_name."') AND ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->mysqlcon, @$name)."\";");					
			} 
		}
		
		// Increase A Constant Value
		public function increaseVar($name, $strict = true){
			if(!$this->sections || !$strict ) {
				return @mysqli_query($this->variable_msqlcon, "UPDATE ".$this->variable_table." SET ".$this->db_r_c_title." = ".$this->db_r_c_title." + 1 WHERE ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->mysqlcon, @$name)."\";");	
			} else {
				return @mysqli_query($this->variable_msqlcon, "UPDATE ".$this->variable_table."SET ".$this->db_r_c_title." = ".$this->db_r_c_title." + 1 WHERE (".$this->db_r_c_section." = '".$this->sections_name."') AND ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->mysqlcon, @$name)."\";");					
			}
		}
			
		// Decrease A Constant Value
		public function decreaseVar($name, $strict = true){
			if(!$this->sections || !$strict ) {
				return @mysqli_query($this->variable_msqlcon, "UPDATE ".$this->variable_table." SET ".$this->db_r_c_title." = ".$this->db_r_c_title." - 1 WHERE ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->mysqlcon, @$name)."\";");	
			} else {
				return @mysqli_query($this->variable_msqlcon, "UPDATE ".$this->variable_table."SET ".$this->db_r_c_title." = ".$this->db_r_c_title." - 1 WHERE (".$this->db_r_c_section." = '".$this->sections_name."') AND ".$this->db_r_c_title." = \"".mysqli_real_escape_string($this->mysqlcon, @$name)."\";");					
			}				
		}
	}
?>