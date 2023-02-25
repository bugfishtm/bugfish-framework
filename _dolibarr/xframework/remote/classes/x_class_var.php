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
		private $db_r_c_descr   	= "description";
		private $db_r_c_section 	= "";
		private $sections_name   		= ""; public function sections($field, $section_name) { $this->sections_name = $section_name; $this->db_r_c_section = $field; }
		public $const 	=	 array();

		######################################################
		// Table Initialization
		######################################################
		private function create_table() {
			return $this->variable_msqlcon->query("CREATE TABLE IF NOT EXISTS `".$this->variable_table."` (
												  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
												  `descriptor` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Descriptor for Constant',
												  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Value for Constant',
												  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Description for Constant',
												  `section` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'Section for Constant',
												  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
												  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
												  PRIMARY KEY (`id`),
												  UNIQUE KEY `Unique` (`section`,`descriptor`) USING BTREE
												) ENGINE=InnoDB AUTO_INCREMENT=453 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");	
		}
		
		######################################################
		// Construct
		######################################################
		function __construct($mysql, $tablename, $descriptor = "descriptor", $value = "value", $description = "description") { 
			if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
			$this->variable_msqlcon = $mysql; 
			$this->db_r_c_title     = $descriptor; 
			$this->db_r_c_value     = $value; 
			$this->db_r_c_descr     = $description; 
			$this->variable_table   = $tablename; 

			try {
				$val = $this->variable_msqlcon->query('SELECT 1 FROM `'.$this->variable_table.'`');
				if($val == FALSE) { $this->create_table();}
			} catch (Exception $e){ $this->create_table();} 
		}
			
		######################################################
		// Init as Constant
		######################################################
		public function initAsConstant($section = false){ 
			if(!$section) { $section = $this->sections_name; }
			$rres = @$this->variable_msqlcon->query("SELECT * FROM ".$this->variable_table." WHERE (".$this->db_r_c_section." = '".$section."'); ");
			while ($sresult = @mysqli_fetch_array($rres, MYSQLI_BOTH)){	
				if(!defined($sresult[$this->db_r_c_title])) {
					define($sresult[$this->db_r_c_title], $sresult["".$this->db_r_c_value.""]);
				}	
			} return true;
		}

		######################################################
		// Return as Array
		######################################################
		public function initAsArray($section = false){ 
			if(!$section) { $section = $this->sections_name; }
			$tmparray = array();
			$rres = @$this->variable_msqlcon->query("SELECT * FROM ".$this->variable_table." WHERE (".$this->db_r_c_section." = '".$section."'); "); 
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
		public function init($section = false){ 
			if(!$section) { $section = $this->sections_name; }
			$tmparray = array();
			$rres = @$this->variable_msqlcon->query("SELECT * FROM ".$this->variable_table." WHERE (".$this->db_r_c_section." = '".$section."'); ");
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
		public function addVar($name, $value, $section = false, $description = "")  {
			if(!$section) { $section = $this->sections_name; }
			if($this->existVar($name, $section)) { return false; }
			return @$this->variable_msqlcon->query("INSERT INTO ".$this->variable_table."(".$this->db_r_c_title.", ".$this->db_r_c_value.", ".$this->db_r_c_section.", ".$this->db_r_c_descr.") VALUES('".$this->variable_msqlcon->escape(@$name)."', '".$this->variable_msqlcon->escape(@$value)."', \"".$section."\", \"".$this->variable_msqlcon->escape(@$description)."\");");	
		}
		
		######################################################
		// Set or Add Variable
		######################################################
		public function setVar($name, $value, $section = false, $addifnotexist = true) {
			if(!$section) { $section = $this->sections_name; }
			if($this->existVar($name, $section)) {
				return @$this->variable_msqlcon->query("UPDATE ".$this->variable_table." SET ".$this->db_r_c_value." = '".$this->variable_msqlcon->escape(@$value)."' WHERE ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\" AND (".$this->db_r_c_section." = '".$section."');"); 			
			} elseif($addifnotexist) {
				return @$this->variable_msqlcon->query("INSERT INTO ".$this->variable_table."(".$this->db_r_c_title.", ".$this->db_r_c_value.", ".$this->db_r_c_section.") VALUES('".$this->variable_msqlcon->escape(@$name)."', '".$this->variable_msqlcon->escape(@$value)."', \"".$section."\");");
			}
		}
		
		######################################################
		// Setup Variable
		######################################################
		public function setupVar($name, $value, $descr, $section = false) {
			if($this->existVar($name, $section)) { return false; }
			if(!$section) { $section = $this->sections_name; }
			return @$this->variable_msqlcon->query("INSERT INTO ".$this->variable_table."(".$this->db_r_c_title.", ".$this->db_r_c_value.", ".$this->db_r_c_section.", ".$this->db_r_c_descr.") VALUES('".$this->variable_msqlcon->escape(@$name)."', '".$this->variable_msqlcon->escape(@$value)."', \"".$section."\", '".$this->variable_msqlcon->escape($descr)."');");			
			
		}
		
		######################################################
		// Get a Variable
		######################################################
		public function getVar($name, $section = false) { 
			if(!$this->existVar($name, $section)) { return false; }
			if(!$section) { $section = $this->sections_name; }
			$query = "SELECT * FROM `".$this->variable_table."` WHERE (".$this->db_r_c_section." = '".$section."' ) AND ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";"; $sresult = @mysqli_fetch_array(@$this->variable_msqlcon->query($query), MYSQLI_BOTH); return @$sresult["".$this->db_r_c_value.""];	
		}
		
		######################################################
		// Get a Full Array from Row of Table with This name Found 1st Hit
		######################################################
		public function getVarFull($name, $section = false) { 
			if(!$this->existVar($name, $section)) { return false; }
			if(!$section) { $section = $this->sections_name; }
			$query = "SELECT * FROM `".$this->variable_table."` WHERE (".$this->db_r_c_section." = '".$section."' ) AND ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";"; $sresult = @mysqli_fetch_array(@$this->variable_msqlcon->query($query), MYSQLI_BOTH); return @$sresult;	
		}

		######################################################
		// Check if Var Exists
		######################################################
		public function existVar($name, $section = false) { 
			if(!$section) { $section = $this->sections_name; }
			$query = "SELECT * FROM `".$this->variable_table."` WHERE (".$this->db_r_c_section." = '".$section."' ) AND ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";"; if($sresult = @mysqli_fetch_array(@$this->variable_msqlcon->query($query), MYSQLI_BOTH)) { return true;  } else { return false;}
		}
		
		######################################################
		// Delete a Constant
		######################################################
		public function delVar($name, $section = false) {
			if(!$this->existVar($name, $section)) { return true; }			
			if(!$section) { $section = $this->sections_name; }
			return @$this->variable_msqlcon->query("DELETE FROM ".$this->variable_table." WHERE (".$this->db_r_c_section." = '".$section."') AND ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";");					
		}
		
		######################################################
		// Increase a Constant
		######################################################
		public function increaseVar($name, $section = false){
			if(!$this->existVar($name, $section)) { return false; }
			if(!$section) { $section = $this->sections_name; }
			return @$this->variable_msqlcon->query("UPDATE ".$this->variable_table."SET ".$this->db_r_c_title." = ".$this->db_r_c_title." + 1 WHERE (".$this->db_r_c_section." = '".$section."') AND ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";");					
		}
			
		######################################################
		// Decrease a Constant
		######################################################
		public function decreaseVar($name, $section = false){
			if(!$this->existVar($name, $section)) { return false; }
			if(!$section) { $section = $this->sections_name; }
			return @$this->variable_msqlcon->query("UPDATE ".$this->variable_table."SET ".$this->db_r_c_title." = ".$this->db_r_c_title." - 1 WHERE (".$this->db_r_c_section." = '".$section."') AND ".$this->db_r_c_title." = \"".$this->variable_msqlcon->escape(@$name)."\";");				
		}
		
		######################################################
		// Setup Int
		######################################################
		public function setup_int($varname, $section = false, $description = true, $addifnotexists = true, $precookie = "") {
			if(!$section) { $section = $this->sections_name; }
			if(!isset($_SESSION["x_class_var".$precookie])) {$_SESSION["x_class_var".$precookie] = mt_rand(1000, 9999); }
			if(isset($_POST["x_class_var_submit_".$varname.$section])) {
				if($_POST["x_class_var_submit_csrf"] == $_SESSION["x_class_var".$precookie]) {
					if($this->setVar($varname, $_POST["x_class_var_submit_val"], $section, $addifnotexists)) {
						$text = "<b><font color='lime'>Changed successfully!</font></b>";
					} else {
						$text = "<b><font color='red'>Could not be changed!</font></b>";
					}
				} else { $text = "<b><font color='red'>CSRF Error Try Again!</font></b>"; }
			} $current = $this->getVarFull($name, $section); ?>
			<div class="x_class_var">
				<form method="post" action="#x_class_var_ancor_<?php echo $varname.$section; ?>">
					<fieldset id="x_class_var_ancor_<?php echo $varname.$section; ?>">
						<?php if($description AND is_array($current)) { echo $current[$this->db_r_c_descr]; echo "<br />"; } ?>
						<?php if(isset($text)) { echo $text; echo "<br />"; } ?>
						<input type="number" value="<?php if(is_array($current)) { echo $current[$this->db_r_c_value]; } ?>" name="x_class_var_submit_val">
						<input type="hidden" value="<?php echo $_SESSION["x_class_var".$precookie]; ?>" name="x_class_var_submit_csrf">
						<input type="submit" value="Change" name="x_class_var_submit_<?php echo $varname.$section; ?>">
					</fieldset>
				</form>
			</div>
			<?php
		}
		
		######################################################
		// Setup String
		######################################################
		public function setup_string($varname, $section = false, $description = true, $addifnotexists = true, $precookie = "") {
			if(!$section) { $section = $this->sections_name; }
			if(!isset($_SESSION["x_class_var".$precookie])) {$_SESSION["x_class_var".$precookie] = mt_rand(1000, 9999); }
			if(isset($_POST["x_class_var_submit_".$varname.$section])) {
				if($_POST["x_class_var_submit_csrf"] == $_SESSION["x_class_var".$precookie]) {
					if($this->setVar($varname, $_POST["x_class_var_submit_val"], $section, $addifnotexists)) {
						$text = "<b><font color='lime'>Changed successfully!</font></b>";
					} else {
						$text = "<b><font color='red'>Could not be changed!</font></b>";
					}
				} else { $text = "<b><font color='red'>CSRF Error Try Again!</font></b>"; }
			} $current = $this->getVarFull($name, $section); ?>
			<div class="x_class_var">
				<form method="post" action="#x_class_var_ancor_<?php echo $varname.$section; ?>">
					<fieldset id="x_class_var_ancor_<?php echo $varname.$section; ?>">
						<?php if($description AND is_array($current)) { echo $current[$this->db_r_c_descr]; echo "<br />"; } ?>
						<?php if(isset($text)) { echo $text; echo "<br />"; } ?>
						<input type="text" value="<?php if(is_array($current)) { echo $current[$this->db_r_c_value]; } ?>" name="x_class_var_submit_val">
						<input type="hidden" value="<?php echo $_SESSION["x_class_var".$precookie]; ?>" name="x_class_var_submit_csrf">
						<input type="submit" value="Change" name="x_class_var_submit_<?php echo $varname.$section; ?>">
					</fieldset>
				</form>
			</div>
			<?php
		}		
		
		######################################################
		// Setup Text
		######################################################
		public function setup_text($varname, $section = false, $description = true, $addifnotexists = true, $precookie = "") {
			if(!$section) { $section = $this->sections_name; }
			if(!isset($_SESSION["x_class_var".$precookie])) {$_SESSION["x_class_var".$precookie] = mt_rand(1000, 9999); }
			if(isset($_POST["x_class_var_submit_".$varname.$section])) {
				if($_POST["x_class_var_submit_csrf"] == $_SESSION["x_class_var".$precookie]) {
					if($this->setVar($varname, $_POST["x_class_var_submit_val"], $section, $addifnotexists)) {
						$text = "<b><font color='lime'>Changed successfully!</font></b>";
					} else {
						$text = "<b><font color='red'>Could not be changed!</font></b>";
					}
				} else { $text = "<b><font color='red'>CSRF Error Try Again!</font></b>"; }
			} $current = $this->getVarFull($name, $section); ?>
			<div class="x_class_var">
				<form method="post" action="#x_class_var_ancor_<?php echo $varname.$section; ?>">
					<fieldset id="x_class_var_ancor_<?php echo $varname.$section; ?>">
						<?php if($description AND is_array($current)) { echo $current[$this->db_r_c_descr]; echo "<br />"; } ?>
						<?php if(isset($text)) { echo $text; echo "<br />"; } ?>
						<textarea name="x_class_var_submit_val"><?php if(is_array($current)) { echo $current[$this->db_r_c_value]; } ?></textarea><br />
						<input type="hidden" value="<?php echo $_SESSION["x_class_var".$precookie]; ?>" name="x_class_var_submit_csrf">
						<input type="submit" value="Change" name="x_class_var_submit_<?php echo $varname.$section; ?>">
					</fieldset>
				</form>
			</div>
			<?php
		}		
		
		######################################################
		// Setup Bool
		######################################################
		public function setup_bool($varname, $section = false, $description = true, $addifnotexists = true, $precookie = "") {
			if(!$section) { $section = $this->sections_name; }
			if(!isset($_SESSION["x_class_var".$precookie])) {$_SESSION["x_class_var".$precookie] = mt_rand(1000, 9999); }
			if(isset($_POST["x_class_var_submit_".$varname.$section])) {
				if($_POST["x_class_var_submit_csrf"] == $_SESSION["x_class_var".$precookie]) {
					if(isset($_POST["x_class_var_submit_val"])) { $new = 1; } else { $new = 0; }
					if($this->setVar($varname, $new, $section, $addifnotexists)) {
						$text = "<b><font color='lime'>Changed successfully!</font></b>";
					} else {
						$text = "<b><font color='red'>Could not be changed!</font></b>";
					}
				} else { $text = "<b><font color='red'>CSRF Error Try Again!</font></b>"; }
			} $current = $this->getVarFull($name, $section); ?>
			<div class="x_class_var">
				<form method="post" action="#x_class_var_ancor_<?php echo $varname.$section; ?>">
					<fieldset id="x_class_var_ancor_<?php echo $varname.$section; ?>">
						<?php if($description AND is_array($current)) { echo $current[$this->db_r_c_descr]; echo "<br />"; } ?>
						<?php if(isset($text)) { echo $text; echo "<br />"; } ?>
						<?php if(is_array($current) AND $current[$this->db_r_c_value] == 1) { $xxx = "checked"; } else { $xxx = ""; } ?>
						<input type="hidden" value="<?php echo $_SESSION["x_class_var".$precookie]; ?>" name="x_class_var_submit_csrf">
						Activate: <input type="checkbox" name="x_class_var_submit_val" <?php echo $xxx; ?>>
						<input type="submit" value="Change" name="x_class_var_submit_<?php echo $varname.$section; ?>">
					</fieldset>
				</form>
			</div>
			<?php			
		}		

		######################################################
		// Setup Radio Choose
		######################################################
		public function setup_radio($varname, $radioarray, $section = false, $description = true, $addifnotexists = true, $precookie = "") {
			if(!$section) { $section = $this->sections_name; }
			if(!isset($_SESSION["x_class_var".$precookie])) {$_SESSION["x_class_var".$precookie] = mt_rand(1000, 9999); }
			if(isset($_POST["x_class_var_submit_".$varname.$section])) {
				if($_POST["x_class_var_submit_csrf"] == $_SESSION["x_class_var".$precookie]) {
					if($this->setVar($varname, $_POST["x_class_var_submit_val"], $section, $addifnotexists)) {
						$text = "<b><font color='lime'>Changed successfully!</font></b>";
					} else {
						$text = "<b><font color='red'>Could not be changed!</font></b>";
					}
				} else { $text = "<b><font color='red'>CSRF Error Try Again!</font></b>"; }
			} $current = $this->getVarFull($name, $section); ?>
			<div class="x_class_var">
				<form method="post" action="#x_class_var_ancor_<?php echo $varname.$section; ?>">
					<fieldset id="x_class_var_ancor_<?php echo $varname.$section; ?>">
						<?php if($description AND is_array($current)) { echo $current[$this->db_r_c_descr]; echo "<br />"; } ?>
						<?php if(isset($text)) { echo $text; echo "<br />"; } ?>
						<input type="text" value="<?php if(is_array($current)) { echo $current[$this->db_r_c_value]; } ?>" name="x_class_var_submit_val">
						<input type="hidden" value="<?php echo $_SESSION["x_class_var".$precookie]; ?>" name="x_class_var_submit_csrf">
						<?php
							foreach($radioarray AS $key => $value) {
								if($current[$this->db_r_c_value] == $value[1]) { $tasd = "checked"; } else { $tasd = ""; }
								echo '<input type="radio" name="x_class_var_submit_val" value="'.$value[1].'" '.$tasd.'>'.$value[0]."<br />";
							}
						?>
						<input type="submit" value="Change" name="x_class_var_submit_<?php echo $varname.$section; ?>">
					</fieldset>
				</form>
			</div>
			<?php
		}
		
		######################################################
		// Setup Radio Choose
		######################################################
		public function setup_select($varname, $selectarray, $section = false, $description = true, $addifnotexists = true, $precookie = "") {
			if(!$section) { $section = $this->sections_name; }
			if(!isset($_SESSION["x_class_var".$precookie])) {$_SESSION["x_class_var".$precookie] = mt_rand(1000, 9999); }
			if(isset($_POST["x_class_var_submit_".$varname.$section])) {
				 if($_POST["x_class_var_submit_csrf"] == $_SESSION["x_class_var".$precookie]) {
					if($this->setVar($varname, $_POST["x_class_var_submit_val"], $section, $addifnotexists)) {
						$text = "<b><font color='lime'>Changed successfully!</font></b>";
					} else {
						$text = "<b><font color='red'>Could not be changed!</font></b>";
					}
				} else { $text = "<b><font color='red'>CSRF Error Try Again!</font></b>"; }
			} $current = $this->getVarFull($name, $section); ?>
			<div class="x_class_var">
				<form method="post" action="#x_class_var_ancor_<?php echo $varname.$section; ?>">
					<fieldset id="x_class_var_ancor_<?php echo $varname.$section; ?>">
						<?php if($description AND is_array($current)) { echo $current[$this->db_r_c_descr]; echo "<br />"; } ?>
						<?php if(isset($text)) { echo $text; echo "<br />"; } ?>
						<input type="text" value="<?php if(is_array($current)) { echo $current[$this->db_r_c_value]; } ?>" name="x_class_var_submit_val">
						<input type="hidden" value="<?php echo $_SESSION["x_class_var".$precookie]; ?>" name="x_class_var_submit_csrf">
						<select name="x_class_var_submit_val">
						<?php $output = "";
							foreach($selectarray AS $key => $value) {
								if($current[$this->db_r_c_value] == $value[1]) { echo '<option value="'.$value[1].'">'.$value[0]."</option>"; }
								else { $output .= '<option value="'.$value[1].'">'.$value[0]."</option>"; }
							}
							echo $output;
						?>
						</select>
						<input type="submit" value="Change" name="x_class_var_submit_<?php echo $varname.$section; ?>">
					</fieldset>
				</form>
			</div>
			<?php
		}
		
		######################################################
		// Show Variable only!
		######################################################
		public function setup_show($varname, $section = false, $description = true) {
			if(!$section) { $section = $this->sections_name; }
			if(!$this->existVar($varname, $section)) { $text = "<b><font color='red'>Variable not Found in System Table!</font></b>"; }
			else { $current = $this->getVarFull($name, $section); }  ?>
			
			<div class="x_class_var">
				<fieldset id="x_class_var_ancor_<?php echo $varname.$section; ?>">
					<?php if($description AND is_array($current)) { echo $current[$this->db_r_c_descr]; echo "<br />"; } ?>
					<?php if(isset($text)) { echo $text; echo "<br />"; } ?>
					Value is: <?php if(isset($current[$this->db_r_c_value])) { echo $current[$this->db_r_c_value]; echo "<br />"; } ?>
				</fieldset>
			</div>
			<?php
		}
	}
?>