<?php
	/* 
		 ____  __  __  ___  ____  ____  ___  _   _ 
		(  _ \(  )(  )/ __)( ___)(_  _)/ __)( )_( )
		 ) _ < )(__)(( (_-. )__)  _)(_ \__ \ ) _ ( 
		(____/(______)\___/(__)  (____)(___/(_) (_) www.bugfish.eu
			  ___                                         _     
			 / __)                                       | |    
			| |__ ____ ____ ____   ____ _ _ _  ___   ____| |  _ 
			|  __) ___) _  |    \ / _  ) | | |/ _ \ / ___) | / )
			| | | |  ( ( | | | | ( (/ /| | | | |_| | |   | |< ( 
			|_| |_|   \_||_|_|_|_|\____)\____|\___/|_|   |_| \_)
		Copyright (C) 2024 Jan Maurice Dahlmanns [Bugfish]

		This program is free software: you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation, either version 3 of the License, or
		(at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program.  If not, see <https://www.gnu.org/licenses/>.
	*/
	class x_class_redis {
		private $redis  	= false; 		
		private $pre  	= false; 		
		
		function __construct($host, $port, $pre = "") { $redis = new Redis(); try { if($redis->connect($host, $port)) { $this->redis = $redis; } else { $this->redis = false; error_log("Redis could not connect with x_class_redis!"); } } catch (\Exception $e) {  $this->redis = false; error_log("Redis could not connect with x_class_redis!");} $this->pre = $pre; }
		
		public function valid() { if ($this->redis) { return true; } else { return false; }  }
		
		public function redis() { if ($this->redis) { return $this->redis; } else { return false; }  }
		public function ping() { if ($this->redis) { return $this->redis->ping(); } else { return false; } }
		public function keys($pre = false, $after = "") { if($pre === false) {$pre = $this->pre;}if ($this->redis) { return $this->redis->keys(@$pre."*".$after); } else { return false; } }
		
		public function add_string($name, $value) { 
			if ($this->redis) {
				if(is_string($value) AND is_string($name)) {
					return $this->redis->set($this->pre.$name, $value); 
				} return false;
			} return false;
		}
		public function add_list($name, $value) { 
			if ($this->redis) {
				if(is_array($value) AND is_string($name)) {
					foreach($value AS $key =>$valuex) {
						$this->redis->lpush($this->pre.$name, $valuex); 
					}
				}
			} return false;
		}
		public function get_string($name) { 
			if ($this->redis) {
				if(is_string($name)) {
					return $this->redis->get($this->pre.$name); 
				} return false;
			} return false;
		}
		public function get_list($name, $start, $end) { 
			if ($this->redis) {
				if(is_string($name)) {
					 return $redis->lrange($this->pre.$name, $start , $end); 
				} return false;
			} return false;
		}
	}
