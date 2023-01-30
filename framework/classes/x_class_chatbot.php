<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  Shell Control Class	*/
	class x_class_shell {
		/*	
CREATE TABLE IF NOT EXISTS `seven_sparky_suggest` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
  `text` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Suggest Text',
  `atid` int DEFAULT NULL COMMENT 'Related ID',
  `status` int NOT NULL DEFAULT '1' COMMENT 'Status (Unrelated)',
  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique` (`text`(100))
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;		
		
CREATE TABLE IF NOT EXISTS `seven_sparky_cat` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
  `title` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Category Title',
  `tocat` int DEFAULT NULL COMMENT 'Refers to Answer Category',
  `sector` varchar(12) NOT NULL,
  `tocommand` int DEFAULT NULL COMMENT 'Refers to Answer Command',
  `toworkflow` int DEFAULT NULL COMMENT 'Refers to Answer Workflow',
  `reply` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Refers to Answer Reply Direct',
  `relation` int DEFAULT NULL COMMENT 'Relation Icon for Reaction Image',
  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Schluessel 2` (`title`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;		
		
CREATE TABLE IF NOT EXISTS `seven_sparky_cat_text` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
  `text` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Group Text',
  `group` int NOT NULL COMMENT 'Group ID',
  `relation` int DEFAULT NULL COMMENT 'Reaction Image Name',
  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=198 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;		
		
		CREATE TABLE IF NOT EXISTS `seven_sparky_command` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
  `command` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'PHP Command',
  `name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Command Identifier',
  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Schluessel 2` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
		
		
		
CREATE TABLE IF NOT EXISTS `seven_sparky_question` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
  `text` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Question Text',
  `relation` int DEFAULT '0' COMMENT 'Reaction Image',
  `directworkflow` int DEFAULT NULL COMMENT 'Go To Workflow',
  `directcommand` int DEFAULT NULL COMMENT 'Go To Command',
  `directreply` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Go To Reply',
  `directtocat` int DEFAULT NULL COMMENT 'Go To Cat for Reply',
  `creation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Date',
  `modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modification Date',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `Schluessel 2` (`text`(100)) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;		
		
		
		
		
		
		
		
		
		
		####################################
	##### Bot Table Configurations
	####################################		
	define('_CHATBOT_TABLE_COMMAND_',   _BTM_PREFIX_."sparky_command");  
	define('_CHATBOT_TABLE_QUESTION_',  _BTM_PREFIX_."sparky_question");  
	define('_CHATBOT_TABLE_CAT_',  		_BTM_PREFIX_."sparky_cat");  
	define('_CHATBOT_TABLE_CAT_TEXT_',  _BTM_PREFIX_."sparky_cat_text");  
	define('_CHATBOT_TABLE_SUGGEST_',  	_BTM_PREFIX_."sparky_suggest");  

	####################################
	##### Bot Settings Configurations
	####################################
	define('_CHATBOT_SAVE_UNKNOWN_', 	 false);
	define('_CHATBOT_BOT_NAME_',  		"Sparky");
	define('_CHATBOT_USER_NAME_',  		"Anon");
	define('_CHATBOT_ERROR_STRING_',  	"This command is not known!");
	define('_CHATBOT_ERROR_GROUP_',  	"notfound");
	define('_CHATBOT_WELCOME_GROUP_',  	"welcome");
	define('_CHATBOT_RESET_COUNT_',  	12000);
	define('_CHATBOT_THEME_',  			"/_theme/global/css/css_main.css");
	define('_CHATBOT_HELP_',  			"Type 'help' into the console to get help about commands and more!");
	define('_CHATBOT_BOTTOM_',  		"<div>Made by <a href='"._BTM_INTERNAL_MAINPAGEURL_."' target='_blank' rel='noopener'>Bugfish!</a></div>");*/
		private $mysql = false;
		private $table_question = false;
		private $table_group_text = false;
		private $table_group = false;
		private $table_command = false;
		private $table_workflow = false;
		private $table_talk = false;
		private $section = ""; public function section($string) { $this->section = $string; }
		
		private $pre_cookie = false; public function pre_cookie($string) { $this->pre_cookie = $string; }
		private $mode = 1;
		
		private $conf_bot_name = false;  public function conf_bot_name($string) { $this->conf_bot_name = $string; }
		private $conf_user_name = false; public function conf_user_name($string) { $this->conf_user_name = $string; }
		private $conf_user_ref = false; public function conf_user_ref($id) { $this->conf_user_ref = $id; }
		
		private $conf_help_text = false; public function conf_help_text($string) { $this->conf_help_text = $string; }
		private $conf_reset_after = false; public function conf_reset_after($int) { $this->conf_reset_after = $int; }
		private $conf_group_start = false; public function conf_group_start($string) { $this->conf_group_start = $string; }
		private $conf_group_error = false; public function conf_group_error($string) { $this->conf_group_error = $string; }
		private $conf_string_error = false; public function conf_string_error($string) { $this->conf_string_error = $string; }
		
		function __construct($mysql, $table_question, $table_group_text, $table_group, $table_command, $table_workflow, $mode = 1, $table_talk = false) {
		
			$this->table_question = $table_question;
			$this->table_group_text = $table_group_text;
			$this->table_group = $table_group;
			$this->table_command = $table_command;
			$this->table_workflow = $table_workflow;
			$this->table_talk = $table_talk;
			
			$this->mode = $mode;
			
			if($mode == 1) { 	
			 if (isANullValue(@$_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"])) 
				{ $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = 0;}	
			 if (isANullValue(@$_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_workflow"])) 
				{ $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_workflow"] = 0;}	
			 if (isANullValue(@$_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_step"])) 
				{ $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_step"] = 0;}		
			 if (isANullValue(@$_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_text"])) 			 
				{ $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_text"] =	displayMessageBot($mysql->mysqlcon, $this->conf_group_start, NULL);} 
			}
	
		}
		
		##### Session Mode 1
		private function set_session($name, $content) { $_SESSION[$this->pre_cookie.$name] = $content; return true; }
		private function get_session($name) { return $_SESSION[$this->pre_cookie.$name]; }		
		private function add_session_msg_bot($content) { array_push($_SESSION[$this->pre_cookie."chat_current_text"], array(1, $content)); return true; }		
		private function add_session_msg_user($content) { array_push($_SESSION[$this->pre_cookie."chat_current_text"], array(2, $content)); return true; }		
		private function clear_session_msg() { $_SESSION[$this->pre_cookie."chat_current_text"] = array(); return true; }		







		##### Get Chat 
		private function get_chat_array() {
			if($this->mode == 1) { return $this->get_session("chat_current_text"); }
			if($this->mode == 2) {  }
		}
		
		##### Clear Chat
		private function clear_chat() {
			if($this->mode == 1) { $this->clear_session_msg(); }
			if($this->mode == 2) {  }
		}
		
		##### Send Text as Bot or Help Text
		public function send_help($override = false) {
			if($this->mode == 1) { if($override) {$this->add_session_msg_bot($override);} else {$this->add_session_msg_bot($this->conf_help_text);} }
			if($this->mode == 2) {  }			
		}
		
		##### Send Text as Bot
		public function send_bot($text) {
			if($this->mode == 1) { $this->add_session_msg_bot($text); }
			if($this->mode == 2) {  }			
		}
		
		##### Send Text as User //////////////
		public function send_user($override = false) {
			if($this->mode == 1) { }
			if($this->mode == 2) {  }			
		}
		
		##### Current Relation
		private function set_relation($int) {
			if($this->mode == 1) {  }
			if($this->mode == 2) {  }
		}
		
		private function change_relation($int) {
			if($this->mode == 1) {  }
			if($this->mode == 2) {  }
		}
		
		private function get_relation() {
			if($this->mode == 1) { return $this->get_session("chat_current_relationship"); }
			if($this->mode == 2) {  }
		}

		##### Current Workflow
		private function set_workflow($int) {
			if($this->mode == 1) {  }
			if($this->mode == 2) {  }
		}
		private function get_workflow() {
			if($this->mode == 1) { return $this->get_session("chat_current_workflow"); }
			if($this->mode == 2) {  }
		}
		
		##### Execute a Command
		private function command_execute_result($ID) {
			if(is_numeric($ID)) {
				$query = "SELECT * FROM `".$this->table_command."` WHERE id = \"".$ID."\"";
				$result = $this->mysql->query($query);
				while ($sresult = mysqli_fetch_array($result, MYSQLI_BOTH)) {		
					ob_start();
					$tmpvarforid	=	$sresult["command"];
					eval("?>$tmpvarforid");
					$result = ob_get_clean();			
					return $result;
				}		
			} return null;
		}	
			
	function getTime() 				{ return date("H:i:s");}		 

							
	private function getOutputProcessed($TEXT) {
		$output = null;			
		if($this->get_workflow() == 0) {
			// Process Check if Raw	
			$tmpdirectid = $this->getTextIdDirect($TEXT);	
			if ($tmpdirectid != NULL) {	
				// Direct Reply 
					$tmpprocessvar	=	$this->getFromTextQuestionId($tmpdirectid, 1);
					 if ( $tmpprocessvar  != NULL AND $tmpprocessvar != "" ) {
						$output = $tmpprocessvar;
						goto proceed; }							 
					 
				// Direct Command 
					$tmpprocessvar	=	$this->getFromTextQuestionId($tmpdirectid, 2);
					 if ( $tmpprocessvar  != NULL AND $tmpprocessvar != "" ) {
						$output = $this->command_execute_result($tmpprocessvar); 
						goto proceed;
					 }								
				// Direct From Categorie
					$tmpprocessvar	=	$this->getFromTextQuestionId($tmpdirectid, 3);
					if ( $tmpprocessvar  != NULL AND $tmpprocessvar != "" ) {
						$output = $this->fetchOneFromCatItemIDSec($tmpprocessvar, 4);
						goto proceed; }							
						
						// Start a Workflow				
							/*$tmpprocessvar	=	getFromTextQuestionId($tmpdirectid, $MYSQL, "directworkflow");
							 if ( $tmpprocessvar  != NULL AND $tmpprocessvar != "" ) {
								$output = getWorkflowFromId($tmpprocessvar, $MYSQL); /////////////////////////////////////////////////////////////////////////
								goto proceed;
							 }		*/	

						// Start a Workflow	from Step		
							/*$tmpprocessvar	=	getFromTextQuestionId($tmpdirectid, $MYSQL, "directworkflow");
							 if ( $tmpprocessvar  != NULL AND $tmpprocessvar != "" ) {
								$output = getWorkflowFromId($tmpprocessvar, $MYSQL); /////////////////////////////////////////////////////////////////////////
								goto proceed;
							 }		*/								 
			} else {
				///////////////////////////////////////////
				// Check if Text is in Group from UsrInput
				$tmpdirectidsecondary	= $this->getTextIdDirectCat($TEXT);
				if ($tmpdirectidsecondary != NULL) {	
					// Direct Reply 
						$tmpprocessvar	=	$this->getFromTextGroupId($tmpdirectidsecondary, 1);
						 if ( $tmpprocessvar  != NULL AND $tmpprocessvar != "" ) {
							$output = $tmpprocessvar;
							goto proceed; }							 
						 
					// Direct Command 
						$tmpprocessvar	=	$this->getFromTextGroupId($tmpdirectidsecondary, 2);
						 if ( $tmpprocessvar  != NULL AND $tmpprocessvar != "" ) {
							$output = $this->command_execute_result($tmpprocessvar); 
							goto proceed;
						 }								
					// Direct From Categorie
						$tmpprocessvar	=	$this->getFromTextGroupId($tmpdirectidsecondary, 3);
						 if ( $tmpprocessvar  != NULL AND $tmpprocessvar != "" ) {
							$output = $this->fetchOneFromCatItemIDSec($tmpprocessvar, 4);
							goto proceed; }							
							
							// Start a Workflow				
								/*$tmpprocessvar	=	getFromTextQuestionId($tmpdirectid, $MYSQL, "toworkflow");
								 if ( $tmpprocessvar  != NULL AND $tmpprocessvar != "" ) {
									$output = getWorkflowFromId($tmpprocessvar, $MYSQL); /////////////////////////////////////////////////////////////////////////
									goto proceed;
								 }		*/	
								 
							// Start a Workflow	from Step			
								/*$tmpprocessvar	=	getFromTextQuestionId($tmpdirectid, $MYSQL, "toworkflow");
								 if ( $tmpprocessvar  != NULL AND $tmpprocessvar != "" ) {
									$output = getWorkflowFromId($tmpprocessvar, $MYSQL); /////////////////////////////////////////////////////////////////////////
									goto proceed;
								 }		*/									 
				}
			}
		} else {
				//We are In a Workflow ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//We are In a Workflow ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//We are In a Workflow ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//We are In a Workflow ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//We are In a Workflow ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		} proceed:
		if($output == NULL || trim($output) == "") {	
			$output	= $this->fetchOneFromCatItem($this->conf_group_error);
			if($output != NULL AND trim($output) != "") { return $output; } else { return $this->conf_string_error; }		
		} else {return $output;}					
	}
	
	#######################
	##### Fetch Multiple Items From Cat from ID
	#######################	
	 function getTextIdDirectCat($TEXT) {
		$query = "SELECT ".$this->table_group.".id FROM `".$this->table_group."` INNER JOIN ".$this->table_group_text." ON ".$this->table_group.".id = ".$this->table_group_text.".group
	 WHERE ".$this->table_group_text.".text = \"".mysqli_real_escape_string($MYSQL, $TEXT)."\" AND sector = 'usrinput'";
		$result = mysqli_query($MYSQL, $query);
		
		$textitems	=	array();
		$relitems	=	array();
		
		while ($sresult = mysqli_fetch_array($result, MYSQLI_BOTH)) {
			@array_push($textitems, $sresult["id"]);
			@array_push($relitems, $sresult["relation"]);
		}		
		
		if (count($textitems) == 0) {
			$_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = 0;
			return null;
		} elseif (count($textitems) == 1) {
			if(isANullValue($relitems[0])) { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = 0; }
			else { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = $relitems[0]; }
			return $textitems[0];
		} else {
			$randomcounter	=	mt_rand(0, count($textitems)-1);
			if(isANullValue($relitems[$randomcounter])) { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = 0; }
			else { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = $relitems[$randomcounter]; }
			return $textitems[$randomcounter];			
		}			
	}
	
	########################
	##### Get a Value from Text ID
	 function getFromTextGroupId($ID, $ITEM) {
		$query = "SELECT * FROM `".$this->table_group."` WHERE id = \"".$ID."\"";
		$result = mysqli_query($MYSQL, $query);
			while ($sresult = mysqli_fetch_array($result, MYSQLI_BOTH)) {			
					$_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = $sresult["relation"];
					return $sresult[$ITEM];
				}		

		return null;
	}				

	#######################
	##### Fetch Multiple Items From Cat from ID
	#######################	
	 function fetchOneFromCatItemIDSec($ID, $GROUP) {
		$query = "SELECT * FROM `".$this->table_group."` INNER JOIN ".$this->table_group_text." ON ".$this->table_group.".id = ".$this->table_group_text.".group
		WHERE ".$this->table_group.".id = \"".$ID."\" AND ".$this->table_group.".sector = \"".str_replace('"', '\"', $GROUP)."\"";
		$result = mysqli_query($MYSQL, $query);
		
		$textitems	=	array();
		$relitems	=	array();
		
		while ($sresult = mysqli_fetch_array($result, MYSQLI_BOTH)) {
			array_push($textitems, $sresult["text"]);
			array_push($relitems, $sresult["relation"]);
		}		
		
		if (count($textitems) == 0) {
			$_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = 0;
			return null;
		} elseif (count($textitems) == 1) {
			if(isANullValue($relitems[0])) { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = 0; }
			else { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = $relitems[0]; }
			return $textitems[0];
		} else {
			$randomcounter	=	mt_rand(0, count($textitems)-1);
			if(isANullValue($relitems[$randomcounter])) { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = 0; }
			else { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = $relitems[$randomcounter]; }
			return $textitems[$randomcounter];			
		}			
	}



	#######################
	##### Fetch Multiple Items From Cat from ID
	#######################	
	 function fetchOneFromCatItemID($ID) {
		$query = "SELECT * FROM `".$this->table_group."` INNER JOIN ".$this->table_group_text." ON ".$this->table_group.".id = ".$this->table_group_text.".group
		WHERE ".$this->table_group.".id = \"".$ID."\"";
		$result = mysqli_query($MYSQL, $query);
		
		$textitems	=	array();
		$relitems	=	array();
		
		while ($sresult = mysqli_fetch_array($result, MYSQLI_BOTH)) {
			array_push($textitems, $sresult["text"]);
			array_push($relitems, $sresult["relation"]);
		}		
		
		if (count($textitems) == 0) {
			$_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = 0;
			return null;
		} elseif (count($textitems) == 1) {
			if(isANullValue($relitems[0])) { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = 0; }
			else { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = $relitems[0]; }
			return $textitems[0];
		} else {
			$randomcounter	=	mt_rand(0, count($textitems)-1);
			if(isANullValue($relitems[$randomcounter])) { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = 0; }
			else { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = $relitems[$randomcounter]; }
			return $textitems[$randomcounter];			
		}			
	}
	
	
	########################
	##### Get a Value from Text ID
	 function getFromTextQuestionId($ID, $ITEM) {
		$query = "SELECT * FROM `".$this->table_question."` WHERE id = \"".$ID."\"";
		$result = mysqli_query($MYSQL, $query);
			while ($sresult = mysqli_fetch_array($result, MYSQLI_BOTH)) {			
					$_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = $sresult["relation"];
					return $sresult[$ITEM];
				}		

		return null;
	}				
	
	########################
	##### Get Text From Questions DB if Exists otherwhise null
	 function getTextIdDirect($TEXT) {
		$query = "SELECT * FROM `".$this->table_question."` WHERE text = \"".str_replace('"', '\"', mysqli_real_escape_string($MYSQL, $TEXT))."\"";
		$result = mysqli_query($MYSQL, $query);
			while ($sresult = mysqli_fetch_array($result, MYSQLI_BOTH)) {			
					return $sresult["id"];}		

		return null;
	}			
	
	#######################
	##### Is Value Empty
	#######################	
	private function isANullValue($VAL) {if($VAL == NULL || $VAL == "") {return true; } else {return false; }		}			

	#######################
	##### Message As Robot
	#######################
	 function displayMessageBot($cat, $text) {
		 if (isANullValue($text)) {
			$tmpvar	=	"";
			$tmpvar	.=	"<div id='mgscontentfrombot'>";
				$tmpvar	.=	"<div class='floatpadding' id='mgsfrombotname'>";
					$tmpvar	.=	"<div>".$this->conf_bot_name."</div>";
					$tmpvar	.=	"<div>".getTime()."</div>";
				$tmpvar	.=	"</div>";
				$tmpvar	.=	"<div class='floatpadding'>";
					$tmpvar	.=	"<div>".getOutputCategorized($mysql, strtolower($cat))."</div>";
				$tmpvar	.=	"</div>";	
			$tmpvar	.=	"<br clear=\"left\">";				
			$tmpvar	.=	"</div>";
			$tmpvar	.=	"<br clear='left'>";				
			return $tmpvar;		 
		 } else {
			$tmpvar	=	"";
			$tmpvar	.=	"<div id='mgscontentfrombot'>";
				$tmpvar	.=	"<div class='floatpadding' id='mgsfrombotname'>";
					$tmpvar	.=	"<div>".$this->conf_bot_name."</div>";
					$tmpvar	.=	"<div>".getTime()."</div>";
				$tmpvar	.=	"</div>";
				$tmpvar	.=	"<div class='floatpadding'>";
					$tmpvar	.=	"<div>".getOutputProcessed($mysql, strtolower($text))."</div>"; 
				$tmpvar	.=	"</div>";	
			$tmpvar	.=	"<br clear=\"left\">";		
			$tmpvar	.=	"</div>";
			//$tmpvar	.=	"<br clear='left'>";				
			return $tmpvar;		 
		 }
	 }
	  
	#######################
	##### Fetch Multiple Items From Cat
	#######################	
	 function fetchOneFromCatItem($CAT) {
		$query = "SELECT * FROM `".$this->table_group."` INNER JOIN ".$this->table_group_text." ON ".$this->table_group_text.".group = ".$this->table_group.".id
		WHERE ".$this->table_group.".title = \"".htmlspecialchars($CAT)."\"";
		$result = mysqli_query($MYSQL, $query);
		
		$textitems	=	array();
		$relitems	=	array();
		
		while ($sresult = mysqli_fetch_array($result, MYSQLI_BOTH)) {
			array_push($textitems, $sresult["text"]);
			array_push($relitems, $sresult["relation"]);
		}		
		
		if (count($textitems) == 0) {
			$_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = 0;
			return null;
		} elseif (count($textitems) == 1) {
			if(isANullValue($relitems[0])) { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = 0; }
			else { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = $relitems[0]; }
			return $textitems[0];
		} else {
			$randomcounter	=	mt_rand(0, count($textitems)-1);
			if(isANullValue($relitems[$randomcounter])) { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = 0; }
			else { $_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_relationship"] = $relitems[$randomcounter]; }
			return $textitems[$randomcounter];			
		}			
	}	 
	 
	#######################
	##### Get Output Categorized
	#######################										
		function getOutputCategorized($CAT) {
			##### Get Error String
			$onerrorstring	=	$this->conf_string_error;
				##### Do A Cat Process
				if ($CAT != NULL) {
					$output	= $this->fetchOneFromCatItem($CAT, $MYSQL);
					if(isANullValue($output)) {
						$output	= $this->fetchOneFromCatItem($this->conf_group_error, $MYSQL);
						if(isANullValue($output)) { return $onerrorstring; } else { return $output;}
					} else { return $output; }
				}
			return $onerrorstring;
		}		 
	 
	#######################
	##### Message As User
	#######################
	 function displayMessageUser($text) {
		$tmpvar	=	"";
		$tmpvar	.=	"<div id='mgscontentfromuser'>";
			$tmpvar	.=	"<div class='floatpadding' id='mgsfromusername'>";
				$tmpvar	.=	"<div>".$this->conf_user_name."</div>";
				$tmpvar	.=	"<div>".getTime()."</div>";
			$tmpvar	.=	"</div>";
			$tmpvar	.=	"<div class='floatpadding'>";
				$tmpvar	.=	"<div>".htmlspecialchars($text)."</div>";
			$tmpvar	.=	"</div>";
		$tmpvar	.=	"<br clear=\"left\">";			
		$tmpvar	.=	"</div>";
		//$tmpvar	.=	"<br clear='left'>";	
		return $tmpvar;
	 }	


	 /*
	// Reset Text after Size  // Static Search after 10000 Chars
	if ( strlen($_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_text"]) > $this->conf_reset_after) {
		$_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_text"] = substr($_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_text"], 0, strpos($_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_text"], "<br clear='left'>", 10000));
	}
	 
 	//////////////////////////
	// Submit a Users Message	
	 if (@$_POST["chatsubmit"] AND $_POST["chatsubmittext"] != "" AND strpos($_POST["chatsubmittext"], '<br clear=\'left\'>') === false) {
		$current_text				=	@$_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_text"];
		$current_text = displayMessageUser($_POST["chatsubmittext"]).$current_text;
		$current_text = displayMessageBot($mysql->mysqlcon, null, htmlspecialchars($_POST["chatsubmittext"])).$current_text;
		$_SESSION[_BTM_MAIN_COOKIEPRE_."chat_current_text"] = $current_text;
		Header("Location: #");
		exit();
	 }
*/
	 
	 
	}
?>