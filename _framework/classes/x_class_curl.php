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
		public function auth_request($urlextension, $type, $body = false, $header = false, $ext = false) {
			$this->last_info = false;
			$finalurl= $this->curldomain.$urlextension;
			$finaluser= $this->username; 
			$finalpass= $this->password;
			
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_USERPWD, "$finaluser:$finalpass");			

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $finalurl);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
			if($header) { curl_setopt($ch, CURLOPT_HTTPHEADER, array($header)); }
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			
			if($this->proxy_prot) {
				curl_setopt($ch, CURLOPT_PROXY, $this->proxy_ip);
				curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxy_port);
				curl_setopt($ch, CURLOPT_PROXYTYPE, $this->proxy_prot);
				if($this->proxy_pass) { curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_pass); }				
			}			
			
			if($this->cert_verifypeer) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->cert_verifypeer);
				curl_setopt($ch, CURLOPT_SSLCERT, $this->cert_pemfile);
				if($this->cert_pass) { curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $this->cert_pass = $cert_pass); }
			}

			if($body) {
				//curl_setopt($ch, CURLOPT_POST,           1 );
				curl_setopt($ch, CURLOPT_POSTFIELDS,     $body ); 
			}
			
			$output = curl_exec($ch); 
			$this->last_info = curl_getinfo($ch);
			curl_close($ch);	
			return $output;
		}		
		
		######################################################
		// Request without Authentication
		######################################################
		public function request($urlextension, $type, $body = false, $header = false, $ext = false) {
			$this->last_info = false;
			$finalurl= $this->curldomain.$urlextension; 

			$ch = curl_init();		

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $finalurl);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
			if($header) { curl_setopt($ch, CURLOPT_HTTPHEADER, array($header)); }
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			
			if($this->proxy_prot) {
				curl_setopt($ch, CURLOPT_PROXY, $this->proxy_ip);
				curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxy_port);
				curl_setopt($ch, CURLOPT_PROXYTYPE, $this->proxy_prot);
				if($this->proxy_pass) { curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_pass); }				
			}			
			
			if($this->cert_verifypeer) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->cert_verifypeer);
				curl_setopt($ch, CURLOPT_SSLCERT, $this->cert_pemfile);
				if($this->cert_pass) { curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $this->cert_pass = $cert_pass); }
			}
			
			if($body) {
				//curl_setopt($ch, CURLOPT_POST,           1 );
				curl_setopt($ch, CURLOPT_POSTFIELDS,     $body ); 
			}
				
			$output = curl_exec($ch); 
			$this->last_info = curl_getinfo($ch);
			curl_close($ch);	
			return $output;
		}		
		
		######################################################
		// Download a File
		######################################################
		public function download($url, $localfile, $type = "GET", $header = false, $ext = false) {
			$this->last_info = false;
			set_time_limit(0);
			$finalurl= $this->curldomain.$url;
			$fp = fopen ($localfile, 'w+');
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
			curl_setopt($ch, CURLOPT_TIMEOUT, 600);
			curl_setopt($ch, CURLOPT_FILE, $fp); 
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_URL, $finalurl);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			
			if($header) { curl_setopt($ch, CURLOPT_HTTPHEADER, array($header)); }
			
			if($this->proxy_prot) {
				curl_setopt($ch, CURLOPT_PROXY, $this->proxy_ip);
				curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxy_port);
				curl_setopt($ch, CURLOPT_PROXYTYPE, $this->proxy_prot);
				if($this->proxy_pass) { curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_pass); }				
			}
			
			if($this->cert_verifypeer) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->cert_verifypeer);
				curl_setopt($ch, CURLOPT_SSLCERT, $this->cert_pemfile);
				if($this->cert_pass) { curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $this->cert_pass = $cert_pass); }
			}
			
			$output = curl_exec($ch); 
			$this->last_info = curl_getinfo($ch);
			curl_close($ch);
			fclose($fp);
			return $output;
		}
		
		######################################################
		// Download a File with Auth
		######################################################
		public function auth_download($url, $localfile, $type = "GET", $header = false, $ext = false) {
			$this->last_info = false;
			set_time_limit(0);
			$finalurl= $this->curldomain.$url;
			$fp = fopen ($localfile, 'w+');
			$ch = curl_init();
			$finaluser= $this->username; 
			$finalpass= $this->password;
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_USERPWD, "$finaluser:$finalpass");		

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
			curl_setopt($ch, CURLOPT_TIMEOUT, 600);
			curl_setopt($ch, CURLOPT_FILE, $fp); 
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_URL, $finalurl);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			
			if($header) { curl_setopt($ch, CURLOPT_HTTPHEADER, array($header)); }
			
			if($this->proxy_prot) {
				curl_setopt($ch, CURLOPT_PROXY, $this->proxy_ip);
				curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxy_port);
				curl_setopt($ch, CURLOPT_PROXYTYPE, $this->proxy_prot);
				if($this->proxy_pass) { curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_pass); }				
			}
			
			if($this->cert_verifypeer) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->cert_verifypeer);
				curl_setopt($ch, CURLOPT_SSLCERT, $this->cert_pemfile);
				if($this->cert_pass) { curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $this->cert_pass = $cert_pass); }
			}
			
			$output = curl_exec($ch); 
			$this->last_info = curl_getinfo($ch);
			curl_close($ch);
			fclose($fp);
			return $output;
		}		
		
		######################################################
		// Upload without Authentication
		######################################################
		public function upload($url, $filepath, $type = "POST", $header = false, $ext = false) {
			$this->last_info = false;
			$finalurl= $this->curldomain.$url;
			$ch = curl_init();

			//curl_setopt($ch, CURLOPT_POST, 1);
			$args['file'] = new CurlFile($filepath, mime_content_type($filepath));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $finalurl);
			if($header) { curl_setopt($ch, CURLOPT_HTTPHEADER, array($header)); }
			curl_setopt($ch, CURLOPT_TIMEOUT, 600);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
			
			if($this->proxy_prot) {
				curl_setopt($ch, CURLOPT_PROXY, $this->proxy_ip);
				curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxy_port);
				curl_setopt($ch, CURLOPT_PROXYTYPE, $this->proxy_prot);
				if($this->proxy_pass) { curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_pass); }				
			}			
			
			if($this->cert_verifypeer) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->cert_verifypeer);
				curl_setopt($ch, CURLOPT_SSLCERT, $this->cert_pemfile);
				if($this->cert_pass) { curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $this->cert_pass = $cert_pass); }
			}
			
			$output = curl_exec($ch); 
			$this->last_info = curl_getinfo($ch);
			curl_close($ch);	
			return $output;
		}		
		
		######################################################
		// Upload with Authentication
		######################################################
		public function auth_upload($url, $filepath, $type = "POST", $header = false, $ext = false) {
			$this->last_info = false;
			$finalurl= $this->curldomain.$url;
			$ch = curl_init();
			$finaluser= $this->username; 
			$finalpass= $this->password;			
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_USERPWD, "$finaluser:$finalpass");			
			
			//curl_setopt($ch, CURLOPT_POST, 1);
			$args['file'] = new CurlFile($filepath, mime_content_type($filepath));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $args);			
			
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $finalurl);
			if($header) { curl_setopt($ch, CURLOPT_HTTPHEADER, array($header)); }
			curl_setopt($ch, CURLOPT_TIMEOUT, 600);
			
			if($this->proxy_prot) {
				curl_setopt($ch, CURLOPT_PROXY, $this->proxy_ip);
				curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxy_port);
				curl_setopt($ch, CURLOPT_PROXYTYPE, $this->proxy_prot);
				if($this->proxy_pass) { curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_pass); }				
			}			
			
			if($this->cert_verifypeer) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->cert_verifypeer);
				curl_setopt($ch, CURLOPT_SSLCERT, $this->cert_pemfile);
				if($this->cert_pass) { curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $this->cert_pass = $cert_pass); }
			}
			
			$output = curl_exec($ch); 
			$this->last_info = curl_getinfo($ch);
			curl_close($ch);	
			return $output;
		}		
		
		######################################################
		// Upload Chunk with Authentication
		######################################################		
		public function upload_chunk($url, $filepath, $type = "POST", $header = false, $ext = false) {
			$this->last_info = false;
			$finalurl= $this->curldomain.$url;
			$ch = curl_init();
			$finaluser= $this->username; 
			$finalpass= $this->password;	
			
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_USERPWD, "$finaluser:$finalpass");			
			
			//curl_setopt($ch, CURLOPT_POSTFIELDS, $args);			
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $finalurl);
			if($header) { curl_setopt($ch, CURLOPT_HTTPHEADER, array($header)); }
			curl_setopt($ch, CURLOPT_TIMEOUT, 600);
		
			if($this->proxy_prot) {
				curl_setopt($ch, CURLOPT_PROXY, $this->proxy_ip);
				curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxy_port);
				curl_setopt($ch, CURLOPT_PROXYTYPE, $this->proxy_prot);
				if($this->proxy_pass) { curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_pass); }				
			}			
			
			if($this->cert_verifypeer) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->cert_verifypeer);
				curl_setopt($ch, CURLOPT_SSLCERT, $this->cert_pemfile);
				if($this->cert_pass) { curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $this->cert_pass = $cert_pass); }
			}
		
			$file = fopen($filepath, 'r');
			$filesize = filesize($filepath);
			$chunkSize = 1048576; // 1MB chunks
			$startByte = 0;
			$endByte = $chunkSize - 1;
			$chunks = ceil($filesize / $chunkSize);		
		
			while ($startByte < $filesize) {
				$headers = array(
					'Authorization: Basic '.base64_encode($username.':'.$password),
					'Content-Type: application/octet-stream',
					'Content-Length: '.($endByte - $startByte + 1),
					'Content-Range: bytes '.$startByte.'-'.$endByte.'/'.$filesize
				);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_PUT, true);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($ch, CURLOPT_INFILE, $file);
				curl_setopt($ch, CURLOPT_INFILESIZE, $endByte - $startByte + 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$output = curl_exec($ch);
				$startByte = $endByte + 1;
				$endByte = min($startByte + $chunkSize - 1, $filesize - 1);
			}
			
			// Finish
			fclose($file);
			$this->last_info = curl_getinfo($ch);
			curl_close($ch);	
			return $output;
		}
	}
?>