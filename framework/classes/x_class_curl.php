<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  Curl Control Class */	
	class x_class_curl {
		######################################################
		// Class Variables
		######################################################
		public $last_info = false;
		
		######################################################
		// Class Configuration
		######################################################
		private $username = false; private $password = false; public function set_auth($username, $password) {$this->username = $username; $this->password = $password;}
		private $curldomain	=	false; public function set_curldomain($path) { $this->curldomain = $path;}
		private $proxy_prot = false;private $proxy_port = false;private $proxy_ip = false;private $proxy_pass = false;
			public function set_proxy($proxy_ip, $proxy_port, $proxy_pass = false, $proxy_prot = 'HTTP') {$this->proxy_ip = $proxy_ip; $this->proxy_port = $proxy_port;$this->proxy_pass = $proxy_pass; $this->proxy_prot = $proxy_prot;}
		private $cert_verifypeer = false;private $cert_pemfile = false;private $cert_pass = false;
			public function set_cert($cert_verifypeer, $cert_pemfile, $cert_pass = false) {$this->cert_verifypeer = $cert_verifypeer; $this->cert_pemfile = $cert_pemfile;$this->cert_pass = $cert_pass; }
			
		######################################################
		// Conversions
		######################################################
		public function xml_to_array($xml) {
			$xml = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
			$json = json_encode($xml);
			$array = json_decode($json,TRUE);	
			return $array;
		}
		
		public function xml_to_json($xml) {
			$xml = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
			$json = json_encode($xml);
			return $json;
		}
		
		public function json_to_array($json) {
			$array = json_decode($json,TRUE);	
			return $array;			
		}
		
		public function json_to_xml($json) {
			$array = json_decode($json,TRUE);	
			$xml = new SimpleXMLElement('<root/>');
			array_walk_recursive($array, array ($xml, 'addChild'));
			return $xml->asXML();				
		}
		
		public function array_to_xml($array) {
			$xml = new SimpleXMLElement('<root/>');
			array_walk_recursive($array, array ($xml, 'addChild'));
			return $xml->asXML();			
		}
		
		public function array_to_json($array) {
			$json = json_encode($array);
			return $json;
		}
		
		
		######################################################
		// Request with Authentication
		######################################################
		public function auth_request($urlextension, $type, $header = false, $ext = false, $ovr_domain = false, $ovr_username = false, $ovr_password = false, $proxy = false, $cert = false) {
			$this->last_info = false;
			if($ovr_domain) { $finalurl = $ovr_domain.$urlextension; } else {  $finalurl= $this->curldomain.$urlextension; }
			if($ovr_username) { $finaluser = $ovr_username.$urlextension; } else {  $finaluser= $this->username; }
			if($ovr_password) { $finalpass = $ovr_password.$urlextension; } else {  $finalpass= $this->password; }
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_USERPWD, "$finaluser:$finalpass");			

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $finalurl);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
			//curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			
			if($proxy) {
				curl_setopt($ch, CURLOPT_PROXY, $this->proxy_ip);
				curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxy_port);
				curl_setopt($ch, CURLOPT_PROXYTYPE, $this->proxy_prot);
				if($this->proxy_pass) { curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_pass); }				
			}			
			
			if($cert) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->cert_verifypeer);
				curl_setopt($ch, CURLOPT_SSLCERT, $this->cert_pemfile);
				if($this->cert_pass) { curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $this->cert_pass = $cert_pass;); }
			}
				
			$output = curl_exec($ch); 
			$this->last_info = fcurl_getinfo($ch);
			curl_close($ch);	
			return $output;
		}
		
		######################################################
		// Upload a single file
		######################################################
		public function upload($filename) {
			curl_setopt($curl_handle, CURLOPT_POST, 1);
			$args['file'] = new CurlFile('filename.png', 'image/png');
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $args);			
		}
		
		######################################################
		// Request without Authentication
		######################################################
		public function request($urlextension, $type, $header = false, $ext = false, $ovr_domain = false, $proxy = false, $cert = false) {
			$this->last_info = false;
			if($ovr_domain) { $finalurl = $ovr_domain.$urlextension; } else {  $finalurl= $this->curldomain.$urlextension; }

			$ch = curl_init();		

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $finalurl);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
			//curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			
			if($proxy) {
				curl_setopt($ch, CURLOPT_PROXY, $this->proxy_ip);
				curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxy_port);
				curl_setopt($ch, CURLOPT_PROXYTYPE, $this->proxy_prot);
				if($this->proxy_pass) { curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_pass); }				
			}			
			
			if($cert) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->cert_verifypeer);
				curl_setopt($ch, CURLOPT_SSLCERT, $this->cert_pemfile);
				if($this->cert_pass) { curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $this->cert_pass = $cert_pass;); }
			}
				
			$output = curl_exec($ch); 
			$this->last_info = fcurl_getinfo($ch);
			curl_close($ch);	
			return $output;
		}
		
		######################################################
		// Download a File
		######################################################
		public function download($url, $localfile, $header = false, $ext = false, $proxy = false, $cert = false) {
			$this->last_info = false;
			set_time_limit(0);
			
			$fp = fopen ($localfile, 'w+');
			$ch = curl_init(str_replace(" ","%20",$url));
			
			curl_setopt($ch, CURLOPT_TIMEOUT, 600);
			curl_setopt($ch, CURLOPT_FILE, $fp); 
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			
			if($proxy) {
				curl_setopt($ch, CURLOPT_PROXY, $this->proxy_ip);
				curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxy_port);
				curl_setopt($ch, CURLOPT_PROXYTYPE, $this->proxy_prot);
				if($this->proxy_pass) { curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_pass); }				
			}
			
			if($cert) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->cert_verifypeer);
				curl_setopt($ch, CURLOPT_SSLCERT, $this->cert_pemfile);
				if($this->cert_pass) { curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $this->cert_pass = $cert_pass;); }
			}
			
			$output = curl_exec($ch); 
			$this->last_info = fcurl_getinfo($ch);
			curl_close($ch);
			fclose($fp);
			return $output;
		}
	}
?>