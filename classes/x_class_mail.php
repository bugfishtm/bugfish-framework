<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  PHPMailer Extension Control Class */	
	use PHPMailer\PHPMailer\PHPMailer;
	class x_class_mail {
		public 	$debugmessage   = false;
		
		private $cursection   	= "global";  
		private $mysqlcon  		= false; // MySQL for Logging
		private $mysqltable		= false; // Table for Logging
		private $mysqllogmode	= 1;     // Mode for Logging
			public function logDisable() { $this->mysqlcon = false; $this->mysqltable = false; $this->mysqllogmode = false; $this->cursection = ""; }
			public function logEnable($connection, $table, $mode = 1, $section = "") { $this->mysqlcon = $connection; $this->mysqltable = $table; $this->mysqllogmode = $mode; $this->cursection = $section; }
			
		private $Host     		= false;	 // The host example : server.domain
		private $SMTPAuth 		= false;	 // Needs Auth?
		private $Username 		= "";        // The Username for Auth
		private $Password		= "";        // The Password for Auth	
		private $Port    		= 25;        // The Port of Server example: 25		
		private $SMTPSecure 	= false;	 // Is Secure Connection
		
		private $AllowInsecureConnection = false; public function allow_insecure_ssl_connections($bool) {$this->AllowInsecureConnection = $bool;} 
		private $defaulthtml 	= false;	public function all_default_html($bool) {$this->defaulthtml = $bool;} 
		private $defheader 		= false; 	private $deffooter = false; public function change_default_template($header, $footer) {$this->defheader = $header;$this->deffooter = $footer;} 
		private $DebugLevel 	= 0;	 	public function debugLevel($int) {$this->DebugLevel = $int;} # 0  - lowest | 3 - highest
		private $CharSet 		= "UTF-8";  public function CharSet($charset) {$this->CharSet = $charset;} 
		private $Encoding 		= 'base64'; public function Encoding($encode) {$this->Encoding = $encode;}
		private $setFromName 	= false; 	private $setFromMail 	= false; public function initFrom($mail, $name) {$this->setFromMail = $mail;$this->setFromName = $name;}
		private $addReplyToName = false; 	private $addReplyToMail = false; public function initReplyTo($mail, $name) {$this->addReplyToMail = $mail;$this->addReplyToName = $name;}
		private $test_mode   	= false; 	public function enableTestMode($val) { $this->test_mode = $val; } 
		private $keep_alive   	= false; 	public function keep_alive($bool = false) { $this->keep_alive = $bool; } 
		
		// Construct the Mail Class
		function __construct($host, $port = 25, $auth_type = false, $user = false, $pass = false) {
			$this->Host 		 = $host; // The host example : server.domain
			if($auth_type == "ssl" OR $auth_type == "tls") { $this->SMTPAuth 	 = true; } else { $this->SMTPAuth 	 = false; } 
			$this->Username 	 = $user; // The Username for Auth
			$this->Password 	 = $pass; // The Password fot Auth
			$this->SMTPSecure 	 = $auth_type; // "tls" or "ssl"
			$this->Port 		 = $port; } // The Port of Server example: 25
			
		// Log Mails if Activated
		private function logMail($mailcontent, $subject, $to, $success, $debugerror) {
			if(is_array($to)) { $to = serialize($to); }
			if(is_string($this->mysqltable)) {if(($success == 1 AND ($this->mysqllogmode == 3 OR $this->mysqllogmode == 1)) OR ($success == 0 AND ($this->mysqllogmode == 2 OR $this->mysqllogmode == 1))) {
		$stmt = $this->mysqlcon->prepare("INSERT INTO ".$this->mysqltable."(receiver, subject, msgtext, success, debugmsg, section) VALUES('".mysqli_real_escape_string($this->mysqlcon, $to)."', '".mysqli_real_escape_string($this->mysqlcon, $subject)."', ?, '".$success."', '".mysqli_real_escape_string($this->mysqlcon, $debugerror)."', '".$this->cursection."');"); $stmt->bind_param('s', $mailcontent);$stmt->execute();}}}
		
		// Send Mail with SMTP
		public function send($to, $toname, $title, $mailContent, $ishtml = false, $FOOTER = false, $HEADER = false, $attachments = false) {
			// Create Object PHPMailer
			$tmp_mailer = new PHPMailer;
			
			// Buildup Connection
			$tmp_mailer->isSMTP();
			$tmp_mailer->Host 		   = $this->Host;
			$tmp_mailer->SMTPAuth 	   = $this->SMTPAuth;
			$tmp_mailer->Username 	   = $this->Username;
			$tmp_mailer->Password 	   = $this->Password; 
			$tmp_mailer->SMTPSecure    = $this->SMTPSecure;
			$tmp_mailer->Port 		   = $this->Port;	
			$tmp_mailer->SMTPKeepAlive = $this->keep_alive;
			$tmp_mailer->SMTPDebug     = $this->DebugLevel;
			$tmp_mailer->CharSet 	   = $this->CharSet;
			$tmp_mailer->Encoding 	   = $this->Encoding;			
			
			// Activate Default HTML if needed
			if($this->defaulthtml AND !$ishtml) { $tmp_mailer->isHTML($this->defaulthtml); } else { $tmp_mailer->isHTML($ishtml); }
			
			// Activate Insecure Connections
			if($this->AllowInsecureConnection) {
				$tmp_mailer->SMTPOptions = [
				  'ssl' => [
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				  ]
				];
			}
			
			// Set From Variables
			$tmp_mailer->setFrom($this->setFromMail, $this->setFromName);
			
			// Set Reply To Variables
			$tmp_mailer->addReplyTo($this->addReplyToMail, $this->addReplyToName);
			
			// Adress to Send Test-Mode if Set otherwhise set Real Receivers Adr.
			if( is_string($this->test_mode) ) { 
				$tmp_mailer->addAddress($this->test_mode); 	
			} else {
				if(is_array($to)) { foreach ($to as &$value) {$tmp_mailer->addAddress($value["mail"], $value["name"]);}
				} else {$tmp_mailer->addAddress($to, $toname);}	
			}			

			// Add Attachments
			if(is_array($attachments)) { foreach ($attachments as &$value) {$tmp_mailer->addAttachment($value);}
			} else { if(is_string($attachments)) { $tmp_mailer->addAttachment($attachments); }}
			
			// Set the Title for Mail
			$tmp_mailer->Subject = $title;			
			
			// Prepare Content with Footer and Header
			$xFOOTER = "";
			$xHEADER = "";
			if(!$FOOTER AND !empty($this->deffooter)) {$xFOOTER = $this->deffooter;}
			if(!$HEADER AND !empty($this->defheader)) {$xHEADER = $this->defheader;}
			if(!empty($FOOTER)) { $xFOOTER = $this->deffooter; }
			if(!empty($HEADER)) { $xHEADER = $this->defheader; }
			$realcontent = $xHEADER.$mailContent.$xFOOTER;
			$tmp_mailer->Body = $realcontent;			

			// Send the Mail
			if($tmp_mailer->send()){
				$this->logMail($realcontent, $title, $to, 1, $tmp_mailer->ErrorInfo);
				$debugmessage = $tmp_mailer->ErrorInfo;
				unset($tmp_mailer);
				return true;
			}else{
				$this->logMail($realcontent, $title, $to, 0, $tmp_mailer->ErrorInfo);
				$debugmessage = $tmp_mailer->ErrorInfo;
				unset($tmp_mailer);
				return false;}				
		}
	}
?>