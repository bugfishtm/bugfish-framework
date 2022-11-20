<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  SessionSecurity */	
				
	class x_class_sessionblocking {
		private $key = false;
		private $maxcount = false;
		
		function __construct($key, $maxcount) {
			if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
			$this->key = $key."x_sessionblocking";
			$this->maxcount = $maxcount;
		}
		
		function blocked()  { if(!is_numeric(@$_SESSION[$this->key])) { $_SESSION[$this->key] = 0; } if($_SESSION[$this->key] >= $this->maxcount) { return true; } return false; }
		function increase() { if(!is_numeric(@$_SESSION[$this->key])) { $_SESSION[$this->key] = 0; } @$_SESSION[$this->key] = @$_SESSION[$this->key] + 1;	}
		function decrease() { if(!is_numeric(@$_SESSION[$this->key])) { $_SESSION[$this->key] = 0; } if(@$_SESSION[$this->key] != 0) {@$_SESSION[$this->key] = $_SESSION[$this->key] + 1;}	}
		function reset()    { if(!is_numeric(@$_SESSION[$this->key])) { $_SESSION[$this->key] = 0; } if(@$_SESSION[$this->key] != 0) {@$_SESSION[$this->key] = 0;}	}
	}
?>