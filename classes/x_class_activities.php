<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  Activities Control Class	*/
	
	class x_class_activities {
		// MySQL Related
			private $mysqlobj   = false;
			private $table  	= false;
		
		// Session Related
			private $pre    = false;
			private $target = false;
			private $module = false;
		
		// System Comments Settings
			private $sys_name	=	"System"; public function sys_name($name = "System") { $this->sys_name = $name; }
			private $sys_text	=	"Thanks for visiting my page and have a nice day!"; public function sys_text($text = "Thanks for visiting my page and have a nice day!") { $this->sys_text = $text; }
		
		// Upvote Parameters
			private $endorse_param =  "xcv_upvotes"; public function endorse_param($method = "xcv_upvotes")  { $this->endorse_param = $method; }
			private $endorse_param_code	=  "c"; public function endorse_param_code($method = "c")  { $this->endorse_param_code = $method; }
			private $decomment_param_code	=  "d"; public function decomment_param_code($method = "d")  { $this->endorse_param_code = $method; }
		
		// Upvote Informations		
			private  $endorsed_by_user  = false; public function endorsed_by_user() { return $this->endorsed_by_user; }
			private  $endorsed_counter 		= false; public function endorsed_counter() { return $this->endorsed_counter; }
			private  $endorsed_session_name	= false; 
		
		// Commenting Handling
			private $commented_by_user = false; public function commented_by_user() { return $this->commented_by_user; }
			private $comments_counter = false; public function comments_counter() { return $this->comments_counter; }
			private $comments_session_name  = false;    
			
		// Commenting Handling
			private $sessionban_status = false; public function sessionban_init($bool = false, $limit = 100) { $this->sessionban_status = $bool; $this->sessionban_limit = $limit; }
			private $sessionban_limit  = 50;  private $sessionban_session_name  = false;  
			public function sessionban_raise() { if(!is_numeric($_SESSION[$this->sessionban_session_name])) { $_SESSION[$this->sessionban_session_name] = 1; } else { $_SESSION[$this->sessionban_session_name] = $_SESSION[$this->sessionban_session_name] +1 ; } }
			public function sessionban_blocked() { if(!is_numeric($_SESSION[$this->sessionban_session_name])) { $_SESSION[$this->sessionban_session_name] = 0; } if($_SESSION[$this->sessionban_session_name] > $this->sessionban_limit) { return true; } return false; }
			public function sessionban_reset() { $_SESSION[$this->sessionban_session_name] = 0; }
			
		// Construct the Class
		function __construct($mysql, $table, $precookie, $module, $target) {
			// Init Session If Not Exists
			if (session_status() === PHP_SESSION_NONE) { session_start(); }
			
			// Init Default Variables
			$this->mysqlobj = $mysql;
			$this->table    = $table;
			$this->pre      = $precookie;
			$this->target   = $target;
			$this->module   = $module;	

			// Set Variable for This Objects Upvotes Session Key and Activities
			$this->endorsed_session_name     = $this->pre."x_activities_endorse";
			$this->sessionban_session_name   = $this->pre."x_activities_ban";
			$this->comments_session_name   	 = $this->pre."x_activities_commented";
		}
		
		// Init Functions and Routines for Commenting System
		function init($captcha_code_if_delivered) { 
			// Insert Systems Entrie
				$q	= @mysqli_query($this->mysqlobj, 'SELECT * FROM '.$this->table .' WHERE status = 3 AND target = "'.$this->module.'" AND targetid = "'.$this->target.'"');
				if(mysqli_num_rows($q) <= 0) {
					@mysqli_query($this->mysqlobj, "INSERT INTO ".$this->table ." (target, targetid, name, text, status) VALUE('".$this->module."','".$this->target."','".$this->sys_name."', '".$this->sys_text."', 3);"); 
				}
				
			// Endorse Executions
				if (is_array($_SESSION[$this->endorsed_session_name])) {	
					foreach($_SESSION[$this->endorsed_session_name] as $key => $value) {
						if($value == $this->target."_".$this->module) { $this->endorsed_by_user = true; }
					}
				} else { $_SESSION[$this->endorsed_session_name] = array();}
				
				$q	= @mysqli_query($this->mysqlobj, 'SELECT * FROM '.$this->table .' WHERE status = 3 AND target = "'.$this->module.'" AND targetid = "'.$this->target.'"');
				if(mysqli_num_rows($q) > 0) { 
					if($r 	= @mysqli_fetch_array($q) ) {
						$this->endorsed_counter = $r["upvotes"];
					} else { $this->endorsed_counter = 0; } 
				} else { $this->endorsed_counter = 0; } 	

				// Check if endorse has been pushed
				if(!$this->endorsed_by_user AND @$_GET[$this->endorse_param]  == $this->endorse_param_code) {
					$this->endorsed_by_user = true;
					array_push($_SESSION[$this->endorsed_session_name], $this->target."_".$this->module);
					$this->endorsed_counter = $this->endorsed_counter + 1;
					@mysqli_query($this->mysqlobj, "UPDATE ".$this->table ." SET upvotes = upvotes + 1 WHERE target = '".$this->module."' AND targetid = '".$this->target."' AND status = 3");	
				}				

			// Comment Executions
				if (is_array($_SESSION[$this->comments_session_name])) {	
					foreach($_SESSION[$this->comments_session_name] as $key => $value) {
						if($value == $this->target."_".$this->module) { $this->commented_by_user = true; }
					}
				} else { $_SESSION[$this->comments_session_name] = array();}
				
				$q	= @mysqli_query($this->mysqlobj, 'SELECT * FROM '.$this->table .' WHERE status = 1 AND target = "'.$this->module.'" AND targetid = "'.$this->target.'" ORDER BY created DESC');
				if(mysqli_num_rows($q) > 0) { 
						$this->comments_counter = mysqli_num_rows($q);
				} else { $this->comments_counter = 0; } 
				
				// Decomment to Write New
				if($this->commented_by_user AND @$_GET[$this->endorse_param] == $this->decomment_param_code) {
					foreach($_SESSION[$this->comments_session_name] as $key => $value) {
						if($value == $this->target."_".$this->module) { $this->commented_by_user = false; unset($_SESSION[$this->comments_session_name][$key]); }
					}
				}
		

		
			// Check for comment push
			if(isset($_POST["x_activities_submit"])) {
				if (trim(@$_POST["x_activities_name"]) != "" AND trim(@$_POST["x_activities_text"]) != ""){
					if (trim(strtolower(@$_POST["x_activities_name"])) == $this->sys_name){$_POST["x_activities_name"] = "Guest_".trim(strtolower(@$_POST["x_activities_name"])); }
					if (@$captcha_code_if_delivered == @$_POST["x_activities_captcha"]){
						$comment_sql1	=	'INSERT INTO '.$this->table .'(name, created, text, target, targetid, status)VALUES("'.mysqli_escape_string($this->mysqlobj, htmlspecialchars($_POST["x_activities_name"])).'", "'.date("Y-m-d H:i:s").'", "'.mysqli_escape_string($this->mysqlobj, $_POST["x_activities_text"]).'", "'.$this->module.'", "'.$this->target.'", 0)';
						$comment_r1	=	mysqli_query($this->mysqlobj, $comment_sql1);
						$this->commented_by_user = true;
						return 3;
						} return 2;
				}  else { return 1; }
			} 
		}	
		
		// Show Comments with Predefined - Boxes
		function show_votes() { ?>
			<div id="x_activities_vote">
				<form method="get"><input type="hidden" name="<?php echo $this->endorse_param; ?>" value="<?php echo $this->endorse_param_code; ?>"><font color="lime">Currently <?php echo $this->endorsed_counter; ?> Upvotes!</font>
					<?php if($this->endorsed_by_user) { ?><input type="submit" value="Vote-Up"><?php } else { ?><font id="x_activities_vote_done">You already have given an upvote for this item!</font><?php } ?></form> 
			</div> <?php 
		}	
		
		
		// Show Form for new Comments
		function show_form($captchaurl) { ?>			
			<div id="x_activities_form">	
			
				<?php if($this->commented_by_user) { ?>
					<div id="x_activities_done">After your comment has been checked it will be submittet immidiately! <br />
					<form action="get"><input type="hidden" name="<?php echo $this->endorse_param; ?>" value="<?php echo $this->decomment_param_code; ?>"><input type="submit" value="Close Message"></form></div>			
				<?php } else { ?>
				<form method="post" id="x_activities_activeform">
					<?php
						echo '<input type="text" name="x_activities_name" placeholder="Name" maxlength="64"/>';
						echo '<textarea name="x_activities_text" placeholder="Comment" maxlength="256"></textarea><br />';
						echo '<img src="'.$captchaurl.'" alt="captcha image">' ;
						echo '<input type="text" name="x_activities_captcha" id="x_activities_captcha" placeholder="Captcha" size="10" maxlength="64"/>';
						echo '<input type="submit" name="x_activities_submit" value="Add" />';
					?>
				</form>		
				<?php } ?>				
			</div>				
		<?php }

		// Show the Comments
		function show_comments($hide_system_msg = false) {
			echo '<div id="x_activities_comments">';
			$q	=	@mysqli_query($this->mysqlobj, 'SELECT * FROM '.$this->table .' WHERE (status = 1 OR status = 2 OR status = 3) AND target = "'.$this->module.'" AND targetid = "'.$this->target.'"  ORDER BY id DESC');
			while($r=@mysqli_fetch_array($q)){ if(!$hide_system_msg OR  $r["status"] == 1) { echo '<div class="x_activities_comments_post"><div id="x_activities_comments_title">'.$r["name"].' - '.$r["created"].'</div><div id="x_activities_comments_text">'.$r["text"].'</div></div>'; } }			
			echo "</div>";
		}		
	} 
?>