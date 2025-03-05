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
