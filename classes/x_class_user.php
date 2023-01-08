<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  Login and Users Control Class */
class x_class_user {    
	## Private SQL Informations
	private $mysql=false;
	private $dt_keys=false;
	private $dt_users=false;
	
	## Private Key Informations
	private $key_activation=1;
	private $key_session=2;
	private $key_recover=3;
	private $key_mail_edit=4;	
	
	## Public Function References and User Info
	public $ref=array();
	public $info=array();	
	public $user=array();	// Same as Info
	public $perm=array();	// To Save Perms

	## More Public Parameters
	public $user_rank = false;
	public $user_id = false;
	public $user_name = false;
	public $user_mail = false;
	public $loggedIn = false;
	public $user_loggedIn = false;
	
	## For Compatibility with older Class
	public $login_request_code = false;
	public $rec_request_code = false;
	
	## General Setup
	private $multi_login=false;public function multi_login($bool = false){$this->multi_login=$bool;}
	private $login_recover_drop=false;public function login_recover_drop($bool = false){$this->login_recover_drop=$bool;}
	private $login_field = "user_mail"; 
	public function login_field_manual($string) { $this->login_field = $string; }
	public function login_field_user() { $this->login_field = "user_name"; $this->user_unique = true; }
	public function login_field_mail() { $this->login_field = "user_mail"; $this->mail_unique = true; }
	private $mail_unique = false; public function mail_unique($bool = false) { $this->mail_unique = $bool; }
	private $user_unique = false; public function user_unique($bool = false) { $this->user_unique = $bool; }
	
	## Logging Setup		
	private $log_ip=false;public function log_ip($bool=false){$this->log_ip = $bool;}
	private $log_activation=false;public function log_activation($bool=false){$this->log_activation = $bool;}
	private $log_session=false;public function log_session($bool=false){$this->log_session = $bool;}
	private $log_recover=false;public function log_recover($bool=false){$this->log_recover = $bool;}
	private $log_mail_edit=false;public function log_mail_edit($bool=false){$this->log_mail_edit = $bool;}
	
	## Interval Between new Requests
	private $wait_activation_hours = 6;public function wait_activation_hours($int = 6){$this->wait_activation_hours = $int;}
	private $wait_recover_hours = 6;public function wait_recover_hours($int = 6){$this->wait_recover_hours = $int;}
	private $wait_mail_edit_hours = 6;public function wait_mail_edit_hours($int = 6){$this->wait_mail_edit_hours = $int;}
	
	## Token Expire Hours
	private $hours_activation = 6;public function hours_activation($int = 6){$this->hours_activation = $int;}
	private $hours_recover = 6;public function hours_recover($int = 6){$this->hours_recover = $int;}
	private $hours_mail_edit = 6;public function hours_mail_edit($int = 6){$this->hours_mail_edit = $int;}
	
	## Sessions Setup
	private $sessions = "x_users";
	private $sessions_days = 7; public function sessions_days($int = 7){$this->sessions_days = $int;}	
	
	## Cookie Setup		
	private $cookies = false;private $cookies_use = false;public function cookies_use($bool = false){$this->cookies_use = $bool;$this->cookies = $this->sessions;}
	private $cookies_days = 7;public function cookies_days($int = 7){$this->cookies_days = $int;}
	
	## Token Setup & Password Functions
	private $token_charset = "0123456789"; public function token_charset($charset = "0123456789") { $this->token_charset = $charset; }
	private $token_length = 24; public function token_length($length = 24) { $this->token_length = $length; }
	private function token_gen() { return $this->password_gen($this->token_length, $this->token_charset); }
	private $session_charset = "QAYXSWEDCVFRTGBNHZUJMKIOLPabcdefghijklmnopqrstuvwxyz0123456789"; public function session_charset($charset = "QAYXSWEDCVFRTGBNHZUJMKIOLPabcdefghijklmnopqrstuvwxyz0123456789") { $this->session_charset = $charset; }
	private $session_length = 24; public function session_length($length = 24) { $this->session_length = $length; }		
	private function session_gen() { return $this->password_gen($this->session_length, $this->session_charset); }	
	public function password_gen($len = 12, $comb = "abcde12345"){$pass = array(); $combLen = strlen($comb) - 1; for ($i = 0; $i < $len; $i++) { $n = mt_rand(0, $combLen); $pass[] = $comb[$n]; } return implode($pass);}			
	public function password_crypt($var, $hash = PASSWORD_BCRYPT) { return password_hash($var,$hash); }
	public function password_check($cleartext, $crypted) { return password_verify($cleartext,$crypted); }	
	
	## Cookies Functions
	private function cookie_set($id, $key){if($this->cookies_use){setcookie($this->cookies."session_userid", $id, time() + $this->cookies_days * 24 * 60 * 60);setcookie($this->cookies."session_key", $key, time() + $this->cookies_days * 24 * 60 * 60);} return true;}
	private function cookie_unset(){if($this->cookies_use){unset($_COOKIE[$this->cookies.'session_key']);@setcookie($this->cookies.'session_key', '', time() - 3600, '/');unset($_COOKIE[$this->cookies.'session_userid']);@setcookie($this->cookies.'session_userid', '', time() - 3600, '/');} return true;}	
	private function cookie_restore(){if($this->cookies_use){if(@is_numeric($_COOKIE[$this->cookies."session_userid"]) OR isset($_COOKIE[$this->cookies."session_key"])){if($this->session_token_valid(@$_COOKIE[$this->sessions."session_userid"], @$_COOKIE[$this->sessions."session_key"])){$_SESSION[$this->sessions."x_users_stay"] = true;$_SESSION[$this->sessions."x_users_key"] = @$_COOKIE[$this->sessions."session_key"];$_SESSION[$this->sessions."x_users_id"] = @$_COOKIE[$this->sessions."session_userid"];$_SESSION[$this->sessions."x_users_ip"] = @$_SERVER["REMOTE_ADDR"];$this->session_restore();return true;}else{$this->cookie_unset();return false;}}return false;}return true;}

	## Filter Functions
	private function f_tel($ref) { return mysqli_real_escape_string($this->mysql, strtolower(trim($ref))); }
	private function f_tl($ref) { return strtolower(trim($ref)); }
	private function f_te($ref) { return mysqli_real_escape_string($this->mysql, trim($ref)); }

	## User Functions
	public function get($id){if(is_numeric($id)){$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE id = '".$id."'");if($x=mysqli_fetch_array($r)){return $x;}}return false;}
	public function exists($id){if(!is_numeric($id)){return false;}$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE id = '".$id."'");if($rrx = mysqli_fetch_array($r)){return true;}return false;}
	public function usernameExists($ref){$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE LOWER(user_name) = \"".$this->f_tel($ref)."\"");if($rrx=mysqli_fetch_array($r)){return true;}return false;}
	public function usernameExistsActive($ref){$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE LOWER(user_name) = \"".$this->f_tel($ref)."\" AND user_confirmed = 1");if($rrx = mysqli_fetch_array($r)){return true;}return false;}	
	public function refExists($ref){$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE LOWER(".$this->login_field.") = \"".$this->f_tel($ref)."\"");if($rrx = mysqli_fetch_array($r)){return true;}return false;}
	public function refExistsActive($ref) {$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE LOWER(".$this->login_field.") = \"".$this->f_tel($ref)."\" AND user_confirmed = 1");if($rrx = mysqli_fetch_array($r)){return true;}return false;}	
	public function mailExists($ref){$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE LOWER(user_mail) = \"".$this->f_tel($ref)."\"");if($rrx=mysqli_fetch_array($r)){return true;}return false;}
	public function mailExistsActive($ref) {$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE LOWER(user_mail) = \"".$this->f_tel($ref)."\" AND user_confirmed = 1");if($rrx = mysqli_fetch_array($r)){return true;}return false;}	
	public function delete($id){if(is_numeric($id)){$this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE fk_user = '".$id."'"); return $this->mysql->query("DELETE FROM ".$this->dt_users." WHERE id = '".$id."'");}return false;}
	public function logout_all(){return $this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE key_type = '".$this->key_session."'");}
	public function disable_user_session($id){if(is_numeric($id)){return $this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE key_type = '".$this->key_session."' AND fk_user = '".$id."'");}return false;}
	public function delete_user_session($id){if(is_numeric($id)){return $this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE '".$this->key_session."' AND fk_user = '".$id."'");}return false;}
	public function blocked_user($id){if(is_numeric($id)) {$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE id = '".$id."'");if($x = mysqli_fetch_array($r)){if($x["user_blocked"] != 1){return false;}}}return true;}
	public function block_user($id){if(is_numeric($id)){return $this->mysql->query("UPDATE ".$this->dt_users." SET user_blocked = 1 WHERE id = '".$id."'");}return false;}		
	public function unblock_user($id){if(is_numeric($id)){return $this->mysql->query("UPDATE ".$this->dt_users." SET user_blocked = 0 WHERE id = '".$id."'");}return false;}
	public function confirmed_user($id){if(is_numeric($id)){$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE id = '".$id."'");if($x = mysqli_fetch_array($r)){if($x["user_confirmed"] == 1){return true;}}}return false;}	
	public function unconfirm_user($id){if(is_numeric($id)){return $this->mysql->query("UPDATE ".$this->dt_users." SET user_confirmed = 0 WHERE id = '".$id."'"); }return false;}	
	public function confirm_user($id){if(is_numeric($id)){return $this->mysql->query("UPDATE ".$this->dt_users." SET user_confirmed = 1, last_activation = CURRENT_TIMESTAMP() WHERE id = '".$id."'"); }return false;}
	public function change_rank($id, $new){if(is_numeric($id) AND is_numeric($new)){return $this->mysql->query("UPDATE ".$this->dt_users." SET user_rank = '".$new."' WHERE id = '".$id."'");}return false;}
	public function change_pass($id, $new){if(is_numeric($id) AND is_string($new)){return $this->mysql->query("UPDATE ".$this->dt_users." SET user_pass = \"".mysqli_real_escape_string($this->mysql, $this->password_crypt($new))."\" WHERE id = '".$id."'");}return false;}
	public function changeUserName($id, $new){if(is_numeric($id)){if(!$this->user_unique){ return $this->mysql->query("UPDATE ".$this->dt_users." SET user_name = '".$this->f_te($new)."' WHERE id = '".$id."'");}else{$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE id = '".$id."'");if($rrx = mysqli_fetch_array($r)){ if($this->f_tl($rrx["user_name"]) == $this->f_tl($new)){return true;}}if($this->usernameExistsActive($new)){return false;}else{return $this->mysql->query("UPDATE ".$this->dt_users." SET user_name = '".$this->f_te($new)."' WHERE id = '".$id."'");}}}return false;}					
	public function changeUserRef($id, $new){if(is_numeric($id)){$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE id = '".$id."'");if($rrx = mysqli_fetch_array($r)){ if($this->f_tl($rrx[$this->login_field]) == f_tl($new)){return true;}}if($this->refExistsActive($new)){return false;}else{return $this->mysql->query("UPDATE ".$this->dt_users." SET ".$this->login_field." = '".$this->f_te($new)."' WHERE id = '".$id."'");}}return false;}	
	public function changeUserShadowMail($id, $new){if(is_numeric($id) AND isset($new)){if (!$this->mail_unique) { return $this->mysql->query("UPDATE ".$this->dt_users." SET user_shadow = '".$this->f_te($new)."' WHERE id = '".$id."'");}else{ if($this->mailExistsActive($new)){return false;}else{return $this->mysql->query("UPDATE ".$this->dt_users." SET user_shadow = '".$this->f_te($new)."' WHERE id = '".$id."'");}}}return false;}
	public function changeUserMail($id, $new)  { if (is_numeric($id) AND isset($new)){if (!$this->mail_unique) {return $this->mysql->query("UPDATE ".$this->dt_users." SET user_mail = '".$this->f_te($new)."' WHERE id = '".$id."'");} else { $r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE id = '".$id."'");if($rrx = mysqli_fetch_array($r)){ if($this->f_tl($rrx["user_mail"]) == $this->f_tl($new)) {return true;}}if($this->mailExistsActive($new)) {return false;} else {return $this->mysql->query("UPDATE ".$this->dt_users." SET user_mail = '".$this->f_te($new)."' WHERE id = '".$id."'");}}}return false;}	
	public function addUser($name, $mail, $password = false, $rank = false, $activated = false, $delunconfirmedwhennew = false) {
		if($this->login_field == "user_mail") { $ref = $mail; } else { $ref = $name;  }
		$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE LOWER(".$this->login_field.") = '".$this->f_tel($ref)."'");
		if($rrx = mysqli_fetch_array($r)){ if($rrx["user_confirmed"] == 1) {return false;} else { if($delunconfirmedwhennew) {$this->deleteUser($rrx["id"]);} else { return false; } }} 
		if(!$activated) {$activated = 0;} else {$activated = 1;}
		if(!$rank) {$rankx = 0;} else {$rankx = $rank;}
		if(!$password) {$pass = $this->password_gen(32, "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz");} else {$pass = $password;}
		return $this->mysql->query("INSERT INTO ".$this->dt_users."(user_name, user_mail, user_pass, user_rank, user_confirmed)
		VALUES('".trim(mysqli_real_escape_string($this->mysql, $name))."', '".trim(mysqli_real_escape_string($this->mysql, $mail))."', '". $this->password_crypt($pass)."', '".$rankx."', '".$activated."')");
	}
		
	## Token Validation Functions	
	public function actication_token_valid($user, $token) { return $this->token_valid($user, $token, $this->key_activation); }
	public function recover_token_valid($user, $token) { return $this->token_valid($user, $token, $this->key_recover); }
	public function mail_edit_token_valid($user, $token) { return $this->token_valid($user, $token, $this->key_mail_edit); }
	public function session_token_valid($user, $token) { return $this->token_valid($user, $token, $this->key_session); }
	private function token_valid($user, $token, $type) {
		if(is_numeric($user) AND isset($token) AND is_numeric($type)){
			if($this->key_mail_edit == $type) {
				$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_keys." WHERE key_type = '".$this->key_mail_edit."' AND session_key = '".$this->f_te($token)."' AND fk_user = '".$user."'");
				if($res=mysqli_fetch_array($r)){
					if($res["is_active"] != 1) { return false; }
					if(is_numeric($this->hours_mail_edit)) {
						if(isset($f["creation"])) { if (strtotime($f["creation"]) > strtotime('-'.$this->hours_mail_edit.' hours')) {					
							return false;
						}}
					}					
					return true;
				} else {return false;}					
			} elseif($this->key_session == $type) {
				$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_keys." WHERE key_type = '".$this->key_session."' AND session_key = '".$this->f_te($token)."' AND fk_user = '".$user."'");
				if($res=mysqli_fetch_array($r)){
					if($res["is_active"] != 1) { return false; }
					if(is_numeric($this->sessions_days)) {
						 if(isset($f["creation"])) {
							if (strtotime($f["creation"]) < strtotime('-'.$this->sessions_days.' days')) {
								if($this->log_session) { $this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE id = '".$res["id"]."'"); }
								else { $this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE id = '".$res["id"]."'"); }
								return false;
							}
						}
					}
					return true;
				} else {return false;}						
			} elseif($this->key_recover == $type) {
				$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_keys." WHERE key_type = '".$this->key_recover."' AND session_key = '".$this->f_te($token)."' AND fk_user = '".$user."'");
				if($res=mysqli_fetch_array($r)){
					if($res["is_active"] != 1) { return false; }
					if(is_numeric($this->hours_recover)) {
						if(isset($f["creation"])) { if (strtotime($f["creation"]) > strtotime('-'.$this->hours_recover.' hours')) {					
							return false;
						}}
					}					
					return true;
				} else {return false;}						
			} elseif($this->key_activation == $type) {
				$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_keys." WHERE key_type = '".$this->key_activation."' AND session_key = '".$this->f_te($token)."' AND fk_user = '".$user."'");
				if($res=mysqli_fetch_array($r)){
					if($res["is_active"] != 1) { return false; }
					if(is_numeric($this->hours_activation)) {
						if(isset($f["creation"])) { if (strtotime($f["creation"]) > strtotime('-'.$this->hours_activation.' hours')) {					
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
			if($this->key_mail_edit == $type) {
				$this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE key_type = '".$this->key_mail_edit."' AND fk_user = '".$user."'");
				if(!$this->log_mail_edit) {
					$this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE key_type = '".$this->key_mail_edit."' AND fk_user = '".$user."'");
				} 		
				if($this->log_ip) {$thenewip = @$_SERVER["REMOTE_ADDR"];} else {$thenewip = "hidden";}
				$this->mysql->query("INSERT INTO ".$this->dt_keys."(fk_user, key_type, session_key, is_active, request_ip) VALUES('".$user."', '".$this->key_mail_edit."', '".$this->f_te($token)."', '1', '".$this->f_te($thenewip)."')");
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
				$this->mysql->query("INSERT INTO ".$this->dt_keys."(fk_user, key_type, session_key, is_active, request_ip, refresh_date) VALUES('".$user."', '".$this->key_session."', '".$this->f_te($token)."', '1', '".$this->f_te($thenewip)."', CURRENT_TIMESTAMP())");
				return true;
			} elseif($this->key_recover == $type) {
				$this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE key_type = '".$this->key_recover."' AND fk_user = '".$user."'");
				if(!$this->log_recover) {
					$this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE key_type = '".$this->key_recover."' AND fk_user = '".$user."'");
				} 		
				if($this->log_ip) {$thenewip = @$_SERVER["REMOTE_ADDR"];} else {$thenewip = "hidden";}
				$this->mysql->query("INSERT INTO ".$this->dt_keys."(fk_user, key_type, session_key, is_active, request_ip) VALUES('".$user."', '".$this->key_recover."', '".$this->f_te($token)."', '1', '".$this->f_te($thenewip)."')");
				return true;
			} elseif($this->key_activation == $type) {
				$this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE key_type = '".$this->key_activation."' AND fk_user = '".$user."'");
				if(!$this->log_activation) {
					$this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE key_type = '".$this->key_activation."' AND fk_user = '".$user."'");
				} 		
				if($this->log_ip) {$thenewip = @$_SERVER["REMOTE_ADDR"];} else {$thenewip = "hidden";}
				$this->mysql->query("INSERT INTO ".$this->dt_keys."(fk_user, key_type, session_key, is_active, request_ip) VALUES('".$user."', '".$this->key_activation."', '".$this->f_te($token)."', '1', '".$this->f_te($thenewip)."')");
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
			$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE user_confirmed = '1' AND user_blocked <> 1 AND id = '".$_SESSION[$this->sessions."x_users_id"]."'");
			if($cr = mysqli_fetch_array($r)){
				$this->object_user_set($cr["id"]);
				$this->mysql->query("UPDATE ".$this->dt_keys." SET refresh_date = CURRENT_TIMESTAMP() WHERE fk_user = '".$cr["id"]."' AND session_key = \"".$this->f_te($cr["x_users_key"])."\" AND is_active = 1 AND key_type = '".$this->key_session."'"); 
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
		$this->user_rank = false;
		$this->user_id = false;
		$this->user_name = false;
		$this->user_mail = false;
		$this->loggedIn = false;
		$this->user_loggedIn = false;
		$this->info = $tmp;
		$this->user = $this->info;
	}
	private function object_user_set($userid) {
		if(!$this->exists($userid)) { return false; }
		$tmp = $this->get($userid);
		$tmp["x_users_key"]		=	@$_SESSION[$this->sessions."x_users_key"];
		$tmp["x_users_stay"]	=	@$_SESSION[$this->sessions."x_users_stay"];
		$tmp["x_users_ip"]		=	@$_SESSION[$this->sessions."x_users_ip"];
		$tmp["x_users_id"]		=	@$_SESSION[$this->sessions."x_users_id"];
		$tmp["loggedIn"]		=	true;
		$this->user_rank = $tmp["user_rank"];
		$this->user_id = $tmp["x_users_id"];
		$this->user_name = $tmp["user_name"];
		$this->user_mail = $tmp["user_mail"];
		$this->loggedIn = true;
		$this->user_loggedIn = true;
		$this->info = $tmp;
		$this->user = $tmp;
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
			$val = mysqli_query($this->mysql, 'SELECT 1 FROM `'.$this->dt_users.'`');
		} catch (Exception $e){ 
			 $this->create_table();
		} if($val === FALSE) { $this->create_table();}

		$val = false; try {
			$val = mysqli_query($this->mysql, 'SELECT 1 FROM `'.$this->dt_keys.'`');
		} catch (Exception $e){ 
			 $this->create_table();
		} if($val === FALSE) { $this->create_table();}
	}
	
	### Table Restore
	private function create_table() {
			mysqli_query($this->mysql, "CREATE TABLE IF NOT EXISTS `".$this->dt_users."` (
											  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
											  `user_name` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'undefined' COMMENT 'Users Name for Login if Ref',
											  `user_pass` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Users Pass for Login',
											  `user_mail` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Users Mail for Login if Ref',
											  `user_shadow` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Users Store for Mail if Renew',
											  `user_rank` tinyint NOT NULL DEFAULT '0' COMMENT 'Users Rank',
											  `created_date` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
											  `modify_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
											  `last_reset` datetime DEFAULT NULL COMMENT 'Reset Date Counter for new Requests',
											  `last_activation` datetime DEFAULT NULL COMMENT 'Activation Date Counter for new Requests',
											  `last_mail_edit` datetime DEFAULT NULL COMMENT 'Last Mail Change Request Date',
											  `req_reset` datetime DEFAULT NULL COMMENT 'Reset Date Counter for new Requests',
											  `req_activation` datetime DEFAULT NULL COMMENT 'Activation Date Counter for new Requests',
											  `req_mail_edit` datetime DEFAULT NULL COMMENT 'Last Mail Change Request Date',
											  `last_login` datetime DEFAULT NULL COMMENT 'Last Login Date',
											  `user_confirmed` tinyint(1) DEFAULT '0' COMMENT 'User Activation Status',
											  `user_blocked` tinyint(1) DEFAULT '0' COMMENT 'User Blocked/Disabled Status',
											  PRIMARY KEY (`id`)
											) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;");
			mysqli_query($this->mysql, "CREATE TABLE IF NOT EXISTS `".$this->dt_keys."` (
											`id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique Session ID',
											`fk_user` int(10) NOT NULL COMMENT 'Related User ID',
											`key_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 1 - activate 2 - session 3 - recover 4 - mailchange',
											`creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date for max Session Days',
											`modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
											`refresh_date` datetime DEFAULT NULL COMMENT 'Last Use Date set by session_restore!',
											`session_key` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Session Authentification Token and Key!',
											`is_active` tinyint(1) DEFAULT '0' COMMENT '1 - Active 0 - Expired!',
											`request_ip` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Requested IP if enabled set at creation!',
											`execute_ip` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Executed IP if enabled set at Invalidation!',
											PRIMARY KEY (`id`)
										) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;");		
	}

	// Login Request to Get a User Logged in with REF and PASSWORD and Cookies Stayloggedin = True?
	// Request Codes: 5 - User is not yet confirmed
	// Request Codes: 4 - User is Disabled / Blocked
	// Request Codes: 3 - Wrong Password
	// Request Codes: 2 - User-Ref not Existant
	// Request Codes: 1 - Login OK
	public function login_request($ref, $password, $stayLoggedIn = false) {
		$this->ref = array();
		$this->login_request_code = false;
		$r	=	mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users." WHERE LOWER(".$this->login_field.") = \"".$this->f_tel($ref)."\"");
		if( $f = mysqli_fetch_array($r) ) {					
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
				$this->login_request_code = 1;
				return 1;
			} else { $this->login_request_code = 3; return 3; }									
		} $this->login_request_code = 2; return 2; 
	}

	// Activation Request for a Users ID Without Checks 
	// 1 - Successfull Created
	// 2 - Reference not Found
	// 3 - Is already Active
	public function activation_request_id($id) {
		$this->ref = array();
		if(!is_numeric($id)) { return 2; }
		$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users."  WHERE id = \"".$id."\"");
		while($f=mysqli_fetch_array($r)){
			if($f["user_confirmed"] == 1) { return 3; }
			$token = $this->token_gen();
			$this->activation_token_create($f["id"], $token);
			$this->ref["token"] 			= $token;
			$this->ref["receiver_id"] 		= $f["id"];
			$this->ref["receiver_name"] 	= $f["user_name"];
			$this->ref["receiver_mail"] 	= $f["user_mail"];
			return 1;
		} return 2;
	}

	// Activation Request for a Users Reference 
	// 1 - Successfull Created
	// 2 - Reference not Found
	// 3 - Interval for new Activation Mail not Reached
	// 4 - User is already Active
	public function activation_request($ref) { 
		$this->ref = array();
		$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users."  WHERE LOWER(".$this->login_field.") = \"".$this->f_tel($ref)."\"");
		while($f=mysqli_fetch_array($r)){
			if($f["user_confirmed"] == 1) { return 4; }
			if(is_numeric($this->wait_activation_hours)) {
				if(isset($f["req_activation"])) { if (strtotime($f["req_activation"]) > strtotime('-'.$this->wait_activation_hours.' hours')) {return 3;}}
			}
			$this->mysql->query("UPDATE ".$this->dt_users." SET req_activation = CURRENT_TIMESTAMP() WHERE id = '".$f["id"]."'");
			$token = $this->token_gen();
			$this->activation_token_create($f["id"], $token);
			$this->ref["token"] 			= $token;
			$this->ref["receiver_id"] 		= $f["id"];
			$this->ref["receiver_name"] 	= $f["user_name"];
			$this->ref["receiver_mail"] 	= $f["user_mail"];
			return 1;
		} return 2;
	}

	// Activation Request for a Users Reference 
	// 1 - Successfull Created
	// 2 - Reference not Found
	// 3 - Token Invalid 
	public function activation_confirm($userid, $token) {
		$this->ref = array();
		if(!is_numeric($userid)) { return 2; }
		$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_keys." WHERE session_key = '".$this->f_te($token)."' AND key_type = '".$this->key_recover."' AND fk_user = '".$userid."' AND is_active = 1");
		if($f= mysqli_fetch_array($r)){
			if($this->log_activation) {$this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE fk_user = ".$f["fk_user"]." AND key_type = '".$this->key_activation."'");	
			} else { $this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE fk_user = ".$f["fk_user"]." AND key_type = '".$this->key_activation."'");}
			if(!$this->activation_token_valid($userid, $token)) { return 3;}
			$this->mysql->query("UPDATE ".$this->dt_users." SET last_activation = CURRENT_TIMESTAMP() WHERE id = '".$userid."'");
			$this->mysql->query("UPDATE ".$this->dt_users." SET user_confirmed = 1 WHERE id = '".$userid."'");
			return 1;
		} else { return 2; }
	}

	// Recover Request for a Users ID Without Checks 
	// 1 - Successfull Created
	// 2 - Reference not Found
	public function recover_request_id($id) {
		$this->ref = array();
		if(!is_numeric($id)) { return 2; }
		$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users."  WHERE id = \"".$id."\"");
		while($f=mysqli_fetch_array($r)){
			$token = $this->token_gen();
			$this->recover_token_create($f["id"], $token);
			$this->ref["token"] 			= $token;
			$this->ref["receiver_id"] 		= $f["id"];
			$this->ref["receiver_name"] 	= $f["user_name"];
			$this->ref["receiver_mail"] 	= $f["user_mail"];
			return 1;
		} return 2;
	}	
						 
	// Recover Request for a Users Reference 
	// 1 - Successfull Created
	// 2 - Reference not Found
	// 3 - Interval for new Recover not Reached
	public function recover_request($ref) { 
		$this->ref = array();
		$this->rec_request_code = false;
		$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users."  WHERE LOWER(".$this->login_field.") = \"".$this->f_tel($ref)."\"");
		while($f=mysqli_fetch_array($r)){
			if(is_numeric($this->wait_recover_hours)) {
				if(isset($f["req_reset"])) { if (strtotime($f["req_reset"]) > strtotime('-'.$this->wait_recover_hours.' hours')) {$this->rec_request_code = 3;return 3;}}
			}
			$this->mysql->query("UPDATE ".$this->dt_users." SET req_reset = CURRENT_TIMESTAMP() WHERE id = '".$f["id"]."'");
			$token = $this->token_gen();
			$this->recover_token_create($f["id"], $token);
			$this->ref["token"] 			= $token;
			$this->ref["receiver_id"] 		= $f["id"];
			$this->ref["receiver_name"] 	= $f["user_name"];
			$this->ref["receiver_mail"] 	= $f["user_mail"];
			$this->rec_request_code = 1; return 1;
		} $this->rec_request_code = 2;return 2;
	}	

	// Recover Request Confirm With Token
	// 1 - Successfull Created
	// 2 - Reference not Found
	// 3 - Token Interval Error
	public function recover_confirm($userid, $token, $newpass) {
		$this->ref = array();
		if(!is_numeric($userid)) { $this->rec_request_code = 2; return false; }
		$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_keys." WHERE session_key = '".mysqli_real_escape_string($this->mysql, trim($token))."' AND key_type = '".$this->key_recover."' AND fk_user = '".$userid."' AND is_active = 1");
		if($f= mysqli_fetch_array($r)){
			if($this->log_recover) {$this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE fk_user = ".$f["fk_user"]." AND key_type = '".$this->key_recover."'");	
			} else { $this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE fk_user = ".$f["fk_user"]." AND key_type = '".$this->key_recover."'");}			
			if(!$this->recover_token_valid($userid, $token)) { return 3; }
			$this->mysql->query("UPDATE ".$this->dt_users." SET last_reset = CURRENT_TIMESTAMP() WHERE id = '".$userid."'");
			$this->mysql->query("UPDATE ".$this->dt_users." SET last_activation = CURRENT_TIMESTAMP() WHERE id = '".$userid."' AND activation_date IS NULL");
			$this->mysql->query("UPDATE ".$this->dt_users." SET user_confirmed = 1 WHERE id = '".$userid."'");
			$this->changeUserPass($f["fk_user"], $newpass);
			return 1;
		} else {return 2;}
	}	
	
	// Functions to Register new "Shadow" Mail
	// Create Mail Change Confirmation Token
	// 1 - Success
	// 2 - Reference Not Found
	// 3 - Interval for new Request not Reached
	// 4 - Mail Exists
	public function mail_edit($id, $newmail, $nointervall = false) {
		$this->ref = array();
		if(!is_numeric($id)) { return 2; }				
		
		if($this->mail_unique) { 
			$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users."  WHERE LOWER(user_mail) LIKE \"".$this->f_tel($newmail)."\" AND user_confirmed = 1");
			if($f=mysqli_fetch_array($r)){	return 4; } 				
		}
		
		$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users."  WHERE id = \"".$id."\"");
		if($f=mysqli_fetch_array($r)){
			if(!$nointervall) { if(is_numeric($this->wait_activation_hours)) {if(isset($f["req_mail_edit"])) {if (strtotime($f["req_mail_edit"]) > strtotime('-'.$this->wait_activation_hours.' hours')) {return 3; }}} }
			if($this->log_mail_edit) {$this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE fk_user = ".$f["id"]." AND key_type = '".$this->key_mail_edit."'");	
			} else { $this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE fk_user = ".$f["id"]." AND key_type = '".$this->key_mail_edit."'");};
			$this->mysql->query("UPDATE ".$this->dt_users." SET req_mail_edit = CURRENT_TIMESTAMP() WHERE id = '".$userid."'");
			$this->changeUserShadowMail($id, $newmail);
			$token	=	$this->token_gen();
			$this->mail_edit_token_create($f["id"], $token);
			$this->ref["token"] 			= $token;
			$this->ref["receiver_id"] 		= $f["id"];
			$this->ref["receiver_name"] 	= $f["user_name"];
			$this->ref["receiver_mail"] 	= $newmail;				
			return 1;
		} return 2;
	}

	// Confirm Change of Mail Address
	// 1 - OK
	// 2 - Ref not Found
	// 3 - Token Expires
	// 4 - Mail exists
	// 5 - Error on Shadow Mail
	public function mail_edit_confirm($userid, $token) {
		$this->ref = array();
		if(!is_numeric($userid)) { return 2; }
			
		$r = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_keys." WHERE session_key = '".mysqli_real_escape_string($this->mysql, $token)."' AND key_type = '".$this->key_mail_edit."' AND fk_user = '".$userid."' AND is_active = 1");
		if($f= mysqli_fetch_array($r)){
			
			if($this->log_mail_edit) {$this->mysql->query("UPDATE ".$this->dt_keys." SET is_active = 0 WHERE fk_user = ".$f["fk_user"]." AND key_type = '".$this->key_mail_edit."'");	
			} else { $this->mysql->query("DELETE FROM ".$this->dt_keys." WHERE fk_user = ".$f["fk_user"]." AND key_type = '".$this->key_mail_edit."'");}			

			if(!$this->mail_edit_token_valid($userid, $token)) { return 3; }

			
			$x = mysqli_query($this->mysql, "SELECT * FROM ".$this->dt_users."  WHERE id = \"".$userid."\"");
			if($xf=mysqli_fetch_array($x)) {
					if($xf["user_shadow"] == NULL OR trim($xf["user_shadow"]) == "") { return 5;  }
					if(!$this->mail_unique) { 
						$this->mysql->query("UPDATE ".$this->dt_users." SET last_mail_edit = CURRENT_TIMESTAMP() WHERE id = '".$f["id"]."'");
						$this->changeUserMail($f["fk_user"], $xf["user_shadow"]);
						$this->mysql->query("UPDATE ".$this->dt_users." SET user_shadow = NULL WHERE id = '".$userid."'");
					} else {
						$this->mysql->query("UPDATE ".$this->dt_users." SET last_mail_edit = CURRENT_TIMESTAMP() WHERE id = '".$f["id"]."'");
						$this->mysql->query("UPDATE ".$this->dt_users." SET user_shadow = NULL WHERE user_shadow = '".$this->f_tel($xf["user_shadow"])."'");					
					}
				}
			return 1;
		} else { return 2;}
	}
}
?>