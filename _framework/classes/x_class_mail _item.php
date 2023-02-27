<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/  x_class_mail_item Control Class */	
	// Object for Sending Mails to Locations, x_class_mail needed
	class x_class_mail_item {
		// Class Variables
		private $x_class_mail = false;
		// Construct		
		function __construct($x_class_mail) {$this->x_class_mail = $x_class_mail;} 
		// Functions for Send Adjustments
		private $attachment = array();
		public function add_attachment($path, $name) { array_push($this->attachment, array($path,$name)); }
		public function get_attachment() { return $this->attachment; }	
		public function clear_attachment() { $this->attachment = array(); }
		private $receiver = array();
		public function add_receiver($mail, $name) { array_push($this->receiver, array($mail,$name)); }
		public function get_receiver() { return $this->receiver; }	
		public function clear_receiver() { $this->receiver = array(); }
		private $cc = array();
		public function add_cc($mail, $name) { array_push($this->cc, array($mail,$name)); }
		public function get_cc() { return $this->cc; }
		public function clear_cc() { $this->cc = array(); }
		private $bcc = array();
		public function add_bcc($mail, $name) { array_push($this->bcc, array($mail,$name)); }	
		public function get_bcc() { return $this->bcc; }		
		public function clear_bcc() { $this->bcc = array(); }
		private $settings = array();
		public function add_setting($name, $value) { $this->settings[$name] = $value; }	
		public function get_setting() { return $this->settings; }
		public function clear_setting() { $this->settings = array(); }		
		######################################################################################################################################
		// Send Final Mail
		public function send($subject, $content) {
			return $this->x_class_mail->mail($subject, $content, $this->receiver, $this->cc, $this->bcc, $this->attachment, $this->settings);
		}
	}
?>