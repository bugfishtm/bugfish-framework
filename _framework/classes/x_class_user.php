<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  Login and Users Control Class */
class x_class_user {    
	## Private SQL Informations
	private $mysql=false; // x_class_mysql Object
	private $dt_keys=false; // Table for Keys
	private $dt_users=false; // Table for Users
	//private $dt_fields=false; // Table for Extrafields 
	//	public function activate_extrafields($tablename) { $this->dt_fields = $tablename; }
	
	## Private Key Informations
	private $key_activation = 1; // Activate and Set Pass || Activate
	private $key_session = 2; // Session Keys
	private $key_recover = 3; // Recover Account Password
	private $key_mail_edit = 4;	// Keys for Mail Changes
	
	## Public Function References and User Info
	public $ref=false;	// References out of Major Functions for further Processing
	public $mail_ref_user=false;	// Outdated Reference
	public $mail_ref_token=false;	// Outdated Reference
	public $mail_ref_receiver=false;	// Outdated Reference
	public $info=false;	// Current Logged In User Information
	public $fields=false;	// Current Logged In User Extrafields
	public $user=false;	// Same as Info
	public $perm=false;	// To Save Perms, used by this class when conf setup and auto init on login
		function perm_config($table, $section = "") { $this->perm =  new x_class_perm($this->mysql, $table, $section); }
	public $misc=false;	// You can use this for what you want, will be reset on logout

	## More Public Parameters
	public $user_rank = false; // Current User Rank
	public $rank = false; // Current User Rank
	public $user_id = false; // Current User Id
	public $id = false; // Current User Id
	public $user_name = false; // Current User Name
	public $name = false; // Current User Name
	public $user_mail = false; // Current User Mail
	public $mail = false; // Current User Mail
	public $loggedin = false; // Current User Logged In?
	public $loggedIn = false; // Current User Logged In?
	public $user_loggedIn = false; // Current User Logged In?
	public $user_loggedin = false; // Current User Logged In?
	
	## For Compatibility with older Class
	public $login_request_code = false; // Return Code out of Login Functions
	public $rec_request_code = false; // Return Code out of Recover Functions
	public $act_request_code = false; // Return Code out of Activation Functions
	public $mc_request_code = false; // Return Code out of Mail Change Functions
	
	## General Setup
	private $multi_login=false;public function multi_login($bool = false){$this->multi_login=$bool;} // Multi Login Allowed?
	private $login_recover_drop=false;public function login_recover_drop($bool = false){$this->login_recover_drop=$bool;} // Delete Reset Keys after Success Login?
	private $login_field = "user_mail"; 
	public function login_field_manual($string) { $this->login_field = $string; } // Set Custom Login Field Reference
	public function login_field_user() { $this->login_field = "user_name"; $this->user_unique = true; } // Set User Name as Login Field Reference
	public function login_field_mail() { $this->login_field = "user_mail"; $this->mail_unique = true; } // Set User Mail as Login Field Reference
	private $mail_unique = false; public function mail_unique($bool = false) { $this->mail_unique = $bool; } // Mail dont have to be unique if not in reference
	private $user_unique = false; public function user_unique($bool = false) { $this->user_unique = $bool; } // User dont have to be unique if not in reference
	
	## Logging Setup		
	private $log_ip=false;public function log_ip($bool=false){$this->log_ip = $bool;} // Log IP Adresses?
	private $log_activation=false;public function log_activation($bool=false){$this->log_activation = $bool;} // Delete old Activation Entries?
	private $log_session=false;public function log_session($bool=false){$this->log_session = $bool;} // Delete old Session Entries?
	private $log_recover=false;public function log_recover($bool=false){$this->log_recover = $bool;} // Delete old Recover Entries?
	private $log_mail_edit=false;public function log_mail_edit($bool=false){$this->log_mail_edit = $bool;} // Delete old Mail Change Entries?
	
	## Interval Between new Requests
	private $wait_activation_min = 6;public function wait_activation_min($int = 6){$this->wait_activation_min = $int;} // Wait Minutes before new Activation Request
	private $wait_recover_min = 6;public function wait_recover_min($int = 6){$this->wait_recover_min = $int;} // Wait Minutes before new Recover Request
	private $wait_mail_edit_min = 6;public function wait_mail_edit_min($int = 6){$this->wait_mail_edit_min = $int;} // Wait Minutes before new Mail Change Request
	
	## Token Expire Hours
	private $min_activation = 6;public function min_activation($int = 6){$this->min_activation = $int;} // Token Valid Length in Minutes for Activation
	private $min_recover = 6;public function min_recover($int = 6){$this->min_recover = $int;} // Token Valid Length in Minutes for Recover
	private $min_mail_edit = 6;public function min_mail_edit($int = 6){$this->min_mail_edit = $int;} // Token Valid Length in Minutes for Mail Change
	
	## Auto-Block user after X tries?
	private $autoblock = false; public function autoblock($int = false) { $this->autoblock = $int; } // Activate Autoblock after X fail Logins?
	
	## Sessions Setup
	private $sessions = "x_users";
	private $sessions_days = 7; public function sessions_days($int = 7){$this->sessions_days = $int;} // Set Max Session Use Days	
	
	## Sessions Setup
	private $password_filter_min_signs = 6;
	private $password_filter_min_capital = true;
	private $password_filter_min_small = true;
	private $password_filter_min_special = true;
	private $password_filter_min_number = true; public function pass_filter_setup($signs = 6, $capitals = true, $small = true, $special = true, $number = true) {$this->password_filter_min_signs = $signs;$this->password_filter_min_capital = $capitals;$this->password_filter_min_small = $small;$this->password_filter_min_special = $special;$this->password_filter_min_number = $number;}
	public function pass_filter_check($passclear) {  
		$isvalid = true;
		if(strlen($passclear) < $this->password_filter_min_signs) { $isvalid = false; }
		if($this->password_filter_min_small) { if(preg_match('/[a-z]/', $string)){ } else { $isvalid = false; } }
		if($this->password_filter_min_capital) { if(preg_match('/[A-Z]/', $string)){ } else { $isvalid = false; } }
		if($this->password_filter_min_number) { if(preg_match('/[0-9]/', $string)){ } else { $isvalid = false; } }
		if($this->password_filter_min_special) { if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+-]/', $string)){ } else { $isvalid = false; } }
		return $isvalid;
	}
	
	## Cookie Setup		
	private $cookies = true;private $cookies_use = false;public function cookies_use($bool = true){$this->cookies_use = $bool;$this->cookies = $this->sessions;} // Allow Cookies Use in General
	private $cookies_days = 7;public function cookies_days($int = 7){$this->cookies_days = $int;} // Max Cookie Lifetime in Days
	
	## Token Setup & Password Functions
	private $token_charset = "0123456789"; public function token_charset($charset = "0123456789") { $this->token_charset = $charset; } // Setup General Token Charset
	private $token_length = 24; public function token_length($length = 24) { $this->token_length = $length; } // Setup General Token Length
	private function token_gen() { return $this->password_gen($this->token_length, $this->token_charset); }
	private $session_charset = "0123456789"; public function session_charset($charset = "0123456789") { $this->session_charset = $charset; } // Setup Session Token Charset
	private $session_length = 24; public function session_length($length = 24) { $this->session_length = $length; }	 // Setup Session Token Length	
	private function session_gen() { return $this->password_gen($this->session_length, $this->session_charset); }	
	public function password_gen($len = 12, $comb = "abcde12345"){$pass = array(); $combLen = strlen($comb) - 1; for ($i = 0; $i < $len; $i++) { $n = mt_rand(0, $combLen); $pass[] = $comb[$n]; } return implode($pass);}			
	public function password_crypt($var, $hash = PASSWORD_BCRYPT) { return password_hash($var,$hash); }
	public function password_check($cleartext, $crypted) { return password_verify($cleartext,$crypted); }	
	
	## Cookies Functions
	private function cookie_set($id, $key){if($this->cookies_use){setcookie($this->cookies."session_userid", $id, time() + $this->cookies_days * 24 * 60 * 60);setcookie($this->cookies."session_key", $key, time() + $this->cookies_days * 24 * 60 * 60);} return true;}
	private function cookie_unset(){if($this->cookies_use){unset($_COOKIE[$this->cookies.'session_key']);@setcookie($this->cookies.'session_key', '', time() - 3600, '/');unset($_COOKIE[$this->cookies.'session_userid']);@setcookie($this->cookies.'session_userid', '', time() - 3600, '/');} return true;}	
	private function cookie_restore(){if($this->cookies_use){if(@is_numeric($_COOKIE[$this->cookies."session_userid"]) OR @isset($_COOKIE[$this->cookies."session_key"])){if(@$this->session_token_valid(@$_COOKIE[$this->sessions."session_userid"], @$_COOKIE[$this->sessions."session_key"])){@$_SESSION[$this->sessions."x_users_stay"] = true;@$_SESSION[$this->sessions."x_users_key"] = @$_COOKIE[$this->sessions."session_key"];@$_SESSION[$this->sessions."x_users_id"] = @$_COOKIE[$this->sessions."session_userid"];@$_SESSION[$this->sessions."x_users_ip"] = @$_SERVER["REMOTE_ADDR"];$this->session_restore();return true;}else{$this->cookie_unset();return false;}}return false;}return true;}

	## Filter Functions
	private function f_tel($ref) { return $this->mysql->escape(strtolower(trim($ref))); }
	private function f_tl($ref) { return strtolower(trim($ref)); }
	private function f_te($ref) { return $this->mysql->escape(trim($ref)); }

	## User Functions
	public function get($id){if(is_numeric($id)){$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE id = '".$id."'");if($x=$this->mysqli_object_fetch($r)){return $x;}}return false;}
	public function exists($id){if(!is_numeric($id)){return false;}$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE id = '".$id."'");if($rrx = $this->mysqli_object_fetch($r)){return true;}return false;}
	public function usernameExists($ref){$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE LOWER(user_name) = \"".$this->f_tel($ref)."\"");if($rrx=$this->mysqli_object_fetch($r)){return true;}return false;}
	public function usernameExistsActive($ref){$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE LOWER(user_name) = \"".$this->f_tel($ref)."\" AND user_confirmed = 1");if($rrx = $this->mysqli_object_fetch($r)){return true;}return false;}	
	public function refExists($ref){$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE LOWER(".$this->login_field.") = \"".$this->f_tel($ref)."\"");if($rrx = $this->mysqli_object_fetch($r)){return true;}return false;}
	public function refExistsActive($ref) {$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE LOWER(".$this->login_field.") = \"".$this->f_tel($ref)."\" AND user_confirmed = 1");if($rrx = $this->mysqli_object_fetch($r)){return true;}return false;}	
	public function mailExists($ref){$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE LOWER(user_mail) = \"".$this->f_tel($ref)."\"");if($rrx=$this->mysqli_object_fetch($r)){return true;}return false;}
	public function mailExistsActive($ref) {$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE LOWER(user_mail) = \"".$this->f_tel($ref)."\" AND user_confirmed = 1");if($rrx = $this->mysqli_object_fetch($r)){return true;}return false;}	
	public function delete($id){if(is_numeric($id)){$this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE fk_user = '".$id."'"); return $this->mysql->query("DELETE FROM ".$this->dt_users." WHERE id = '".$id."'");}return false;}
	public function logout_all(){return $this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE key_type = '".$this->key_session."'");}
	public function disable_user_session($id){if(is_numeric($id)){return $this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE key_type = '".$this->key_session."' AND fk_user = '".$id."'");}return false;}
	public function delete_user_session($id){if(is_numeric($id)){return $this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE '".$this->key_session."' AND fk_user = '".$id."'");}return false;}
	public function blocked_user($id){if(is_numeric($id)) {$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE id = '".$id."'");if($x = $this->mysqli_object_fetch($r)){if($x["user_blocked"] != 1){return false;}}}return true;}
	public function block_user($id){if(is_numeric($id)){return $this->mysql->query("UPDATE ".$this->dt_users." SET user_blocked = 1 WHERE id = '".$id."'");}return false;}		
	public function unblock_user($id){if(is_numeric($id)){return $this->mysql->query("UPDATE ".$this->dt_users." SET user_blocked = 0 WHERE id = '".$id."'");}return false;}
	public function confirmed_user($id){if(is_numeric($id)){$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE id = '".$id."'");if($x = $this->mysqli_object_fetch($r)){if($x["user_confirmed"] == 1){return true;}}}return false;}	
	public function unconfirm_user($id){if(is_numeric($id)){return $this->mysql->query("UPDATE ".$this->dt_users." SET user_confirmed = 0 WHERE id = '".$id."'"); }return false;}	
	public function confirm_user($id){if(is_numeric($id)){return $this->mysql->query("UPDATE ".$this->dt_users." SET user_confirmed = 1, last_activation = CURRENT_TIMESTAMP() WHERE id = '".$id."'"); }return false;}
	public function change_rank($id, $new){if(is_numeric($id) AND is_numeric($new)){return $this->mysql->query("UPDATE ".$this->dt_users." SET user_rank = '".$new."' WHERE id = '".$id."'");}return false;}
	public function change_pass($id, $new){if(is_numeric($id) AND is_string($new)){return $this->mysql->query("UPDATE ".$this->dt_users." SET user_pass = \"".$this->mysql->escape($this->password_crypt($new))."\" WHERE id = '".$id."'");}return false;}
	public function changeUserName($id, $new){if(is_numeric($id)){if(!$this->user_unique){ return $this->mysql->query("UPDATE ".$this->dt_users." SET user_name = '".$this->f_te($new)."' WHERE id = '".$id."'");}else{$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE id = '".$id."'");if($rrx = $this->mysqli_object_fetch($r)){ if($this->f_tl($rrx["user_name"]) == $this->f_tl($new)){return true;}}if($this->usernameExistsActive($new)){return false;}else{return $this->mysql->query("UPDATE ".$this->dt_users." SET user_name = '".$this->f_te($new)."' WHERE id = '".$id."'");}}}return false;}					
	public function changeUserRef($id, $new){if(is_numeric($id)){$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE id = '".$id."'");if($rrx = $this->mysqli_object_fetch($r)){ if($this->f_tl($rrx[$this->login_field]) == f_tl($new)){return true;}}if($this->refExistsActive($new)){return false;}else{return $this->mysql->query("UPDATE ".$this->dt_users." SET ".$this->login_field." = '".$this->f_te($new)."' WHERE id = '".$id."'");}}return false;}	
	public function changeUserShadowMail($id, $new){if(is_numeric($id) AND isset($new)){if (!$this->mail_unique) { return $this->mysql->query("UPDATE ".$this->dt_users." SET user_shadow = '".$this->f_te($new)."' WHERE id = '".$id."'");}else{ if($this->mailExistsActive($new)){return false;}else{return $this->mysql->query("UPDATE ".$this->dt_users." SET user_shadow = '".$this->f_te($new)."' WHERE id = '".$id."'");}}}return false;}
	public function changeUserMail($id, $new)  { if (is_numeric($id) AND isset($new)){if (!$this->mail_unique) {return $this->mysql->query("UPDATE ".$this->dt_users." SET user_mail = '".$this->f_te($new)."' WHERE id = '".$id."'");} else { $r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE id = '".$id."'");if($rrx = $this->mysqli_object_fetch($r)){ if($this->f_tl($rrx["user_mail"]) == $this->f_tl($new)) {return true;}}if($this->mailExistsActive($new)) {return false;} else {return $this->mysql->query("UPDATE ".$this->dt_users." SET user_mail = '".$this->f_te($new)."' WHERE id = '".$id."'");}}}return false;}	
	public function addUser($name, $mail, $password = false, $rank = false, $activated = false, $delunconfirmedwhennew = false) {
		if($this->login_field == "user_mail") { $ref = $mail; } else { $ref = $name;  }
		$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE LOWER(".$this->login_field.") = '".$this->f_tel($ref)."'");
		if($rrx = $this->mysqli_object_fetch($r)){ if($rrx["user_confirmed"] == 1) {return false;} else { if($delunconfirmedwhennew) {$this->deleteUser($rrx["id"]);} else { return false; } }} 
		if(!$activated) {$activated = 0;} else {$activated = 1;}
		if(!$rank) {$rankx = 0;} else {$rankx = $rank;}
		if(!$password) {$pass = $this->password_gen(32, "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz");} else {$pass = $password;}
		return $this->mysql->query("INSERT INTO ".$this->dt_users."(user_name, user_mail, user_pass, user_rank, user_confirmed)
		VALUES('".trim($this->mysql->escape($name))."', '".trim($this->mysql->escape($mail))."', '". $this->password_crypt($pass)."', '".$rankx."', '".$activated."')");
	}
	public function get_extra($id) {
		if(is_numeric($id)) {
			$ar = $this->mysql->select("SELECT * FROM ".$this->dt_users." WHERE id = '".$id."'");
			if(is_array($ar)) {
				return unserialize($ar["extradata"]);
			} return false;
		} return false;
	}
	public function set_extra($id, $array) {
		if(is_numeric($id) AND is_array($array)) {
			$bind[0]["type"] = "s";
			$bind[0]["value"] = serialize($array);
			return $this->mysql->query("UPDATE ".$this->dt_users." SET extradata = ? WHERE id = '".$id."'", $bind);
		} return false;
	}
	# Extrafield Handling
	/*private function init_extrafield($id) {
		if(!$this->dt_fields) { return true; }
		if(is_numeric($id)) {
			$ar = $this->mysql->select("SELECT * FROM ".$this->dt_fields." WHERE fk_user = '".$id."'");
			if(!is_array($ar)) {
				return $this->mysql->query("INSERT INTO ".$this->dt_fields."(fk_user) VALUES('".$id."')");
			} return true;
		} else { return false; }
	}
	public function get_extrafields($id) { 
		if(!$this->dt_fields) { return true; }
		$this->init_extrafield($id);
		if(is_numeric($id)) {
			$ar = $this->mysql->select("SELECT * FROM ".$this->dt_fields." WHERE fk_user = '".$id."'");
			if(is_array($ar)) {
				return $ar;
			} return false;
		} return false;	
	}
	public function get_extrafield($id, $fieldname) { 
		if(!$this->dt_fields) { return true; }
		$this->init_extrafield($id);
		if(is_numeric($id)) {
			$ar = $this->mysql->select("SELECT * FROM ".$this->dt_fields." WHERE fk_user = '".$id."'");
			if(is_array($ar)) {
				return $ar[$fieldname];
			} return false;
		} return false;	
	}
	public function set_extrafield($id, $fieldname, $value) { 
		if(!$this->dt_fields) { return true; }
		$this->init_extrafield($id);
		if($id AND is_string($fieldname)) { 
			$bind[0]["type"] = "s";
			$bind[0]["value"] = $value;		
			return $this->mysql->query("UPDATE ".$this->dt_fields." SET ".$fieldname." = ? WHERE fk_user = '".$id."'", $bind);
		} else { return false; }
	} */
	# Extrafield Table Modifications
	public function user_add_field($fieldstring) { return $this->mysql->query("ALTER TABLE ".$this->dt_users." ADD ".$fieldstring." ;");}
	public function user_del_field($fieldname) { return $this->mysql->query("ALTER TABLE ".$this->dt_users." DROP COLUMN ".$fieldname." ;"); }
	
	## Check Time Interval Function	
	private function check_interval($datetimeref, $strstring = '-1 hours') {
		if (strtotime($datetimeref) > strtotime($strstring)) {return false;}
		return true;
	}
	
	## Check Time Interval Function	
	private function check_interval_value($datetimeref, $strstring = '-1 hours') {
		$new = strtotime($datetimeref) - strtotime($strstring);
		return $new;
	}
	
	## Check Time Difference Function	
	private function get_cur_time_dif($datetime) {
		$datetime = strtotime($datetime);
		$current = strtotime("Y-m-d H:i:s");
		$current = $current - $datetime;
		return $current;
	}
	
	private function mysqli_object_fetch($val) {
		if(!$val) { return false; }
		else { return mysqli_fetch_array($val); }
	}

	## Get Rrequest Interval Functions
	private function activation_request_time($user) { return $this->token_time($user, $this->key_activation); }
	private function recover_request_time($user) { return $this->token_time($user, $this->key_recover); }
	private function mail_edit_request_time($user) { return $this->token_time($user, $this->key_mail_edit); }
	private function request_time($user, $type) {
		if(is_numeric($user) AND is_numeric($type)){
			if($this->key_mail_edit == $type) {
				$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE id = '".$user."'");
				if($res=$this->mysqli_object_fetch($r)){
					if(is_numeric($this->wait_mail_edit_min)) {
						if(isset($f["req_mail_edit"])) { return $this->check_interval_value($f["req_mail_edit"], '-'.$this->wait_mail_edit_min.' minutes');}
					} else { return 0;}
				} 			
			} elseif($this->key_recover == $type) {
				$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE id = '".$user."'");
				if($res=$this->mysqli_object_fetch($r)){
					if(is_numeric($this->wait_recover_min)) {
						if(isset($f["req_recover"])) { return $this->check_interval_value($f["req_recover"], '-'.$this->wait_recover_min.' minutes');}
					} else { return 0;}
				} 					
			} elseif($this->key_activation == $type) {
				$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE id = '".$user."'");
				if($res=$this->mysqli_object_fetch($r)){
					if(is_numeric($this->wait_activation_min)) {
						if(isset($f["req_activation"])) { return $this->check_interval_value($f["req_activation"], '-'.$this->wait_activation_min.' minutes');}
					} else { return 0;}
				}					
			}
		} return 0;
	}

	## Get Token Interval Functions
	private function activation_token_time($user, $token) { return $this->token_time($user, $token, $this->key_activation); }
	private function recover_token_time($user, $token) { return $this->token_time($user, $token, $this->key_recover); }
	private function mail_edit_token_time($user, $token) { return $this->token_time($user, $token, $this->key_mail_edit); }
	private function token_time($user, $token, $type) {
		if(is_numeric($user) AND isset($token) AND is_numeric($type)){
			$bind[0]["value"] = $token;
			$bind[0]["type"] = "s";
			if($this->key_mail_edit == $type) {
				$r = $this->mysql->query("SELECT * FROM ".$this->dt_keys." WHERE key_type = '".$this->key_mail_edit."' AND session_key = ? AND fk_user = '".$user."'", $bind);
				if($res=$this->mysqli_object_fetch($r)){
					if($res["is_active"] != 1) { return 0; }
					if(is_numeric($this->min_mail_edit)) {
						if(isset($f["creation"])) { return $this->get_cur_time_dif($f["creation"]); } else { return 0; }
					} else { return 999999999; }					
				} else {return 0;}					
			} elseif($this->key_recover == $type) {
				$r = $this->mysql->query("SELECT * FROM ".$this->dt_keys." WHERE key_type = '".$this->key_recover."' AND session_key = ? AND fk_user = '".$user."'", $bind);
				if($res=$this->mysqli_object_fetch($r)){
					if($res["is_active"] != 1) { return 0; }
					if(is_numeric($this->min_recover)) {
						if(isset($f["creation"])) { return $this->get_cur_time_dif($f["creation"]); } else { return 0; }
					} else { return 999999999; }			
				} else {return 0;}						
			} elseif($this->key_activation == $type) {
				$r = $this->mysql->query("SELECT * FROM ".$this->dt_keys." WHERE key_type = '".$this->key_activation."' AND session_key = ? AND fk_user = '".$user."'", $bind);
				if($res=$this->mysqli_object_fetch($r)){
					if($res["is_active"] != 1) { return 0; }
					if(is_numeric($this->min_activation)) {
						if(isset($f["creation"])) { return $this->get_cur_time_dif($f["creation"]); } else { return 0; }
					}  else { return 999999999; }						
				} else {return 0;}						
			}
		} return false;
	}
	
	## Token Validation Functions	
	public function activation_token_valid($user, $token) { return $this->token_valid($user, $token, $this->key_activation); }
	public function recover_token_valid($user, $token) { return $this->token_valid($user, $token, $this->key_recover); }
	public function mail_edit_token_valid($user, $token) { return $this->token_valid($user, $token, $this->key_mail_edit); }
	public function session_token_valid($user, $token) { return $this->token_valid($user, $token, $this->key_session); }
	private function token_valid($user, $token, $type) {
		if(is_numeric($user) AND isset($token) AND is_numeric($type)){
			$bind[0]["value"] = $token;
			$bind[0]["type"] = "s";
			if($this->key_mail_edit == $type) {
				$r = $this->mysql->query("SELECT * FROM ".$this->dt_keys." WHERE key_type = '".$this->key_mail_edit."' AND session_key = ? AND fk_user = '".$user."'", $bind);
				if($res=$this->mysqli_object_fetch($r)){
					if($res["is_active"] != 1) { return false; }
					if(is_numeric($this->min_mail_edit)) {
						if(isset($f["creation"])) { if($this->check_interval($f["creation"], '-'.$this->min_mail_edit.' minutes')) {return false;} }
					}					
					return true;
				} else {return false;}					
			} elseif($this->key_session == $type) {
				$r = $this->mysql->query("SELECT * FROM ".$this->dt_keys." WHERE key_type = '".$this->key_session."' AND session_key = ? AND fk_user = '".$user."'", $bind);
				if($res=$this->mysqli_object_fetch($r)){
					if($res["is_active"] != 1) { return false; }
					if(is_numeric($this->sessions_days)) {
						 if(isset($f["creation"])) {
							if ($this->check_interval($f["creation"],''.$this->sessions_days.' days')) {
								if($this->log_session) { $this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE id = '".$res["id"]."'"); }
								else { $this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE id = '".$res["id"]."'"); }
								return false;
							}
						}
					}
					return true;
				} else {return false;}						
			} elseif($this->key_recover == $type) {
				$r = $this->mysql->query("SELECT * FROM ".$this->dt_keys." WHERE key_type = '".$this->key_recover."' AND session_key = ? AND fk_user = '".$user."'", $bind);
				if($res=$this->mysqli_object_fetch($r)){
					if($res["is_active"] != 1) { return false; }
					if(is_numeric($this->min_recover)) {
						if(isset($f["creation"])) { if ($this->check_interval($f["creation"],'-'.$this->min_recover.' minutes')) {					
							return false;
						}}
					}					
					return true;
				} else {return false;}						
			} elseif($this->key_activation == $type) {
				$r = $this->mysql->query("SELECT * FROM ".$this->dt_keys." WHERE key_type = '".$this->key_activation."' AND session_key = ? AND fk_user = '".$user."'", $bind);
				if($res=$this->mysqli_object_fetch($r)){
					if($res["is_active"] != 1) { return false; }
					if(is_numeric($this->min_activation)) {
						if(isset($f["creation"])) { if ($this->check_interval($f["creation"],'-'.$this->min_activation.' minutes')) {					
							return false;
						}}
					}					
					return true;
				} else {return false;}						
			}
		} return false;
	}

	## Token Creations and Singing
	private function activation_token_create($user, $token) { return $this->token_create($user, $token, $this->key_activation); }
	private function recover_token_create($user, $token) { return $this->token_create($user, $token, $this->key_recover); }
	private function mail_edit_token_create($user, $token) { return $this->token_create($user, $token, $this->key_mail_edit); }
	private function session_token_create($user, $token) { return $this->token_create($user, $token, $this->key_session); }
	private function token_create($user, $token, $type) {
		if(is_numeric($user) AND isset($token) AND is_numeric($type)){
			$bind[0]["value"] = $token;
			$bind[0]["type"] = "s";
			if($this->key_mail_edit == $type) {
				$this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE key_type = '".$this->key_mail_edit."' AND fk_user = '".$user."'");
				if(!$this->log_mail_edit) {
					$this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE key_type = '".$this->key_mail_edit."' AND fk_user = '".$user."'");
				} 		
				if($this->log_ip) {$thenewip = @$_SERVER["REMOTE_ADDR"];} else {$thenewip = "hidden";}
				$this->mysql->query("INSERT INTO ".$this->dt_keys."(fk_user, key_type, session_key, is_active, request_ip) VALUES('".$user."', '".$this->key_mail_edit."', ?, '1', '".$this->f_te($thenewip)."')", $bind);
				return true;
			} elseif($this->key_session == $type) {
				if(!$this->multi_login) {
					$this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE key_type = '".$this->key_session."' AND fk_user = '".$user."'");
					if(!$this->log_session) {
						$this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE key_type = '".$this->key_session."' AND fk_user = '".$user."'");
					} 
				} else {
					if(!$this->log_session) {
						$this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE key_type = '".$this->key_session."' AND fk_user = '".$user."' AND is_active = 0");
					} 
				}
				if($this->log_ip) { $thenewip = @$_SERVER["REMOTE_ADDR"]; } else { $thenewip = "hidden"; }
				$this->mysql->query("INSERT INTO ".$this->dt_keys."(fk_user, key_type, session_key, is_active, request_ip, refresh_date) VALUES('".$user."', '".$this->key_session."', ?, '1', '".$this->f_te($thenewip)."', CURRENT_TIMESTAMP())", $bind);
				return true;
			} elseif($this->key_recover == $type) {
				$this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE key_type = '".$this->key_recover."' AND fk_user = '".$user."'");
				if(!$this->log_recover) {
					$this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE key_type = '".$this->key_recover."' AND fk_user = '".$user."'");
				} 		
				if($this->log_ip) {$thenewip = @$_SERVER["REMOTE_ADDR"];} else {$thenewip = "hidden";}
				$this->mysql->query("INSERT INTO ".$this->dt_keys."(fk_user, key_type, session_key, is_active, request_ip) VALUES('".$user."', '".$this->key_recover."', ?, '1', '".$this->f_te($thenewip)."')", $bind);
				return true;
			} elseif($this->key_activation == $type) {
				$this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE key_type = '".$this->key_activation."' AND fk_user = '".$user."'");
				if(!$this->log_activation) {
					$this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE key_type = '".$this->key_activation."' AND fk_user = '".$user."'");
				} 		
				if($this->log_ip) {$thenewip = @$_SERVER["REMOTE_ADDR"];} else {$thenewip = "hidden";}
				$this->mysql->query("INSERT INTO ".$this->dt_keys."(fk_user, key_type, session_key, is_active, request_ip) VALUES('".$user."', '".$this->key_activation."', ?, '1', '".$this->f_te($thenewip)."')", $bind);
				return true;
			}
		} return false;
	}	

	## Session Function to Logout A Session
	private function session_logout() {
		if(!is_numeric($_SESSION[$this->sessions."x_users_id"])) { return false; }
		if($this->multi_login) { $ext = "AND session_key = '".f_te($_SESSION[$this->sessions."x_users_key"])."' "; } else {$ext = " ";}
		if(!$this->log_session) {$this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE key_type = '".$this->key_session."' AND fk_user = '".@$_SESSION[$this->sessions."x_users_id"]."' ".$ext);
		} else { $this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE key_type = '".$this->key_session."' AND fk_user = '".@$_SESSION[$this->sessions."x_users_id"]."' AND is_active = 1 ".$ext); } 
	}

	## Session Function to Restore
	private function session_restore(){
		if(is_numeric($_SESSION[$this->sessions."x_users_id"])) {
			$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE user_confirmed = '1' AND user_blocked <> 1 AND id = '".$_SESSION[$this->sessions."x_users_id"]."'");
			if($cr = $this->mysqli_object_fetch($r)){
				$this->object_user_set($cr["id"]);
				$this->mysql->query("UPDATE ".$this->dt_keys." SET refresh_date = CURRENT_TIMESTAMP() WHERE fk_user = '".$cr["id"]."' AND session_key = \"".$this->f_te(@$_SESSION[$this->sessions."x_users_key"])."\" AND is_active = 1 AND key_type = '".$this->key_session."'"); 
				return true;
			} else {
				$this->object_user_unset();
				$this->cookie_unset();
				return false;
			}
		} else {
			$this->object_user_unset();
			$this->cookie_unset();
			return false;		
		}
	}
	
	## Logout Function
	public function logout() {
		@$this->session_logout();
		@$this->cookie_unset();
		@$this->object_user_unset();
		return true;
	}

	## Init Function
	public function init() {
		if($this->login_field == "user_name") { $this->user_unique = true; }
		if($this->login_field == "user_mail") { $this->mail_unique = true; }
		if(@$_SESSION[$this->sessions."x_users_ip"] == @$_SERVER["REMOTE_ADDR"]
			AND isset($_SESSION[$this->sessions."x_users_key"])
			AND is_bool($_SESSION[$this->sessions."x_users_stay"])
			AND is_numeric($_SESSION[$this->sessions."x_users_id"])) {
				if(!$this->session_token_valid($_SESSION[$this->sessions."x_users_id"], $_SESSION[$this->sessions."x_users_key"])) {
					$this->object_user_unset();
					$this->cookie_restore();} 
				else { $this->session_restore(); }
		} else {
			$this->object_user_unset();
			$this->cookie_restore(); }				
	}	
	
	## Object Restore
	private function object_user_unset() {
		$tmp = array();
		unset($_SESSION[$this->sessions."x_users_ip"]);
		unset($_SESSION[$this->sessions."x_users_key"]);
		unset($_SESSION[$this->sessions."x_users_id"]);
		unset($_SESSION[$this->sessions."x_users_stay"]);
		$tmp["x_users_key"]		=	false;
		$tmp["x_users_stay"]	=	false;
		$tmp["x_users_ip"]		=	false;
		$tmp["x_users_id"]		=	false;
		$tmp["loggedIn"]		=	false;
		$tmp["loggedin"]		=	false;
		$this->user_rank = false;
		$this->rank = false;
		$this->user_id = false;
		$this->id = false;
		$this->user_name = false;
		$this->name = false;
		$this->user_mail = false;
		$this->mail = false;
		$this->loggedIn = false;
		$this->loggedin = false;
		$this->user_loggedIn = false;
		$this->user_loggedin = false;
		$this->info = false;
		//$this->fields = false;
		$this->perm = false;
		$this->user = false;
		$this->misc = false;
	}
	private function object_user_set($userid) {
		if(!$this->exists($userid)) { return false; }
		$tmp = $this->get($userid);
		$tmp["x_users_key"]		=	@$_SESSION[$this->sessions."x_users_key"];
		$tmp["x_users_stay"]	=	@$_SESSION[$this->sessions."x_users_stay"];
		$tmp["x_users_ip"]		=	@$_SESSION[$this->sessions."x_users_ip"];
		$tmp["x_users_id"]		=	@$_SESSION[$this->sessions."x_users_id"];
		$tmp["loggedIn"]		=	true;
		$tmp["loggedin"]		=	true;
		$this->user_rank = $tmp["user_rank"];
		$this->rank = $tmp["user_rank"];
		$this->user_id = $tmp["x_users_id"];
		$this->id = $tmp["x_users_id"];
		$this->user_name = $tmp["user_name"];
		$this->name = $tmp["user_name"];
		$this->user_mail = $tmp["user_mail"];
		$this->mail = $tmp["user_mail"];
		$this->loggedIn = true;
		$this->loggedin = true;
		$this->user_loggedIn = true;
		$this->user_loggedin = true;
		$this->info = $tmp;
		//$this->fields = GET ALL IN ARRAY;
		$this->user = $tmp;
		if( is_object($this->perm) ) { $this->perm->initPerm($userid); }
	}

	// Constructor of the Control Class
	function __construct($mysqlcon, $table_users, $table_sessions, $preecokie = "x_users_") {
		// Init Variables for Runtime
		$this->sessions 		=   $preecokie;	
		$this->mysql			=	$mysqlcon;
		$this->dt_users			=	$table_users;
		$this->dt_keys			=	$table_sessions;
		// Start Session if not Exists and Ban Var Initialize if Not Initialized
		if (session_status() !== PHP_SESSION_ACTIVE) { @session_start(); }
		
		$val = false; try {
			$val = $this->mysql->query('SELECT 1 FROM `'.$this->dt_users.'`');
		} catch (Exception $e){ 
			 $this->create_table();
		} if($val === FALSE) { $this->create_table();}

		$val = false; try {
			$val = $this->mysql->query('SELECT 1 FROM `'.$this->dt_keys.'`');
		} catch (Exception $e){ 
			 $this->create_table();
		} if($val === FALSE) { $this->create_table();}
		
		/*if($this->dt_fields) { $val = false; try {
			$val = $this->mysql->query('SELECT 1 FROM `'.$this->dt_fields.'`');
		} catch (Exception $e){ 
			 $this->create_table();
		} if($val === FALSE) { $this->create_table();} }*/
	}
	
	/*	___________     ___.   .__                 
		\__    ___/____ \_ |__ |  |   ____   ______
		  |    |  \__  \ | __ \|  | _/ __ \ /  ___/
		  |    |   / __ \| \_\ \  |_\  ___/ \___ \ 
		  |____|  (____  /___  /____/\___  >____  >
					   \/    \/          \/     \/ */
	private function create_table() {
			$this->mysql->query("CREATE TABLE IF NOT EXISTS `".$this->dt_users."` (
											  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
											  `user_name` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'undefined' COMMENT 'Users Name for Login if Ref',
											  `user_pass` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Users Pass for Login',
											  `user_mail` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Users Mail for Login if Ref',
											  `user_shadow` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Users Store for Mail if Renew',
											  `user_rank` tinyint NOT NULL DEFAULT '0' COMMENT 'Users Rank',
											  `created_date` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
											  `modify_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
											  `last_reset` datetime DEFAULT NULL COMMENT 'Reset Date Counter for new Requests',
											  `last_activation` datetime DEFAULT NULL COMMENT 'Activation Date Counter for new Requests',
											  `last_mail_edit` datetime DEFAULT NULL COMMENT 'Last Mail Change Request Date',
											  `req_reset` datetime DEFAULT NULL COMMENT 'Reset Date Counter for new Requests',
											  `block_reset` int(1) DEFAULT NULL COMMENT 'Block Resets for this user',
											  `req_activation` datetime DEFAULT NULL COMMENT 'Activation Date Counter for new Requests',
											  `block_activation` int(1) DEFAULT NULL COMMENT 'Block Activation for this User',
											  `fails_in_a_row` int(10) DEFAULT 1 COMMENT 'Fail Pass Enters without Success Login',
											  `req_mail_edit` datetime DEFAULT NULL COMMENT 'Last Mail Change Request Date',
											  `block_mail_edit` datetime DEFAULT NULL COMMENT 'Block Mail Edits for this User',
											  `last_login` datetime DEFAULT NULL COMMENT 'Last Login Date',
											  `extradata` TEXT DEFAULT NULL COMMENT 'Additional Data',
											  `user_confirmed` tinyint(1) DEFAULT '0' COMMENT 'User Activation Status',
											  `user_blocked` tinyint(1) DEFAULT '0' COMMENT 'User Blocked/Disabled Status',
											  PRIMARY KEY (`id`)
											) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
			$this->mysql->query("CREATE TABLE IF NOT EXISTS `".$this->dt_keys."` (
											`id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique Session ID',
											`fk_user` int(10) NOT NULL COMMENT 'Related User ID',
											`key_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 1 - activate 2 - session 3 - recover 4 - mailchange',
											`creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date for max Session Days',
											`modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
											`refresh_date` datetime DEFAULT NULL COMMENT 'Last Use Date set by session_restore!',
											`session_key` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Session Authentification Token and Key!',
											`is_active` tinyint(1) DEFAULT '0' COMMENT '1 - Active 0 - Expired!',
											`request_ip` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Requested IP if enabled set at creation!',
											`execute_ip` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Executed IP if enabled set at Invalidation!',
											PRIMARY KEY (`id`)
										) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");	
			/*if($this->dt_fields) { $this->mysql->query("CREATE TABLE IF NOT EXISTS `".$this->dt_fields."` (
											`id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique Session ID',
											`fk_user` int(10) NOT NULL COMMENT 'Related User ID',
											`creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date for max Session Days',
											`modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
											PRIMARY KEY (`id`)
											) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");}		*/								
	}
	
	/* . ____                 .__        
		|    |    ____   ____ |__| ____  
		|    |   /  _ \ / ___\|  |/    \ 
		|    |__(  <_> ) /_/  >  |   |  \
		|_______ \____/\___  /|__|___|  /
				\/    /_____/         \/ */
	public function login_request($ref, $password, $stayLoggedIn = false) {
		$this->ref = array();
		$this->login_request_code = false;
		$this->mail_ref_user = false;
		$this->mail_ref_token = false;
		$this->mail_ref_receiver = false;	
		$bind[0]["value"] = $ref;
		$bind[0]["type"] = "s";
		$r	=	$this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE LOWER(".$this->login_field.") = ?", $bind);
		if( $f = $this->mysqli_object_fetch($r) ) {					
			if ( (strtolower($f[$this->login_field]) == strtolower($ref) AND $this->password_check($password, $f["user_pass"])) ) {
				if($f["user_blocked"] == 1) { $this->login_request_code = 4; return 4; } 
				if($f["user_confirmed"] != 1) { $this->login_request_code = 5; return 5; } 
				$newtoken	=	$this->session_gen(32);
				while($this->session_token_valid($f["id"], $newtoken)) {$newtoken =	$this->session_gen(32);}
				$this->session_token_create($f["id"], $newtoken);
				if($stayLoggedIn) { $this->cookie_add($f["id"], $newtoken); }
				$_SESSION[$this->sessions."x_users_ip"]  = @$_SERVER["REMOTE_ADDR"];
				$_SESSION[$this->sessions."x_users_key"] = $newtoken;
				$_SESSION[$this->sessions."x_users_id"]  = $f["id"];
				if($stayLoggedIn) { $_SESSION[$this->sessions."x_users_stay"]  = true; } else { $_SESSION[$this->sessions."x_users_stay"] = false; }
				$this->object_user_set($f["id"]);
				$this->mysql->query("UPDATE ".$this->dt_users." SET last_login = CURRENT_TIMESTAMP() WHERE id = '".$f["id"]."'");
				if($this->login_recover_drop) {
				 if(!$this->log_recover) {
					 $this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE fk_user = '".$f["id"]."' AND key_type = '".$this->key_recover."'");
					} else {
					 $this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE fk_user = '".$f["id"]."' AND key_type = '".$this->key_recover."'");
				 }
				}
				$this->ref				= $f;
				$this->mysql->query("UPDATE ".$this->dt_users." SET fails_in_a_row = 0 WHERE id = '".$f["id"]."'");
				$this->login_request_code = 1;
				return 1;
			} else { $this->mysql->query("UPDATE ".$this->dt_users." SET fails_in_a_row = fails_in_a_row + 1 WHERE id = '".$f["id"]."'");  
				if(is_numeric($this->autoblock)) {
					if($f["fails_in_a_row"] > $this->autoblock) {
						$this->block_user($f["id"]); 
						
						$this->login_request_code = 6; return 6;
					}
				}
				$this->login_request_code = 3; return 3;
			}									
		} $this->login_request_code = 2; return 2; 
	}

	/*      _____          __  .__               __  .__               
		  /  _  \   _____/  |_|__|__  _______ _/  |_|__| ____   ____  
		 /  /_\  \_/ ___\   __\  \  \/ /\__  \\   __\  |/  _ \ /    \ 
		/    |    \  \___|  | |  |\   /  / __ \|  | |  (  <_> )   |  \
		\____|__  /\___  >__| |__| \_/  (____  /__| |__|\____/|___|  /
				\/     \/                    \/                    \/    */
	public function activation_request_id($id) {
		$this->ref = false;
		$this->mail_ref_user = false;
		$this->mail_ref_token = false;
		$this->mail_ref_receiver = false;	
		$this->act_request_code = false;
		if(!is_numeric($id)) { $this->act_request_code = 2; return 2; }
		$r = $this->mysql->query("SELECT * FROM ".$this->dt_users."  WHERE id = \"".$id."\"");
		while($f=$this->mysqli_object_fetch($r)){
			if($f["user_confirmed"] == 1) { $this->act_request_code = 3; return 3; }
			$token = $this->token_gen();
			$this->activation_token_create($f["id"], $token);
			$this->ref				= $f["id"];
			$this->ref["token"] 	= $token;
			
			$this->mail_ref_user = $f["id"];
			$this->mail_ref_token = $token;
			$this->mail_ref_receiver = $f["user_mail"];
			
			$this->act_request_code = 1; return 1;
		} $this->act_request_code = 2;return 2;
	}

	public function activation_request($ref) { 
		$this->ref = false;
		$this->mail_ref_user = false;
		$this->mail_ref_token = false;
		$this->mail_ref_receiver = false;	
		$this->act_request_code = false;
		$bind[0]["value"] = $ref;
		$bind[0]["type"] = "s";
		$r = $this->mysql->query("SELECT * FROM ".$this->dt_users."  WHERE LOWER(".$this->login_field.") = ?", $bind);
		while($f=$this->mysqli_object_fetch($r)){
			if($f["user_confirmed"] == 1) { $this->act_request_code = 4; return 4; }
			if(is_numeric($this->wait_activation_min)) {
				if(isset($f["req_activation"])) { if ($this->check_interval($f["req_activation"], '-'.$this->wait_activation_min.' minutes')) {$this->act_request_code = 3; return 3;}}
			}
			if($f["block_activation"] == 1) {  $this->act_request_code = 5; return 5; }
			$this->mysql->query("UPDATE ".$this->dt_users." SET req_activation = CURRENT_TIMESTAMP() WHERE id = '".$f["id"]."'");
			$token = $this->token_gen();
			$this->activation_token_create($f["id"], $token);
			$this->ref				= $f["id"];
			$this->ref["token"] 	= $token;
			
			$this->mail_ref_user = $f["id"];
			$this->mail_ref_token = $token;
			$this->mail_ref_receiver = $f["user_mail"];
			
			$this->act_request_code = 1;return 1;
		} $this->act_request_code = 2; return 2;
	}
	
	public function activation_confirm($userid, $token) {
		$this->ref = false;
		$this->act_request_code = false;
		$this->mail_ref_user = false;
		$this->mail_ref_token = false;
		$this->mail_ref_receiver = false;	
		$bind[0]["value"] = $token;
		$bind[0]["type"] = "s";
		if(!is_numeric($userid)) { $this->act_request_code = 2; return 2; }
		$r = $this->mysql->query("SELECT * FROM ".$this->dt_keys." WHERE session_key = ? AND key_type = '".$this->key_recover."' AND fk_user = '".$userid."' AND is_active = 1", $bind);
		if($f= $this->mysqli_object_fetch($r)){
			if($f["block_activation"] == 1) {  $this->act_request_code = 4; return 4; }
			if(!$this->activation_token_valid($userid, $token)) { $this->act_request_code = 3; return 3;}
			if($this->log_activation) {$this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE fk_user = ".$f["fk_user"]." AND key_type = '".$this->key_activation."'");	
			} else { $this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE fk_user = ".$f["fk_user"]." AND key_type = '".$this->key_activation."'");}
			$this->ref				= $f;
			$this->mysql->query("UPDATE ".$this->dt_users." SET last_activation = CURRENT_TIMESTAMP() WHERE id = '".$userid."'");
			$this->mysql->query("UPDATE ".$this->dt_users." SET user_confirmed = 1 WHERE id = '".$userid."'");
			$this->act_request_code = 1; return 1;
		} else { $this->act_request_code = 2; return 2; }
	}

	/* 	__________                                       
		\______   \ ____   ____  _______  __ ___________ 
		 |       _// __ \_/ ___\/  _ \  \/ // __ \_  __ \
		 |    |   \  ___/\  \__(  <_> )   /\  ___/|  | \/
		 |____|_  /\___  >\___  >____/ \_/  \___  >__|   
				\/     \/     \/                \/  	*/
	public function recover_request_id($id) {
		$this->ref = false;
		$this->mail_ref_user = false;
		$this->mail_ref_token = false;
		$this->mail_ref_receiver = false;	
		$this->rec_request_code = false;
		if(!is_numeric($id)) { $this->rec_request_code = 2; return 2; }
		$r = $this->mysql->query("SELECT * FROM ".$this->dt_users."  WHERE id = \"".$id."\"");
		while($f=$this->mysqli_object_fetch($r)){
			$token = $this->token_gen();
			$this->recover_token_create($f["id"], $token);
			$this->ref				= $f;
			$this->ref["token"] 	= $token;
			
			$this->mail_ref_user = $f["id"];
			$this->mail_ref_token = $token;
			$this->mail_ref_receiver = $f["user_mail"];
			
			$this->rec_request_code = 1; return 1;
		} $this->rec_request_code = 2; return 2;
	}	

	public function recover_request($ref) { 
		$this->ref = false;
		$this->mail_ref_user = false;
		$this->mail_ref_token = false;
		$this->mail_ref_receiver = false;	
		$this->rec_request_code = false;
		$bind[0]["value"] = $ref;
		$bind[0]["type"] = "s";
		$r = $this->mysql->query("SELECT * FROM ".$this->dt_users."  WHERE LOWER(".$this->login_field.") = ?", $bind);
		while($f=$this->mysqli_object_fetch($r)){
			if($f["block_reset"] == 1) {  $this->rec_request_code = 4; return 4; }
			if(is_numeric($this->wait_recover_min)) {
				if(isset($f["req_reset"])) { if ($this->check_interval($f["req_activation"], '-'.$this->wait_recover_min.' minutes')) {$this->rec_request_code = 3;return 3;}}
			}
			$this->mysql->query("UPDATE ".$this->dt_users." SET req_reset = CURRENT_TIMESTAMP() WHERE id = '".$f["id"]."'");
			$token = $this->token_gen();
			$this->recover_token_create($f["id"], $token);
			$this->ref				= $f;
			$this->ref["token"] 	= $token;
		
			$this->mail_ref_user = $f["id"];
			$this->mail_ref_token = $token;
			$this->mail_ref_receiver = $f["user_mail"];
			
			$this->rec_request_code = 1; return 1;
		} $this->rec_request_code = 2;return 2;
	}	

	public function recover_confirm($userid, $token, $newpass) {
		$this->ref = false;
		$this->rec_request_code = false;
		$this->mail_ref_user = false;
		$this->mail_ref_token = false;
		$this->mail_ref_receiver = false;	
		$bind[0]["value"] = $token;
		$bind[0]["type"] = "s";
		if(!is_numeric($userid)) { $this->rec_request_code = 2; return false; }
		$r = $this->mysql->query("SELECT * FROM ".$this->dt_keys." WHERE session_key = ? AND key_type = '".$this->key_recover."' AND fk_user = '".$userid."' AND is_active = 1", $bind);
		if($f= $this->mysqli_object_fetch($r)){
			if($f["block_reset"] == 1) {  $this->rec_request_code = 4; return 4; }
			if(!$this->recover_token_valid($userid, $token)) { $this->rec_request_code = 3; return 3; }
			if($this->log_recover) {$this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE fk_user = ".$f["fk_user"]." AND key_type = '".$this->key_recover."'");	
			} else { $this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE fk_user = ".$f["fk_user"]." AND key_type = '".$this->key_recover."'");}			
			$this->ref				= $f;
			$this->mysql->query("UPDATE ".$this->dt_users." SET last_reset = CURRENT_TIMESTAMP() WHERE id = '".$userid."'");
			$this->mysql->query("UPDATE ".$this->dt_users." SET last_activation = CURRENT_TIMESTAMP() WHERE id = '".$userid."' AND activation_date IS NULL");
			$this->mysql->query("UPDATE ".$this->dt_users." SET user_confirmed = 1 WHERE id = '".$userid."'");
			$this->changeUserPass($f["fk_user"], $newpass);
			$this->rec_request_code = 1; return 1;
		} else {$this->rec_request_code = 2; return 2;}
	}	
	
	/*      _____         .__.__    ___________    .___.__  __   
		  /     \ _____  |__|  |   \_   _____/  __| _/|__|/  |_ 
		 /  \ /  \\__  \ |  |  |    |    __)_  / __ | |  \   __\
		/    Y    \/ __ \|  |  |__  |        \/ /_/ | |  ||  |  
		\____|__  (____  /__|____/ /_______  /\____ | |__||__|  
				\/     \/                  \/      \/         */
	public function mail_edit($id, $newmail, $nointervall = false) {
		$this->ref = false;
		$this->mail_ref_user = false;
		$this->mail_ref_token = false;
		$this->mail_ref_receiver = false;		
		
		$this->mc_request_code = false;
		if(!is_numeric($id)) { $this->mc_request_code = 2;return 2; }				
		$bind[0]["value"] = trim(strtolower($newmail));
		$bind[0]["type"] = "s";		
		if($this->mail_unique) { 
			$r = $this->mysql->query("SELECT * FROM ".$this->dt_users." WHERE LOWER(user_mail) LIKE ? AND user_confirmed = 1", $bind);
			if($f=$this->mysqli_object_fetch($r)){	$this->mc_request_code = 4; return 4; } 				
		}
		
		$r = $this->mysql->query("SELECT * FROM ".$this->dt_users."  WHERE id = \"".$id."\"");
		if($f=$this->mysqli_object_fetch($r)){
			if($f["block_mail_edit"] == 1) {  $this->mc_request_code = 5; return 5; }
			if(!$nointervall) { if(is_numeric($this->wait_activation_min)) {if(isset($f["req_mail_edit"])) {if ($this->check_interval($f["req_mail_edit"], '-'.$this->wait_activation_min.' minutes')) {$this->mc_request_code = 3;return 3; }}} }
			if($this->log_mail_edit) {$this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE fk_user = ".$f["id"]." AND key_type = '".$this->key_mail_edit."'");	
			} else { $this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE fk_user = ".$f["id"]." AND key_type = '".$this->key_mail_edit."'");};
			$this->mysql->query("UPDATE ".$this->dt_users." SET req_mail_edit = CURRENT_TIMESTAMP() WHERE id = '".$userid."'");
			$this->changeUserShadowMail($id, $newmail);
			$token	=	$this->token_gen();
			$this->mail_edit_token_create($f["id"], $token);
			$this->ref				= $f;
			$this->ref["token"] 	= $token;				
			$this->ref["user_shadow"] 	= trim(strtolower($newmail));

			$this->mail_ref_user = $f["id"];
			$this->mail_ref_token = $token;
			$this->mail_ref_receiver = trim(strtolower($newmail));
			
			$this->mc_request_code = 1; return 1;
		} $this->mc_request_code = 2; return 2;
	}

	public function mail_edit_confirm($userid, $token, $run = true, $runifdata = false) {
		if($run) {
			if($runifdata AND ((trim($userid) == "" OR $userid == false) OR (trim($token) == "" OR $token == false))) { return false; }
			$bind[0]["value"] = $token;
			$bind[0]["type"] = "s";		
			$this->ref = false;
			$this->mc_request_code = false;
			$this->mail_ref_user = false;
			$this->mail_ref_token = false;
			$this->mail_ref_receiver = false;	
			if(!is_numeric($userid)) { $this->mc_request_code = 2; return 2; }
				
			$r = $this->mysql->query("SELECT * FROM ".$this->dt_keys." WHERE session_key = ? AND key_type = '".$this->key_mail_edit."' AND fk_user = '".$userid."' AND is_active = 1", $bind);
			if($f= $this->mysqli_object_fetch($r)){
				if($f["block_mail_edit"] == 1) {  $this->mc_request_code = 5; return 5; }
				if(!$this->mail_edit_token_valid($userid, $token)) { $this->mc_request_code = 3; return 3; }
				if($this->log_mail_edit) {$this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE fk_user = ".$f["fk_user"]." AND key_type = '".$this->key_mail_edit."'");	
				} else { $this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE fk_user = ".$f["fk_user"]." AND key_type = '".$this->key_mail_edit."'");}	
				
				$x = $this->mysql->query("SELECT * FROM ".$this->dt_users."  WHERE id = \"".$userid."\"");
				if($xf=$this->mysqli_object_fetch($x)) {
						if($xf["user_shadow"] == NULL OR trim($xf["user_shadow"]) == "") { $this->mc_request_code = 4; return 4;  }
						if(!$this->mail_unique) { 
							$this->mysql->query("UPDATE ".$this->dt_users." SET last_mail_edit = CURRENT_TIMESTAMP() WHERE id = '".$xf["id"]."'");
							$this->changeUserMail($f["fk_user"], $xf["user_shadow"]);
							$this->mysql->query("UPDATE ".$this->dt_users." SET user_shadow = NULL WHERE id = '".$userid."'");
						} else {
							$this->mysql->query("UPDATE ".$this->dt_users." SET last_mail_edit = CURRENT_TIMESTAMP() WHERE id = '".$xf["id"]."'");
							$this->mysql->query("UPDATE ".$this->dt_users." SET user_shadow = NULL WHERE user_shadow = '".$this->f_tel($xf["user_shadow"])."'");					
						}
						$this->ref				= $xf;
					}
				 $this->mc_request_code = 1; return 1;
			} else { $this->mc_request_code = 2; return 2;}
		}
	}

	/*	________  .__               .__                
		\______ \ |__| ____________ |  | _____  ___.__.
		 |    |  \|  |/  ___/\____ \|  | \__  \<   |  |
		 |    `   \  |\___ \ |  |_> >  |__/ __ \\___  |
		/_______  /__/____  >|   __/|____(____  / ____|
				\/        \/ |__|             \/\/    	*/
		// Display Messages
		public $display_return_code	=	false;
		public $display_return_type	=	false;
		
		// Internal Function to set Messages
		private function display_message_set($code, $type) {$this->display_return = $code;}	
		
		// Display Recover Window
		function display_recover($title, $backbuttonurl = false, $reference = "Mail", $buttonstring = "Reset Password", $buttonbackstring = "Back to Login") {
			if (isset($_POST["x_class_user_submit_recover"])) {
				if (!empty($_POST["x_class_user_reference"]) AND trim($_POST["x_class_user_reference"]) != "") {
					if ($_SESSION["x_class_user_csrf"] == $_POST["x_class_user_csrf"] AND trim($_POST["x_class_user_csrf"]) != "" AND isset($_POST["x_class_user_csrf"])) {
						$req_return = $object["user"]->recover_request($_POST["x_class_user_reference"]);		
						if ($this->rec_request_code == 1 AND $req_return == 1) { $this->display_message_set("ok", "ok"); return true; }
						if ($this->rec_request_code == 2 AND $req_return == 2) { $this->display_message_set("unknown", "error"); return true; }
						if ($this->rec_request_code == 3 AND $req_return == 3) { $this->display_message_set("interval", "error"); return true; }
						if ($this->rec_request_code == 4 AND $req_return == 4) { $this->display_message_set("blocked", "error"); return true; }
					} else { $this->display_message_set("expired", "error"); return true; }		
				} else { $this->display_message_set("empty", "error"); return true; }
			}  ?>
			<div class="x_class_user_login"><div class="x_class_user_login_title"><?php $csrf = mt_rand(10000,999999); $_SESSION["x_class_user_csrf"] = $csrf; echo $title; ?></div><div class="x_class_user_login_inner"><form method="post"><input type="hidden" name="x_class_user_csrf" value="<?php echo $csrf; ?>">
				<div class="x_class_user_login_group">
					<label class="x_class_user_login_label"><?php echo $reference; ?></label><br />
					<input type="text" maxlength="255" placeholder="<?php echo $reference; ?>" name="x_class_user_reference" class="x_class_user_input" tabindex="1" autofocus="autofocus">
				</div>				
				<div class="x_class_user_form_group">			
					<input type="submit" class="x_class_user_input" value="<?php echo $buttonstring; ?>" tabindex="2" name="x_class_user_submit_recover">
					<?php if($backbuttonurl) { ?>	<br /><a class="x_class_user_link" href="<?php echo $backbuttonurl; ?>"><?php echo $buttonbackstring; ?></a> <?php } ?>
				</div>	
			</form></div></div><?php
		}	
		
		// Display Login
		public function display_login($registerbuttonurl = false, $registerbuttonstring = "Register", $cookiecheckbox = false, $resetbuttonurl = false, $resetbuttonstring = "Reset",  $title = "Login", $label = "E-Mail") {			
			if (isset($_POST["x_class_user_submit_login"])) {
				if (!empty($_POST["x_class_user_ref"]) AND !empty($_POST["x_class_user_pass"])) {
					if ($_SESSION["x_class_user_csrf"] == $_POST["x_class_user_csrf"] AND trim($_POST["x_class_user_csrf"]) != "" AND isset($_POST["x_class_user_csrf"])) {
						$result = $this->login_request($_POST["x_class_user_ref"], $_POST["x_class_user_pass"], $_POST["x_class_user_submit_login_stay"]);
						if ($result == 1 AND $this->login_request_code = 1 ) { $this->display_message_set("ok", "ok"); return true; }
						if ($result == 2 AND $this->login_request_code = 2 ) { $this->display_message_set("unknown", "error"); return true; }
						if ($result == 3 AND $this->login_request_code = 3 ) { $this->display_message_set("wrongpass", "error"); return true; }
						if ($result == 4 AND $this->login_request_code = 4 ) { $this->display_message_set("blocked", "error"); return true; }
						if ($result == 5 AND $this->login_request_code = 5 ) { $this->display_message_set("unconfirmed", "error"); return true; }
					} else { $this->display_message_set("expired", "error");  return true; }
				} else { $this->display_message_set("empty", "error"); return true;  }
			}?>
			<div class="x_class_user_login"><div class="x_class_user_login_title"><?php $csrf = mt_rand(10000,999999); $_SESSION["x_class_user_csrf"] = $csrf; echo $title; ?></div><div class="x_class_user_login_inner"><form method="post"><input type="hidden" name="x_class_user_csrf" value="<?php echo $csrf; ?>">
				<div class="x_class_user_login_group">
					<label class="x_class_user_login_label"><?php echo $label; ?></label><br />
					<input type="text" maxlength="255" tabindex="1" placeholder="Please enter your <?php echo $label; ?>!" name="x_class_user_ref" autofocus="autofocus"><br />
					<label class="x_class_user_login_label">Password:</label ><br />	
					<input type="password" maxlength="128" tabindex="2" placeholder="Please enter your password!" name="x_class_user_pass" autocomplete="off">	
				</div>					
				<div class="x_class_user_form_group">
					<input type="submit" value="Login" tabindex="3" name="x_class_user_submit_login">
					<?php if($cookiecheckbox) { ?> 	<input type="checkbox" name="x_class_user_submit_login_stay"> <?php } ?>
					<?php if($registerbuttonurl) { ?>	<br /><a class="x_class_user_link" href="<?php echo $registerbuttonurl; ?>"><?php echo $registerbuttonstring; ?></a> <?php } ?>
					<?php if($resetbuttonurl) { ?>	<br /><a class="x_class_user_link" href="<?php echo $resetbuttonurl; ?>"><?php echo $resetbuttonstring; ?></a> <?php } ?>
				</div>
			</form></div></div><?php
		}	
	
		// Display Activation Form With Password Set
		function display_reset($title = "Reset", $backbuttonurl = false, $buttonbackstring = "Back to Login") {	
				if ($this->recover_token_valid($_GET["x_class_user_rec_user"], $_GET["x_class_user_rec_token"])) {
					if(isset($_POST["x_class_user_submit_reset"])) {
						if ($_SESSION["x_class_user_csrf"] == $_POST["x_class_user_csrf"] AND trim($_POST["x_class_user_csrf"]) != "" AND isset($_POST["x_class_user_csrf"])) {
							if ($_POST["x_class_user_pass"] == $_POST["x_class_user_pass_confirm"] and trim($_POST["x_class_user_pass"]) != "") {
								$resq	=	$this->recover_confirm($_POST["x_class_user_rec_user"], $_POST["x_class_user_rec_token"], $_POST["x_class_user_pass"]);
								if ($this->rec_request_code == 1 AND $resq == 1) { $this->display_message_set("ok", "ok"); return true; }
								if ($this->rec_request_code == 2 AND $resq == 2) { $this->display_message_set("unknown", "error"); return true; }
								if ($this->rec_request_code == 3 AND $resq == 3) { $this->display_message_set("interval", "error"); return true; }
								if ($this->rec_request_code == 4 AND $resq == 4) { $this->display_message_set("blocked", "error"); return true; }
							} else { if ($_POST["x_class_user_pass"] != $_POST["x_class_user_pass_confirm"]) { $this->display_message_set("passmatch", "error"); return true; } else { $this->display_message_set("empty", "error"); return true; } } 
						} else { $this->display_message_set("expired", "error"); return true; } 
					}
				} else { $this->display_message_set("interval", "error"); return true; } 
			?>
			<div class="x_class_user_login"><div class="x_class_user_login_title"><?php $csrf = mt_rand(10000,999999); $_SESSION["x_class_user_csrf"] = $csrf; echo $title; ?></div><div class="x_class_user_login_inner"><form method="post"><input type="hidden" name="x_class_user_csrf" value="<?php echo $csrf; ?>">
				<input type="hidden" name="x_class_user_rec_token" value="<?php echo @$_GET["x_class_user_rec_token"]; ?>">
				<input type="hidden" name="x_class_user_rec_user" value="<?php echo @$_GET["x_class_user_rec_user"]; ?>">		
				<div class="x_class_user_login_group">
					<label class="x_class_user_login_label">Password:</label><br />
					<input type="password" maxlength="128" tabindex="1" placeholder="Please enter your password!" name="x_class_user_pass" autocomplete="off">	
					<label class="x_class_user_login_label">Password Confirmation:</label><br />
					<input type="password" maxlength="128" tabindex="2" placeholder="Please enter your password!" name="x_class_user_pass_confirm" autocomplete="off">	
				</div>		
				<div class="x_class_user_form_group">
					<input type="submit" value="Login" tabindex="3" name="x_class_user_submit_reset">
					<?php if($backbuttonurl) { ?>	<br /><a class="x_class_user_link" href="<?php echo $backbuttonurl; ?>"><?php echo $buttonbackstring; ?></a> <?php } ?>
				</div>	
			</form></div></div><?php
		}	
		
		// Display Recover
		function display_register_unique_mail($title = "Register", $backbuttonurl = false, $buttonbackstring = "Back to Login", $needusername = false, $captchaurl = false, $captchakey = false, $rank = 0, $confirmed = 0) {
				if (isset($_POST["x_class_user_submit_register"])) {
					if (!empty($_POST["x_class_user_mail"]) AND !empty($_POST["x_class_user_pass"])) {
						if ($captchakey == $_POST["x_class_user_csrf"] AND trim($_POST["x_class_user_csrf"]) != "" AND isset($_POST["x_class_user_csrf"])) {
							if(($needusername AND isset($_POST["x_class_user_name"]) AND trim($_POST["x_class_user_name"])) != "" OR (!$needusername)) {
								if(!$needusername) { $_POST["x_class_user_name"] = "undefined";}
								if(addUser($name, $_POST["x_class_user_mail"], $_POST["x_class_user_pass"], $rank, $confirmed, true)) { $this->display_message_set("ok", "ok"); return true; }
								else {$this->display_message_set("error", "error"); return true; }
							
							} else { $this->display_message_set("empty", "error"); return true; }
						} else { $this->display_message_set("expired", "error"); return true; }
					} else { $this->display_message_set("empty", "error"); return true; }
				}
			?>
			<div class="x_class_user_login"><div class="x_class_user_login_title"><?php $csrf = mt_rand(10000,999999); $_SESSION["x_class_user_csrf"] = $csrf; echo $title; ?></div><div class="x_class_user_login_inner"><form method="post"><input type="hidden" name="x_class_user_csrf" value="<?php echo $csrf; ?>">
				<div class="x_class_user_login_group">
						<?php if($needusername) { ?><label class="x_class_user_login_label">Username*</label><br />
						<input type="text" maxlength="255" tabindex="1" placeholder="Username" name="x_class_user_name" tabindex="1" autofocus="autofocus"><br />	<?php } ?>				

						<label class="x_class_user_login_label">E-Mail*</label><br />
						<input type="text" maxlength="255" tabindex="1" placeholder="Mail-Adress" name="x_class_user_mail" tabindex="2" autofocus="autofocus"><br />
						
						<label class="x_class_user_login_label">Password*</label><br />
						<input type="password" maxlength="128" tabindex="2" placeholder="Password" name="x_class_user_pass" tabindex="3" autocomplete="off"><br />
						
						<label class="x_class_user_login_label">Confirm Password*</label><br />
						<input type="password" maxlength="128" tabindex="2" placeholder="Confirm Password" name="x_class_user_pass_confirm" tabindex="4" autocomplete="off"><br />	

						<?php if($captchaurl) { ?><label class="x_class_user_login_label">Captcha*</label><br />
						<img src="<?php echo $captchaurl; ?>"><br />
						<input type="text" maxlength="255" tabindex="1" placeholder="Username" name="x_class_user_captcha" tabindex="1" autofocus="autofocus"><br /><?php } ?>
				</div>
				<div class="x_class_user_form_group">
					<input type="submit" value="Login" tabindex="3" name="x_class_user_submit_register">
					<?php if($backbuttonurl) { ?>	<br /><a class="x_class_user_link" href="<?php echo $backbuttonurl; ?>"><?php echo $buttonbackstring; ?></a> <?php } ?>
				</div>	
			</form></div></div><?php
		}	
	
	}
?>